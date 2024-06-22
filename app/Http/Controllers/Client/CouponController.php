<?php

namespace App\Http\Controllers\Client;

use App\Models\Company;
use App\Models\CouponCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use Illuminate\Support\Facades\Auth;


class CouponController extends Controller
{
    public function index(){
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $coupons = $company->coupons;
        return view('client.coupons.index',compact('company','company_id','coupons'));
    }
    public function create()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $outer_clients = $company->outerClients;
        $categories = $company->categories;
        $products = $company->products;
        return view('client.coupons.create',compact('company_id','categories','products','outer_clients','company'));
    }

    public function store(CouponRequest $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $data = $request->all();
        $data['client_id'] = Auth::user()->id;
        $coupon = CouponCode::create($data);
        return redirect()->route('client.coupons.index')
            ->with('success', 'تم اضافة كوبون الخصم بنجاح');
    }

    public function edit($id)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $coupon = CouponCode::findOrFail($id);
        $outer_clients = $company->outerClients;
        $categories = $company->categories;
        $products = $company->products;
        return view('client.coupons.edit', compact('coupon', 'categories','products','company_id','outer_clients', 'company'));
    }
    public function update(CouponRequest $request, $id)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $data = $request->all();
        $data['client_id'] = Auth::user()->id;
        $coupon = CouponCode::findOrFail($id);
        $coupon->update($data);
        return redirect()->route('client.coupons.index')
            ->with('success', 'تم تعديل بيانات كوبون الخصم بنجاح');
    }
    public function destroy(Request $request)
    {
        $coupon = CouponCode::findOrFail($request->couponid);
        $coupon->delete();
        return redirect()->route('client.coupons.index')
            ->with('success', 'تم حذف كوبون الخصم بنجاح');
    }
}
