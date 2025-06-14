<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Categories extends Model
{
    protected $table = 'categories';

    protected $primaryKey = 'category_id'; // jika bukan 'id'
    public $incrementing = false; // karena kamu pakai string
    protected $keyType = 'string';

    protected $fillable = [
        'product_id',
        'name',
        'description',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->category_id)) {
                $model->category_id = (string) Str::ulid();
            }
        });
    }
}
