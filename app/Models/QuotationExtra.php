<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationExtra extends Model
{
    protected $table = "quotations_extra";
    protected $fillable = [
        'quotation_id','company_id','action','action_type','value'
    ];
    public function quotation(){
        return $this->belongsTo('\App\Models\Quotation','quotation_id','id');
    }

    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
}
