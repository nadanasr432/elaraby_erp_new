<?php

namespace App\Http\Controllers\Client;

use App\Models\Bank;
use App\Models\Safe;
use App\Models\Company;
use App\Models\BankProcess;
use App\Models\BankTransfer;
use Illuminate\Http\Request;
use App\Models\BankModification;
use App\Models\BankSafeTransfer;
use App\Models\SafeBankTransfer;
use App\Http\Requests\BankRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{
    public function index()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $banks = $company->banks;
        return view('client.banks.index', compact('company', 'company_id', 'banks'));
    }

    public function create()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        return view('client.banks.create', compact('company_id', 'company'));
    }

    public function store(BankRequest $request)
    {
        $data = $request->all(); 
        $company_id = $data['company_id'];
        $bank = Bank::create($data);
        return redirect()->route('client.banks.index')
        ->with('success', 'تم اضافة البنك بنجاح');
    }

    public function edit($id)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $bank = Bank::findOrFail($id);
        return view('client.banks.edit', compact('bank', 'company_id', 'company'));
    }

    public function update(BankRequest  $request, $id)
    {
        $data = $request->validated(); 
        $bank = Bank::findOrFail($id);
        $balance_before = $bank->bank_balance;
        $bank->update($data);
        $balance_after = $request->bank_balance;
        BankModification::create([
            'company_id' => $request->company_id,
            'client_id' => Auth::user()->id,
            'bank_id' => $bank->id,
            'reason' => $request->reason,
            'balance_before' => $balance_before,
            'balance_after' => $balance_after,
        ]);
        return redirect()->route('client.banks.index')
        ->with('success', 'تم تعديل بيانات البنك بنجاح');
    }

    public function destroy(Request $request)
    {
        $bank = Bank::findOrFail($request->bankid);
        $bank->delete();
        return redirect()->route('client.banks.index')
            ->with('success', 'تم حذف البنك بنجاح');
    }

    public function banks_process()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $banks = Bank::where('company_id', $company_id)->get();
        $banks_process = BankProcess::where('company_id', $company_id)
            ->get();
        return view('client.banks.process', compact('banks', 'banks_process', 'company_id', 'company'));
    }

    public function banks_process_store(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $banks = Bank::where('company_id', $company_id)->get();
        $bank = Bank::FindOrFail($request->bank_id);
        $balance_before = $bank->bank_balance;
        $amount = $request->amount;
        $process_type = $request->process_type;
        if ($process_type == "withdrawal") {
            $balance_after = $balance_before - $amount;
        } elseif ($process_type == "deposit") {
            $balance_after = $balance_before + $amount;
        }
        BankProcess::create([
            'company_id' => $request->company_id,
            'client_id' => Auth::user()->id,
            'bank_id' => $request->bank_id,
            'reason' => $request->reason,
            'amount' => $amount,
            'process_type' => $process_type,
            'balance_before' => $balance_before,
            'balance_after' => $balance_after,
        ]);
        $bank->update([
            'bank_balance' => $balance_after,
            'updated_at' => now()
        ]);
        return redirect()->route('client.banks.process')
            ->with('success', 'تم تسجيل العملية بنجاح');
    }

    public function banks_process_destroy(Request $request)
    {
        $process_id = $request->processid;
        $process = BankProcess::FindOrFail($process_id);
        $bank = Bank::FindOrFail($process->bank_id);
        $balance_before = $bank->bank_balance;
        $amount = $process->amount;
        $process_type = $process->process_type;
        if ($process_type == "withdrawal") {
            $balance_after = $balance_before + $amount;
        } elseif ($process_type == "deposit") {
            $balance_after = $balance_before - $amount;
        }
        $process->delete();
        $bank->update([
            'bank_balance' => $balance_after,
            'updated_at' => now()
        ]);

        return redirect()->route('client.banks.process')
            ->with('success', 'تم حذف العملية بنجاح');
    }


    public function banks_transfer()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $banks = Bank::where('company_id', $company_id)->get();
        $banks_transfer = BankTransfer::where('company_id', $company_id)
            ->get();
        return view('client.banks.transfer', compact('banks', 'banks_transfer', 'company_id', 'company'));
    }

    public function banks_transfer_store(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $amount = $request->amount;
        $withdrawal_bank = Bank::FindOrFail($request->withdrawal_bank);
        $deposit_bank = Bank::FindOrFail($request->deposit_bank);
        $balance_before_withdrawal_bank = $withdrawal_bank->bank_balance;
        $balance_before_deposit_bank = $deposit_bank->bank_balance;

        $balance_after_withdrawal_bank = $balance_before_withdrawal_bank - $amount;
        $balance_after_deposit_bank = $balance_before_deposit_bank + $amount;

        BankTransfer::create([
            'company_id' => $request->company_id,
            'client_id' => Auth::user()->id,
            'withdrawal_bank' => $request->withdrawal_bank,
            'deposit_bank' => $request->deposit_bank,
            'reason' => $request->reason,
            'amount' => $amount,
        ]);
        $withdrawal_bank->update([
            'bank_balance' => $balance_after_withdrawal_bank,
            'updated_at' => now()
        ]);
        $deposit_bank->update([
            'bank_balance' => $balance_after_deposit_bank,
            'updated_at' => now()
        ]);
        return redirect()->route('client.banks.transfer')
            ->with('success', 'تم تسجيل العملية بنجاح');
    }

    public function banks_transfer_destroy(Request $request)
    {
        $transfer_id = $request->transferid;
        $transfer = BankTransfer::FindOrFail($transfer_id);
        $amount = $transfer->amount;
        $withdrawal_bank = Bank::FindOrFail($transfer->withdrawal_bank);
        $deposit_bank = Bank::FindOrFail($transfer->deposit_bank);
        $balance_before_withdrawal_bank = $withdrawal_bank->bank_balance;
        $balance_before_deposit_bank = $deposit_bank->bank_balance;

        $balance_after_withdrawal_bank = $balance_before_withdrawal_bank + $amount;
        $balance_after_deposit_bank = $balance_before_deposit_bank - $amount;

        $transfer->delete();
        $withdrawal_bank->update([
            'bank_balance' => $balance_after_withdrawal_bank,
            'updated_at' => now()
        ]);
        $deposit_bank->update([
            'bank_balance' => $balance_after_deposit_bank,
            'updated_at' => now()
        ]);
        return redirect()->route('client.banks.transfer')
            ->with('success', 'تم حذف العملية بنجاح');
    }
    public function bank_safe_transfer()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $banks = $company->banks;
        $safes = $company->safes;
        $bank_safe_transfer = BankSafeTransfer::where('company_id', $company_id)
            ->get();
        return view('client.banks.bank_safe_transfer', compact('banks', 'bank_safe_transfer','safes', 'company_id', 'company'));
    }

    public function bank_safe_transfer_store(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $amount = $request->amount;
        $bank = Bank::FindOrFail($request->bank_id);
        $safe = Safe::FindOrFail($request->safe_id);
        $balance_before_bank = $bank->bank_balance;
        $balance_before_safe = $safe->balance;

        $balance_after_bank = $balance_before_bank - $amount;
        $balance_after_safe = $balance_before_safe + $amount;

        BankSafeTransfer::create([
            'company_id' => $request->company_id,
            'client_id' => Auth::user()->id,
            'bank_id' => $request->bank_id,
            'safe_id' => $request->safe_id,
            'reason' => $request->reason,
            'amount' => $amount,
        ]);
        $bank->update([
            'bank_balance' => $balance_after_bank,
            'updated_at' => now()
        ]);
        $safe->update([
            'balance' => $balance_after_safe,
            'updated_at' => now()
        ]);
        return redirect()->route('client.bank.safe.transfer')
            ->with('success', 'تم تسجيل العملية بنجاح');
    }

    public function bank_safe_transfer_destroy(Request $request)
    {
        $transfer_id = $request->transferid;
        $transfer = BankSafeTransfer::FindOrFail($transfer_id);
        $amount = $transfer->amount;
        $bank = Bank::FindOrFail($transfer->bank_id);
        $safe = Safe::FindOrFail($transfer->safe_id);
        $balance_before_bank = $bank->bank_balance;
        $balance_before_safe = $safe->balance;

        $balance_after_bank = $balance_before_bank + $amount;
        $balance_after_safe = $balance_before_safe - $amount;

        $transfer->delete();
        $bank->update([
            'bank_balance' => $balance_after_bank,
            'updated_at' => now()
        ]);
        $safe->update([
            'balance' => $balance_after_safe,
            'updated_at' => now()
        ]);
        return redirect()->route('client.bank.safe.transfer')
            ->with('success', 'تم حذف العملية بنجاح');
    }


    public function safe_bank_transfer()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $banks = $company->banks;
        $safes = $company->safes;
        $safe_bank_transfer = SafeBankTransfer::where('company_id', $company_id)
            ->get();
        return view('client.banks.safe_bank_transfer', compact('banks', 'safe_bank_transfer','safes', 'company_id', 'company'));
    }

    public function safe_bank_transfer_store(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $amount = $request->amount;
        $safe = Safe::FindOrFail($request->safe_id);
        $bank = Bank::FindOrFail($request->bank_id);
        $balance_before_safe = $safe->balance;
        $balance_before_bank = $bank->bank_balance;

        $balance_after_safe = $balance_before_safe - $amount;
        $balance_after_bank = $balance_before_bank + $amount;

        SafeBankTransfer::create([
            'company_id' => $request->company_id,
            'client_id' => Auth::user()->id,
            'safe_id' => $request->safe_id,
            'bank_id' => $request->bank_id,
            'reason' => $request->reason,
            'amount' => $amount,
        ]);
        $safe->update([
            'balance' => $balance_after_safe,
            'updated_at' => now()
        ]);
        $bank->update([
            'bank_balance' => $balance_after_bank,
            'updated_at' => now()
        ]);
        return redirect()->route('client.safe.bank.transfer')
            ->with('success', 'تم تسجيل العملية بنجاح');
    }

    public function safe_bank_transfer_destroy(Request $request)
    {
        $transfer_id = $request->transferid;
        $transfer = SafeBankTransfer::FindOrFail($transfer_id);
        $amount = $transfer->amount;
        $safe = Safe::FindOrFail($transfer->safe_id);
        $bank = Bank::FindOrFail($transfer->bank_id);
        $balance_before_safe = $safe->balance;
        $balance_before_bank = $bank->bank_balance;

        $balance_after_safe = $balance_before_safe + $amount;
        $balance_after_bank = $balance_before_bank - $amount;
        $transfer->delete();
        $safe->update([
            'balance' => $balance_after_safe,
            'updated_at' => now()
        ]);
        $bank->update([
            'bank_balance' => $balance_after_bank,
            'updated_at' => now()
        ]);
        return redirect()->route('client.safe.bank.transfer')
            ->with('success', 'تم حذف العملية بنجاح');
    }
}
