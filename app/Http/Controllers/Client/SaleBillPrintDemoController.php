<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\SaleBillPrintDemo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SaleBillPrintDemoController extends Controller
{
    public function edit_print_demo()
    {
        $company_id = Auth::user()->company_id;
        $client_id = Auth::user()->id;
        $print_demo = SaleBillPrintDemo::where('company_id',$company_id)->first();
        return view('client.sale_bills.print_demo',compact('company_id','client_id','print_demo'));
    }
    public function update_print_demo(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $client_id = Auth::user()->id;
        $data = $request->all();
        $data['company_id'] = $company_id;
        $data['client_id'] = $client_id;
        $print_demo = SaleBillPrintDemo::where('company_id',$company_id)->first();
        if (empty($print_demo)){
            SaleBillPrintDemo::create($data);
        }
        else{
            $print_demo->update($data);
        }
        return redirect()->route('print.demo')->with('success','تم تعديل مسميات حقول طباعة فاتورة المبيعات بنجاح');
    }

}
