<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSizeAmount extends Model
{
    use HasFactory;
    protected $fillable = [

        'amount',
        'import_cost',
        'import_code',
        'size_id',
        'storage_id',

    ];

    public function size()
    {
        return $this->belongsTo(Size::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }


}
