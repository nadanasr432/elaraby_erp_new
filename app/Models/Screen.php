<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Screen extends Model
{
    protected $table = "screens";
    protected $fillable = [
        'company_id','branch_id', 'products', 'debt','banks_safes', 'sales',
        'purchases','finance','marketing','accounting','reports','settings',
    ];

    public function company()
    {
        return $this->belongsTo('\App\Models\Company', 'company_id', 'id');
    }
    public function branch()
    {
        return $this->belongsTo('\App\Models\Branch', 'branch_id', 'id');
    }

}
