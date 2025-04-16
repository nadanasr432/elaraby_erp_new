<?php

namespace App\Models;

use App\Models\OuterClient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransportPolicy extends Model
{
    use HasFactory;

    protected $fillable = [
        'discharging_station_id', 
        'charging_station_id', 
        'driver_id', 
        'shipment_id', 
        'vehicle_id', 
        'vehicle_owner_id',
        'outer_client_id',
        'company_id',
        'receiver',  
        'sender',
    ];

    public function dischargingStation()
    {
        return $this->belongsTo(DischargingStation::class);
    }

    public function chargingStation()
    {
        return $this->belongsTo(ChargingStation::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function vehicleOwner()
    {
        return $this->belongsTo(VehicleOwner::class);
    }
    public function outer_client()
    {
        return $this->belongsTo(OuterClient::class);
    }
}
