<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankModification extends Model
{
    protected $table = "banks_modifications";
    protected $fillable = [
        'company_id','bank_id','client_id','balance_before','balance_after','reason'
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
