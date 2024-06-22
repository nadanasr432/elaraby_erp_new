<?php

namespace App\Http\Controllers\Client;

use App\Models\Branch;
use App\Models\Screen;
use App\Models\Company;
use App\Models\PosSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\BranchRequest;
use Illuminate\Support\Facades\Auth;


class BranchController extends Controller
{
    public function index(){
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $branches = $company->branches;
        return view('client.branches.index',compact('company','company_id','branches'));
    }
    public function create()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        return view('client.branches.create',compact('company_id','company'));
    }

    public function store(BranchRequest $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $data = $request->all();
        $branch = Branch::create($data);
        $pos_settings = PosSetting::create([
            'company_id' => $company_id,
            'branch_id' => $branch->id,
            'status' => 'open'
        ]);
        $screens = Screen::create([
            'company_id' => $company_id,
            'branch_id' => $branch->id
        ]);
        return redirect()->route('client.branches.index')
            ->with('success', 'تم اضافة الفرع بنجاح');
    }

    public function edit($id)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $branch = Branch::findOrFail($id);
        return view('client.branches.edit', compact('branch', 'company_id', 'company'));
    }
    public function update(BranchRequest $request, $id)
    {
        $input = $request->all();
        $branch = Branch::findOrFail($id);
        $branch->update($input);
        return redirect()->route('client.branches.index')
            ->with('success', 'تم تعديل بيانات الفرع بنجاح');
    }
    public function destroy(Request $request)
    {
        $branch = Branch::findOrFail($request->branchid);
        $branch->delete();
        return redirect()->route('client.branches.index')
            ->with('success', 'تم حذف الفرع بنجاح');
    }
}
