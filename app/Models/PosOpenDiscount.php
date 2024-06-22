<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosOpenDiscount extends Model
{
    protected $table = "pos_open_discount";
    protected $fillable = [
        'pos_open_id','company_id','discount_value','discount_type'
    ];
    public function PosOpen(){
        return $this->belongsTo('\App\Models\PosOpen','pos_open_id','id');
    }
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
}
