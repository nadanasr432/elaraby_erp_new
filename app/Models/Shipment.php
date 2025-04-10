<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = ['payload_type', 'containers_no', 'weight', 'height','company_id'];

    public function transportPolicies()
    {
        return $this->hasMany(TransportPolicy::class);
    }
}
