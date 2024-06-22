<?php

namespace App\Exports;
use App\Models\BuyBillElement;
use App\Models\Company;
use App\Models\Product;
use App\Models\SaleBillElement;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class InventoryExport implements FromView
{
    public $data;
    public function __construct($data)
    {
        $this->data = $data;
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $stores = $company->stores;
        $products = $company->products;
        $store_id = $data['store_id'];
        $from_date = $data['from_date'];
        $to_date = $data['to_date'];
        $options= $data['options'];
        $data['company_id'] = $company_id;
        $data['company'] = $company;
        $data['stores'] = $stores;
        $data['products'] = $products;
        if (!empty($store_id)) {
            if($store_id == "all"){
                // serach by store
                if (empty($from_date) || empty($to_date)) {
                    $products_k = Product::where('company_id',$company_id)->get();
                } else {
                    $products_k = Product::whereBetween('created_at', [$from_date, $to_date])->where('company_id',$company_id)
                        ->get();
                }
            }
            else{
                // serach by store
                if (empty($from_date) || empty($to_date)) {
                    $products_k = Product::where('store_id', $store_id)->where('company_id',$company_id)->get();
                } else {
                    $products_k = Product::where('store_id', $store_id)
                        ->where('company_id',$company_id)
                        ->whereBetween('created_at', [$from_date, $to_date])
                        ->get();
                }
            }
            $data['products_k'] = $products_k;
        }
//        dd($data);
        $this->data = $data;
    }
    public function view(): View
    {
        return view('client.stores.report', [
            'data' => $this->data
        ]);
    }

}

