<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuyBill extends Model
{
    protected $table = "buy_bills";
    protected $fillable = [
        'company_id','company_counter','client_id','supplier_id','buy_bill_number','date','time','notes'
        ,'final_total','status','paid','rest','value_added_tax'
    ];
    public function elements(){
        return $this->hasMany('\App\Models\BuyBillElement','buy_bill_id','id');
    }
    public function extras(){
        return $this->hasMany('\App\Models\BuyBillExtra','buy_bill_id','id');
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
