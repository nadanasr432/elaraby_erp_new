<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChargingStation extends Model
{
    use HasFactory;

    protected $fillable = ['country', 'region', 'city','company_id'];

    public function transportPolicies()
    {
        return $this->hasMany(TransportPolicy::class);
    }
}
