<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = ['vehicle_number', 'plate_number', 'trailer_type','company_id'];

    public function transportPolicies()
    {
        return $this->hasMany(TransportPolicy::class);
    }
}
