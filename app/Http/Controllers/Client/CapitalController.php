<?php

namespace App\Http\Controllers\Client;

use App\Models\Safe;
use App\Models\Capital;
use App\Models\Company;
use App\Models\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CapitalRequest;


class CapitalController extends Controller
{
    public function index()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $capitals = $company->capitals;
        return view('client.capitals.index', compact('company', 'company_id', 'capitals'));
    }

    public function create()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $safes = Safe::where('company_id',$company_id)->get();
        return view('client.capitals.create', compact('company_id', 'safes', 'company'));
    }

    public function store(CapitalRequest  $request)
    {
        $data = $request->all();
        $company_id = $data['company_id'];
        $amount = $data['amount'];
        $safe_id = $data['safe_id'];
        $data['client_id'] = Auth::user()->id;
        $safe = Safe::FindOrFail($safe_id);
        $old_balance = $safe->balance;
        $new_balance = $old_balance + $amount;
        $safe->update([
            'balance' => $new_balance,
        ]);
        $data['balance_before'] = $old_balance;
        $data['balance_after'] = $new_balance;
        $capital = Capital::create($data);

        return redirect()->route('client.capitals.index')
            ->with('success', 'تم اضافة المبلغ بنجاح');
    }

    public function edit($id)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $capital = Capital::findOrFail($id);
        $safes = Safe::where('company_id',$company_id)->get();
        return view('client.capitals.edit', compact('capital', 'company_id','safes', 'company'));
    }

    public function update(CapitalRequest  $request, $id)
    {
        
        $data = $request->all();

        // Return the old values before the operation
        $old_capital = Capital::FindOrFail($id);
        $old_safe_id = $old_capital->safe_id;
        $old_safe = Safe::FindOrFail($old_safe_id);
        $old_amount = $old_capital->amount;
        $old_safe_balance = $old_safe->balance;
        $new_safe_balance = $old_safe_balance - $old_amount;
        $old_safe->update([
            'balance' => $new_safe_balance,
        ]);
        // Assign the new values of the operation
        $company_id = $data['company_id'];
        $data['client_id'] = Auth::user()->id;
        $amount = $data['amount'];
        $safe_id = $data['safe_id'];
        $safe = Safe::FindOrFail($safe_id);
        $old_balance = $safe->balance;
        $new_balance = $old_balance + $amount;
        $data['balance_before'] = $old_balance;
        $data['balance_after'] = $new_balance;
        $data['client_id'] = Auth::user()->id;
        $safe->update([
            'balance' => $new_balance,
        ]);
        $capital = capital::FindOrFail($id);
        $capital->update($data);
        return redirect()->route('client.capitals.index')
            ->with('success', 'تم تعديل بيانات العملية بنجاح');
    }

    public function destroy(Request $request)
    {
        $data = $request->all();
        $id = $data['capitalid'];
        // Return the old values before the operation
        $old_capital = Capital::FindOrFail($id);
        $old_safe_id = $old_capital->safe_id;
        $old_safe = Safe::FindOrFail($old_safe_id);
        $old_amount = $old_capital->amount;
        $old_safe_balance = $old_safe->balance;
        $new_safe_balance = $old_safe_balance - $old_amount;
        $old_safe->update([
            'balance' => $new_safe_balance,
        ]);
        Capital::findOrFail($id)->delete();
        return redirect()->route('client.capitals.index')
            ->with('success', 'تم حذف العملية بنجاح');
    }
}
