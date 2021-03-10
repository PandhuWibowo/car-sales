<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use DB;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = [
        'id', 'buyers_name', 'email', 'phone', 'product_id'
    ];

    public function mostValueProductToday() {
        return DB::table('products')
        ->leftJoin('orders','products.id', 'orders.product_id')
        ->whereDate('created_at', Carbon::today())
        ->groupBy('products.id')
        ->orderByDesc('total')
        ->select('products.*', DB::raw('COUNT(orders.product_id) AS total'))
        ->limit(1)
        ->first();
    }

    public function mostValueProductPerSevenDays() {
        return DB::table('products')
        ->leftJoin('orders','products.id', 'orders.product_id')
        ->where('created_at', '<=', Carbon::now())
        ->where('created_at', '>', Carbon::now()->subDays(7))
        ->groupBy('products.id')
        ->orderByDesc('total')
        ->select('products.*', DB::raw('COUNT(orders.product_id) AS total'))
        ->limit(1)
        ->first();
    }

    public function mvpYesterday($productId) {
        return DB::table('products')
        ->leftJoin('orders','products.id', 'orders.product_id')
        ->where('created_at', '<=', Carbon::now()->subDays(1))
        ->where('created_at', '>', Carbon::now()->subDays(2))
        ->where('orders.product_id', $productId)
        ->groupBy('products.id')
        ->orderByDesc('total')
        ->select('products.*', DB::raw('COUNT(orders.product_id) AS total'))
        ->limit(1)
        ->first();
    }

    public function post()
    {
        return $this->belongsTo(Product::class);
    }
}
