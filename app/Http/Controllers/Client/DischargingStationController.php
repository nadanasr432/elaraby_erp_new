<?php

namespace App\Http\Controllers\Client;

use App\Models\TimeZone;
use Illuminate\Http\Request;
use App\Models\DischargingStation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DischargingStationController extends Controller
{
    
    public function index()
    {
        return view('client.discharging_stations.index', ['stations' => DischargingStation::where('company_id', Auth::user()->company_id)->get()]);
    }

    public function create()
    {
        $countries = TimeZone::all();
        return view('client.discharging_stations.create',compact('countries'));
    }

    public function store(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $request->validate([
            
            'country' => 'required|string',
            'region' => 'required|string',
            'city' => 'required|string',
        ]);
        $request->merge(['company_id' => $company_id]);

        DischargingStation::create($request->all());

        return redirect()->route('discharging-stations.index')->with('success', 'Charging station added.');
    }

    public function edit(DischargingStation $dischargingStation)
    {
        $countries = TimeZone::all();
        return view('client.discharging_stations.edit', compact('dischargingStation','countries'));
    }

    public function update(Request $request, DischargingStation $dischargingStation)
    {
        $company_id = Auth::user()->company_id;
        $request->validate([
            
            'country' => 'required|string',
            'region' => 'required|string',
            'city' => 'required|string',
        ]);
        $request->merge(['company_id' => $company_id]);

        $dischargingStation->update($request->all());

        return redirect()->route('discharging-stations.index')->with('success', 'Charging station updated.');
    }

   public function destroy($id)
    {
        $station = DischargingStation::findOrFail($id);
        $station->delete();

        return redirect()->route('discharging-stations.index')->with('success', 'تم حذف محطة التفريغ بنجاح!');
    }

}

