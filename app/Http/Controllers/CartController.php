<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductFilialSize;
use App\Models\User;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CartController extends Controller
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
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }

    //добавить продукт в корзину
    public function add_product_cart($id) {
        // dd($id);
        $product = Product::query()->where('id', $id)->first();
        // dd($product);
        $order = Order::query()->where('User_id', Auth::id())->where('status', 'Новый')->firstOrCreate(['user_id'=>Auth::id()], ['status'=>'Новый']);
        $cart = Cart::query()->where('order_id', $order->id)->where('product_id', $id)->firstOrCreate(['order_id'=>$order->id], ['product_id'=>$id]);
        if ($cart->count) {
            $cart->count += 1;
            $cart->price += $product->price;
            $order->sum += $cart->price;
            $cart->save();
            $order->save();
        } else {
            $cart->count = 1;
            $cart->price = $product->price * $cart->count;
            $order->sum += $cart->price;
            $order->update();
            $cart->update();
        }
        return redirect()->back()->with('success_add_cart', 'Товар добавлен в корзину');
    }

    //получить товары для корзины
    public function get_cart_products() {
        $order_user = Order::query()->where('user_id', Auth::id())->where('status', 'Новый')->first();
        $cart_products = Cart::query()->where('order_id', $order_user->id)->get();
        $products = [];
        foreach($cart_products as $product) {
            $p = Product::query()->where('id', $product->product_id)->first();
            // dd($p);
            $p_fil_size = ProductFilialSize::query()->where('product_id', $p->id)->get();
            $obj = [
                'id' => $p->id,
                'title' => $p->title,
                'images' => $p->images,
                'price' => $p->price, 
                'sum' => $p->price, 
                'cart_id' => $product->id,
                'count' => $product->count,
                'filials_sizes'=>$p_fil_size,
            ];
            array_push($products, $obj);
        }
        return response()->json($products);
    }

    //Удалить продукт из корзины
    public function deleteProductCart($id) {
        $order = Order::query()->where('user_id', Auth::id())->where('status',('Новый'))->first();
        $product = Cart::query()->where('product_id', $id)->where('order_id', $order->id)->first();
        $product->delete();
        return response()->json();
    }

}
