<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderElement extends Model
{
    protected $table = "purchase_orders_elements";
    protected $fillable = [
        'purchase_order_id','company_id','product_id','product_price','quantity','unit_id','quantity_price'
    ];
    public function unit(){
        return $this->belongsTo('\App\Models\Unit','unit_id','id');
    }
    public function PurchaseOrder(){
        return $this->belongsTo('\App\Models\PurchaseOrder','purchase_order_id','id');
    }
    public function product(){
        return $this->belongsTo('\App\Models\Product','product_id','id');
    }
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
}
