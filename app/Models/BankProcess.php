<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankProcess extends Model
{
    protected $table = "banks_process";
    protected $fillable = [
        'company_id','bank_id','client_id','process_type','amount','balance_before','balance_after','reason'
    ];
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
    public function bank(){
        return $this->belongsTo('\App\Models\Bank','bank_id','id');
    }
    public function client(){
        return $this->belongsTo('\App\Models\Client','client_id','id');
    }
}
