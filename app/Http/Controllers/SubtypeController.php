<?php

namespace App\Http\Controllers;

use App\Models\Subtype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubtypeController extends Controller
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
        $valid = Validator::make($request->all(), [
            'name'=>['required', 'unique:subtypes,title'],
        ]);
        if ($valid->fails()) {
            return response()->json($valid->errors(), 400);
        }
        $s = new Subtype();
        $s->type_id = $request->id;
        $s->title = $request->name;
        $s->save();
        return response()->json('Подтип добавлен', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Subtype $subtype)
    {
        //
        $subtypes = Subtype::all();
        return response()->json($subtypes);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subtype $subtype)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subtype $subtype)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subtype $subtype)
    {
        //
    }

    //изменение подтипа
    public function edit_subtype(Request $request) {
        $valid = Validator::make($request->all(), [
            'title'=>['required', 'unique:subtypes'],
        ]);
        if ($valid->fails()) {
            return response()->json($valid->errors(), 400);
        }
        $subtype = Subtype::query()->where('id', $request->id)->first();

        $subtype->title = $request->title;
        $subtype->update();

        return response()->json('Данные сохранены', 200);
    }

    //удаление подтипа
    public function delete_sub(Request $request) {
        $subtype = Subtype::query()->where('id', $request->id);
        $subtype->delete();
        return response()->json('Подтип удален', 200);
    }
}
