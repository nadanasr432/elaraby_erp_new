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

    public function post_clients_summary(ClientsSummaryRequest $request)
    {
        //client id..
        $outer_client_id = $request->outer_client_id;

        //date from
        $from_date = $request->from_date;
        //date to
        $to_date = $request->to_date;
        //type of getting data ==> all or just invoices for today..
        $submit = $request->submit;
        $today = date('Y-m-d');

        $outer_client_k = OuterClient::FindOrFail($outer_client_id);
        if (isset($submit) && $submit == "all") {
            if (empty($from_date) && empty($to_date)) {

                // all summary results
                $gifts = $outer_client_k->gifts;
                $quotations = $outer_client_k->quotations;
                $bonds = Bondclient::where('client', $outer_client_k->client_name)->get();
                $saleBills = $outer_client_k->saleBills;
                $cashs = Cash::where('outer_client_id', $outer_client_id)->where('amount', '>', 0)->get();
                $borrows = Cash::where('outer_client_id', $outer_client_id)->where('amount', '<', 0)->get();
                $bankcashs = $outer_client_k->bankcashs;
                $returns = $outer_client_k->saleBillReturns;
            } else {
                // from - to
                $gifts = Gift::where('outer_client_id', $outer_client_id)
                    ->whereBetween('created_at', [$from_date, $to_date])->get();
                $quotations = Quotation::where('outer_client_id', $outer_client_id)
                    ->whereBetween('created_at', [$from_date, $to_date])->get();

                $bonds = Bondclient::where('client', $outer_client_k->client_name)
                    ->whereBetween('created_at', [$from_date, $to_date])->get();

//                $saleBills = SaleBill::where('outer_client_id', $outer_client_id)
//                    ->whereBetween('created_at', [$from_date, $to_date])->get();

                //convert time..
                $from_date2 = new \DateTime($from_date);
                $to_date2 = new \DateTime($to_date);

                //get timeStampe ==> (time)
                $from_date_timeStamp = $from_date2->getTimestamp();
                $to_date_timeStamp = $to_date2->getTimestamp();

                $from_date2 = new Carbon($from_date_timeStamp);
                $to_date2 = new Carbon($to_date_timeStamp);

                $saleBills = SaleBill::where('outer_client_id', $outer_client_id)
                    ->whereBetween('date', [$from_date2->format('Y-m-d') . " 00:00:00", $to_date2->format('Y-m-d') . " 23:59:59"])->get();

                $cashs = Cash::where('outer_client_id', $outer_client_id)
                    ->where('amount', '>', 0)
                    ->whereBetween('created_at', [$from_date, $to_date])->get();
                $borrows = Cash::where('outer_client_id', $outer_client_id)
                    ->where('amount', '<', 0)
                    ->whereBetween('created_at', [$from_date, $to_date])->get();
                $bankcashs = BankCash::where('outer_client_id', $outer_client_id)
                    ->whereBetween('created_at', [$from_date, $to_date])->get();
                $returns = SaleBillReturn::where('outer_client_id', $outer_client_id)
                    ->whereBetween('created_at', [$from_date, $to_date])->get();
            }
        }
        if (isset($submit) && $submit == "today") {
            // today
            $gifts = Gift::where('outer_client_id', $outer_client_id)
                ->whereDate('created_at', 'LIKE', '%' . $today . '%')->get();
            $quotations = Quotation::where('outer_client_id', $outer_client_id)
                ->whereDate('created_at', 'LIKE', '%' . $today . '%')->get();
            $saleBills = SaleBill::where('outer_client_id', $outer_client_id)
                ->whereDate('created_at', 'LIKE', '%' . $today . '%')->get();
            $cashs = Cash::where('outer_client_id', $outer_client_id)
                ->where('amount', '>', 0)
                ->whereDate('created_at', 'LIKE', '%' . $today . '%')->get();
            $borrows = Cash::where('outer_client_id', $outer_client_id)
                ->where('amount', '<', 0)
                ->whereDate('created_at', 'LIKE', '%' . $today . '%')->get();
            $bankcashs = BankCash::where('outer_client_id', $outer_client_id)
                ->whereDate('created_at', 'LIKE', '%' . $today . '%')->get();
            $returns = SaleBillReturn::where('outer_client_id', $outer_client_id)
                ->whereDate('created_at', 'LIKE', '%' . $today . '%')->get();
            $bonds = Bondclient::where('client', $outer_client_k->client_name)
                ->whereDate('created_at', 'LIKE', '%' . $today . '%')->get();

        }
        return view('client.summary.clients_post',
            compact('returns', 'from_date', 'to_date'
                , 'outer_client_k', 'gifts', 'quotations', 'saleBills', 'cashs', 'bankcashs', 'borrows', 'bonds'));
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
            } else {
                // from - to
                $buyBills = BuyBill::where('supplier_id', $supplier_id)
                    ->whereBetween('created_at', [$from_date, $to_date])->get();
                $buyCashs = BuyCash::where('supplier_id', $supplier_id)
                    ->where('amount', '>', 0)
                    ->whereBetween('created_at', [$from_date, $to_date])->get();

                $buyBorrows = BuyCash::where('supplier_id', $supplier_id)
                    ->where('amount', '<', 0)
                    ->whereBetween('created_at', [$from_date, $to_date])->get();

                $bankbuyCashs = BankBuyCash::where('supplier_id', $supplier_id)
                    ->whereBetween('created_at', [$from_date, $to_date])->get();
                $returns = BuyBillReturn::where('supplier_id', $supplier_id)
                    ->whereBetween('created_at', [$from_date, $to_date])->get();
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
        }
        return view('client.summary.suppliers_post',
            compact('from_date', 'to_date'
                , 'supplier_k', 'buyBills', 'buyCashs', 'bankbuyCashs', 'returns', 'buyBorrows'));

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
            return view('client.summary.employees',
                compact('company', 'currency', 'employee_id', 'employees', 'from_date', 'to_date', 'company_id', 'employees_k'));
        } else {
            $employee_k = Employee::FindOrFail($employee_id);
            return view('client.summary.employees',
                compact('company', 'currency', 'employee_id', 'employees', 'from_date', 'to_date', 'company_id', 'employee_k'));
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
