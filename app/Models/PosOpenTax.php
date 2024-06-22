<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosOpenTax extends Model
{
    protected $table = "pos_open_tax";
    protected $fillable = [
        'pos_open_id','company_id','tax_id','tax_value'
    ];
    public function PosOpen(){
        return $this->belongsTo('\App\Models\PosOpen','pos_open_id','id');
    }
    public function Tax(){
        return $this->belongsTo('\App\Models\Tax','tax_id','id');
    }
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
}
