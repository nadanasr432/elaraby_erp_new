<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = "suppliers";
    protected $fillable = [
        'company_id','supplier_name','supplier_category',
        'prev_balance','shop_name','supplier_email','supplier_national','tax_number'
    ];
    public function notes(){
        return $this->hasMany('\App\Models\SupplierNote','supplier_id','id');
    }
    public function phones(){
        return $this->hasMany('\App\Models\SupplierPhone','supplier_id','id');
    }
    public function addresses(){
        return $this->hasMany('\App\Models\SupplierAddress','supplier_id','id');
    }
    public function buyBills(){
        return $this->hasMany('\App\Models\BuyBill','supplier_id','id');
    }
    public function buyBillReturns(){
        return $this->hasMany('\App\Models\BuyBillReturn','supplier_id','id');
    }
    public function buyCashs(){
        return $this->hasMany('\App\Models\BuyCash','supplier_id','id');
    }
    public function bankbuyCashs(){
        return $this->hasMany('\App\Models\BankBuyCash','supplier_id','id');
    }
}
