<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreTransfer extends Model
{
    protected $table = "stores_transfer";
    protected $fillable = [
        'company_id','client_id','from_store','to_store','product_id','quantity','date','notes'
    ];
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
    public function client(){
        return $this->belongsTo('\App\Models\Client','client_id','id');
    }
    public function product(){
        return $this->belongsTo('\App\Models\Product','product_id','id');
    }
    public function fromStore(){
        return $this->belongsTo('\App\Models\Store','from_store','id');
    }
    public function toStore(){
        return $this->belongsTo('\App\Models\Store','to_store','id');
    }
}
