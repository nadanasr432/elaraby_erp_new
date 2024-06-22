<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderExtra extends Model
{
    protected $table = "purchase_orders_extra";
    protected $fillable = [
        'purchase_order_id','company_id','action','action_type','value'
    ];
    public function PurchaseOrder(){
        return $this->belongsTo('\App\Models\PurchaseOrder','purchase_order_id','id');
    }
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
}
