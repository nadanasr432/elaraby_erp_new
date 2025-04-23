<?php

namespace App\Http\Controllers\Client;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    public function index()
    {
        return view('client.vehicles.index', ['vehicles' => Vehicle::where('company_id', auth::user()->company_id)->get()]);
    }

    public function create()
    {
        return view('client.vehicles.create');
    }

    public function store(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $request->validate([
            
            'vehicle_number' => 'required|string|unique:vehicles',
            'plate_number' => 'required|string',
            'trailer_type' => 'nullable|string',
        ]);
        $request->merge(['company_id' => $company_id]);

        Vehicle::create($request->all());

        return redirect()->route('vehicles.index')->with('success', 'Vehicle added.');
    }
    public function edit(Vehicle $vehicle)
    {
        return view('client.vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $company_id = Auth::user()->company_id;
        $request->validate([
            
            'vehicle_number' => 'required|string|unique:vehicles,vehicle_number,' . $vehicle->id,
            'plate_number' => 'required|string',
            'trailer_type' => 'nullable|string',
        ]);
        

        $vehicle->update($request->all());

        return redirect()->route('vehicles.index')->with('success', 'Vehicle updated.');
    }
     public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return redirect()->route('vehicles.index')->with('success', 'Vehicle deleted.');
    }

}
