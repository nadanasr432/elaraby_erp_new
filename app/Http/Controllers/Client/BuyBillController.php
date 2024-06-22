<?php

namespace App\Http\Controllers\Client;

use App\Models\Bank;
use App\Models\Cash;
use App\Models\Safe;
use App\Models\BuyBill;
use App\Models\BuyCash;
use App\Models\Company;
use App\Models\Product;
use App\Models\BankCash;
use App\Models\Supplier;
use App\Models\BankBuyCash;
use App\Mail\sendingBuyBill;

use App\Models\BuyBillExtra;
use Illuminate\Http\Request;
use App\Models\BuyBillReturn;
use App\Models\ExtraSettings;
use App\Models\BuyBillElement;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\CashPaymentRequest;

class BuyBillController extends Controller
{
    public function index()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $buy_bills = BuyBill::where('company_id', $company_id)->where('status', 'done')->get();

        $suppliers = $company->suppliers;
        $products = $company->products;
        return view('client.buy_bills.index', compact('company', 'products', 'company_id', 'suppliers', 'buy_bills'));
    }

    public function create()
    {
        # get companyData.
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $client_id = Auth::user()->id;

        # set formData to pass to view.
        $categories = $company->categories;
        $all_products = $company->products;
        $stores = $company->stores;
        $units = $company->units;
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $suppliers = Supplier::where('company_id', $company_id)->get();

        //bills..
        $pre_bill = $company_id . time(); //this is the unique id for buy bills...
        $countBills = BuyBill::where('company_id', $company_id)->count();
        $countBills += 1;
        $pre_cash = $company_id . time(); //this is the unique id for buy bills...
        $countCashs = BuyBill::where('company_id', $company_id)->count();

        $safes = $company->safes;
        $banks = $company->banks;
        $user = Auth::user();
        $type_name = $user->company->subscription->type->type_name;
        if ($type_name == "تجربة") {
            $bills_count = "غير محدود";
        } else {
            $bills_count = $user->company->subscription->type->package->bills_count;
        }
        $company_bills_count = $company->buy_bills->count();
        if ($bills_count == "غير محدود") {
            $step = BuyBill::where('company_id', $company_id)
                ->where('client_id', $client_id)
                ->where('status', 'open')
                ->first();

            if (!empty($step)) {
                $open_buy_bill = $step;
                $buy_bill_cash = BuyCash::where('bill_id', $step->buy_bill_number)->get();
                $buy_bill_bank_cash = BankBuyCash::where('bill_id', $step->buy_bill_number)->get();
                return view('client.buy_bills.create', compact('company', 'buy_bill_cash',
                    'units', 'buy_bill_bank_cash', 'open_buy_bill', 'pre_cash', 'stores',
                    'safes', 'banks', 'suppliers', 'categories', 'extra_settings', 'company_id',
                    'all_products', 'pre_bill', 'countBills', 'countCashs'));
            } else {
                $open_buy_bill = "";
                return view('client.buy_bills.create', compact('company',
                    'open_buy_bill', 'units', 'pre_cash', 'stores', 'safes',
                    'banks', 'suppliers', 'categories', 'extra_settings', 'company_id',
                    'all_products', 'pre_bill', 'countBills', 'countCashs'));

            }
        } else {
            if ($bills_count > $company_bills_count) {
                $step = BuyBill::where('company_id', $company_id)
                    ->where('client_id', $client_id)
                    ->where('status', 'open')
                    ->first();
                if (!empty($step)) {
                    $open_buy_bill = $step;
                    $buy_bill_cash = BuyCash::where('bill_id', $step->buy_bill_number)
                        ->get();
                    $buy_bill_bank_cash = BankBuyCash::where('bill_id', $step->buy_bill_number)
                        ->get();
                    return view('client.buy_bills.create',
                        compact('company', 'buy_bill_cash', 'units', 'buy_bill_bank_cash', 'open_buy_bill', 'pre_cash', 'stores', 'safes', 'banks', 'suppliers', 'categories', 'extra_settings'
                            , 'company_id', 'all_products', 'pre_bill'));
                } else {
                    $open_buy_bill = "";
                    return view('client.buy_bills.create',
                        compact('company', 'open_buy_bill', 'units', 'pre_cash', 'stores', 'safes', 'banks', 'suppliers', 'categories', 'extra_settings'
                            , 'company_id', 'all_products', 'pre_bill'));

                }
            } else {
                return redirect()->route('client.home')->with('error', 'باقتك الحالية لا تسمح بالمزيد من فواتير الشراء');
            }
        }
    }

    public function store_cash_suppliers(CashPaymentRequest $request)
    {
        $data = $request->all();
        $company_id = $data['company_id'];
        $data['client_id'] = Auth::user()->id;
        $supplier_id = $data['supplier_id'];
        $amount = $data['amount'];
        $supplier = Supplier::FindOrFail($supplier_id);
        $balance_before = $supplier->prev_balance;
        $balance_after = $balance_before - $amount;
        $data['balance_before'] = $balance_before;
        $data['balance_after'] = $balance_after;
        $payment_method = $data['payment_method'];
        if ($payment_method == "cash") {
            $check = BuyCash::where('bill_id', $request->bill_id)
                ->where('company_id', $company_id)
                ->where('client_id', $data['client_id'])
                ->where('supplier_id', $supplier_id)
                ->first();
            if (empty($check)) {
                $cash = BuyCash::create($data);
            } else {
                return response()->json([
                    'status' => true,
                    'msg' => 'غير مسموح لك .. تم الدفع من قبل'
                ]);
            }
        } else {
            $check = BankBuyCash::where('bill_id', $request->bill_id)
                ->where('company_id', $company_id)
                ->where('client_id', $data['client_id'])
                ->where('supplier_id', $supplier_id)
                ->first();
            if (empty($check)) {
                $cash = BankBuyCash::create($data);
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

    public function pay_delete(Request $request)
    {
        $payment_method = $request->payment_method;
        $cash_id = $request->cash_id;
        if ($payment_method == "cash") {
            $cash = BuyCash::FindOrFail($cash_id);
            $cash->delete();
        } elseif ($payment_method == "bank") {
            $cash = BankBuyCash::FindOrFail($cash_id);
            $cash->delete();
        }
    }


    #--------on adding new product to buy_invoice--------#
    public function save(Request $request)
    {
        # get formData.
        $data = $request->all();

        # get companyData.
        $data['company_id'] = Auth::user()->company_id;
        $company = Company::FindOrFail($data['company_id']);
        $data['client_id'] = Auth::user()->id;
        $data['status'] = 'open';

        # chk to create or to update invoice.
        $BuyBill = BuyBill::where('buy_bill_number', $data['buy_bill_number'])->first();
        if (empty($BuyBill)) $BuyBill = BuyBill::create($data);
        else $BuyBill->update($data);

        $data['buy_bill_id'] = $BuyBill->id;
        $data['company_id'] = $company->id;

        # chk to create elements or to update.
        $check = BuyBillElement::where('buy_bill_id', $BuyBill->id)
            ->where('product_id', $request->product_id)
            ->where('company_id', $company->id)
            ->first();
        if (empty($check)) {
            $buy_bill_element = BuyBillElement::create($data);
        } else {
            $old_quantity = $check->quantity;
            $new_quantity = $old_quantity + $request->quantity;
            $product_price = $request->product_price;
            $new_quantity_price = $new_quantity * $product_price;
            $unit_id = $request->unit_id;
            $buy_bill_element = $check->update([
                'product_price' => $product_price,
                'quantity' => $new_quantity,
                'unit_id' => $unit_id,
                'quantity_price' => $new_quantity_price,
            ]);
        }

        # return elements.
        if ($BuyBill && $buy_bill_element) {
            $all_elements = BuyBillElement::where('buy_bill_id', $BuyBill->id)->get();
            return response()->json([
                'status' => true,
                'msg' => 'تمت الاضافة الى الفاتورة بنجاح',
                'all_elements' => $all_elements,
            ]);
        } else {
            $all_elements = BuyBillElement::where('buy_bill_id', $BuyBill->id)->get();
            return response()->json([
                'status' => false,
                'msg' => 'هناك خطأ فى عملية الاضافة',
                'all_elements' => $all_elements,
            ]);
        }
    }

    #--------get elements of invoice--------#
    public function get_buy_bill_elements(Request $request)
    {
        # get companyData.
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);

        # get invoiceData.
        $buy_bill_number = $request->buy_bill_number;
        $buy_bill = BuyBill::where('buy_bill_number', $buy_bill_number)->first();
        $elements = BuyBillElement::where('buy_bill_id', $buy_bill->id)->get();
        $extras = BuyBillExtra::where('buy_bill_id', $buy_bill->id)->get();
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $tax_value_added = $company->tax_value_added;

        # calc total price of products.
        $sum = array();

        # print table of products.
        $countBills = BuyBill::where('company_id', $company_id)->count();
        if (!$elements->isEmpty()) {
            echo '<h6 class="alert alert-sm alert-danger text-center">
                <i class="fa fa-info-circle"></i>
            بيانات عناصر الفاتورة  رقم
                ' . $countBills . '
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
                echo "<td>" . $element->quantity . " " . $element->unit->unit_name . "</td>";
                echo "<td>" . $element->quantity_price . "</td>";
                echo "<td class='no-print'>
                    <button type='button' buy_bill_number='" . $element->BuyBill->buy_bill_number . "' element_id='" . $element->id . "' class='btn btn-sm btn-info edit_element'>
                        <i class='fa fa-pencil'></i> تعديل
                    </button>
                    <button type='button' buy_bill_number='" . $element->BuyBill->buy_bill_number . "' element_id='" . $element->id . "' class='btn btn-sm btn-danger remove_element'>
                        <i class='fa fa-trash'></i> حذف
                    </button>
                </td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            $total = array_sum($sum);
            $tax_option = $buy_bill->value_added_tax;
            if ($tax_option == 1) { //-- inclusive
                $after_total = $total;
            } else { // exclusive
                $percentage = ($tax_value_added / 100) * $total;
                $after_total = $total + $percentage;
            }

            echo "
            <div class='clearfix'></div>
            <div class='alert alert-dark alert-sm text-center'>
                <div class='pull-right col-lg-6 '>
                     اجمالى الفاتورة
                    " . $total . " " . $currency . "
                </div>
                <div class='pull-left col-lg-6 '>
                    اجمالى الفاتورة  بعد القيمة المضافة
                    " . $after_total . " " . $currency . "
                </div>
                <div class='clearfix'></div>
            </div>";

        }

        # echo scripts.
        echo "
        <script>
            $('.remove_element').on('click',function(){
                let element_id = $(this).attr('element_id');
                let buy_bill_number = $(this).attr('buy_bill_number');
                let discount_type = $('#discount_type').val();
                let discount_value = $('#discount_value').val();
                let extra_type = $('#extra_type').val();
                let extra_value = $('#extra_value').val();

                $.post('/client/buy-bills/element/delete',{
                    '_token': '" . csrf_token() . "', element_id: element_id
                    },function (data) {
                    $.post('/client/buy-bills/elements', {
                        '_token': '" . csrf_token() . "', buy_bill_number: buy_bill_number
                        },function (elements) {
                            $('.bill_details').html(elements);
                    });
                });

                $.post('/client/buy-bills/discount',{
                    '_token': '" . csrf_token() . "',
                    buy_bill_number:buy_bill_number,
                    discount_type: discount_type,
                    discount_value: discount_value
                },function (data) {
                    $('.after_totals').html(data);
                });

                $.post('/client/buy-bills/extra',{
                    '_token': '" . csrf_token() . "',
                    buy_bill_number:buy_bill_number,
                    extra_type: extra_type,
                    extra_value: extra_value
                },function (data) {
                    $('.after_totals').html(data);
                });

                $.post('/client/buy-bills/refresh',{
                    '_token': '" . csrf_token() . "',
                    buy_bill_number : buy_bill_number,
                },function (data) {
                    $('#final_total').val(data.final_total);
                });

                $(this).parent().parent().fadeOut(300);
            });

            $('.edit_element').on('click', function () {
            let element_id = $(this).attr('element_id');
            let buy_bill_number = $(this).attr('buy_bill_number');
            $.post('/client/buy-bills/edit-element',{
                    '_token': '" . csrf_token() . "',
                    buy_bill_number: buy_bill_number,
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
                    $.post('/client/buy-bills/get-edit', {
                        product_id: product_id,
                        buy_bill_number: buy_bill_number,
                        '_token': '" . csrf_token() . "'
                    }, function (data) {
                        $('input#quantity').attr('max', data.first_balance);
                        $('.available').html('الكمية المتاحة : ' + data.first_balance);
                    });
                    $('#add').hide();
                    $('#edit').show();
                    $('#edit').attr('element_id', element_id);
                    $('#edit').attr('buy_bill_number', buy_bill_number);
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
        $buy_bill_number = $request->buy_bill_number;
        $discount_type = $request->discount_type;
        $discount_value = $request->discount_value;

        # get invoiceData.
        $buy_bill = BuyBill::where('buy_bill_number', $buy_bill_number)->first();
        $elements = BuyBillElement::where('buy_bill_id', $buy_bill->id)->get();
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $tax_value_added = $company->tax_value_added;

        $sum = array();
        if (!$elements->isEmpty()) {
            # get sum of products.
            foreach ($elements as $element) {
                array_push($sum, $element->quantity_price);
            }
            $total = array_sum($sum);

            # calc discount value.
            $previous_extra = BuyBillExtra::where('buy_bill_id', $buy_bill->id)
                ->where('action', 'extra')->first();
            if (!empty($previous_extra)) {
                $previous_extra_type = $previous_extra->action_type;
                $previous_extra_value = $previous_extra->value;
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
            }

            # calc final_total and tax
            $tax_option = $buy_bill->value_added_tax;
            if (isset($after_discount) && $after_discount != 0) {
                # calc final_total with inserted tax if inclusive or exclusive.
                if ($tax_option == 0) {#exclusive
                    $percentage = ($tax_value_added / 100) * $after_discount;
                    $after_total = $after_discount + $percentage;
                } else # so its inclusive
                    $after_total = $after_discount;

            } else {
                # calc final_total with inserted tax if inclusive or exclusive.
                if ($tax_option == 0) {#exclusive
                    $percentage = ($tax_value_added / 100) * $total;
                    $after_total = $total + $percentage;
                } else # so its inclusive
                    $after_total = $total;
            }
            echo "
            <div class='clearfix'></div>
            <div class='alert alert-secondary alert-sm text-center'>
                   اجمالى الفاتورة النهائى بعد الضريبة والشحن والخصم :
                    " . $after_total . " " . $currency . "
            </div>";
            $buy_bill_extra = BuyBillExtra::where('buy_bill_id', $buy_bill->id)
                ->where('action', 'discount')->first();
            if (empty($buy_bill_extra)) {
                $buy_bill_extra = BuyBillExtra::create([
                    'buy_bill_id' => $buy_bill->id,
                    'action' => 'discount',
                    'action_type' => $discount_type,
                    'value' => $discount_value,
                    'company_id' => $company_id,
                ]);
            } else {
                $buy_bill_extra->update([
                    'action_type' => $discount_type,
                    'value' => $discount_value,
                ]);
            }
        }
    }

    #--------apply shipping to the invoice--------#
    public function apply_extra(Request $request)
    {
        # company data.
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);

        # get formData.
        $buy_bill_number = $request->buy_bill_number;
        $extra_type = $request->extra_type;
        $extra_value = $request->extra_value;

        # get invoiceData.
        $buy_bill = BuyBill::where('buy_bill_number', $buy_bill_number)->first();
        $elements = BuyBillElement::where('buy_bill_id', $buy_bill->id)->get();
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $tax_value_added = $company->tax_value_added;

        $sum = array();
        if (!$elements->isEmpty()) {
            # get sum of products.
            foreach ($elements as $element) {
                array_push($sum, $element->quantity_price);
            }
            $total = array_sum($sum);

            # calc discount value.
            $previous_discount = BuyBillExtra::where('buy_bill_id', $buy_bill->id)
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
            $tax_option = $buy_bill->value_added_tax;
            if (isset($after_extra) && $after_extra != 0) {
                # calc final_total with inserted tax if inclusive or exclusive.
                if ($tax_option == 0) {#exclusive
                    $percentage = ($tax_value_added / 100) * $after_extra;
                    $after_total = $after_extra + $percentage;
                } else # so its inclusive
                    $after_total = $after_extra;
            } else {
                # calc final_total with inserted tax if inclusive or exclusive.
                if ($tax_option == 0) {#exclusive
                    $percentage = ($tax_value_added / 100) * $total;
                    $after_total = $total + $percentage;
                } else # so its inclusive
                    $after_total = $total;
            }

            echo "
            <div class='clearfix'></div>
            <div class='alert alert-secondary alert-sm text-center'>
                   اجمالى الفاتورة النهائى بعد الضريبة والشحن والخصم :
                    " . $after_total . " " . $currency . "
            </div>";
            $buy_bill_extra = BuyBillExtra::where('buy_bill_id', $buy_bill->id)
                ->where('action', 'extra')->first();
            if (empty($buy_bill_extra)) {
                $buy_bill_extra = BuyBillExtra::create([
                    'buy_bill_id' => $buy_bill->id,
                    'action' => 'extra',
                    'action_type' => $extra_type,
                    'value' => $extra_value,
                    'company_id' => $company_id,
                ]);
            } else {
                $buy_bill_extra->update([
                    'action_type' => $extra_type,
                    'value' => $extra_value,
                ]);
            }
        }
    }

    #--------refresh data of the invoice--------#
    public function refresh(Request $request)
    {
        # get companyData.
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);

        # get invoiceData -> elements and tax.
        $buy_bill_number = $request->buy_bill_number;
        $buy_bill = BuyBill::where('buy_bill_number', $buy_bill_number)->first();
        $elements = $buy_bill->elements;
        $tax_value_added = $company->tax_value_added;

        # calc sum of products which is the price of the invoice.
        $sum = array();
        foreach ($elements as $element) {
            array_push($sum, $element->quantity_price);
        }
        $total = array_sum($sum);

        #get extra which is shipping here.
        $previous_extra = BuyBillExtra::where('buy_bill_id', $buy_bill->id)
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
        $previous_discount = BuyBillExtra::where('buy_bill_id', $buy_bill->id)
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


        # calc final total.
        $tax_option = $buy_bill->value_added_tax;
        if (isset($after_discount) && $after_discount != 0) {
            # calc final_total with inserted tax if inclusive or exclusive.
            if ($tax_option == 0) {#exclusive
                $percentage = ($tax_value_added / 100) * $after_discount;
                $after_total_all = $after_discount + $percentage;
            } else # so its inclusive
                $after_total_all = $after_discount;
        } else {
            # calc final_total with inserted tax if inclusive or exclusive.
            if ($tax_option == 0) {#exclusive
                $percentage = ($tax_value_added / 100) * $total;
                $after_total_all = $total + $percentage;
            } else # so its inclusive
                $after_total_all = $total;
        }

        $buy_bill->update([
            'final_total' => $after_total_all
        ]);
        return response()->json([
            'final_total' => $after_total_all,
        ]);
    }

    public function saveAll(Request $request)
    {
        # get userData.
        $data = $request->all();
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $client_id = Auth::user()->id;

        # get invoiceData.
        $buy_bill = BuyBill::where('buy_bill_number', $request->buy_bill_number)->first();
        $elements = $buy_bill->elements;
        foreach ($elements as $element) {
            $product = Product::FindOrFail($element->product_id);
            $old_product_balance = $product->first_balance;
            $new_product_balance = $old_product_balance + $element->quantity;
            $product->viewed = 0;
            $product->update([
                'first_balance' => $new_product_balance
            ]);
        }
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $tax_value_added = $company->tax_value_added;


        # calc total price of products.
        $sum = array();
        foreach ($elements as $element) {
            array_push($sum, $element->quantity_price);
        }
        $total = array_sum($sum);

        # calc shipping value.
        $previous_extra = BuyBillExtra::where('buy_bill_id', $buy_bill->id)
            ->where('action', 'extra')->first();
        if (!empty($previous_extra)) {
            $previous_extra_type = $previous_extra->action_type;
            $previous_extra_value = $previous_extra->value;
            if ($previous_extra_type == "percent") {
                $previous_extra_value = $previous_extra_value / 100 * $total;
            }
            $after_discount = $total + $previous_extra_value;
        }

        # calc discount value.
        $previous_discount = BuyBillExtra::where('buy_bill_id', $buy_bill->id)
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

        $tax_option = $buy_bill->value_added_tax;
        if (isset($after_discount) && $after_discount != 0) {
            # calc final_total with inserted tax if inclusive or exclusive.
            if ($tax_option == 0) {#exclusive
                $percentage = ($tax_value_added / 100) * $after_discount;
                $after_total_all = $after_discount + $percentage;
            } else # so its inclusive
                $after_total_all = $after_discount;
        } else {
            # calc final_total with inserted tax if inclusive or exclusive.
            if ($tax_option == 0) {#exclusive
                $percentage = ($tax_value_added / 100) * $total;
                $after_total_all = $total + $percentage;
            } else # so its inclusive
                $after_total_all = $total;
        }

        $cash = BuyCash::where('bill_id', $buy_bill->buy_bill_number)
            ->where('company_id', $company_id)
            ->where('client_id', $buy_bill->client_id)
            ->where('supplier_id', $buy_bill->supplier_id)
            ->first();
        if (!empty($cash)) {
            $amount = $cash->amount;
            $rest = $after_total_all - $amount;
            $supplier = Supplier::FindOrFail($buy_bill->supplier_id);
            $balance_before = $supplier->prev_balance;
            $balance_after = $balance_before + $rest;
            $supplier->update([
                'prev_balance' => $balance_after
            ]);

            $safe_id = $cash->safe_id;
            $safe = Safe::FindOrFail($safe_id);
            $safe_balance_before = $safe->balance;
            $safe_balance_after = $safe_balance_before - $amount;
            $safe->update([
                'balance' => $safe_balance_after
            ]);
            $buy_bill->update([
                'status' => 'done',
                'paid' => $amount,
                'rest' => $rest,
            ]);
        }
        $bank_cash = BankBuyCash::where('bill_id', $buy_bill->buy_bill_number)
            ->where('company_id', $company_id)
            ->where('client_id', $buy_bill->client_id)
            ->where('supplier_id', $buy_bill->supplier_id)
            ->first();
        if (!empty($bank_cash)) {
            $amount = $bank_cash->amount;
            $rest = $after_total_all - $amount;
            $supplier = Supplier::FindOrFail($buy_bill->supplier_id);
            $balance_before = $supplier->prev_balance;
            $balance_after = $balance_before + $rest;
            $supplier->update([
                'prev_balance' => $balance_after
            ]);

            $bank_id = $bank_cash->bank_id;
            $bank = Bank::FindOrFail($bank_id);
            $bank_balance_before = $bank->bank_balance;
            $bank_balance_after = $bank_balance_before - $amount;
            $bank->update([
                'bank_balance' => $bank_balance_after
            ]);
            $buy_bill->update([
                'status' => 'done',
                'paid' => $amount,
                'rest' => $rest,
            ]);
        }

        if (empty($bank_cash) && empty($cash)) {
            $rest = $after_total_all;
            $supplier = Supplier::FindOrFail($buy_bill->supplier_id);
            $balance_before = $supplier->prev_balance;
            $balance_after = $balance_before + $rest;
            $supplier->update([
                'prev_balance' => $balance_after
            ]);
            $buy_bill->update([
                'status' => 'done',
                'paid' => '0',
                'rest' => $rest,
            ]);
        }
    }

    public function send($id)
    {
        $buy_bill = BuyBill::where('buy_bill_number', $id)->first();
        $url = 'https://' . request()->getHttpHost() . '/buy-bills/print/' . $id;
        $data = array(
            'body' => 'بيانات الفاتورة ',
            'url' => $url,
            'subject' => 'مرفق مع هذه الرسالة بيانات تفصيلية للفاتورة ',
        );
        Mail::to($buy_bill->supplier->supplier_email)->send(new sendingBuyBill($data));
        return redirect()->route('client.buy_bills.index')
            ->with('success', 'تم ارسال فاتورة المشتريات الى بريد المورد بنجاح');
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
        $buy_bill_number = $request->buy_bill_number;
        $buy_bill = BuyBill::where('buy_bill_number', $buy_bill_number)->first();
        $buy_bill->elements()->delete();
        $buy_bill->extras()->delete();
        $cash = BuyCash::where('bill_id', $buy_bill->buy_bill_number)
            ->where('company_id', $company_id)
            ->where('client_id', $buy_bill->client_id)
            ->where('supplier_id', $buy_bill->supplier_id)
            ->first();
        if (!empty($cash)) {
            $cash->delete();
        }
        $cash = BankBuyCash::where('bill_id', $buy_bill->buy_bill_number)
            ->where('company_id', $company_id)
            ->where('client_id', $buy_bill->client_id)
            ->where('supplier_id', $buy_bill->supplier_id)
            ->first();
        if (!empty($cash)) {
            $cash->delete();
        }
        $buy_bill->delete();
        return redirect()->route('client.buy_bills.create')
            ->with('success', 'تم حذف الفاتورة  بنجاح');
    }

    public function delete_bill(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $client_id = Auth::user()->id;
        $bill_id = $request->billid;
        $buy_bill = BuyBill::FindOrFail($bill_id);
        $elements = $buy_bill->elements;
        $extras = $buy_bill->extras;
        $final_total = $buy_bill->final_total;
        $paid = $buy_bill->paid;
        $rest = $buy_bill->rest;

        foreach ($elements as $element) {
            $quantity = $element->quantity;
            $product_id = $element->product_id;
            $product = Product::FindOrFail($product_id);
            $prev_balance = $product->first_balance;
            $curr_balance = $prev_balance - $quantity;
            $product->update([
                'first_balance' => $curr_balance
            ]);
        }

        $buy_bill->elements()->delete();
        $buy_bill->extras()->delete();
        $cash = BuyCash::where('bill_id', $buy_bill->buy_bill_number)
            ->where('company_id', $company_id)
            ->where('client_id', $buy_bill->client_id)
            ->where('supplier_id', $buy_bill->supplier_id)
            ->first();
        if (!empty($cash)) {
            $safe_id = $cash->safe_id;
            $safe = Safe::FindOrFail($safe_id);
            $safe_balance_before = $safe->balance;
            $safe_balance_after = $safe_balance_before + $cash->amount;
            $safe->update([
                'balance' => $safe_balance_after
            ]);

            $cash->delete();
        }
        $bank_cash = BankBuyCash::where('bill_id', $buy_bill->buy_bill_number)
            ->where('company_id', $company_id)
            ->where('client_id', $buy_bill->client_id)
            ->where('supplier_id', $buy_bill->supplier_id)
            ->first();
        if (!empty($bank_cash)) {
            $bank_id = $bank_cash->bank_id;
            $bank = Bank::FindOrFail($bank_id);
            $bank_balance_before = $bank->bank_balance;
            $bank_balance_after = $bank_balance_before + $bank_cash->amount;
            $bank->update([
                'bank_balance' => $bank_balance_after
            ]);
            $bank_cash->delete();
        }
        $supplier = Supplier::FindOrFail($buy_bill->supplier_id);
        $balance_before = $supplier->prev_balance;
        $balance_after = $balance_before - $rest;
        $supplier->update([
            'prev_balance' => $balance_after
        ]);
        $buy_bill->delete();
        return redirect()->route('client.buy_bills.index')
            ->with('success', 'تم حذف الفاتورة  بنجاح');
    }

    public function edit($id)
    {
        $company_id = Auth::user()->company_id;
        $bill_id = $id;
        $buy_bill = BuyBill::FindOrFail($bill_id);
        $elements = $buy_bill->elements;
        $extras = $buy_bill->extras;
        $final_total = $buy_bill->final_total;
        $paid = $buy_bill->paid;
        $rest = $buy_bill->rest;

        foreach ($elements as $element) {
            $quantity = $element->quantity;
            $product_id = $element->product_id;
            $product = Product::FindOrFail($product_id);
            $prev_balance = $product->first_balance;
            $curr_balance = $prev_balance - $quantity;
            $product->update([
                'first_balance' => $curr_balance
            ]);
        }
        $cash = BuyCash::where('bill_id', $buy_bill->buy_bill_number)
            ->where('company_id', $company_id)
            ->where('client_id', $buy_bill->client_id)
            ->where('supplier_id', $buy_bill->supplier_id)
            ->first();
        if (!empty($cash)) {
            $safe_id = $cash->safe_id;
            $safe = Safe::FindOrFail($safe_id);
            $safe_balance_before = $safe->balance;
            $safe_balance_after = $safe_balance_before + $cash->amount;
            $safe->update([
                'balance' => $safe_balance_after
            ]);
        }
        $bank_cash = BankBuyCash::where('bill_id', $buy_bill->buy_bill_number)
            ->where('company_id', $company_id)
            ->where('client_id', $buy_bill->client_id)
            ->where('supplier_id', $buy_bill->supplier_id)
            ->first();
        if (!empty($bank_cash)) {
            $bank_id = $bank_cash->bank_id;
            $bank = Bank::FindOrFail($bank_id);
            $bank_balance_before = $bank->bank_balance;
            $bank_balance_after = $bank_balance_before + $bank_cash->amount;
            $bank->update([
                'bank_balance' => $bank_balance_after
            ]);
        }
        $supplier = Supplier::FindOrFail($buy_bill->supplier_id);
        $balance_before = $supplier->prev_balance;
        $balance_after = $balance_before - $rest;
        $supplier->update([
            'prev_balance' => $balance_after
        ]);
        $buy_bill->update([
            'status' => 'open'
        ]);
        return redirect()->route('client.buy_bills.create');
    }

    public function filter_code(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $products = $company->products;
        $buy_bills = BuyBill::where('company_id', $company_id)->where('status', 'done')->get();
        $suppliers = $company->suppliers;

        $product_id = $request->code_universal;
        $product_k = Product::FindOrFail($product_id);
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;

        $buy_bill_elements = BuyBillElement::where('product_id', $product_k->id)->get();
        $arr = array();
        foreach ($buy_bill_elements as $buy_bill_element) {
            $buy_bill = $buy_bill_element->BuyBill;
            $buy_bill_id = $buy_bill->id;
            array_push($arr, $buy_bill_id);
        }
        $my_array = array_unique($arr);
        $product_buy_bills = BuyBill::whereIn('id', $my_array)->get();
        return view('client.buy_bills.index', compact('currency', 'product_k', 'products', 'product_buy_bills', 'buy_bills', 'suppliers', 'company'));
    }

    public function filter_product(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $products = $company->products;
        $buy_bills = BuyBill::where('company_id', $company_id)->where('status', 'done')->get();
        $suppliers = $company->suppliers;

        $product_id = $request->product_name;
        $product_k = Product::FindOrFail($product_id);
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;

        $buy_bill_elements = BuyBillElement::where('product_id', $product_k->id)->get();
        $arr = array();
        foreach ($buy_bill_elements as $buy_bill_element) {
            $buy_bill = $buy_bill_element->BuyBill;
            $buy_bill_id = $buy_bill->id;
            array_push($arr, $buy_bill_id);
        }
        $my_array = array_unique($arr);
        $product_buy_bills = BuyBill::whereIn('id', $my_array)->get();
        return view('client.buy_bills.index', compact('currency', 'product_k', 'products', 'product_buy_bills', 'buy_bills', 'suppliers', 'company'));
    }

    public function filter_all(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $products = $company->products;
        $buy_bills = BuyBill::where('company_id', $company_id)->where('status', 'done')->get();
        $suppliers = $company->suppliers;
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $all_buy_bills = BuyBill::where('company_id', $company_id)->where('status', 'done')->get();
        return view('client.buy_bills.index', compact('currency', 'products', 'all_buy_bills', 'buy_bills', 'suppliers', 'company'));
    }

    public function filter_supplier(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);

        $products = $company->products;
        $buy_bills = BuyBill::where('company_id', $company_id)->where('status', 'done')->get();
        $suppliers = $company->suppliers;

        $supplier_id = $request->supplier_id;
        $supplier_k = Supplier::FindOrFail($supplier_id);
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;

        $supplier_buy_bills = BuyBill::where('supplier_id', $supplier_k->id)->get();

        return view('client.buy_bills.index', compact('currency', 'products', 'supplier_k', 'supplier_buy_bills', 'buy_bills', 'suppliers', 'company'));
    }

    public function filter_key(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);

        $products = $company->products;
        $buy_bills = BuyBill::where('company_id', $company_id)->where('status', 'done')->get();
        $suppliers = $company->suppliers;

        $buy_bill_id = $request->buy_bill_id;

        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;

        $buy_bill_k = BuyBill::FindOrFail($buy_bill_id);
        $cash = BuyCash::where('bill_id', $buy_bill_k->buy_bill_number)
            ->where('company_id', $company_id)
            ->where('client_id', $buy_bill_k->client_id)
            ->where('supplier_id', $buy_bill_k->supplier_id)
            ->first();

        $elements = $buy_bill_k->elements;
        $extras = $buy_bill_k->extras;
        foreach ($extras as $key) {
            if ($key->action == "discount") {
                if ($key->action_type == "pound") {
                    $buy_bill_discount_value = $key->value;
                    $buy_bill_discount_type = "pound";
                } else {
                    $buy_bill_discount_value = $key->value;
                    $buy_bill_discount_type = "percent";
                }
            } else {
                if ($key->action_type == "pound") {
                    $buy_bill_extra_value = $key->value;
                    $buy_bill_extra_type = "pound";
                } else {
                    $buy_bill_extra_value = $key->value;
                    $buy_bill_extra_type = "percent";
                }
            }
        }
        if ($extras->isEmpty()) {
            $buy_bill_discount_value = 0;
            $buy_bill_extra_value = 0;
            $buy_bill_discount_type = "pound";
            $buy_bill_extra_type = "pound";
        }
        $tax_value_added = $company->tax_value_added;
        $sum = array();
        foreach ($elements as $element) {
            array_push($sum, $element->quantity_price);
        }
        $total = array_sum($sum);

        $previous_extra = BuyBillExtra::where('buy_bill_id', $buy_bill_k->id)
            ->where('action', 'extra')->first();
        if (!empty($previous_extra)) {
            $previous_extra_type = $previous_extra->action_type;
            $previous_extra_value = $previous_extra->value;
            if ($previous_extra_type == "percent") {
                $previous_extra_value = $previous_extra_value / 100 * $total;
            }
            $after_discount = $total + $previous_extra_value;
        }


        $previous_discount = BuyBillExtra::where('buy_bill_id', $buy_bill_k->id)
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

        return view('client.buy_bills.index',
            compact('currency', 'after_discount', 'after_total_all', 'buy_bill_k', 'buy_bills', 'suppliers'
                , 'elements', 'extras', 'products', 'cash', 'company', 'buy_bill_discount_value', 'buy_bill_discount_type', 'buy_bill_extra_value', 'buy_bill_extra_type'));
    }

    public function get_product_price(Request $request)
    {
        $product_id = $request->product_id;
        $product = Product::FindOrFail($product_id);
        $purchasing_price = $product->purchasing_price;
        return response()->json([
            'purchasing_price' => $purchasing_price,
        ]);
    }

    public function get_supplier_details(Request $request)
    {
        $supplier_id = $request->supplier_id;
        $supplier = Supplier::FindOrFail($supplier_id);
        $category = $supplier->supplier_category;
        $balance_before = $supplier->prev_balance;
        $supplier_national = $supplier->supplier_national;
        return response()->json([
            'category' => $category,
            'balance_before' => $balance_before,
            'supplier_national' => $supplier_national,
        ]);
    }

    public function delete_element(Request $request)
    {
        $element_id = $request->element_id;
        $element = BuyBillElement::FindOrFail($element_id);
        $buy_bill_id = $element->buy_bill_id;
        $element->delete();
    }

    public function updateData(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $buy_bill_number = $request->buy_bill_number;
        $buy_bill = BuyBill::where('buy_bill_number', $buy_bill_number)->first();
        $elements = BuyBillElement::where('buy_bill_id', $buy_bill->id)->get();
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
        echo "
            <div class='pull-right col-lg-6 '>
            اجمالى الفاتورة
            " . $total . " " . $currency . "
            </div>
            <div class='pull-left col-lg-6 '>
            اجمالى الفاتورة  بعد القيمة المضافة
            " . $after_total . " " . $currency . "
            </div>
            <div class='clearfix'></div>";
    }

    public function get_return(Request $request)
    {
        $buy_bill = BuyBill::FindOrFail($request->buy_bill_id);
        $element = BuyBillElement::FindOrFail($request->element_id);
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $suppliers = $company->suppliers;
        $products = $company->products;
        return view('client.buy_bills.return', compact('company', 'buy_bill', 'element', 'products', 'company_id', 'suppliers'));
    }

    public function post_return(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $data = $request->all();
        $data['company_id'] = $company_id;
        $data['client_id'] = Auth::user()->id;
        $return = BuyBillReturn::create($data);
        $element = BuyBillElement::FindOrFail($request->element_id);
        $product = Product::FindOrFail($request->product_id);
        $supplier = Supplier::FindOrFail($request->supplier_id);
        $product->update([
            'first_balance' => $request->after_return
        ]);
        $supplier->update([
            'prev_balance' => $request->balance_after
        ]);
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

        return redirect()->route('client.buy_bills.returns');
    }

    public function get_returns()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $buy_bill_returns = $company->buy_bill_returns;
        return view('client.buy_bills.returns', compact('buy_bill_returns'));
    }

    public function redirect()
    {
        return redirect()->route('client.buy_bills.create')->with('success', 'تم انشاء فاتورة مشتريات بنجاح');
    }

    public function get_products(Request $request)
    {
        $store_id = $request->store_id;
        $products = Product::where('store_id', $store_id)->get();
        foreach ($products as $product) {
            echo "<option value='" . $product->id . "'>" . $product->product_name . "</option>";
        }
    }

    public function print($id)
    {
        $buy_bill = BuyBill::where('buy_bill_number', $id)->first();
        if (!empty($buy_bill)) {
            $elements = $buy_bill->elements;
            if ($elements->isEmpty()) {
                return abort('404');
            } else {
                return view('client.buy_bills.print', compact('buy_bill'));
            }
        } else {
            return abort('404');
        }
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

    public function update_element(Request $request)
    {
        $elementId = $request->element_id;
        $element = BuyBillElement::findOrFail($elementId);

        $element->update([
            'unit_id' => $request->unit_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'quantity_price' => $request->quantity_price,
            'product_price' => $request->product_price,
        ]);

        return response()->json(['message' => 'Element updated successfully']);
    }

    public function edit_element(Request $request)
    {
        $elementId = $request->element_id;
        $element = BuyBillElement::findOrFail($elementId);

        return response()->json([
            'product_id' => $element->product_id,
            'product_price' => $element->product_price,
            'quantity' => $element->quantity,
            'quantity_price' => $element->quantity_price,
            'unit_id' => $element->unit_id,
        ]);
    }


}


