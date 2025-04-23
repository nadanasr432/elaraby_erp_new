<?php

namespace App\Http\Controllers\Client;

use App\Models\Driver;
use App\Models\Company;
use App\Models\Vehicle;
use App\Models\Shipment;
use App\Models\OuterClient;
use App\Models\VehicleOwner;
use Illuminate\Http\Request;
use App\Models\ChargingStation;
use App\Models\TransportPolicy;
use App\Models\DischargingStation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TransportPolicyController extends Controller
{
    public function index()
    {
        return view('client.transport_policies.index', ['policies' => TransportPolicy::where('company_id', auth::user()->company_id)->get()]);
    }

    public function create()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::findOrFail($company_id);

        if (in_array('مدير النظام', Auth::user()->role_name)) {
            $outer_clients = OuterClient::where('company_id', $company_id)->get();
        } else {
            $outer_clients = OuterClient::where('company_id', $company_id)
                ->where(function ($query) {
                    $query->where('client_id', Auth::user()->id)
                        ->orWhereNull('client_id');
                })->get();
        }
        $charge_stations = ChargingStation::where('company_id', auth::user()->company_id)->get();
        $discharge_stations = DischargingStation::where('company_id', auth::user()->company_id)->get();
        $drivers = Driver::where('company_id', auth::user()->company_id)->get();
        $shipments = Shipment::where('company_id', auth::user()->company_id)->get();
        $vehicles = Vehicle::where('company_id', auth::user()->company_id)->get();
        $vehicleOwners = VehicleOwner::where('company_id', auth::user()->company_id)->get();

        return view('client.transport_policies.create', compact(
            'drivers', 'discharge_stations', 'charge_stations', 'company', 'outer_clients', 
            'shipments', 'vehicles', 'vehicleOwners'
        ));
    }

    public function store(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $request->validate([
            'outer_client_id'=>'required|exists:outer_clients,id',
            'discharging_station_id' => 'required|exists:discharging_stations,id',
            'charging_station_id' => 'required|exists:charging_stations,id',
            'driver_id' => 'required|exists:drivers,id',
            'shipment_id' => 'required|exists:shipments,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'vehicle_owner_id' => 'required|exists:vehicle_owners,id',
            'receiver'=>'nullable',
            'sender'=>'nullable'
        ]);
        $request->merge(['company_id' => $company_id]);

        TransportPolicy::create($request->all());

        return redirect()->route('transport-policies.index')->with('success', 'Transport policy added.');
    }
    public function edit(TransportPolicy $transportPolicy)
    {
        $company_id = Auth::user()->company_id;    
        // Get the necessary data for the dropdowns
        $outer_clients = OuterClient::where('company_id', $company_id)->get();
        $discharge_stations = DischargingStation::where('company_id', $company_id)->get();
        $charge_stations = ChargingStation::where('company_id', $company_id)->get();
        $drivers = Driver::where('company_id', $company_id)->get();
        $shipments = Shipment::where('company_id', $company_id)->get();
        $vehicles = Vehicle::where('company_id', $company_id)->get();
        $vehicleOwners = VehicleOwner::where('company_id', $company_id)->get();
        return view('client.transport_policies.edit', compact('transportPolicy', 'outer_clients', 'discharge_stations', 'charge_stations', 'drivers', 'shipments', 'vehicles', 'vehicleOwners'));

    }
     public function update(Request $request, TransportPolicy $transportPolicy)
    {
        $company_id = Auth::user()->company_id;
        $request->validate([
            'outer_client_id'=>'required|exists:outer_clients,id',
            'discharging_station_id' => 'required|exists:discharging_stations,id',
            'charging_station_id' => 'required|exists:charging_stations,id',
            'driver_id' => 'required|exists:drivers,id',
            'shipment_id' => 'required|exists:shipments,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'vehicle_owner_id' => 'required|exists:vehicle_owners,id',
            'receiver'=>'nullable',
            'sender'=>'nullable'
        ]);
        $request->merge(['company_id' => $company_id]);
        

        $transportPolicy->update($request->all());

        return redirect()->route('transport-policies.index')->with('success', 'Transport policy updated.');
    }
     public function destroy(TransportPolicy $transportPolicy)
    {
        $transportPolicy->delete();

        return redirect()->route('transport-policies.index')->with('success', 'Transport policy deleted.');
    }
    public function print(TransportPolicy $transportPolicy)
    {
        $company = Company::findOrFail($transportPolicy->company_id);
        $outerClient = OuterClient::findOrFail($transportPolicy->outer_client_id);
        $dischargingStation = DischargingStation::findOrFail($transportPolicy->discharging_station_id);
        $chargingStation = ChargingStation::findOrFail($transportPolicy->charging_station_id);
        $driver = Driver::findOrFail($transportPolicy->driver_id);
        $shipment = Shipment::findOrFail($transportPolicy->shipment_id);
        $vehicle = Vehicle::findOrFail($transportPolicy->vehicle_id);
        $vehicleOwner = VehicleOwner::findOrFail($transportPolicy->vehicle_owner_id);

         $policyNumber = TransportPolicy::where('company_id', $transportPolicy->company_id)
        ->where('created_at', '<=', $transportPolicy->created_at)
        ->orderBy('created_at')
        ->get()
        ->search(function ($item) use ($transportPolicy) {
            return $item->id === $transportPolicy->id;
        }) + 1;

        return view('client.transport_policies.print', compact(
            'transportPolicy', 'company', 'outerClient', 'dischargingStation',
            'chargingStation', 'driver', 'shipment', 'vehicle', 'vehicleOwner', 'policyNumber'
        ));
    }
}
