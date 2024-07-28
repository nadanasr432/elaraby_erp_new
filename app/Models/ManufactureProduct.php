<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManufactureProduct extends Model
{
    use HasFactory;
    protected $table ='manufacture_product';
    protected $fillable = [
        'manufacture_id',
        'product_id',
        'qty'
    ];

    public function manufacturing()
    {
        return $this->belongsTo(Manufacture::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
