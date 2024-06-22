<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Safe extends Model
{
    protected $table = "safes";
    protected $fillable = [
        'company_id','branch_id','safe_name','balance','type'
    ];
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
    public function branch(){
        return $this->belongsTo('\App\Models\Branch','branch_id','id');
    }
    public function expenses(){
        return $this->hasMany('\App\Models\Expense','safe_id','id');
    }
}
