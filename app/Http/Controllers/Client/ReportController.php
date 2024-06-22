<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BankBuyCash;
use App\Models\BankCash;
use App\Models\BankModification;
use App\Models\BankProcess;
use App\Models\BankSafeTransfer;
use App\Models\BankTransfer;
use App\Models\Branch;
use App\Models\BuyBill;
use App\Models\BuyBillElement;
use App\Models\BuyCash;
use App\Models\Capital;
use App\Models\Cash;
use App\Models\Company;
use App\Models\EmployeeCash;
use App\Models\Expense;
use App\Models\ExtraSettings;
use App\Models\OuterClient;
use App\Models\PosOpen;
use App\Models\PosOpenElement;
use App\Models\Product;
use App\Models\Safe;
use App\Models\SafeBankTransfer;
use App\Models\SafeTransfer;
use App\Models\SaleBill;
use App\Models\SaleBillElement;
use App\Models\Store;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{

    public function reports()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        return view('client.reports.reports', compact('company', 'company_id'));
    }

    public function get_report1()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $outer_clients = $company->outerClients;
        return view('client.reports.report1', compact('outer_clients', 'company', 'company_id'));
    }

    public function post_report1(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $outer_client_id = $request->outer_client_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        if (empty($from_date) || empty($to_date)) {
            if ($outer_client_id == "all") {
                $saleBills = $company->sale_bills;
                $posBills = $company->pos_bills;
            } else {
                $outer_client_k = OuterClient::FindOrFail($outer_client_id);
                $saleBills = $outer_client_k->saleBills;
                $posBills = $outer_client_k->pos_bills;
            }
        } else {
            if ($outer_client_id == "all") {
                $saleBills = SaleBill::where('company_id', $company_id)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();

                $posBills = PosOpen::where('company_id', $company_id)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            } else {
                $outer_client_k = OuterClient::FindOrFail($outer_client_id);
                $saleBills = SaleBill::where('company_id', $company_id)
                    ->where('outer_client_id', $outer_client_k->id)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();

                $posBills = PosOpen::where('company_id', $company_id)
                    ->where('outer_client_id', $outer_client_k->id)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();

            }
        }
        $outer_clients = $company->outerClients;
        return view('client.reports.report1', compact('from_date', 'to_date', 'outer_clients', 'company', 'company_id', 'posBills', 'saleBills', 'currency', 'outer_client_id'));
    }

    public function get_report2()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $products = $company->products;
        return view('client.reports.report2', compact('products', 'company'));
    }

    public function post_report2(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $product_id = $request->product_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        if (empty($from_date) || empty($to_date)) {
            if ($product_id == "all") {
                $saleBills = $company->sale_bills;
                $posBills = $company->pos_bills;
            } else {
                $saleBillElements = SaleBillElement::where('product_id', $product_id)->get();
                $saleBills = array();
                foreach ($saleBillElements as $element) {
                    $saleBill = $element->SaleBill;
                    array_push($saleBills, $saleBill);
                }
                $saleBills = array_unique($saleBills);

                $posBillElements = PosOpenElement::where('product_id', $product_id)->get();
                $posBills = array();
                foreach ($posBillElements as $element) {
                    $posBill = $element->PosOpen;
                    array_push($posBills, $posBill);
                }
                $posBills = array_unique($posBills);

            }
        } else {
            if ($product_id == "all") {
                $saleBills = SaleBill::where('company_id', $company_id)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
                $posBills = PosOpen::where('company_id', $company_id)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            } else {
                $saleBillElements = SaleBillElement::where('company_id', $company_id)
                    ->where('product_id', $product_id)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                    ->get();
                $saleBills = array();
                foreach ($saleBillElements as $element) {
                    $saleBill = $element->SaleBill;
                    array_push($saleBills, $saleBill);
                }
                $saleBills = array_unique($saleBills);


                $posBillElements = PosOpenElement::where('company_id', $company_id)
                    ->where('product_id', $product_id)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
                $posBills = array();
                foreach ($posBillElements as $element) {
                    $posBill = $element->PosOpen;
                    array_push($posBills, $posBill);
                }
                $posBills = array_unique($posBills);

            }
        }
        $products = $company->products;
        return view('client.reports.report2',
            compact('from_date', 'to_date', 'products', 'company', 'company_id', 'saleBills', 'posBills', 'currency', 'product_id'));
    }

    public function get_report3()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $suppliers = $company->suppliers;
        return view('client.reports.report3', compact('suppliers', 'company'));
    }

    public function post_report3(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $supplier_id = $request->supplier_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        if (empty($from_date) || empty($to_date)) {
            if ($supplier_id == "all") {
                $buyBills = $company->buy_bills;
            } else {
                $supplier_k = Supplier::FindOrFail($supplier_id);
                $buyBills = $supplier_k->buyBills;
            }
        } else {
            if ($supplier_id == "all") {
                $buyBills = BuyBill::where('company_id', $company_id)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            } else {
                $supplier_k = Supplier::FindOrFail($supplier_id);
                $buyBills = BuyBill::where('company_id', $company_id)
                    ->where('supplier_id', $supplier_k->id)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            }
        }

        $suppliers = $company->suppliers;
        return view('client.reports.report3', compact('from_date', 'to_date', 'suppliers', 'company', 'company_id', 'buyBills', 'currency', 'supplier_id'));
    }

    public function get_report4()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $products = $company->products;
        return view('client.reports.report4', compact('products', 'company'));
    }

    public function post_report4(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $product_id = $request->product_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        if (empty($from_date) || empty($to_date)) {
            if ($product_id == "all") {
                $buyBills = $company->buy_bills;
            } else {
                $buyBillElements = buyBillElement::where('product_id', $product_id)->get();
                $buyBills = array();
                foreach ($buyBillElements as $element) {
                    $buyBill = $element->buyBill;
                    array_push($buyBills, $buyBill);
                }
                $buyBills = array_unique($buyBills);
            }
        } else {
            if ($product_id == "all") {
                $buyBills = BuyBill::where('company_id', $company_id)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            } else {
                $buyBillElements = buyBillElement::where('company_id', $company_id)
                    ->where('product_id', $product_id)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                    ->get();
                $buyBills = array();
                foreach ($buyBillElements as $element) {
                    $buyBill = $element->buyBill;
                    array_push($buyBills, $buyBill);
                }
                $buyBills = array_unique($buyBills);
            }
        }
        $products = $company->products;
        return view('client.reports.report4',
            compact('from_date', 'to_date', 'products', 'company', 'company_id', 'buyBills', 'currency', 'product_id'));
    }

    public function get_report5()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $outer_clients = $company->outerClients;
        return view('client.reports.report5', compact('outer_clients', 'company'));
    }

    public function post_report5(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $outer_client_id = $request->outer_client_id;
        if ($outer_client_id == "all") {
            $outerClients = $company->outerClients;
            $balances = array();
            foreach ($outerClients as $outer_client) {
                $client_balance = $outer_client->prev_balance;
                array_push($balances, $client_balance);
            }
            $total_balances = array_sum($balances);
        } else {
            $outerClients = OuterClient::where('id', $outer_client_id)->get();
            $total_balances = "";
        }
        $outer_clients = $company->outerClients;
        return view('client.reports.report5',
            compact('outerClients', 'company', 'total_balances', 'company_id', 'outer_clients', 'currency', 'outer_client_id'));
    }

    public function get_report6()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $suppliers = $company->suppliers;
        return view('client.reports.report6', compact('suppliers', 'company'));
    }

    public function post_report6(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $supplier_id = $request->supplier_id;
        if ($supplier_id == "all") {
            $Suppliers = $company->suppliers;
            $balances = array();
            foreach ($Suppliers as $supplier) {
                $supplier_balance = $supplier->prev_balance;
                array_push($balances, $supplier_balance);
            }
            $total_balances = array_sum($balances);
        } else {
            $Suppliers = Supplier::where('id', $supplier_id)->get();
            $total_balances = "";
        }
        $suppliers = $company->suppliers;
        return view('client.reports.report6',
            compact('Suppliers', 'company', 'total_balances', 'company_id', 'suppliers', 'currency', 'supplier_id'));
    }

    public function get_report7()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $safes = $company->safes;
        return view('client.reports.report7', compact('safes', 'company'));
    }

    public function post_report7(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $safe_id = $request->safe_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        if ($safe_id == "all") {
            if (empty($from_date) || empty($to_date)) {
                $capitals = $company->capitals;
            } else {
                $capitals = Capital::where('company_id', $company_id)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            }
        } else {
            if (empty($from_date) || empty($to_date)) {
                $capitals = Capital::where('safe_id', $safe_id)->get();
            } else {
                $capitals = Capital::where('safe_id', $safe_id)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            }
        }
        $capital_amounts = 0;
        foreach ($capitals as $capital) {
            $capital_amounts = $capital_amounts + $capital->amount;
        }
        $safes = $company->safes;
        return view('client.reports.report7',
            compact('safes', 'capital_amounts', 'company', 'capitals', 'company_id', 'from_date', 'to_date', 'currency', 'safe_id'));
    }

    public function get_report8()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $products = $company->products;
        return view('client.reports.report8', compact('products', 'company'));
    }

    public function post_report8(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $product_id = $request->product_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        if ($product_id == "all") {
            if (empty($from_date) || empty($to_date)) {
                $buyBills = $company->buy_bills;
            } else {
                $buyBills = BuyBill::where('company_id', $company_id)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            }
        } else {

            if (empty($from_date) || empty($to_date)) {
                $buyBillElements = BuyBillElement::where('product_id', $product_id)->get();
                $buyBills = array();
                foreach ($buyBillElements as $element) {
                    $buyBill = $element->buyBill;
                    array_push($buyBills, $buyBill);
                }
                $buyBills = array_unique($buyBills);
            } else {
                $buyBillElements = BuyBillElement::where('product_id', $product_id)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
                $buyBills = array();
                foreach ($buyBillElements as $element) {
                    $buyBill = $element->buyBill;
                    array_push($buyBills, $buyBill);
                }
                $buyBills = array_unique($buyBills);
            }
        }
        $products = $company->products;
        return view('client.reports.report8',
            compact('products', 'company', 'buyBills', 'company_id', 'from_date', 'to_date', 'currency', 'product_id'));
    }

    public function get_report9()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $products = $company->products;
        return view('client.reports.report9', compact('products', 'company'));
    }

    public function post_report9(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $product_id = $request->product_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        if ($product_id == "all") {
            if (empty($from_date) || empty($to_date)) {
                $buyBills = $company->buy_bills;
            } else {
                $buyBills = BuyBill::where('company_id', $company_id)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            }
        } else {

            if (empty($from_date) || empty($to_date)) {
                $buyBillElements = BuyBillElement::where('product_id', $product_id)->get();
                $buyBills = array();
                foreach ($buyBillElements as $element) {
                    $buyBill = $element->buyBill;
                    array_push($buyBills, $buyBill);
                }
                $buyBills = array_unique($buyBills);
            } else {
                $buyBillElements = BuyBillElement::where('product_id', $product_id)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
                $buyBills = array();
                foreach ($buyBillElements as $element) {
                    $buyBill = $element->buyBill;
                    array_push($buyBills, $buyBill);
                }
                $buyBills = array_unique($buyBills);
            }
        }
        $products = $company->products;
        return view('client.reports.report9',
            compact('products', 'company', 'buyBills', 'company_id', 'from_date', 'to_date', 'currency', 'product_id'));
    }


    public function get_report10()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $products = $company->products;
        return view('client.reports.report10', compact('products', 'company'));
    }

    public function post_report10(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $product_id = $request->product_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        if ($product_id == "all") {
            if (empty($from_date) || empty($to_date)) {
                $saleBills = $company->sale_bills;
                $posBills = $company->pos_bills;
            } else {
                $saleBills = SaleBill::where('company_id', $company_id)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
                $posBills = PosOpen::where('company_id', $company_id)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            }
        } else {
            if (empty($from_date) || empty($to_date)) {
                $saleBillElements = SaleBillElement::where('product_id', $product_id)->get();
                $saleBills = array();
                foreach ($saleBillElements as $element) {
                    $saleBill = $element->saleBill;
                    array_push($saleBills, $saleBill);
                }
                $saleBills = array_unique($saleBills);

                $posBillElements = PosOpenElement::where('product_id', $product_id)->get();
                $posBills = array();
                foreach ($posBillElements as $element) {
                    $posBill = $element->posBill;
                    array_push($posBills, $posBill);
                }
                $posBills = array_unique($posBills);
            } else {
                $saleBillElements = SaleBillElement::where('product_id', $product_id)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
                $saleBills = array();
                foreach ($saleBillElements as $element) {
                    $saleBill = $element->saleBill;
                    array_push($saleBills, $saleBill);
                }
                $saleBills = array_unique($saleBills);

                $posBillElements = PosOpenElement::where('product_id', $product_id)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
                $posBills = array();
                foreach ($posBillElements as $element) {
                    $posBill = $element->posBill;
                    array_push($posBills, $posBill);
                }
                $posBills = array_unique($posBills);
            }
        }
        $products = $company->products;
        return view('client.reports.report10',
            compact('products', 'company', 'saleBills','posBills', 'company_id', 'from_date', 'to_date', 'currency', 'product_id'));
    }

    public function get_report11()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $outer_clients = $company->outerClients;
        return view('client.reports.report11', compact('outer_clients', 'company'));
    }


    public function post_report11(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $outer_client_id = $request->outer_client_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        if ($outer_client_id == "all") {
            if (empty($from_date) || empty($to_date)) {
                $cashs = Cash::where('company_id', $company_id)
                    ->where('amount', '>', 0)->get();
            } else {
                $cashs = Cash::where('company_id', $company_id)
                    ->where('amount', '>', 0)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            }
        } else {
            if (empty($from_date) || empty($to_date)) {
                $cashs = Cash::where('outer_client_id', $outer_client_id)->where('amount', '>', 0)->get();
            } else {
                $cashs = Cash::where('outer_client_id', $outer_client_id)
                    ->where('amount', '>', 0)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            }
        }
        $outer_clients = $company->outerClients;
        return view('client.reports.report11',
            compact('outer_clients', 'company', 'cashs', 'company_id', 'from_date', 'to_date', 'currency', 'outer_client_id'));
    }


    public function get_report12()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $suppliers = $company->suppliers;
        return view('client.reports.report12', compact('suppliers', 'company'));
    }


    public function post_report12(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $supplier_id = $request->supplier_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        if ($supplier_id == "all") {
            if (empty($from_date) || empty($to_date)) {
                $buy_cashs = BuyCash::where('company_id', $company_id)
                    ->where('amount', '>', 0)->get();
            } else {
                $buy_cashs = BuyCash::where('company_id', $company_id)
                    ->where('amount', '>', 0)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            }
        } else {
            if (empty($from_date) || empty($to_date)) {
                $buy_cashs = BuyCash::where('supplier_id', $supplier_id)->where('amount', '>', 0)->get();
            } else {
                $buy_cashs = BuyCash::where('supplier_id', $supplier_id)
                    ->where('amount', '>', 0)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            }
        }
        $suppliers = $company->suppliers;
        return view('client.reports.report12',
            compact('suppliers', 'company', 'buy_cashs', 'company_id', 'from_date', 'to_date', 'currency', 'supplier_id'));
    }

    public function get_report13()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        return view('client.reports.report13', compact('company'));
    }

    public function post_report13(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        if (empty($from_date) || empty($to_date)) {
            $sale_bills = $company->sale_bills;
            $pos_bills = $company->pos_bills;
        } else {
            $sale_bills = SaleBill::where('company_id', $company_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            $pos_bills = PosOpen::where('company_id', $company_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
        }
        return view('client.reports.report13',
            compact('company', 'sale_bills','pos_bills', 'company_id', 'from_date', 'to_date', 'currency'));
    }

    public function get_report14()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $fixed_expenses = $company->fixed_expenses;
        return view('client.reports.report14', compact('fixed_expenses', 'company'));
    }

    public function post_report14(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $fixed_expense = $request->fixed_expense;
        if ($fixed_expense == "all") {
            if (empty($from_date) || empty($to_date)) {
                $expenses = $company->expenses;
            } else {
                $expenses = Expense::where('company_id', $company_id)
                    ->whereBetween('date', [$from_date, $to_date])->get();
            }
        } else {
            if (empty($from_date) || empty($to_date)) {
                $expenses = Expense::where('fixed_expense', $fixed_expense)->get();
            } else {
                $expenses = Expense::where('fixed_expense', $fixed_expense)
                    ->whereBetween('date', [$from_date, $to_date])->get();
            }
        }
        $fixed_expenses = $company->fixed_expenses;
        return view('client.reports.report14',
            compact('company', 'expenses', 'fixed_expenses', 'company_id', 'from_date', 'fixed_expense', 'to_date', 'currency'));
    }

    public function get_report15()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $banks = $company->banks;
        return view('client.reports.report15', compact('banks', 'company'));
    }

    public function post_report15(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $bank_id = $request->bank_id;
        if (empty($from_date) || empty($to_date)) {
            $bank_k = Bank::FindOrFail($bank_id);
            $bank_modifications = BankModification::where('bank_id', $bank_id)->get();
            $bank_processes = BankProcess::where('bank_id', $bank_id)->get();
            $bank_transfers = BankTransfer::where('withdrawal_bank', $bank_id)
                ->orwhere('deposit_bank', $bank_id)
                ->get();
            $bank_safe_transfers = BankSafeTransfer::where('bank_id', $bank_id)->get();
            $safe_bank_transfers = SafeBankTransfer::where('bank_id', $bank_id)->get();

            $bank_cash = BankCash::where('bank_id', $bank_id)->get();
            $bank_buy_cash = BankBuyCash::where('bank_id', $bank_id)->get();
        } else {
            $bank_k = Bank::FindOrFail($bank_id);
            $bank_modifications = BankModification::where('bank_id', $bank_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                ->get();
            $bank_processes = BankProcess::where('bank_id', $bank_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                ->get();
            $bank_transfers = BankTransfer::where('withdrawal_bank', $bank_id)
                ->orwhere('deposit_bank', $bank_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                ->get();
            $bank_safe_transfers = BankSafeTransfer::where('bank_id', $bank_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                ->get();
            $safe_bank_transfers = SafeBankTransfer::where('bank_id', $bank_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                ->get();

            $bank_cash = BankCash::where('bank_id', $bank_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                ->get();
            $bank_buy_cash = BankBuyCash::where('bank_id', $bank_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                ->get();
        }
        $banks = $company->banks;
        return view('client.reports.report15',
            compact('company', 'banks', 'bank_k', 'bank_modifications',
                'bank_processes', 'bank_transfers', 'bank_cash', 'bank_buy_cash',
                'company_id', 'from_date', 'safe_bank_transfers', 'bank_safe_transfers', 'bank_id', 'to_date', 'currency'));
    }

    public function get_report16()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        return view('client.reports.report16', compact('company'));
    }

    public function post_report16(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        if (empty($from_date) || empty($to_date)) {
            $outerClients = $company->outerClients;
            $suppliers = $company->suppliers;
            $sale_bills = $company->sale_bills;
            $pos_bills = $company->pos_bills;
            $buy_bills = $company->buy_bills;
            $cashs = $company->cashs;
            $buy_cashs = $company->buy_cashs;
            $capitals = $company->capitals;
            $expenses = $company->expenses;
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
                $total_price = $product_price * $product_balance;
                array_push($purchase_prices, $total_price);
            }
            $total_purchase_prices = array_sum($purchase_prices);
        } else {
            $outerClients = OuterClient::where('company_id', $company_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                ->get();
            $suppliers = Supplier::where('company_id', $company_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                ->get();
            $sale_bills = SaleBill::where('company_id', $company_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                ->get();
            $pos_bills = PosOpen::where('company_id', $company_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                ->get();
            $buy_bills = BuyBill::where('company_id', $company_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                ->get();;
            $cashs = Cash::where('company_id', $company_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                ->get();
            $buy_cashs = BuyCash::where('company_id', $company_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                ->get();
            $capitals = Capital::where('company_id', $company_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                ->get();
            $expenses = Expense::where('company_id', $company_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                ->get();
            // اجمالى الخزن
            $safes = Safe::where('company_id', $company_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                ->get();
            $safes_balances = 0;
            foreach ($safes as $safe) {
                $safes_balances = $safes_balances + $safe->balance;
            }
            // اجمالى البنوك
            $banks = Bank::where('company_id', $company_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                ->get();
            $banks_balances = 0;
            foreach ($banks as $bank) {
                $banks_balances = $banks_balances + $bank->bank_balance;
            }
            //  واجمالي قيمة البضاعة التى في المخازن
            $products = Product::where('company_id', $company_id)
                ->where('first_balance', '>', 0)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                ->get();
            $purchase_prices = array();
            foreach ($products as $product) {
                $product_price = $product->purchasing_price;
                $product_balance = $product->first_balance;
                $total_price = $product_price * $product_balance;
                array_push($purchase_prices, $total_price);
            }
            $total_purchase_prices = array_sum($purchase_prices);
        }
        $result = "result";
        return view('client.reports.report16',
            compact('from_date', 'to_date', 'company', 'company_id', 'safes_balances', 'banks_balances',
                'total_purchase_prices', 'result', 'outerClients', 'suppliers', 'sale_bills', 'cashs', 'buy_cashs',
                'capitals', 'expenses', 'buy_bills', 'currency','pos_bills'));
    }

    public function get_report17()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        return view('client.reports.report17', compact('company'));
    }

    public function post_report17(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $type = $request->type;
        if (empty($from_date) && empty($to_date)) {
            $cashs = $company->cashs;
            $buy_cashs = $company->buy_cashs;
            $capitals = $company->capitals;
            $expenses = $company->expenses;
        } else {
            $cashs = Cash::where('company_id', $company_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            $buy_cashs = BuyCash::where('company_id', $company_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            $capitals = Capital::where('company_id', $company_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            $expenses = Expense::where('company_id', $company_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
        }
        // اجمالى الخزن
        $safes = $company->safes;
        $safes_balances = 0;
        foreach ($safes as $safe) {
            $safes_balances = $safes_balances + $safe->balance;
        }
        return view('client.reports.report17',
            compact('company', 'company_id', 'safes_balances', 'type', 'from_date', 'cashs', 'buy_cashs', 'expenses', 'capitals', 'to_date', 'currency'));
    }

    public function get_report18()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        return view('client.reports.report18', compact('company'));
    }

    public function post_report18(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $count = $request->count;
        $submit = $request->submit;

        $from_date = $request->from_date;
        $to_date = $request->to_date;
        if (empty($from_date) || empty($to_date)) {
            if (isset($submit) && !empty($submit) && $submit == "best_sales") {
                $products = $company->products;
                $products_arr = array();
                $count_arr = array();
                foreach ($products as $product) {
                    $sum = 0;
                    $product_id = $product->id;
                    array_push($products_arr, $product_id);
                    $sel = SaleBillElement::where('product_id', $product_id)
                        ->sum('quantity');
                    $sum = $sum + $sel;
                    array_push($count_arr, $sum);
                }
                $counter = count($products_arr);
                $final_sales = array();
                for ($j = 0; $j < $counter; $j++) {
                    $new_array = array('product_id' => $products_arr[$j], 'count' => $count_arr[$j]);
                    array_push($final_sales, $new_array);
                }
                array_multisort(array_column($final_sales, 'count'), SORT_DESC, SORT_NATURAL | SORT_FLAG_CASE, $final_sales);

                return view('client.reports.report18',
                    compact('from_date', 'to_date', 'company', 'count', 'submit', 'count_arr', 'products_arr', 'final_sales', 'company_id', 'currency'));
            } elseif (isset($submit) && !empty($submit) && $submit == "best_profits") {
                $products = $company->products;
                $products_arr = array();
                $profit_arr = array();
                foreach ($products as $product) {
                    $sum = 0;
                    $quantity_prices = 0;
                    $product_id = $product->id;
                    array_push($products_arr, $product_id);
                    $sel = SaleBillElement::where('product_id', $product_id)
                        ->sum('quantity');
                    $sum = $sum + $sel;

                    $quantity_price = SaleBillElement::where('product_id', $product_id)
                        ->sum('quantity_price');
                    $quantity_prices = $quantity_prices + $quantity_price;

                    $real_price = $product->purchasing_price * $sum;
                    $profit = $quantity_prices - $real_price;
                    array_push($profit_arr, $profit);
                }
                $counter = count($products_arr);
                $final_profits = array();
                for ($j = 0; $j < $counter; $j++) {
                    $new_array = array('product_id' => $products_arr[$j], 'profit' => $profit_arr[$j]);
                    array_push($final_profits, $new_array);
                }
                array_multisort(array_column($final_profits, 'profit'), SORT_DESC, SORT_NATURAL | SORT_FLAG_CASE, $final_profits);
                return view('client.reports.report18',
                    compact('from_date', 'to_date', 'company', 'count', 'submit', 'profit_arr', 'final_profits', 'products_arr', 'company_id', 'currency'));
            }
        } else {
            if (isset($submit) && !empty($submit) && $submit == "best_sales") {
                $products = $company->products;
                $products_arr = array();
                $count_arr = array();
                foreach ($products as $product) {
                    $sum = 0;
                    $product_id = $product->id;
                    array_push($products_arr, $product_id);
                    $sel = SaleBillElement::where('product_id', $product_id)
                        ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                        ->sum('quantity');
                    $sum = $sum + $sel;
                    array_push($count_arr, $sum);
                }
                $counter = count($products_arr);
                $final_sales = array();
                for ($j = 0; $j < $counter; $j++) {
                    $new_array = array('product_id' => $products_arr[$j], 'count' => $count_arr[$j]);
                    array_push($final_sales, $new_array);
                }
                array_multisort(array_column($final_sales, 'count'), SORT_DESC, SORT_NATURAL | SORT_FLAG_CASE, $final_sales);

                return view('client.reports.report18',
                    compact('from_date', 'to_date', 'company', 'count', 'submit', 'count_arr', 'products_arr', 'final_sales', 'company_id', 'currency'));
            } elseif (isset($submit) && !empty($submit) && $submit == "best_profits") {
                $products = $company->products;
                $products_arr = array();
                $profit_arr = array();
                foreach ($products as $product) {
                    $sum = 0;
                    $quantity_prices = 0;
                    $product_id = $product->id;
                    array_push($products_arr, $product_id);
                    $sel = SaleBillElement::where('product_id', $product_id)
                        ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                        ->sum('quantity');
                    $sum = $sum + $sel;

                    $quantity_price = SaleBillElement::where('product_id', $product_id)
                        ->sum('quantity_price');
                    $quantity_prices = $quantity_prices + $quantity_price;

                    $real_price = $product->purchasing_price * $sum;
                    $profit = $quantity_prices - $real_price;
                    array_push($profit_arr, $profit);
                }
                $counter = count($products_arr);
                $final_profits = array();
                for ($j = 0; $j < $counter; $j++) {
                    $new_array = array('product_id' => $products_arr[$j], 'profit' => $profit_arr[$j]);
                    array_push($final_profits, $new_array);
                }
                array_multisort(array_column($final_profits, 'profit'), SORT_DESC, SORT_NATURAL | SORT_FLAG_CASE, $final_profits);
                return view('client.reports.report18',
                    compact('from_date', 'to_date', 'company', 'count', 'submit', 'profit_arr', 'final_profits', 'products_arr', 'company_id', 'currency'));
            }
        }
    }

    public function get_report19()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $stores = $company->stores;
        $products = $company->products;
        return view('client.reports.report19', compact('stores', 'products', 'company_id', 'company'));
    }

    public function post_report19(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $stores = $company->stores;
        $products = $company->products;
        $product_id = $request->product_id;
        $product_k = Product::FindOrFail($product_id);
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        if (empty($from_date) || empty($to_date)) {
            $buy_elements = BuyBillElement::where('product_id', $product_k->id)->get();
            $total_buy_elements = 0;
            foreach ($buy_elements as $buy_element) {
                $total_buy_elements = $total_buy_elements + $buy_element->quantity;
            }
            $sale_elements = SaleBillElement::where('product_id', $product_k->id)->get();
            $total_sale_elements = 0;
            foreach ($sale_elements as $sale_element) {
                $total_sale_elements = $total_sale_elements + $sale_element->quantity;
            }
            $total_sold = $total_sale_elements;
        } else {
            $buy_elements = BuyBillElement::where('product_id', $product_k->id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                ->get();
            $total_buy_elements = 0;
            foreach ($buy_elements as $buy_element) {
                $total_buy_elements = $total_buy_elements + $buy_element->quantity;
            }
            $sale_elements = SaleBillElement::where('product_id', $product_k->id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                ->get();
            $total_sale_elements = 0;
            foreach ($sale_elements as $sale_element) {
                $total_sale_elements = $total_sale_elements + $sale_element->quantity;
            }
            $total_sold = $total_sale_elements;

        }

        return view('client.reports.report19', compact('from_date', 'to_date', 'stores', 'product_id', 'products', 'total_sold',
            'total_buy_elements', 'product_k', 'company_id', 'company'));
    }

    public function get_report20()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $safes = $company->safes;
        return view('client.reports.report20', compact('safes', 'company_id', 'company'));
    }

    public function post_report20(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        if (empty($from_date) || empty($to_date)) {
            $safes = $company->safes;
            $safe_id = $request->safe_id;
            $safe_k = Safe::FindOrFail($safe_id);
            $bank_safe_transfers = BankSafeTransfer::where('safe_id', $safe_id)->get();
            $safe_bank_transfers = SafeBankTransfer::where('safe_id', $safe_id)->get();
            $safes_transfers = SafeTransfer::where('from_safe', $safe_id)->orwhere('to_safe', $safe_id)->get();
            $buy_cashs = BuyCash::where('safe_id', $safe_id)->get();
            $capitals = Capital::where('safe_id', $safe_id)->get();
            $cashs = Cash::where('safe_id', $safe_id)->get();
            $employees_cashs = EmployeeCash::where('safe_id', $safe_id)->get();
            $expenses = Expense::where('safe_id', $safe_id)->get();
        } else {
            $safes = $company->safes;
            $safe_id = $request->safe_id;
            $safe_k = Safe::FindOrFail($safe_id);
            $bank_safe_transfers = BankSafeTransfer::where('safe_id', $safe_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                ->get();
            $safe_bank_transfers = SafeBankTransfer::where('safe_id', $safe_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                ->get();
            $safes_transfers = SafeTransfer::where('from_safe', $safe_id)->orwhere('to_safe', $safe_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                ->get();
            $buy_cashs = BuyCash::where('safe_id', $safe_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                ->get();
            $capitals = Capital::where('safe_id', $safe_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                ->get();
            $cashs = Cash::where('safe_id', $safe_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                ->get();
            $employees_cashs = EmployeeCash::where('safe_id', $safe_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                ->get();
            $expenses = Expense::where('safe_id', $safe_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                ->get();
        }
        return view('client.reports.report20',
            compact('from_date', 'to_date', 'safes', 'safes_transfers', 'safe_id', 'safe_k', 'company_id', 'company', 'bank_safe_transfers', 'safe_bank_transfers'
                , 'capitals', 'cashs', 'employees_cashs', 'buy_cashs', 'expenses'));
    }

    public function get_report21()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $branches = $company->branches;
        return view('client.reports.report21', compact('branches', 'company_id', 'company'));
    }

    public function post_report21(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $branches = $company->branches;
        $branch_id = $request->branch_id;
        $branch_k = Branch::FindOrFail($branch_id);
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $stores = Store::where('branch_id', $branch_id)->get();
        $safes = Safe::where('branch_id', $branch_id)->get();
        $stores_ids = array();
        $safes_ids = array();

        foreach ($stores as $store) {
            array_push($stores_ids, $store->id);
        }
        foreach ($safes as $safe) {
            array_push($safes_ids, $safe->id);
        }
        $bank_safe_transfers = collect(new BankSafeTransfer);
        $safe_bank_transfers = collect(new SafeBankTransfer);
        $buy_cashs = collect(new BuyCash);
        $capitals = collect(new Capital);
        $cashs = collect(new Cash);
        $employees_cashs = collect(new EmployeeCash);
        $expenses = collect(new Expense);
        $products_k = collect(new Product);

        if (!$safes->isEmpty()) {
            if (empty($from_date) || empty($to_date)) {
                $bank_safe_transfers = BankSafeTransfer::whereIn('safe_id', $safes_ids)->get();
                $safe_bank_transfers = SafeBankTransfer::whereIn('safe_id', $safes_ids)->get();
                $buy_cashs = BuyCash::whereIn('safe_id', $safes_ids)->get();
                $capitals = Capital::whereIn('safe_id', $safes_ids)->get();
                $cashs = Cash::whereIn('safe_id', $safes_ids)->get();
                $employees_cashs = EmployeeCash::whereIn('safe_id', $safes_ids)->get();
                $expenses = Expense::whereIn('safe_id', $safes_ids)->get();
            } else {
                $bank_safe_transfers = BankSafeTransfer::whereIn('safe_id', $safes_ids)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                    ->get();
                $safe_bank_transfers = SafeBankTransfer::whereIn('safe_id', $safes_ids)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                    ->get();
                $buy_cashs = BuyCash::whereIn('safe_id', $safes_ids)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                    ->get();
                $capitals = Capital::whereIn('safe_id', $safes_ids)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                    ->get();
                $cashs = Cash::whereIn('safe_id', $safes_ids)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                    ->get();
                $employees_cashs = EmployeeCash::whereIn('safe_id', $safes_ids)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                    ->get();
                $expenses = Expense::whereIn('safe_id', $safes_ids)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                    ->get();
            }

        }

        if (!$stores->isEmpty()) {
            if (empty($from_date) || empty($to_date)) {
                $products_k = Product::whereIn('store_id', $stores_ids)
                    ->get();
            } else {
                $products_k = Product::whereIn('store_id', $stores_ids)
                    ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])
                    ->get();
            }
        }

        return view('client.reports.report21',
            compact('from_date', 'to_date', 'branch_id', 'branch_k', 'company_id', 'company',
                'bank_safe_transfers', 'safe_bank_transfers', 'branches', 'products_k'
                , 'capitals', 'cashs', 'employees_cashs', 'buy_cashs', 'expenses'));
    }

    public function get_report22()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        return view('client.reports.report22', compact('company_id', 'company'));
    }

    public function post_report22(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        if (empty($from_date) || empty($to_date)) {
            $sale_bills = $company->sale_bills;
            $pos_bills = $company->pos_bills;
            $buy_bills = $company->buy_bills;
        } else {
            $sale_bills = SaleBill::where('company_id', $company_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            $pos_bills = PosOpen::where('company_id', $company_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            $buy_bills = BuyBill::where('company_id', $company_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
        }
        return view('client.reports.report22',
            compact('from_date', 'currency', 'to_date', 'company_id', 'company', 'sale_bills', 'pos_bills', 'buy_bills'));
    }
}
