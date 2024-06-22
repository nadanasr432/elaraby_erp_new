<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\Bondclient;
use App\Models\Bondsupplier;
use App\Models\Supplier;
use App\Models\OuterClient;
use App\Models\ElectronicStamps;
use File;


class BondsController extends Controller
{
    public function getClientsBonds()
    {
        $bondClients = Bondclient::where("company_id", Auth::user()->company_id)->latest()->get();
        return view('client.clients_bonds.index', compact("bondClients"));
    }

    //show create page..
    public function createClientsBonds()
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

        return view('client.clients_bonds.create', compact("outer_clients"));
    }


    //store new clientBond...
    public function storeNewBond(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $outerClient = OuterClient::where("client_name", $request->client)->where('company_id', $company_id)->first();

        if ($request->type == "قبض") {
            $outerClient->prev_balance -= $request->amount;
        } else {
            $outerClient->prev_balance += $request->amount;
        }
        $outerClient->save();

        try {
            $bond = Bondclient::create($request->all());
            return response()->json($bond->id);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
    public function deleteClientBond(Request $request)
    {
        Bondclient::destroy($request->client_bond_id);
        return redirect("ar/client/clients-bonds/index");
    }

    public function getClientBond($id)
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

        $clientBond = Bondclient::find($id);
        return view('client.clients_bonds.edit', compact("clientBond", "outer_clients"));
    }
    public function updateClientBond(Request $request)
    {
        $clientBond = Bondclient::find($request->client_bond_id);
        $clientBond->update($request->all());
        return response()->json(1);
    }

    //index page for supliers bonds..
    public function getSuppliersBonds()
    {
        $blondSuppliers = Bondsupplier::where("company_id", Auth::user()->company_id)->latest()->get();
        return view('client.suppliers_bonds.index', compact("blondSuppliers"));
    }

    //create page for supliers bonds..
    public function createSuppliersBonds()
    {
        $suppliers = Supplier::where("company_id", Auth::user()->company_id)->get();
        return view('client.suppliers_bonds.create', compact("suppliers"));
    }

    //store new supplierBond...
    public function storeNewBondSupplier(Request $request)
    {
        $company_id = Auth::user()->company_id;

        $supplier = Supplier::where("supplier_name", $request->supplier)->where('company_id', $company_id)->first();

        if ($request->type == "قبض") {
            $supplier->prev_balance -= $request->amount;
        } else {
            $supplier->prev_balance += $request->amount;
        }
        $supplier->save();

        try {
            $bond = Bondsupplier::create([
                "company_id" => $request->company_id,
                "supplier" => $request->supplier,
                "account" => $request->account,
                "type" => $request->type,
                "date" => $request->date,
                "amount" => $request->amount,
                "notes" => $request->notes
            ]);
            return response()->json($bond->id);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function showClientBondPrint($clientid)
    {
        $company_id = Auth::user()->company_id;
        $company_data = Company::findOrFail($company_id);
        $clientBond = Bondclient::find($clientid);
        $electronicStamp = ElectronicStamps::where('company_id', Auth::user()->company_id)->first();
        return view('client.clients_bonds.show', compact("clientBond", 'company_data', 'electronicStamp'));
    }

    public function getSupplierBond($supplierid)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::findOrFail($company_id);
        $suppliers = Supplier::where("company_id", $company_id)->get();
        $supplierBond = Bondsupplier::find($supplierid);
        return view('client.suppliers_bonds.edit', compact("supplierBond", "suppliers"));
    }

    public function updateSupplierBond(Request $request)
    {
        $supplierBond = Bondsupplier::find($request->supplier_bond_id);
        $supplierBond->fill($request->all());

        if ($supplierBond->save()) {
            return response()->json(1);
        } else {
            return response()->json("err", 500);
        }
    }

    public function deleteSupplierBond(Request $request)
    {
        $bondId = $request->supplierID;
        Bondsupplier::destroy($bondId);

        return redirect()->route('ar.client.suppliers-bonds.index');
    }

    public function showSupplierBondPrint($supplierid)
    {
        $company_id = Auth::user()->company_id;
        $company_data = Company::findOrFail($company_id);
        $supplierBond = Bondsupplier::findOrFail($supplierid);
        $electronicStamp = ElectronicStamps::where('company_id', $company_id)->first();

        return view('client.suppliers_bonds.show', compact("supplierBond", 'electronicStamp', 'company_data'));
    }



    public function electronicStmapPage()
    {
        $electronicStamp = ElectronicStamps::where('company_id', Auth::user()->company_id)->first();
        return view('client.electronic_stamp', compact('electronicStamp'));
    }

    public function addElectronicStamp(Request $request)
    {

        $electronicStamp = ElectronicStamps::where('company_id', Auth::user()->company_id)->first();


        $img = $_FILES['elec_stamp'];
        $imgName = time() . "." . strtolower(explode(".", $img['name'])[1]);
        $path = base_path("assets/images/electronic_stamps/" . $imgName);


        if (move_uploaded_file($img['tmp_name'], $path)) {

            //check if there is an stamp already uploaded
            if ($electronicStamp !== null) {

                //yes there is an stamp uploaded... so we need to delete it.
                $img_path = base_path("assets/images/electronic_stamps/" . $electronicStamp->img);
                if (File::exists($img_path)) {
                    File::delete($img_path);
                }

                $electronicStamp->img = $imgName;
                $electronicStamp->save();
            } else {
                $electronicStamp = new ElectronicStamps();
                $electronicStamp->img = $imgName;
                $electronicStamp->company_id = Auth::user()->company_id;
                $electronicStamp->save();
            }
            echo $imgName;
        } else {
            echo "err";
        }
    }
}
