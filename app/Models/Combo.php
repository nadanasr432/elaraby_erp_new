<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Combo extends Model
{
    use HasFactory;
    protected $fillable = [
        'parent_id',
        'price',
        'quantity',
        'product_id',
    ];
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
