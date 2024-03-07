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
        'sales',
        'import_price',
        'sell_price',
        'gender_item_code',
        'product_id',
    ]; 
}
