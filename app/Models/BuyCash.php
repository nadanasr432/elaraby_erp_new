<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuyCash extends Model
{
    protected $table = "buy_cash";
    protected $fillable = [
        'cash_number','company_id','client_id','safe_id','supplier_id','balance_before','balance_after','amount',
        'bill_id','date','time','notes'
    ];
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
    public function client(){
        return $this->belongsTo('\App\Models\Client','client_id','id');
    }
    public function supplier(){
        return $this->belongsTo('\App\Models\Supplier','supplier_id','id');
    }
    public function safe(){
        return $this->belongsTo('\App\Models\Safe','safe_id','id');
    }
    public function buybill(){
        return $this->belongsTo('\App\Models\BuyBill','bill_id','id');
    }
}
