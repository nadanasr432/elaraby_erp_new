<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    protected $table = "cash";
    protected $fillable = [
        'cash_number','company_id','client_id','safe_id','outer_client_id','balance_before','balance_after','amount',
        'bill_id','date','time','notes'
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
    public function safe(){
        return $this->belongsTo('\App\Models\Safe','safe_id','id');
    }
    public function salebill(){
        return $this->belongsTo('\App\Models\SaleBill','bill_id','id');
    }
}
