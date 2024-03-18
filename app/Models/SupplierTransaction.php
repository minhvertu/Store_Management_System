<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'import_price',
        'amount',
        'product_detail',
        'shop_id',
        'supplier_id',
        'products_id',
    ]; 
}
