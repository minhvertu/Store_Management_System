<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [

        'price',
        'detail',
        'order_code',
        'client_id',
        'user_id',
        'status',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function order_product()
    {
        return $this->hasMany(OrderProduct::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}


