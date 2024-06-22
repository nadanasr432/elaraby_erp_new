<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class SupplierNote extends Model
{
    protected $table = "supplier_note";
    protected $fillable = [
        'supplier_id','supplier_note','company_id'
    ];

    public function supplier(){
        return $this->belongsTo('\App\Models\Supplier','supplier_id','id');
    }

    public function company(){
        return $this->belongsTo('\App\Models\Company','company_id','id');
    }
}
