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
        'gender_id',
        'import_price',
        'sell_price',
        'size',
        'brand_id',
        'category_id',
        'image',
        'description_image',
        'detail',
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function storages()
{
    return $this->hasMany(Storage::class);
}

    public function descriptionImages()
    {
        return $this->hasMany(DescriptionImage::class);
    }

    public function product_size_amount()
    {
        return $this->hasMany(ProductSizeAmount::class);
    }


}
