<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = "employees";
    protected $fillable = [
        'company_id','client_id','name','birth_date','job','civil_registry','address','phone_number','email',
        'salary','work_status','work_start_date','work_end_date','works_by_the_hour','number_of_hours_per_day','hourly_price'
    ];
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
    public function client(){
        return $this->belongsTo('\App\Models\Client','client_id','id');
    }
    public function employees_cashs(){
        return $this->hasMany('\App\Models\EmployeeCash','employee_id','id');
    }
}
