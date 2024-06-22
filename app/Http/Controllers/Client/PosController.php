<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BankCash;
use App\Models\Branch;
use App\Models\Cash;
use App\Models\Category;
use App\Models\Client;
use App\Models\Company;
use App\Models\CouponCash;
use App\Models\CouponCode;
use App\Models\ExtraSettings;
use App\Models\OuterClient;
use App\Models\PosOpen;
use App\Models\PosOpenDiscount;
use App\Models\PosOpenElement;
use App\Models\PosOpenTax;
use App\Models\PosSetting;
use App\Models\Product;
use App\Models\Safe;
use App\Models\SubCategory;
use App\Models\Tax;
use App\Models\TimeZone;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PosController extends Controller
{
    public function getNewPosBillID()
    {
        $PosOpen = PosOpen::where('client_id', Auth::user()->id)
            ->where('status', 'open')
            ->first();
        echo $PosOpen->id;
    }

    public function create()
    {
        $auth_id = Auth::user()->id;
        $user = Client::findOrFail($auth_id);
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $branch_id = $user->branch_id;
        if ($branch_id != "") {
            $pos_status = PosSetting::where('company_id', $company_id)
                ->where('branch_id', $branch_id)
                ->first();

            if ($pos_status->status == "closed") {
                return redirect()->route('client.home')->with('error', 'تم اقفال اليومية لنقطة البيع للفرع الخاص بكم ');
            }
        } else {
            $pos_status = "none";
        }
        $pos_settings = $company->pos_settings;
        $categories = $company->categories;

        if (in_array('مدير النظام', Auth::user()->role_name)) {
            $outer_clients = OuterClient::where('company_id', $company_id)->get();
        } else {
            $outer_clients = OuterClient::where('company_id', $company_id)
                ->where(function ($query) {
                    $query->where('client_id', Auth::user()->id)
                        ->orWhereNull('client_id');
                })->get();
        }


        $stores = $company->stores;

        $pending_pos = PosOpen::where('status', 'pending')
            ->where('company_id', $company_id)
            ->where('client_id', $auth_id)
            ->get();
        if (!empty($user->branch_id)) {
            $branch = Branch::FindOrFail($user->branch_id);
            $stores = $branch->stores;
            if ($company->all_users_access_main_branch == "yes") {
                $products = Product::where('company_id', $company_id)
                    ->where(function ($query) {
                        $query->where('first_balance', '>', 0)
                            ->orWhereNull('first_balance')
                            ->orWhereNull('store_id');
                    })->get();
            } else {
                $products = Product::where('company_id', $company_id)
                    ->where(function ($query) use ($stores) {
                        $query->where('first_balance', '>', 0)
                            ->orWhereNull('first_balance')
                            ->whereIn('store_id', $stores)
                            ->orWhereNull('store_id');
                    })
                    ->get();
            }
        } else {
            $products = Product::where('company_id', $company_id)
                ->where(function ($query) {
                    $query->where('first_balance', '>', 0)
                        ->orWhereNull('first_balance')
                        ->orWhereNull('store_id');
                })->get();
        }

        $timezones = TimeZone::all();
        $client_id = Auth::user()->id;
        $pos_open = PosOpen::where('client_id', $client_id)
            ->where('status', 'open')
            ->first();

        $taxes = Tax::where('company_id', $company_id)->get();

//        $old_cash = Cash::max('cash_number');
//        $pre_cash = ++$old_cash;
        $pre_cash = time() . $company_id;
        if (!empty($user->branch_id)) {
            $safes = $branch->safes;
        } else {
            $safes = $company->safes;
        }
        $banks = $company->banks;
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;

        $bills = PosOpen::where('company_id', $company_id)
            ->where('client_id', $client_id)
            ->where('status', 'done')
            ->get();

        $check = Product::where('company_id', $company_id)->get();
        if ($check->isEmpty()) {
            $code_universal = "100000001";
        } else {
            $old_order = Product::where('company_id', $company_id)->max('code_universal');
            $code_universal = ++$old_order;
        }

        if (!empty($pos_open)) {
            $pos_open_elements = PosOpenElement::where('pos_open_id', $pos_open->id)->get();
            $pos_open_discount = PosOpenDiscount::where('pos_open_id', $pos_open->id)->first();
            $pos_open_tax = PosOpenTax::where('pos_open_id', $pos_open->id)->first();
            $pos_id = "pos_" . $pos_open->id;
            $pos_cash = Cash::where('bill_id', $pos_id)
                ->get();
            $pos_bank_cash = BankCash::where('bill_id', $pos_id)
                ->get();
            $pos_coupon_cash = CouponCash::where('bill_id', $pos_id)
                ->get();
            return view('client.pos.create',
                compact('company_id', 'pos_status', 'pos_settings', 'user', 'bills', 'pos_cash', 'pos_bank_cash', 'pos_coupon_cash', 'outer_clients', 'pending_pos', 'pos_open_discount', 'pos_open_tax',
                    'stores', 'code_universal', 'pos_open', 'currency', 'pos_open_elements', 'safes', 'banks', 'pre_cash', 'products', 'company', 'taxes', 'timezones', 'categories'));
        } else {
            return view('client.pos.create',
                compact('company_id', 'pos_status', 'pos_settings', 'code_universal', 'currency', 'user', 'bills', 'outer_clients', 'safes', 'banks', 'pre_cash', 'pending_pos', 'stores', 'taxes', 'pos_open', 'products', 'company', 'timezones', 'categories'));
        }

    }

    public function create2()
    {
        $user = Client::findOrFail(Auth::user()->id);
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);

        $pos_status = "none";
        if ($user->branch_id && !empty($user->branch_id)) {
            $pos_status = PosSetting::where('company_id', $company_id)
                ->where('branch_id', $user->branch_id)
                ->first();
            if ($pos_status->status == "closed") {
                return redirect()->route('client.home')->with('error', 'تم اقفال اليومية لنقطة البيع للفرع الخاص بكم ');
            }
        }

        # == العملاء الخاصين بالاكونت مثل cash == #
        if (in_array('مدير النظام', Auth::user()->role_name)) {
            $outer_clients = OuterClient::where('company_id', $company_id)->get();
        } else {
            $outer_clients = OuterClient::where('company_id', $company_id)
                ->where(function ($query) {
                    $query->where('client_id', Auth::user()->id)
                        ->orWhereNull('client_id');
                })->get();
        }

        $pos_settings = $company->pos_settings;
        $categories = $company->categories;
        $stores = $company->stores;
        $timezones = TimeZone::all();
        $taxes = Tax::where('company_id', $company_id)->get();
        $pre_cash = time() . $company_id;

        $pending_pos = PosOpen::where('status', 'pending')
            ->where('company_id', $company_id)
            ->where('client_id', Auth::user()->id)
            ->get();

        if ($user->branch_id && !empty($user->branch_id)) {
            $branch = Branch::FindOrFail($user->branch_id);
            $stores = $branch->stores;
            $safes = $branch->safes;
            // Extract store IDs from the collection
            $storeIds = $stores->pluck('id')->toArray();

            // Query products
            $products = Product::where('company_id', $company_id)
                ->where(function ($query) use ($storeIds) {
                    $query->whereIn('store_id', $storeIds)
                        ->orWhereNull('store_id');
                })
                ->where(function ($query) {
                    $query->where('first_balance', '>', 0)
                        ->orWhereNull('first_balance');
                })
                ->get();

        } else {
            $safes = $company->safes;
            $products = Product::where('company_id', $company_id)
                ->where('first_balance', '>', 0)
                ->get();
        }

        // $old_cash = Cash::max('cash_number');
        // $pre_cash = ++$old_cash;
        $banks = $company->banks;
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();

        $check = Product::where('company_id', $company_id)->get();
        if ($check->isEmpty()) {
            $code_universal = "100000001";
        } else {
            $old_order = Product::where('company_id', $company_id)->max('code_universal');
            $code_universal = ++$old_order;
        }

        return view('client.pos.create2',
            compact('company_id', 'pos_status', 'pos_settings', 'code_universal', 'user', 'outer_clients', 'safes', 'banks', 'pre_cash', 'pending_pos', 'stores', 'taxes', 'products', 'company', 'timezones', 'categories'));

    }

    public function close_pos_open(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $client_id = Auth::user()->id;
        $client = Client::FindOrFail($client_id);
        $pos_status = PosSetting::where('company_id', $company_id)
            ->where('branch_id', $client->branch_id)
            ->first();
        $pos_status->update([
            'status' => 'closed'
        ]);
        return redirect()->route('client.pos.create');
    }

    public function open_pos_open(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $client_id = Auth::user()->id;
        $client = Client::FindOrFail($client_id);
        $pos_status = PosSetting::where('company_id', $company_id)
            ->where('branch_id', $client->branch_id)
            ->first();
        $pos_status->update([
            'status' => 'open'
        ]);
        return redirect()->route('client.pos.create');
    }

    public function shuffle_coupon_codes(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $client_id = Auth::user()->id;

        $chars = "0123456789876543210";
        $code = substr(str_shuffle($chars), 0, 16);

        $check = CouponCode::where('company_id', $company_id)
            ->where('coupon_code', $code)
            ->first();
        if (!empty($check)) {
            $chars = "0123456789876543210";
            $code = substr(str_shuffle($chars), 0, 16);
        }
        $coupon_code = $code;
        return response()->json([
            'coupon_code' => $coupon_code,
        ]);
    }

    # add product to pos inv #
    public function save(Request $request)
    {
        $data = $request->all();
        $data['company_id'] = Auth::user()->company_id;
        $company = Company::FindOrFail($data['company_id']);
        $data['client_id'] = Auth::user()->id;
        # create or update the pos inv #
        $PosOpen = PosOpen::where('client_id', $data['client_id'])
            ->where('status', 'open')
            ->first();
        if (empty($PosOpen)) {
            $PosOpen = PosOpen::create($data);
        } else {
            $PosOpen->update($data);
        }
         if ($PosOpen && !empty($PosOpen)) {
            $PosOpen->update(['value_added_tax' => 1]);
             
         }

        $data['pos_open_id'] = $PosOpen->id;
        $product = Product::FindOrFail($data['product_id']);

        if (!empty($data['outer_client_id'])) {
            $outer_client = OuterClient::FindOrFail($data['outer_client_id']);
            $client_category = $outer_client->client_category;
            if ($client_category == "جملة" && $outer_client->client_name != 'Cash') {
                $product_price = $product->wholesale_price;
            } else {
                $product_price = $product->sector_price;
            }
        } else {
            $product_price = $product->sector_price;
        }

        $element = PosOpenElement::where('product_id', $data['product_id'])
            ->where('pos_open_id', $PosOpen->id)
            ->first();
        if (empty($element)) {
            $data['product_price'] = $product_price;
            $data['quantity'] = 1;
            $data['quantity_price'] = $product_price;
            $data['company_id'] = $company->id;
            $pos_open_element = PosOpenElement::create($data);
        } else {
            $old_quantity = $element->quantity;
            $old_product_price = $element->product_price;
            $old_quantity_price = $element->quantity_price;
            $new_quantity = $old_quantity + 1;
            $new_product_price = $old_product_price;
            $new_quantity_price = $new_quantity * $new_product_price;
            $data['product_price'] = $new_product_price;
            $data['quantity'] = $new_quantity;
            $data['quantity_price'] = $new_quantity_price;
            $pos_open_element = $element->update($data);
        }
    }

    public function edit_quantity(Request $request)
    {
        $data = $request->all();
        $data['company_id'] = Auth::user()->company_id;
        $company = Company::FindOrFail($data['company_id']);

        //get product_id and quantity
        $element_id = $request->element_id;
        $edit_quantity = $request->edit_quantity;

        $element = PosOpenElement::FindOrFail($element_id);

        ///get old data..
        $old_quantity = $element->quantity;
        $old_product_price = $element->product_price;
        $old_quantity_price = $element->quantity_price;

        ///get new data..
        $new_quantity = $edit_quantity;
        $new_product_price = $old_product_price;
        $new_quantity_price = ($new_quantity * $new_product_price) - $element->discount;

        $data['product_price'] = $new_product_price;
        $data['quantity'] = $new_quantity;
        $data['quantity_price'] = $new_quantity_price;
        $pos_open_element = $element->update($data);

    }

    //change the discount = change the total amount (money)
    public function edit_discount(Request $request)
    {
        $data = $request->all();
        $data['company_id'] = Auth::user()->company_id;
        $company = Company::FindOrFail($data['company_id']);

        //get product_id and quantity
        $element_id = $request->element_id;
        $edit_discount = $request->edit_discount;

        $element = PosOpenElement::FindOrFail($element_id);

        $new_quantity_price = (($element->quantity * $element->product_price) - $edit_discount);

        $data['product_price'] = $element->product_price;
        $data['quantity'] = $element->quantity;
        $data['discount'] = $edit_discount;
        $data['quantity_price'] = $new_quantity_price;
        $pos_open_element = $element->update($data);
    }

    public function edit_price(Request $request)
    {
        // Edit product price with quantity price
        $data = $request->all();
        $data['company_id'] = Auth::user()->company_id;
        $company = Company::FindOrFail($data['company_id']);

        //get product_id and its data and change in price...
        $element_id = $request->element_id;
        $edit_price = $request->edit_price;
        $element = PosOpenElement::FindOrFail($element_id);

        $old_quantity = $element->quantity;
        $old_product_price = $element->product_price;
        $old_quantity_price = $element->quantity_price;


        $new_quantity_price = $edit_price;
        $new_quantity = $old_quantity;
        $new_product_price = $new_quantity_price / $new_quantity;

        $data['product_price'] = $new_product_price;
        $data['quantity_price'] = $new_quantity_price - $element->discount;
        $pos_open_element = $element->update($data);
    }

    public function delete_element(Request $request)
    {
        $data = $request->all();
        $data['company_id'] = Auth::user()->company_id;
        $company = Company::FindOrFail($data['company_id']);
        $element_id = $request->element_id;
        $element = PosOpenElement::FindOrFail($element_id);
        $element->delete();
    }

    public function store_discount(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $client_id = Auth::user()->id;
        $data = $request->all();
        $PosOpen = PosOpen::where('client_id', $client_id)
            ->where('status', 'open')
            ->first();
        $data['pos_open_id'] = $PosOpen->id;
        $data['company_id'] = $company_id;
        $check = PosOpenDiscount::where('pos_open_id', $PosOpen->id)->first();
        if (!empty($check)) {
            $check->update($data);
        } else {
            $pos_open_discount = PosOpenDiscount::create($data);
        }
    }

    public function store_tax(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $client_id = Auth::user()->id;
        $data = $request->all();
        $PosOpen = PosOpen::where('client_id', $client_id)
            ->where('status', 'open')
            ->first();

        $pos_open_elements = PosOpenElement::where('pos_open_id', $PosOpen->id)->get();
        $data['pos_open_id'] = $PosOpen->id;
        $data['company_id'] = $company_id;

        $pos_open_tax = PosOpenTax::where('pos_open_id', $PosOpen->id)->first();
        $pos_open_discount = PosOpenDiscount::where('pos_open_id', $PosOpen->id)->first();
        if (!empty($pos_open_tax) && $request->tax_id != 0) {
            $pos_open_tax->update($data);
        } elseif ($request->tax_id == 0) {
            $pos_open_tax->delete();
        } else {
            $pos_open_tax = PosOpenTax::create($data);
        }

        //save tax in pos settings.
        if (empty($pos_open_tax) || $request->tax_id != 0) {
            $posSettings = PosSetting::where('company_id', $company_id)->first();
            if ($request->tax_value == 15)
                $posSettings->update(['taxStatusPos' => 1]);
            elseif ($request->tax_value == 130)
                $posSettings->update(['taxStatusPos' => 2]);
                
        }


        $tax_value = $pos_open_tax->tax_value;
        $sum = 0;
        foreach ($pos_open_elements as $pos_open_element) {
            $sum = $sum + $pos_open_element->quantity_price;
        }
        if (isset($PosOpen) && !empty($pos_open_discount)) {
            $discount_value = $pos_open_discount->discount_value;
            $discount_type = $pos_open_discount->discount_type;
            if ($discount_type == "pound") {
                $sum = $sum - $discount_value;
            } else {
                $discount_value = ($discount_value / 100) * $sum;
                $sum = $sum - $discount_value;
            }
        }
        $percent = $tax_value / 100 * $sum;


        return response()->json([
            'percent' => $percent,
        ]);
    }

    public function update_inclusive(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $PosOpen = PosOpen::where('company_id', $company_id)
            ->where('status', 'open')
            ->latest('created_at')
            ->first();

        if ($PosOpen && !empty($PosOpen)) {
            $PosOpen->update(['value_added_tax' => 1]);

            //save tax in pos settings.
            $posSettings = PosSetting::where('company_id', $company_id)
                ->first();
            $posSettings->update(['taxStatusPos' => 3]);
            return 1;
        } else {
            return 0;
        }
    }

    # get subcategories by category_id
    public function get_subcategories_by_category_id(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $sub_categories = SubCategory::where('company_id', $company_id)
            ->where('category_id', $request->category_id)
            ->get();

        foreach ($sub_categories as $sub_category) {
            echo "
            <span sub_category_id='" . $sub_category->id . "' class='sub_category m-nos p-1 circle badge badge-lightnew cursor_pointer'>
            " . $sub_category->sub_category_name . "
            </span>";

        }


    }

    # get subcategories by subcategory_id
    public function get_products_by_category_id(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $user_id = Auth::user()->id;
        $user = Client::FindOrFail($user_id);
        $company = Company::FindOrFail($company_id);
        $pos_settings = $company->pos_settings;
        $category_id = $request->category_id;

        if (!empty($user->branch_id)) {
            $branch = Branch::FindOrFail($user->branch_id);
            $stores = $branch->stores;
            if ($company->all_users_access_main_branch == "yes") {
                $products = Product::where('company_id', $company_id)
                    ->where(function ($query) use ($category_id) {
                        $query->where('first_balance', '>', 0)
                            ->orWhereNull('first_balance')
                            ->where('category_id', $category_id)
                            ->orWhereNull('store_id');
                    })->get();
            } else {
                if ($category_id)
                    $products = Product::where('company_id', $company_id)
                        ->where('category_id', $category_id)
                        ->get();
                else
                    $products = Product::where('company_id', $company_id)->get();

            }
        } else {
            $products = Product::where('company_id', $company_id)
                ->where('category_id', $category_id)
                ->where('first_balance', '>', 0)
                ->get();
        }
        foreach ($products as $product) {
            $img = $product->product_pic ? $product->product_pic : 'images/noprod.png';

            echo '
            <div class="card cproduct m-nos product" product_id="' . $product->id . '" product_name="' . $product->product_name . '" product_price="' . $product->wholesale_price . '"
                 style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px !important; border: 1px solid rgba(229, 229, 229, 0.4) !important; min-height: 172px !important; max-height: 172px !important; width: 12rem !important;margin-bottom: 5px !important;">
                <div class="imgBox" style="height: 75px !important; width: 100% !important;">
                    <img style="height: 100% !important; width: 100% !important; object-fit: contain !important;"
                     src="' . asset($img) . '" class="card-img-top">
                </div>
                <div class="card-body cbod" style="padding: 6px !important;">
                    <h5 class="card-title ctitle" style="font-size: 12px !important;min-height: 33px !important;color: #0A246A !important; font-weight: 600 !important;">' . $product->product_name . '</h5>
                    <p class="card-text ctxt" style="margin-bottom: 3px !important;color: #0A3551 !important;">' . $product->code_universal . '</p>
                    <div class="row col-12 justify-content-between m-0 pl-0">
                        <span class="text-warning font-weight-bold">
                            100 ر.س
                        </span>
                        <span class="row p-0 d-inline">
                            <span class="plusIcon">+</span>
                            <span class="m-nos font-weight-bold" style="color: #0A3551 !important;">1</span>
                            <span class="minusIcon">-</span>
                        </span>
                    </div>
                </div>
            </div>
            ';
        }
    }

    public function get_products_by_sub_category_id(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $user_id = Auth::user()->id;
        $user = Client::FindOrFail($user_id);
        $company = Company::FindOrFail($company_id);
        $pos_settings = $company->pos_settings;
        $sub_category_id = $request->sub_category_id;
        $category_id = $request->category_id;
        if ($sub_category_id == "all") {

            if (!empty($user->branch_id)) {
                // return false;
                $branch = Branch::FindOrFail($user->branch_id);
                $stores = $branch->stores;
                if ($company->all_users_access_main_branch == "yes") {
                    $products = Product::where('company_id', $company_id)
                        ->where(function ($query) use ($category_id) {
                            $query->where('first_balance', '>', 0)
                                ->orWhereNull('first_balance')
                                ->where('category_id', $category_id)
                                ->orWhereNull('store_id');
                        })->get();
                } else {
                    $products = Product::where('company_id', $company_id)
                        ->where(function ($query) use ($stores, $category_id) {
                            $query->where('first_balance', '>', 0)
                                ->orWhereNull('first_balance')
                                ->where('category_id', $category_id)
                                ->whereIn('store_id', $stores)
                                ->orWhereNull('store_id');
                        })->get();
                }
            } else {
                $products = Product::where('company_id', $company_id)
                    ->where(function ($query) use ($category_id) {
                        $query->where('first_balance', '>', 0)
                            ->orWhereNull('first_balance')
                            ->where('category_id', $category_id)
                            ->orWhereNull('store_id');
                    })->get();
            }
            foreach ($products as $product) {
                $img = $product->product_pic ? $product->product_pic : 'images/noprod.png';
                echo '
            <div class="card cproduct m-nos product" product_id="' . $product->id . '" product_name="' . $product->product_name . '" product_price="' . $product->wholesale_price . '"
                 style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px !important; border: 1px solid rgba(229, 229, 229, 0.4) !important; min-height: 172px !important; max-height: 172px !important; width: 12rem !important;margin-bottom: 5px !important;">
                <div class="imgBox" style="height: 75px !important; width: 100% !important;">
                    <img style="height: 100% !important; width: 100% !important; object-fit: contain !important;"
                     src="' . asset($img) . '" class="card-img-top">
                </div>
                <div class="card-body cbod" style="padding: 6px !important;">
                    <h5 class="card-title ctitle" style="font-size: 12px !important;min-height: 33px !important;color: #0A246A !important; font-weight: 600 !important;">' . $product->product_name . '</h5>
                    <p class="card-text ctxt" style="margin-bottom: 3px !important;color: #0A3551 !important;">' . $product->code_universal . '</p>
                    <div class="row col-12 justify-content-between m-0 pl-0">
                        <span class="text-warning font-weight-bold">
                            100 ر.س
                        </span>
                        <span class="row p-0 d-inline">
                            <span class="plusIcon">+</span>
                            <span class="m-nos font-weight-bold" style="color: #0A3551 !important;">1</span>
                            <span class="minusIcon">-</span>
                        </span>
                    </div>
                </div>
            </div>
                ';
            }
        } else {
            $sub_category = SubCategory::FindOrFail($sub_category_id);
            if (!empty($user->branch_id)) {
                $branch = Branch::FindOrFail($user->branch_id);
                $stores = $branch->stores;
                $products = Product::where('company_id', $company_id)
                    ->where(function ($query) use ($stores, $sub_category) {
                        $query->where('first_balance', '>', 0)->where('sub_category_id', $sub_category->id)->whereIn('store_id', $stores);
                    })->get();
            } else {
                $products = Product::where('company_id', $company_id)
                    ->where(function ($query) use ($sub_category) {
                        $query->where('first_balance', '>', 0)->where('sub_category_id', $sub_category->id);
                    })->get();


                if (count($products) == 0) {
                    return "<div class='alert alert-info' style='margin: auto; width: 79%; text-align: center;'>
                        لا يوجد منتجات اضيف لهذه الفئة الفرعية
                        </div>";
                }
            }
            foreach ($products as $product) {
                $img = $product->product_pic ? $product->product_pic : 'images/noprod.png';

                echo '
            <div class="card cproduct m-nos product" product_id="' . $product->id . '" product_name="' . $product->product_name . '" product_price="' . $product->wholesale_price . '"
                 style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px !important; border: 1px solid rgba(229, 229, 229, 0.4) !important; min-height: 172px !important; max-height: 172px !important; width: 12rem !important;margin-bottom: 5px !important;">
                <div class="imgBox" style="height: 75px !important; width: 100% !important;">
                    <img style="height: 100% !important; width: 100% !important; object-fit: contain !important;"
                     src="' . asset($img) . '" class="card-img-top">
                </div>
                <div class="card-body cbod" style="padding: 6px !important;">
                    <h5 class="card-title ctitle" style="font-size: 12px !important;min-height: 33px !important;color: #0A246A !important; font-weight: 600 !important;">' . $product->product_name . '</h5>
                    <p class="card-text ctxt" style="margin-bottom: 3px !important;color: #0A3551 !important;">' . $product->code_universal . '</p>
                    <div class="row col-12 justify-content-between m-0 pl-0">
                        <span class="text-warning font-weight-bold">
                            100 ر.س
                        </span>
                        <span class="row p-0 d-inline">
                            <span class="plusIcon">+</span>
                            <span class="m-nos font-weight-bold" style="color: #0A3551 !important;">1</span>
                            <span class="minusIcon">-</span>
                        </span>
                    </div>
                </div>
            </div>
            ';
            }
        }
    }


    public function restore_pos_open(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $pos_open_id = $request->pos_open_id;
        $pos_open = PosOpen::FindOrFail($pos_open_id);
        if (!empty($pos_open)) {
            $pos_open->update([
                'status' => 'open'
            ]);
        }
    }

    public function refresh(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $client_id = Auth::user()->id;
        $pos_open = PosOpen::where('client_id', $client_id)
            ->where('status', 'open')
            ->first();

        //get elements opend in POS...
        $elements = PosOpenElement::where('pos_open_id', $pos_open->id)->get();
        $pos_open_discount = PosOpenDiscount::where('pos_open_id', $pos_open->id)->first();
        $pos_open_tax = PosOpenTax::where('pos_open_id', $pos_open->id)->first();
        $items = 0;
        $sum = 0;
        $discount = 0;
        $total_quantity = 0;
        foreach ($elements as $element) {
            ++$items;
            $total_quantity = $total_quantity + $element->quantity;
            $sum = $sum + $element->quantity_price;
        }
        if (isset($pos_open)) {
            $total = $sum;
            $percent = 0;
            if (isset($pos_open_tax) || !empty($pos_open_tax)) {
                $tax_value = $pos_open_tax->tax_value;
            } else {
                $tax_value = 0;
            }
            if (isset($pos_open_discount) || !empty($pos_open_discount)) {
                $discount_value = $pos_open_discount->discount_value;
                $discount_type = $pos_open_discount->discount_type;
                if ($discount_type == "percent") {
                    $discount_value = ($discount_value / 100) * $sum;
                    $discount = $discount_value . " ( " . $pos_open_discount->discount_value . " % ) ";
                } else {
                    $discount = $discount_value;
                }
            } else {
                $discount_value = 0;
            }
            $total = $total - $discount_value;
            $percent = $tax_value / 100 * $total;
            $total = $total + $percent;
        }
        if (isset($pos_open_tax)) {
            return response()->json([
                'items' => $items,
                'total_quantity' => $total_quantity,
                'sum' => $sum,
                'total' => $total,
                'discount_value' => $discount,
                'percent' => $percent . " ( " . $pos_open_tax->tax_value . " %) ",
                'pos_open_id' => $pos_open->id
            ]);
        } else {
            return response()->json([
                'items' => $items,
                'total_quantity' => $total_quantity,
                'sum' => $sum,
                'total' => $total,
                'discount_value' => $discount,
                'percent' => $percent,
                'pos_open_id' => $pos_open->id
            ]);
        }

    }

    public function get_coupon_code(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $client_id = Auth::user()->id;
        $coupon_code = $request->coupon_code;
        $check = CouponCode::where('coupon_code', $coupon_code)
            ->first();
        if (!empty($check)) {
            $status = "success";
            $coupon_value = $check->coupon_value;
        }
        return response()->json([
            'status' => $status,
            'coupon_value' => $coupon_value,
        ]);
    }

    public function get_coupon_codes(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $client_id = Auth::user()->id;
        $outer_client_id = $request->outer_client_id;
        $coupon_codes = CouponCode::where('outer_client_id', $outer_client_id)
            ->orWhere('company_id', $company_id)
            ->orWhere('client_id', $client_id)
            ->where('status', 'new')
            ->get();
        foreach ($coupon_codes as $coupon_code) {
            $dept = $coupon_code->dept;
            if ($dept == "categories") {
                $dept_name = "خصم فئة";
            } else if ($dept == "products") {
                $dept_name = "خصم منتج";
            } else if ($dept == "outer_clients") {
                $dept_name = "خصم عميل";
            }
            echo '<option value="' . $coupon_code->coupon_code . '">' . $coupon_code->coupon_code . " - " . $dept_name . '</option>';
        }
    }

    //###########################################PAYING BUTTONS ACTIONS END##########################################//

    # ================ دفع شبكة سريع================#
    public function finishBank_pos_open(Request $request)
    {
        $billDetails = $request->billDetails;
        $productsArr = $request->productsArr;

        # create pos invoice #
        $posOpen = PosOpen::create([
            'company_id' => Auth::user()->company_id,
            'client_id' => Auth::user()->id,
            'editing' => 0,
            'outer_client_id' => $billDetails['outer_client_id'],
            'tableNum' => $billDetails['tableNum'] ?? 0,
            'notes' => $billDetails['notes'] ?? '',
            'status' => 'done',
            'value_added_tax' => empty($billDetails['tax_amount']) ? 1 : 0,
            'total_amount' => $billDetails['total_amount'],
            'tax_amount' => $billDetails['tax_amount'],
            'tax_value' => $billDetails['tax_value'],
            'class' => 'paid'
        ]);

        if ($posOpen) {
            # create pos invoice Elements #
            foreach ($productsArr as $element) {
                PosOpenElement::create([
                    'pos_open_id' => $posOpen->id,
                    'company_id' => Auth::user()->company_id,
                    'product_id' => $element['product_id'],
                    'product_price' => $element['product_price'],
                    'quantity' => $element['quantity'],
                    'discount' => $element['discount'],
                    'quantity_price' => $element['quantity_price']
                ]);
                # update stock #
                $product = Product::FindOrFail($element['product_id']);
                if ($product->category->category_type == "مخزونية") {
                    $product->update([
                        'first_balance' => ($product->first_balance - $element['quantity'])
                    ]);
                }
            }
            # ===================================== #

            #===== بيضيف اجمالي الفاتورة للخزنة تبع المؤسسة (كارباح)====#
            $safe = Safe::where('company_id', Auth::user()->company_id)
                ->where('type', 'main')
                ->first();
            $safe->update(['balance' => $safe->balance + $billDetails['total_amount']]);
            # ===================================== #


            #=====بيخصم المبلغ من حساب العميل========#
            if (!empty($billDetails['outer_client_id'])) {
                $outer_client = OuterClient::FindOrFail($billDetails['outer_client_id']);
                $balance_before = $outer_client->prev_balance;
                $balance_after = $balance_before - $billDetails['total_amount'];
            } else {
                $balance_before = 0;
                $balance_after = 0;
            }
            # ===================================== #

            #========تسجيل الدفع عن طريق البنك========#
            BankCash::create([
                'cash_number' => time(),
                'company_id' => Auth::user()->company_id,
                'client_id' => Auth::user()->id,
                'bank_id' => $billDetails['bank_id'],
                'outer_client_id' => $billDetails['outer_client_id'],
                'balance_before' => $balance_before,
                'balance_after' => $balance_after,
                'amount' => $billDetails['total_amount'],
                'bill_id' => "pos_" . $posOpen->id,
                'date' => date("Y-m-d"),
                'time' => date("H:i:s"),
            ]);
            $bank = Bank::FindOrFail($billDetails['bank_id']);
            $bank->update([
                'bank_balance' => $bank->bank_balance + $billDetails['total_amount']
            ]);
            # ===================================== #
            return [
                'reason' => 'تم الدفع وحفظ الفاتورة',
                'success' => 1,
                'pos_id' => $posOpen->id,
            ];
        }

    }

    # ============== دفع كاش سريع============pos.open.finish=======#
    public function finish_pos_open(Request $request)
    {
        $billDetails = $request->billDetails;
        $productsArr = $request->productsArr;

        # create pos invoice #
        $posOpen = PosOpen::create([
            'company_id' => Auth::user()->company_id,
            'client_id' => Auth::user()->id,
            'editing' => 0,
            'outer_client_id' => $billDetails['outer_client_id'],
            'tableNum' => $billDetails['tableNum'] ?? 0,
            'notes' => $billDetails['notes'] ?? '',
            'status' => 'done',
             'value_added_tax' => empty($billDetails['tax_amount']) ? 1 : 0,
            'total_amount' => $billDetails['total_amount'],
            'tax_amount' => $billDetails['tax_amount'],
            'tax_value' => $billDetails['tax_value'],
            'class' => 'paid'
        ]);
        
 
        if ($posOpen) {
            # create pos invoice Elements #
            foreach ($productsArr as $element) {
                PosOpenElement::create([
                    'pos_open_id' => $posOpen->id,
                    'company_id' => Auth::user()->company_id,
                    'product_id' => $element['product_id'],
                    'product_price' => $element['product_price'],
                    'quantity' => $element['quantity'],
                    'discount' => $element['discount'],
                    'quantity_price' => $element['quantity_price']
                ]);
                # update stock #
                $product = Product::FindOrFail($element['product_id']);
                if ($product->category->category_type == "مخزونية") {
                    $product->update([
                        'first_balance' => ($product->first_balance - $element['quantity'])
                    ]);
                }
            }
           
            # =============================== #

            #===== بيضيف اجمالي الفاتورة للخزنة تبع المؤسسة (كارباح)====#
            $safe = Safe::where('company_id', Auth::user()->company_id)
                ->where('type', 'main')
                ->first();
            $safe->update(['balance' => $safe->balance + $billDetails['total_amount']]);
            # =============================== #


            #=====بيخصم المبلغ من حساب العميل====#
            if (!empty($billDetails['outer_client_id'])) {
                $outer_client = OuterClient::FindOrFail($billDetails['outer_client_id']);
                $balance_before = $outer_client->prev_balance;
                $balance_after = $balance_before - $billDetails['total_amount'];
            } else {
                $balance_before = 0;
                $balance_after = 0;
            }
            # =============================== #

            //cash as operation
            $old_cash = Cash::max('cash_number');
            $cash = Cash::create([
                'cash_number' => ++$old_cash,
                'company_id' => Auth::user()->company_id,
                'client_id' => Auth::user()->id,
                'safe_id' => $safe->id,
                'outer_client_id' => $billDetails['outer_client_id'],
                'balance_before' => $balance_before,
                'balance_after' => $balance_after,
                'amount' => $billDetails['total_amount'],
                'bill_id' => "pos_" . $posOpen->id,
                'date' => date('Y-m-d'),
                'time' => date('H:i:s'),
            ]);

            return [
                'reason' => 'تم الدفع وحفظ الفاتورة',
                'success' => 1,
                'pos_id' => $posOpen->id,
            ];
        }
    }
    # =============================================#

    # ===============حفظ وطباعة بدون دفع=============#
    public function done_pos_open(Request $request)
    {
        $billDetails = $request->billDetails;
        $productsArr = $request->productsArr;

        # create pos invoice #
        $posOpen = PosOpen::create([
            'company_id' => Auth::user()->company_id,
            'client_id' => Auth::user()->id,
            'editing' => 0,
            'outer_client_id' => $billDetails['outer_client_id'],
            'tableNum' => $billDetails['tableNum'] ?? 0,
            'notes' => $billDetails['notes'] ?? '',
            'status' => 'done',
            'value_added_tax' => empty($billDetails['tax_amount']) ? 1 : 0,
            'total_amount' => $billDetails['total_amount'],
            'tax_amount' => $billDetails['tax_amount'],
            'tax_value' => $billDetails['tax_value']
        ]);

        if ($posOpen) {
            # create pos invoice Elements #
            foreach ($productsArr as $element) {
                PosOpenElement::create([
                    'pos_open_id' => $posOpen->id,
                    'company_id' => Auth::user()->company_id,
                    'product_id' => $element['product_id'],
                    'product_price' => $element['product_price'],
                    'quantity' => $element['quantity'],
                    'discount' => $element['discount'],
                    'quantity_price' => $element['quantity_price']
                ]);
                # update stock #
                $product = Product::FindOrFail($element['product_id']);
                if ($product->category->category_type == "مخزونية") {
                    $product->update([
                        'first_balance' => ($product->first_balance - $element['quantity'])
                    ]);
                }
            }
            # =============================== #

            #===== بيضيف اجمالي الفاتورة للخزنة تبع المؤسسة (كارباح)====#
            $safe = Safe::where('company_id', Auth::user()->company_id)
                ->where('type', 'main')
                ->first();
            $safe->update(['balance' => $safe->balance + $billDetails['total_amount']]);
            # =============================== #

            #=====بيضيف المبلغ في حساب العميل لانه مدفعش====#
            $cash_id = "pos_" . $posOpen->id;
            $cash = Cash::where('bill_id', $cash_id)->get();
            if (!$cash->isEmpty()) { # يعني العميل دفع قبل كدا
                $cash_amount = 0;
                foreach ($cash as $item)
                    $cash_amount = $cash_amount + $item->amount;
            } else # يعني العميل مدفعش وحفظ الفاتورة فقط
                $cash_amount = 0;

            $bank_cash = BankCash::where('bill_id', $cash_id)->get();
            if (!$bank_cash->isEmpty()) {
                $cash_bank_amount = 0;
                foreach ($bank_cash as $item)
                    $cash_bank_amount = $cash_bank_amount + $item->amount;
            } else
                $cash_bank_amount = 0;

            $coupon_cash = CouponCash::where('bill_id', $cash_id)->get();
            if (!$coupon_cash->isEmpty()) {
                $cash_coupon_amount = 0;
                foreach ($coupon_cash as $item)
                    $cash_coupon_amount = $cash_coupon_amount + $item->amount;
            } else
                $cash_coupon_amount = 0;

            $total_paid_amount = $cash_amount + $cash_bank_amount + $cash_coupon_amount;
            $rest = $billDetails['total_amount'] - $total_paid_amount;
            if (isset($billDetails['outer_client_id']) && !empty($billDetails['outer_client_id'])) {
                $outer_client = OuterClient::FindOrFail($posOpen->outer_client_id);
                $new_balance = $outer_client->prev_balance + $rest;
                $outer_client->update(['prev_balance' => $new_balance]);
            }
            # =============================== #

            return [
                'reason' => 'تم حفظ الفاتورة',
                'success' => 1,
                'pos_id' => $posOpen->id,
            ];
        }
    }
    # ==============================================#

    # ===============pending pos inv ===============#
    public function pending_pos_open(Request $request)
    {
        $billDetails = $request->billDetails;
        $productsArr = $request->productsArr;

        # create pos invoice #
        $posOpen = PosOpen::create([
            'company_id' => Auth::user()->company_id,
            'client_id' => Auth::user()->id,
            'editing' => 0,
            'outer_client_id' => $billDetails['outer_client_id'],
            'tableNum' => $billDetails['tableNum'] ?? 0,
            'notes' => $billDetails['notes'] ?? '',
            'status' => 'pending',
            'value_added_tax' => empty($billDetails['tax_amount']) ? 1 : 0,
            'total_amount' => $billDetails['total_amount'],
            'tax_amount' => $billDetails['tax_amount'],
            'tax_value' => $billDetails['tax_value'],
        ]);

        if ($posOpen) {
            # create pos invoice Elements #
            foreach ($productsArr as $element) {
                PosOpenElement::create([
                    'pos_open_id' => $posOpen->id,
                    'company_id' => Auth::user()->company_id,
                    'product_id' => $element['product_id'],
                    'product_price' => $element['product_price'],
                    'quantity' => $element['quantity'],
                    'discount' => $element['discount'],
                    'quantity_price' => $element['quantity_price']
                ]);
                # update stock #
                $product = Product::FindOrFail($element['product_id']);
                if ($product->category->category_type == "مخزونية") {
                    $product->update([
                        'first_balance' => ($product->first_balance - $element['quantity'])
                    ]);
                }
            }
            # ===================================== #

            # ===================================== #
            return [
                'success' => 1,
                'pos_id' => $posOpen->id,
            ];
        }
    }
    # ==============================================#


    # =============== زر تسجيل الدفع =========client.store.cash.clients.pos===== #
    public function store_cash_clients(Request $request)
    {
        $billDetails = $request->billDetails;
        $productsArr = $request->productsArr;

        # create pos invoice #
        $posOpen = PosOpen::create([
            'company_id' => Auth::user()->company_id,
            'client_id' => Auth::user()->id,
            'editing' => 0,
            'outer_client_id' => $billDetails['outer_client_id'],
            'tableNum' => $billDetails['tableNum'] ?? 0,
            'notes' => $billDetails['notes'] ?? '',
            'status' => 'done',
            'value_added_tax' => empty($billDetails['tax_amount']) ? 1 : 0,
            'total_amount' => $billDetails['total_amount'],
            'tax_amount' => $billDetails['tax_amount'],
            'tax_value' => $billDetails['tax_value'],
            'class' => 'partial'
        ]);
         
        if ($posOpen) {
            # create pos invoice Elements #
            foreach ($productsArr as $element) {
                PosOpenElement::create([
                    'pos_open_id' => $posOpen->id,
                    'company_id' => Auth::user()->company_id,
                    'product_id' => $element['product_id'],
                    'product_price' => $element['product_price'],
                    'quantity' => $element['quantity'],
                    'discount' => $element['discount'],
                    'quantity_price' => $element['quantity_price']
                ]);
                # update stock #
                $product = Product::FindOrFail($element['product_id']);
                if ($product->category->category_type == "مخزونية") {
                    $product->update([
                        'first_balance' => ($product->first_balance - $element['quantity'])
                    ]);
                }
            }
            # =============================== #

            #=====بيخصم المبلغ من حساب العميل====#
            //customer balance if exists.
            if (!empty($billDetails['outer_client_id'])) {
                $outer_client = OuterClient::FindOrFail($billDetails['outer_client_id']);
                $billDetails['balance_before'] = $outer_client->prev_balance;
                $billDetails['balance_after'] = $billDetails['balance_before'] - $billDetails['total_amount'];
            } else {
                $billDetails['balance_before'] = 0;
                $billDetails['balance_after'] = 0;
            }

            if ($billDetails['payment_method'] == "cash") {
                # ====== cash as operation ======#
                $old_cash = Cash::max('cash_number');
                $cash = Cash::create([
                    'cash_number' => ++$old_cash,
                    'company_id' => Auth::user()->company_id,
                    'client_id' => Auth::user()->id,
                    'safe_id' => $billDetails['safe_id'],
                    'outer_client_id' => $billDetails['outer_client_id'],
                    'balance_before' => $billDetails['balance_before'],
                    'balance_after' => $billDetails['balance_after'],
                    'amount' => $billDetails['paid_amount'],
                    'bill_id' => "pos_" . $posOpen->id,
                    'date' => date('Y-m-d'),
                    'time' => date('H:i:s'),
                ]);

                #===== بيضيف اجمالي الفاتورة للخزنة تبع المؤسسة (كارباح)====#
                $safe = Safe::FindOrFail($billDetails['safe_id']);
                $safe->update(['balance' => $safe->balance + $billDetails['total_amount']]);
                # =============================== #
            } elseif ($billDetails['payment_method'] == "coupon") {
                $coupon = CouponCode::where('coupon_code', $billDetails['coupon_code'])->first();
                $billDetails['coupon_id'] = $coupon->id;
                $billDetails['bill_id'] = "pos_" . $posOpen->id;
                $cash = CouponCash::create($billDetails);
            } else { # gonna be bankCash

                #========تسجيل الدفع عن طريق البنك========#
                BankCash::create([
                    'cash_number' => time(),
                    'company_id' => Auth::user()->company_id,
                    'client_id' => Auth::user()->id,
                    'bank_id' => $billDetails['bank_id'],
                    'outer_client_id' => $billDetails['outer_client_id'],
                    'balance_before' => $billDetails['balance_before'],
                    'balance_after' => $billDetails['balance_after'],
                    'amount' => $billDetails['paid_amount'],
                    'bill_id' => "pos_" . $posOpen->id,
                    'date' => date("Y-m-d"),
                    'time' => date("H:i:s"),
                ]);
                $bank = Bank::FindOrFail($billDetails['bank_id']);
                $bank->update([
                    'bank_balance' => $bank->bank_balance + $billDetails['total_amount']
                ]);
                # ===================================== #
            }
            return $posOpen->id;
        }
    }
    # ==============================================#

    //###########################################PAYING BUTTONS ACTIONS END##########################################//

    public function check_pos_open(Request $request)
    {
        $pos_open = PosOpen::where('client_id', Auth::user()->id)
            ->where('status', 'open')
            ->firstOrFail();
        if (!empty($pos_open)) {
            return response()->json([
                'reason' => '',
                'success' => 1
            ]);
        } else {
            return response()->json([
                'reason' => 'لابد من اضافة منتجات للفاتورة اولا',
                'success' => 0
            ]);
        }
    }

    public function print($pos_id)
    {
        $pos = PosOpen::FindOrFail($pos_id);
        $clientID = $pos->client_id;
        $branchID = Client::findOrFail($clientID);
        $company_id = $pos->company_id;
        $company = Company::FindOrFail($company_id);
        $branchID = $branchID->branch_id;
        if ($branchID) {
            $branchDetails = $pos->company->branches->where('id', $branchID)->first();
            $branch_address = $branchDetails->branch_address;
            $branch_phone = $branchDetails->branch_phone;
        } else {
            $branch_address = $pos->company->company_address;
            $branch_phone = $pos->company->phone_number;
        }

        $posSettings = PosSetting::where("company_id", $pos->company_id)->first();
        return view('client.pos.print2', compact('company','pos', 'posSettings', 'branch_address', 'branch_phone'));
    }

    //pos_sales for main table-main page...
    public function pos_sales_report()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $client_id = Auth::user()->id;
        //get pos sales...
        $pos_sales = PosOpen::where('status', 'done')
            ->where('company_id', $company_id)
            ->where('client_id', $client_id)
            ->whereDate('created_at', Carbon::today())
            ->get();
        return view('client.pos.report', compact('company_id', 'company', 'pos_sales'));
    }

    //posTodayReportAjax
    public function posTodayReport()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $client_id = Auth::user()->id;

        //get pos sales...
        $pos_sales = PosOpen::where('status', 'done')
            ->where('company_id', $company_id)
            ->where('client_id', $client_id)
            ->get();

        //***************************start printing data****************************//
        echo "
        <table id='posReportToday' class='table table-condensed table-striped table-bordered text-center table-hover'>
            <thead>
                <tr>
                    <th class='text-center'>#</th>
                    <th class='text-center'>" . __('pos.invoice-number') . "</th>
                    <th class='text-center'>" . __('pos.client-name') . "</th>
                    <th class='text-center'>" . __('pos.invoice-date') . "</th>
                    <th class='text-center'>" . __('pos.invoice-status') . "</th>
                    <th class='text-center'>" . __('main.amount') . "</th>
                    <th class='text-center'>" . __('main.paid-amount') . "</th>
                    <th class='text-center'>" . __('main.remaining-amount') . "</th>
                    <th class='text-center'>" . __('main.taxes') . "</th>
                    <th class='text-center'>" . __('main.items') . "</th>
                </tr>
            </thead>
            <tbody class='posReportTodayTbody'>";

        #initialization.
        $i = 0;
        $sum1 = 0; # total-invoices-including-tax
        $sum2 = 0; # main.paid-amount
        $sum3 = 0; # total-tax-for-all-invoices
        $totalCash = 0; # total-cash
        $totalBank = 0; # total-tax-for-all-invoices

        if (!empty($pos_sales) && count($pos_sales)) {
            foreach ($pos_sales as $key => $pos) {
                //totalamount
                $totalAmount = 0;
                //totalPaid
                $totalPaid = 0;

                echo "
            <tr>
                <td>" . ++$i . "</td>
                <td>" . $pos->id . "</td>
                <td>";
                if (isset($pos->outerClient->client_name))
                    echo $pos->outerClient->client_name;
                else
                    echo 'زبون';
                echo "
                </td>

                <!---invoice date--->
                <td>" . explode(' ', $pos->created_at)[0] . "</td>
                <!---invoice-status--->
                <td>";
                $bill_id = 'pos_' . $pos->id;
                $check = Cash::where('bill_id', $bill_id)->first();
                if (empty($check)) {
                    $check2 = BankCash::where('bill_id', $bill_id)->first();
                    if (empty($check2)) {
                        echo 'غير مدفوعة - دين على العميل';
                    } else {
                        $totalBank += $check2->amount;
                        echo 'مدفوعة شيك بنكى';
                    }
                } else {
                    $totalCash += $check->amount;
                    echo 'مدفوعة كاش';
                }
                echo "
                </td>

                <!----amount---->
                <td>";
                if (isset($pos)) {
                    $pos_elements = $pos->elements; #get elements
                    $pos_discount = $pos->discount; #get discount
                    $pos_tax = $pos->tax; #get tax
                    $percent = 0;

                    #get total price of products
                    $sum = 0;
                    foreach ($pos_elements as $pos_element) {
                        $sum = $sum + $pos_element->quantity_price;
                        $totalAmount += $pos_element->quantity_price;
                    }

                    //calc Tax
                    if (isset($pos) && isset($pos_tax) && empty($pos_discount)) {
                        # if there is tax and no discount.
                        $tax_value = $pos_tax->tax_value;
                        $percent = ($tax_value / 100) * $sum;
                        $sum = $sum + $percent;
                    } elseif (isset($pos) && isset($pos_discount) && empty($pos_tax)) {
                        # if there is discount and no tax.
                        $discount_value = $pos_discount->discount_value;
                        $discount_type = $pos_discount->discount_type;
                        if ($discount_type == 'pound') {
                            $sum = $sum - $discount_value;
                        } else {
                            $discount_value = ($discount_value / 100) * $sum;
                            $sum = $sum - $discount_value;
                        }
                    } elseif (isset($pos) && !empty($pos_discount) && !empty($pos_tax)) {
                        $tax_value = $pos_tax->tax_value;
                        $discount_value = $pos_discount->discount_value;
                        $discount_type = $pos_discount->discount_type;
                        if ($discount_type == 'pound') {
                            $sum = $sum - $discount_value;
                        } else {
                            $discount_value = ($discount_value / 100) * $sum;
                            $sum = $sum - $discount_value;
                        }
                        $percent = ($tax_value / 100) * $sum;
                        $sum = $sum + $percent;
                    } elseif (isset($pos) && empty($pos_discount) && empty($pos_tax)) {#inclusive
                        if ($pos->value_added_tax)
                            $percent = round($sum - ((100 / 115) * $sum), 2);
                        else
                            $percent = 0;
                    }
                    echo round($sum, 2);

                    $sum1 = $sum1 + $sum;
                } else echo 0;

                echo "
            </td>

            <!---paid-amount---->
            <td>";
                $bill_id = 'pos_' . $pos->id;
                $check = Cash::where('bill_id', $bill_id)->first();
                if (empty($check)) {
                    $check2 = BankCash::where('bill_id', $bill_id)->first();
                    if (empty($check2)) {
                        echo '0';
                        $sum2 = $sum2 + 0;
                    } else {
                        $totalPaid = $check2->amount;
                        echo round($totalPaid, 2);
                        $sum2 = $sum2 + $check2->amount;
                    }
                } else {
                    echo round($check->amount, 2);
                    $totalPaid = $check->amount;
                    $sum2 = $sum2 + $check->amount;
                }
                echo "
            </td>

            <!---remaining-amount-->
            <td>";
                //$rest = $totalAmount - $totalPaid;
                echo round($sum - $totalPaid, 2);
                echo "
            </td>

            <!--taxes--->
            <td>";
                echo round($percent, 2);
                $sum3 = $sum3 + $percent;
                echo "
            </td>

            <td>";
                if (isset($pos)) {
                    $pos_elements = $pos->elements;
                    echo $pos_elements->count();
                } else
                    echo 0;

                echo "
            </td>
        </tr>";
            }
        } else {
            echo "<tr class='alert alert-danger font-weight-bold'><td colspan='10' >لا يوجد فواتير لليوم!</td></tr>";
        }

        echo "</tbody>
        </table>
        <div class='row mb-3 mt-3 text-center'>

            <div class='badge badge-dark mb-1 p-1'
                 style='margin-right: 5px;width: fit-content;font-size: 14px !important;font-weight: bold;'>
                مبيعات الكاش :
                " . round($totalCash, 2) . "
            </div>
            <div class='badge badge-warning mb-1 p-1'
                 style='margin-right: 5px;width: fit-content;font-size: 14px !important;font-weight: bold;'>
                مبيعات الشبكة :
                " . round($totalBank, 2) . "
            </div>
            <div class='badge badge-danger mb-1 p-1'
                 style='margin-right: 5px;width: fit-content;font-size: 14px !important;font-weight: bold;'>
                " . __('pos.total-tax-for-all-invoices') . " :
                " . round($sum3, 2) . "
            </div>
            <div class='badge badge-primary mb-1 p-1'
                 style='margin-right: 5px;width: fit-content;font-size: 14px !important;font-weight: bold;'>
                " . __('main.paid-amount') . " :
                " . round($sum2, 2) . "
            </div>
            <div class='badge badge-success mb-1 p-1'
                 style='margin-right: 5px;width: fit-content;font-size: 14px !important;font-weight: bold;'>
                 " . __('pos.total-invoices-including-tax') . " :
                " . round($sum1, 2) . "
            </div>
        </div>";
    }

    //posTodayReportAjax
    public function posReportsBetweenDates(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $client_id = Auth::user()->id;

        //get pos sales...
        $pos_sales = PosOpen::where('status', 'done')
            ->where('company_id', $company_id)
            ->where('client_id', $client_id)
            ->whereBetween('created_at', [$request->dateFrom, $request->dateTo])
            ->get();

        //***************************start printing data****************************//
        echo "
        <table id='posReportToday' class='table table-condensed table-striped table-bordered text-center table-hover'>
            <thead>
                <tr>
                    <th class='text-center'>#</th>
                    <th class='text-center'>" . __('pos.invoice-number') . "</th>
                    <th class='text-center'>" . __('pos.client-name') . "</th>
                    <th class='text-center'>" . __('pos.invoice-date') . "</th>
                    <th class='text-center'>" . __('pos.invoice-status') . "</th>
                    <th class='text-center'>" . __('main.amount') . "</th>
                    <th class='text-center'>" . __('main.paid-amount') . "</th>
                    <th class='text-center'>" . __('main.remaining-amount') . "</th>
                    <th class='text-center'>" . __('main.taxes') . "</th>
                    <th class='text-center'>" . __('main.items') . "</th>
                </tr>
            </thead>
            <tbody class='posReportTodayTbody'>";

        #initialization.
        $i = 0;
        $sum1 = 0; # total-invoices-including-tax
        $sum2 = 0; # main.paid-amount
        $sum3 = 0; # total-tax-for-all-invoices
        $totalCash = 0; # total-cash
        $totalBank = 0; # total-tax-for-all-invoices

        if (!empty($pos_sales) && count($pos_sales)) {
            foreach ($pos_sales as $key => $pos) {
                //totalamount
                $totalAmount = 0;
                //totalPaid
                $totalPaid = 0;

                echo "
            <tr>
                <td>" . ++$i . "</td>
                <td>" . $pos->id . "</td>
                <td>";
                if (isset($pos->outerClient->client_name))
                    echo $pos->outerClient->client_name;
                else
                    echo 'زبون';
                echo "
                </td>

                <!---invoice date--->
                <td>" . explode(' ', $pos->created_at)[0] . "</td>
                <!---invoice-status--->
                <td>";
                $bill_id = 'pos_' . $pos->id;
                $check = Cash::where('bill_id', $bill_id)->first();
                if (empty($check)) {
                    $check2 = BankCash::where('bill_id', $bill_id)->first();
                    if (empty($check2)) {
                        echo 'غير مدفوعة - دين على العميل';
                    } else {
                        $totalBank += $check2->amount;
                        echo 'مدفوعة شيك بنكى';
                    }
                } else {
                    $totalCash += $check->amount;
                    echo 'مدفوعة كاش';
                }
                echo "
                </td>

                <!----amount---->
                <td>";
                if (isset($pos)) {
                    $pos_elements = $pos->elements; #get elements
                    $pos_discount = $pos->discount; #get discount
                    $pos_tax = $pos->tax; #get tax
                    $percent = 0;

                    #get total price of products
                    $sum = 0;
                    foreach ($pos_elements as $pos_element) {
                        $sum = $sum + $pos_element->quantity_price;
                        $totalAmount += $pos_element->quantity_price;
                    }

                    //calc Tax
                    if (isset($pos) && isset($pos_tax) && empty($pos_discount)) {
                        # if there is tax and no discount.
                        $tax_value = $pos_tax->tax_value;
                        $percent = ($tax_value / 100) * $sum;
                        $sum = $sum + $percent;
                    } elseif (isset($pos) && isset($pos_discount) && empty($pos_tax)) {
                        # if there is discount and no tax.
                        $discount_value = $pos_discount->discount_value;
                        $discount_type = $pos_discount->discount_type;
                        if ($discount_type == 'pound') {
                            $sum = $sum - $discount_value;
                        } else {
                            $discount_value = ($discount_value / 100) * $sum;
                            $sum = $sum - $discount_value;
                        }
                    } elseif (isset($pos) && !empty($pos_discount) && !empty($pos_tax)) {
                        $tax_value = $pos_tax->tax_value;
                        $discount_value = $pos_discount->discount_value;
                        $discount_type = $pos_discount->discount_type;
                        if ($discount_type == 'pound') {
                            $sum = $sum - $discount_value;
                        } else {
                            $discount_value = ($discount_value / 100) * $sum;
                            $sum = $sum - $discount_value;
                        }
                        $percent = ($tax_value / 100) * $sum;
                        $sum = $sum + $percent;
                    } elseif (isset($pos) && empty($pos_discount) && empty($pos_tax)) {#inclusive
                        if ($pos->value_added_tax)
                            $percent = round($sum - ((100 / 115) * $sum), 2);
                        else
                            $percent = 0;
                    }
                    echo round($sum, 2);

                    $sum1 = $sum1 + $sum;
                } else echo 0;

                echo "
            </td>

            <!---paid-amount---->
            <td>";
                $bill_id = 'pos_' . $pos->id;
                $check = Cash::where('bill_id', $bill_id)->first();
                if (empty($check)) {
                    $check2 = BankCash::where('bill_id', $bill_id)->first();
                    if (empty($check2)) {
                        echo '0';
                        $sum2 = $sum2 + 0;
                    } else {
                        $totalPaid = $check2->amount;
                        echo round($totalPaid, 2);
                        $sum2 = $sum2 + $check2->amount;
                    }
                } else {
                    echo round($check->amount, 2);
                    $totalPaid = $check->amount;
                    $sum2 = $sum2 + $check->amount;
                }
                echo "
            </td>

            <!---remaining-amount-->
            <td>";
                //$rest = $totalAmount - $totalPaid;
                echo round($sum - $totalPaid, 2);
                echo "
            </td>

            <!--taxes--->
            <td>";
                echo round($percent, 2);
                $sum3 = $sum3 + $percent;
                echo "
            </td>

            <td>";
                if (isset($pos)) {
                    $pos_elements = $pos->elements;
                    echo $pos_elements->count();
                } else
                    echo 0;

                echo "
            </td>
        </tr>";
            }
        } else {
            echo "<tr class='alert alert-danger font-weight-bold'><td colspan='10' >لا يوجد فواتير لليوم!</td></tr>";
        }

        echo "</tbody>
        </table>
        <div class='row mb-3 mt-3 text-center'>

            <div class='badge badge-dark mb-1 p-1'
                 style='margin-right: 5px;width: fit-content;font-size: 14px !important;font-weight: bold;'>
                مبيعات الكاش :
                " . round($totalCash, 2) . "
            </div>
            <div class='badge badge-warning mb-1 p-1'
                 style='margin-right: 5px;width: fit-content;font-size: 14px !important;font-weight: bold;'>
                مبيعات الشبكة :
                " . round($totalBank, 2) . "
            </div>
            <div class='badge badge-danger mb-1 p-1'
                 style='margin-right: 5px;width: fit-content;font-size: 14px !important;font-weight: bold;'>
                " . __('pos.total-tax-for-all-invoices') . " :
                " . round($sum3, 2) . "
            </div>
            <div class='badge badge-primary mb-1 p-1'
                 style='margin-right: 5px;width: fit-content;font-size: 14px !important;font-weight: bold;'>
                " . __('main.paid-amount') . " :
                " . round($sum2, 2) . "
            </div>
            <div class='badge badge-success mb-1 p-1'
                 style='margin-right: 5px;width: fit-content;font-size: 14px !important;font-weight: bold;'>
                 " . __('pos.total-invoices-including-tax') . " :
                " . round($sum1, 2) . "
            </div>
        </div>";
    }

    public function pos_sales_report_print()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $client_id = Auth::user()->id;
        $pos_sales = PosOpen::where('status', 'done')
            ->where('company_id', $company_id)->where('client_id', $client_id)->get();
        return view('client.pos.print_report', compact('company_id', 'company', 'pos_sales'));
    }

    public function pos_sales_report_print_today()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $client_id = Auth::user()->id;
        $pos_sales = PosOpen::where('status', 'done')
            ->where('company_id', $company_id)
            ->where('client_id', $client_id)
            ->whereDate('created_at', Carbon::today())
            ->get();
        return view('client.pos.print_report', compact('company_id', 'company', 'pos_sales'));
    }

    public function pos_edit(Request $request)
    {
        //user data..
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $client_id = Auth::user()->id;

        //get bill id..
        $bill_id = $request->bill_id;
        $pos = PosOpen::where('id', $bill_id)->first();
        $pos_open = PosOpen::where('client_id', $client_id)
            ->where('status', 'open')
            ->first();
        $elements = $pos->elements;
        $pos_tax = $pos->tax;
        $pos_discount = $pos->discount;
        $sum = 0;
        foreach ($elements as $pos_element) {
            $sum = $sum + $pos_element->quantity_price;
        }

        //get bill data to show..
        if (isset($pos) && isset($pos_tax) && empty($pos_discount)) {
            $tax_value = $pos_tax->tax_value;
            $percent = $tax_value / 100 * $sum;
            $sum = $sum + $percent;
        } elseif (isset($pos) && isset($pos_discount) && empty($pos_tax)) {
            $discount_value = $pos_discount->discount_value;
            $discount_type = $pos_discount->discount_type;
            if ($discount_type == "pound") {
                $sum = $sum - $discount_value;
            } else {
                $discount_value = ($discount_value / 100) * $sum;
                $sum = $sum - $discount_value;
            }
        } elseif (isset($pos) && !empty($pos_discount) && !empty($pos_tax)) {
            $tax_value = $pos_tax->tax_value;
            $discount_value = $pos_discount->discount_value;
            $discount_type = $pos_discount->discount_type;
            if ($discount_type == "percent") {
                $discount_value = ($discount_value / 100) * $sum;
            }
            $tot = $sum - $discount_value;
            $percent = $tax_value / 100 * $tot;
            $sum = $sum - $discount_value + $percent;
        }


        if (!empty($pos)) {
            if (!empty($pos_open)) {
                $pos_open->update([
                    'status' => 'pending'
                ]);
            }

            $cash_id = "pos_" . $bill_id;
            $cash = Cash::where('bill_id', $cash_id)->get();
            if (!$cash->isEmpty()) {
                $cash_amount = 0;
                foreach ($cash as $item) {
                    $cash_amount = $cash_amount + $item->amount;
//                    $amount = $item->amount;
//                    $safe = Safe::FindOrFail($item->safe_id);
//                    $old_safe_balance = $safe->balance;
//                    $new_safe_balance = $old_safe_balance - $amount;
//                    $safe->update([
//                        'balance' => $new_safe_balance
//                    ]);
                }
            } else {
                $cash_amount = 0;
            }

            $bank_cash = BankCash::where('bill_id', $cash_id)->get();
            if (!$bank_cash->isEmpty()) {
                $cash_bank_amount = 0;
                foreach ($bank_cash as $item) {
                    $cash_bank_amount = $cash_bank_amount + $item->amount;
//                    $amount = $item->amount;
//                    $bank = Bank::FindOrFail($item->bank_id);
//                    $old_bank_balance = $bank->bank_balance;
//                    $new_bank_balance = $old_bank_balance - $amount;
//                    $bank->update([
//                        'bank_balance' => $new_bank_balance
//                    ]);
                }
            } else {
                $cash_bank_amount = 0;
            }

            $coupon_cash = CouponCash::where('bill_id', $cash_id)->get();
            if (!$coupon_cash->isEmpty()) {
                $cash_coupon_amount = 0;
                foreach ($coupon_cash as $item) {
                    $cash_coupon_amount = $cash_coupon_amount + $item->amount;
                    $item->coupon->update([
                        'status' => 'new'
                    ]);
                }
            } else {
                $cash_coupon_amount = 0;
            }
            $total_amount = $cash_amount + $cash_bank_amount + $cash_coupon_amount;
            $rest = $sum - $total_amount;

            if (isset($pos->outer_client_id) && !empty($pos->outer_client_id)) {
                $outer_client = OuterClient::FindOrFail($pos->outer_client_id);
                $prev_balance = $outer_client->prev_balance;

                $new_balance = $prev_balance - $rest;
                $outer_client->update([
                    'prev_balance' => $new_balance
                ]);
            }


            $pos->update([
                'status' => 'open',
                'editing' => 1,
            ]);
            foreach ($elements as $element) {
                $product = Product::FindOrFail($element->product_id);
                $category_type = $product->category->category_type;
                if ($category_type == "مخزونية") {
                    $product_before_balance = $product->first_balance;
                    $product_after_balance = $product_before_balance + $element->quantity;
                    $product->update([
                        'first_balance' => $product_after_balance
                    ]);
                }
            }
            return response()->json([
                'message' => '',
                'success' => 1
            ]);
        } else {
            return response()->json([
                'message' => 'لا يوجد فاتورة مسجلة بهذا الرقم',
                'success' => 0
            ]);
        }
    }

    public function delete_pos_open(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $client_id = Auth::user()->id;
        $pos_open = PosOpen::where('client_id', $client_id)
            ->where('status', 'open')
            ->first();
        if (!empty($pos_open)) {
            $cash_id = "pos_" . $pos_open->id;
            $cash = Cash::where('bill_id', $cash_id)->get();
            if (!$cash->isEmpty()) {
                foreach ($cash as $item) {
                    $amount = $item->amount;
                    $safe = Safe::FindOrFail($item->safe_id);
                    $old_safe_balance = $safe->balance;
                    $new_safe_balance = $old_safe_balance - $amount;
                    $safe->update([
                        'balance' => $new_safe_balance
                    ]);
                    $item->delete();
                }
            }

            $bank_cash = BankCash::where('bill_id', $cash_id)->get();
            if (!$bank_cash->isEmpty()) {
                foreach ($bank_cash as $item) {
                    $amount = $item->amount;
                    $bank = Bank::FindOrFail($item->bank_id);
                    $old_bank_balance = $bank->bank_balance;
                    $new_bank_balance = $old_bank_balance - $amount;
                    $bank->update([
                        'bank_balance' => $new_bank_balance
                    ]);
                    $item->delete();
                }
            }
            $coupon_cash = CouponCash::where('bill_id', $cash_id)->get();
            if (!$coupon_cash->isEmpty()) {
                foreach ($coupon_cash as $item) {
                    $item->coupon->update([
                        'status' => 'new'
                    ]);
                    $item->delete();
                }
            }

            $pos_open->delete();
            return response()->json([
                'reason' => 'تم الغاء الفاتورة',
                'success' => 1
            ]);
        } else {
            return response()->json([
                'reason' => 'لا يوجد فاتورة لحذفها',
                'success' => 0
            ]);
        }
    }

    public function pos_delete(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $client_id = Auth::user()->id;
        $bill_id = $request->bill_id;
        $pos = PosOpen::where('id', $bill_id)->first();
        $elements = $pos->elements;
        $pos_tax = $pos->tax;
        $pos_discount = $pos->discount;
        $sum = 0;
        foreach ($elements as $pos_element) {
            $sum = $sum + $pos_element->quantity_price;
        }
        if (isset($pos) && isset($pos_tax) && empty($pos_discount)) {
            $tax_value = $pos_tax->tax_value;
            $percent = $tax_value / 100 * $sum;
            $sum = $sum + $percent;
        } elseif (isset($pos) && isset($pos_discount) && empty($pos_tax)) {
            $discount_value = $pos_discount->discount_value;
            $discount_type = $pos_discount->discount_type;
            if ($discount_type == "pound") {
                $sum = $sum - $discount_value;
            } else {
                $discount_value = ($discount_value / 100) * $sum;
                $sum = $sum - $discount_value;
            }
        } elseif (isset($pos) && !empty($pos_discount) && !empty($pos_tax)) {
            $tax_value = $pos_tax->tax_value;
            $discount_value = $pos_discount->discount_value;
            $discount_type = $pos_discount->discount_type;
            if ($discount_type == "percent") {
                $discount_value = ($discount_value / 100) * $sum;
            }
            $tot = $sum - $discount_value;
            $percent = $tax_value / 100 * $tot;
            $sum = $sum - $discount_value + $percent;
        }

        if (!empty($pos)) {
            $cash_id = "pos_" . $bill_id;
            $cash = Cash::where('bill_id', $cash_id)->get();
            if (!$cash->isEmpty()) {
                $cash_amount = 0;
                foreach ($cash as $item) {
                    $cash_amount = $cash_amount + $item->amount;
                    $amount = $item->amount;
                    $safe = Safe::FindOrFail($item->safe_id);
                    $old_safe_balance = $safe->balance;
                    $new_safe_balance = $old_safe_balance - $amount;
                    $safe->update([
                        'balance' => $new_safe_balance
                    ]);
                    $item->delete();
                }
            } else {
                $cash_amount = 0;
            }

            $bank_cash = BankCash::where('bill_id', $cash_id)->get();
            if (!$bank_cash->isEmpty()) {
                $cash_bank_amount = 0;
                foreach ($bank_cash as $item) {
                    $cash_bank_amount = $cash_bank_amount + $item->amount;
                    $amount = $item->amount;
                    $bank = Bank::FindOrFail($item->bank_id);
                    $old_bank_balance = $bank->bank_balance;
                    $new_bank_balance = $old_bank_balance - $amount;
                    $bank->update([
                        'bank_balance' => $new_bank_balance
                    ]);
                    $item->delete();
                }
            } else {
                $cash_bank_amount = 0;
            }

            $coupon_cash = CouponCash::where('bill_id', $cash_id)->get();
            if (!$coupon_cash->isEmpty()) {
                $cash_coupon_amount = 0;
                foreach ($coupon_cash as $item) {
                    $cash_coupon_amount = $cash_coupon_amount + $item->amount;
                    $item->coupon->update([
                        'status' => 'new'
                    ]);
                    $item->delete();
                }
            } else {
                $cash_coupon_amount = 0;
            }
            $total_amount = $cash_amount + $cash_bank_amount + $cash_coupon_amount;
            $rest = $sum - $total_amount;

            if (isset($pos->outer_client_id) && !empty($pos->outer_client_id)) {
                $outer_client = OuterClient::FindOrFail($pos->outer_client_id);
                $prev_balance = $outer_client->prev_balance;

                $new_balance = $prev_balance - $rest;
                $outer_client->update([
                    'prev_balance' => $new_balance
                ]);
            }
        }
        foreach ($elements as $element) {
            $product = Product::FindOrFail($element->product_id);
            $category_type = $product->category->category_type;
            if ($category_type == "مخزونية") {
                $product_before_balance = $product->first_balance;
                $product_after_balance = $product_before_balance + $element->quantity;
                $product->update([
                    'first_balance' => $product_after_balance
                ]);
            }
        }
        $pos->delete();
        return response()->json([
            'message' => 'تم حذف الفاتورة بنجاح',
            'success' => 1,
        ]);
    }

    public function pay_delete(Request $request)
    {
        $payment_method = $request->payment_method;
        $cash_id = $request->cash_id;
        if ($payment_method == "cash") {
            $cash = Cash::FindOrFail($cash_id);
            $amount = $cash->amount;
            $safe = Safe::FindOrFail($cash->safe_id);
            $old_safe_balance = $safe->balance;
            $new_safe_balance = $old_safe_balance - $amount;
            $safe->update([
                'balance' => $new_safe_balance
            ]);
            $cash->delete();
        } elseif ($payment_method == "coupon") {
            $cash = CouponCash::FindOrFail($cash_id);
            $cash->coupon->update([
                'status' => 'new'
            ]);
            $cash->delete();
        } elseif ($payment_method == "bank") {
            $cash = BankCash::FindOrFail($cash_id);
            $amount = $cash->amount;
            $bank = Bank::FindOrFail($cash->bank_id);
            $old_bank_balance = $bank->bank_balance;
            $new_bank_balance = $old_bank_balance - $amount;
            $bank->update([
                'bank_balance' => $new_bank_balance
            ]);
            $cash->delete();
        }
    }


    // pos invoice button فاتورة الإعداد
    public function prod_pos($invID)
    {
        $pos = PosOpen::FindOrFail($invID);
        return view('client.pos.prod_pos', compact('pos'));
    }


    public function checkTaxEntka2ya()
    {
        $chk = Tax::where('company_id', Auth::user()->company_id)
            ->where('tax_name', 'ضريبه دمغه')
            ->first();
        //adding it if not exists.
        if (!$chk && empty($chk)) {
            if (Tax::create([
                'company_id' => Auth::user()->company_id,
                'client_id' => Auth::user()->id,
                'tax_name' => 'ضريبه دمغه',
                'tax_value' => '130'
            ])) return 1;
        }
        if ($chk && $chk->tax_value != 130) {
            if ($chk->update([
                'tax_value' => '130'
            ])) return 1;
        }
        return 0;
    }

    //--report--تقرير المنتجات المباعة اليوم-----//
    public function sales_products_today()
    {
        # get products to compare with pos_invoices.
        $POSs = PosOpen::where('company_id', Auth::user()->company_id)
            ->whereDate('created_at', Carbon::today())
            ->get();
        $productsSoldToday = [];

        $totalTax = $totalPrice = 0;
        foreach ($POSs as $pos) {

            # get elements and taxes of pos invoice #
            $elements = $pos->elements;
            $pos_tax = $pos->tax;

            # loop for each product in the invoice #
            foreach ($elements as $element) {
                # calc tax of the product #
                if ($pos->value_added_tax) { #inlcusive
                    $tax = ($element->product_price * $element->quantity) - (($element->product_price * $element->quantity) / 115);
                } else { # exclusive get from taxes table.
                    if (isset($pos_tax->tax_value))
                        $tax = (($element->product_price * $element->quantity) * $pos_tax->tax_value) / 100;
                    else
                        $tax = 0;
                }

                $totalTax += $tax;
                $totalPrice += ($element->product_price * $element->quantity);
                $priceBeforeTax = round(($element->product_price * $element->quantity), 3) - round($tax, 3);
                $prodArr = [
                    'name' => $element->product->product_name,
                    'priceBeforeTax' => $priceBeforeTax,
                    'price' => round(($element->product_price * $element->quantity), 3),
                    'tax' => round($tax, 3),
                    'count' => $element->quantity
                ];

                # chk if this product added before #
                $i = 0;
                $flag = false;
                foreach ($productsSoldToday as $arr) {
                    if ($arr['name'] == $element->product->product_name) {
                        $flag = true;
                        # if in array just increment the value of count.
                        $productsSoldToday[$i]['priceBeforeTax'] += $priceBeforeTax;
                        $productsSoldToday[$i]['price'] += ($element->product_price * $element->quantity);
                        $productsSoldToday[$i]['tax'] += $tax;
                        $productsSoldToday[$i]['count'] += $element->quantity;
                    }
                    $i++;
                }

                if (!$flag) {
                    array_push($productsSoldToday, $prodArr);
                }
            }
        }# end foreach.
        return view('client.pos.report_sales_products', compact('productsSoldToday', 'totalTax', 'totalPrice'));
    }

    public function printProductSales()
    {
        # get products to compare with pos_invoices.
        $company_id = Auth::user()->company_id;
        $company = Company::findOrFail($company_id);
        $POSs = PosOpen::where('company_id', $company_id)
            ->whereDate('created_at', Carbon::today())
            ->get();
        $productsSoldToday = [];

        $totalTax = $totalPrice = 0;
        foreach ($POSs as $pos) {

            # get elements and taxes of pos invoice #
            $elements = $pos->elements;
            $pos_tax = $pos->tax;

            # loop for each product in the invoice #
            foreach ($elements as $element) {
                # calc tax of the product #
                if ($pos->value_added_tax) { #inlcusive
                    $tax = ($element->product_price * $element->quantity) - (($element->product_price * $element->quantity) / 115);
                } else { # exclusive get from taxes table.
                    if (isset($pos_tax->tax_value))
                        $tax = (($element->product_price * $element->quantity) * $pos_tax->tax_value) / 100;
                    else
                        $tax = 0;
                }

                $totalTax += $tax;
                $totalPrice += ($element->product_price * $element->quantity);
                $priceBeforeTax = round(($element->product_price * $element->quantity), 3) - round($tax, 3);
                $prodArr = [
                    'name' => $element->product->product_name,
                    'priceBeforeTax' => $priceBeforeTax,
                    'price' => round(($element->product_price * $element->quantity), 3),
                    'tax' => round($tax, 3),
                    'count' => $element->quantity
                ];

                # chk if this product added before #
                $i = 0;
                $flag = false;
                foreach ($productsSoldToday as $arr) {
                    if ($arr['name'] == $element->product->product_name) {
                        $flag = true;
                        # if in array just increment the value of count.
                        $productsSoldToday[$i]['priceBeforeTax'] += $priceBeforeTax;
                        $productsSoldToday[$i]['price'] += ($element->product_price * $element->quantity);
                        $productsSoldToday[$i]['tax'] += $tax;
                        $productsSoldToday[$i]['count'] += $element->quantity;
                    }
                    $i++;
                }

                if (!$flag) {
                    array_push($productsSoldToday, $prodArr);
                }
            }
        }# end foreach.
        return view('client.pos.report_sales_products_print', compact('company', 'productsSoldToday', 'totalTax', 'totalPrice'));
    }

    public function pos_sales_report_print_today_button()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $client_id = Auth::user()->id;
        $pos_sales = PosOpen::where('status', 'done')
            ->where('company_id', $company_id)
            ->where('client_id', $client_id)
            ->whereDate('created_at', Carbon::today())
            ->get();
        return view('client.pos.print_report_button', compact('company_id', 'company', 'pos_sales'));
    }

    public function getAllSubCatsAndProducts(Request $request)
    {
        $subCategories = SubCategory::where('company_id', Auth::user()->company_id)->get();
        $user = Client::findOrFail(Auth::user()->id);
        if ($user->branch_id && !empty($user->branch_id)) {
            $products = Product::where('company_id', Auth::user()->company_id)
                ->where(function ($query) {
                    $query->where('first_balance', '>', 0)
                        ->orWhereNull('first_balance');
                })->get();
        } else {
            $products = Product::where('company_id', Auth::user()->company_id)
                ->where('first_balance', '>', 0)
                ->paginate(80);
        }
        return json_encode([$subCategories, $products]);
    }
}
