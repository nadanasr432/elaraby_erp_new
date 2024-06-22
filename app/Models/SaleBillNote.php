<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleBillNote extends Model
{
    protected $table = "sale_bill_notes";
    protected $fillable = [
        'company_id','sale_bill_id','notes'
    ];
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
    public function SaleBill(){
        return $this->belongsTo('\App\Models\SaleBill','sale_bill_id','id');
    }
}
