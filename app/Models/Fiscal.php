<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fiscal extends Model
{
    protected $table = "fiscals";
    protected $fillable = [
        'company_id','fiscal_year','start_date','end_date'
    ];
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
}
