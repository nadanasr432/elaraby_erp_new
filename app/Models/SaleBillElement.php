<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleBillElement extends Model
{
    protected $table = "sale_bill_elements";
    protected $fillable = [
        'sale_bill_id','company_id','product_id','product_price','quantity','unit_id','quantity_price'
    ];
    public function unit(){
        return $this->belongsTo('\App\Models\Unit','unit_id','id');
    }
    public function SaleBill(){
        return $this->belongsTo('\App\Models\SaleBill','sale_bill_id','id');
    }
    public function product(){
        return $this->belongsTo('\App\Models\Product','product_id','id');
    }
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
}
