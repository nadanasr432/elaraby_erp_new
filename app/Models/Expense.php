<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $table = "expenses";
    protected $fillable = [
        'expense_number','company_id','client_id','employee_id','fixed_expense','expense_details'
        ,'amount','expense_pic','safe_id','notes','date'
    ];
    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
    public function employee(){
        return $this->belongsTo('\App\Models\Employee','employee_id','id');
    }
    public function client(){
        return $this->belongsTo('\App\Models\Client','client_id','id');
    }
    public function fixed(){
        return $this->belongsTo('\App\Models\FixedExpense','fixed_expense','id');
    }
    public function safe(){
        return $this->belongsTo('\App\Models\Safe','safe_id','id');
    }
}
