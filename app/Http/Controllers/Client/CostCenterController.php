<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\CostCenter;
use Illuminate\Http\Request;
use Auth;

class CostCenterController extends Controller
{
    public function index(Request $request)
    {

        $client_id = Auth::user()->id;

        $cost_centers  = CostCenter::where('client_id',$client_id)->get();

        return view('client.cost_center.index', compact( 'cost_centers'));
    }

    public function get_cost_center(Request $request)
    {
        $client_id = Auth::user()->id;
        $cost_center  = CostCenter::where('client_id',$client_id)->where('id',$request->id)->first();

        return response()->json($cost_center);
    }

    public function create_cost_center()
    {
        $client_id = Auth::user()->id;


        $id = CostCenter::where('parent_id', '=', Null)->latest()->pluck('account_number')->first();

        $categories = CostCenter::where('parent_id', '=', Null)->where('client_id',$client_id)->get();

        $allCategories = CostCenter::where('client_id',$client_id)->pluck('account_name', 'id')->all();
        return view('client.cost_center.create', compact( 'id', 'categories', 'allCategories'));


    }

    public function store_cost_center(Request $request)
    {
        $client_id = Auth::user()->id;
        // $account_type = $request->account_type;
        $cost_center = CostCenter::where('id',$request->account_id)->first();

        if(!isset($cost_center)){
        $cost_center = new CostCenter();
        $cost_center->type = $request->type;
        $cost_center->account_number = $request->account_number;
        $cost_center->account_name = $request->account_name;
        $cost_center->account_name_en = $request->account_name_en;
        $cost_center->level = $request->level;
        $cost_center->parent_id = $request->parent_id;
        $cost_center->period = $request->period;
        $cost_center->value = $request->period;
        $cost_center->responsible_name = $request->responsible_name;
        $cost_center->email = $request->email;
        $cost_center->phone = $request->phone;
        $cost_center->location = $request->location;
        $cost_center->started_at = $request->started_at;
        $cost_center->ended_at = $request->ended_at;
        $cost_center->save();

        return redirect()->back()
            ->with('success', 'تم اضافة مركز التكلفة بنجاح');}
            else{
                $cost_center->update([
                    'type'=> ($request->type) ? $request->type : $cost_center->type,
                    'account_number'=> ($request->account_number) ? $request->account_number : $cost_center->account_number,
                    'account_name'=> ($request->account_name) ? $request->account_name : $cost_center->account_name,
                    'account_name_en'=> ($request->account_name_en) ? $request->account_name_en : $cost_center->account_name_en,
                    'period'=> ($request->period) ? $request->period : $cost_center->period,
                    'value'=> ($request->value) ? $request->value : $cost_center->value,
                    'responsible_name'=> ($request->responsible_name) ? $request->responsible_name : $cost_center->responsible_name,
                    'email'=> ($request->email) ? $request->email : $cost_center->email,
                    'phone'=> ($request->phone) ? $request->phone : $cost_center->phone,
                    'location'=> ($request->location) ? $request->location : $cost_center->location,
                    'started_at'=> ($request->started_at) ? $request->started_at : $cost_center->started_at,
                    'ended_at'=> ($request->ended_at) ? $request->ended_at : $cost_center->ended_at,
                ]);
                 return redirect()->back()
                 ->with('success', 'تم تعديل مركز التكلفة بنجاح');
            }
    }

    public function delete_cost_center(Request $request){

        $client_id = Auth::user()->id;
        $cost_center = CostCenter::where('id',$request->id)->first();
      if(isset($cost_center)){
        $accounting_parent = CostCenter::where('parent_id',$request->id)->get();
        if(count($accounting_parent)>0){
            foreach($accounting_parent as $cost){
                $cost->delete();
            }
        }
        $cost_center->delete();
        return response()->json();
      }

    }
}
