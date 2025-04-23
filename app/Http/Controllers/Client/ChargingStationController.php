<?php

namespace App\Http\Controllers\Client;

use App\Models\Country;
use App\Models\Currency;
use App\Models\TimeZone;
use Illuminate\Http\Request;
use App\Models\ChargingStation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ChargingStationController extends Controller
{
    public function index()
    {
        return view('client.charging_stations.index', ['stations' => ChargingStation::where('company_id', auth::user()->company_id)->get()]);
    }

    public function create()
    {
        $countries = TimeZone::all();
        return view('client.charging_stations.create',compact('countries'));
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


        ChargingStation::create($request->all());

        return redirect()->route('charging-stations.index')->with('success', 'Charging station added.');
    }

    public function edit(ChargingStation $chargingStation)
    {
        $countries = TimeZone::all();
        return view('client.charging_stations.edit', compact('chargingStation','countries'));
    }

    public function update(Request $request, ChargingStation $chargingStation)
    {
        $company_id = Auth::user()->company_id;
        $request->validate([
            
            'country' => 'required|string',
            'region' => 'required|string',
            'city' => 'required|string',
        ]);
        $request->merge(['company_id' => $company_id]);

        $chargingStation->update($request->all());

        return redirect()->route('charging-stations.index')->with('success', 'Charging station updated.');
    }

   public function destroy($id)
    {
        $station = ChargingStation::findOrFail($id);
        $station->delete();

        return redirect()->route('charging-stations.index')->with('success', 'تم حذف محطة الشحن بنجاح!');
    }

}
