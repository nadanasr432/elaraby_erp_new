<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $table = "purchase_orders";
    protected $fillable = [
        'company_id','client_id','supplier_id','purchase_order_number','start_date','expiration_date'
    ];
    public function elements(){
        return $this->hasMany('\App\Models\PurchaseOrderElement','purchase_order_id','id');
    }
    public function extras(){
        return $this->hasMany('\App\Models\PurchaseOrderExtra','purchase_order_id','id');
    }
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
    public function supplier(){
        return $this->belongsTo('\App\Models\Supplier','supplier_id','id');
    }
    public function client(){
        return $this->belongsTo('\App\Models\Client','client_id','id');
    }
}
