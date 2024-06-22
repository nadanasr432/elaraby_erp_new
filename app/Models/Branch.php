<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = "branches";
    protected $fillable = [
        'company_id','branch_name','branch_phone','branch_address','commercial_registration_number'
    ];
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
    public function safes(){
        return $this->hasMany('\App\Models\Safe','branch_id','id');
    }
    public function stores(){
        return $this->hasMany('\App\Models\Store','branch_id','id');
    }
}
