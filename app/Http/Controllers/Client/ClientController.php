<?php

namespace App\Http\Controllers\Client;

use App\Models\Client;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\ClientProfile;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Middleware\PermissionMiddleware;

class ClientController extends Controller
{
    function __construct()
    {
        $this->middleware(PermissionMiddleware::class . ':صلاحيات المستخدمين');
    }

    public function index(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $data = $company->clients;
        return view('client.clients.index', compact('data'));
    }

    public function create()
    {
        $company_id = Auth::user()->company_id;
        $user = Auth::user();
        $company = Company::FindOrFail($company_id);
        $roles = Role::pluck('name', 'name')->all();
        $branches = $company->branches;
        $type_name = $user->company->subscription->type->type_name;
        if ($type_name == "تجربة") {
            $users_count = "غير محدود";
        } else {
            $users_count = $user->company->subscription->type->package->users_count;
        }
        $company_users_count = $company->clients->count();
        if ($users_count == "غير محدود") {
            return view('client.clients.create', compact('roles', 'branches', 'company', 'company_id'));
        } else {
            if ($users_count > $company_users_count) {
                return view('client.clients.create', compact('roles', 'branches', 'company', 'company_id'));
            } else {
                return redirect()->route('client.home')->with('error', 'باقتك الحالية لا تسمح بالمزيد من المستخدمين');
            }
        }
    }

    public function store(ClientRequest  $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['company_id'] = $company_id;
        $client = Client::create($input);
        $client->email_verified_at = now();
        $client->save();

        $client->assignRole($request->input('role_name'));
        $profile = ClientProfile::create([
            'phone_number' => '',
            'city_name' => '',
            'age' => '',
            'gender' => '',
            'profile_pic' => 'app-assets/images/logo.png',
            'client_id' => $client->id,
            'company_id' => $company_id
        ]);
        return redirect()->route('client.clients.index')
            ->with('success', 'تم اضافة مستخدم بنجاح');
    }

    public function edit($id)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);

        $client = Client::findOrFail($id);
        $roles = Role::pluck('name', 'name')->all();
        $clientRole = $client->roles->pluck('name', 'name')->all();
        $branches = $company->branches;
        return view('client.clients.edit', compact('client', 'branches', 'roles', 'clientRole'));
    }

    public function update(ClientRequest  $request, $id)
    {
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = array_except($input, array('password'));
        }
        $client = Client::findOrFail($id);
        $client->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $client->assignRole($request->input('role_name'));
        return redirect()->route('client.clients.index')
            ->with('success', 'تم تعديل بيانات المستخدم بنجاح');
    }

    public function destroy(Request $request)
    {
        Client::findOrFail($request->client_id)->delete();
        return redirect()->route('client.clients.index')
            ->with('success', 'تم حذف المستخدم بنجاح');
    }
}
