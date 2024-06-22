<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponCash extends Model
{
    protected $table = "coupon_cash";
    protected $fillable = [
        'cash_number','company_id','client_id','outer_client_id','coupon_id','amount',
        'bill_id','notes'
    ];
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
    public function client(){
        return $this->belongsTo('\App\Models\Client','client_id','id');
    }
    public function outerClient(){
        return $this->belongsTo('\App\Models\OuterClient','outer_client_id','id');
    }
    public function coupon(){
        return $this->belongsTo('\App\Models\CouponCode','coupon_id','id');
    }
    public function bill(){
        return $this->belongsTo('\App\Models\PosOpen','bill_id','id');
    }
}
