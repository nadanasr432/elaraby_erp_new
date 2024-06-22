<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class SupplierPhone extends Model
{
    protected $table = "supplier_phone";
    protected $fillable = [
        'supplier_id','supplier_phone','company_id'
    ];

    public function supplier(){
        return $this->belongsTo('\App\Models\Supplier','supplier_id','id');
    }

    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
}
