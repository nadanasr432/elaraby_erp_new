<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankCash extends Model
{
    protected $table = "bank_cash";
    protected $fillable = [
        'cash_number','company_id','client_id','bank_id','outer_client_id','balance_before','balance_after','amount',
        'bill_id','date','time','notes','bank_check_number'
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
    public function bank(){
        return $this->belongsTo('\App\Models\Bank','bank_id','id');
    }
    public function bill(){
        return $this->belongsTo('\App\Models\Bill','bill_id','id');
    }
}
