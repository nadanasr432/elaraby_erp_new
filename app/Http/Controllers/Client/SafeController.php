<?php

namespace App\Http\Controllers\Client;

use App\Models\Safe;
use App\Models\Branch;
use App\Models\Company;
use App\Models\SafeTransfer;
use Illuminate\Http\Request;
use App\Http\Requests\SafeRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class SafeController extends Controller
{
    public function index()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $safes = $company->safes;
        return view('client.safes.index', compact('company', 'company_id', 'safes'));
    }

    public function create()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $branches = Branch::where('company_id', $company_id)->get();
        return view('client.safes.create', compact('company_id', 'branches', 'company'));
    }

    public function store(SafeRequest  $request)
    {
        $data = $request->all();
        $safe = safe::create($data);
        return redirect()->route('client.safes.index')
            ->with('success', 'تم اضافة الخزينة بنجاح');
    }

    public function edit($id)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $branches = Branch::where('company_id', $company_id)->get();
        $safe = safe::findOrFail($id);
        return view('client.safes.edit', compact('safe', 'branches', 'company_id', 'company'));
    }

    public function update(SafeRequest  $request, $id)
    {
        $input = $request->all();
        $safe = safe::findOrFail($id);
        $safe->update($input);
        return redirect()->route('client.safes.index')
            ->with('success', 'تم تعديل بيانات الخزينة بنجاح');
    }

    public function destroy(Request $request)
    {
        safe::findOrFail($request->safeid)->delete();
        return redirect()->route('client.safes.index')
            ->with('success', 'تم حذف الخزينة بنجاح');
    }

    public function transfer_get()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $safes = $company->safes;
        $transfers = SafeTransfer::where('company_id',$company_id)->get();
        return view('client.safes.transfer', compact('company','transfers', 'company_id', 'safes'));
    }

    public function transfer_post(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $safes = $company->safes;
        $from_safe = Safe::FindOrFail($request->from_safe);
        $to_safe = Safe::FindOrFail($request->to_safe);
        $amount = $request->amount;
        $data = $request->all();
        if ($amount <= 0) {
            return redirect()->route('client.safes.transfer')
                ->with('error', 'اكتب قيمة صحيحة');
        } else {
            if ($from_safe == $to_safe) {
                return redirect()->route('client.safes.transfer')
                    ->with('error', 'لابد ان تكون الخزنتين مختلفتين');
            } else {
                $old_from_safe_balance = $from_safe->balance;
                $old_to_safe_balance = $to_safe->balance;
                $new_from_safe_balance = $old_from_safe_balance - $amount;
                $new_to_safe_balance = $old_to_safe_balance + $amount;
                $from_safe->update([
                    'balance' => $new_from_safe_balance,
                ]);
                $to_safe->update([
                    'balance' => $new_to_safe_balance,
                ]);
                $data['client_id'] = Auth::user()->id;
                SafeTransfer::create($data);
                return redirect()->route('client.safes.transfer')
                    ->with('success', 'تم التحويل بنجاح');
            }
        }
    }
    public function transfer_destroy(Request $request){
        $transfer_id = $request->transferid;
        $transfer = SafeTransfer::FindOrFail($transfer_id);
        $from_safe = Safe::FindOrFail($transfer->from_safe);
        $to_safe = Safe::FindOrFail($transfer->to_safe);
        $amount = $transfer->amount;
        $old_from_safe_balance = $from_safe->balance;
        $old_to_safe_balance = $to_safe->balance;
        $new_from_safe_balance = $old_from_safe_balance + $amount;
        $new_to_safe_balance = $old_to_safe_balance - $amount;
        $from_safe->update([
            'balance' => $new_from_safe_balance,
        ]);
        $to_safe->update([
            'balance' => $new_to_safe_balance,
        ]);
        $transfer->delete();
        return redirect()->route('client.safes.transfer')->with('success','تم حذف العملية بنجاح');
    }

}
