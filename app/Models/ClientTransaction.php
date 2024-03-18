<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'price',
        'amount',
        'product_detail',
        'shop_id',
        'client_id',
        'products_id',
    ]; 
}
