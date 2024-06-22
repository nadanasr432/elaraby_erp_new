<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankBuyCash extends Model
{
    protected $table = "bank_buy_cash";
    protected $fillable = [
        'cash_number','company_id','client_id','bank_id','supplier_id','balance_before','balance_after','amount',
        'bill_id','date','time','bank_check_number','notes'
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
    public function bank(){
        return $this->belongsTo('\App\Models\Bank','bank_id','id');
    }
    public function buybill(){
        return $this->belongsTo('\App\Models\BuyBill','bill_id','id');
    }
}
