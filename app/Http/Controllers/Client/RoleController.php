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
            ->where('company_id', $company_id)
            ->orwhere('name', 'مدير النظام')
            ->orwhere('name', 'مستخدمين')
            ->get();
        return view('client.roles.index', compact('roles'));
    }

    public function create()
    {
        $permission = Permission::get();
        return view('client.roles.create', compact('permission'));
    }

    public function store(RoleRequest $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::findOrFail($company_id);

        $role = Role::create([
            'name' => $request->input('name'),
            'guard_name' => 'client-web',
            'company_id' => $company_id
        ]);

        // Validate and sync permissions
        $permissions = $request->input('permission', []);
        $validPermissions = Permission::where('guard_name', 'client-web')->whereIn('name', $permissions)->pluck('name');
        $role->syncPermissions($validPermissions);

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

    // use Spatie\Permission\Models\Permission;

    public function update(RoleRequest $request, $id)
    {
        $role = Role::findOrFail($id);

        // Update the role name
        $role->name = $request->input('name');
        $role->save();

        // Convert permission IDs to their names
        $permissions = Permission::whereIn('id', $request->input('permission'))->pluck('name')->toArray();

        // Sync permissions using names
        $role->syncPermissions($permissions);

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
