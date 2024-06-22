<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\sendingPurchaseOrder;
use App\Models\BuyBill;
use App\Models\BuyBillElement;
use App\Models\BuyBillExtra;
use App\Models\Company;
use App\Models\ExtraSettings;

use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderElement;
use App\Models\PurchaseOrderExtra;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PurchaseOrderController extends Controller
{

    public function index()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $purchase_orders = $company->purchase_orders;
        $suppliers = $company->suppliers;
        $products = $company->products;
        return view('client.purchase_orders.index', compact('company', 'products', 'company_id', 'suppliers', 'purchase_orders'));
    }

    public function filter_code(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $products = $company->products;
        $purchase_orders = $company->purchase_orders;
        $suppliers = $company->suppliers;

        $product_id = $request->code_universal;
        $product_k = Product::FindOrFail($product_id);
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;

        $purchase_order_elements = PurchaseOrderElement::where('product_id', $product_k->id)->get();
        $arr = array();
        foreach ($purchase_order_elements as $purchase_order_element) {
            $purchase_order = $purchase_order_element->PurchaseOrder;
            $purchase_order_id = $purchase_order->id;
            array_push($arr, $purchase_order_id);
        }
        $my_array = array_unique($arr);
        $product_purchase_orders = PurchaseOrder::whereIn('id', $my_array)->get();
        return view('client.purchase_orders.index', compact('currency', 'product_k', 'products', 'product_purchase_orders', 'purchase_orders', 'suppliers', 'company'));
    }

    public function filter_product(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $products = $company->products;
        $purchase_orders = $company->purchase_orders;
        $suppliers = $company->suppliers;

        $product_id = $request->product_name;
        $product_k = Product::FindOrFail($product_id);
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;

        $purchase_order_elements = PurchaseOrderElement::where('product_id', $product_k->id)->get();
        $arr = array();
        foreach ($purchase_order_elements as $purchase_order_element) {
            $purchase_order = $purchase_order_element->PurchaseOrder;
            $purchase_order_id = $purchase_order->id;
            array_push($arr, $purchase_order_id);
        }
        $my_array = array_unique($arr);
        $product_purchase_orders = PurchaseOrder::whereIn('id', $my_array)->get();
        return view('client.purchase_orders.index', compact('currency', 'product_k', 'products', 'product_purchase_orders', 'purchase_orders', 'suppliers', 'company'));
    }

    public function filter_supplier(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);

        $products = $company->products;
        $purchase_orders = $company->purchase_orders;
        $suppliers = $company->suppliers;

        $supplier_id = $request->supplier_id;
        $supplier_k = Supplier::FindOrFail($supplier_id);
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;

        $supplier_purchase_orders = PurchaseOrder::where('supplier_id', $supplier_k->id)->get();

        return view('client.purchase_orders.index', compact('currency', 'products', 'supplier_k', 'supplier_purchase_orders', 'purchase_orders', 'suppliers', 'company'));
    }
    public function filter_all(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $products = $company->products;
        $purchase_orders = $company->purchase_orders;
        $suppliers = $company->suppliers;
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $all_purchase_orders = $company->purchase_orders;
        return view('client.purchase_orders.index', compact('currency', 'products', 'all_purchase_orders', 'purchase_orders', 'suppliers', 'company'));
    }

    public function filter_key(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);

        $products = $company->products;
        $purchase_orders = $company->purchase_orders;
        $suppliers = $company->suppliers;

        $purchase_order_id = $request->purchase_order_id;

        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;

        $purchase_order_k = PurchaseOrder::FindOrFail($purchase_order_id);
        $elements = $purchase_order_k->elements;
        $extras = $purchase_order_k->extras;
        foreach ($extras as $key) {
            if ($key->action == "discount") {
                if ($key->action_type == "pound") {
                    $purchase_order_discount_value = $key->value;
                    $purchase_order_discount_type = "pound";
                } else {
                    $purchase_order_discount_value = $key->value;
                    $purchase_order_discount_type = "percent";
                }
            } else {
                if ($key->action_type == "pound") {
                    $purchase_order_extra_value = $key->value;
                    $purchase_order_extra_type = "pound";
                } else {
                    $purchase_order_extra_value = $key->value;
                    $purchase_order_extra_type = "percent";
                }
            }
        }
        if ($extras->isEmpty()) {
            $purchase_order_discount_value = 0;
            $purchase_order_extra_value = 0;
            $purchase_order_discount_type = "pound";
            $purchase_order_extra_type = "pound";
        }
        $tax_value_added = $company->tax_value_added;
        $sum = array();
        foreach ($elements as $element) {
            array_push($sum, $element->quantity_price);
        }
        $total = array_sum($sum);

        $previous_extra = PurchaseOrderExtra::where('purchase_order_id', $purchase_order_k->id)
            ->where('action', 'extra')->first();
        if (!empty($previous_extra)) {
            $previous_extra_type = $previous_extra->action_type;
            $previous_extra_value = $previous_extra->value;
            if ($previous_extra_type == "percent") {
                $previous_extra_value = $previous_extra_value / 100 * $total;
            }
            $after_discount = $total + $previous_extra_value;
        }


        $previous_discount = PurchaseOrderExtra::where('purchase_order_id', $purchase_order_k->id)
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

        return view('client.purchase_orders.index',
            compact('currency', 'after_discount', 'after_total_all', 'purchase_order_k', 'purchase_orders', 'suppliers'
                , 'elements', 'extras', 'products', 'company', 'purchase_order_discount_value', 'purchase_order_discount_type', 'purchase_order_extra_value', 'purchase_order_extra_type'));
    }

    public function send($id)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $purchase_order = PurchaseOrder::where('purchase_order_number', $id)->first();
        $tax_value_added = $company->tax_value_added;
        $sum = array();
        $elements = $purchase_order->elements;
        foreach ($elements as $element) {
            array_push($sum, $element->quantity_price);
        }
        $total = array_sum($sum);
        $previous_extra = PurchaseOrderExtra::where('purchase_order_id', $purchase_order->id)
            ->where('action', 'extra')->first();
        if (!empty($previous_extra)) {
            $previous_extra_type = $previous_extra->action_type;
            $previous_extra_value = $previous_extra->value;
            if ($previous_extra_type == "percent") {
                $previous_extra_value = $previous_extra_value / 100 * $total;
            }
            $after_discount = $total + $previous_extra_value;
        }
        $previous_discount = PurchaseOrderExtra::where('purchase_order_id', $purchase_order->id)
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

        $data = array(
            'purchase_order' => $purchase_order,
            'body' => 'بيانات امر الشراء',
            'elements' => $purchase_order->elements,
            'extras' => $purchase_order->extras,
            'subject' => 'مرفق مع هذه الرسالة بيانات تفصيلية لامر الشراء',
            'company' => $company,
            'after_total_all' => $after_total_all,
            'currency' => $currency,
        );

        Mail::to($purchase_order->supplier->supplier_email)->send(new sendingPurchaseOrder($data));
        return redirect()->route('client.purchase_orders.index')
            ->with('success', 'تم  ارسال امر الشراء الى بريد المورد بنجاح');

    }

    public function show($id)
    {
        dd($id);
    }

    public function create()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $categories = $company->categories;
        $all_products = Product::where('company_id', $company_id)->where('first_balance', '>', '0')->get();
        $stores = $company->stores;
        $units = $company->units;
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $suppliers = Supplier::where('company_id', $company_id)->get();
        $check = PurchaseOrder::all();
        if ($check->isEmpty()) {
            $pre_purchase_order = 1;
        } else {
            $old_purchase_order = PurchaseOrder::max('purchase_order_number');
            $pre_purchase_order = ++$old_purchase_order;
        }
        return view('client.purchase_orders.create',
            compact('company', 'suppliers','units', 'stores', 'categories', 'extra_settings', 'company_id', 'all_products', 'pre_purchase_order'));
    }

    public function get_product_price(Request $request)
    {
        $product_id = $request->product_id;
        $supplier_id = $request->supplier_id;
        $product = Product::FindOrFail($product_id);
        $supplier = Supplier::FindOrFail($supplier_id);
        $first_balance = $product->first_balance;
        $order_price = $product->purchasing_price;
        return response()->json([
            'order_price' => $order_price,
            'first_balance' => $first_balance . " " . $product->unit->unit_name
        ]);
    }

    public function save(Request $request)
    {
        $data = $request->all();
        $data['company_id'] = Auth::user()->company_id;
        $company = Company::FindOrFail($data['company_id']);
        $data['client_id'] = Auth::user()->id;
        $purchase_order = PurchaseOrder::where('purchase_order_number', $data['purchase_order_number'])->first();
        if (empty($purchase_order)) {
            $purchase_order = PurchaseOrder::create($data);
        } else {
            $purchase_order->update($data);
        }
        $data['purchase_order_id'] = $purchase_order->id;
        $data['company_id'] = $company->id;

        $check = PurchaseOrderElement::where('purchase_order_id', $purchase_order->id)
            ->where('product_id', $request->product_id)
            ->where('company_id', $company->id)
            ->first();
        if (empty($check)) {
            $purchase_order_element = PurchaseOrderElement::create($data);
        } else {
            $old_quantity = $check->quantity;
            $new_quantity = $old_quantity + $request->quantity;
            $product_price = $request->product_price;
            $new_quantity_price = $new_quantity * $product_price;
            $unit_id = $request->unit_id;
            $purchase_order_element = $check->update([
                'product_price' => $product_price,
                'quantity' => $new_quantity,
                'unit_id' => $unit_id,
                'quantity_price' => $new_quantity_price,
            ]);
        }
        if ($purchase_order && $purchase_order_element) {
            $all_elements = PurchaseOrderElement::where('purchase_order_id', $purchase_order->id)->get();
            return response()->json([
                'status' => true,
                'msg' => 'تمت الاضافة الى امر الشراء بنجاح',
                'all_elements' => $all_elements,
            ]);
        } else {
            $all_elements = PurchaseOrderElement::where('purchase_order_id', $purchase_order->id)->get();
            return response()->json([
                'status' => false,
                'msg' => 'هناك خطأ فى عملية الاضافة',
                'all_elements' => $all_elements,
            ]);
        }
    }

    public function destroy_element(Request $request)
    {
        $element_id = $request->element_id;
        $element = PurchaseOrderElement::FindOrFail($element_id);
        $purchase_order_id = $element->purchase_order_id;
        $element->delete();
    }

    public function changePurchaseOrder(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $data = $request->all();
        $purchase_order_number = $request->purchase_order_number;
        $purchase_order = PurchaseOrder::where('purchase_order_number', $purchase_order_number)->first();
        $purchase_order->update($data);
        echo "<p class='alert alert-sm alert-success text-center mt-2 mb-2'>تم حفظ البيانات بنجاح</p>";
    }

    public function updateData(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $purchase_order_number = $request->purchase_order_number;
        $purchase_order = PurchaseOrder::where('purchase_order_number', $purchase_order_number)->first();
        $elements = PurchaseOrderElement::where('purchase_order_id', $purchase_order->id)->get();
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
            اجمالى امر الشراء
            " . $total . " " . $currency . "
            </div>
            <div class='pull-left col-lg-6 '>
            اجمالى امر الشراء بعد القيمة المضافة
            " . $after_total . " " . $currency . "
            </div>
            <div class='clearfix'></div>";
    }

    public function get_purchase_order_elements(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $purchase_order_number = $request->purchase_order_number;
        $purchase_order = PurchaseOrder::where('purchase_order_number', $purchase_order_number)->first();
        $elements = PurchaseOrderElement::where('purchase_order_id', $purchase_order->id)->get();
        $extras = PurchaseOrderExtra::where('purchase_order_id', $purchase_order->id)->get();
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $tax_value_added = $company->tax_value_added;
        $sum = array();
        if (!$elements->isEmpty()) {
            echo '<h6 class="alert alert-sm alert-danger text-center">
                <i class="fa fa-info-circle"></i>
            بيانات عناصر امر الشراء رقم
                ' . $purchase_order_number . '
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
                    echo "<td>" . $element->quantity ." ".$element->unit->unit_name. "</td>";
                    echo "<td>" . $element->quantity_price . "</td>";
                    echo "<td class='no-print'>
                            <button type='button' purchase_order_number='" . $element->PurchaseOrder->purchase_order_number . "' element_id='" . $element->id . "' class='btn btn-sm btn-info edit_element'>
                                <i class='fa fa-pencil'></i> تعديل
                            </button>
                            <button type='button' purchase_order_number='" . $element->PurchaseOrder->purchase_order_number . "' element_id='" . $element->id . "' class='btn btn-sm btn-danger remove_element'>
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
            echo "
            <div class='clearfix'></div>
            <div class='alert alert-dark alert-sm text-center'>
                <div class='pull-right col-lg-6 '>
                     اجمالى امر الشراء
                    " . $total . " " . $currency . "
                </div>
                <div class='pull-left col-lg-6 '>
                    اجمالى امر الشراء بعد القيمة المضافة
                    " . $after_total . " " . $currency . "
                </div>
                <div class='clearfix'></div>
            </div>";

        }

        echo "
        <script>
            $('.remove_element').on('click',function(){
                let element_id = $(this).attr('element_id');
                let purchase_order_number = $(this).attr('purchase_order_number');

                let discount_type = $('#discount_type').val();
                let discount_value = $('#discount_value').val();

                let extra_type = $('#extra_type').val();
                let extra_value = $('#extra_value').val();

                $.post('/client/purchase_orders/element/delete',
                {'_token': '" . csrf_token() . "', element_id: element_id},
                function (data) {
                    $.post('/client/purchase_orders/elements',
                        {'_token': '" . csrf_token() . "', purchase_order_number: purchase_order_number},
                        function (elements) {
                            $('.bill_details').html(elements);
                        });
                    });
                $.post('/client/purchase_orders/discount',
                    {'_token': '" . csrf_token() . "',purchase_order_number:purchase_order_number, discount_type: discount_type, discount_value: discount_value},
                    function (data) {
                        $('.after_totals').html(data);
                });

                $.post('/client/purchase_orders/extra',
                    {'_token': '" . csrf_token() . "',purchase_order_number:purchase_order_number, extra_type: extra_type, extra_value: extra_value},
                    function (data) {
                        $('.after_totals').html(data);
                });

                $(this).parent().parent().fadeOut(300);
            });

            $('.edit_element').on('click', function () {
                let element_id = $(this).attr('element_id');
                let purchase_order_number = $(this).attr('purchase_order_number');
                $.post('/client/purchase_orders/edit-element',
                    {
                        '_token': '" . csrf_token() . "',
                        purchase_order_number: purchase_order_number,
                        element_id: element_id
                    },
                    function (data) {
                        $('#product_id').val(data.product_id);
                        $('#product_id').selectpicker('refresh');
                        $('#product_price').val(data.product_price);
                        $('#unit_id').val(data.unit_id);
                        $('#quantity').val(data.quantity);
                        $('#quantity_price').val(data.quantity_price);
                        $('#add').hide();
                        $('#edit').show();
                        $('#edit').attr('element_id', element_id);
                        $('#edit').attr('purchase_order_number', purchase_order_number);
                    });
                });


        </script>
        ";
    }

    public function apply_discount(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $purchase_order_number = $request->purchase_order_number;
        $discount_type = $request->discount_type;
        $discount_value = $request->discount_value;
        $purchase_order = PurchaseOrder::where('purchase_order_number', $purchase_order_number)->first();
        $elements = PurchaseOrderElement::where('purchase_order_id', $purchase_order->id)->get();
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $tax_value_added = $company->tax_value_added;
        $sum = array();
        if (!$elements->isEmpty()) {
            foreach ($elements as $element) {
                array_push($sum, $element->quantity_price);
            }
            $total = array_sum($sum);

            $previous_extra = PurchaseOrderExtra::where('purchase_order_id', $purchase_order->id)
                ->where('action', 'extra')->first();
            if (!empty($previous_extra)) {
                $previous_extra_type = $previous_extra->action_type;
                $previous_extra_value = $previous_extra->value;
                if ($previous_extra_type == "percent") {
                    $previous_extra_value = $previous_extra_value / 100 * $total;
                }
            }

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

            if (isset($after_discount) && $after_discount != 0) {
                $percentage = ($tax_value_added / 100) * $after_discount;
                $after_total = $after_discount + $percentage;
            } else {
                $percentage = ($tax_value_added / 100) * $total;
                $after_total = $total + $percentage;
            }
            echo "
            <div class='clearfix'></div>
            <div class='alert alert-secondary alert-sm text-center'>
                   اجمالى امر الشراء النهائى بعد الضريبة والشحن والخصم :
                    " . $after_total . " " . $currency . "
            </div>";
            $purchase_order_extra = PurchaseOrderExtra::where('purchase_order_id', $purchase_order->id)
                ->where('action', 'discount')->first();
            if (empty($purchase_order_extra)) {
                $purchase_order_extra = PurchaseOrderExtra::create([
                    'purchase_order_id' => $purchase_order->id,
                    'action' => 'discount',
                    'action_type' => $discount_type,
                    'value' => $discount_value,
                    'company_id' => $company_id,
                ]);
            } else {
                $purchase_order_extra->update([
                    'action_type' => $discount_type,
                    'value' => $discount_value,
                ]);
            }
        }
    }

    public function apply_extra(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $purchase_order_number = $request->purchase_order_number;
        $extra_type = $request->extra_type;
        $extra_value = $request->extra_value;
        $purchase_order = PurchaseOrder::where('purchase_order_number', $purchase_order_number)->first();
        $elements = PurchaseOrderElement::where('purchase_order_id', $purchase_order->id)->get();
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $tax_value_added = $company->tax_value_added;
        $sum = array();
        if (!$elements->isEmpty()) {
            foreach ($elements as $element) {
                array_push($sum, $element->quantity_price);
            }
            $total = array_sum($sum);

            $previous_discount = PurchaseOrderExtra::where('purchase_order_id', $purchase_order->id)
                ->where('action', 'discount')->first();
            if (!empty($previous_discount)) {
                $previous_discount_type = $previous_discount->action_type;
                $previous_discount_value = $previous_discount->value;
                if ($previous_discount_type == "percent") {
                    $previous_discount_value = $previous_discount_value / 100 * $total;
                }
            }


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
            if (isset($after_extra) && $after_extra != 0) {
                $percentage = ($tax_value_added / 100) * $after_extra;
                $after_total = $after_extra + $percentage;
            } else {
                $percentage = ($tax_value_added / 100) * $total;
                $after_total = $total + $percentage;
            }
            echo "
            <div class='clearfix'></div>
            <div class='alert alert-secondary alert-sm text-center'>
                   اجمالى امر الشراء النهائى بعد الضريبة والشحن والخصم :
                    " . $after_total . " " . $currency . "
            </div>";
            $purchase_order_extra = PurchaseOrderExtra::where('purchase_order_id', $purchase_order->id)
                ->where('action', 'extra')->first();
            if (empty($purchase_order_extra)) {
                $purchase_order_extra = PurchaseOrderExtra::create([
                    'purchase_order_id' => $purchase_order->id,
                    'action' => 'extra',
                    'action_type' => $extra_type,
                    'value' => $extra_value,
                    'company_id' => $company_id,
                ]);
            } else {
                $purchase_order_extra->update([
                    'action_type' => $extra_type,
                    'value' => $extra_value,
                ]);
            }
        }
    }

    public function destroy(Request $request)
    {
        $purchase_order_number = $request->purchase_order_number;
        $purchase_order = PurchaseOrder::where('purchase_order_number', $purchase_order_number)->first();
        $purchase_order->elements()->delete();
        $purchase_order->extras()->delete();
        $purchase_order->delete();
        return redirect()->route('client.purchase_orders.create')
            ->with('success', 'تم حذف امر الشراء بنجاح');
    }

    public function redirect()
    {
        return redirect()->route('client.purchase_orders.create')->with('success', 'تم انشاء امر الشراء بنجاح');
    }

    public function get_supplier_details(Request $request)
    {
        $supplier_id = $request->supplier_id;
        $supplier = Supplier::FindOrFail($supplier_id);
        if($supplier->prev_balance > 0 ){
            $balance = "له ". floatval($supplier->prev_balance);
        }
        elseif($supplier->prev_balance < 0){
            $balance = "عليه ". floatval(abs($supplier->prev_balance));
        }
        else{
            $balance = 0;
        }
        echo "<div class='col-lg-4 pull-right'>" . "الفئة : " . $supplier->supplier_category . '</div>';
        echo "<div class='col-lg-4 pull-right'>" . " مستحقات المورد : " . $balance . '</div>';
        echo "<div class='col-lg-4 pull-right'>" . " الجنسية : " . $supplier->supplier_national . '</div>';
        echo "<div class='clearfix'></div>";
    }

    public function get_products(Request $request)
    {
        $store_id = $request->store_id;
        $products = Product::where('store_id', $store_id)->get();
        foreach ($products as $product) {
            echo "<option value='" . $product->id . "'>" . $product->product_name . "</option>";
        }
    }

    public function edit($id)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $purchase_order = PurchaseOrder::findOrFail($id);
        $categories = $company->categories;
        $all_products = $company->products;
        $stores = $company->stores;
        $units = $company->units;
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $suppliers = Supplier::where('company_id', $company_id)->get();
        $safes = $company->safes;
        $banks = $company->banks;
        return view('client.purchase_orders.edit',
            compact('purchase_order','units', 'categories', 'all_products', 'stores',
                'extra_settings', 'safes', 'banks', 'suppliers', 'company_id', 'company'));
    }

    public function delete_bill(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $client_id = Auth::user()->id;
        $bill_id = $request->billid;
        $purchase_order = PurchaseOrder::FindOrFail($bill_id);
        $elements = $purchase_order->elements;
        $extras = $purchase_order->extras;
        $purchase_order->elements()->delete();
        $purchase_order->extras()->delete();
        $purchase_order->delete();
        return redirect()->route('client.purchase_orders.index')
            ->with('success', 'تم حذف امر الشراء  بنجاح');
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
        $element_id = $request->element_id;
        $element = PurchaseOrderElement::FindOrFail($element_id);
        $element->update([
            'unit_id' => $request->unit_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'quantity_price' => $request->quantity_price,
            'product_price' => $request->product_price,
        ]);
    }
    public function edit_element(Request $request)
    {
        $element = PurchaseOrderElement::FindOrFail($request->element_id);
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
    public function convert_to_buybill($id)
    {
        $purchase_order = PurchaseOrder::FindOrFail($id);
        $purchase_order_elements = $purchase_order->elements;
        $purchase_order_extras = $purchase_order->extras;

        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $client_id = Auth::user()->id;

        $check = BuyBill::all();
        if ($check->isEmpty()) {
            $pre_bill = 1;
        } else {
            $old_pre_bill = BuyBill::max('buy_bill_number');
            $pre_bill = ++$old_pre_bill;
        }
        $date = date('Y-m-d');
        $time = date('H:i:s');
        $status = "open";
        $paid = "0";

        $tax_value_added = $company->tax_value_added;
        $sum = array();
        foreach ($purchase_order_elements as $element) {
            array_push($sum, $element->quantity_price);
        }
        $total = array_sum($sum);
        $previous_extra = PurchaseOrderExtra::where('purchase_order_id', $purchase_order->id)
            ->where('action', 'extra')->first();
        if (!empty($previous_extra)) {
            $previous_extra_type = $previous_extra->action_type;
            $previous_extra_value = $previous_extra->value;
            if ($previous_extra_type == "percent") {
                $previous_extra_value = $previous_extra_value / 100 * $total;
            }
            $after_discount = $total + $previous_extra_value;
        }
        $previous_discount = PurchaseOrderExtra::where('purchase_order_id', $purchase_order->id)
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

        $final_total = $after_total_all;
        $rest = $final_total;

        $buyBill = BuyBill::create([
            'company_id' => $company_id,
            'client_id' => $client_id,
            'supplier_id' => $purchase_order->supplier_id,
            'buy_bill_number' => $pre_bill,
            'date' => $date,
            'time' => $time,
            'status' => $status,
            'final_total' => $final_total,
            'paid' => $paid,
            'rest' => $rest,
        ]);

        foreach ($purchase_order_elements as $element) {
            $buybill_element = BuyBillElement::create([
                'buy_bill_id' => $buyBill->id,
                'company_id' => $company_id,
                'product_id' => $element->product_id,
                'product_price' => $element->product_price,
                'quantity' => $element->quantity,
                'quantity_price' => $element->quantity_price,
                'unit_id' => $element->unit_id
            ]);
        }
        foreach ($purchase_order_extras as $extra) {
            $buyBill_extra = BuyBillExtra::create([
                'company_id' => $company_id,
                'buy_bill_id' => $buyBill->id,
                'action' => $extra->action,
                'action_type' => $extra->action_type,
                'value' => $extra->value,
            ]);
        }
        return redirect()->route('client.buy_bills.create')->with('success','تم تحويل امر الشراء الى فاتورة مشتريات ');
    }


}

?>
