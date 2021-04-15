<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Automattic\WooCommerce\HttpClient\HttpClientException;
use Illuminate\Support\Facades\Log;

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
        try {
            $data = [];
            $hold = [];
            $wooCommerce = wooCommerce();

            $products = $wooCommerce->get('products', array('per_page' => 10, 'paged' => 1));
            $categories = $wooCommerce->get('products/categories');
            $attributes = $wooCommerce->get('products/attributes');
            $cat_final = [];
            foreach ($categories as $cat) {
                $cat_final[$cat->id] = $cat->name;
            }
            foreach ($products as $key => $product) {
                foreach ($product as $key => $value) {
                    if (!is_array($value)) {
                        if ($key != 'description' && $key != 'price_html' && $key != 'dimensions' && $key != '_links') {
                            $hold[$key] = $value;
                        }
                    } else {
                        if ($key == "categories") {
                            foreach ($value as $val) {
                                $hold[$key][$val->id] = $val->name;
                            }
                        }
                    }
                }
                array_push($data, $hold);
            }
            $headers = $data[0];
            $headers = array_keys($headers);
            foreach ($headers as $key => $value) {
                $valT = str_replace("_", " ", $value);
                $headers[$key] = strtoupper($valT);
            }
            $columns = [];
            foreach ($data[0] as $key => $val) {
                if (is_array($val)) {
                    $obj = new \stdClass();
                    $obj->editor = "select";
                    $obj->selectOptions = $cat_final;
                    $columns[] = $obj;
                } else {
                    $obj = new \stdClass();
                    $obj->type = "text";
                    $obj->data = $key;
                    $columns[] = $obj;
                }
            }
            return response()->json(array(
                "categories" => $cat_final,
                "attributes" => $attributes,
                "headers" => $headers,
                "columns" => $columns,
                "data" => $products
            ), 200);
        } catch (Exception $e) {
            return response()->json(json_encode($e->getMessage()), 500);
        }
    }

    public function updateProductsFromApi()
    {
        $data = [];
        $hold = [];
        $woocommerce = woocommerce();
        $product_id = request()->product_id;
        $field[request()->field] = request()->value;
        $response = $woocommerce->put('products/' . $product_id, $field);
        foreach ($response as $key => $value) {
            if (!is_array($value)) {
                if ($key != 'description' && $key != 'price_html') {
                    $hold[$key] = $value;
                }
            }
        }
        array_push($data, $hold);
        return response()->json(json_encode($data), 200);
    }
}
