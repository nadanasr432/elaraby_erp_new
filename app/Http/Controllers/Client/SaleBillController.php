<?php

namespace App\Http\Controllers\Client;

use App\Models\Bank;
use App\Models\Cash;
use App\Models\Safe;
use App\Models\Branch;
use App\Models\Client;
use App\Models\Company;
use App\Models\Product;
use App\Models\BankCash;
use App\Models\SaleBill;
use App\Models\OuterClient;
use App\Models\SaleBillNote;
use Illuminate\Http\Request;
use App\Mail\sendingSaleBill;
use App\Models\BasicSettings;
use App\Models\ExtraSettings;
use App\Models\SaleBillExtra;
use App\Models\SaleBillReturn;
use App\Models\SaleBillElement;
use App\Models\OuterClientAddress;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use AIOSEO\Plugin\Common\Utils\Cache;
use App\Http\Requests\SaleBillRequest;
use Illuminate\Support\Facades\Artisan;

class SaleBillController extends Controller
{
    public function createTokensForAllInvoices()
    {
        $saleBills = SaleBill::get();
        foreach ($saleBills as $saleBill) {
            $saleBill->token = $this->createHashToken(30);
            $saleBill->save();
        }
        echo "done....";
    }

    public function reAssignPayments()
    {
        $company = Company::findOrFail(Auth::user()->company_id);
        foreach ($company->sale_bills as $saleBill) {
            $sale_bill_cash = Cash::where('bill_id', $saleBill->sale_bill_number)->get();
            $totalPaid = 0;
            if (!empty($sale_bill_cash)) {
                foreach ($sale_bill_cash as $row) {
                    $totalPaid += $row->amount;
                }
                $saleBill->update(['paid' => $totalPaid]);
            }
        }
    }

    # index page #
    public function index()
    {
        $this->reAssignPayments();
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $sale_bills = SaleBill::latest()->where('company_id', $company_id)->where('status', 'done')->get();
        if (in_array('مدير النظام', Auth::user()->role_name)) {
            $outer_clients = OuterClient::where('company_id', $company_id)->get();
        } else {
            $outer_clients = OuterClient::where('company_id', $company_id)
                ->where(function ($query) {
                    $query->where('client_id', Auth::user()->id)
                        ->orWhereNull('client_id');
                })->get();
        }

        $products = $company->products;
        return view('client.sale_bills.index', compact('company', 'products', 'company_id', 'outer_clients', 'sale_bills'));
    }

    # create page #
    public function create()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $client_id = Auth::user()->id;

        //get products that خدمية and update its stock
        $products = Product::with('category')->where('company_id', $company_id)
            ->where('first_balance', '<=', 0)
            ->get();
        if (!empty($products)) {
            foreach ($products as $khadamy) {
                if ($khadamy->category->category_type == "خدمية") {
                    $khadamy->first_balance = 100000;
                    $khadamy->update();
                }
            }
        }
        ///////////////////////////////////////////////

        $categories = $company->categories;
        $user = Client::FindOrFail($client_id);
        if (!empty($user->branch_id)) {
            $branch = Branch::FindOrFail($user->branch_id);
            $stores = $branch->stores;
            $flatStores = $stores->pluck('id')->toArray();

            $all_products = Product::where('company_id', $company_id)
                ->where(function ($query) {
                    $query->where('first_balance', '>', 0)
                        ->orWhereNull('first_balance');
                })
                ->whereIn('store_id', $flatStores)
                ->orWhereNull('store_id')
                ->get();

        } else {
            $stores = $company->stores;
            $all_products = $company->products;
        }
        $units = $company->units;
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        if (in_array('مدير النظام', Auth::user()->role_name)) {
            $outer_clients = OuterClient::where('company_id', $company_id)->get();
        } else {
            $outer_clients = OuterClient::where('company_id', $company_id)
                ->where(function ($query) {
                    $query->where('client_id', Auth::user()->id)
                        ->orWhereNull('client_id');
                })->get();
        }
        $check = SaleBill::where('company_id', $company_id)->count();
        if ($check == 0) {
            $pre_bill = SaleBill::max('sale_bill_number') + 1;
            $pre_counter = 1;
        } else {
            $old_pre_bill = SaleBill::max('sale_bill_number');
            $pre_bill = ++$old_pre_bill;
            $old_pre_counter = SaleBill::where('company_id', $company_id)->max('company_counter');
            $pre_counter = $old_pre_counter + 1;
        }
        $check = Cash::all();
        if ($check->isEmpty()) {
            $pre_cash = 1;
        } else {
            $old_cash = Cash::max('cash_number');
            $pre_cash = ++$old_cash;
        }
        $safes = $company->safes;
        $banks = $company->banks;

        $user = Auth::user();
        $type_name = $user->company->subscription->type->type_name;
        if ($type_name == "تجربة") {
            $bills_count = "غير محدود";
        } else {
            $bills_count = $user->company->subscription->type->package->bills_count;
        }
        $company_bills_count = $company->sale_bills->count();
        $open_sale_bill = "";
        return view(
            'client.sale_bills.create',
            compact(
                'company',
                'open_sale_bill',
                'units',
                'pre_cash',
                'stores',
                'safes',
                'banks',
                'outer_clients',
                'categories',
                'extra_settings',
                'company_id',
                'all_products',
                'pre_bill',
                'pre_counter'
            )
        );
    }

    public function store_cash_outer_clients(SaleBillRequest $request)
    {
        $data = $request->all();
        $company_id = $data['company_id'];
        $data['client_id'] = Auth::user()->id;
        $amount = $data['amount'];
        $bill_id = $request->bill_id;
        $sale_bill = SaleBill::where('sale_bill_number', $bill_id)->firstOrFail();

        if ($sale_bill->paid >= $sale_bill->final_total) {
            return response()->json([
                'status' => true,
                'msg' => 'غير مسموح لك .. تم الدفع من قبل'
            ]);
        }

        $sale_bill->update(['paid' => ($sale_bill->paid + $amount)]);
        $outer_client_id = $data['outer_client_id'];

        if (!empty($sale_bill->outer_client_id)) {
            $outer_client = OuterClient::FindOrFail($outer_client_id);
            $balance_before = $outer_client->prev_balance;
            $balance_after = $balance_before - $amount;
            $data['balance_before'] = $balance_before;
            $data['balance_after'] = $balance_after;
        } else {
            $data['balance_before'] = 0;
            $data['balance_after'] = 0;
        }

        $payment_method = $data['payment_method'];
        if ($payment_method == "cash") {
            if ($sale_bill->paid <= $sale_bill->final_total) {
                $cash = Cash::create($data);
            }
        } else {
            $check = BankCash::where('bill_id', $request->bill_id)
                ->where('company_id', $company_id)
                ->where('client_id', $data['client_id'])
                ->where('outer_client_id', $outer_client_id)
                ->first();
            if (empty($check)) {
                $cash = BankCash::create($data);
            } else {
                return response()->json([
                    'status' => true,
                    'msg' => 'غير مسموح لك .. تم الدفع من قبل'
                ]);
            }
        }
        if ($cash) {
            if ($payment_method == "cash") {
                $pay_method = 'دفع نقدى كاش ';
            } elseif ($payment_method == "bank") {
                $pay_method = 'دفع بنكى شبكة ';
            }
            $button = '<button type="button" payment_method="' . $payment_method . '" cash_id="' . $cash->id . '"
                class="btn btn-danger delete_pay pull-left"> حذف </button> ';
            $clear = '<div class="clearfix"></div>';

            return response()->json([
                'status' => true,
                'msg' => ' تم تسجيل الدفع بنجاح ' . " ( " . $pay_method . " ) " . " المبلغ : " . $amount . $button . $clear,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'هناك خطأ فى تسجيل الدفع النقدى حاول مرة اخرى',
            ]);
        }
    }

    # delete payment from the table #
    public function pay_delete(Request $request)
    {
        $payment_method = $request->payment_method;
        $cash_id = $request->cash_id;
        if ($payment_method == "cash") {
            $cash = Cash::FindOrFail($cash_id);
            $cash->delete();
        } elseif ($payment_method == "bank") {
            $cash = BankCash::FindOrFail($cash_id);
            $cash->delete();
        }
    }

    function createHashToken($length = 15)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString . rand(0, 9999999999);
    }

    # this function adds products to the invoice #
    public function save(Request $request)
    {
        # get formData.
        $data = $request->all();
        $data['company_id'] = Auth::user()->company_id;
        $company = Company::FindOrFail($data['company_id']);
        $data['client_id'] = Auth::user()->id;

        # get saleBill using saleBillNumber -> if empty then create else update.
        $SaleBill = SaleBill::where('sale_bill_number', $data['sale_bill_number'])->first();
        if (empty($SaleBill)) {
            $old_pre_counter = SaleBill::where('company_id', $company->id)->max('company_counter');
            $pre_counter = ++$old_pre_counter;
            $data['company_counter'] = $pre_counter;
            $data['token'] = $this->createHashToken(30);
            $SaleBill = SaleBill::create($data);
        } else {
            $SaleBill->update($data);
        }

        $data['sale_bill_id'] = $SaleBill->id;
        $data['company_id'] = $company->id;

        # get elements of sale invoice if empty then create else update..
        $check = SaleBillElement::where('sale_bill_id', $SaleBill->id)
            ->where('product_id', $request->product_id)
            ->where('company_id', $company->id)
            ->first();
        if (empty($check)) {
            $sale_bill_element = SaleBillElement::create($data);
        } else {
            $old_quantity = $check->quantity;
            $new_quantity = $old_quantity + $request->quantity;
            $product_price = $request->product_price;
            $new_quantity_price = $new_quantity * $product_price;
            $unit_id = $request->unit_id;
            $sale_bill_element = $check->update([
                'product_price' => $product_price,
                'quantity' => $new_quantity,
                'unit_id' => $unit_id,
                'quantity_price' => $new_quantity_price,
            ]);
        }

        # return appropriate msg if created or updated.
        if ($SaleBill && $sale_bill_element) {
            $all_elements = SaleBillElement::where('sale_bill_id', $SaleBill->id)->get();
            return response()->json([
                'status' => true,
                'msg' => 'تمت الاضافة الى الفاتورة بنجاح',
                'all_elements' => $all_elements,
            ]);
        } else {
            $all_elements = SaleBillElement::where('sale_bill_id', $SaleBill->id)->get();
            return response()->json([
                'status' => false,
                'msg' => 'هناك خطأ فى عملية الاضافة',
                'all_elements' => $all_elements,
            ]);
        }
    }

    # save then redirect to print #
    public function saveAll(Request $request)
    {
        # get companyData.
        $data = $request->all();
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $client_id = Auth::user()->id;

        # get invoiceData.
        $sale_bill = SaleBill::where('sale_bill_number', $request->sale_bill_number)
            ->where('company_id', $company_id)->first();
        $elements = \App\Models\SaleBillElement::where('sale_bill_id', $sale_bill->id)
            ->where('company_id', $sale_bill->company_id)
            ->get();
        # update products balance
        foreach ($elements as $element) {
            $product = Product::FindOrFail($element->product_id);
            $category_type = $product->category->category_type;
            if ($category_type == "مخزونية") {
                $old_product_balance = $product->first_balance;
                $new_product_balance = $old_product_balance - $element->quantity;
                $product->update([
                    'first_balance' => $new_product_balance
                ]);
            }
        }

        # get tax settings from company settings #
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $tax_value_added = $company->tax_value_added;

        # calc total price of products.
        $sum = array();
        foreach ($elements as $element) {
            array_push($sum, $element->quantity_price);
        }
        $total = array_sum($sum);

        # calc shipping #
        $previous_extra = SaleBillExtra::where('sale_bill_id', $sale_bill->id)
            ->where('action', 'extra')->first();
        if (!empty($previous_extra)) {
            $previous_extra_type = $previous_extra->action_type;
            $previous_extra_value = $previous_extra->value;
            if ($previous_extra_type == "percent") {
                $previous_extra_value = $previous_extra_value / 100 * $total;
            }
            $after_discount = $total + $previous_extra_value;
        }
        #---------------#

        # calc discount #
        $previous_discount = SaleBillExtra::where('sale_bill_id', $sale_bill->id)
            ->where('action', 'discount')->first();
        if (!empty($previous_discount)) {
            $previous_discount_type = $previous_discount->action_type;
            $previous_discount_value = $previous_discount->value;
            if ($previous_discount_type == "percent" || $previous_discount_type == "afterTax") {
                $previous_discount_value = $previous_discount_value / 100 * $total;
            }
            if ($previous_discount_type != "poundAfterTax" && $previous_discount_type != "poundAfterTaxPercent")
                $after_discount = $total - $previous_discount_value;
        }
        #---------------#

        # calc total Price After Discount & Shipping #
        if (!empty($previous_extra) && !empty($previous_discount)) {
            if ($previous_discount_type != "poundAfterTax" && $previous_discount_type != "poundAfterTaxPercent")
                $after_discount = $total - $previous_discount_value + $previous_extra_value;
        } else {
            $after_discount = $total;
        }
        #-------------------------------------------#

        # calc final_total with tax if inclusive or exclusive
        $tax_option = $sale_bill->value_added_tax;
        if (isset($after_discount) && $after_discount != 0) {
            # calc final_total with inserted tax if inclusive or exclusive.
            if ($tax_option == 0) { #exclusive
                $percentage = ($tax_value_added / 100) * $after_discount;
                $after_total_all = $after_discount + $percentage;
            } else # so its inclusive
                $after_total_all = $after_discount;
        } else {
            # calc final_total with inserted tax if inclusive or exclusive.
            if ($tax_option == 0) { #exclusive
                $percentage = ($tax_value_added / 100) * $total;
                $after_total_all = $total + $percentage;
            } else # so its inclusive
                $after_total_all = $total;
        }

        if ($previous_discount_type == "poundAfterTax") {
            $after_total_all = $after_total_all - $previous_discount_value;
        } elseif ($previous_discount_type == "poundAfterTaxPercent") {
            $after_total_all = $after_total_all - (($total * $previous_discount_value) / 100);
        }
        #-------------------------------------------#

        # get cash if exists #
        $cash = Cash::where('bill_id', $sale_bill->sale_bill_number)
            ->where('company_id', $company_id)
            ->where('client_id', $sale_bill->client_id)
            ->where('outer_client_id', $sale_bill->outer_client_id)
            ->first();
        if (!empty($cash)) {
            $amount = $cash->amount;
            $rest = $after_total_all - $amount;
            if (!empty($sale_bill->outer_client_id)) {
                $outer_client = OuterClient::FindOrFail($sale_bill->outer_client_id);
                $balance_before = $outer_client->prev_balance;
                $balance_after = $balance_before + $rest;
                $outer_client->update([
                    'prev_balance' => $balance_after
                ]);
            }

            $safe_id = $cash->safe_id;
            $safe = Safe::FindOrFail($safe_id);
            $safe_balance_before = $safe->balance;
            $safe_balance_after = $safe_balance_before + $amount;
            $safe->update([
                'balance' => $safe_balance_after
            ]);
            $sale_bill->update([
                'status' => 'done',
                'paid' => $amount,
                'rest' => $rest,
            ]);
        }
        #-------------------------------------------#

        # get bank if exists #
        $bank_cash = BankCash::where('bill_id', $sale_bill->sale_bill_number)
            ->where('company_id', $company_id)
            ->where('client_id', $sale_bill->client_id)
            ->where('outer_client_id', $sale_bill->outer_client_id)
            ->first();
        if (!empty($bank_cash)) {
            $amount = $bank_cash->amount;
            $rest = $after_total_all - $amount;
            if (!empty($sale_bill->outer_client_id)) {
                $outer_client = OuterClient::FindOrFail($sale_bill->outer_client_id);
                $balance_before = $outer_client->prev_balance;
                $balance_after = $balance_before + $rest;
                $outer_client->update([
                    'prev_balance' => $balance_after
                ]);
            }

            $bank_id = $bank_cash->bank_id;
            $bank = Bank::FindOrFail($bank_id);
            $bank_balance_before = $bank->bank_balance;
            $bank_balance_after = $bank_balance_before + $amount;
            $bank->update([
                'bank_balance' => $bank_balance_after
            ]);
            $sale_bill->update([
                'status' => 'done',
                'paid' => $amount,
                'rest' => $rest,
            ]);
        }
        #-------------------------------------------#

        # update payment #
        if (empty($bank_cash) && empty($cash)) {
            $rest = $after_total_all;
            if (!empty($sale_bill->outer_client_id)) {
                $outer_client = OuterClient::FindOrFail($sale_bill->outer_client_id);
                $outer_client->update([
                    'prev_balance' => ($outer_client->prev_balance) + $rest,
                ]);
            }
            $sale_bill->update([
                'final_total' => $after_total_all,
                'status' => 'done',
                'paid' => '0',
                'rest' => $rest,
            ]);
        }
        #-------------------------------------------#
        $sale_bill->update(['final_total' => $after_total_all]);
        return $sale_bill->token;
    }

    public function send($id)
    {
        $sale_bill = SaleBill::where('sale_bill_number', $id)->first();
        $url = 'https://' . request()->getHttpHost() . '/sale-bills/print/' . $id;
        $data = array(
            'body' => 'بيانات الفاتورة ',
            'url' => $url,
            'subject' => 'مرفق مع هذه الرسالة بيانات تفصيلية للفاتورة ',
        );
        Mail::to($sale_bill->outerClient->client_email)->send(new sendingSaleBill($data));
        return redirect()->route('client.sale_bills.index')
            ->with('success', 'تم ارسال فاتورة البيع الى بريد العميل بنجاح');
    }

    public function show($id)
    {
        dd($id);
    }

    public function destroy(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $client_id = Auth::user()->id;
        $sale_bill_number = $request->sale_bill_number;
        $sale_bill = SaleBill::where('sale_bill_number', $sale_bill_number)->first();
        $sale_bill->elements()->delete();
        $sale_bill->extras()->delete();
        $cash = Cash::where('bill_id', $sale_bill->sale_bill_number)
            ->where('company_id', $company_id)
            ->where('client_id', $sale_bill->client_id)
            ->where('outer_client_id', $sale_bill->outer_client_id)
            ->first();
        if (!empty($cash)) {
            $cash->delete();
        }
        $cash = BankCash::where('bill_id', $sale_bill->sale_bill_number)
            ->where('company_id', $company_id)
            ->where('client_id', $sale_bill->client_id)
            ->where('outer_client_id', $sale_bill->outer_client_id)
            ->first();
        if (!empty($cash)) {
            $cash->delete();
        }
        $sale_bill->delete();
        return redirect()->route('client.sale_bills.create')
            ->with('success', 'تم حذف الفاتورة  بنجاح');
    }

    public function delete_bill(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $client_id = Auth::user()->id;
        $bill_id = $request->billid;
        $sale_bill = SaleBill::FindOrFail($bill_id);
        $elements = \App\Models\SaleBillElement::where('sale_bill_id', $sale_bill->id)
            ->where('company_id', $sale_bill->company_id)
            ->get();
        $extras = $sale_bill->extras;
        $final_total = $sale_bill->final_total;
        $paid = $sale_bill->paid;
        $rest = $sale_bill->rest;

        foreach ($elements as $element) {
            $quantity = $element->quantity;
            $product_id = $element->product_id;
            $product = Product::FindOrFail($product_id);
            $category_type = $product->category->category_type;
            if ($category_type == "مخزونية") {
                $prev_balance = $product->first_balance;
                $curr_balance = $prev_balance + $quantity;
                $product->update([
                    'first_balance' => $curr_balance
                ]);
            }
        }

        $sale_bill->elements()->delete();
        $sale_bill->extras()->delete();
        $cash = Cash::where('bill_id', $sale_bill->sale_bill_number)
            ->where('company_id', $company_id)
            ->where('client_id', $sale_bill->client_id)
            ->where('outer_client_id', $sale_bill->outer_client_id)
            ->first();
        if (!empty($cash)) {
            $safe_id = $cash->safe_id;
            $safe = Safe::FindOrFail($safe_id);
            $safe_balance_before = $safe->balance;
            $safe_balance_after = $safe_balance_before - $cash->amount;
            $safe->update([
                'balance' => $safe_balance_after
            ]);

            $cash->delete();
        }
        $bank_cash = BankCash::where('bill_id', $sale_bill->sale_bill_number)
            ->where('company_id', $company_id)
            ->where('client_id', $sale_bill->client_id)
            ->where('outer_client_id', $sale_bill->outer_client_id)
            ->first();
        if (!empty($bank_cash)) {
            $bank_id = $bank_cash->bank_id;
            $bank = Bank::FindOrFail($bank_id);
            $bank_balance_before = $bank->bank_balance;
            $bank_balance_after = $bank_balance_before - $bank_cash->amount;
            $bank->update([
                'bank_balance' => $bank_balance_after
            ]);
            $bank_cash->delete();
        }
        if (!empty($sale_bill->outer_client_id)) {
            $outer_client = OuterClient::FindOrFail($sale_bill->outer_client_id);
            $balance_before = $outer_client->prev_balance;
            $balance_after = $balance_before - $rest;
            $outer_client->update([
                'prev_balance' => $balance_after
            ]);
        }

        $sale_bill->delete();
        return redirect()->route('client.sale_bills.index')
            ->with('success', 'تم حذف الفاتورة  بنجاح');
    }

    public function edit_element(Request $request)
    {
        $element = SaleBillElement::FindOrFail($request->element_id);
        $product_id = $element->product_id;
        $product_price = $element->product_price;
        $quantity = $element->quantity;
        $quantity_price = $element->quantity_price;
        $unit_id = $element->unit_id;
        return response()->json([
            'product_id' => $product_id,
            'product_price' => $product_price,
            'quantity' => $quantity,
            'quantity_price' => $quantity_price,
            'unit_id' => $unit_id,
        ]);
    }

    public function edit($token, $compID = null)
    {
        $compID = $compID ? $compID : Auth::user()->company_id;
        $company = Company::FindOrFail($compID);
        $client_id = Auth::user()->id;

        $check = Cash::all();
        if ($check->isEmpty()) {
            $pre_cash = 1;
        } else {
            $old_cash = Cash::max('cash_number');
            $pre_cash = ++$old_cash;
        }

        # get stores, products, branches, units.
        $user = Client::FindOrFail($client_id);
        if (!empty($user->branch_id)) {
            $branch = Branch::FindOrFail($user->branch_id);
            $stores = $branch->stores;
            $all_products = Product::where('company_id', $compID)
                ->where(function ($query) use ($stores) {
                    $query->where('first_balance', '>', 0)
                        ->orWhereNull('first_balance')
                        ->whereIn('store_id', $stores)
                        ->orWhereNull('store_id');
                })->get();
        } else {
            $stores = $company->stores;
            $all_products = $company->products;
        }
        $units = $company->units;
        $extra_settings = ExtraSettings::where('company_id', $compID)->first();
        if (in_array('مدير النظام', Auth::user()->role_name)) {
            $outer_clients = OuterClient::where('company_id', $compID)->get();
        } else {
            $outer_clients = OuterClient::where('company_id', $compID)
                ->where('client_id', Auth::user()->id)
                ->orWhereNull('client_id')
                ->get();
        }
        $safes = $company->safes;
        $banks = $company->banks;


        $saleBill = SaleBill::where('token', $token)->where('company_id', $compID)->firstOrFail();
        $sale_bill_cash = Cash::where('bill_id', $saleBill->sale_bill_number)->get();
        $sale_bill_bank_cash = BankCash::where('bill_id', $saleBill->sale_bill_number)->get();
        return view(
            'client.sale_bills.edit',
            compact(
                'company',
                'sale_bill_cash',
                'units',
                'sale_bill_bank_cash',
                'saleBill',
                'stores',
                'safes',
                'banks',
                'outer_clients',
                'extra_settings',
                'all_products',
                'pre_cash'
            )
        );

    }

    /*
    public function filter_code(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $products = $company->products;
        $sale_bills = SaleBill::where('company_id', $company_id)->where('status', 'done')->get();
        if (in_array('مدير النظام', Auth::user()->role_name)) {
            $outer_clients = OuterClient::where('company_id', $company_id)->get();
        } else {
            $outer_clients = OuterClient::where('company_id', $company_id)
                ->where(function ($query) {
                    $query->where('client_id', Auth::user()->id)
                        ->orWhereNull('client_id');
                })->get();
        }
        $product_id = $request->code_universal;
        $product_k = Product::FindOrFail($product_id);
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;

        $sale_bill_elements = SaleBillElement::where('product_id', $product_k->id)->get();
        $arr = array();
        foreach ($sale_bill_elements as $sale_bill_element) {
            $sale_bill = $sale_bill_element->SaleBill;
            $sale_bill_id = $sale_bill->id;
            array_push($arr, $sale_bill_id);
        }
        $my_array = array_unique($arr);
        $product_sale_bills = SaleBill::whereIn('id', $my_array)->get();
        return view('client.sale_bills.index', compact('currency', 'product_k', 'products', 'product_sale_bills', 'sale_bills', 'outer_clients', 'company'));
    }

    public function filter_product(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $products = $company->products;
        $sale_bills = SaleBill::where('company_id', $company_id)->where('status', 'done')->get();
        if (in_array('مدير النظام', Auth::user()->role_name)) {
            $outer_clients = OuterClient::where('company_id', $company_id)->get();
        } else {
            $outer_clients = OuterClient::where('company_id', $company_id)
                ->where(function ($query) {
                    $query->where('client_id', Auth::user()->id)
                        ->orWhereNull('client_id');
                })->get();
        }
        $product_id = $request->product_name;
        $product_k = Product::FindOrFail($product_id);
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;

        $sale_bill_elements = SaleBillElement::where('product_id', $product_k->id)->get();
        $arr = array();
        foreach ($sale_bill_elements as $sale_bill_element) {
            $sale_bill = $sale_bill_element->SaleBill;
            $sale_bill_id = $sale_bill->id;
            array_push($arr, $sale_bill_id);
        }
        $my_array = array_unique($arr);
        $product_sale_bills = SaleBill::whereIn('id', $my_array)->get();
        return view('client.sale_bills.index', compact('currency', 'product_k', 'products', 'product_sale_bills', 'sale_bills', 'outer_clients', 'company'));
    }

    public function filter_all(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $products = $company->products;
        $sale_bills = SaleBill::where('company_id', $company_id)->where('status', 'done')->get();
        if (in_array('مدير النظام', Auth::user()->role_name)) {
            $outer_clients = OuterClient::where('company_id', $company_id)->get();
        } else {
            $outer_clients = OuterClient::where('company_id', $company_id)
                ->where(function ($query) {
                    $query->where('client_id', Auth::user()->id)
                        ->orWhereNull('client_id');
                })->get();
        }
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $all_sale_bills = SaleBill::where('company_id', $company_id)->where('status', 'done')->get();
        return view('client.sale_bills.index', compact('currency', 'products', 'all_sale_bills', 'sale_bills', 'outer_clients', 'company'));
    }

    public function filter_outer_client(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);

        $products = $company->products;
        $sale_bills = SaleBill::where('company_id', $company_id)->where('status', 'done')->get();
        if (in_array('مدير النظام', Auth::user()->role_name)) {
            $outer_clients = OuterClient::where('company_id', $company_id)->get();
        } else {
            $outer_clients = OuterClient::where('company_id', $company_id)
                ->where(function ($query) {
                    $query->where('client_id', Auth::user()->id)
                        ->orWhereNull('client_id');
                })->get();
        }
        $outer_client_id = $request->outer_client_id;
        $outer_client_k = OuterClient::FindOrFail($outer_client_id);
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;

        $outer_client_sale_bills = SaleBill::where('outer_client_id', $outer_client_k->id)->get();

        return view('client.sale_bills.index', compact('currency', 'products', 'outer_client_k', 'outer_client_sale_bills', 'sale_bills', 'outer_clients', 'company'));
    }

    public function filter_key(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);

        $products = $company->products;
        $sale_bills = SaleBill::where('company_id', $company_id)->where('status', 'done')->get();
        if (in_array('مدير النظام', Auth::user()->role_name)) {
            $outer_clients = OuterClient::where('company_id', $company_id)->get();
        } else {
            $outer_clients = OuterClient::where('company_id', $company_id)
                ->where(function ($query) {
                    $query->where('client_id', Auth::user()->id)
                        ->orWhereNull('client_id');
                })->get();
        }

        #getting formData.
        $sale_bill_id = $request->sale_bill_id;
        $sale_bill_number = $request->sale_bill_number;

        #getting currency from company settings.
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;

        #getting bill details.
        if (!empty($sale_bill_id)) {
            $sale_bill_k = SaleBill::where('id', $sale_bill_id)->where('company_id', $company_id)->first();
        } else {
            $sale_bill_k = SaleBill::where('sale_bill_number', $sale_bill_number)
                ->where('company_id', $company_id)->first();
        }

        if (!empty($sale_bill_k)) {
            $cash = Cash::where('bill_id', $sale_bill_k->sale_bill_number)
                ->where('company_id', $company_id)
                ->where('client_id', $sale_bill_k->client_id)
                ->where('outer_client_id', $sale_bill_k->outer_client_id)
                ->first();

            $elements = SaleBillElement::where('sale_bill_id', $sale_bill_id)
                ->where('company_id', $company_id)->get();

            $extras = $sale_bill_k->extras;
            foreach ($extras as $key) {
                if ($key->action == "discount") {
                    if ($key->action_type == "pound") {
                        $sale_bill_discount_value = $key->value;
                        $sale_bill_discount_type = "pound";
                    } elseif ($key->action_type == "percent") {
                        $sale_bill_discount_value = $key->value;
                        $sale_bill_discount_type = "percent";
                    } else {
                        $sale_bill_discount_value = $key->value;
                        $sale_bill_discount_type = "afterTax";
                    }
                } else {
                    if ($key->action_type == "pound") {
                        $sale_bill_extra_value = $key->value;
                        $sale_bill_extra_type = "pound";
                    } else {
                        $sale_bill_extra_value = $key->value;
                        $sale_bill_extra_type = "percent";
                    }
                }
            }
            if ($extras->isEmpty()) {
                $sale_bill_discount_value = 0;
                $sale_bill_extra_value = 0;
                $sale_bill_discount_type = "pound";
                $sale_bill_extra_type = "pound";
            }
            $tax_value_added = $company->tax_value_added;
            $sum = array();
            foreach ($elements as $element) {
                array_push($sum, $element->quantity_price);
            }
            $total = array_sum($sum);

            $previous_extra = SaleBillExtra::where('sale_bill_id', $sale_bill_k->id)
                ->where('action', 'extra')->first();
            if (!empty($previous_extra)) {
                $previous_extra_type = $previous_extra->action_type;
                $previous_extra_value = $previous_extra->value;
                if ($previous_extra_type == "percent") {
                    $previous_extra_value = $previous_extra_value / 100 * $total;
                }
                $after_discount = $total + $previous_extra_value;
            }


            $previous_discount = SaleBillExtra::where('sale_bill_id', $sale_bill_k->id)
                ->where('action', 'discount')->first();
            if (!empty($previous_discount)) {
                $previous_discount_type = $previous_discount->action_type;
                $previous_discount_value = $previous_discount->value;
                if ($previous_discount_type == "percent" || $previous_discount_type == "afterTax") {
                    $previous_discount_value = $previous_discount_value / 100 * $total;
                }
                $after_discount = $total - $previous_discount_value;
            }
            if (!empty($previous_extra) && !empty($previous_discount)) {
                $after_discount = $total - $previous_discount_value + $previous_extra_value;
            } else {
                $after_discount = $total;
            }

            if (isset($after_discount) && $after_discount != 0) {
                $percentage = ($tax_value_added / 100) * $after_discount;
                $after_total_all = $after_discount + $percentage;
            } else {
                $percentage = ($tax_value_added / 100) * $total;
                $after_total_all = $total + $percentage;
            }
            return view(
                'client.sale_bills.index',
                compact(
                    'currency',
                    'after_discount',
                    'after_total_all',
                    'sale_bill_k',
                    'sale_bills',
                    'outer_clients',
                    'elements',
                    'extras',
                    'products',
                    'cash',
                    'company',
                    'sale_bill_discount_value',
                    'sale_bill_discount_type',
                    'sale_bill_extra_value',
                    'sale_bill_extra_type'
                )
            );
        } else {
            return redirect()->route('client.sale_bills.index')->with('error', 'لا يوجد فاتورة بهذا الرقم');
        }
    }
    */

    public function get_product_price(Request $request)
    {
        $product_id = $request->product_id;
        $product = Product::FindOrFail($product_id);
        $wholesale_price = $product->wholesale_price;
        $sector_price = $product->sector_price;
        $first_balance = $product->first_balance;
        $unit_id = $product->unit_id;
        $category_type = $product->category->category_type;
        if ($category_type == "مخزونية") {
            $sale_bill = SaleBill::where('sale_bill_number', $request->sale_bill_number)->first();
            if (!empty($sale_bill)) {
                $company_id = $sale_bill->company_id;
                $elements = SaleBillElement::where('sale_bill_id', $sale_bill->id)
                    ->where('product_id', $product_id)
                    ->where('company_id', $company_id)
                    ->get();
                if (!$elements->isempty()) {
                    $sum = 0;
                    foreach ($elements as $element) {
                        $sum += $element->quantity;
                    }
                    $first_balance = $first_balance - $sum;
                }
            }
        }

        return response()->json([
            'wholesale_price' => $wholesale_price,
            'sector_price' => $sector_price,
            'first_balance' => $first_balance,
            'unit_id' => $unit_id,
        ]);
    }

    public function get_edit_product_price(Request $request)
    {
        $product_id = $request->product_id;
        $product = Product::FindOrFail($product_id);
        $first_balance = $product->first_balance;
        return response()->json([
            'first_balance' => $first_balance,
        ]);
    }

    public function get_outer_client_details(Request $request)
    {
        $outer_client_id = $request->outer_client_id;
        $outer_client = OuterClient::FindOrFail($outer_client_id);
        $category = $outer_client->client_category;
        $balance_before = $outer_client->prev_balance;
        $outer_client_national = $outer_client->client_national;
        if ($outer_client->phones->isEmpty()) {
            $client_phone = "";
        } else {
            $client_phone = $outer_client->phones[0]->client_phone;
        }
        if ($outer_client->addresses->isEmpty()) {
            $client_address = "";
        } else {
            $client_address = $outer_client->addresses[0]->client_address;
        }
        return response()->json([
            'category' => $category,
            'balance_before' => $balance_before,
            'client_national' => $outer_client_national,
            'tax_number' => $outer_client->tax_number,
            'shop_name' => $outer_client->shop_name,
            'client_phone' => $client_phone,
            'client_address' => $client_address,
        ]);
    }

    public function delete_element(Request $request)
    {
        $element_id = $request->element_id;
        $element = SaleBillElement::FindOrFail($element_id);
        $element->delete();
    }

    public function update_element(Request $request)
    {
        $element_id = $request->element_id;
        $element = SaleBillElement::FindOrFail($element_id);
        $element->update([
            'unit_id' => $request->unit_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'quantity_price' => $request->quantity_price,
            'product_price' => $request->product_price,
        ]);
    }

    #--------get elements of invoice--------#
    public function get_sale_bill_elements(Request $request)
    {
        # get companyData.
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);

        # get invoiceData.
        $sale_bill_number = $request->sale_bill_number;
        $sale_bill = SaleBill::where('company_id', $company_id)->where('sale_bill_number', $sale_bill_number)->first();
        $elements = SaleBillElement::where('company_id', $company_id)->where('sale_bill_id', $sale_bill->id)->get();
        $extras = SaleBillExtra::where('company_id', $company_id)->where('sale_bill_id', $sale_bill->id)->get();
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $tax_value_added = $company->tax_value_added;

        # calc total price of products.
        $sum = array();
        if (!$elements->isEmpty()) {
            echo '<h6 class="alert alert-sm alert-info text-center font-weight-bold">
                <i class="fa fa-info-circle"></i>
            بيانات عناصر الفاتورة
                (' . $sale_bill->company_counter . ')
            </h6>';
            $i = 0;
            echo "<table class='table table-condensed table-striped table-bordered'>";
            echo "<thead>";
            echo "<th>  # </th>";
            echo "<th> اسم المنتج </th>";
            echo "<th> سعر الوحدة </th>";
            echo "<th> الكمية </th>";
            echo "<th>  الاجمالى </th>";
            echo "<th class='no-print'>  تحكم </th>";
            echo "</thead>";
            echo "<tbody>";
            foreach ($elements as $element) {
                array_push($sum, $element->quantity_price);
                echo "<tr>";
                echo "<td>" . ++$i . "</td>";
                echo "<td>" . $element->product->product_name . "</td>";
                echo "<td>" . $element->product_price . "</td>";
                if (!empty($element->unit_id)) {
                    echo "<td>" . $element->quantity . " " . $element->unit->unit_name . "</td>";
                } else {
                    echo "<td>" . $element->quantity . "</td>";
                }
                echo "<td>" . $element->quantity_price . "</td>";
                echo "<td class='no-print'>
                    <button type='button' sale_bill_number='" . $element->SaleBill->sale_bill_number . "' element_id='" . $element->id . "' class='btn btn-sm btn-info edit_element'>
                                <i class='fa fa-pencil'></i> تعديل
                            </button>
                    <button type='button' sale_bill_number='" . $element->SaleBill->sale_bill_number . "' element_id='" . $element->id . "' class='btn btn-sm btn-danger remove_element'>
                        <i class='fa fa-trash'></i> حذف
                    </button>
                </td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            $total = array_sum($sum);
            $percentage = ($tax_value_added / 100) * $total;
            $after_total = $total + $percentage;
            $tax_option = $sale_bill->value_added_tax;
            if ($tax_option == 1) {
                $after_total = $total;
            } else { // exclusive
                $percentage = ($tax_value_added / 100) * $total;
                $after_total = $total + $percentage;
            }

            echo "
            <div class='clearfix'></div>
            <div class='alert alert-dark alert-sm text-center'>
                <div class='pull-right col-lg-6 '>
                     الاجمالى قبل الخصم والضريبة
                    " . round($total, 2) . " " . $currency . "
                </div>
                <div class='pull-left col-lg-6 '>
                    اجمالى الفاتورة بعد الخصم والضريبة
                    " . round($after_total, 2) . " " . $currency . "
                </div>
                <div class='clearfix'></div>
            </div>";
        }

        echo "
        <script>
            $('.remove_element').on('click',function(){
                let element_id = $(this).attr('element_id');
                let sale_bill_number = $(this).attr('sale_bill_number');

                let discount_type = $('#discount_type').val();
                let discount_value = $('#discount_value').val();

                let extra_type = $('#extra_type').val();
                let extra_value = $('#extra_value').val();

                $.post('/client/sale-bills/element/delete',{
                    '_token': '" . csrf_token() . "', element_id: element_id
                    },function (data) {
                    $.post('/client/sale-bills/elements',{
                        '_token': '" . csrf_token() . "',
                        sale_bill_number: sale_bill_number
                    },function (elements) {
                        $('.bill_details').html(elements);
                    });
                });

                $.post('/client/sale-bills/discount',{
                    '_token': '" . csrf_token() . "',
                    sale_bill_number:sale_bill_number,
                    discount_type: discount_type,
                    discount_value: discount_value
                },function (data) {
                    $('.after_totals').html(data);
                });

                $.post('/client/sale-bills/extra',{
                    '_token': '" . csrf_token() . "',
                    sale_bill_number:sale_bill_number,
                    extra_type: extra_type,
                    extra_value: extra_value
                },function (data) {
                    $('.after_totals').html(data);
                });
                $.post('/client/sale-bills/refresh',{
                    '_token': '" . csrf_token() . "',
                    sale_bill_number : sale_bill_number,
                },function (data) {
                    $('#final_total').val(data.final_total);
                });

                $(this).parent().parent().fadeOut(300);
            });

            $('.edit_element').on('click', function () {
            let element_id = $(this).attr('element_id');
            let sale_bill_number = $(this).attr('sale_bill_number');
            $.post('/client/sale-bills/edit-element',
                {
                    '_token': '" . csrf_token() . "',
                    sale_bill_number: sale_bill_number,
                    element_id: element_id
                },
                function (data) {
                    $('#product_id').val(data.product_id);
                    $('#product_id').selectpicker('refresh');
                    $('#product_price').val(data.product_price);
                    $('#unit_id').val(data.unit_id);
                    $('#quantity').val(data.quantity);
                    $('#quantity_price').val(data.quantity_price);
                    let product_id = data.product_id;
                    $.post('/client/sale-bills/get-edit', {
                        product_id: product_id,
                        sale_bill_number: sale_bill_number,
                        '_token': '" . csrf_token() . "'
                    }, function (data) {
                        $('input#quantity').attr('max', data.first_balance);
                        $('.available').html('الكمية المتاحة : ' + data.first_balance);
                    });
                    $('#add').hide();
                    $('#edit').show();
                    $('#edit').attr('element_id', element_id);
                    $('#edit').attr('sale_bill_number', sale_bill_number);
                });
            });
        </script>
        ";
    }

    #--------apply discount to the invoice--------#
    public function apply_discount(Request $request)
    {
        # company data.
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);

        # get formData.
        $sale_bill_number = $request->sale_bill_number;
        $discount_type = $request->discount_type; //after_tax
        $discount_value = $request->discount_value; //10
        $discount_note = $request->discount_note; //10

        # get invoiceData.
        $sale_bill = SaleBill::where('sale_bill_number', $sale_bill_number)->first();
        $elements = SaleBillElement::where('sale_bill_id', $sale_bill->id)->get();
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $tax_value_added = $company->tax_value_added; //15%

        $sum = array();
        if (!$elements->isEmpty()) {
            # get sum of products.
            foreach ($elements as $element) {
                array_push($sum, $element->quantity_price);
            }
            $total = array_sum($sum);

            # calc discount value.
            $previous_extra = SaleBillExtra::where('sale_bill_id', $sale_bill->id)
                ->where('action', 'extra')
                ->first();
            if (!empty($previous_extra)) {
                $previous_extra_type = $previous_extra->action_type;
                $previous_extra_value = $previous_extra->value; //0
                if ($previous_extra_type == "percent") {
                    $previous_extra_value = $previous_extra_value / 100 * $total;
                }
            }

            # check if discount is on pounds or % percent.
            if ($discount_type == "pound") {
                if (isset($previous_extra_value) && $previous_extra_value != 0) {
                    $after_discount = $total - $discount_value + $previous_extra_value;
                } else {
                    $after_discount = $total - $discount_value;
                }
            } else if ($discount_type == "percent") {
                $value = $discount_value / 100 * $total;
                if (isset($previous_extra_value) && $previous_extra_value != 0) {
                    $after_discount = $total - $value + $previous_extra_value;
                } else {
                    $after_discount = $total - $value;
                }
            } else if ($discount_type == "afterTax") {
                $value = $discount_value / 100 * $total; // 10 / 100*100
                if (isset($previous_extra_value) && $previous_extra_value != 0) {
                    $after_discount = $total - $value + $tax_value_added;
                } else {
                    $after_discount = $total - $value;
                }
            }


            # calc final_total and tax
            $tax_option = $sale_bill->value_added_tax;
            if (isset($after_discount) && $after_discount != 0) {
                # calc final_total with inserted tax if inclusive or exclusive.
                if ($tax_option == 0) { #exclusive
                    $percentage = ($tax_value_added / 100) * $after_discount;
                    $after_total = $after_discount + $percentage;
                } else # so its inclusive
                    $after_total = $after_discount;

            } else {
                # calc final_total with inserted tax if inclusive or exclusive.
                if ($tax_option == 0) { #exclusive
                    $percentage = ($tax_value_added / 100) * $total;
                    $after_total = $total + $percentage;
                } else # so its inclusive
                    $after_total = $total;
            }
            if ($discount_type == "poundAfterTax") {
                $after_total = $after_total - $discount_value;
            } elseif ($discount_type == "poundAfterTaxPercent") {
                $after_total = $after_total - (($total * $discount_value) / 100);
            }
            echo "
            <div class='clearfix'></div>";
            $sale_bill_extra = SaleBillExtra::where('sale_bill_id', $sale_bill->id)
                ->where('action', 'discount')->first();
            if (empty($sale_bill_extra)) {
                $sale_bill_extra = SaleBillExtra::create([
                    'sale_bill_id' => $sale_bill->id,
                    'action' => 'discount',
                    'action_type' => $discount_type,
                    'value' => $discount_value,
                    'company_id' => $company_id,
                    'discount_note' => $discount_note,
                ]);
            } else {
                $sale_bill_extra->update([
                    'action_type' => $discount_type,
                    'value' => $discount_value,
                    'discount_note' => $discount_note,
                ]);
            }

            $sale_bill->update(['final_total' => $after_total]);
        }
    }

    #--------apply shipping to the invoice--------#
    public function apply_extra(Request $request)
    {
        # company data.
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);

        # get formData.
        $sale_bill_number = $request->sale_bill_number;
        $extra_type = $request->extra_type;
        $extra_value = $request->extra_value;

        # get invoiceData.
        $sale_bill = SaleBill::where('sale_bill_number', $sale_bill_number)->first();
        $elements = SaleBillElement::where('sale_bill_id', $sale_bill->id)->get();
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $tax_value_added = $company->tax_value_added;

        # calc total price of products.
        $sum = array();
        if (!$elements->isEmpty()) {
            # get sum of products.
            foreach ($elements as $element) {
                array_push($sum, $element->quantity_price);
            }
            $total = array_sum($sum);

            # calc discount value.
            $previous_discount = SaleBillExtra::where('sale_bill_id', $sale_bill->id)
                ->where('action', 'discount')->first();
            if (!empty($previous_discount)) {
                $previous_discount_type = $previous_discount->action_type;
                $previous_discount_value = $previous_discount->value;
                if ($previous_discount_type == "percent") {
                    $previous_discount_value = $previous_discount_value / 100 * $total;
                }
            }

            # check if discount is on pounds or % percent.
            if ($extra_type == "pound") {
                if (isset($previous_discount_value) && $previous_discount_value != 0) {
                    $after_extra = $total + $extra_value - $previous_discount_value;
                } else {
                    $after_extra = $total + $extra_value;
                }
            } else if ($extra_type == "percent") {
                $value = $extra_value / 100 * $total;
                if (isset($previous_discount_value) && $previous_discount_value != 0) {
                    $after_extra = $total + $value - $previous_discount_value;
                } else {
                    $after_extra = $total + $value;
                }
            }


            # calc final_total with tax if inclusive or exclusive
            $tax_option = $sale_bill->value_added_tax;
            if (isset($after_extra) && $after_extra != 0) {
                # calc final_total with inserted tax if inclusive or exclusive.
                if ($tax_option == 0) { #exclusive
                    $percentage = ($tax_value_added / 100) * $after_extra;
                    $after_total = $after_extra + $percentage;
                } else # so its inclusive
                    $after_total = $after_extra;
            } else {
                # calc final_total with inserted tax if inclusive or exclusive.
                if ($tax_option == 0) { #exclusive
                    $percentage = ($tax_value_added / 100) * $total;
                    $after_total = $total + $percentage;
                } else # so its inclusive
                    $after_total = $total;
            }

            echo "
            <div class='clearfix'></div>
            ";
            $sale_bill_extra = SaleBillExtra::where('sale_bill_id', $sale_bill->id)
                ->where('action', 'extra')->first();
            if (empty($sale_bill_extra)) {
                $sale_bill_extra = SaleBillExtra::create([
                    'sale_bill_id' => $sale_bill->id,
                    'action' => 'extra',
                    'action_type' => $extra_type,
                    'value' => $extra_value,
                    'company_id' => $company_id,
                ]);
            } else {
                $sale_bill_extra->update([
                    'action_type' => $extra_type,
                    'value' => $extra_value,
                ]);
            }
        }
    }

    public function refresh(Request $request)
    {
        # get companyData.
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);

        # get invoiceData -> elements and tax.
        $sale_bill_number = $request->sale_bill_number;
        $sale_bill = SaleBill::where('sale_bill_number', $sale_bill_number)->first();
        $elements = \App\Models\SaleBillElement::where('sale_bill_id', $sale_bill->id)
            ->where('company_id', $sale_bill->company_id)
            ->get();
        $tax_value_added = $company->tax_value_added;

        # calc sum of products which is the price of the invoice.
        $sum = array();
        foreach ($elements as $element) {
            array_push($sum, $element->quantity_price);
        }
        $total = array_sum($sum);

        #get extra which is shipping here.
        $previous_extra = SaleBillExtra::where('sale_bill_id', $sale_bill->id)
            ->where('action', 'extra')->first();
        if (!empty($previous_extra)) {
            $previous_extra_type = $previous_extra->action_type;
            $previous_extra_value = $previous_extra->value;
            if ($previous_extra_type == "percent") {
                $previous_extra_value = $previous_extra_value / 100 * $total;
            }
            $after_discount = $total + $previous_extra_value;
        }

        #get extra which is discount here.
        $previous_discount = SaleBillExtra::where('sale_bill_id', $sale_bill->id)
            ->where('action', 'discount')->first();
        if (!empty($previous_discount)) {
            $previous_discount_type = $previous_discount->action_type;
            $previous_discount_value = $previous_discount->value;
            if ($previous_discount_type == "percent") {
                $previous_discount_value = $previous_discount_value / 100 * $total;
            }
            $after_discount = $total - $previous_discount_value;
        }

        # calc final_total if there is discount and shipping.
        if (!empty($previous_extra) && !empty($previous_discount))
            $after_discount = $total - $previous_discount_value + $previous_extra_value;
        else
            $after_discount = $total;

        # calc final_total with tax if inclusive or exclusive
        $tax_option = $sale_bill->value_added_tax;
        if (isset($after_extra) && $after_extra != 0) {
            # calc final_total with inserted tax if inclusive or exclusive.
            if ($tax_option == 0) { #exclusive
                $percentage = ($tax_value_added / 100) * $after_discount;
                $after_total_all = $after_discount + $percentage;
            } else # so its inclusive
                $after_total_all = $after_discount;
        } else {
            # calc final_total with inserted tax if inclusive or exclusive.
            if ($tax_option == 0) { #exclusive
                $percentage = ($tax_value_added / 100) * $total;
                $after_total_all = $total + $percentage;
            } else # so its inclusive
                $after_total_all = $total;
        }

        if ($previous_discount_type == "poundAfterTax") {
            $after_total_all = $after_total_all - $previous_discount->value;
        } elseif ($previous_discount_type == "poundAfterTaxPercent") {
            $after_total_all = $after_total_all - (($total * $previous_discount->value) / 100);
        }

        $sale_bill->update([
            'final_total' => $after_total_all
        ]);
        return response()->json([
            'final_total' => $after_total_all,
        ]);
    }

    public function updateData(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $sale_bill_number = $request->sale_bill_number;
        $sale_bill = SaleBill::where('sale_bill_number', $sale_bill_number)->first();
        $elements = SaleBillElement::where('sale_bill_id', $sale_bill->id)->get();
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $tax_value_added = $company->tax_value_added;
        $sum = array();
        foreach ($elements as $element) {
            array_push($sum, $element->quantity_price);
        }
        $total = array_sum($sum);
        $percentage = ($tax_value_added / 100) * $total;
        $after_total = $total + $percentage;
        $tax_option = $sale_bill->value_added_tax;
        if ($tax_option == 1) {
            $total = $total * (100 / 115);
            $total_with_option = $total;
            $percentage = (15 / 100) * $total_with_option;
            $after_total = $percentage + $total_with_option;
        }
        echo "
            <div class='pull-right col-lg-6 '>
            الاجمالى قبل الخصم والضريبة
            " . $total . " " . $currency . "
            </div>
            <div class='pull-left col-lg-6 '>
            اجمالى الفاتورة بعد الخصم والضريبة
            " . $after_total . " " . $currency . "
            </div>
            <div class='clearfix'></div>";
    }

    # return product #
    public function get_return(Request $request)
    {
        $sale_bill = SaleBill::FindOrFail($request->sale_bill_id);
        $element = SaleBillElement::FindOrFail($request->element_id);
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        if (in_array('مدير النظام', Auth::user()->role_name)) {
            $outer_clients = OuterClient::where('company_id', $company_id)->get();
        } else {
            $outer_clients = OuterClient::where('company_id', $company_id)
                ->where(function ($query) {
                    $query->where('client_id', Auth::user()->id)
                        ->orWhereNull('client_id');
                })->get();
        }
        $products = $company->products;
        return view('client.sale_bills.return', compact('company', 'sale_bill', 'element', 'products', 'company_id', 'outer_clients'));
    }

    public function print_return($id)
    {
        $sale_bill_return = SaleBillReturn::where('id', $id)->with([
            'bill',
            'company',
            'client',
            'outerClient',
            'product',
        ])->first();
        $company_id = Auth::user()->company_id;
        if ($sale_bill_return !== null) {
            if ($sale_bill_return->company_id == $company_id) {
                return view('client.sale_bills.print_return', compact('sale_bill_return'));
            } else {
                return abort('404');
            }
        } else {
            return abort('404');
        }
    }

    public function print_returnAll($bill_id)
    {
        $itemsInSaleBillReturn = SaleBillReturn::where('bill_id', $bill_id)->with([
            'bill',
            'company',
            'client',
            'outerClient',
            'product',
        ])->get();

        $saleBill = SaleBill::find($itemsInSaleBillReturn[0]->bill_id);
        $taxOption = $saleBill->value_added_tax;
        $company_id = Auth::user()->company_id;
        if ($itemsInSaleBillReturn && !empty($itemsInSaleBillReturn)) {
            return view('client.sale_bills.print_return', compact('itemsInSaleBillReturn', 'taxOption'));
        } else {
            return abort('404');
        }
    }

    public function post_return(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $data = $request->all();
        $data['company_id'] = $company_id;
        $data['client_id'] = Auth::user()->id;
        $return = SaleBillReturn::create($data);
        $element = SaleBillElement::FindOrFail($request->element_id);
        $product = Product::FindOrFail($request->product_id);
        $category_type = $product->category->category_type;
        if ($category_type == "مخزونية") {
            $product->update([
                'first_balance' => $request->after_return
            ]);
        }
        $sale_bill = $element->SaleBill;
        if (!empty($sale_bill->outer_client_id)) {
            $outer_client = OuterClient::FindOrFail($request->outer_client_id);
            $outer_client->update([
                'prev_balance' => $request->balance_after
            ]);
        }

        $quantity_before_return = $element->quantity;
        $product_price_before_return = $element->product_price;

        $quantity_after_return = $quantity_before_return - $request->return_quantity;
        $product_price_after_return = $quantity_after_return * $product_price_before_return;
        if ($quantity_after_return == 0 || $product_price_after_return == 0) {
            $element->delete();
        } else {
            $element->update([
                'quantity' => $quantity_after_return,
                'quantity_price' => $product_price_after_return,
            ]);
        }

        $elements = \App\Models\SaleBillElement::where('sale_bill_id', $sale_bill->id)
            ->where('company_id', $sale_bill->company_id)
            ->get();
        $tax_value_added = $company->tax_value_added;
        $sum = array();
        foreach ($elements as $element) {
            array_push($sum, $element->quantity_price);
        }
        $total = array_sum($sum);
        $previous_extra = SaleBillExtra::where('sale_bill_id', $sale_bill->id)
            ->where('action', 'extra')->first();
        if (!empty($previous_extra)) {
            $previous_extra_type = $previous_extra->action_type;
            $previous_extra_value = $previous_extra->value;
            if ($previous_extra_type == "percent") {
                $previous_extra_value = $previous_extra_value / 100 * $total;
            }
            $after_discount = $total + $previous_extra_value;
        }
        $previous_discount = SaleBillExtra::where('sale_bill_id', $sale_bill->id)
            ->where('action', 'discount')->first();
        if (!empty($previous_discount)) {
            $previous_discount_type = $previous_discount->action_type;
            $previous_discount_value = $previous_discount->value;
            if ($previous_discount_type == "percent") {
                $previous_discount_value = $previous_discount_value / 100 * $total;
            }
            $after_discount = $total - $previous_discount_value;
        }
        if (!empty($previous_extra) && !empty($previous_discount)) {
            $after_discount = $total - $previous_discount_value + $previous_extra_value;
        } else {
            $after_discount = $total;
        }
        if (isset($after_discount) && $after_discount != 0) {
            $percentage = ($tax_value_added / 100) * $after_discount;
            $after_total_all = $after_discount + $percentage;
        } else {
            $percentage = ($tax_value_added / 100) * $total;
            $after_total_all = $total + $percentage;
        }
        $sale_bill->update([
            'final_total' => $after_total_all
        ]);
        return redirect()->route('client.sale_bills.returns');
    }

    public function post_returnAll(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $data = $request->all();
        $data['company_id'] = $company_id;
        $data['client_id'] = Auth::user()->id;
        $data['bill_id'] = $request->sale_bill_id;
        $invoice = SaleBill::findOrFail($data['bill_id']);
        $items = \App\Models\SaleBillElement::where('sale_bill_id', $invoice->id)
            ->where('company_id', $invoice->company_id)
            ->get();

        $clientData = OuterClient::where("id", $invoice->outer_client_id)->first();
        foreach ($items as $product) {
            $data['return_quantity'] = $product->quantity;
            $data['quantity_price'] = $product->product_price * $product->quantity;
            $data['product_price'] = $product->product_price;
            $data['product_id'] = $product->product->id;
            $data['outer_client_id'] = $clientData->id;
            $data['balance_before'] = $clientData->prev_balance;
            $data['balance_after'] = $clientData->prev_balance - $data['quantity_price'];
            $data['before_return'] = $product->product->first_balance;
            $data['after_return'] = $product->product->first_balance - $data['return_quantity'];
            $data['date'] = date("Y-m-d");
            $data['time'] = date("h:i:s");
            $category_type = $product->product->category->category_type;
            if ($category_type == "مخزونية") {
                $product->product->update([
                    'first_balance' => $data['balance_after']
                ]);
            }
            unset($data['sale_bill_id'], $data['_token']);
            SaleBillReturn::create($data);
        }
        $tax_value_added = $company->tax_value_added;
        $sum = array();
        foreach ($items as $element) {
            array_push($sum, $element->quantity_price);
        }
        $total = array_sum($sum);
        $previous_extra = SaleBillExtra::where('sale_bill_id', $data['bill_id'])
            ->where('action', 'extra')->first();
        if (!empty($previous_extra)) {
            $previous_extra_type = $previous_extra->action_type;
            $previous_extra_value = $previous_extra->value;
            if ($previous_extra_type == "percent") {
                $previous_extra_value = $previous_extra_value / 100 * $total;
            }
            $after_discount = $total + $previous_extra_value;
        }
        $previous_discount = SaleBillExtra::where('sale_bill_id', $data['bill_id'])
            ->where('action', 'discount')->first();
        if (!empty($previous_discount)) {
            $previous_discount_type = $previous_discount->action_type;
            $previous_discount_value = $previous_discount->value;
            if ($previous_discount_type == "percent") {
                $previous_discount_value = $previous_discount_value / 100 * $total;
            }
            $after_discount = $total - $previous_discount_value;
        }
        if (!empty($previous_extra) && !empty($previous_discount)) {
            $after_discount = $total - $previous_discount_value + $previous_extra_value;
        } else {
            $after_discount = $total;
        }
        if (isset($after_discount) && $after_discount != 0) {
            $percentage = ($tax_value_added / 100) * $after_discount;
            $after_total_all = $after_discount + $percentage;
        } else {
            $percentage = ($tax_value_added / 100) * $total;
            $after_total_all = $total + $percentage;
        }
        $invoice->update([
            'final_total' => $after_total_all
        ]);
        return redirect()->route('client.sale_bills.returns');
    }

    public function get_returns()
    {
        $billIDS = DB::table('sale_bill_return')
            ->select('bill_id')
            ->groupBy('bill_id')
            ->where('company_id', Auth::user()->company_id)
            ->get();

        $returnSaleInvoices = [];
        foreach ($billIDS as $invID) {
            $invoices = SaleBillReturn::where("bill_id", $invID->bill_id)->get();
            foreach ($invoices as $bill_return) {
                $saleBill = SaleBill::find($bill_return->bill_id);
                $bill_return->setAttribute('value_added_tax', $saleBill->value_added_tax);
            }
            array_push($returnSaleInvoices, $invoices);
        }

        return view('client.sale_bills.returns', compact('returnSaleInvoices'));
    }

    public function redirect()
    {
        return redirect()->route('client.sale_bills.create')->with('success', 'تم انشاء فاتورة مبيعات بنجاح');
    }

    public function get_products(Request $request)
    {
        $store_id = $request->store_id;
        $products = Product::where('store_id', $store_id)->get();
        foreach ($products as $product) {
            echo "<option value='" . $product->id . "'>" . $product->product_name . "</option>";
        }
    }

    public function print($hashtoken, $invoiceType = 1, $printColor = null, $isMoswada = null)
    {
        // dd($invoiceType);
        $sale_bill = SaleBill::where('token', $hashtoken)->first();
        if (!empty($sale_bill)) {
            $elements = SaleBillElement::where('sale_bill_id', $sale_bill->id)
                ->where('company_id', $sale_bill->company_id)
                ->get();

            if ($elements->isEmpty()) {
                return abort('404');
            } else {
                #--main data of invoice--#
                $company = Company::FindOrFail($sale_bill->company_id);
                $extra_settings = ExtraSettings::where('company_id', $company->id)->first();
                $currency = $extra_settings->currency;

                #--owner data--#
                $client_id = $sale_bill->client_id;
                $client = Client::FindOrFail($client_id);
                $branch = $client->branch;
                if ($branch) {
                    $pageData['branch_address'] = $branch->branch_address;
                    $pageData['branch_phone'] = $branch->branch_phone;
                } else {
                    $pageData['branch_address'] = $company->company_address;
                    $pageData['branch_phone'] = $company->phone_number;
                }
                $owner = Client::where('company_id', $company->id)->first();
                if ($owner && !empty($owner))
                    $pageData['ownerEmail'] = $owner->email;
                else
                    $pageData['ownerEmail'] = 'غير مسجل';

                #--client data--#
                $clientData = OuterClient::findOrFail($sale_bill->outer_client_id);
                $pageData['clientName'] = $clientData->client_name;
                $pageData['clientAddress'] = OuterClientAddress::where('outer_client_id', $sale_bill->outer_client_id)->first();
                if ($pageData['clientAddress'] && !empty($pageData['clientAddress']))
                    $pageData['clientAddress'] = $pageData['clientAddress']->client_address;
                else
                    $pageData['clientAddress'] = 'غير مسجل';

                $total = [];
                foreach ($elements as $element) {
                    array_push($total, $element->quantity_price);
                }
                $realtotal = array_sum($total);
                $total = $realtotal;

                # chk for discount #
                $shipping = \App\Models\SaleBillExtra::where('sale_bill_id', $sale_bill->id)->where('company_id', $sale_bill->company_id)->where('action', 'extra')->first();
                $discount = \App\Models\SaleBillExtra::where('sale_bill_id', $sale_bill->id)->where('company_id', $sale_bill->company_id)->where('action', 'discount')->first();
                $discountNote = $discount->discount_note ?? '';
                $tax_value_added = $company->tax_value_added; //15%
                # calc shipping
                if (!empty($shipping)) {
                    $shippingType = $shipping->action_type;
                    $shippingValue = $shipping->value;
                    if ($shippingType == "percent") {
                        $shippingValue = $shippingValue / 100 * $total;
                    }
                }
                if (!isset($discount->action_type)) {
                    $discount->action_type = '';
                }

                # check if discount is on pounds or % percent.
                if ($discount->action_type == "pound") {
                    $discountValue = $discount->value;
                    if (isset($shippingValue) && $shippingValue != 0) {
                        $after_discount = $total - $discount->value + $shippingValue;
                    } else {
                        $after_discount = $total - $discount->value;
                    }
                } else if ($discount->action_type == "percent") {
                    $discountValue = $discount->value / 100 * $total;
                    if (isset($shippingValue) && $shippingValue != 0) {
                        $after_discount = $total - $discountValue + $shippingValue;
                    } else {
                        $after_discount = $total - $discountValue;
                    }
                } else if ($discount->action_type == "afterTax") {
                    $discountValue = $discount->value / 100 * $total; // 10 / 100*100
                    if (isset($shippingValue) && $shippingValue != 0) {
                        $after_discount = $total - $discountValue + $tax_value_added;
                    } else {
                        $after_discount = $total - $discountValue;
                    }
                } else {
                    if ($discount->action_type == "poundAfterTaxPercent") {
                        $discountValue = (($discount->value * $total) / 100);
                        $after_discount = $total - $discountValue;
                    } else {
                        $discountValue = $discount->value;
                        $after_discount = $total - $discountValue;
                    }
                }
                $total = $after_discount;
                # ---------------- #
                if ($discount->action_type == "poundAfterTax" || $discount->action_type == "poundAfterTaxPercent") {
                    $sumWithOutTax = $sale_bill->value_added_tax ? round($total * 20 / 23, 2) : round($total, 2);
                    $sumWithTax = $sale_bill->value_added_tax ? $total : round($total + $realtotal * 15 / 100, 2);
                    $totalTax = round($sumWithTax - $sumWithOutTax, 2);
                } else {
                    $sumWithOutTax = $sale_bill->value_added_tax ? round($total * 20 / 23, 2) : round($total, 2);
                    $sumWithTax = $sale_bill->value_added_tax ? $total : round($total + $total * 15 / 100, 2);
                    $totalTax = round($sumWithTax - $sumWithOutTax, 2);
                }

                #Artisan::call('cache:clear');
                # ============= get paid and rest amount ============ #
                if (!empty($printColor)) {
                    $printColor = $printColor == 1 ? "#085d4a" : "#666EE8";
                } else {
                    $printColor = "#666EE8";
                }
                if ($invoiceType == 1) {
                    $printColor = '#222751';
                    return view(
                        'client.sale_bills.main',
                        compact('isMoswada', 'discountNote', 'printColor', 'sale_bill', 'elements', 'company', 'currency', 'pageData', 'sumWithTax', 'sumWithOutTax', 'totalTax','realtotal', 'discountValue')
                    );
                } elseif ($invoiceType == 4) {
                    $printColor = '#222751';
                    return view(
                        'client.sale_bills.print4',
                        compact('isMoswada', 'discountNote', 'printColor', 'sale_bill', 'elements', 'company', 'currency', 'pageData', 'sumWithTax', 'sumWithOutTax', 'totalTax', 'realtotal', 'discountValue')
                    );
                }
                 elseif ($invoiceType == 3) {
                    return view(
                        'client.sale_bills.no_tax_print',
                        compact('isMoswada', 'discountNote', 'printColor', 'sale_bill', 'elements', 'company', 'currency', 'pageData', 'sumWithTax', 'sumWithOutTax', 'totalTax','realtotal', 'discountValue')
                    );
                } else {
                    return view(
                        'client.sale_bills.nPrint3',
                        compact('isMoswada', 'discountNote', 'printColor', 'sale_bill', 'elements', 'company', 'currency', 'pageData', 'sumWithTax', 'sumWithOutTax', 'totalTax','realtotal', 'discountValue')
                    );
                }
            }
        } else {
            return abort('404');
        }
    }

    public function save_notes(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $client_id = Auth::user()->id;
        $data = $request->all();
        $sale_bill = SaleBill::where('company_id', $company_id)
            ->where('client_id', $client_id)
            ->where('status', 'open')
            ->first();
        $sale_bill_id = $sale_bill->id;

        $old_notes = SaleBillNote::where('company_id', $company_id)
            ->where('sale_bill_id', $sale_bill_id)
            ->get();

        if (!$old_notes->isEmpty()) {
            foreach ($old_notes as $old_note) {
                $old_note->delete();
            }
        }

        foreach ($request->notes as $note) {
            if (!empty($note)) {
                $note = SaleBillNote::create([
                    'company_id' => $company_id,
                    'sale_bill_id' => $sale_bill_id,
                    'notes' => $note,
                ]);
            }
        }
        return redirect()->route('client.sale_bills.create');
    }

    public function updateStatusOnEdit(Request $request)
    {
        SaleBill::where('token', $request->token)->update(['status' => 'done']);
    }

    public function updateInvTaxValue(Request $request)
    {
        if (SaleBill::where("token", $request->token)
            ->firstOrFail()
            ->update(['value_added_tax' => $request->value_added_tax]))
            return 1;
        else
            return 0;
    }

    public function copy_product(Request $request)
    {
        $order = SaleBill::where('id', $request->sale_bill_id)->first();
        $newOrder = $order->replicate(); // نسخ الطلب السابق
        $newOrder->save(); // حفظ الطلب الجديد
        return redirect()->route('client.sale_bills.index');
    }

    public function updateInovicePolices()
    {
        $policies = BasicSettings::where('company_id', Auth::user()->company_id)->firstOrFail();
        return view('client.sale_bills.policies', compact('policies'));
    }

    public function updateConditions(Request $request)
    {
        return BasicSettings::where('company_id', Auth::user()->company_id)->firstOrFail()->update(['sale_bill_condition' => $request->condition]) ? 1 : 0;
    }
}
