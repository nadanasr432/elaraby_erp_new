<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Capital extends Model
{
    protected $table = "capitals";
    protected $fillable = [
        'company_id','client_id','amount','safe_id','balance_before','balance_after','notes'
    ];
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
    public function client(){
        return $this->belongsTo('\App\Models\Client','client_id','id');
    }
    public function safe(){
        return $this->belongsTo('\App\Models\Safe','safe_id','id');
    }
}
