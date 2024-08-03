<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Cart;
use App\Models\Cutting;
use App\Models\Material;
use App\Models\Product;
use App\Models\Order;
use App\Models\ProductFilialSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Cast\Array_;
use PhpParser\Node\Expr\Cast\String_;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorites;
use App\Models\Sample;
use App\Models\Type;
use App\Models\Stone;
use App\Models\Subtype;
use App\Models\Whome;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
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
        $valid = Validator::make($request->all(), [
            'title' => ['required', 'unique:products'],
            'description' => ['required', 'unique:products'],
            'price' => ['required'],
            'material' => ['required'],
            'sample' => ['required'],
            'stone' => ['required'],
            'cutting' => ['required'],
            'whom' => ['required'],
            'type' => ['required'],
            'subtype' => ['required'],
            'brand' => ['required'],
        ]);
        // dd($request->all());
        $product = new Product();
        $product->title = $request->title;
        $product->description = $request->description;
        $file = '';
        foreach ($request->images as $img) {
            $file = $file . '/storage/' . $img->store('/public/img') . ';';
        }
        $product->images = $file;
        $product->price = $request->price;
        $product->material_id = $request->material;
        $product->sample_id = $request->sample;
        $product->stone_id = $request->stone;
        $product->cutting_id = $request->cutting;
        $product->whome_id = $request->whom;
        $product->type_id = $request->type;
        $product->subtype_id = $request->subtype;
        $product->brand_id = $request->brand;

        $product->save();
        foreach ($request->filials_size as $k => $filial) {
            // dd(count($filial));
            if (count($filial) === 3) {
                foreach ($filial['counts'] as $key => $count) {
                    // dd($count);
                    if (!$count) {
                        unset($filial['counts'][$key]); // unset удаляет элемент из массива
                        $filial['counts'] = array_values($filial['counts']); //array_values - восстанавливает ключи массива
                    }
                }
                if ($filial['sizes']) {
                    foreach ($filial['sizes'] as $key => $size) {
                        $product_size_filial = new ProductFilialSize();
                        // dd($product->id);
                        $product_size_filial->product_id = $product->id;
                        $product_size_filial->filial_id = $request->filials_size[$k][0];
                        $product_size_filial->size_id = $filial['sizes'][$key];
                        // dd($filial['counts']);
                        $product_size_filial->count = $filial['counts'][$key];
                        $product_size_filial->save();
                    }
                }
            }
            if (count($filial) === 2) {
                foreach ($filial['counts'] as $key => $count) {
                    // dd($count);
                    if (!$count) {
                        unset($filial['counts'][$key]); // unset удаляет элемент из массива
                        $filial['counts'] = array_values($filial['counts']); //array_values - восстанавливает ключи массива
                    }
                }
                if ($filial['counts']) {
                    foreach ($filial['counts'] as $key => $count) {
                        $product_size_filial = new ProductFilialSize();
                        // dd($product->id);
                        $product_size_filial->product_id = $product->id;
                        $product_size_filial->filial_id = $request->filials_size[$k][0];
                        // $product_size_filial->size_id = $filial['sizes'][$key];
                        // dd($filial['counts']);
                        $product_size_filial->count = $filial['counts'][$key];
                        $product_size_filial->save();
                    }
                }
            }

            // dd($product_size_filial);
        }


        return response()->json('Данные сохранены', 200);
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
    public function show(Product $product)
    {
        //
        $products = Product::with(['productfilialsizes'])->get();
        // dd($products);
        return response()->json($products);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    //удалени продукта
    public function destroy($id)
    {
        $filialSizeProduct = ProductFilialSize::query()->where('product_id', (int)$id)->get();
        foreach($filialSizeProduct as $product) {
            $product->delete();
        }
        // dd($id);
        Product::find($id)->delete();
        return redirect()->back();
    }

    public function filter(Request $request)
    {
        $products_all = session('products');
        // dd($products_all);
        if ($products_all) {
            if($request->type) {
                $products = Array();
                foreach($request->type as $type) {
                    foreach($products_all as $product) {
                        if($product->type_id == $type) {
                            array_push($products, $product);
                        }
                    }
                }
                $products_all = $products;
            } else {
                $products = $products_all;
            }
            if ($request->stone) {
                $products = Array(); //пустой массив, чтобы туда добавить продукты, прошедшие все фильтрации
                foreach($request->stone as $stone) {
                    foreach($products_all as $product) {
                        if($product->stone_id == $stone) {
                            array_push($products, $product);
                        }
                    }
                }
                $products_all = $products;
            } else {
                $products = $products_all;
            }
            if ($request->whome) {
                $products = Array(); //пустой массив, чтобы туда добавить продукты, прошедшие все фильтрации
                foreach($request->whome as $whome) {
                    foreach($products_all as $product) {
                        if($product->whome_id == $whome) {
                            array_push($products, $product);
                        }
                    }
                }
                $products_all = $products;
            } else {
                $products = $products_all;
            }
            if ($request->cutting) {
                $products = Array(); //пустой массив, чтобы туда добавить продукты, прошедшие все фильтрации
                foreach($request->cutting as $cutting) {
                    foreach($products_all as $product) {
                        if($product->cuting_id == $cutting) {
                            array_push($products, $product);
                        }
                    }
                }
                $products_all = $products;
            } else {
                $products = $products_all;
            }
            if ($request->sample) {
                $products = Array(); //пустой массив, чтобы туда добавить продукты, прошедшие все фильтрации
                foreach($request->sample as $sample) {
                    foreach($products_all as $product) {
                        if($product->sample_id == $sample) {
                            array_push($products, $product);
                        }
                    }
                }
                $products_all = $products;
            } else {
                $products = $products_all;
            }
            if ($request->material) {
                $products = Array(); //пустой массив, чтобы туда добавить продукты, прошедшие все фильтрации
                foreach($request->material as $material) {
                    foreach($products_all as $product) {
                        if($product->material_id == $material) {
                            array_push($products, $product);
                        }
                    }
                }
                $products_all = $products;
            } else {
                $products = $products_all;
            }
            if ($request->brand) {
                $products = Array(); //пустой массив, чтобы туда добавить продукты, прошедшие все фильтрации
                foreach($request->brand as $brand) {
                    foreach($products_all as $product) {
                        if($product->brand_id == $brand) {
                            array_push($products, $product);
                        }
                    }
                }
                $products_all = $products;
            } else {
                $products = $products_all;
            }
        } else {
            // dd('Здесь');
            $query = Product::with(['productfilialsizes'])->get();
            if ($request->type) {
                $products = Array();
                foreach ($query as $product) {
                    foreach($request->type as $type) {
                        if ($type == $product->type_id) {
                            array_push($products, $product);
                        }
                    }
                }
                $query = $products;
            } else {
                $products = $query;
            }
            if ($request->stone) {
                $query = $products;
                $products = Array();
                foreach ($query as $product) {
                    foreach($request->stone as $stone) {
                        if ($stone == $product->stone_id) {
                            array_push($products, $product);
                        }
                    }
                }
                $query = $products;
            } else {
                $products = $query;
            }
            if ($request->whome) {
                $query = $products;
                $products = Array();
                foreach ($query as $product) {
                    foreach($request->whome as $whome) {
                        if ($whome == $product->whome_id) {
                            array_push($products, $product);
                        }
                    }
                }
                $query = $products;
            } else {
                $products = $query;
            }
            if ($request->cutting) {
                $query = $products;
                $products = Array();
                foreach ($query as $product) {
                    foreach($request->cutting as $cutting) {
                        if ($cutting == $product->cutting_id) {
                            array_push($products, $product);
                        }
                    }
                }
                $query = $products;
            } else {
                $products = $query;
            }
            if ($request->sample) {
                $query = $products;
                $products = Array();
                foreach ($query as $product) {
                    foreach($request->sample as $sample) {
                        if ($sample == $product->sample_id) {
                            array_push($products, $product);
                        }
                    }
                }
                $query = $products;
            } else {
                $products = $query;
            }
            if ($request->material) {
                $query = $products;
                $products = Array();
                foreach ($query as $product) {
                    foreach($request->material as $material) {
                        if ($material == $product->material_id) {
                            array_push($products, $product);
                        }
                    }
                }
                $query = $products;
            } else {
                $products = $query;
            }
            if ($request->brand) {
                $query = $products;
                $products = Array();
                foreach ($query as $product) {
                    foreach($request->brand as $brand) {
                        if ($brand == $product->brand_id) {
                            array_push($products, $product);
                        }
                    }
                }
                $query = $products;
            } else {
                $products = $query;
            }
        }
        // dump($products);
        if (!$products) {
            session()->forget('products');
        } 
        // session(['products'=>$products]);
        return response()->json($products);
    }

    public function search(Request $request)
    {
        // dd($request->all());
        $words = explode(' ', $request->search);
        $query = Product::with(['productfilialsizes']);
        // dd($query);
        foreach ($words as $word) {
            $query = $query
                ->where('title', 'LIKE', "%{$word}%")
                ->orWhere('price', 'LIKE', "%{$word}%")
                ->orWhereRelation('material', 'title', 'LIKE', "%{$word}%")
                ->orWhereRelation('sample', 'title', 'LIKE', "%{$word}%")
                ->orWhereRelation('stone', 'title', 'LIKE', "%{$word}%")
                ->orWhereRelation('cutting', 'title', 'LIKE', "%{$word}%")
                ->orWhereRelation('whome', 'title', 'LIKE', "%{$word}%")
                ->orWhereRelation('type', 'title', 'LIKE', "%{$word}%")
                ->orWhereRelation('brand', 'title', 'LIKE', "%{$word}%");
        }
        $products = $query->get();
        // dd($products);
        session(['products' => $products]);
        // return response()->json(session(['products' => $products]));
        return response()->json($products);
    }

    //получить продукт для изменения
    public function get_product_for_update($id) {
        $product = Product::find($id);
        return response()->json($product);
    }

    //получить новые продукты
    public function getNewProducts() {
        $products = Product::query()->orderByDesc('created_at')->limit(4)->get();
        return response()->json($products);
    }

    //показать страницу подробнее о товаре
    public function get_more_details_product($id) {

        $product = Product::query()->where('id', $id)->first();
        $obj=[
            'product_id'=>$product->id,
            'product_title'=>$product->title,
            'images'=>$product->images,
            'price'=>$product->price,
            'product_description'=>$product->description,
            'product_price'=>$product->price,
            'type'=>$product->type->title,
            'material'=>$product->material->title,
            'sample'=>$product->sample->title,
            'stone'=>$product->stone->title,
            'cutting'=>$product->cutting->title,
            'whome'=>$product->whome->title,
            'brand'=>$product->brand->title,
            'filial_sizes'=>$product->productfilialsizes,
            'subtype'=>$product->subtype_id,
        ];
        $subtype = Subtype::query()->where('id', $product->subtype_id)->first();
        // dd($subtype->title);
        if($subtype) {
           $obj['subtype'] = $subtype->title;  
        }
        $isFavorite = Favorites::where('product_id', $id)
                            ->where('user_id', Auth::id())
                            ->exists();
        if($isFavorite) {
            $obj['isFavorite'] = true;
        }
        $order = Order::query()->where('user_id', Auth::id())->where('status', 'В обработке')->first();
        if($order) {
            $cart = Cart::query()->where('order_id', $order->id)->where('product_id', $id)->first();
            if($cart) {
                $obj['isOrder'] = true;
            }
        }
        return response()->json($obj);
    }

    //получить популярные продукты
    public function getPopularProducts() {
        $popularProducts = Product::select('products.*', DB::raw('COUNT(carts.id) as cart_count'))
        ->join('carts', 'products.id', '=', 'carts.product_id')
        ->groupBy('products.id')
        ->orderBy('cart_count', 'desc')->limit(4)
        ->get();
        return response()->json($popularProducts);
    }
}
