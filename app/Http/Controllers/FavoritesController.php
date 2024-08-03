<?php

namespace App\Http\Controllers;

use App\Models\Favorites;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
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
    public function show(Favorites $favorites)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Favorites $favorites)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Favorites $favorites)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Favorites $favorites)
    {
        //
    }

    public function add_product_favorite($id) {
        $favUser = Favorites::query()->where('user_id', Auth::id())->where('product_id', $id)->first();
        if($favUser) {
            // dd($favUser);
            $favUser->delete();
            return redirect()->back();
        } else {
            $favorites = new Favorites();
            $favorites->user_id = Auth::id();
            $favorites->product_id = $id;
            // dd($favorites);
            $favorites->save();
            return redirect()->back();
        }
    }

    //получить все избранные пользователя
    public function getUserFavorites() {
        $user = Auth::user();
        if($user) {
            $favorites = Favorites::query()->where('user_id', Auth::id())->get();
        } else {
            $favorites = [];
        }
        
        // dd($favorites);
        return response()->json($favorites);
    }

    //удалить из избранного
    public function delete_product_favorite($id) {
        Favorites::find($id)->delete();
        return redirect()->back();
    }

    //получить все избранные пользователя с информацией о продукте
    public function get_user_favorites_products() {
        $favorites = Favorites::query()->where('user_id', Auth::id())->get();
        $favorites_product = [];
        foreach($favorites as $favorite) {
            $product = Product::query()->where('id', $favorite->product_id)->first();
            $obj = [
                'favorite_id'=>$favorite->id,
                'product_id'=>$product->id,
                'product_title'=>$product->title,
                'product_images'=>$product->images,
                'product_price'=>$product->price,
            ];
            array_push($favorites_product, $obj);
        }
        return response()->json($favorites_product);
    }
}
