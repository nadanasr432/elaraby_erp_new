<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\sendingQuotation;
use App\Models\BasicSettings;
use App\Models\BuyBill;
use App\Models\BuyCash;
use App\Models\Company;
use App\Models\ExtraSettings;
use App\Models\OuterClient;

use App\Models\Product;
use App\Models\Quotation;
use App\Models\QuotationElement;
use App\Models\QuotationExtra;
use App\Models\SaleBill;
use App\Models\SaleBillElement;
use App\Models\SaleBillExtra;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class QuotationController extends Controller
{

    function createHashToken($length = 15)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    # view create page #
    public function index()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $products = $company->products;
        $quotations = $company->quotations;
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
        $all_quotations = $company->quotations;
        return view('client.quotations.index', compact('currency', 'products', 'all_quotations', 'quotations', 'outer_clients', 'company'));
    }
    # =============== #

    # view create page #
    public function create()
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);

        /**************************************************************************************/
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
        /**************************************************************************************/

        $categories = $company->categories;
        $all_products = Product::where('company_id', $company_id)->where('first_balance', '>', '0')->get();
        $stores = $company->stores;
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
        $pre_quotation = $quoationsCount = Quotation::where('company_id', $company_id)->count() + 1;
        /*
        $pre_quotation = $company_id . rand();
        $pre_quotation = substr($pre_quotation, 0, 9);
        */
        return view(
            'client.quotations.create',
            compact('company', 'outer_clients', 'units', 'stores', 'categories', 'extra_settings', 'company_id', 'all_products', 'pre_quotation', 'quoationsCount')
        );
    }

    # =============== #

    public function send($id)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $quotation = Quotation::where('quotation_number', $id)->where('company_id', $company_id)->first();
        $tax_value_added = $company->tax_value_added;
        $elements = $quotation->elements;
        $sum = array();
        foreach ($elements as $element) {
            array_push($sum, $element->quantity_price);
        }
        $total = array_sum($sum);
        $previous_extra = QuotationExtra::where('quotation_id', $quotation->id)
            ->where('action', 'extra')->first();
        if (!empty($previous_extra)) {
            $previous_extra_type = $previous_extra->action_type;
            $previous_extra_value = $previous_extra->value;
            if ($previous_extra_type == "percent") {
                $previous_extra_value = $previous_extra_value / 100 * $total;
            }
            $after_discount = $total + $previous_extra_value;
        }
        $previous_discount = QuotationExtra::where('quotation_id', $quotation->id)
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
            'quotation' => $quotation,
            'body' => 'بيانات عرض السعر',
            'elements' => $quotation->elements,
            'extras' => $quotation->extras,
            'subject' => 'مرفق مع هذه الرسالة بيانات تفصيلية لعرض السعر',
            'company' => $company,
            'after_total_all' => $after_total_all,
            'currency' => $currency,
        );
        Mail::to($quotation->outerClient->client_email)->send(new sendingQuotation($data));
        return redirect()->route('client.quotations.index')
            ->with('success', 'تم  ارسال عرض السعر  الى بريد العميل بنجاح');
    }

    public function get_product_price(Request $request)
    {
        $product_id = $request->product_id;
        $outer_client_id = $request->outer_client_id;
        $product = Product::FindOrFail($product_id);
        $outer_client = OuterClient::FindOrFail($outer_client_id);
        $client_category = $outer_client->client_category;
        $sector_price = $product->sector_price;
        $wholesale_price = $product->wholesale_price;
        $first_balance = $product->first_balance;
        if ($client_category == "جملة") {
            $order_price = $wholesale_price;
        } elseif ($client_category == "قطاعى") {
            $order_price = $sector_price;
        }
        return response()->json([
            'order_price' => $order_price,
            'unit_id' => $product->unit->id,
            'first_balance' => $first_balance . ' ' . $product->unit->unit_name
        ]);
    }

    # store quotation #
    public function save(Request $request)
    {
        $data = $request->all();
        $data['company_id'] = Auth::user()->company_id;
        $company = Company::FindOrFail($data['company_id']);
        $data['client_id'] = Auth::user()->id;
        $quotation = Quotation::where('quotation_number', $data['quotation_number'])->where('company_id', $company->id)->first();
        // return json_encode($quotation);
        if (empty($quotation)) {
            $quotation = Quotation::create($data);
        } else {
            $quotation->update($data);
        }
        $data['quotation_id'] = $quotation->id;
        $data['company_id'] = $company->id;

        $check = QuotationElement::where('quotation_id', $quotation->id)
            ->where('product_id', $request->product_id)
            ->where('company_id', $company->id)
            ->first();

        if (empty($check)) {
            $quotation_element = QuotationElement::create($data);
        } else {
            $old_quantity = $check->quantity;
            $new_quantity = $old_quantity + $request->quantity;
            $product_price = $request->product_price;
            $new_quantity_price = $new_quantity * $product_price;
            $unit_id = $request->unit_id;
            $quotation_element = $check->update([
                'product_price' => $product_price,
                'quantity' => $new_quantity,
                'unit_id' => $unit_id,
                'quantity_price' => $new_quantity_price,
            ]);
        }

        if ($quotation && $quotation_element) {
            $all_elements = QuotationElement::where('quotation_id', $quotation->id)->where('company_id', $company->id)->get();
            return response()->json([
                'status' => true,
                'msg' => 'تمت الاضافة الى عرض السعر بنجاح',
                'all_elements' => $all_elements,
            ]);
        } else {
            $all_elements = QuotationElement::where('quotation_id', $quotation->id)->where('company_id', $company->id)->get();
            return response()->json([
                'status' => false,
                'msg' => 'هناك خطأ فى عملية الاضافة',
                'all_elements' => $all_elements,
            ]);
        }
    }

    # =============== #

    public function destroy_element(Request $request)
    {
        $element_id = $request->element_id;
        $element = QuotationElement::FindOrFail($element_id);
        $quotation_id = $element->quotation_id;
        $element->delete();
    }

    public function changeQuotation(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $data = $request->all();
        $quotation_number = $request->quotation_number;
        $quotation = Quotation::where('quotation_number', $quotation_number)->where('company_id', $company_id)->first();
        $quotation->update($data);
        echo "<p class='alert alert-sm alert-success text-center mt-2 mb-2'>تم حفظ البيانات بنجاح</p>";
    }

    public function updateData(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $quotation_number = $request->quotation_number;
        $quotation = Quotation::where('quotation_number', $quotation_number)->where('company_id', $company->id)->first();
        $elements = QuotationElement::where('quotation_id', $quotation->id)->where('company_id', $company->id)->get();
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
            اجمالى عرض السعر
            " . $total . " " . $currency . "
            </div>
            <div class='pull-left col-lg-6 '>
            اجمالى عرض السعر بعد القيمة المضافة
            " . $after_total . " " . $currency . "
            </div>
            <div class='clearfix'></div>";
    }

    public function get_quotation_elements(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $quotation_number = $request->quotation_number;
        // dd($quotation_number);
        $quotation = Quotation::where('quotation_number', $quotation_number)->where('company_id', $company->id)->first();
        $elements = QuotationElement::where('quotation_id', $quotation->id)->where('company_id', $company->id)->get();
        $extras = QuotationExtra::where('quotation_id', $quotation->id)->get();
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $tax_value_added = $company->tax_value_added;
        $sum = array();
        if (!$elements->isEmpty()) {
            echo '<h6 class="alert bg-white p-1 mb-0 text-left font-weight-bold" style="font-size: 16px !important;">جدول المنتجات</h6>';
            $i = 0;
            echo '<table class="defaultTableMain table dataTable no-footer" style="border-radius: 12px !important; overflow: hidden;width: 96%;margin:5px 10px;" >';
            echo "<thead>";
            echo "<th> #</th>";
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
                            <button type='button' quotation_number='" . $element->quotation->quotation_number . "' element_id='" . $element->id . "' class='btn btn-sm btn-info edit_element'>
                                <i class='fa fa-pencil'></i>
                            </button>
                            <button type='button' quotation_number='" . $element->quotation->quotation_number . "' element_id='" . $element->id . "' class='btn btn-sm btn-danger remove_element'>
                                <i class='fa fa-trash'></i>
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
            <div class='alert-sm text-center p-0 w-auto d-inline-block m-1'>
                <div class='w-auto text-left badge badge-info font-weight-bold'>
                     اجمالى المنتجات
                    " . $total . " " . $currency . "
                </div>
                <div class='w-auto text-left badge badge-warning font-weight-bold'>
                    الاجمالي بعد الضريبة
                    " . $after_total . " " . $currency . "
                </div>

            </div>";
        }

        echo "
        <script>
            $('.remove_element').on('click',function(){
                let element_id = $(this).attr('element_id');
                let quotation_number = $(this).attr('quotation_number');

                let discount_type = $('#discount_type').val();
                let discount_value = $('#discount_value').val();

                let extra_type = $('#extra_type').val();
                let extra_value = $('#extra_value').val();

                $.post('/client/quotations/element/delete',
                {'_token': '" . csrf_token() . "', element_id: element_id},
                function (data) {
                    $.post('/client/quotations/elements',
                        {'_token': '" . csrf_token() . "', quotation_number: quotation_number},
                        function (elements) {
                            $('.bill_details').html(elements);
                        });
                    });
                $.post('/client/quotations/discount',
                    {'_token': '" . csrf_token() . "',quotation_number:quotation_number, discount_type: discount_type, discount_value: discount_value},
                    function (data) {
                        $('.after_totals').html(data);
                });

                $.post('/client/quotations/extra',
                    {'_token': '" . csrf_token() . "',quotation_number:quotation_number, extra_type: extra_type, extra_value: extra_value},
                    function (data) {
                        $('.after_totals').html(data);
                });

                $(this).parent().parent().fadeOut(300);
            });

            $('.edit_element').on('click', function () {
                let element_id = $(this).attr('element_id');
                let quotation_number = $(this).attr('quotation_number');
                $.post('/client/quotations/edit-element',
                    {
                        '_token': '" . csrf_token() . "',
                        quotation_number: quotation_number,
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
                        $('#edit').attr('quotation_number', quotation_number);
                    });
                });

        </script>
        ";
    }

    public function apply_discount(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $quotation_number = $request->quotation_number;
        $discount_type = $request->discount_type;
        $discount_value = $request->discount_value;
        $quotation = Quotation::where('quotation_number', $quotation_number)->where('company_id', $company->id)->first();
        $elements = QuotationElement::where('quotation_id', $quotation->id)->where('company_id', $company->id)->get();
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $tax_value_added = $company->tax_value_added;
        $sum = array();

        if (!$elements->isEmpty()) {
            foreach ($elements as $element) {
                array_push($sum, $element->quantity_price);
            }
            $total = array_sum($sum);

            $previous_extra = QuotationExtra::where('quotation_id', $quotation->id)
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
            <div class='text-left badge badge btn-newdark font-weight-bold w-auto mt-1 mx-1'>
                   الاجمالي النهائي :
                    " . $after_total . " " . $currency . "
            </div>";
            $quotation_extra = QuotationExtra::where('quotation_id', $quotation->id)
                ->where('action', 'discount')->first();
            if (empty($quotation_extra)) {
                $quotation_extra = QuotationExtra::create([
                    'quotation_id' => $quotation->id,
                    'action' => 'discount',
                    'action_type' => $discount_type,
                    'value' => $discount_value,
                    'company_id' => $company_id,
                ]);
            } else {
                $quotation_extra->update([
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
        $quotation_number = $request->quotation_number;
        $extra_type = $request->extra_type;
        $extra_value = $request->extra_value;
        $quotation = Quotation::where('quotation_number', $quotation_number)->where('company_id', $company->id)->first();
        $elements = QuotationElement::where('quotation_id', $quotation->id)->where('company_id', $company->id)->get();
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $tax_value_added = $company->tax_value_added;
        $sum = array();
        if (!$elements->isEmpty()) {
            foreach ($elements as $element) {
                array_push($sum, $element->quantity_price);
            }
            $total = array_sum($sum);

            $previous_discount = QuotationExtra::where('quotation_id', $quotation->id)
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
            <div class='text-left badge badge btn-newdark font-weight-bold w-auto mt-1 mx-1'>
                   الاجمالي النهائي :
                    " . $after_total . " " . $currency . "
            </div>";

            $quotation_extra = QuotationExtra::where('quotation_id', $quotation->id)
                ->where('action', 'extra')->first();
            if (empty($quotation_extra)) {
                $quotation_extra = QuotationExtra::create([
                    'quotation_id' => $quotation->id,
                    'action' => 'extra',
                    'action_type' => $extra_type,
                    'value' => $extra_value,
                    'company_id' => $company_id,
                ]);
            } else {
                $quotation_extra->update([
                    'action_type' => $extra_type,
                    'value' => $extra_value,
                ]);
            }
        }
    }

    public function destroy(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $quotation_number = $request->quotation_number;
        $quotation = Quotation::where('quotation_number', $quotation_number)->where('company_id', $company_id)->first();
        $quotation->elements()->delete();
        $quotation->extras()->delete();
        $quotation->delete();
        return redirect()->route('client.quotations.create')
            ->with('success', 'تم حذف عرض السعر بنجاح');
    }

    public function redirect()
    {
        return redirect()->route('client.quotations.index')->with('success', 'تم انشاء عرض السعر بنجاح');
    }

    public function redirectANDprint(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);

        $products = $company->products;
        $quotations = $company->quotations;
        if (in_array('مدير النظام', Auth::user()->role_name)) {
            $outer_clients = OuterClient::where('company_id', $company_id)->get();
        } else {
            $outer_clients = OuterClient::where('company_id', $company_id)
                ->where(function ($query) {
                    $query->where('client_id', Auth::user()->id)
                        ->orWhereNull('client_id');
                })->get();
        }

        $quotation_id = $request->quotation_id;

        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;

        $quotation_k = Quotation::where('quotation_number', $quotation_id)->where('company_id', $company_id)->first();

        $elements = $quotation_k->elements;
        $extras = $quotation_k->extras;
        // dd($quotation_k);
        foreach ($extras as $key) {
            if ($key->action == "discount") {
                if ($key->action_type == "pound") {
                    $quotation_discount_value = $key->value;
                    $quotation_discount_type = "pound";
                } else {
                    $quotation_discount_value = $key->value;
                    $quotation_discount_type = "percent";
                }
            } else {
                if ($key->action_type == "pound") {
                    $quotation_extra_value = $key->value;
                    $quotation_extra_type = "pound";
                } else {
                    $quotation_extra_value = $key->value;
                    $quotation_extra_type = "percent";
                }
            }
        }

        if ($extras->isEmpty()) {
            $quotation_discount_value = 0;
            $quotation_extra_value = 0;
            $quotation_discount_type = "pound";
            $quotation_extra_type = "pound";
        }
        $tax_value_added = $company->tax_value_added;
        $sum = array();
        foreach ($elements as $element) {
            array_push($sum, $element->quantity_price);
        }
        $total = array_sum($sum);

        $previous_extra = QuotationExtra::where('quotation_id', $quotation_k->id)
            ->where('action', 'extra')->first();
        if (!empty($previous_extra)) {
            $previous_extra_type = $previous_extra->action_type;
            $previous_extra_value = $previous_extra->value;
            if ($previous_extra_type == "percent") {
                $previous_extra_value = $previous_extra_value / 100 * $total;
            }
            $after_discount = $total + $previous_extra_value;
        }


        $previous_discount = QuotationExtra::where('quotation_id', $quotation_k->id)
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
        /*
        return view('client.quotations.sample',
            compact('company_id', 'currency', 'after_discount', 'after_total_all', 'quotation_k', 'quotations', 'outer_clients'
                , 'elements', 'extras', 'products', 'company', 'quotation_discount_value', 'quotation_discount_type', 'quotation_extra_value', 'quotation_extra_type'));
        */
        return redirect()->route('client.quotations.view', $quotation_k->quotation_number)->with('success', 'تم انشاء عرض السعر بنجاح');
    }

    public function get_outer_client_details(Request $request)
    {
        $outer_client_id = $request->outer_client_id;
        $outer_client = OuterClient::FindOrFail($outer_client_id);
        if ($outer_client->prev_balance > 0) {
            $balance = "عليه " . floatval($outer_client->prev_balance);
        } elseif ($outer_client->prev_balance < 0) {
            $balance = "له " . floatval(abs($outer_client->prev_balance));
        } else {
            $balance = 0;
        }
        echo "<div class='col-lg-4 pull-right'>" . "الفئة : " . $outer_client->client_category . '</div>';
        echo "<div class='col-lg-4 pull-right'>" . " مديونية العميل : " . $balance . '</div>';
        echo "<div class='col-lg-4 pull-right'>" . " الجنسية : " . $outer_client->client_national . '</div>';
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
        $quotation = Quotation::findOrFail($id);
        $categories = $company->categories;
        $all_products = $company->products;
        $stores = $company->stores;
        $units = $company->units;
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        if (in_array('مدير النظام', Auth::user()->role_name)) {
            $outer_clients = OuterClient::where('company_id', $company_id)->get();
        } else {
            $outer_clients = OuterClient::where('company_id', $company_id)
                ->where(function ($query) {
                    $query->where('client_id', Auth::user()->id)
                        ->orWhereNull('client_id');
                })->get();
        }
        $safes = $company->safes;
        $banks = $company->banks;
        return view(
            'client.quotations.edit',
            compact(
                'quotation',
                'categories',
                'units',
                'all_products',
                'stores',
                'extra_settings',
                'safes',
                'banks',
                'outer_clients',
                'company_id',
                'company'
            )
        );
    }

    public function delete_bill(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $client_id = Auth::user()->id;
        $bill_id = $request->billid;
        $quotation = Quotation::FindOrFail($bill_id);
        $elements = $quotation->elements;
        $extras = $quotation->extras;
        $quotation->elements()->delete();
        $quotation->extras()->delete();
        $quotation->delete();
        return redirect()->back()
            ->with('success', 'تم حذف عرض السعر  بنجاح');
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
        $element = QuotationElement::FindOrFail($element_id);
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
        $element = QuotationElement::FindOrFail($request->element_id);
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

    public function convert_to_salebill($id, $isMoswada = null, $printColor = null)
    {
        # get quotation details #
        $quotation = Quotation::FindOrFail($id);
        $quotation_elements = $quotation->elements;
        $quotation_extras = $quotation->extras;
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);
        $client_id = Auth::user()->id;

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

        $date = date('Y-m-d');
        $time = date('H:i:s');
        $status = "done";
        $paid = "0";

        $tax_value_added = $company->tax_value_added;
        $sum = array();
        foreach ($quotation_elements as $element) {
            array_push($sum, $element->quantity_price);
        }
        $total = array_sum($sum);
        $previous_extra = QuotationExtra::where('quotation_id', $quotation->id)
            ->where('action', 'extra')->first();
        if (!empty($previous_extra)) {
            $previous_extra_type = $previous_extra->action_type;
            $previous_extra_value = $previous_extra->value;
            if ($previous_extra_type == "percent") {
                $previous_extra_value = ($previous_extra_value / 100) * $total;
            }
            $after_discount = $total + $previous_extra_value;
        }
        $previous_discount = QuotationExtra::where('quotation_id', $quotation->id)
            ->where('action', 'discount')->first();
        if (!empty($previous_discount)) {
            $previous_discount_type = $previous_discount->action_type;
            $previous_discount_value = $previous_discount->value;
            if ($previous_discount_type == "percent") {
                $previous_discount_value = ($previous_discount_value / 100) * $total;
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

        $sale_bill = SaleBill::create([
            'company_id' => $company_id,
            'client_id' => $client_id,
            'company_counter' => $pre_counter,
            'outer_client_id' => $quotation->outer_client_id,
            'sale_bill_number' => $pre_bill,
            'token' => $this->createHashToken(30),
            'date' => $date,
            'time' => $time,
            'status' => $status,
            'final_total' => $final_total,
            'paid' => $paid,
            'rest' => $rest,
        ]);

        foreach ($quotation_elements as $element) {
            $salebill_element = SaleBillElement::create([
                'sale_bill_id' => $sale_bill->id,
                'company_id' => $company_id,
                'product_id' => $element->product_id,
                'product_price' => $element->product_price,
                'quantity' => $element->quantity,
                'quantity_price' => $element->quantity_price,
                'unit_id' => $element->unit_id
            ]);
        }
        foreach ($quotation_extras as $extra) {
            $saleBill_extra = SaleBillExtra::create([
                'company_id' => $company_id,
                'sale_bill_id' => $sale_bill->id,
                'action' => $extra->action,
                'action_type' => $extra->action_type,
                'value' => $extra->value,
            ]);
        }
        $shipping = \App\Models\SaleBillExtra::where('sale_bill_id', $sale_bill->id)->where('company_id', $sale_bill->company_id)->where('action', 'extra')->first();
        $discount = SaleBillExtra::where('sale_bill_id', $sale_bill->id)->where('company_id', $sale_bill->company_id)->where('action', 'discount')->first();
        $extra_settings = ExtraSettings::where('company_id', $company_id)->first();
        $currency = $extra_settings->currency;
        $tax_value_added = $company->tax_value_added;
        $elements = SaleBillElement::where('sale_bill_id', $sale_bill->id)
            ->where('company_id', $sale_bill->company_id)
            ->get();

        $total = [];
        foreach ($elements as $element) {
            array_push($total, $element->quantity_price);
        }
        $realtotal = array_sum($total);
        $total = $realtotal;

        if ($discount && $discount->action_type) {
            if ($discount->action_type == "poundAfterTax" || $discount->action_type == "poundAfterTaxPercent") {
                $sumWithOutTax = $sale_bill->value_added_tax ? round($total * 20 / 23, 2) : round($total, 2);
                $sumWithTax = $sale_bill->value_added_tax ? $total : round($total + $realtotal * 15 / 100, 2);
                $totalTax = round($sumWithTax - $sumWithOutTax, 2);
            } else {
                $sumWithOutTax = $sale_bill->value_added_tax ? round($total * 20 / 23, 2) : round($total, 2);
                $sumWithTax = $sale_bill->value_added_tax ? $total : round($total + $total * 15 / 100, 2);
                $totalTax = round($sumWithTax - $sumWithOutTax, 2);
            }
            $discountNote = $discount->discount_note ?? '';
        } else {
            $sumWithOutTax = round($total, 2);
            $sumWithTax = round($total + ($total * ($tax_value_added / 100)), 2);
            $totalTax = round($sumWithTax - $sumWithOutTax, 2);
            $discountNote = '';
        }

        if ($discount) {
            if ($discount->action_type == "pound") {
                $discountValue = $discount->value;
                if (isset($shippingValue) && $shippingValue != 0) {
                    $after_discount = $total - $discount->value + $shippingValue;
                } else {
                    $after_discount = $total - $discount->value;
                }
            } else if ($discount->action_type == "percent") {
                $discountValue = ($discount->value / 100) * $total;
                if (isset($shippingValue) && $shippingValue != 0) {
                    $after_discount = $total - $discountValue + $shippingValue;
                } else {
                    $after_discount = $total - $discountValue;
                }
            } else if ($discount->action_type == "afterTax") {
                $discountValue = ($discount->value / 100) * $total; // 10 / 100*100
                if (isset($shippingValue) && $shippingValue != 0) {
                    $after_discount = $total - $discountValue + $tax_value_added;
                } else {
                    $after_discount = $total - $discountValue;
                }
            } else if ($discount->action_type == "poundAfterTaxPercent") {
                $discountValue = (($discount->value * $total) / 100);
                $after_discount = $total - $discountValue;
            } else {
                $discountValue = $discount->value;
                $after_discount = $total - $discountValue;
            }
        } else {
            $after_discount = $total;
        }

        return view(
            'client.sale_bills.main',
            compact('isMoswada', 'realtotal', 'discountValue',
                'sumWithOutTax', 'discountNote', 'elements', 'printColor', 'sale_bill', 'currency', 'company', 'sumWithTax', 'totalTax')
        );
    }



    // view quotation template
    // view quotation template
    public function view($quotation_id)
    {
        # get company data #
        $company_id = Auth::user()->company_id;
        $company = Company::FindOrFail($company_id);

        # get quotation data #
        $quotation = Quotation::where('quotation_number', $quotation_id)->where('company_id', $company_id)->firstOrFail();
        $products = QuotationElement::where('quotation_id', $quotation->id)->where('company_id', $company_id)->get();

        # chk for totalPrice for Products #
        $elements = $quotation->elements;
        $productsTotal = array();
        foreach ($elements as $element) {
            array_push($productsTotal, $element->quantity_price);
        }
        $productsTotal = array_sum($productsTotal);

        # chk for discount #
        $totalQuotaitonPrice = 0;
        $discount = QuotationExtra::where('quotation_id', $quotation->id)
            ->where('action', 'discount')->first();
        if (!empty($discount)) {
            $discount_type = $discount->action_type;
            $discount_value = $discount->value;
            if ($discount_type == "percent") {
                $discount_value = $discount_value / 100 * $productsTotal;
            }
            $totalQuotaitonPrice = $productsTotal - $discount_value;
        }

        # calc tax #
        $tax_value_added = $company->tax_value_added;
        $taxValue = 0;
        if ($tax_value_added != 0) {
            $taxValue = $totalQuotaitonPrice * $tax_value_added / 100;
            $totalQuotaitonPrice += $taxValue;
        }
        # chk for shipping #
        $shipping = QuotationExtra::where('quotation_id', $quotation->id)
            ->where('action', 'extra')->first();
        if (!empty($shipping)) {
            $shipping_type = $shipping->action_type;
            $shipping_value = $shipping->value;
            if ($shipping_type == "percent") {
                $shipping_value = $shipping_value / 100 * $totalQuotaitonPrice;
            }
            $totalQuotaitonPrice = $totalQuotaitonPrice + $shipping_value;
        }

        return view(
            'client.quotations.sample',
            compact(
                'company',
                'quotation',
                'totalQuotaitonPrice',
                'taxValue',
                'shipping_value',
                'discount_value',
                'productsTotal',
                'tax_value_added',
                'products'
            )
        );
    }



    public function updateConditions(Request $request)
    {
        return BasicSettings::where('company_id', Auth::user()->company_id)->firstOrFail()->update(['quotation_condition' => $request->condition]) ? 1 : 0;
    }
}
