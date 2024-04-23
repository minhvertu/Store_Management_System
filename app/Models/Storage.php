<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    use HasFactory;
    protected $fillable = [
        'shop_id',
        'product_id',
        'amount',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function product_size_amount()
    {
        return $this->hasMany(ProductSizeAmount::class);
    }
}
