<?php

namespace App\Http\Controllers\Client;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\DB;



// use DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Middleware\PermissionMiddleware;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware(PermissionMiddleware::class . ':صلاحيات المستخدمين');
    }

    public function index(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $roles = Role::orderBy('id', 'ASC')
            ->where('company_id',$company_id)
            ->orwhere('name','مدير النظام')
            ->orwhere('name','مستخدمين')
            ->get();
        return view('client.roles.index', compact('roles'));
    }

    public function create()
    {
        $permission = Permission::get();
        return view('client.roles.create', compact('permission'));
    }

    public function store(RoleRequest  $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);

        $role = Role::create([
            'name' => $request->input('name'),
            'guard_name' => 'client-web',
            'company_id' => $company_id
        ]);
        $role->syncPermissions($request->input('permission'));
        return redirect()->route('client.roles.index')
            ->with('success', 'تم اضافة الصلاحية بنجاح');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", $id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();
        return view('client.roles.edit', compact('role', 'permission', 'rolePermissions'));
    }

    public function update(RoleRequest  $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->name = $request->input('name');
        $role->save();
        $role->syncPermissions($request->input('permission'));
        return redirect()->route('client.roles.index')
            ->with('success', 'تم تحديث الدور او الصلاحية بنجاح');
    }

    public function destroy(Request $request)
    {
        DB::table("roles")->where('id', $request->role_id)->delete();
        return redirect()->route('client.roles.index')
            ->with('success', 'تم حذف الدور او الصلاحية بنجاح');
    }


}
