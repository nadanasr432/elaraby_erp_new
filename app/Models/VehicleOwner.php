<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleOwner extends Model
{
    use HasFactory;

    protected $fillable = ['company_name', 'supervisor_name', 'mobile_number','company_id'];

    public function transportPolicies()
    {
        return $this->hasMany(TransportPolicy::class);
    }
}
