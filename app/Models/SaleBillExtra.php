<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleBillExtra extends Model
{
    protected $table = "sale_bill_extra";
    protected $fillable = [
        'sale_bill_id','company_id','action','action_type','value','discount_note'
    ];
    public function SaleBill(){
        return $this->belongsTo('\App\Models\SaleBill','sale_bill_id','id');
    }
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
}
