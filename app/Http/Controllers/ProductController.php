<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }

    public function getProductsFromApi()
    {
        $data=[];
        $hold = [];
        $woocommerce = woocommerce();
        $products = $woocommerce->get('products');
        foreach ($products as $key => $product) {
            foreach ($product as $key => $value) {
                if ( !is_array($value) ) {
                    if ($key != 'description' && $key != 'price_html') {
                        $hold[$key] = $value;
                    }
                }
                
            }
            array_push($data,$hold);
        }
        return response()->json(json_encode($data),200);
    }

    public function updateProductsFromApi()
    {
        $data=[];
        $hold = [];
        $woocommerce = woocommerce();
        $product_id = request()->product_id;
        $field[request()->field] = request()->value;
        $response = $woocommerce->put('products/'.$product_id, $field);
        foreach ($response as $key => $value) {
            if ( !is_array($value) ) {
                if ($key != 'description' && $key != 'price_html') {
                    $hold[$key] = $value;
                }
            }
            
        }
        array_push($data,$hold);
        return response()->json(json_encode($data),200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
