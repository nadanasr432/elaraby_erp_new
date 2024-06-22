<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SafeTransfer extends Model
{
    protected $table = "safes_transfer";
    protected $fillable = [
        'company_id','client_id','from_safe','to_safe','amount','reason'
    ];
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
    public function client(){
        return $this->belongsTo('\App\Models\Client','client_id','id');
    }
    public function fromSafe(){
        return $this->belongsTo('\App\Models\Safe','from_safe','id');
    }
    public function toSafe(){
        return $this->belongsTo('\App\Models\Safe','to_safe','id');
    }
}
