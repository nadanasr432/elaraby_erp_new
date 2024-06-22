<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = "units";
    protected $fillable = [
        'company_id','unit_name'
    ];
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
}
