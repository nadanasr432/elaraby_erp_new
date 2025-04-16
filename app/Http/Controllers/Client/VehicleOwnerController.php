<?php

namespace App\Http\Controllers\Client;

use App\Models\Company;
use App\Models\VehicleOwner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class VehicleOwnerController extends Controller
{
    public function index()
    {
        return view('client.vehicleOwner.index', ['owners' => VehicleOwner::where('company_id', auth::user()->company_id)->get()]);
    }

    public function create()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        return view('client.vehicleOwner.create',compact('company'));
    }

    public function store(Request $request)
    {        
        $company_id = Auth::user()->company_id;
        $request->validate([
            'company_name' => 'required|string',
            'supervisor_name' => 'required|string',
            'mobile_number' => 'required|string',
        ]);
        $request->merge(['company_id' => $company_id]);

        VehicleOwner::create($request->all());

        return redirect()->route('vehicle-owners.index')->with('success', 'Vehicle owner added.');
    }
     public function edit(VehicleOwner $vehicleOwner )
    {
        return view('client.vehicleOwner.edit', compact('vehicleOwner'));
    }
    public function update(Request $request, VehicleOwner $vehicleOwner)
    {
        $company_id = Auth::user()->company_id;
        $request->validate([
            'company_name' => 'required|string',
            'supervisor_name' => 'required|string',
            'mobile_number' => 'required|string',
        ]);
        $request->merge(['company_id' => $company_id]);

        $vehicleOwner->update($request->all());

        return redirect()->route('vehicle-owners.index')->with('success', 'Vehicle owner updated.');
    }

    public function destroy(VehicleOwner $vehicleOwner)
    {
        $vehicleOwner->delete();

        return redirect()->route('vehicle-owners.index')->with('success', 'Vehicle Owners deleted.');
    }

}
