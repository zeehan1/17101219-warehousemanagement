<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockProductOrderModel extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_name',
        'quantity',
        'payment',
        'status'
    ];
}
