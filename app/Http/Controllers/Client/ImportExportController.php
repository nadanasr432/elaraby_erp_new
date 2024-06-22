<?php

namespace App\Http\Controllers\Client;

use App\Exports\InventoryExport;
use App\Exports\OuterClientsExport;
use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Imports\OuterClientsImport;
use App\Imports\ProductsImport;
use App\Models\Company;
use App\Models\OuterClient;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Exports\SuppliersExport;
use App\Imports\SuppliersImport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;


class ImportExportController extends Controller
{
    public function export_suppliers()
    {
        return Excel::download(new SuppliersExport, 'الموردين.xlsx');
    }
    public function import_suppliers(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $suppliers = Supplier::where('company_id',$company_id)
            ->get();
        // foreach ($suppliers as $supplier) {
        //     $supplier->delete();
        // }
        Excel::import(new SuppliersImport, $request->file('file'));
        return redirect()->back();
    }

    public function export_outer_clients()
    {
        return Excel::download(new OuterClientsExport, 'العملاء.xlsx');
    }
    public function import_outer_clients(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $outer_clients = OuterClient::where('company_id',$company_id)
            ->get();
        // foreach ($outer_clients as $outer_client) {
        //     $outer_client->delete();
        // }
        Excel::import(new OuterClientsImport, $request->file('file'));
        return redirect()->back();
    }

    public function export_products()
    {
        return Excel::download(new ProductsExport, 'المنتجات.xlsx');
    }
    public function import_products(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $products = Product::where('company_id',$company_id)
            ->get();
        // foreach ($products as $product) {
        //     $product->delete();
        // }
        Excel::import(new ProductsImport, $request->file('file'));
        return redirect()->back();
    }
    public function export_inventory(Request $request)
    {
        $data = $request->all();
        return Excel::download(new InventoryExport($data), 'تقرير جرد المخازن.xlsx');
    }
}
