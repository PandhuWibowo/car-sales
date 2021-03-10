<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = [
        'id', 'car_name', 'price', 'stock'
    ];
    public $timestamps = false;

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
