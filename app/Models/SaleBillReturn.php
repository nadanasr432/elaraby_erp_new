<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleBillReturn extends Model
{
    protected $table = "sale_bill_return";
    protected $fillable = [
        'bill_id','company_id','client_id','outer_client_id','balance_before','balance_after','product_id'
        ,'product_price','quantity_price','return_quantity','before_return','after_return','date','time','notes'
    ];
    public function bill(){
        return $this->belongsTo('\App\Models\SaleBill','bill_id','id');
    }
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
    public function client(){
        return $this->belongsTo('\App\Models\Client','client_id','id');
    }
    public function outerClient(){
        return $this->belongsTo('\App\Models\OuterClient','outer_client_id','id');
    }
    public function product(){
        return $this->belongsTo('\App\Models\Product','product_id','id');
    }
}
