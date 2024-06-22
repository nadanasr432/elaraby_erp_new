<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SafeBankTransfer extends Model
{
    protected $table = "safe_bank_transfer";
    protected $fillable = [
        'company_id','client_id','safe_id','bank_id','amount','reason'
    ];
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
    public function bank(){
        return $this->belongsTo('\App\Models\Bank','bank_id','id');
    }
    public function safe(){
        return $this->belongsTo('\App\Models\Safe','safe_id','id');
    }
    public function client(){
        return $this->belongsTo('\App\Models\Client','client_id','id');
    }
}
