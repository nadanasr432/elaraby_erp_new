<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $table = "stores";
    protected $fillable = [
        'company_id','branch_id','store_name'
    ];
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
    public function branch(){
        return $this->belongsTo('\App\Models\Branch','branch_id','id');
    }
    public function gifts(){
        return $this->hasMany('\App\Models\Gift','store_id','id');
    }
    public function products(){
        return $this->hasMany('\App\Models\Product','store_id','id');
    }
}
