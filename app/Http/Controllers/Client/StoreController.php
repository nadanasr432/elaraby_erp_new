<?php

namespace App\Http\Controllers\Client;

use App\Models\Store;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\StoreTransfer;
use App\Models\BuyBillElement;
use App\Models\SaleBillElement;
use App\Http\Requests\StoreRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class StoreController extends Controller
{
    public function index()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $stores = $company->stores;
        return view('client.stores.index', compact('company', 'company_id', 'stores'));
    }

    public function create()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $branches = Branch::where('company_id', $company_id)->get();
        return view('client.stores.create', compact('company_id', 'branches', 'company'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->all();
        $store = Store::create($data);
        return redirect()->route('client.stores.index')
            ->with('success', 'تم اضافة المخزن بنجاح');
    }

    public function edit($id)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $branches = Branch::where('company_id', $company_id)->get();
        $store = Store::findOrFail($id);
        return view('client.stores.edit', compact('store', 'branches', 'company_id', 'company'));
    }

    public function update(StoreRequest $request, $id)
    {
        $input = $request->all();
        $store = Store::findOrFail($id);
        $store->update($input);
        return redirect()->route('client.stores.index')
            ->with('success', 'تم تعديل بيانات المخزن بنجاح');
    }

    public function destroy(Request $request)
    {
        $store = Store::findOrFail($request->storeid);
        $store->delete();
        return redirect()->route('client.stores.index')
            ->with('success', 'تم حذف المخزن بنجاح');
    }

    public function inventory_get()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $stores = $company->stores;
        $products = $company->products;
        return view('client.stores.inventory', compact('stores', 'products', 'company_id', 'company'));
    }

    public function inventory_post(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $stores = $company->stores;
        $products = $company->products;
        $store_id = $request->store_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $product_id = $request->product_id;
        $options = $request->options;
        if (!empty($store_id)) {
            if ($store_id == "all") {
                // serach by store
                if (empty($from_date) || empty($to_date)) {
                    $products_k = Product::where('company_id', $company_id)->get();
                } else {
                    $products_k = Product::whereBetween('created_at', [$from_date, $to_date])->where('company_id', $company_id)
                        ->get();
                }
            } else {
                // serach by store
                if (empty($from_date) || empty($to_date)) {
                    $products_k = Product::where('store_id', $store_id)->where('company_id', $company_id)->get();
                } else {
                    $products_k = Product::where('store_id', $store_id)
                        ->where('company_id', $company_id)
                        ->whereBetween('created_at', [$from_date, $to_date])
                        ->get();
                }
            }
            return view('client.stores.inventory',
                compact('stores', 'options', 'store_id', 'product_id', 'from_date', 'to_date', 'products', 'products_k', 'company_id', 'company'));
        } elseif (!empty($product_id)) {
            // search by product
            $product_k = Product::FindOrFail($product_id);
            $buy_elements = BuyBillElement::where('product_id', $product_k->id)->get();
            $total_buy_elements = 0;
            foreach ($buy_elements as $buy_element) {
                $total_buy_elements = $total_buy_elements + $buy_element->quantity;
            }
            $sale_elements = SaleBillElement::where('product_id', $product_k->id)->get();
            $total_sale_elements = 0;
            foreach ($sale_elements as $sale_element) {
                $total_sale_elements = $total_sale_elements + $sale_element->quantity;
            }
            $total_sold = $total_sale_elements;
            return view('client.stores.inventory',
                compact('stores', 'options', 'store_id', 'product_id', 'from_date', 'to_date', 'products', 'total_sold', 'total_buy_elements', 'product_k', 'company_id', 'company'));

        } else {
            return redirect()->route('client.inventory.get')->with('error', 'اختر المخزن او اختر المنتج');
        }
    }

    public function transfer_get()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $stores = $company->stores;
        $products = $company->products;
        $transfers = StoreTransfer::where('company_id', $company_id)->get();
        return view('client.stores.transfer', compact('stores', 'products', 'transfers', 'company_id', 'company'));
    }

    public function transfer_post(Request $request)
    {
        $from_store_id = $request->from_store;
        $to_store_id = $request->to_store;
        $product_id = $request->product_id;
        $quantity = $request->quantity;
        $date = $request->date;
        $notes = $request->notes;

        $from_store = Store::FindOrFail($from_store_id);
        $to_store = Store::FindOrFail($to_store_id);
        $product = Product::FindOrFail($product_id);
        $data = $request->all();
        $client_id = Auth::user()->id;
        $data['client_id'] = $client_id;
        if ($quantity <= 0) {
            return redirect()->route('client.stores.transfer.get')
                ->with('error', 'اكتب قيمة صحيحة فى خانة الكمية');
        } else {
            if ($from_store_id == $to_store_id) {
                return redirect()->route('client.stores.transfer.get')
                    ->with('error', 'لابد ان يكون المخزنين مختلفتين');
            } else {
                $old_product_balance_before = $product->first_balance;
                if ($old_product_balance_before < $quantity){
                    return redirect()->route('client.stores.transfer.get')
                        ->with('error', 'الكمية ليست متوفرة فى المخزن المحول منه');
                }
                else{
                    $new_product = Product::where('product_name',$product->product_name)
                        ->where('code_universal',$product->code_universal)
                        ->where('store_id',$to_store_id)
                        ->first();
                    if (!empty($new_product)){
                        $new_product_balance_before = $new_product->first_balance;
                        $new_product_balance_after = $new_product_balance_before + $quantity;
                        $new_product->update([
                            'first_balance' => $new_product_balance_after
                        ]);

                        $old_product_balance_after = $old_product_balance_before - $quantity;
                        $product->update([
                            'first_balance' => $old_product_balance_after
                        ]);

                        StoreTransfer::create($data);
                        return redirect()->route('client.stores.transfer.get')
                            ->with('success', 'تم التحويل بنجاح');
                    }
                    else{
                        $new_product = $product->replicate();
                        $new_product->store_id = $to_store_id;
                        $new_product->first_balance = $quantity;
                        $new_product->save();

                        $old_product_balance_after = $old_product_balance_before - $quantity;
                        $product->update([
                           'first_balance' => $old_product_balance_after
                        ]);
                        StoreTransfer::create($data);
                        return redirect()->route('client.stores.transfer.get')
                            ->with('success', 'تم التحويل بنجاح');
                    }
                }
            }
        }
    }
    public function get_products_by_store_id(Request $request){
        $from_store_id = $request->from_store_id;
        $products = Product::where('store_id',$from_store_id)->where('first_balance','>',0)->get();
        foreach ($products as $product) {
            echo "<option value='".$product->id."'>".$product->product_name."</option>";
        }
    }
}
