<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosReturnElement extends Model
{
    protected $table = 'pos_return_elements';
    protected $fillable = [
        'pos_return_id', 'company_id', 'product_id', 'product_price',
        'quantity', 'discount', 'quantity_price'
    ];

    public function posReturn()
    {
        return $this->belongsTo(PosReturn::class, 'pos_return_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
