<?php

namespace App\Http\Controllers\Client;

use App\Models\Bank;
use App\Models\Company;
use App\Models\BankCash;
use App\Models\Supplier;
use App\Models\BankBuyCash;
use App\Models\OuterClient;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\BankClientsRequest;
use App\Http\Requests\BankSuppliersRequest;


class CashBankController extends Controller
{
    public function add_cashbank_clients()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $old_cash = BankCash::max('cash_number');
        $pre_cash = ++$old_cash;
        $outer_clients = OuterClient::where('company_id', $company_id)->get();
        $banks = $company->banks;
        return view('client.finances.cashbank.clients', compact('outer_clients', 'banks', 'banks', 'company_id', 'pre_cash', 'company'));
    }

    public function edit_cashbank_clients($id)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $cash = BankCash::FindOrFail($id);

        $outer_clients = OuterClient::where('company_id', $company_id)->get();
        $banks = $company->banks;

        return view('client.finances.paymentsbank.edit_clients', compact('outer_clients',
            'banks', 'company_id', 'cash', 'company'));
    }

    public function cashbank_clients()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $cashs = BankCash::where('company_id', $company_id)->get();
        return view('client.finances.paymentsbank.clients', compact('company_id', 'cashs', 'company'));
    }

    public function store_cashbank_clients(BankClientsRequest  $request)
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
        $bank_id = $data['bank_id'];
        $bank = Bank::FindOrFail($bank_id);
        $old_balance = $bank->bank_balance;
        $new_balance = $old_balance + $amount;
        $cash = BankCash::create($data);
        $outer_client->update([
            'prev_balance' => $balance_after,
        ]);
        $bank->update([
            'bank_balance' => $new_balance,
        ]);
        return redirect()->route('client.add.cashbank.clients')
            ->with('success', 'تم الدفع البنكى من عميل بنجاح');
    }

    public function update_cashbank_clients(BankClientsRequest  $request, $id)
    {
      
        $data = $request->all();

        // Return the old values before the operation
        $old_cash = BankCash::FindOrFail($id);
        $old_bank_id = $old_cash->bank_id;
        $old_bank = Bank::FindOrFail($old_bank_id);
        $old_amount = $old_cash->amount;
        $old_bank_balance = $old_bank->bank_balance;
        $new_bank_balance = $old_bank_balance - $old_amount;
        $old_outer_client_id = $old_cash->outer_client_id;
        $old_outer_client = OuterClient::FindOrFail($old_outer_client_id);
        $old_outer_client_balance = $old_outer_client->prev_balance;
        $new_outer_client_balance = $old_outer_client_balance + $old_amount;
        $old_bank->update([
            'bank_balance' => $new_bank_balance,
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
        $bank_id = $data['bank_id'];
        $bank = Bank::FindOrFail($bank_id);
        $old_balance = $bank->bank_balance;
        $new_balance = $old_balance + $amount;
        $outer_client->update([
            'prev_balance' => $balance_after,
        ]);
        $bank->update([
            'bank_balance' => $new_balance,
        ]);
        $cash = BankCash::FindOrFail($id);
        $cash->update($data);

        return redirect()->route('client.cashbank.clients')
            ->with('success', 'تم تعديل البيانات بنجاح');
    }

    public function destroy_cashbank_clients(Request $request)
    {
        $data = $request->all();
        $id = $request->cashid;
        // Return the old values before the operation
        $old_cash = BankCash::FindOrFail($id);
        $old_bank_id = $old_cash->bank_id;
        $old_bank = Bank::FindOrFail($old_bank_id);
        $old_amount = $old_cash->amount;
        $old_bank_balance = $old_bank->bank_balance;
        $new_bank_balance = $old_bank_balance - $old_amount;
        $old_outer_client_id = $old_cash->outer_client_id;
        $old_outer_client = OuterClient::FindOrFail($old_outer_client_id);
        $old_outer_client_balance = $old_outer_client->prev_balance;
        $new_outer_client_balance = $old_outer_client_balance + $old_amount;
        $old_bank->update([
            'bank_balance' => $new_bank_balance,
        ]);
        $old_outer_client->update([
            'prev_balance' => $new_outer_client_balance,
        ]);
        $cash = BankCash::FindOrFail($id);
        $cash->delete();

        return redirect()->route('client.cashbank.clients')
            ->with('success', 'تم حذف البيانات بنجاح');
    }

    public function add_cashbank_suppliers()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);

        $old_cash = BankBuyCash::max('cash_number');
        $pre_buy_cash = ++$old_cash;

        $suppliers = Supplier::where('company_id', $company_id)->get();
        $banks = $company->banks;

        return view('client.finances.cashbank.suppliers', compact('suppliers', 'banks', 'company_id', 'pre_buy_cash', 'company'));
    }

    public function edit_cashbank_suppliers($id)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $buy_cash = BankBuyCash::FindOrFail($id);

        $suppliers = Supplier::where('company_id', $company_id)->get();
        $banks = Bank::where('company_id', $company_id)->get();

        return view('client.finances.paymentsbank.edit_suppliers', compact('suppliers',
            'banks', 'company_id', 'buy_cash', 'company'));
    }

    public function cashbank_suppliers()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $buy_cashs = BankBuyCash::where('company_id', $company_id)->get();
        return view('client.finances.paymentsbank.suppliers', compact('company_id', 'buy_cashs', 'company'));
    }

    public function store_cashbank_suppliers(BankSuppliersRequest  $request)
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
        $cash = BankBuyCash::create($data);
        $supplier->update([
            'prev_balance' => $balance_after,
        ]);
        $bank_id = $data['bank_id'];
        $bank = Bank::FindOrFail($bank_id);
        $old_balance = $bank->bank_balance;
        $new_balance = $old_balance - $amount;
        $bank->update([
            'bank_balance' => $new_balance,
        ]);
        return redirect()->route('client.add.cashbank.suppliers')
            ->with('success', 'تم الدفع البنكى الى المورد بنجاح');
    }

    public function update_cashbank_suppliers(BankSuppliersRequest  $request, $id)
    {
        $data = $request->all();
        $old_cash = BankBuyCash::FindOrFail($id);
        $old_bank_id = $old_cash->bank_id;
        $old_bank = Bank::FindOrFail($old_bank_id);
        $old_amount = $old_cash->amount;
        $old_bank_balance = $old_bank->bank_balance;
        $new_bank_balance = $old_bank_balance + $old_amount;
        $old_supplier_id = $old_cash->supplier_id;
        $old_supplier = Supplier::FindOrFail($old_supplier_id);
        $old_supplier_balance = $old_supplier->prev_balance;
        $new_supplier_balance = $old_supplier_balance + $old_amount;
        $old_bank->update([
            'bank_balance' => $new_bank_balance,
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
        $bank_id = $data['bank_id'];
        $bank = Bank::FindOrFail($bank_id);
        $old_balance = $bank->bank_balance;
        $new_balance = $old_balance - $amount;
        $supplier->update([
            'prev_balance' => $balance_after,
        ]);
        $bank->update([
            'bank_balance' => $new_balance,
        ]);
        $cash = BankBuyCash::FindOrFail($id);
        $cash->update($data);

        return redirect()->route('client.cashbank.suppliers')
            ->with('success', 'تم تعديل البيانات بنجاح');
    }

    public function destroy_cashbank_suppliers(Request $request)
    {
        $data = $request->all();
        $id = $request->cashid;

        // Return the old values before the operation
        $old_cash = BankBuyCash::FindOrFail($id);
        $old_bank_id = $old_cash->bank_id;
        $old_bank = Bank::FindOrFail($old_bank_id);
        $old_amount = $old_cash->amount;
        $old_bank_balance = $old_bank->bank_balance;
        $new_bank_balance = $old_bank_balance + $old_amount;
        $old_supplier_id = $old_cash->supplier_id;
        $old_supplier = Supplier::FindOrFail($old_supplier_id);
        $old_supplier_balance = $old_supplier->prev_balance;
        $new_supplier_balance = $old_supplier_balance + $old_amount;
        $old_bank->update([
            'bank_balance' => $new_bank_balance,
        ]);
        $old_supplier->update([
            'prev_balance' => $new_supplier_balance,
        ]);
        $cash = BankBuyCash::FindOrFail($id);
        $cash->delete();
        return redirect()->route('client.cashbank.suppliers')
            ->with('success', 'تم حذف البيانات بنجاح');
    }

    public function print_bank_cash_receipt($id){
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $cash = BankCash::FindOrFail($id);
        return view('client.finances.paymentsbank.print_bank_cash',compact('cash','company'));
    }

    public function print_bank_buy_cash_receipt($id){
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $cash = BankBuyCash::FindOrFail($id);
        return view('client.finances.paymentsbank.print_bank_buy_cash',compact('cash','company'));
    }

}
