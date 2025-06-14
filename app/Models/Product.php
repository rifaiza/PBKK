<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'product_id';
    public $incrementing = false; // karena primary key-nya string
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'name',
        'description',
        'price',
        'stock',
        'category_id',
    ];
}
