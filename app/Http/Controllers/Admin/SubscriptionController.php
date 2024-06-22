<?php

namespace App\Http\Controllers\Admin;

use DateTime;
use App\Models\Type;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSubscriptionRequest;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::all();
        return view('admin.subscriptions.index', compact('subscriptions'));
    }
//
    public function edit($id)
    {
        $subscription = Subscription::FindOrFail($id);
        $types = Type::all();
        return view('admin.subscriptions.edit', compact('subscription','types'));
    }
//
    public function update(UpdateSubscriptionRequest $request, $id)
    {
        $input = $request->all();
        $subscription = Subscription::findOrFail($id);
        $type_id = $request->type_id;
        $type = Type::FindOrFail($type_id);
        $period = $type->period;
        $start_date = $request->start_date;
        $start_date = new DateTime($start_date);
        $start_date->modify( "+ $period day");
        $end_date = $start_date->format('Y-m-d');
        $input['end_date'] = $end_date;
        $subscription->update($input);
        $subscription->company->update([
           'status' => 'active'
        ]);
        return redirect()->route('admin.subscriptions.index')
            ->with('success', 'تم تعديل بيانات الاشتراك بنجاح');
    }
    public function get_filter(){
        $types = Type::all();
        return view('admin.subscriptions.filter',compact('types'));
    }
    public function post_filter(Request $request){
        $types = Type::all();
        $type_id = $request->type_id;
        $subscriptions = Subscription::where('type_id',$type_id)->get();
        return view('admin.subscriptions.filter',compact('types','subscriptions'));
    }

}
