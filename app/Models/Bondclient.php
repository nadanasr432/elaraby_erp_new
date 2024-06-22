<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bondclient extends Model
{
    protected $table = "client_bonds";
    protected $fillable = [
        'client','account','type','date',"amount","notes","company_id"
    ];
    // public function company(){
    //     return $this->belongsTo('\App\Models\Company','company_id','id');
    // }

}
