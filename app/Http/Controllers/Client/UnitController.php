<?php

namespace App\Http\Controllers\Client;

use App\Models\Unit;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\UnitRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class UnitController extends Controller
{
    public function index(){
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $units = $company->units;
        return view('client.units.index',compact('company','company_id','units'));
    }
    public function create()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        return view('client.units.create',compact('company_id','company'));
    }

    public function store(UnitRequest  $request)
    {
        $data = $request->all();
        $unit = Unit::create($data);
        return redirect()->route('client.units.index')
            ->with('success', 'تم اضافة الوحدة بنجاح');
    }

    public function edit($id)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $unit = Unit::findOrFail($id);
        return view('client.units.edit', compact('unit', 'company_id', 'company'));
    }
    public function update(UnitRequest  $request, $id)
    {
        $input = $request->all();
        $unit = Unit::findOrFail($id);
        $unit->update($input);
        return redirect()->route('client.units.index')
            ->with('success', 'تم تعديل بيانات الوحدة بنجاح');
    }
    public function destroy(Request $request)
    {
        $unit = Unit::findOrFail($request->unitid);
        $unit->delete();
        return redirect()->route('client.units.index')
            ->with('success', 'تم حذف الوحدة بنجاح');
    }
}
