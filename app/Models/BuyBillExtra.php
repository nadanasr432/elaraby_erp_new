<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuyBillExtra extends Model
{
    protected $table = "buy_bill_extra";
    protected $fillable = [
        'buy_bill_id','company_id','action','action_type','value'
    ];
    public function SaleBill(){
        return $this->belongsTo('\App\Models\BuyBill','buy_bill_id','id');
    }

    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
}
