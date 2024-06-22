<?php

namespace App\Http\Controllers\Client;

use App\Models\Gift;
use App\Models\Store;
use App\Models\Company;
use App\Models\Product;
use App\Models\Category;

use App\Models\OuterClient;
use Illuminate\Http\Request;
use App\Http\Requests\GiftRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class GiftController extends Controller
{
    public function index()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $gifts = $company->gifts;
        return view('client.gifts.index', compact('company', 'company_id', 'gifts'));
    }

    public function create()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $stores = Store::where('company_id',$company_id)->get();
        $outer_clients = OuterClient::where('company_id',$company_id)->get();
        $products = Product::where('company_id',$company_id)->get();
        return view('client.gifts.create', compact('company_id', 'stores','products','outer_clients', 'company'));
    }

    public function store(GiftRequest  $request)
    {
        $data = $request->all();
        $company_id = $data['company_id'];
        $data['client_id'] = Auth::user()->id;

        $product_id = $data['product_id'];
        $product = Product::FindOrFail($product_id);
        $old_balance = $product->first_balance;
        $new_balance = $old_balance - $data['amount'];
        $product->update([
            'first_balance' => $new_balance,
        ]);
        $data['balance_before'] = $old_balance;
        $data['balance_after'] = $new_balance;
        $gift = Gift::create($data);
        return redirect()->route('client.gifts.index')
            ->with('success', 'تم اضافة الهدية بنجاح');
    }


    public function edit($id)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $stores = Store::where('company_id',$company_id)->get();
        $outer_clients = OuterClient::where('company_id',$company_id)->get();
        $products = Product::where('company_id',$company_id)->get();
        $gift = Gift::FindOrFail($id);
        return view('client.gifts.edit', compact('gift', 'company_id', 'company','stores','products','outer_clients'));
    }

    public function update(GiftRequest  $request, $id)
    {
        $data = $request->all();
        $company_id = $data['company_id'];
        $data['client_id'] = Auth::user()->id;

        $gift = Gift::FindOrFail($id);

        $old_product_id = $gift->product_id;
        $old_product = Product::FindOrFail($old_product_id);
        $old_product_amount = $gift->amount;
        $old_product_balance = $old_product->first_balance;
        $new_product_balance = $old_product_balance + $old_product_amount;
        $old_product->update([
            'first_balance' => $new_product_balance,
        ]);

        $product_id = $data['product_id'];
        $product = Product::FindOrFail($product_id);
        $old_balance = $product->first_balance;
        $new_balance = $old_balance - $data['amount'];
        $product->update([
            'first_balance' => $new_balance,
        ]);
        $data['balance_before'] = $old_balance;
        $data['balance_after'] = $new_balance;
        $gift->update($data);
        return redirect()->route('client.gifts.index')
            ->with('success', 'تم اضافة الهدية بنجاح');
    }

    public function destroy(Request $request)
    {
        $data = $request->all();
        $id = $request->giftid;
        $gift = Gift::FindOrFail($id);
        $old_product_id = $gift->product_id;
        $old_product = Product::FindOrFail($old_product_id);
        $old_product_amount = $gift->amount;
        $old_product_balance = $old_product->first_balance;
        $new_product_balance = $old_product_balance + $old_product_amount;
        $old_product->update([
            'first_balance' => $new_product_balance,
        ]);
        Gift::findOrFail($request->giftid)->delete();
        return redirect()->route('client.gifts.index')
            ->with('success', 'تم حذف الهدية بنجاح');
    }
}
