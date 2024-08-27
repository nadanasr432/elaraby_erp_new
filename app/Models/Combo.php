<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Combo extends Model
{
    use HasFactory;
    protected $table = 'combos';
    protected $fillable = [
        'parent_id',
        'price',
        'quantity',
        'product_id',
    ];
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function parent()
    {
        return $this->belongsTo(Product::class, 'parent_id');
    }

    // The child product that is part of the combo
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
