<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Favorites;

class PageController extends Controller
{
    //
    public function welcome() {
        return view('welcome');
    }

    public function show_registration() {
        return view('guest.registration');
    }

    public function show_auth() {
        return view('guest.auth');
    }

    public function show_admin_profile() {
        return view('admin.profile');
    }

    public function show_user_profile() {
        return view('user.profile');
    }

    public function show_characters() {
        return view('admin.categories');
    }

    // показать страницу с филиалами
    public function show_filials() {
        return view('admin.filials');
    }

    //показать страницу с продуктами
    public function show_products_page() {
        $products = Product::all();
        return view('admin.products.products', ['products'=>$products]);
    }

    //показать страницу для добавления продукта
    public function show_add_product_page() {
        return view('admin.products.add');
    }

    //показать страницу для изменения товара
    public function show_edit_product($id) {
        // $product = Product::query()->where('id', $id)->first();
        // dd($id);
        return view('admin.products.edit', ['id'=>$id]);
    }

    //показать страницу каталога
    public function show_catalog_page() {
        return view('guest.catalog');
    }

    //показать страницу подробнее о товаре
    public function show_more_details_product($id) {
        return view('guest.productPage', ['id'=>$id]);
    }

    //показать страницу с корзиной пользователя
    public function show_cart_page() {
        return view('user.cart');
    }

    //показать страницу с избранным пользователя
    public function show_user_favorite() {
        return view('user.favorite');
    }

    //показать страницу с заказами пользователя
    public function show_my_active_orders() {
        return view('user.myOrders');
    }

    //показать страницу с историей заказов
    public function show_my_history_orders() {
        // dd(Auth::id());
        return view('user.historyOrder');
    }

    //показать страницу со всеми заказами пользователей
    public function show_all_orders_page() {
        return view('admin.orders');
    }
}
