<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SizeController extends Controller
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
        // dd($request->all());
        $valid = Validator::make($request->all(), [
            'name'=>['required', 'unique:sizes,number'],
        ]);
        if ($valid->fails()) {
            return response()->json($valid->errors(), 400);
        }
        $s = new Size();
        $s->type_id = $request->id;
        $s->number = $request->name;
        $s->save();
        return response()->json('Размер добавлен', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Size $size)
    {
        //
        $sizes = Size::all();
        return response()->json($sizes);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Size $size)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Size $size)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Size $size)
    {
        //
    }

    public function edit_size(Request $request) {
        // dd($request->id);
        $valid = Validator::make($request->all(), [
            'number'=>['required', 'unique:sizes'],
        ]);
        if ($valid->fails()) {
            return response()->json($valid->errors(), 400);
        }
        $size = Size::query()->where('id', $request->id)->first();
        // dd($size);
        $size->number = $request->number;
        $size->update();
        return response()->json('Данные сохранены', 200);
    }

    //удаление размера
    public function del_size(Request $request) {
        $size = Size::query()->where('id', $request->id);
        $size->delete();
        return response()->json('Размер удален', 200);
    }
}
