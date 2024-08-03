<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Cutting;
use App\Models\Material;
use App\Models\Sample;
use App\Models\Size;
use App\Models\Subtype;
use App\Models\Type;
use App\Models\Whome;
use App\Models\Stone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Type\Integer;

class TypeController extends Controller
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
        $valid = Validator::make($request->all(), [
            'title'=>['required', 'unique:types'],
        ]);
        if ($valid->fails()) {
            return response()->json($valid->errors(), 400);
        }

        $type = new Type();
        $type->title = $request->title;
        $type->save();
        if(!empty($request->subtypes)) {
            foreach($request->subtypes as $subtype) {
                if($subtype!=null) {
                    $s = new Subtype();
                    $s->type_id = $type->id;
                    $s->title = $subtype;
                    $s->save();
                }
            }
        }
        if (!empty($request->sizes)) {
            foreach ($request->sizes as $size) {
                if ($size!= null) {
                    $s = new Size();
                    $s->type_id = $type->id;
                    $s->number = doubleval($size);
                    $s->save();
                }
            }
        }

        return response()->json('Данные сохранены', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Type $type)
    {
        //
        $types = Type::with(['subtypes', 'sizes'])->get();
        // dd($types);
        return response()->json($types);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        //
        // dd($request->all());
        $valid = Validator::make($request->all(), [
            'title'=>['required', 'unique:types'],
        ]);
        if ($valid->fails()) {
            return response()->json($valid->errors(), 400);
        }
        $type = Type::query()->where('id', $request->id)->first();
        $type->title = $request->title;
        $type->update();
        return response()->json('Данные сохранены', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Type $type)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, $type)
    {
        //
        // dd($id, $type);
        switch($type) {
            case 'type': 
                Type::find($id)->delete();
                break;

            case 'stone': 
                Stone::find($id)->delete();
                break;

            case 'whome': 
                Whome::find($id)->delete();
                break;

            case 'cutting': 
                Cutting::find($id)->delete();
                break;
            
            case 'sample': 
                Sample::find($id)->delete();
                break;

            case 'material': 
                Material::find($id)->delete();
                break;

            case 'brand': 
                Brand::find($id)->delete();
                break;
        }

        return redirect()->back();
    }
}
