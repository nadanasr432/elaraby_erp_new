<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeCash extends Model
{
    protected $table = "employees_cash";
    protected $fillable = [
        'company_id','client_id','employee_id','safe_id','date','amount','notes'
    ];
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
    public function client(){
        return $this->belongsTo('\App\Models\Client','client_id','id');
    }
    public function employee(){
        return $this->belongsTo('\App\Models\Employee','employee_id','id');
    }
    public function safe(){
        return $this->belongsTo('\App\Models\Safe','safe_id','id');
    }

}
