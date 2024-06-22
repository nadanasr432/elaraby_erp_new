<?php

namespace App\Http\Controllers\Client;

use App\Models\Cash;
use App\Models\ClientProfile;
use App\Models\Client;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\ExtraSettings;
use App\Models\OuterClient;
use App\Models\Package;
use App\Models\PosSetting;
use App\Models\Product;
use App\Models\SaleBill;
use App\Models\Supplier;
use App\Models\Type;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth:client-web');
    }

    public function index()
    {
        $auth_id = Auth::user()->id;
        $user = Client::findOrFail($auth_id);
        $company_id = Auth::user()->company_id;
        if (ClientProfile::where('client_id', '=', $auth_id)->count() > 0) {
            //profile found
        } else {
            // profile not found
            $user->assignRole($user->role_name);
            $profile = ClientProfile::create([
                'city_name' => '',
                'age' => '',
                'gender' => '',
                'profile_pic' => 'app-assets/images/logo.png',
                'Client_id' => $auth_id,
                'company_id' => $company_id
            ]);
        }
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $outer_clients = $company->outerClients;


        # total Clients' indebtedness -- اجمالي مديونية العملاء
        $clients_balances = array();
        foreach ($outer_clients as $outer_client) {
            $client_balance = $outer_client->prev_balance;
            array_push($clients_balances, $client_balance);
        }
        $total_clients_balances = array_sum($clients_balances);
        #----------------------#

        # total Suppliers' indebtedness -- اجمالي مديونية الموردين
        $suppliers = $company->suppliers;
        $suppliers_balances = array();
        foreach ($suppliers as $supplier) {
            $supplier_balance = $supplier->prev_balance;
            array_push($suppliers_balances, $supplier_balance);
        }
        $total_suppliers_balances = array_sum($suppliers_balances);
        #----------------------#

        // اجمالى الخزن
        $safes = $company->safes;
        $safes_balances = 0;
        foreach ($safes as $safe) {
            $safes_balances = $safes_balances + $safe->balance;
        }
        // اجمالى البنوك
        $banks = $company->banks;
        $banks_balances = 0;
        foreach ($banks as $bank) {
            $banks_balances = $banks_balances + $bank->bank_balance;
        }
        //  واجمالي قيمة البضاعة التى في المخازن
        $products = Product::where('company_id', $company_id)
            ->where('first_balance', '>', 0)
            ->get();
        $purchase_prices = array();
        foreach ($products as $product) {
            $product_price = $product->purchasing_price;
            $product_balance = $product->first_balance;


            //check if the values are integer or not..
            if (is_int($product_balance) && is_int($product_price)) {
                $total_price = $product_price * $product_balance;
                array_push($purchase_prices, $total_price);
            }
        }
        $total_purchase_prices = array_sum($purchase_prices);

        #---#
        $all_products = Product::where('company_id', $company_id)->get();
        $all_outer_clients = OuterClient::where('company_id', $company_id)->orderBy('created_at', 'DESC')->paginate(5);
        $all_suppliers = Supplier::where('company_id', $company_id)->get();

        $company = Company::FindOrFail($company_id);
        $pos_settings = $company->pos_settings;
        $branch_id = $user->branch_id;
        if ($branch_id != "") {
            $pos_status = PosSetting::where('company_id', $company_id)
                ->where('branch_id', $branch_id)
                ->first();
        } else {
            $pos_status = "none";
        }

        $sale_bills = SaleBill::with('outerClient')
            ->where('company_id', $company_id)
            ->orderBy('created_at', 'DESC')
            ->take(5)->get();

        $cashs = Cash::with('outerClient')
            ->where('company_id', $company_id)
            ->where('amount', '>', 0)
            ->orderBy('created_at', 'DESC')
            ->take(5)->get();

        //get products that out of stock
        $productsOutStock = Product::with('category')->where('company_id', $company_id)
            ->where('first_balance', '<=', 0)
            ->get();


        return view('client.home', compact('user', 'total_purchase_prices', 'safes_balances',
            'banks_balances', 'total_clients_balances', 'company',
            'total_suppliers_balances', 'currency',
            'all_products', 'all_outer_clients', 'all_suppliers', 'pos_settings', 'pos_status',
            'sale_bills', 'productsOutStock', 'cashs'));

    }

    public function go_to_upgrade()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $auth_id = Auth::user()->id;
        $user = Client::findOrFail($auth_id);
        $packages = Package::all();
//        $types = Type::where('type_name', '!=', 'تجربة')->get();
        return view('client.upgrade', compact('company_id', 'company', 'user', 'packages'));
    }

    public function go_to_upgrade2($id)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $auth_id = Auth::user()->id;
        $user = Client::findOrFail($auth_id);
        $package = Package::FindOrFail($id);
        $types = Type::where('type_name', '!=', 'تجربة')
            ->where('package_id', $package->id)
            ->get();
        return view('client.upgrade2', compact('company_id', 'company', 'package', 'user', 'types'));
    }
}
