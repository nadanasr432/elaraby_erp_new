<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'iqama_number', 'nationality', 'mobile_number','company_id'];

    public function transportPolicies()
    {
        return $this->hasMany(TransportPolicy::class);
    }
}
