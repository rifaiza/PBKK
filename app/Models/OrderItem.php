<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    // Nama tabel (opsional jika sesuai konvensi Laravel)
    protected $table = 'order_items';

    // Primary key bertipe string
    protected $primaryKey = 'id';
    public $incrementing = false; // karena bukan auto-increment
    protected $keyType = 'string';

    // Kolom yang bisa diisi massal
    protected $fillable = [
        'id',
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    // Relasi ke Order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    // Relasi ke Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
