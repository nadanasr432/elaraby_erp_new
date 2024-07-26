<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Voucher;
use Illuminate\Http\Request;
use App\Models\accounting_tree;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class VoucherController extends Controller
{
    public function get_voucher_entries(Request $request)
    {
        // dd($request);
        $company_id = Auth::user()->company_id;
        $vouchers = Voucher::where('company_id', $company_id)
            ->when($request->filled('from_date'), function ($query) use ($request) {
                return $query->where('date', '>=', $request->input('from_date'));
            })
            ->when($request->filled('to_date'), function ($query) use ($request) {
                return $query->where('date', '<=', $request->input('to_date'));
            })
            ->when($request->filled('acount_id'), function ($query) use ($request) {
                return $query->whereHas('transactions', function ($query) use ($request) {
                    $account = accounting_tree::find($request->input('acount_id'));
                    $childeren = $account->childs->pluck('id')->toArray();
                    $query->where('accounting_tree_id', $request->input('acount_id'))
                        ->orWhereIn('accounting_tree_id', $childeren);
                });
            })->get();
        $accounts = accounting_tree::get();
        return view('client.voucher.index', compact('vouchers', 'accounts'));
    }

    public function create_voucher_entries()
    {
        $accounts = accounting_tree::get();
        return view('client.voucher.create', compact('accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'date' => 'required',
            'notation' => 'required',
            'transactions' => 'required|array|min:1',
            'transactions.*.account' => 'required|exists:accounting_trees,id',
            // 'transactions.*.amount' => 'required|numeric',
            'transactions.*.notation' => 'nullable|string',
            // 'transactions.*.type' => 'required|in:0,1',
        ]);
        $company_id = Auth::user()->company_id;
        // where('company_id',$company_id)
        DB::beginTransaction();

        try {
            $voucher = Voucher::create([
                'amount' => $request->amount,
                'company_id' => $company_id,
                'date' => $request->date,
                'payment_method' => "cash",
                'notation' => $request->notation,
                'status' => 1,
                'user_id' => auth::user()->id,
                'options' => 0,
            ]);

            foreach ($request->transactions as $transaction) {
                Transaction::create([
                    'accounting_tree_id' => $transaction['account'],
                    'voucher_id' => $voucher->id,
                    'amount' => $transaction['credit'] ? $transaction['credit'] : $transaction['debit'],
                    'notation' => $transaction['notation'],
                    'type' => $transaction['credit'] ? 0 : 1,
                ]);
            }

            DB::commit();

            return response()->json($voucher->id);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['error' => 'An error occurred while creating the voucher.'], 500);
        }
    }

    public function showAccountStatement($accountId)
    {
        $transactions = Transaction::where('company_id', Auth::user()->company_id)->where('accounting_tree_id', $accountId)->get();
        $totalDebit = $transactions->where('type', 1)->sum('amount');
        $totalCredit = $transactions->where('type', 0)->sum('amount');

        return view('client.voucher.statement', compact('transactions', 'totalDebit', 'totalCredit'));
    }
}
