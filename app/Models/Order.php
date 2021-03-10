<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = [
        'id', 'buyers_name', 'email', 'phone', 'product_id'
    ];
}
