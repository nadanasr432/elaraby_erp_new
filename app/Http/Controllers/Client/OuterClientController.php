<?php

namespace App\Http\Controllers\Client;

use App\Models\Company;
use App\Models\TimeZone;
use Ramsey\Uuid\Type\Time;
use App\Models\OuterClient;
use Illuminate\Http\Request;
use App\Models\OuterClientNote;

use App\Models\OuterClientPhone;
use App\Models\OuterClientAddress;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\OuterClientRequest;


class OuterClientController extends Controller
{
    public function index()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        if(in_array('مدير النظام',Auth::user()->role_name)){
            $outer_clients = OuterClient::where('company_id', $company_id)->get();
        }
        else{
            $outer_clients = OuterClient::where('company_id', $company_id)
            ->where(function ($query) {
                $query->where('client_id',Auth::user()->id)
                ->orWhereNull('client_id');
            })->get();
        }
        $balances = array();
        foreach ($outer_clients as $outer_client) {
            $client_balance = $outer_client->prev_balance;
            array_push($balances, $client_balance);
        }
        $total_balances = array_sum($balances);
        // dd($outer_clients->toArray());
        return view('client.outer_clients.index', compact('company', 'total_balances', 'company_id', 'outer_clients'));
    }

    public function create()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $timezones = TimeZone::all();
        $clients = $company->clients;
        $user = Auth::user();
        $type_name = $user->company->subscription->type->type_name;
        if ($type_name == "تجربة") {
            $outer_clients_count = "غير محدود";
        } else {
            $outer_clients_count = $user->company->subscription->type->package->employees_count;
        }
        $company_outer_clients_count = $company->outerClients->count();
        if ($outer_clients_count == "غير محدود") {
            return view('client.outer_clients.create', compact('company_id','clients', 'timezones', 'company'));
        } else {
            if ($outer_clients_count > $company_outer_clients_count) {
                return view('client.outer_clients.create', compact('company_id','clients', 'timezones', 'company'));
            } else {
                return redirect()->route('client.home')->with('error', 'باقتك الحالية لا تسمح بالمزيد من العملاء');
            }
        }
    }

    public function store_pos(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $data = $request->all();
        $data['company_id'] = Auth::user()->company_id;
        $outer_client = OuterClient::create($data);
        $phone = $request->client_phone;
        $address = $request->client_address;
        if (isset($address) && !empty($address)) {
            OuterClientAddress::create([
                'outer_client_id' => $outer_client->id,
                'client_address' => $address,
                'company_id' => $company_id,
            ]);
        }

        if (isset($phone) && !empty($phone)) {
            OuterClientPhone::create([
                'outer_client_id' => $outer_client->id,
                'client_phone' => $phone,
                'company_id' => $company_id,
            ]);
        }

        if ($outer_client) {
            return response()->json([
                'status' => true,
                'outer_client_id' => $outer_client->id,
                'client_name' => $outer_client->client_name,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'هناك خطأ فى تسجيل العميل حاول مرة اخرى',
            ]);
        }
    }

    public function show_pos(Request $request)
    {
        $outer_client = OuterClient::FindOrFail($request->outer_client_id);
        echo '
        <div class="col-lg-4 pull-right p-2">
            <p class="alert alert-secondary alert-sm" dir="rtl">
                اسم العميل :
                ' . $outer_client->client_name . '
            </p>
        </div>
        <div class="col-lg-4 pull-right p-2">
            <p class="alert alert-secondary alert-sm" dir="rtl">
                فئة التعامل :
                ' . $outer_client->client_category . '
            </p>
        </div>
        <div class="clearfix"></div>
        <div class="col-lg-4 pull-right p-2">
            <p class="alert alert-secondary alert-sm" dir="rtl">
                مديونية العميل :
                ' . $outer_client->prev_balance . '
            </p>
        </div>
        <div class="col-lg-4 pull-right p-2">
            <p class="alert alert-secondary alert-sm" dir="rtl">
                اسم المحل او الشركة :
                ' . $outer_client->shop_name . '
            </p>
        </div>
        <div class="col-lg-4 pull-right p-2">
            <p class="alert alert-secondary alert-sm" dir="rtl">
                جنسية العميل :
                ' . $outer_client->client_national . '
            </p>
        </div>
        <div class="clearfix"></div>
        <div class="col-lg-6 pull-right p-2">
            <p class="alert alert-secondary alert-sm" dir="rtl">
                البريد الالكترونى :
                ' . $outer_client->client_email . '
            </p>
        </div>
        <div class="col-lg-6 pull-right p-2">
            <p class="alert alert-secondary alert-sm" dir="rtl">
                الرقم الضريبى :
                ' . $outer_client->tax_number . '
            </p>
        </div>
        <div class="clearfix"></div>';
    }


    public function store(OuterClientRequest  $request)
    {
        $data = $request->all();
        $company_id = $data['company_id'];
        $balance = $request->balance;
        if ($balance == "for") {
            $data['prev_balance'] = -1 * $request->prev_balance;
        } elseif ($balance == "on") {
            $data['prev_balance'] = $request->prev_balance;
        }
        $outer_client = OuterClient::create($data);
        $notes = $request->notes;
        $phones = $request->phones;
        $addresses = $request->addresses;

        if (isset($notes) && !empty($notes)) {
            foreach ($notes as $note) {
                OuterClientNote::create([
                    'outer_client_id' => $outer_client->id,
                    'client_note' => $note,
                    'company_id' => $company_id,
                ]);
            }
        }

        if (isset($addresses) && !empty($addresses)) {
            foreach ($addresses as $address) {
                OuterClientAddress::create([
                    'outer_client_id' => $outer_client->id,
                    'client_address' => $address,
                    'company_id' => $company_id,
                ]);
            }
        }

        if (isset($phones) && !empty($phones)) {
            foreach ($phones as $phone) {
                OuterClientPhone::create([
                    'outer_client_id' => $outer_client->id,
                    'client_phone' => $phone,
                    'company_id' => $company_id,
                ]);
            }
        }
        return redirect()->route('client.outer_clients.index')
            ->with('success', 'تم اضافة العميل بنجاح');
    }

    public function show($id)
    {
        $outer_client = OuterClient::FindOrFail($id);
        return view('client.outer_clients.show', compact('outer_client'));
    }

    public function edit($id)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $timezones = TimeZone::all();
        $clients = $company->clients;
        $outer_client = OuterClient::findOrFail($id);
        return view('client.outer_clients.edit', compact('timezones','clients', 'outer_client', 'company_id', 'company'));
    }

    public function update(OuterClientRequest  $request, $id)
    {
        $data = $request->all();
        $company_id = $data['company_id'];
        $balance = $request->balance;
        $outer_client = OuterClient::FindOrFail($id);
        if ($balance == "for") {
            $data['prev_balance'] = -1 * $request->prev_balance;
        } elseif ($balance == "on") {
            $data['prev_balance'] = $request->prev_balance;
        }
        $outer_client->update($data);
        $notes = $request->notes;
        $addresses = $request->addresses;
        $phones = $request->phones;
        $outer_client->notes()->delete();
        $outer_client->addresses()->delete();
        $outer_client->phones()->delete();
        foreach ($notes as $note) {
            OuterClientNote::create([
                'outer_client_id' => $outer_client->id,
                'client_note' => $note,
                'company_id' => $company_id,
            ]);
        }
        foreach ($addresses as $address) {
            OuterClientAddress::create([
                'outer_client_id' => $outer_client->id,
                'client_address' => $address,
                'company_id' => $company_id,
            ]);
        }
        foreach ($phones as $phone) {
            OuterClientPhone::create([
                'outer_client_id' => $outer_client->id,
                'client_phone' => $phone,
                'company_id' => $company_id,
            ]);
        }
        return redirect()->route('client.outer_clients.index')
            ->with('success', 'تم تعديل العميل بنجاح');
    }

    public function destroy(Request $request)
    {
        $outer_client = OuterClient::FindOrFail($request->clientid);
        if ($outer_client->prev_balance != '0') {
            return redirect()->route('client.outer_clients.index')
                ->with('error', 'هذا العميل عليه مديونيات من فواتير سابقة');
        } else {
            $outer_client->phones()->delete();
            $outer_client->notes()->delete();
            $outer_client->addresses()->delete();
            $outer_client->delete();
            return redirect()->route('client.outer_clients.index')
                ->with('success', 'تم حذف العميل بنجاح');
        }
    }

    public function print()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $outer_clients = OuterClient::where('company_id', $company_id)
        ->where(function ($query) {
            $query->where('client_id',Auth::user()->id)
            ->orWhereNull('client_id');
        })->get();
        return view('client.outer_clients.print', compact('outer_clients', 'company'));
    }

    public function filter_clients()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $nationals = OuterClient::where('company_id', $company_id)
            ->groupBy('client_national')
            ->where('client_id',Auth::user()->id)
            ->select('client_national')
            ->get();
        return view('client.outer_clients.filter', compact('nationals', 'company'));
    }

    public function filter_key(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $nationals = OuterClient::where('company_id', $company_id)
            ->groupBy('client_national')
            ->select('client_national')
            ->where('client_id',Auth::user()->id)
            ->get();
        if (isset($request->national)) {
            $national = $request->national;
            $outer_clients = OuterClient::where('company_id', $company_id)
                ->where('client_id',Auth::user()->id)
                ->where('client_national', 'like', '%' . $national . '%')
                ->get();
        } elseif (isset($request->category)) {
            $category = $request->category;
            $outer_clients = OuterClient::where('company_id', $company_id)
                ->where('client_category', 'like', '%' . $category . '%')
                ->where('client_id',Auth::user()->id)
                ->get();
        }
        return view('client.outer_clients.filter', compact('outer_clients', 'nationals', 'company'));
    }

    public function filter_name(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $client_name = $request->client_name;
        $OuterClient = OuterClient::where('company_id', $company_id)
            ->where('client_name', 'LIKE', '%' . $client_name . '%')
            ->where('client_id',Auth::user()->id)
            ->first();
        if (empty($OuterClient)) {
            return redirect()->route('client.home')->with('error', 'لا يوجد عميل بهذا الاسم');
        } else {
            return redirect()->route('client.outer_clients.show', $OuterClient->id);
        }
    }
}
