<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'product_code',
        'amount',
        'gender_item_code',
        'import_price',
        'sell_price',
        'size',
        'brand_id',
        'category_id',
    ]; 

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
