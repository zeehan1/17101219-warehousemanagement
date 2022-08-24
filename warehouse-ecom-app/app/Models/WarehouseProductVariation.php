<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseProductVariation extends Model
{
    use HasFactory;
    protected $fillable = [
        'variation_name',
        'variation_type',
    ];
}
