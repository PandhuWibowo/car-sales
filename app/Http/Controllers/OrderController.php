<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Str;
class OrderController extends Controller
{
    public function __construct(){
        $this->Order = new Order();
    }
    public function index () {
        $products = Product::all();
        $mvpToday = $this->Order->mostValueProductToday();
        $mvpOneWeek = $this->Order->mostValueProductPerSevenDays();
        $mvpYesterday = $this->Order->mvpYesterday($mvpToday->id);
        // dd($mvpYesterday);
        return view('orders.index', [
            'products' => $products,
            'mvpToday' => $mvpToday,
            'mvpOneWeek' => $mvpOneWeek,
            'mvpYesterday' => $mvpYesterday
        ]);
    }

    public function buy (Request $request) {
        try {
            $productExisting = Product::find($request->carId);
            if (empty($productExisting)) return response()->json([
                'status' => 400,
                'message' => 'Product not found'
            ], 400);

            if ($productExisting->stock <= 0) return response()->json([
                'status' => 400,
                'message' => 'The product has been out of stock'
            ], 400);

            $newOrder = new Order([
                'id' => Str::uuid(),
                'buyers_name' => $request->buyerName,
                'email' => $request->email,
                'phone' => $request->phone,
                'product_id' => $request->carId
            ]);

            if ($newOrder->save()) {
                $productExisting->stock = $productExisting->stock - 1;
                $productExisting->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'Order successfully saved'
                ], 200);
            }

            return response()->json([
                'status' => 400,
                'message' => 'Order totally failed to be ordered'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
