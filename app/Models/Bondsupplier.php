<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bondsupplier extends Model
{
    protected $table = "supplier_bonds";
    protected $fillable = [
        'company_id','supplier','account','type','date',"amount","notes","company_id"
    ];
    // public function company(){
    //     return $this->belongsTo('\App\Models\Company','company_id','id');
    // }

}
