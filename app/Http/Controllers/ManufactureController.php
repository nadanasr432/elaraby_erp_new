<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Product;
use App\Models\Manufacture;
use Illuminate\Http\Request;
use App\Models\Manufacturing;
use Illuminate\Support\Carbon;
use App\Models\ManufactureProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ManufactureController extends Controller
{
    public function index()
    {
        $company_id = Auth::user()->company_id;
        $manufactures = Manufacture::with('products.product')->where('company_id', $company_id)->get();
        return view('client.manufacture.index', compact('company_id', 'manufactures'));
    }


    public function create()
    {
        $company_id = Auth::user()->company_id;
        $stores = Store::where('company_id', $company_id)->get();
        $ManufactureProducts = Product::where(['manufacturer' => 1, 'company_id' => $company_id])->get();
        return view(
            'client.manufacture.create',
            compact('company_id', 'stores', 'ManufactureProducts')
        );
    }
    public function show(Manufacture $manufacture)
    {
        // $company_id = Auth::user()->company_id;
        // $stores = Store::where('company_id', $company_id)->get();
        // $ManufactureProducts = Product::where(['manufacturer' => 1, 'company_id' => $company_id])->get();
        return view(
            'client.manufacture.show',
            compact('manufacture')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required|integer',
            'store_id' => 'required|integer',
            'status' => 'required|string',
            'date' => 'required|date',
            'products' => 'required|array',
            'total' => 'required',
            'qty' => 'required|integer',
            'note' => 'nullable',
            'products.*.id' => 'required|integer',
            'products.*.qty' => 'required|integer',
        ]);
        DB::beginTransaction();

        try {
            // Create the manufacturing record
            $manufacturing = Manufacture::create([
                'company_id' => $request->input('company_id'),
                'store_id' => $request->input('store_id'),
                'status' => $request->input('status'),
                'date' => Carbon::parse($request->input('date')),
                'qty' => $request->input('qty'),
                'note' => $request->input('note'),
                'total' => $request->input('total'),
            ]);

            // Create the related manufacture products
            foreach ($request->input('products') as $product) {
                ManufactureProduct::create([
                    'manufacture_id' => $manufacturing->id,
                    'product_id' => $product['id'],
                    'qty' => $product['qty'],
                ]);
            }

            DB::commit();

            return redirect()->route('client.manufactures.index')->with('success', 'Manufacturing record created successfully.');
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();

            Log::error('Manufacture record creation failed: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to create manufacture record: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Manufacture $Manufacture)
    {
        $Manufacture->status = 'complete';
        $Manufacture->save();
        return redirect()->route('client.manufactures.index')->with('success', 'Manufacturing confirmed successfully.');
    }


    public function cancel($Manufacture)
    {
        $Manufacture = Manufacture::findOrFail($Manufacture);
        // dd($Manufacture);
        $Manufacture->status = 'canceled';
        $Manufacture->save();
        return redirect()->route('client.manufactures.index')->with('success', 'Manufacturing canceled successfully.');
    }
}
