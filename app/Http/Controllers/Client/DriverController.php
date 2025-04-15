<?php

namespace App\Http\Controllers\Client;

use App\Models\Driver;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    public function index()
    {
        return view('client.driver.index', ['drivers' => Driver::where('company_id', auth::user()->company_id)->get()]);
    }

    public function create()
    {
        return view('client.driver.create');
    }

    public function store(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $request->validate([
            
            'name' => 'required|string',
            'iqama_number' => 'required|string|unique:drivers',
            'nationality' => 'required|string',
            'mobile_number' => 'required|string',
        ]);
        $request->merge(['company_id' => $company_id]);

        Driver::create($request->all());

        return redirect()->route('drivers.index')->with('success', 'Driver added.');
    }

    public function edit(Driver $driver)
    {
        return view('client.driver.edit', compact('driver'));
    }

    public function update(Request $request, Driver $driver)
    {
        $company_id = Auth::user()->company_id;
        $request->validate([
            
            'name' => 'required|string',
            'iqama_number' => 'required|string|unique:drivers,iqama_number,' . $driver->id,
            'nationality' => 'required|string',
            'mobile_number' => 'required|string',
        ]);
        $request->merge(['company_id' => $company_id]);

        $driver->update($request->all());

        return redirect()->route('drivers.index')->with('success', 'Driver updated.');
    }

    public function destroy(Driver $driver)
    {
        $driver->delete();

        return redirect()->route('drivers.index')->with('success', 'Driver deleted.');
    }
}
