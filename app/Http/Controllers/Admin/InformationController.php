<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Information;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InformationController extends Controller
{
    public function index(){
        $informations = Information::first();
        return view('admin.informations.index',compact('informations'));
    }
    public function post(Request $request){
        $data = $request->all();
        $admin_id = Auth::user()->id;
        $data['admin_id'] = $admin_id;
        $check = Information::first();
        if (empty($check)){
            $information = Information::create($data);
        }
        else{
            $information = $check->update($data);
        }
        return redirect()->route('informations.get');
    }
}
