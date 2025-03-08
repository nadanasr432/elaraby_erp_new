<?php

namespace App\Http\Controllers\Client;

use App\Models\Company;
use App\Models\Supplier;
use App\Models\TimeZone;
use App\Models\SupplierNote;
use Illuminate\Http\Request;
use App\Models\SupplierPhone;

use App\Models\SupplierAddress;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SupplierRequest;

class SupplierController extends Controller
{
    public function index()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $suppliers = Supplier::where('company_id', $company_id)->get();
        $balances = array();
        foreach ($suppliers as $supplier) {
            $supplier_balance = $supplier->prev_balance;
            array_push($balances, $supplier_balance);
        }
        $total_balances = array_sum($balances);
        return view('client.suppliers.index', compact('company', 'total_balances', 'company_id', 'suppliers'));
    }

    public function create()
{
    $company_id = Auth::user()->company_id;

    // Ensure company_id exists
    if (!$company_id) {
        return redirect()->route('error.page')->with('error', 'Company ID not found!');
    }

    // Fetch company with suppliers & handle if not found
    $company = Company::with('suppliers')->find($company_id);
    if (!$company) {
        return redirect()->route('error.page')->with('error', 'Company not found!');
    }

    $timezones = TimeZone::all();
    $user = Auth::user();
    $type_name = optional($user->company->subscription->type)->type_name ?? '';

    // Determine suppliers limit
    $suppliers_count = ($type_name == "تجربة") ? PHP_INT_MAX : 
        optional($user->company->subscription->type->package)->suppliers_count ?? 0;

    // Count existing suppliers
    $company_suppliers_count = $company->suppliers->count();

    // Allow supplier creation only if within limit
    if ($suppliers_count > $company_suppliers_count) {
        return view('client.suppliers.create', compact('company_id', 'timezones', 'company'));
    } else {
        return redirect()->route('client.home')->with('error', 'باقتك الحالية لا تسمح بالمزيد من الموردين');
    }
}


    public function store(SupplierRequest  $request)
    {
        $data = $request->all();
        $company_id = $data['company_id'];
        $balance = $request->balance;
        if ($balance == "for") {
            $data['prev_balance'] =  $request->prev_balance;
        } elseif ($balance == "on") {
            $data['prev_balance'] = -1 * $request->prev_balance;
        }
        $supplier = Supplier::create($data);
        $notes = $request->notes;
        $phones = $request->phones;
        $addresses = $request->addresses;
        foreach ($notes as $note) {
            SupplierNote::create([
                'supplier_id' => $supplier->id,
                'supplier_note' => $note,
                'company_id' => $company_id,
            ]);
        }
        foreach ($phones as $phone) {
            SupplierPhone::create([
                'supplier_id' => $supplier->id,
                'supplier_phone' => $phone,
                'company_id' => $company_id,
            ]);
        }
        foreach ($addresses as $address) {
            SupplierAddress::create([
                'supplier_id' => $supplier->id,
                'supplier_address' => $address,
                'company_id' => $company_id,
            ]);
        }
        return redirect()->route('client.suppliers.index')
            ->with('success', 'تم اضافة المورد بنجاح');
    }

    public function show($id)
    {
        $supplier = Supplier::FindOrFail($id);
        return view('client.suppliers.show', compact('supplier'));
    }

    public function edit($id)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $timezones = TimeZone::all();
        $supplier = Supplier::findOrFail($id);
        return view('client.suppliers.edit', compact('timezones', 'supplier', 'company_id', 'company'));
    }

    public function update(SupplierRequest  $request, $id)
    {
        $data = $request->all();
        $company_id = $data['company_id'];
        $supplier = Supplier::FindOrFail($id);
        $balance = $request->balance;
        if ($balance == "for") {
            $data['prev_balance'] =  $request->prev_balance;
        } elseif ($balance == "on") {
            $data['prev_balance'] = -1 * $request->prev_balance;
        }
        $supplier->update($data);
        $notes = $request->notes;
        $phones = $request->phones;
        $addresses = $request->addresses;
        $supplier->notes()->delete();
        $supplier->phones()->delete();
        $supplier->addresses()->delete();
        foreach ($notes as $note) {
            SupplierNote::create([
                'supplier_id' => $supplier->id,
                'supplier_note' => $note,
                'company_id' => $company_id,
            ]);
        }
        foreach ($phones as $phone) {
            SupplierPhone::create([
                'supplier_id' => $supplier->id,
                'supplier_phone' => $phone,
                'company_id' => $company_id,
            ]);
        }
        foreach ($addresses as $address) {
            SupplierAddress::create([
                'supplier_id' => $supplier->id,
                'supplier_address' => $address,
                'company_id' => $company_id,
            ]);
        }
        return redirect()->route('client.suppliers.index')
            ->with('success', 'تم تعديل المورد بنجاح');
    }

    public function destroy(Request $request)
    {
        $supplier = Supplier::FindOrFail($request->supplierid);
        if ($supplier->prev_balance != '0') {
            return redirect()->route('client.suppliers.index')
                ->with('error', 'هذا المورد عليه مستحقات من فواتير سابقة');
        } else {
            $supplier->phones()->delete();
            $supplier->notes()->delete();
            $supplier->addresses()->delete();
            $supplier->delete();
            return redirect()->route('client.suppliers.index')
                ->with('success', 'تم حذف المورد بنجاح');
        }
    }

    public function print()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $suppliers = Supplier::where('company_id', $company_id)->get();
        return view('client.suppliers.print', compact('suppliers', 'company'));
    }

    public function filter_suppliers()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $nationals = Supplier::where('company_id', $company_id)
            ->groupBy('supplier_national')
            ->select('supplier_national')
            ->get();
        return view('client.suppliers.filter', compact('nationals', 'company'));
    }

    public function filter_key(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $nationals = Supplier::where('company_id', $company_id)
            ->groupBy('supplier_national')
            ->select('supplier_national')
            ->get();
        if (isset($request->national)) {
            $national = $request->national;
            $suppliers = Supplier::where('company_id', $company_id)
                ->where('supplier_national', 'like', '%' . $national . '%')
                ->get();
        } elseif (isset($request->category)) {
            $category = $request->category;
            $suppliers = Supplier::where('company_id', $company_id)
                ->where('supplier_category', 'like', '%' . $category . '%')
                ->get();
        }
        return view('client.suppliers.filter', compact('suppliers', 'nationals', 'company'));
    }

}
