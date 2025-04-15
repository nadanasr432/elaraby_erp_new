<?php

namespace App\Http\Controllers\Client;

use Carbon\Carbon;
use App\Models\Cash;
use App\Models\Gift;
use App\Models\BuyBill;
use App\Models\BuyCash;
use App\Models\Company;
use App\Models\BankCash;
use App\Models\Employee;
use App\Models\SaleBill;
use App\Models\Supplier;
use App\Models\Quotation;
use App\Models\Bondclient;
use App\Models\BankBuyCash;
use App\Models\OuterClient;
use App\Models\EmployeeCash;
use Illuminate\Http\Request;
use App\Models\BuyBillReturn;
use App\Models\ExtraSettings;
use App\Models\SaleBillReturn;
use App\Mail\sendingClientSummary;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Mail\sendingSupplierSummary;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ClientsSummaryRequest;
use App\Http\Requests\EmployeesSummaryRequest;
use App\Http\Requests\SuppliersSummaryRequest;

class SummaryController extends Controller
{
    public function get_clients_summary()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $outer_clients = $company->outerClients;
        return view('client.summary.clients', compact('company', 'company_id', 'outer_clients'));
    }
    public function get_clients_summary_new()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $outer_clients = $company->outerClients;
        return view('client.summary.clients_new', compact('company', 'company_id', 'outer_clients'));
    }
    public function get_clients_summary_new3()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $outer_clients = $company->outerClients;
        return view('client.summary.clients_new3', compact('company', 'company_id', 'outer_clients'));
    }

    public function post_clients_summary(ClientsSummaryRequest $request)
    {
        // Initialize variables
        $outer_client_id = $request->outer_client_id;
        $from_date = $request->from_date ? Carbon::parse($request->from_date) : null;
        $to_date = $request->to_date ? Carbon::parse($request->to_date) : null;
        $submit = $request->submit;
        $today = Carbon::today();

        // Find the client
        $outer_client_k = OuterClient::FindOrFail($outer_client_id);

        // Initialize collections
        $gifts = collect();
        $quotations = collect();
        $bonds = collect();
        $saleBills = collect();
        $cashs = collect();
        $borrows = collect();
        $bankcashs = collect();
        $returns = collect();

        // Determine the type of summary
        if ($submit === "all") {
            // Summary for all data
            if (is_null($from_date) && is_null($to_date)) {
                // No date filters
                $gifts = $outer_client_k->gifts;
                $quotations = $outer_client_k->quotations;
                $bonds = Bondclient::where('client', $outer_client_k->client_name)
                ->where('company_id', $outer_client_k->company_id)
                ->get();

                $saleBills = $outer_client_k->saleBills->where('status', 'done');
                $cashs = Cash::where('outer_client_id', $outer_client_id)->where('amount', '>', 0)->get();
                $borrows = Cash::where('outer_client_id', $outer_client_id)->where('amount', '<', 0)->get();
                $bankcashs = $outer_client_k->bankcashs;
                $returns = $outer_client_k->saleBillReturns;
            } else {
                // With date filters
                $gifts = Gift::where('outer_client_id', $outer_client_id)
                    ->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->get();
                $quotations = Quotation::where('outer_client_id', $outer_client_id)
                    ->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->get();
                $bonds = Bondclient::where('client', $outer_client_k->client_name)
                    ->where('company_id', $outer_client_k->company_id)
                    ->whereDate('created_at', '>=', $from_date)
                    ->whereDate('created_at', '<=', $to_date)
                    ->get();

                $saleBills = SaleBill::where('status', 'done')->where('outer_client_id', $outer_client_id)
                    ->whereDate('date', '>=', $from_date->startOfDay())
                    ->whereDate('date', '<=', $to_date->endOfDay())->get();
                //  dd($saleBills);
                $cashs = Cash::where('outer_client_id', $outer_client_id)
                    ->where('amount', '>', 0)
                    ->whereDate('created_at', '>=', $from_date)
                    ->whereDate('created_at', '<=', $to_date)->get();
                $borrows = Cash::where('outer_client_id', $outer_client_id)
                    ->where('amount', '<', 0)
                    ->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->get();
                $bankcashs = BankCash::where('outer_client_id', $outer_client_id)
                    ->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->get();
                $returns = SaleBillReturn::where('outer_client_id', $outer_client_id)
                    ->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->get();
            }
        } elseif ($submit === "today") {
            // Summary for today
            $gifts = Gift::where('outer_client_id', $outer_client_id)
                ->whereDate('created_at', $today)->get();
            $quotations = Quotation::where('outer_client_id', $outer_client_id)
                ->whereDate('created_at', $today)->get();
            $saleBills = SaleBill::where('outer_client_id', $outer_client_id)
                ->whereDate('created_at', $today)->get();
            $cashs = Cash::where('outer_client_id', $outer_client_id)
                ->where('amount', '>', 0)
                ->whereDate('created_at', $today)->get();
            $borrows = Cash::where('outer_client_id', $outer_client_id)
                ->where('amount', '<', 0)
                ->whereDate('created_at', $today)->get();
            $bankcashs = BankCash::where('outer_client_id', $outer_client_id)
                ->whereDate('created_at', $today)->get();
            $returns = SaleBillReturn::where('outer_client_id', $outer_client_id)
                ->whereDate('created_at', $today)->get();
            $bonds = Bondclient::where('client', $outer_client_k->client_name)
                ->where('company_id', $outer_client_k->company_id)
                ->whereDate('created_at', $today)->get();
        }

        // Return the view with the gathered data
        return view('client.summary.clients_post', compact(
            'returns',
            'from_date',
            'to_date',
            'outer_client_k',
            'gifts',
            'quotations',
            'saleBills',
            'cashs',
            'bankcashs',
            'borrows',
            'bonds'
        ));
    }
    public function post_clients_summary_new(ClientsSummaryRequest $request)
    {
        // Initialize variables
        $outer_client_id = $request->outer_client_id;
        $from_date = $request->from_date ? Carbon::parse($request->from_date) : null;
        $to_date = $request->to_date ? Carbon::parse($request->to_date) : null;
        $submit = $request->submit;
        $today = Carbon::today();

        // Find the client
        $outer_client_k = OuterClient::FindOrFail($outer_client_id);

        // Initialize collections
        $gifts = collect();
        $quotations = collect();
        $bonds = collect();
        $saleBills = collect();
        $cashs = collect();
        $borrows = collect();
        $bankcashs = collect();
        $returns = collect();

        // Determine the type of summary
        if ($submit === "all") {
            // Summary for all data
            if (is_null($from_date) && is_null($to_date)) {
                // No date filters
                $gifts = $outer_client_k->gifts;
                $quotations = $outer_client_k->quotations;
                $bonds = Bondclient::where('client', $outer_client_k->client_name)
                    ->where('company_id', $outer_client_k->company_id)
                    ->get();

                $saleBills = $outer_client_k->saleBills->where('status', 'done');
                $cashs = Cash::where('outer_client_id', $outer_client_id)->where('amount', '>', 0)->get();
                $borrows = Cash::where('outer_client_id', $outer_client_id)->where('amount', '<', 0)->get();
                $bankcashs = $outer_client_k->bankcashs;
                $returns = $outer_client_k->saleBillReturns;
            } else {
                // With date filters
                $gifts = Gift::where('outer_client_id', $outer_client_id)
                    ->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->get();
                $quotations = Quotation::where('outer_client_id', $outer_client_id)
                    ->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->get();
                $bonds = Bondclient::where('client', $outer_client_k->client_name)
                    ->where('company_id', $outer_client_k->company_id)
                    ->whereDate('created_at', '>=', $from_date)
                    ->whereDate('created_at', '<=', $to_date)
                    ->get();

                $saleBills = SaleBill::where('status', 'done')->where('outer_client_id', $outer_client_id)
                    ->whereBetween('date', [$from_date->startOfDay(), $to_date->endOfDay()])->get();
                $cashs = Cash::where('outer_client_id', $outer_client_id)
                    ->where('amount', '>', 0)
                    ->whereDate('created_at', '>=', $from_date)
                    ->whereDate('created_at', '<=', $to_date)->get();
                $borrows = Cash::where('outer_client_id', $outer_client_id)
                    ->where('amount', '<', 0)
                    ->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->get();
                $bankcashs = BankCash::where('outer_client_id', $outer_client_id)
                    ->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->get();
                $returns = SaleBillReturn::where('outer_client_id', $outer_client_id)
                    ->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->get();
            }
        } elseif ($submit === "today") {
            // Summary for today
            $gifts = Gift::where('outer_client_id', $outer_client_id)
                ->whereDate('created_at', $today)->get();
            $quotations = Quotation::where('outer_client_id', $outer_client_id)
                ->whereDate('created_at', $today)->get();
            $saleBills = SaleBill::where('outer_client_id', $outer_client_id)
                ->whereDate('created_at', $today)->get();
            $cashs = Cash::where('outer_client_id', $outer_client_id)
                ->where('amount', '>', 0)
                ->whereDate('created_at', $today)->get();
            $borrows = Cash::where('outer_client_id', $outer_client_id)
                ->where('amount', '<', 0)
                ->whereDate('created_at', $today)->get();
            $bankcashs = BankCash::where('outer_client_id', $outer_client_id)
                ->whereDate('created_at', $today)->get();
            $returns = SaleBillReturn::where('outer_client_id', $outer_client_id)
                ->whereDate('created_at', $today)->get();
            $bonds = Bondclient::where('client', $outer_client_k->client_name)
                ->where('company_id', $outer_client_k->company_id)
                ->whereDate('created_at', $today)->get();
        }
        $sale_bills_done = SaleBill::where('company_id', $outer_client_k->company_id)
            ->where('status', 'done')
            ->orderBy('created_at', 'asc')
            ->get();
        // dd($sale_bills_done->pluck('id'),$outer_client_k->company_id, $outer_client_k->id);
        foreach ($sale_bills_done as $saleBill) {
            $position = $sale_bills_done->search(function ($item) use ($saleBill) {
                return $item->id === $saleBill->id;
            }) + 1; // +1 to make it 1-based index
            $saleBill->sale_bill_number = $position;
            $saleBill->save();
        }
        // Return the view with the gathered data
        return view('client.summary.clients_post_new', compact(
            'returns',
            'from_date',
            'to_date',
            'outer_client_k',
            'gifts',
            'quotations',
            'saleBills',
            'cashs',
            'bankcashs',
            'borrows',
            'bonds'
        ));
    }
    public function post_clients_summary_new3(ClientsSummaryRequest $request)
    {
        // Initialize variables
        $outer_client_id = $request->outer_client_id;
        $from_date = $request->from_date ? Carbon::parse($request->from_date) : null;
        $to_date = $request->to_date ? Carbon::parse($request->to_date) : null;
        $submit = $request->submit;
        $today = Carbon::today();

        // Find the client
        $outer_client_k = OuterClient::FindOrFail($outer_client_id);

        // Initialize collections
        $gifts = collect();
        $quotations = collect();
        $bonds = collect();
        $saleBills = collect();
        $cashs = collect();
        $borrows = collect();
        $bankcashs = collect();
        $returns = collect();

        // Determine the type of summary
        if ($submit === "all") {
            // Summary for all data
            if (is_null($from_date) && is_null($to_date)) {
                // No date filters
                $gifts = $outer_client_k->gifts;
                $quotations = $outer_client_k->quotations;
                $bonds = Bondclient::where('client', $outer_client_k->client_name)
                    ->where('company_id', $outer_client_k->company_id)->get();

                $saleBills = $outer_client_k->saleBills->where('status', 'done');
                $cashs = Cash::where('outer_client_id', $outer_client_id)->where('amount', '>', 0)->get();
                $borrows = Cash::where('outer_client_id', $outer_client_id)->where('amount', '<', 0)->get();
                $bankcashs = $outer_client_k->bankcashs;
                $returns = $outer_client_k->saleBillReturns;
            } else {
                // With date filters
                $gifts = Gift::where('outer_client_id', $outer_client_id)
                    ->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->get();
                $quotations = Quotation::where('outer_client_id', $outer_client_id)
                    ->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->get();
                $bonds = Bondclient::where('client', $outer_client_k->client_name)
                    ->where('company_id', $outer_client_k->company_id)
                    ->whereDate('created_at', '>=', $from_date)
                    ->whereDate('created_at', '<=', $to_date)
                    ->get();

                $saleBills = SaleBill::where('status', 'done')->where('outer_client_id', $outer_client_id)
                    ->whereBetween('date', [$from_date->startOfDay(), $to_date->endOfDay()])->get();
                $cashs = Cash::where('outer_client_id', $outer_client_id)
                    ->where('amount', '>', 0)
                    ->whereDate('created_at', '>=', $from_date)
                    ->whereDate('created_at', '<=', $to_date)->get();
                $borrows = Cash::where('outer_client_id', $outer_client_id)
                    ->where('amount', '<', 0)
                    ->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->get();
                $bankcashs = BankCash::where('outer_client_id', $outer_client_id)
                    ->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->get();
                $returns = SaleBillReturn::where('outer_client_id', $outer_client_id)
                    ->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->get();
            }
        } elseif ($submit === "today") {
            // Summary for today
            $gifts = Gift::where('outer_client_id', $outer_client_id)
                ->whereDate('created_at', $today)->get();
            $quotations = Quotation::where('outer_client_id', $outer_client_id)
                ->whereDate('created_at', $today)->get();
            $saleBills = SaleBill::where('outer_client_id', $outer_client_id)
                ->whereDate('created_at', $today)->get();
            $cashs = Cash::where('outer_client_id', $outer_client_id)
                ->where('amount', '>', 0)
                ->whereDate('created_at', $today)->get();
            $borrows = Cash::where('outer_client_id', $outer_client_id)
                ->where('amount', '<', 0)
                ->whereDate('created_at', $today)->get();
            $bankcashs = BankCash::where('outer_client_id', $outer_client_id)
                ->whereDate('created_at', $today)->get();
            $returns = SaleBillReturn::where('outer_client_id', $outer_client_id)
                ->whereDate('created_at', $today)->get();
            $bonds = Bondclient::where('client', $outer_client_k->client_name)
                ->where('company_id', $outer_client_k->company_id)
                ->whereDate('created_at', $today)->get();
        }
        $sale_bills_done = SaleBill::where('company_id', $outer_client_k->company_id)
            ->where('status', 'done')
            ->orderBy('created_at', 'asc')
            ->get();
        // dd($sale_bills_done->pluck('id'),$outer_client_k->company_id, $outer_client_k->id);
        foreach ($sale_bills_done as $saleBill) {
            $position = $sale_bills_done->search(function ($item) use ($saleBill) {
                return $item->id === $saleBill->id;
            }) + 1; // +1 to make it 1-based index
            $saleBill->sale_bill_number = $position;
            $saleBill->save();
        }
        // Return the view with the gathered data
        return view('client.summary.clients_post_new3', compact(
            'returns',
            'from_date',
            'to_date',
            'outer_client_k',
            'gifts',
            'quotations',
            'saleBills',
            'cashs',
            'bankcashs',
            'borrows',
            'bonds'
        ));
    }
    public function get_suppliers_summary()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $suppliers = $company->suppliers;
        return view('client.summary.suppliers', compact('company', 'company_id', 'suppliers'));
    }

    public function post_suppliers_summary(SuppliersSummaryRequest $request)
    {
        $supplier_id = $request->supplier_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $submit = $request->submit;
        $today = date('Y-m-d');
        $supplier_k = Supplier::FindOrFail($supplier_id);
        if (isset($submit) && $submit == "all") {
            if (empty($from_date) && empty($to_date)) {
                // all summary results
                $buyBills = $supplier_k->buyBills;
                $buyCashs = BuyCash::where('supplier_id', $supplier_id)->where('amount', '>', 0)->get();
                $buyBorrows = BuyCash::where('supplier_id', $supplier_id)->where('amount', '<', 0)->get();
                $bankbuyCashs = $supplier_k->bankbuyCashs;
                $returns = $supplier_k->buyBillReturns;
                $bondSuppliers = $supplier_k->bondSuppliers;
            } else {
                // from - to
                $buyBills = BuyBill::where('supplier_id', $supplier_id)
                    ->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->get();
                $buyCashs = BuyCash::where('supplier_id', $supplier_id)
                    ->where('amount', '>', 0)
                    ->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->get();

                $buyBorrows = BuyCash::where('supplier_id', $supplier_id)
                    ->where('amount', '<', 0)
                    ->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->get();

                $bankbuyCashs = BankBuyCash::where('supplier_id', $supplier_id)
                    ->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->get();
                $returns = BuyBillReturn::where('supplier_id', $supplier_id)
                    ->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->get();
                $bondSuppliers = $supplier_k->bondSuppliers()
                    ->whereDate('created_at', '>=', $from_date)->whereDate('created_at', '<=', $to_date)->get();

                }
        }
        if (isset($submit) && $submit == "today") {
            // today
            $buyBills = BuyBill::where('supplier_id', $supplier_id)
                ->whereDate('created_at', 'LIKE', '%' . $today . '%')->get();
            $buyCashs = BuyCash::where('supplier_id', $supplier_id)
                ->where('amount', '>', 0)
                ->whereDate('created_at', 'LIKE', '%' . $today . '%')->get();

            $buyBorrows = BuyCash::where('supplier_id', $supplier_id)
                ->where('amount', '<', 0)
                ->whereDate('created_at', 'LIKE', '%' . $today . '%')->get();

            $bankbuyCashs = BankBuyCash::where('supplier_id', $supplier_id)
                ->whereDate('created_at', 'LIKE', '%' . $today . '%')->get();

            $returns = BuyBillReturn::where('supplier_id', $supplier_id)
                ->whereDate('created_at', 'LIKE', '%' . $today . '%')->get();
            $bondSuppliers = $supplier_k->bondSuppliers()
                        ->whereDate('created_at', 'LIKE', '%' . $today . '%')->get();

            }
        return view(
            'client.summary.suppliers_post',
            compact(
                'from_date',
                'to_date',
                'supplier_k',
                'buyBills',
                'buyCashs',
                'bankbuyCashs',
                'returns',
                'buyBorrows',
                'bondSuppliers'
            )
        );
    }

    public function get_employees_summary()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $employees = $company->employees;
        return view('client.summary.employees', compact('company', 'company_id', 'employees'));
    }

    public function post_employees_summary(EmployeesSummaryRequest $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $employees = $company->employees;
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $employee_id = $request->employee_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        if ($employee_id == "all") {
            $employees_k = $company->employees;
            return view(
                'client.summary.employees',
                compact('company', 'currency', 'employee_id', 'employees', 'from_date', 'to_date', 'company_id', 'employees_k')
            );
        } else {
            $employee_k = Employee::FindOrFail($employee_id);
            return view(
                'client.summary.employees',
                compact('company', 'currency', 'employee_id', 'employees', 'from_date', 'to_date', 'company_id', 'employee_k')
            );
        }
    }

    public function send_client_summary(Request $request)
    {
        $url = $request->url;
        $id = $request->id;
        $outer_client = OuterClient::FindOrFail($id);
        $data = array(
            'body' => 'كشف حساب عميل',
            'url' => $url,
            'subject' => 'مرفق مع هذه الرسالة رابط لكشف الحساب ',
        );
        Mail::to($outer_client->client_email)->send(new sendingClientSummary($data));
        return redirect()->to('/client/clients-summary-get')
            ->with('success', 'تم ارسال كشف الحساب الى بريد العميل بنجاح');
    }

    public function send_supplier_summary(Request $request)
    {
        $url = $request->url;
        $id = $request->id;
        $supplier = Supplier::FindOrFail($id);
        $data = array(
            'body' => 'كشف حساب مورد',
            'url' => $url,
            'subject' => 'مرفق مع هذه الرسالة رابط لكشف الحساب ',
        );
        Mail::to($supplier->supplier_email)->send(new sendingSupplierSummary($data));
        return redirect()->to('/client/suppliers-summary-get')
            ->with('success', 'تم ارسال كشف الحساب الى بريد المورد بنجاح');
    }
}
