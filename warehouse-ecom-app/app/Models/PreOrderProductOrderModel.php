<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreOrderProductOrderModel extends Model
{
    use HasFactory;
    protected $fillable = [
        'details',
        'payment',
        'status'
    ];
}
