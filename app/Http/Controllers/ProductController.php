<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index () {
        $products = Product::all();
        return view('products.index', ['products' => $products]);
    }

    public function store (Request $request) {
        try {
            $product = Product::create([
                'id' => Str::uuid(),
                'car_name' => $request->carName,
                'price' => $request->price,
                'stock' => $request->stock
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Product successfully saved'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update (Request $request, $id) {
        try {
            $product = Product::find($id);
            if (empty($product)) return response()->json([
                'status' => 400,
                'message' => 'Product not found'
            ], 400);

            $product->car_name = $request->carName;
            $product->price = $request->price;
            $product->stock = $request->stock;
            if ($product->save()) return response()->json([
                'status' => 200,
                'message' => 'Product successfully updated'
            ], 200);

            return response()->json([
                'status' => 400,
                'message' => 'Product totally failed to be updated'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function delete ($id) {
        try {
            $product = Product::find($id);
            if (empty($product)) return response()->json([
                'status' => 400,
                'message' => 'Product not found'
            ], 400);

            if ($product->delete()) return response()->json([
                'status' => 200,
                'message' => 'Product successfully deleted'
            ], 200);

            return response()->json([
                'status' => 400,
                'message' => 'Product totally failed to be deleted'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
