<?php

namespace App\Http\Controllers\Client;

use App\Models\Bank;
use App\Models\Cash;
use App\Models\Safe;
use App\Models\BuyCash;
use App\Models\Company;
use App\Models\BankCash;
use App\Models\Supplier;

use App\Models\OuterClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CashClientsRequest;
use App\Http\Requests\CashSuppliersRequest;


class CashController extends Controller
{
    public function add_cash_clients()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $check = Cash::all();
        if ($check->isEmpty()) {
            $pre_cash = 1;
        } else {
            $old_cash = Cash::max('cash_number');
            $pre_cash = ++$old_cash;
        }
        $outer_clients = OuterClient::where('company_id', $company_id)->get();
        $safes = $company->safes;
        $banks = $company->banks;

        return view('client.finances.cash.clients', compact('outer_clients', 'banks', 'safes', 'company_id', 'pre_cash', 'company'));
    }

    public function give_cash_clients()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $check = Cash::all();
        if ($check->isEmpty()) {
            $pre_cash = 1;
        } else {
            $old_cash = Cash::max('cash_number');
            $pre_cash = ++$old_cash;
        }
        $outer_clients = OuterClient::where('company_id', $company_id)->get();
        $safes = $company->safes;
        $banks = $company->banks;

        return view('client.finances.borrow.clients', compact('outer_clients', 'banks', 'safes', 'company_id', 'pre_cash', 'company'));
    }

    public function edit_cash_clients($id)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $cash = Cash::FindOrFail($id);

        $outer_clients = OuterClient::where('company_id', $company_id)->get();
        $safes = Safe::where('company_id', $company_id)->get();

        return view('client.finances.payments.edit_clients', compact('outer_clients',
            'safes', 'company_id', 'cash', 'company'));
    }

    public function edit_borrow_clients($id)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $cash = Cash::FindOrFail($id);

        $outer_clients = OuterClient::where('company_id', $company_id)->get();
        $safes = Safe::where('company_id', $company_id)->get();

        return view('client.finances.paymentsborrow.edit_clients', compact('outer_clients',
            'safes', 'company_id', 'cash', 'company'));
    }

    public function cash_clients()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $cashs = Cash::where('company_id', $company_id)->where('amount', '>', 0)->get();
        return view('client.finances.payments.clients', compact('company_id', 'cashs', 'company'));
    }

    public function borrow_clients()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $cashs = Cash::where('company_id', $company_id)->where('amount', '<', 0)->get();
        return view('client.finances.paymentsborrow.clients', compact('company_id', 'cashs', 'company'));
    }

    public function store_cash_clients(CashClientsRequest $request)
    {
        $data = $request->all();
        $company_id = $data['company_id'];
        $data['client_id'] = Auth::user()->id;
        $outer_client_id = $data['outer_client_id'];
        $amount = $data['amount'];
        $outer_client = OuterClient::FindOrFail($outer_client_id);
        $balance_before = $outer_client->prev_balance;
        $balance_after = $balance_before - $amount;
        $data['balance_before'] = $balance_before;
        $data['balance_after'] = $balance_after;
        $safe_id = $data['safe_id'];
        $safe = Safe::FindOrFail($safe_id);
        $old_balance = $safe->balance;
        $new_balance = $old_balance + $amount;
        $cash = Cash::create($data);
        $outer_client->update([
            'prev_balance' => $balance_after,
        ]);
        $safe->update([
            'balance' => $new_balance,
        ]);
        return redirect()->route('client.add.cash.clients')
            ->with('success', 'تم استلام نقدية من عميل بنجاح');
    }

    public function store2_cash_clients(CashClientsRequest $request)
    {
        $data = $request->all();
        $company_id = $data['company_id'];
        $data['client_id'] = Auth::user()->id;
        $outer_client_id = $data['outer_client_id'];
        $amount = $data['amount'];
        $outer_client = OuterClient::FindOrFail($outer_client_id);
        $balance_before = $outer_client->prev_balance;
        $balance_after = $balance_before + $amount;
        $data['balance_before'] = $balance_before;
        $data['balance_after'] = $balance_after;
        $safe_id = $data['safe_id'];
        $safe = Safe::FindOrFail($safe_id);
        $old_balance = $safe->balance;
        $new_balance = $old_balance - $amount;
        $data['amount'] = -$amount;
        $cash = Cash::create($data);
        $outer_client->update([
            'prev_balance' => $balance_after,
        ]);
        $safe->update([
            'balance' => $new_balance,
        ]);
        return redirect()->route('client.give.cash.clients')
            ->with('success', 'تم اعطاء سلفة الى العميل بنجاح');
    }

    public function update_cash_clients(CashClientsRequest $request, $id)
    {
        $data = $request->all();

        // Return the old values before the operation
        $old_cash = Cash::FindOrFail($id);
        $old_safe_id = $old_cash->safe_id;
        $old_safe = Safe::FindOrFail($old_safe_id);
        $old_amount = $old_cash->amount;
        $old_safe_balance = $old_safe->balance;
        $new_safe_balance = $old_safe_balance - $old_amount;
        $old_outer_client_id = $old_cash->outer_client_id;
        $old_outer_client = OuterClient::FindOrFail($old_outer_client_id);
        $old_outer_client_balance = $old_outer_client->prev_balance;
        $new_outer_client_balance = $old_outer_client_balance + $old_amount;
        $old_safe->update([
            'balance' => $new_safe_balance,
        ]);
        $old_outer_client->update([
            'prev_balance' => $new_outer_client_balance,
        ]);
        // Assign the new values of the operation
        $company_id = $data['company_id'];
        $data['client_id'] = Auth::user()->id;
        $outer_client_id = $data['outer_client_id'];
        $amount = $data['amount'];
        $outer_client = OuterClient::FindOrFail($outer_client_id);
        $balance_before = $outer_client->prev_balance;
        $balance_after = $balance_before - $amount;
        $data['balance_before'] = $balance_before;
        $data['balance_after'] = $balance_after;
        $safe_id = $data['safe_id'];
        $safe = Safe::FindOrFail($safe_id);
        $old_balance = $safe->balance;
        $new_balance = $old_balance + $amount;
        $outer_client->update([
            'prev_balance' => $balance_after,
        ]);
        $safe->update([
            'balance' => $new_balance,
        ]);
        $cash = Cash::FindOrFail($id);
        $cash->update($data);

        return redirect()->route('client.cash.clients')
            ->with('success', 'تم تعديل البيانات بنجاح');
    }

    public function update_borrow_clients(CashClientsRequest $request, $id)
    {
        $data = $request->all();

        // Return the old values before the operation
        $old_cash = Cash::FindOrFail($id);
        $old_safe_id = $old_cash->safe_id;
        $old_safe = Safe::FindOrFail($old_safe_id);
        $old_amount = $old_cash->amount;
        $old_safe_balance = $old_safe->balance;
        $new_safe_balance = $old_safe_balance - $old_amount;
        $old_outer_client_id = $old_cash->outer_client_id;
        $old_outer_client = OuterClient::FindOrFail($old_outer_client_id);
        $old_outer_client_balance = $old_outer_client->prev_balance;
        $new_outer_client_balance = $old_outer_client_balance + $old_amount;
        $old_safe->update([
            'balance' => $new_safe_balance,
        ]);
        $old_outer_client->update([
            'prev_balance' => $new_outer_client_balance,
        ]);
        // Assign the new values of the operation
        $company_id = $data['company_id'];
        $data['client_id'] = Auth::user()->id;
        $outer_client_id = $data['outer_client_id'];
        $amount = $data['amount'];
        $outer_client = OuterClient::FindOrFail($outer_client_id);
        $balance_before = $outer_client->prev_balance;
        $balance_after = $balance_before + $amount;
        $data['balance_before'] = $balance_before;
        $data['balance_after'] = $balance_after;
        $data['amount'] = -$amount;
        $safe_id = $data['safe_id'];
        $safe = Safe::FindOrFail($safe_id);
        $old_balance = $safe->balance;
        $new_balance = $old_balance - $amount;
        $outer_client->update([
            'prev_balance' => $balance_after,
        ]);
        $safe->update([
            'balance' => $new_balance,
        ]);
        $cash = Cash::FindOrFail($id);
        $cash->update($data);

        return redirect()->route('client.borrow.clients')
            ->with('success', 'تم تعديل البيانات بنجاح');
    }

    public function destroy_cash_clients(Request $request)
    {
        $data = $request->all();
        $id = $request->cashid;
        // Return the old values before the operation
        $old_cash = Cash::FindOrFail($id);
        $old_safe_id = $old_cash->safe_id;
        $old_safe = Safe::FindOrFail($old_safe_id);
        $old_amount = $old_cash->amount;
        $old_safe_balance = $old_safe->balance;
        $new_safe_balance = $old_safe_balance - $old_amount;
        $old_outer_client_id = $old_cash->outer_client_id;
        $old_outer_client = OuterClient::FindOrFail($old_outer_client_id);
        $old_outer_client_balance = $old_outer_client->prev_balance;
        $new_outer_client_balance = $old_outer_client_balance + $old_amount;
        $old_safe->update([
            'balance' => $new_safe_balance,
        ]);
        $old_outer_client->update([
            'prev_balance' => $new_outer_client_balance,
        ]);
        $cash = Cash::FindOrFail($id);
        $cash->delete();

        return redirect()->route('client.cash.clients')
            ->with('success', 'تم حذف البيانات بنجاح');
    }

    public function destroy_borrow_clients(Request $request)
    {
        $data = $request->all();
        $id = $request->cashid;
        // Return the old values before the operation
        $old_cash = Cash::FindOrFail($id);
        $old_safe_id = $old_cash->safe_id;
        $old_safe = Safe::FindOrFail($old_safe_id);
        $old_amount = $old_cash->amount;
        $old_safe_balance = $old_safe->balance;
        $new_safe_balance = $old_safe_balance - $old_amount;
        $old_outer_client_id = $old_cash->outer_client_id;
        $old_outer_client = OuterClient::FindOrFail($old_outer_client_id);
        $old_outer_client_balance = $old_outer_client->prev_balance;
        $new_outer_client_balance = $old_outer_client_balance + $old_amount;
        $old_safe->update([
            'balance' => $new_safe_balance,
        ]);
        $old_outer_client->update([
            'prev_balance' => $new_outer_client_balance,
        ]);
        $cash = Cash::FindOrFail($id);
        $cash->delete();

        return redirect()->route('client.borrow.clients')
            ->with('success', 'تم حذف البيانات بنجاح');
    }

    public function add_cash_suppliers()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $check = BuyCash::all();
        if ($check->isEmpty()) {
            $pre_buy_cash = 1;
        } else {
            $old_cash = BuyCash::max('cash_number');
            $pre_buy_cash = ++$old_cash;
        }
        $suppliers = Supplier::where('company_id', $company_id)->get();
        $safes = Safe::where('company_id', $company_id)->get();

        return view('client.finances.cash.suppliers', compact('suppliers', 'safes', 'company_id', 'pre_buy_cash', 'company'));
    }

    public function give_cash_suppliers()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $check = BuyCash::all();
        if ($check->isEmpty()) {
            $pre_buy_cash = 1;
        } else {
            $old_cash = BuyCash::max('cash_number');
            $pre_buy_cash = ++$old_cash;
        }
        $suppliers = Supplier::where('company_id', $company_id)->get();
        $safes = Safe::where('company_id', $company_id)->get();
        return view('client.finances.borrow.suppliers', compact('suppliers', 'safes', 'company_id', 'pre_buy_cash', 'company'));
    }

    public function edit_cash_suppliers($id)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $buy_cash = BuyCash::FindOrFail($id);

        $suppliers = Supplier::where('company_id', $company_id)->get();
        $safes = Safe::where('company_id', $company_id)->get();

        return view('client.finances.payments.edit_suppliers', compact('suppliers',
            'safes', 'company_id', 'buy_cash', 'company'));
    }
    public function edit_borrow_suppliers($id)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $buy_cash = BuyCash::FindOrFail($id);

        $suppliers = Supplier::where('company_id', $company_id)->get();
        $safes = Safe::where('company_id', $company_id)->get();

        return view('client.finances.paymentsborrow.edit_suppliers', compact('suppliers',
            'safes', 'company_id', 'buy_cash', 'company'));
    }

    public function cash_suppliers()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $buy_cashs = BuyCash::where('company_id', $company_id)->where('amount','>',0)->get();
        return view('client.finances.payments.suppliers', compact('company_id', 'buy_cashs', 'company'));
    }

    public function borrow_suppliers()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $buy_cashs = BuyCash::where('company_id', $company_id)->where('amount','<',0)->get();
        return view('client.finances.paymentsborrow.suppliers', compact('company_id', 'buy_cashs', 'company'));
    }

    public function store_cash_suppliers(CashSuppliersRequest $request)
    {
        $data = $request->all();
        $company_id = $data['company_id'];
        $data['client_id'] = Auth::user()->id;
        $supplier_id = $data['supplier_id'];
        $amount = $data['amount'];
        $supplier = Supplier::FindOrFail($supplier_id);
        $balance_before = $supplier->prev_balance;
        $balance_after = $balance_before - $amount;
        $data['balance_before'] = $balance_before;
        $data['balance_after'] = $balance_after;
        $cash = BuyCash::create($data);
        $supplier->update([
            'prev_balance' => $balance_after,
        ]);
        $safe_id = $data['safe_id'];
        $safe = Safe::FindOrFail($safe_id);
        $old_balance = $safe->balance;
        $new_balance = $old_balance - $amount;
        $safe->update([
            'balance' => $new_balance,
        ]);
        return redirect()->route('client.add.cash.suppliers')
            ->with('success', 'تم دفع النقدية الى المورد بنجاح');
    }

    public function store2_cash_suppliers(CashSuppliersRequest $request)
    {
        $data = $request->all();
        $company_id = $data['company_id'];
        $data['client_id'] = Auth::user()->id;
        $supplier_id = $data['supplier_id'];
        $amount = $data['amount'];
        $supplier = Supplier::FindOrFail($supplier_id);
        $balance_before = $supplier->prev_balance;
        $balance_after = $balance_before + $amount;
        $data['balance_before'] = $balance_before;
        $data['balance_after'] = $balance_after;
        $data['amount'] = -$amount;
        $cash = BuyCash::create($data);
        $supplier->update([
            'prev_balance' => $balance_after,
        ]);
        $safe_id = $data['safe_id'];
        $safe = Safe::FindOrFail($safe_id);
        $old_balance = $safe->balance;
        $new_balance = $old_balance + $amount;
        $safe->update([
            'balance' => $new_balance,
        ]);
        return redirect()->route('client.give.cash.suppliers')
            ->with('success', 'تم اخذ سلفة من المورد بنجاح');
    }

    public function update_cash_suppliers(CashSuppliersRequest $request, $id)
    {
        $data = $request->all();

        // Return the old values before the operation
        $old_cash = BuyCash::FindOrFail($id);
        $old_safe_id = $old_cash->safe_id;
        $old_safe = Safe::FindOrFail($old_safe_id);
        $old_amount = $old_cash->amount;
        $old_safe_balance = $old_safe->balance;
        $new_safe_balance = $old_safe_balance + $old_amount;
        $old_supplier_id = $old_cash->supplier_id;
        $old_supplier = Supplier::FindOrFail($old_supplier_id);
        $old_supplier_balance = $old_supplier->prev_balance;
        $new_supplier_balance = $old_supplier_balance + $old_amount;
        $old_safe->update([
            'balance' => $new_safe_balance,
        ]);
        $old_supplier->update([
            'prev_balance' => $new_supplier_balance,
        ]);
        // Assign the new values of the operation
        $company_id = $data['company_id'];
        $data['client_id'] = Auth::user()->id;
        $supplier_id = $data['supplier_id'];
        $amount = $data['amount'];
        $supplier = Supplier::FindOrFail($supplier_id);
        $balance_before = $supplier->prev_balance;
        $balance_after = $balance_before - $amount;
        $data['balance_before'] = $balance_before;
        $data['balance_after'] = $balance_after;
        $safe_id = $data['safe_id'];
        $safe = Safe::FindOrFail($safe_id);
        $old_balance = $safe->balance;
        $new_balance = $old_balance - $amount;
        $supplier->update([
            'prev_balance' => $balance_after,
        ]);
        $safe->update([
            'balance' => $new_balance,
        ]);
        $cash = BuyCash::FindOrFail($id);
        $cash->update($data);

        return redirect()->route('client.cash.suppliers')
            ->with('success', 'تم تعديل البيانات بنجاح');
    }
    public function update_borrow_suppliers(CashSuppliersRequest $request, $id)
    {
       
        $data = $request->all();

        // Return the old values before the operation
        $old_cash = BuyCash::FindOrFail($id);
        $old_safe_id = $old_cash->safe_id;
        $old_safe = Safe::FindOrFail($old_safe_id);
        $old_amount = $old_cash->amount;
        $old_safe_balance = $old_safe->balance;
        $new_safe_balance = $old_safe_balance + $old_amount;
        $old_supplier_id = $old_cash->supplier_id;
        $old_supplier = Supplier::FindOrFail($old_supplier_id);
        $old_supplier_balance = $old_supplier->prev_balance;
        $new_supplier_balance = $old_supplier_balance + $old_amount;
        $old_safe->update([
            'balance' => $new_safe_balance,
        ]);
        $old_supplier->update([
            'prev_balance' => $new_supplier_balance,
        ]);
//         Assign the new values of the operation
        $company_id = $data['company_id'];
        $data['client_id'] = Auth::user()->id;
        $supplier_id = $data['supplier_id'];
        $amount = $data['amount'];
        $supplier = Supplier::FindOrFail($supplier_id);
        $balance_before = $supplier->prev_balance;
        $balance_after = $balance_before + $amount;
        $data['balance_before'] = $balance_before;
        $data['balance_after'] = $balance_after;
        $safe_id = $data['safe_id'];
        $safe = Safe::FindOrFail($safe_id);
        $old_balance = $safe->balance;
        $new_balance = $old_balance + $amount;
        $supplier->update([
            'prev_balance' => $balance_after,
        ]);
        $safe->update([
            'balance' => $new_balance,
        ]);
        $data['amount'] = -$amount;
        $cash = BuyCash::FindOrFail($id);
        $cash->update($data);

        return redirect()->route('client.borrow.suppliers')
            ->with('success', 'تم تعديل البيانات بنجاح');
    }

    public function destroy_cash_suppliers(Request $request)
    {
        $data = $request->all();
        $id = $request->cashid;

        // Return the old values before the operation
        $old_cash = BuyCash::FindOrFail($id);
        $old_safe_id = $old_cash->safe_id;
        $old_safe = Safe::FindOrFail($old_safe_id);
        $old_amount = $old_cash->amount;
        $old_safe_balance = $old_safe->balance;
        $new_safe_balance = $old_safe_balance + $old_amount;
        $old_supplier_id = $old_cash->supplier_id;
        $old_supplier = Supplier::FindOrFail($old_supplier_id);
        $old_supplier_balance = $old_supplier->prev_balance;
        $new_supplier_balance = $old_supplier_balance + $old_amount;
        $old_safe->update([
            'balance' => $new_safe_balance,
        ]);
        $old_supplier->update([
            'prev_balance' => $new_supplier_balance,
        ]);
        $cash = BuyCash::FindOrFail($id);
        $cash->delete();
        return redirect()->route('client.cash.suppliers')
            ->with('success', 'تم حذف البيانات بنجاح');
    }
    public function destroy_borrow_suppliers(Request $request)
    {
        $data = $request->all();
        $id = $request->cashid;

        // Return the old values before the operation
        $old_cash = BuyCash::FindOrFail($id);
        $old_safe_id = $old_cash->safe_id;
        $old_safe = Safe::FindOrFail($old_safe_id);
        $old_amount = $old_cash->amount;
        $old_safe_balance = $old_safe->balance;
        $new_safe_balance = $old_safe_balance + $old_amount;
        $old_supplier_id = $old_cash->supplier_id;
        $old_supplier = Supplier::FindOrFail($old_supplier_id);
        $old_supplier_balance = $old_supplier->prev_balance;
        $new_supplier_balance = $old_supplier_balance + $old_amount;
        $old_safe->update([
            'balance' => $new_safe_balance,
        ]);
        $old_supplier->update([
            'prev_balance' => $new_supplier_balance,
        ]);
        $cash = BuyCash::FindOrFail($id);
        $cash->delete();
        return redirect()->route('client.borrow.suppliers')
            ->with('success', 'تم حذف البيانات بنجاح');
    }
    public function print_cash_receipt($id){
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $cash = Cash::FindOrFail($id);
        return view('client.finances.payments.print_cash',compact('cash','company'));
    }
    public function print_buy_cash_receipt($id){
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $cash = BuyCash::FindOrFail($id);
        return view('client.finances.payments.print_buy_cash',compact('cash','company'));
    }
}
