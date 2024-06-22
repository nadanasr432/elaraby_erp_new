<?php

namespace App\Http\Controllers\Client;

use App\Models\Safe;
use App\Models\Company;
use App\Models\Expense;
use App\Models\Employee;
use App\Models\FixedExpense;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ExpenseRequest;
use App\Http\Requests\FixedExpenseRequest;


class ExpenseController extends Controller
{
    public function fixed_expenses(){
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $fixed_expenses = FixedExpense::where('company_id',$company_id)->get();
        return view('client.expenses.fixed', compact('company', 'company_id', 'fixed_expenses'));
    }
    public function fixed_expenses_store(FixedExpenseRequest $request){
        $data = $request->all();
        $company_id = $data['company_id'];
        $data['client_id'] = Auth::user()->id;
        $fixed_expense = FixedExpense::create($data);
        return redirect()->route('client.fixed.expenses')
            ->with('success', 'تم اضافة المصروف الثابت بنجاح');
    }

    public function fixed_expenses_edit($id)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $fixed_expense = FixedExpense::findOrFail($id);
        return view('client.expenses.fixed_edit', compact('fixed_expense', 'company_id', 'company'));
    }
    public function fixed_expenses_update(FixedExpenseRequest $request, $id)
    {
        $data = $request->all();
        $company_id = $data['company_id'];
        $data['client_id'] = Auth::user()->id;
        $fixed_expense = FixedExpense::FindOrFail($id);
        $fixed_expense->update($data);
        return redirect()->route('client.fixed.expenses')
            ->with('success', 'تم تعديل المصروف الثابت بنجاح');
    }

    public function fixed_expenses_destroy(Request $request)
    {
        FixedExpense::FindOrFail($request->fixed_expenseid)->delete();
        return redirect()->route('client.fixed.expenses')
            ->with('success', 'تم حذف المصروف الثابت بنجاح');
    }

    public function index()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $expenses = $company->expenses;
        return view('client.expenses.index', compact('company', 'company_id', 'expenses'));
    }

    public function create()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $check = Expense::all();
        if ($check->isEmpty()) {
            $pre_expenses = 1;
        } else {
            $old_expense = Expense::max('expense_number');
            $pre_expenses = ++$old_expense;
        }
        $fixed_expenses = FixedExpense::where('company_id',$company_id)->get();
        $safes = Safe::where('company_id',$company_id)->get();
        $employees = Employee::where('company_id',$company_id)->get();
        return view('client.expenses.create', compact('company_id','employees','safes','fixed_expenses', 'pre_expenses', 'company'));
    }

    public function store(ExpenseRequest $request)
    {
        $data = $request->all();
        $company_id = $data['company_id'];
        $data['client_id'] = Auth::user()->id;
        $expense = Expense::create($data);
        if ($request->hasFile('expense_pic')) {
            $expense_pic = $request->file('expense_pic');
            $fileName = $expense_pic->getClientOriginalName();
            $uploadDir = 'uploads/expenses/' . $expense->id;
            $expense_pic->move($uploadDir, $fileName);
            $expense->expense_pic = $uploadDir . '/' . $fileName;
            $expense->save();
        }
        $safe_id = $data['safe_id'];
        $safe = Safe::FindOrFail($safe_id);
        $old_balance = $safe->balance;
        $new_balance = $old_balance - $data['amount'];
        $safe->update([
            'balance' => $new_balance,
        ]);
        return redirect()->route('client.expenses.index')
            ->with('success', 'تم اضافة المصروف بنجاح');
    }

    public function edit($id)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $expense = Expense::findOrFail($id);
        $fixed_expenses = FixedExpense::where('company_id',$company_id)->get();
        $safes = Safe::where('company_id',$company_id)->get();
        $employees = Employee::where('company_id',$company_id)->get();
        return view('client.expenses.edit', compact('expense','employees','fixed_expenses','safes', 'company_id', 'company'));
    }

    public function update(ExpenseRequest $request, $id)
    {
        $data = $request->all();
        $company_id = $data['company_id'];
        $data['client_id'] = Auth::user()->id;
        $expense = Expense::FindOrFail($id);

        $old_safe_id = $expense->safe_id;
        $old_safe = Safe::FindOrFail($old_safe_id);
        $old_safe_amount = $expense->amount;
        $old_safe_balance = $old_safe->balance;
        $new_safe_balance = $old_safe_balance + $old_safe_amount;
        $old_safe->update([
            'balance' => $new_safe_balance,
        ]);

        $safe_id = $data['safe_id'];
        $safe = Safe::FindOrFail($safe_id);
        $old_amount = $expense->amount;
        $old_balance = $safe->balance;
        $new_balance = $old_balance - $data['amount'];
        $safe->update([
            'balance' => $new_balance,
        ]);

        $expense->update($data);
        if ($request->hasFile('expense_pic')) {
            $expense_pic = $request->file('expense_pic');
            $fileName = $expense_pic->getClientOriginalName();
            $uploadDir = 'uploads/expenses/' . $expense->id;
            $expense_pic->move($uploadDir, $fileName);
            $expense->expense_pic = $uploadDir . '/' . $fileName;
            $expense->save();
        }
        return redirect()->route('client.expenses.index')
            ->with('success', 'تم تعديل المصروف بنجاح');
    }

    public function destroy(Request $request)
    {
        Expense::findOrFail($request->expenseid)->delete();
        return redirect()->route('client.expenses.index')
            ->with('success', 'تم حذف المصروف بنجاح');
    }
}
