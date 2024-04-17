<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSizeAmount extends Model
{
    use HasFactory;
    protected $fillable = [
       
        'amount',
        'size_id',
        'storage_id',
      
    ]; 

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }
}
