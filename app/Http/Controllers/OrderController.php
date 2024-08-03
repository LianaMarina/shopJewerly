<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductFilialSize;
use App\Models\Size;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    //оформить заказ
    public function checkout(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'filial' => ['required'],
        ]);
        if ($valid->fails()) {
            return response()->json($valid->errors(), 400);
        }
        $summ = 0;
        $order_user = Order::query()->where('user_id', Auth::id())->where('status', 'Новый')->first();
        $cart_products = Cart::query()->where('order_id', $order_user->id)->get();
        $sizes = Size::all();
        foreach ($cart_products as $key => $product) {
            $p = Product::query()->where('id', $product->product_id)->first();
            // $size_is = Size::query()->where('id', $request->size[$key]);
            // dd($sizes->where('id', $request->size[$key])->isNotEmpty());
            if ($sizes->where('id', $request->size[$key])->isNotEmpty()) {
                $pr_add_size = Cart::query()->where('id', $product->id)->where('order_id', $order_user->id)->first();
                // dd($pr_add_size);
                $pr_add_size->size_id = $request->size[$key];
                $pr_add_size->update();
                $p_fil_size = ProductFilialSize::query()->where('product_id', $p->id)->where('filial_id', $request->filial)
                    ->where('size_id', $request->size[$key])->first();
            } else {
                $p_fil_size = ProductFilialSize::query()->where('product_id', $p->id)->where('filial_id', $request->filial)
                    ->first();
            }
            // dd($request->all());
            // dd($p_fil_size);
            if (!$p_fil_size) {
                return response()->json('По данному адресу некоторые украшения отсутсвуют', 401);
            }
            // dd($p_fil_size->count >= (int)$request->count[$key]);
            if ($p_fil_size->count >= (int)$request->count[$key]) {
                $p_fil_size->count -= (int)$request->count[$key];
                $p_fil_size->update();
                $summ += $product->price * (int)$request->count[$key];
                $pr_add_count = Cart::query()->where('id', $product->id)->where('order_id', $order_user->id)->first();
                $pr_add_count->count = $request->count[$key];
                $pr_add_count->update();
            } else {
                return response()->json('По данному адресу некоторые украшения отсутсвуют', 401);
            }

            // dump($p_fil_size);
        }
        $order_user->status = 'В обработке';
        $order_user->sum = $summ;
        $order_user->filial_id = $request->filial;
        $order_user->update();
        return response()->json('Заказ успешно оформлен');
        // dd($request->all());
    }

    //получить все заказы пользователя для страницы "Мои заказы"
    public function getMyOrders()
    {
        $orders = Order::with(['filial'])->where('user_id', Auth::id())->whereIn('status', ['В обработке', 'Подтверждён'])->get();
        // dd($orders);
        return response()->json($orders);
    }

    //получить список товаров для пришедшего заказа
    public function getListProductsOrder($id)
    {
        $cart_products = Cart::with(['product'])->where('order_id', $id)->get();
        // dd($id);
        return response()->json($cart_products);
    }

    //отменить заказ
    public function cancel_order($id)
    {
        // dd($id);
        $order = Order::query()->where('id', $id)->first();
        $carts_products = Cart::query()->where('order_id', $order->id)->get();
        foreach ($carts_products as $cart_product) {
            if ($cart_product->size_id) {
                $filial_size = ProductFilialSize::query()->where('product_id', $cart_product->product_id)
                    ->where('filial_id', $order->filial_id)
                    ->where('size_id', $cart_product->size_id)->first();
            } else {
                $filial_size = ProductFilialSize::query()->where('product_id', $cart_product->product_id)
                    ->where('filial_id', $order->filial_id)->first();
            }
            $filial_size->count += $cart_product->count;
            $filial_size->update();
            // dd($filial_size);
        }
        $order->status = "Отменён";
        $order->update();
        return redirect()->back()->with('success', 'Заказ успешно отменён');
    }

    //получить историю заказов пользователя
    public function getMyHistoryOrder()
    {
        $historyOrders = Order::with(['filial'])->where('user_id', Auth::id())->where('status', 'Получён')->orWhere('status', 'Отменён')->get();
        return response()->json($historyOrders);
    }

    //получить все заказы для админа
    public function getAllOrders()
    {
        $orders = Order::with(['filial'])->with(['user'])->get();
        // dd($orders);
        return response()->json($orders);
    }

    //изменить статус заказа (админ)
    public function editOrderStatus(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'status' => 'required',
        ]);
        if ($valid->fails()) {
            return response()->json($valid->errors(), 400);
        }
        $order = Order::query()->where('id', $request->id)->first();
        if ($request->status == 'Отменён') {
            $order->comment = $request->comment;
            $carts_products = Cart::query()->where('order_id', $order->id)->get();
            foreach ($carts_products as $cart_product) {
                if ($cart_product->size_id) {
                    $filial_size = ProductFilialSize::query()->where('product_id', $cart_product->product_id)
                        ->where('filial_id', $order->filial_id)
                        ->where('size_id', $cart_product->size_id)->first();
                } else {
                    $filial_size = ProductFilialSize::query()->where('product_id', $cart_product->product_id)
                        ->where('filial_id', $order->filial_id)->first();
                }
                $filial_size->count += $cart_product->count;
                $filial_size->update();
                // dd($filial_size);
            }
        }
        if ($request->status == 'Подтверждён') {
            $order->date_start = $request->date_start;
            $order->date_end = $request->date_end;
        }
        $order->status = $request->status;
        $order->update();
        return response()->json('Статус успешно изменен');
    }

    public function getCurrentOrdersCount() {
        $count = Order::all()->count();
        return $count;
    }
}
