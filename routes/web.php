<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CuttingController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\FilialController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SampleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\StoneController;
use App\Http\Controllers\SubtypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\WhomeController;
use App\Models\Favorites;
use App\Models\Subtype;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('main_page/', 
    [PageController::class, 'welcome'])->name('welcome');

Route::group(['middleware'=>['admin', 'auth'], 'prefix'=>'admin'], function(){
    //маршруты для admin
    Route::get('categories',
        [PageController::class, 'show_characters'])->name('show_characters');

    Route::post('categories/types/save',
        [TypeController::class, 'store'])->name('typesSave');
    Route::post('categories/materials/save',
        [MaterialController::class, 'store'])->name('materialsSave');
    Route::post('categories/stones/save',
        [StoneController::class, 'store'])->name('stonesSave');
    Route::post('categories/whoms/save',
        [WhomeController::class, 'store'])->name('whomsSave');
    Route::post('categories/cuttings/save',
        [CuttingController::class, 'store'])->name('cuttingsSave');
    Route::post('categories/samples/save',
        [SampleController::class, 'store'])->name('samplesSave');
    Route::post('categories/brands/save',
        [BrandController::class, 'store'])->name('brandsSave');



    //Для изменения глобального типа одной из характеристик
    Route::post('/categories/edit_type',
        [TypeController::class, 'edit'])->name('editType');
    Route::post('/categories/edit_stone',
        [StoneController::class, 'edit'])->name('editStone');
    Route::post('/categories/edit_cutting',
        [CuttingController::class, 'edit'])->name('editCutting');
    Route::post('/categories/edit_sample',
        [SampleController::class, 'edit'])->name('editSample');
    Route::post('/categories/edit_whome',
        [WhomeController::class, 'edit'])->name('editWhome');
    Route::post('/categories/edit_material',
        [MaterialController::class, 'edit'])->name('editMaterial');
    Route::post('/categories/edit_brand',
        [BrandController::class, 'edit'])->name('editBrand');




    //создание филиала
    Route::post('/create_filial/',
        [FilialController::class, 'create'])->name('createFilial');
    //изменение филиала
    Route::post('/edit_filial/', 
        [FilialController::class, 'edit'])->name('editFilial');
    //Удаление филиала
    Route::get('filial_delete/{id?}',
        [FilialController::class, 'destroy'])->name('deleteFilial');

    //фильтрация товаров на странице админа
    Route::post('/filter/',
        [ProductController::class, 'filter'])->name('filter');
    
    // Route::post('/filter_brand/',
    //     [ProductController::class, 'filterBrand'])->name('filterBrand');

    
    //поиск на странице админа
    Route::post('/search/',
        [ProductController::class, 'search'])->name('search');

//открыть страницу для изменения товара
    Route::get('/show_edit_product_page/{id?}', 
        [PageController::class, 'show_edit_product'])->name('show_edit_product');
});

Route::get('show_registration/', 
    [PageController::class, 'show_registration'])->name('show_registration');

Route::post('registration/', 
    [UserController::class, 'registration'])->name('registration');

//отображение страницы с авторизацией
Route::get('show_auth/',
    [PageController::class, 'show_auth'])->name('login');

Route::post('auth/',
    [UserController::class, 'auth'])->name('auth');

//профиль администратора
Route::get('admin/show_profile/',
    [PageController::class, 'show_admin_profile'])->name('show_admin_profile');

//профиль пользователя
Route::get('user/show_profile/',
    [PageController::class, 'show_user_profile'])->name('show_user_profile');

//выход из аккаунта
Route::get('user/exit',
    [UserController::class, 'exit'])->name('exit');

//для показа характеристик украшений
Route::get('/categories/type/get',
    [TypeController::class, 'show'])->name('getTypes');
Route::get('/categories/stone/get',
    [StoneController::class, 'show'])->name('getStones');
Route::get('/categories/whom/get',
    [WhomeController::class, 'show'])->name('getWhomes');
Route::get('/categories/cutting/get',
    [CuttingController::class, 'show'])->name('getCuttings');
Route::get('/categories/sample/get',
    [SampleController::class, 'show'])->name('getSamples');
Route::get('/categories/material/get',
    [MaterialController::class, 'show'])->name('getMaterials');
Route::get('/categories/brand/get',
    [BrandController::class, 'show'])->name('getBrands');
Route::get('/categories/subtype/get',
    [SubtypeController::class, 'show'])->name('getSubtypes');
Route::get('/categories/size/get',
    [SizeController::class, 'show'])->name('getSizes');

// Route::post('admin/delete_type/',
//     [TypeController::class, 'delete_type'])->name('delete_type');

//изненение подтипа
Route::post('edit_subtype',
    [SubtypeController::class, 'edit_subtype'])->name('edit_subtype');

//изненение размера
Route::post('edit_size',
    [SizeController::class, 'edit_size'])->name('edit_size');

//удаление подтипа
Route::post('/del_subtype',
    [SubtypeController::class, 'delete_sub'])->name('delete_sub');

Route::post('/del_size',
    [SizeController::class, 'del_size'])->name('del_size');

//создание нового подтипа
Route::post('/categories/subtype/save',
    [SubtypeController::class, 'store'])->name('saveSubtype');

//создание нового размера
Route::post('/categories/size/save',
    [SizeController::class, 'store'])->name('saveSize');

//Удаление категории типа
Route::get('/categories/delete/{id?}/{type?}',
    [TypeController::class, 'destroy'])->name('deleteCharacters');




//показать страницу с филиалами
Route::get('/filials_show_page', 
    [PageController::class, 'show_filials'])->name('show_filials');

//получить филиалы
Route::get('show_filials', 
    [FilialController::class, 'show'])->name('getFilials');


//показать страницу с товарами
Route::get('show_products_page',
    [PageController::class, 'show_products_page'])->name('show_products_page');

//показать страницу для добавления товара
Route::get('show_add_product_page',
    [PageController::class, 'show_add_product_page'])->name('show_add_product_page');

//создать товар
Route::post('add_product', 
    [ProductController::class, 'create'])->name('addProduct');


//показать страницу со всеми товарами
Route::get('show_all_products_page', 
    [ProductController::class, 'show'])->name('getProducts');

//удаление продукта
Route::get('/products/delete/{id?}',
    [ProductController::class, 'destroy'])->name('deleteProduct');

//получить продукт для изменения
Route::get('/get_product_for_update/{id?}', [ProductController::class, 'get_product_for_update'])->name('get_product_for_update');


//показать страницу каталога
Route::get('/show_catalog_page/', [PageController::class, 'show_catalog_page'])->name('show_catalog_page');

//добавить продукт в корзину
Route::get('/user/add_product_cart/{id?}', [CartController::class, 'add_product_cart'])->name('add_product_cart');

//добавить продукт в избранное
Route::get('/user/add_fav_product/{id?}', [FavoritesController::class, 'add_product_favorite'])->name('add_product_favorite');

//удалить продукт в избранное
Route::get('/user/del_fav_product/{id?}', [FavoritesController::class, 'delete_product_favorite'])->name('delete_product_favorite');

//получить все избранные пользователя
Route::get('/user/get_user_favorites', [FavoritesController::class, 'getUserFavorites'])->name('getUserFavorites');

//получить новые товары
Route::get('/get_new_products/', [ProductController::class, 'getNewProducts'])->name('getNewProducts');

//показать страницу с товаром (подробнее)
Route::get('/show_more_details_product/{id?}', [PageController::class, 'show_more_details_product'])->name('show_more_details_product');

//получить данные о товаре
Route::get('/get_more_details_product/{id?}', [ProductController::class, 'get_more_details_product'])->name('get_more_details_product');

//добавить отзыв
Route::post('/user/addReview/', [ReviewController::class, 'addReview'])->name('addReview');

//получить все отзывы для данного продукта
Route::get('/user/getReviews/{id?}', [ReviewController::class, 'getReviews'])->name('getReviews');

//получить все отзывы для продукта этого пользователя
Route::get('user/get_my_reviews/{id?}', [ReviewController::class, 'getReviewsUser'])->name('getReviewsUser');

//удалить свой отзыв 
Route::get('user/deleteReview/{id?}', [ReviewController::class, 'delete_my_review'])->name('delete_my_review');


//КОРЗИНА
//показать страницу с корзиной пользователя
Route::get('/user/show_cart_page/', [PageController::class, 'show_cart_page'])->name('show_cart_page');

//получить продукты для корзины
Route::get('/user/get_cart_products', [CartController::class, 'get_cart_products'])->name('get_cart_products');

//удалить продукт из корзиины
Route::get('/user/delete_product_cart/{id?}', [CartController::class, 'deleteProductCart'])->name('deleteProductCart');

//оформить заказ
Route::post('/user/checkout/', [OrderController::class, 'checkout'])->name('checkout');


//ИЗБРАННОЕ
//открыть избранное пользователя
Route::get('/user/show_user_favorite/', [PageController::class, 'show_user_favorite'])->name('show_user_favorite');

//получить всю информацию о избранных продуктах
Route::get('/user/get_user_favorites_products/', [FavoritesController::class, 'get_user_favorites_products'])->name('get_user_favorites_products');


//СТРАНИЦА С ЗАКАЗАМИ
//переход на страницу с заказами пользователя
Route::get('/user/show_my_active_orders/', [PageController::class, 'show_my_active_orders'])->name('show_my_active_orders');

//получить все заказы пользователя для страницы "Мои заказы"
Route::get('/user/get_my_orders', [OrderController::class, 'getMyOrders'])->name('getMyOrders');

//получить список всех товаров из заказа
Route::get('/user/get_list_products_order/{id?}', [OrderController::class, 'getListProductsOrder'])->name('getListProductsOrder');

//отменить заказ
Route::get('/user/cancel_order/{id?}', [OrderController::class, 'cancel_order'])->name('cancel_order');

//показать историю заказов
Route::get('/user/my_history_orders', [PageController::class, 'show_my_history_orders'])->name('show_my_history_orders');

//получить заказы для истории заказов
Route::get('user/get_my_history', [OrderController::class, 'getMyHistoryOrder'])->name('getMyHistoryOrder');

//показать все заказы (админ)
Route::get('user/show_all_users_orders', [PageController::class, 'show_all_orders_page'])->name('show_all_orders_page');

//получить все заказы для админа
Route::get('/admin/get_all_orders', [OrderController::class, 'getAllOrders'])->name('getAllOrders');

//изменить статус заказа (админ)
Route::post('/admin/edit_status_order/', [OrderController::class, 'editOrderStatus'])->name('editOrderStatus');

//Получить пользователя для профиля пользователя
Route::get('user/get_user_inf', [UserController::class, 'getUserInf'])->name('getUserInf');

//изменить информацию о пользователе
Route::post('/user/edit_user_inf/', [UserController::class, 'editUserInf'])->name('editUserInf');

//удалить свой аккаунт
Route::get('/user/delete_user', [UserController::class, 'delete_my_accaunt'])->name('delete_my_accaunt');

//получать кол-во заказов
Route::get('/get_current_orders_count', [OrderController::class, 'getCurrentOrdersCount'])->name('getCurrentOrdersCount');

//получить популярные товары
Route::get('get_popular_products', [ProductController::class, 'getPopularProducts'])->name('getPopularProducts');