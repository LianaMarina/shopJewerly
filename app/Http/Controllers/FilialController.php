<?php

namespace App\Http\Controllers;

use App\Models\Filial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FilialController extends Controller
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
    public function create(Request $request)
    {
        //
        // dd($request->all());
        $valid = Validator::make($request->all(), [
            'title'=>['required', 'unique:filials'],
            'address'=>['required', 'unique:filials'],
        ]);
        if ($valid->fails()) {
            return response()->json($valid->errors(), 400);
        }

        $filial = new Filial();
        $filial->title = $request->title;
        $filial->address = $request->address;
        $filial->save();
        return response()->json('Филиал добавлен', 200);
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
    public function show(Filial $filial)
    {
        //

        $filials = Filial::all();
        return response()->json($filials);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        //
        $valid = Validator::make($request->all(), [
            'title'=>['required', Rule::unique('filials')->ignore($request->id)],
            'address'=>['required', Rule::unique('filials')->ignore($request->id)],
        ]);
        if ($valid->fails()) {
            return response()->json($valid->errors(), 400);
        }
        // dd($request->all());
        $valid = Validator::make($request->all(), [
            'title'=>['required'],
            'address'=>['required'],
        ]);
        if ($valid->fails()) {
            return response()->json($valid->errors(), 400);
        }
        $filial = Filial::query()->where('id', $request->id)->first();
        $filial->title = $request->title;
        $filial->address = $request->address;
        $filial->update();
        return response()->json('Изменения сохранены', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Filial $filial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // dd(Filial::find($id));
        Filial::find($id)->delete();
        return redirect()->back();


    }
}
