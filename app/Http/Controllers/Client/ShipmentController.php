<?php

namespace App\Http\Controllers\Client;

use App\Models\Shipment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ShipmentController extends Controller
{
    public function index()
    {
        return view('client.shipments.index', ['shipments' => Shipment::where('company_id', auth::user()->company_id)->get()]);
    }

    public function create()
    {
        return view('client.shipments.create');
    }

    public function store(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $request->validate([
            
            'payload_type' => 'required|string',
            'containers_no' => 'nullable|numeric',
            'weight' => 'nullable|string',
            'height' => 'nullable|string',
        ]);
        $request->merge(['company_id' => $company_id]);

        Shipment::create($request->all());

        return redirect()->route('shipments.index')->with('success', 'Shipment added.');
    }
     public function edit(Shipment $shipment )
    {
        return view('client.shipments.edit', compact('shipment'));
    }
    public function update(Request $request, Shipment $shipment)
    {
        $company_id = Auth::user()->company_id;
        $request->validate([
            
            'payload_type' => 'required|string',
            'containers_no' => 'nullable|string',
            'weight' => 'nullable|string',
            'height' => 'nullable|string',
        ]);
        $request->merge(['company_id' => $company_id]);

        $shipment->update($request->all());

        return redirect()->route('shipments.index')->with('success', 'Shipment updated.');
    }
    public function destroy(Shipment $shipment)
    {
        $shipment->delete();

        return redirect()->route('shipments.index')->with('success', 'Shipment deleted.');
    }


}
