<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = "banks";
    protected $fillable = [
        'company_id','bank_number','bank_name','bank_balance'
    ];
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }

    public function modifications(){
        return $this->hasMany('\App\Models\BankModification','bank_id','id');
    }

    public function withdrawal_transfers(){
        return $this->hasMany('\App\Models\BankTransfer','withdrawal_bank','id');
    }

    public function deposit_transfers(){
        return $this->hasMany('\App\Models\BankTransfer','deposit_bank','id');
    }

    public function processes(){
        return $this->hasMany('\App\Models\BankProcess','bank_id','id');
    }

}
