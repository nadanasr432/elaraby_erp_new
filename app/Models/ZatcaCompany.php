<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZatcaCompany extends Model
{
    protected $fillable = ['company_id', 'onboarding_data', 'last_hash', 'sequence'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
