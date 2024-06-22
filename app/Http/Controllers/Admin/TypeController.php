<?php

namespace App\Http\Controllers\Admin;

use App\Models\Type;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Http\Requests\TypeRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TypeController extends Controller
{
    public function index()
    {
        $types = Type::all();
        return view('admin.types.index', compact('types'));
    }
    public function create()
    {
        $packages = Package::all();
        return view('admin.types.create',compact('packages'));
    }

    public function store(TypeRequest $request)
    {
        $data = $request->all();
        $type = Type::create($data);
        return redirect()->route('admin.types.index')
            ->with('success', 'تم اضافة نوع الاشتراك وسعره بنجاح');
    }

    public function edit($id)
    {
        $type = Type::findOrFail($id);
        $packages = Package::all();
        return view('admin.types.edit', compact('type','packages'));
    }
    public function update(TypeRequest $request, $id)
    {
        $input = $request->all();
        $type = Type::findOrFail($id);
        $type->update($input);
        return redirect()->route('admin.types.index')
            ->with('success', 'تم تعديل بيانات نوع الاشتراك بنجاح');
    }
    public function destroy(Request $request)
    {
        $type = Type::findOrFail($request->typeid);
        $type->delete();
        return redirect()->route('admin.types.index')
            ->with('success', 'تم حذف نوع الاشتراك بنجاح');
    }


}
