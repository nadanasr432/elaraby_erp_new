<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuyBillReturn extends Model
{
    protected $table = "buy_bill_return";
    protected $fillable = [
        'bill_id','company_id','client_id','supplier_id','balance_before','balance_after','product_id'
        ,'product_price','quantity_price','return_quantity','before_return','after_return','date','time','notes'
    ];
    public function bill(){
        return $this->belongsTo('\App\Models\BuyBill','bill_id','id');
    }
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
    public function client(){
        return $this->belongsTo('\App\Models\Client','client_id','id');
    }
    public function supplier(){
        return $this->belongsTo('\App\Models\Supplier','supplier_id','id');
    }
    public function product(){
        return $this->belongsTo('\App\Models\Product','product_id','id');
    }
}
