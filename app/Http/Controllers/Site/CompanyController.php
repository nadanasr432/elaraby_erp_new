<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\BasicSettings;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Client;
use App\Models\OuterClient;
use App\Models\PosSetting;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\ClientProfile;
use App\Models\Company;
use App\Models\ExtraSettings;
use App\Models\Fiscal;

use App\Models\Safe;
use App\Models\Screen;
use App\Models\Store;
use App\Models\Subscription;
use App\Models\Type;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

Carbon::setLocale('ar');

class CompanyController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();
        $data['status'] = 'active';
        $data['all_users_access_main_branch'] = 'no';
        $company = Company::create($data);
        if ($request->hasFile('company_logo')) {
            $image = $request->file('company_logo');
            $fileName = $image->getClientOriginalName();
            $uploadDir = 'uploads/companies/logos/' . $company->id;
            $image->move($uploadDir, $fileName);
            $company->company_logo = $uploadDir . '/' . $fileName;
            $company->save();
        }
        $check = Type::where('type_name', 'تجربة')
            ->where('type_price', '0')
            ->first();
        if (empty($check)) {
            $type = Type::create([
                'type_name' => 'تجربة',
                'type_price' => '0',
                'period' => '2',
            ]);
        } else {
            $type = $check;
        }
        $subscription = Subscription::create([
            'type_id' => $type->id,
            'period' => $type->period,
            'start_date' => date('Y-m-d'),
            'end_date' => date("Y-m-d", strtotime("+$type->period day")),
            'status' => 'active',
            'company_id' => $company->id
        ]);
        $basic_settings = BasicSettings::create([
            'header' => '',
            'footer' => '',
            'electronic_stamp' => '',
            'company_id' => $company->id
        ]);
        $extra_settings = ExtraSettings::create([
            'timezone' => $request->country,
            'currency' => $request->currency,
            'company_id' => $company->id,
            'font_size' => '12'
        ]);
        $unit = Unit::create([
            'unit_name' => 'كيلو',
            'company_id' => $company->id,
        ]);
        $unit = Unit::create([
            'unit_name' => 'طن',
            'company_id' => $company->id,
        ]);
        $unit = Unit::create([
            'unit_name' => 'وحدة',
            'company_id' => $company->id,
        ]);

        $company_id = $company->id;
        return Redirect::route('index4', compact('company_id'));
    }

    public function store_s2(Request $request)
    {
        $company_id = $request->company_id;
        $company = Company::FindOrFail($company_id);
        $have_branches = $request->have_branches;
        $check = Fiscal::where('company_id', $company_id)
            ->where('fiscal_year', $request->fiscal_year)
            ->where('start_date', $request->start_date)
            ->where('end_date', $request->end_date)
            ->first();
        if (empty($check)) {
            $fiscal = Fiscal::create($request->all());
        }
        if (empty($have_branches)) {
            // no branches
            $branch = Branch::create([
                'company_id' => $company_id,
                'branch_name' => 'الفرع الرئيسى',
                'branch_phone' => '',
                'branch_address' => ''
            ]);
            $PosSetting = PosSetting::create([
                'company_id' => $company_id,
                'branch_id' => $branch->id,
                'status' => 'open'
            ]);
            $screens = Screen::create([
                'company_id' => $company_id,
                'branch_id' => $branch->id
            ]);
            $store = Store::create([
                'company_id' => $company_id,
                'branch_id' => $branch->id,
                'store_name' => 'المخزن الرئيسى'
            ]);
            $safe = Safe::create([
                'company_id' => $company_id,
                'branch_id' => $branch->id,
                'safe_name' => 'الخزنة الرئيسية',
                'balance' => 0,
                'type' => 'main'
            ]);

            $category = Category::create([
                'company_id' => $company_id,
                'category_name' => 'مخزونية',
                'category_type' => 'مخزونية'
            ]);
            $category = Category::create([
                'company_id' => $company_id,
                'category_name' => 'خدمية',
                'category_type' => 'خدمية'
            ]);
            return Redirect::route('index5', compact('company_id'));
        } else {
            // have branches
            $branches = Branch::where('company_id', $company_id)->get();
            return Redirect::route('branches', compact('company_id', 'branches'));
        }
    }

    public function admin_login(Request $request)
    {
        $password = $request->password;
        $company_id = $request->company_id;
        $data = $request->all();
        $email = $request->email;
        $data['company_id'] = $company_id;
        $phone_number = $request->phone_number;
        $check = Client::where('email', $email)
            ->orWhere('phone_number', $phone_number)
            ->first();
        if (empty($check)) {
            $data['password'] = Hash::make($data['password']);
            $client = Client::create($data);
            $client->email_verified_at = now();
            $client->Status = "active";
            $client->save();

            $outer_client = OuterClient::create([
                'company_id' => $company_id,
                'client_name' => 'Cash',
                'client_category' => 'جملة',
                'prev_balance' => '0',
            ]);
            $supplier = Supplier::create([
                'company_id' => $company_id,
                'supplier_name' => 'Cash',
                'supplier_category' => 'جملة',
                'prev_balance' => '0',
            ]);
            $check = Role::where('name', 'مدير النظام')->where('guard_name', 'client-web')->first();
            if (empty($check)) {
                $role = Role::create([
                    'name' => 'مدير النظام',
                    'guard_name' => 'client-web',
                    'company_id' => $company_id
                ]);
                $permissions = Permission::pluck('id', 'id')->all();
                $role->syncPermissions($permissions);
                $client->assignRole($role->name);

                // other  roles and permissions
                $role = Role::create([
                    'name' => 'مستخدم',
                    'guard_name' => 'client-web',
                    'company_id' => $company_id
                ]);
                $role->syncPermissions([11,14,17,27,28,39,42]);
            } else {
                $client->assignRole($request->input('role_name'));
            }
            $profile = ClientProfile::create([
                'city_name' => '',
                'age' => '',
                'gender' => '',
                'profile_pic' => 'images/guest.png',
                'client_id' => $client->id,
                'company_id' => $company_id
            ]);
            return Redirect::route('client.login');
        } else {
            $company = Company::FindOrFail($company_id);
            return redirect()->route('index5', compact('company_id'))->withInput()->with('error', 'البريد الالكترونى  او  رقم الهاتف مستخدم من قبل');
        }

    }

    public function store_branch(Request $request)
    {
        $input = $request->all();
        $company_id = $input['company_id'];
        $branch = Branch::create($input);
        $PosSetting = PosSetting::create([
            'company_id' => $company_id,
            'branch_id' => $branch->id,
            'status' => 'open'
        ]);
        $screens = Screen::create([
            'company_id' => $company_id,
            'branch_id' => $branch->id
        ]);
        $branches = Branch::where('company_id', $company_id)->get();
        return Redirect::route('branches', compact('company_id', 'branches'));
    }

    public function stores($id)
    {
        $company_id = $id;
        $stores = Store::where('company_id', $company_id)->get();
        $branches = Branch::where('company_id', $company_id)->get();
        return Redirect::route('stores', compact('company_id', 'stores', 'branches'));
    }

    public function store_store(Request $request)
    {
        $input = $request->all();
        $company_id = $input['company_id'];
        $store = Store::create($input);
        $stores = Store::where('company_id', $company_id)->get();
        $branches = Branch::where('company_id', $company_id)->get();
        return Redirect::route('stores', compact('company_id', 'branches', 'stores'));
    }

    public function safes($id)
    {
        $company_id = $id;
        $safes = Safe::where('company_id', $company_id)->get();
        $branches = Branch::where('company_id', $company_id)->get();
        return Redirect::route('safes', compact('company_id', 'safes', 'branches'));
    }

    public function safe_store(Request $request)
    {
        $input = $request->all();
        $company_id = $input['company_id'];
        $input['type'] = "main";
        $input['balance'] = 0;
        $safe = Safe::create($input);
        $safes = Safe::where('company_id', $company_id)->get();
        $branches = Branch::where('company_id', $company_id)->get();
        return Redirect::route('safes', compact('company_id', 'branches', 'safes'));
    }

    public function to_admin_login($id)
    {
        $company_id = $id;
        return Redirect::route('index5', compact('company_id'));
    }
}
