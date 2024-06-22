<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::all();
        return view('admin.packages.index', compact('packages'));
    }
    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $package = Package::create($data);
        return redirect()->route('admin.packages.index')
            ->with('success', 'تم اضافة الباقة بنجاح');
    }

    public function edit($id)
    {
        $package = Package::findOrFail($id);
        return view('admin.packages.edit', compact('package'));
    }
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $package = Package::findOrFail($id);
        $package->update($input);
        return redirect()->route('admin.packages.index')
            ->with('success', 'تم تعديل الباقة بنجاح');
    }
    public function destroy(Request $request)
    {
        $package = Package::findOrFail($request->packageid);
        $package->delete();
        return redirect()->route('admin.packages.index')
            ->with('success', 'تم حذف الباقة بنجاح');
    }
}
