<?php

namespace App\Http\Controllers\Client;

use App\Models\Cash;
use App\Models\Gift;
use App\Models\Client;
use App\Models\BuyBill;
use App\Models\BuyCash;
use App\Models\Company;
use App\Models\Expense;
use App\Models\PosOpen;
use App\Models\BankCash;
use App\Models\SaleBill;
use App\Models\Quotation;
use App\Models\BankBuyCash;
use Illuminate\Http\Request;
use App\Models\BuyBillReturn;
use App\Models\ExtraSettings;
use App\Models\SaleBillReturn;
use App\Models\accounting_tree;
use App\Http\Requests\DailyRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class DailyController extends Controller
{
    public function get_daily()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $clients = $company->clients;
        $products = $company->products;
        return view('client.daily.daily', compact('company', 'company_id', 'products', 'clients'));
    }

    public function post_daily(Request $request)
    {
        $client_id = Auth::user()->id;
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $clients = $company->clients;
        $products = $company->products;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;

        if (in_array('مدير النظام', Auth::user()->role_name)) {
            $gifts = Gift::where('company_id', $company_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            $quotations = Quotation::where('company_id', $company_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            $saleBills = SaleBill::where('company_id', $company_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            $posBills = PosOpen::where('company_id', $company_id)
                ->where('status', 'done')
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            $cashs = Cash::where('company_id', $company_id)
                ->where('amount', '>', 0)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            $borrows = Cash::where('company_id', $company_id)
                ->where('amount', '<', 0)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            $bankcashs = BankCash::where('company_id', $company_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            $returns = SaleBillReturn::where('company_id', $company_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            $buyBills = BuyBill::where('company_id', $company_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            $buyCashs = BuyCash::where('company_id', $company_id)
                ->where('amount', '>', 0)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            $buyBorrows = BuyCash::where('company_id', $company_id)
                ->where('amount', '<', 0)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            $bankbuyCashs = BankBuyCash::where('company_id', $company_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            $buyReturns = BuyBillReturn::where('company_id', $company_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            $expenses = Expense::where('company_id', $company_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
        } else {
            $gifts = Gift::where('company_id', $company_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            $quotations = Quotation::where('company_id', $company_id)
                ->where('client_id', $client_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            $saleBills = SaleBill::where('company_id', $company_id)
                ->where('client_id', $client_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            $posBills = PosOpen::where('company_id', $company_id)
                ->where('status', 'done')
                ->where('client_id', $client_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            $cashs = Cash::where('company_id', $company_id)
                ->where('amount', '>', 0)
                ->where('client_id', $client_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            $borrows = Cash::where('company_id', $company_id)
                ->where('amount', '<', 0)
                ->where('client_id', $client_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            $bankcashs = BankCash::where('company_id', $company_id)
                ->where('client_id', $client_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            $returns = SaleBillReturn::where('company_id', $company_id)
                ->where('client_id', $client_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            $buyBills = BuyBill::where('company_id', $company_id)
                ->where('client_id', $client_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            $buyCashs = BuyCash::where('company_id', $company_id)
                ->where('client_id', $client_id)
                ->where('amount', '>', 0)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            $buyBorrows = BuyCash::where('company_id', $company_id)
                ->where('client_id', $client_id)
                ->where('amount', '<', 0)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            $bankbuyCashs = BankBuyCash::where('company_id', $company_id)
                ->where('client_id', $client_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            $buyReturns = BuyBillReturn::where('company_id', $company_id)
                ->where('client_id', $client_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
            $expenses = Expense::where('company_id', $company_id)
                ->where('client_id', $client_id)
                ->whereBetween('created_at', [$from_date, date('Y-m-d', strtotime($to_date . ' +1 day'))])->get();
        }
        return view(
            'client.daily.daily',
            compact(
                'company',
                'company_id',
                'currency',
                'products',
                'clients',
                'gifts',
                'quotations',
                'posBills',
                'saleBills',
                'cashs',
                'bankcashs',
                'borrows',
                'buyBorrows',
                'returns',
                'buyBills',
                'buyCashs',
                'bankbuyCashs',
                'buyReturns',
                'expenses',
                'from_date',
                'to_date'
            )
        );
    }


    public function accounting_tree(Request $request)
    {

        $parent_id = accounting_tree::where('type', 'level_one')->orWhere('type', 'main')->get();
        $main_1 = accounting_tree::where('parent_id', 1)->latest()->pluck('id')->first();
        $id = accounting_tree::where('parent_id', '=', Null)->latest()->pluck('account_number')->first();

        $categories = accounting_tree::where('parent_id', '=', Null)->get();

        $allCategories = accounting_tree::pluck('account_name', 'id')->all();
        return view('client.accounting_tree.index', compact('parent_id', 'id', 'categories', 'allCategories', 'main_1'));
    }

    public function accounting_tree_store(DailyRequest  $request)
    {

        $account_type = $request->account_type;
        if ($account_type == 'أصول') {
            $last_year_amount = 0.00;
            $debit_balance = -64.00;
            $credit = 5233.50;
            $balance = -5297.50;
        } elseif ($account_type == 'خصوم') {
            $last_year_amount = 0.00;
            $debit_balance = 1663.52;
            $credit = 7759.89;
            $balance = 6096.37;
        } elseif ($account_type == 'إيرادات') {
            $last_year_amount = 0.00;
            $debit_balance = 0.00;
            $credit = 100.00;
            $balance = 100.00;
        } elseif ($account_type == 'مصروفات') {
            $last_year_amount = 0.00;
            $debit_balance = 11313.87;
            $credit = -1380.00;
            $balance = 12693.87;
        } else {
            $last_year_amount = 0.00;
            $debit_balance = 0.00;
            $credit = 0.00;
            $balance = 0.00;
        }

        if ($request->type == 'level_one') {
            $type_budget = 'أخرى';
        } elseif ($request->type == 'main') {
            $type_budget = $request->type_budget;
        } elseif ($request->type == 'sub') {
            $type_budget = 'أخرى';
        }
        if ($request->account_type == Null) {
            $account_type = $request->account_type1;
        } else {
            $account_type = $request->account_type;
        }

        $acc = accounting_tree::where('id', $request->account_id)->first();

        if (!isset($acc)) {
            $accounting_tree = new accounting_tree();
            $accounting_tree->type = $request->type;
            $accounting_tree->account_number = $request->account_number;
            $accounting_tree->account_name = $request->account_name;
            $accounting_tree->account_type = $account_type;
            $accounting_tree->account_name_en = $request->account_name_en;
            $accounting_tree->level = $request->level;
            $accounting_tree->type_budget = $type_budget;
            $accounting_tree->last_year_amount = $last_year_amount;
            $accounting_tree->debit_balance = $debit_balance;
            $accounting_tree->credit = $credit;
            $accounting_tree->balance = $balance;
            $accounting_tree->parent_id = $request->parent_id;
            $accounting_tree->save();

            return redirect()->back()
                ->with('success', 'تم اضافة الفرع بنجاح');
        } else {
            $acc->update([
                'type' => ($request->type) ? $request->type : $acc->type,
                'account_number' => ($request->account_number) ? $request->account_number : $acc->account_number,
                'account_name' => ($request->account_name) ? $request->account_name : $acc->account_name,
                'account_type' => ($request->account_type) ? $request->account_type : $acc->account_type,
                'account_name_en' => ($request->account_name_en) ? $request->account_name_en : $acc->account_name_en,
            ]);
            return redirect()->back()
                ->with('success', 'تم تعديل الفرع بنجاح');
        }
    }

    public function get_data_accounting_tree(Request $request)
    {
        // $main_1 = accounting_tree::where('parent_id',$request->selectedValue)->latest()->pluck('id')->first();
        $main_12 = accounting_tree::where('parent_id', $request->selectedValue)->latest()->pluck('account_number')->first();

        if ($main_12 != Null) {
            $account_number = $main_12 + 1;

            $numString = (string)$account_number; // تحويل الرقم إلى نص
            $numLength = strlen($numString); // حساب عدد الأحرف في النص
            $numberOfDigits = strrev($numLength);

            if ($numberOfDigits == 2) {
                $level = 'مستوى ثاني';
            } elseif ($numberOfDigits == 4) {
                $level = 'مستوى ثالث';
            } elseif ($numberOfDigits == 8) {
                $level = 'مستوى رابع';
            }

        } else {
            $main12 = accounting_tree::where('id', $request->selectedValue)->first();
            if ($main12->parent_id == null) {
                $account_number = $main12->account_number . '1';
                $level = 'مستوى ثاني';
            } else {
                $numString = (string)$main12->account_number; // تحويل الرقم إلى نص
                $numLength = strlen($numString); // حساب عدد الأحرف في النص
                $numberOfDigits = strrev($numLength);
                if ($numberOfDigits == 2) {
                    $account_number = $main12->account_number . '01';
                    $level = 'مستوى ثالث';
                } else if ($numberOfDigits == 4) {
                    $account_number = $main12->account_number . '0001';
                    $level = 'مستوى رابع';
                }
            }
        }
        $data = [
            'account_number' => $account_number,
            'level' => $level
        ];

        return response()->json($data);
    }

    public function edit_accounting_tree(Request $request)
    {
        $accounting_tree = accounting_tree::where('id', $request->id)->first();
        return response()->json($accounting_tree);
    }

    public function delete_data_accounting_tree(Request $request)
    {
        $accounting_tree = accounting_tree::where('id', $request->id)->first();
        if (isset($accounting_tree)) {
            $accounting_parent = accounting_tree::where('parent_id', $request->id)->get();
            if (count($accounting_parent) > 0) {
                foreach ($accounting_parent as $dd) {
                    $dd->delete();
                }
            }
            $accounting_tree->delete();
            return response()->json();
        }

    }
}
