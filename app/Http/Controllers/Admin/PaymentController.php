<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use App\Models\Payment;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\ExtraSettings;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PaymentRequest;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::all();
        return view('admin.payments.index', compact('payments'));
    }

    public function create()
    {
        $companies = Company::all();
        return view('admin.payments.create', compact('companies'));
    }

    public function store(PaymentRequest  $request)
    {
        $data = $request->all();
        $payment = Payment::create($data);
        return redirect()->route('admin.payments.index')
            ->with('success', 'تم اضافة المدفوعات بنجاح');
    }

    public function edit($id)
    {
        $companies = Company::all();
        $payment = Payment::findOrFail($id);
        return view('admin.payments.edit', compact('payment', 'companies'));
    }

    public function update(PaymentRequest  $request, $id)
    {
        $input = $request->all();
        $payment = Payment::findOrFail($id);
        $payment->update($input);
        return redirect()->route('admin.payments.index')
            ->with('success', 'تم تعديل المدفوعات بنجاح');
    }

    public function destroy(Request $request)
    {
        $payment = Payment::findOrFail($request->paymentid);
        $payment->delete();
        return redirect()->route('admin.payments.index')
            ->with('success', 'تم حذف المدفوعات بنجاح');
    }
    public function get_report()
    {
        $companies = Company::all();
        return view('admin.payments.report', compact('companies'));
    }
}
