<?php

namespace App\Http\Controllers\Client;

use App\Models\Safe;
use App\Models\Company;
use App\Models\Employee;
use App\Models\EmployeeCash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\PostCashRequest;

class EmployeeController extends Controller
{
    public function index()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $employees = $company->employees;
        return view('client.employees.index',compact('company_id','company','employees'));
    }

    public function create()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $user = Auth::user();
        $type_name = $user->company->subscription->type->type_name;
        if ($type_name == "تجربة"){
            $employees_count = "غير محدود";
        }
        else{
            $employees_count = $user->company->subscription->type->package->employees_count;
        }
        $company_employees_count = $company->employees->count();
        if ($employees_count == "غير محدود") {
            return view('client.employees.create', compact('company_id', 'company'));
        }
        else{
            if($employees_count > $company_employees_count){
                return view('client.employees.create', compact('company_id', 'company'));
            }
            else{
                return redirect()->route('client.home')->with('error','باقتك الحالية لا تسمح بالمزيد من الموظفين');
            }
        }
    }

    public function store(EmployeeRequest $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $data = $request->all();
        $client_id = Auth::user()->id;
        $data['client_id'] = $client_id;
        $employee = Employee::create($data);
        return redirect()->route('client.employees.index')
            ->with('success', 'تم اضافة الموظف بنجاح');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $employee = Employee::FindOrFail($id);
        return view('client.employees.edit', compact('company_id','employee', 'company'));
    }

    public function update(EmployeeRequest $request, $id)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $data = $request->all();
        $employee = Employee::findOrFail($id);
        $data['employee_id'] = Auth::user()->id;
        $employee->update($data);
        return redirect()->route('client.employees.index')
            ->with('success', 'تم تعديل بيانات الموظف بنجاح');
    }

    public function destroy(Request $request)
    {
        $employee = Employee::FindOrFail($request->employeeid);
        $employee->delete();
        return redirect()->route('client.employees.index')
            ->with('success', 'تم حذف الموظف بنجاح');
    }

    public function cashs()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $employees_cashs = $company->employees_cashs;
        return view('client.employees.cashs',compact('company_id','company','employees_cashs'));
    }

    public function get_cash(){
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $employees = $company->employees;
        $safes = $company->safes;
        return view('client.employees.cash',compact('company','safes','company_id','employees'));
    }
    public function post_cash(PostCashRequest  $request){
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $data = $request->all();
        $data['client_id'] = Auth::user()->id;
        $amount = $data['amount'];
        $safe_id = $data['safe_id'];
        $safe = Safe::FindOrFail($safe_id);
        $old_balance = $safe->balance;
        $new_balance = $old_balance - $amount;
        $safe->update([
            'balance' => $new_balance,
        ]);
        $employee = EmployeeCash::create($data);
        return redirect()->route('employees.cashs')
            ->with('success', 'تم تسجيل الدفعة بنجاح');
    }
    public function edit_cash($id)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $employee_cash = EmployeeCash::FindOrFail($id);
        $employees = $company->employees;
        $safes = $company->safes;
        return view('client.employees.edit_cash', compact('company_id','safes','employees','employee_cash', 'company'));
    }

    public function update_cash(PostCashRequest  $request, $id)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $data = $request->all();
        $data['client_id'] = Auth::user()->id;
        // return old values
        $employee_cash = EmployeeCash::FindOrFail($id);
        $old_safe_id = $employee_cash->safe_id;
        $old_safe = Safe::FindOrFail($old_safe_id);
        $old_amount = $employee_cash->amount;
        $old_safe_balance = $old_safe->balance;
        $new_safe_balance = $old_safe_balance + $old_amount;
        $old_safe->update([
            'balance' => $new_safe_balance,
        ]);
        // assign new values
        $company_id = $data['company_id'];
        $data['client_id'] = Auth::user()->id;
        $amount = $data['amount'];
        $safe_id = $data['safe_id'];
        $safe = Safe::FindOrFail($safe_id);
        $old_balance = $safe->balance;
        $new_balance = $old_balance - $amount;
        $safe->update([
            'balance' => $new_balance,
        ]);
        $cash = EmployeeCash::FindOrFail($id);
        $cash->update($data);
        return redirect()->route('employees.cashs')
            ->with('success', 'تم تعديل الدفعة بنجاح');
    }
    public function destroy_cash(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $data = $request->all();
        // return old values
        $employee_cash = EmployeeCash::FindOrFail($request->employeeid);
        $old_safe_id = $employee_cash->safe_id;
        $old_safe = Safe::FindOrFail($old_safe_id);
        $old_amount = $employee_cash->amount;
        $old_safe_balance = $old_safe->balance;
        $new_safe_balance = $old_safe_balance + $old_amount;
        $old_safe->update([
            'balance' => $new_safe_balance,
        ]);
        $cash = EmployeeCash::FindOrFail($request->employeeid);
        $cash->delete();
        return redirect()->route('employees.cashs')
            ->with('success', 'تم حذف الدفعة بنجاح');
    }

}
