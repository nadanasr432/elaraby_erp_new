<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = "subscriptions";
    protected $fillable = [
        'company_id','type_id','start_date','end_date','status'
    ];
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
    public function type(){
        return $this->belongsTo('\App\Models\Type','type_id','id');
    }
}
