<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    use HasFactory;
    protected $table = 'product_stock';
    protected $fillable = [
        'product_id',
        'store_id',
        'remaining',
        'qty',
        'stockable_id',
        'stockable_type',
        'net_unit_cost',
    ];

    /**
     * Get the product associated with the stock.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function stockable()
    {
        return $this->morphTo();
    }
}
