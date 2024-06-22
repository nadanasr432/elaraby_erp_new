<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankTransfer extends Model
{
    protected $table = "banks_transfer";
    protected $fillable = [
        'company_id','client_id','withdrawal_bank','amount','deposit_bank','reason'
    ];
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
    public function withdrawal(){
        return $this->belongsTo('\App\Models\Bank','withdrawal_bank','id');
    }
    public function deposit(){
        return $this->belongsTo('\App\Models\Bank','deposit_bank','id');
    }
    public function client(){
        return $this->belongsTo('\App\Models\Client','client_id','id');
    }
}
