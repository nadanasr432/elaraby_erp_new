<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    protected $table = "gifts";
    protected $fillable = [
        'company_id','outer_client_id','product_id','amount','store_id','balance_before','balance_after','details','notes'
    ];
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
    public function product(){
        return $this->belongsTo('\App\Models\Product','product_id','id');
    }
    public function outerClient(){
        return $this->belongsTo('\App\Models\OuterClient','outer_client_id','id');
    }
    public function store(){
        return $this->belongsTo('\App\Models\Store','store_id','id');
    }
}
