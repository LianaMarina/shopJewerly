<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
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
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        //
    }

    //добавить отзыв
    public function addReview(Request $request) {
        // dd($request->all());
        $review = new Review();
        $review->positive = $request->positive;
        $review->negative = $request->negative;
        $review->text = $request->text;
        $review->product_id = $request->id;
        $review->user_id = Auth::id();
        $review->save();
        return response()->json('Отзыв добавлен');
    }

    //получить все отзывы для этого продукта
    public function getReviews($id) {
        $reviews = Review::query()->where('product_id', $id)->get();
        foreach($reviews as $review) {
            $user = User::query()->where('id', $review->user_id)->first();
            $review['user_name'] = $user->fio;
        }
        return response()->json($reviews);
    }

    //получить все отзывы этого продукта для авторизованного пользователя
    public function getReviewsUser($id) {
        $reviews = Review::query()->where('product_id', $id)->where('user_id', Auth::id())->get();
        return response()->json($reviews);
    }

    //удалить свой отзыв
    public function delete_my_review($id) {
        $review=Review::query()->where('id', $id)->first();
        $review->delete();
        return redirect()->back();
    }
}
