<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehousProductDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'img',
        'category',
        'warehouse_id',
        'specification',
        'buying_price',
        'selling_price',
        'quantiry',
        'stock_status',
        'is_offer',
        'status',
        'author',
    ];
}
