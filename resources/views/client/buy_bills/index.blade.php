@extends('client.layouts.app-main')
<style>
    .content-body{
        background-color: white;
        padding: 5px;
    }
    .bootstrap-select {
        width: 75% !important;
        height: 40px !important;
    }

    .btn {
        height: 40px !important;
    }

    .btn-sm {
        height: 30px !important;
        padding: 5px !important;
    }
    .dropdown-toggle::after {

    position: absolute !important;
    
}
</style>
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissable fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif

    <h4  class="alert  text-end no-print custom-title fw-bold"> {{ __('sidebar.previous-purchases-invoices') }} </h4>
    <div class=" row ">
        <div class="col-lg-6  no-print">
            <form action="{{ route('client.buy_bills.filter.key') }}" method="POST">
                @csrf
                @method('POST')
                <div class="form-group">
                    <label class="px-1" style="display:block;" for="bill_id">{{ __('sales_bills.invoice-number') }}</label>
                    <div class="d-flex">
                        <select required class="selectpicker form-control mx-1" data-live-search="true" title="{{ __('main.write-or-choose') }}"
                        data-style="btn-third" name="buy_bill_id" id="buy_bill_id">
                        @foreach ($buy_bills as $buy_bill)
                            <option title="{{ $buy_bill->buy_bill_number }}" @if (isset($buy_bill_k) && $buy_bill->id == $buy_bill_k->id) selected @endif
                                value="{{ $buy_bill->id }}">{{ $buy_bill->buy_bill_number }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-md btn-warning text-center px-2"
                        style="display: inline !important; float: left !important;" id="by_buy_bill_id"><i
                            class="fa fa-search"></i>
                    </button>
                    </div>
                </div>
            </form>
        </div>
    
        <div class="col-lg-6 no-print">
            <form action="{{ route('client.buy_bills.filter.supplier') }}" method="POST">
                @csrf
                @method('POST')
                <div class="form-group">
                    <label class="px-1" style="display:block;" for="supplier_id">{{ __('suppliers.supplier-name') }}</label>
                    <div class="d-flex">
                        <select required class="selectpicker form-control mx-1" data-live-search="true" title="{{ __('main.write-or-choose') }}"
                        data-style="btn-third" name="supplier_id" id="supplier_id">
                        @foreach ($suppliers as $supplier)
                            <option title="{{ $supplier->supplier_name }}" @if (isset($supplier_k) && $supplier->id == $supplier_k->id) selected @endif
                                value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                        @endforeach
                        </select>
                        <button type="submit" class="btn btn-md btn-warning text-center px-2"
                            style="display: inline !important; float: left !important;" id="by_supplier_id"><i
                            class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-6 no-print">
            <form action="{{ route('client.buy_bills.filter.code') }}" method="POST">
                @csrf
                @method('POST')
                <div class="form-group">
                    <label class="px-1" style="display:block;" for="code_universal">{{ __('sales_bills.product-code') }}</label>
                    <div class="d-flex">
                        <select required class="selectpicker form-control mx-1" data-live-search="true" title="{{ __('main.write-or-choose') }}"
                        data-style="btn-third" name="code_universal" id="code_universal">
                        @foreach ($products as $product)
                            <option title="{{ $product->code_universal }}" @if (isset($product_k) && $product->id == $product_k->id) selected @endif
                                value="{{ $product->id }}">{{ $product->code_universal }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-md btn-warning text-center px-2"
                        style="display: inline !important; float: left !important;"
                        id="by_code_universal"><i class="fa fa-search"></i>
                    </button>
                    </div>
                </div>
            </form>
        </div>
    
        <div class="col-lg-6  no-print">
            <form action="{{ route('client.buy_bills.filter.product') }}" method="POST">
                @csrf
                @method('POST')
                <div class="form-group">
                    <label class="px-1" style="display:block;" for="product_name">{{ __('sales_bills.product-name') }}</label>
                    <div class="d-flex">
                        <select required class="selectpicker form-control mx-1" data-live-search="true" title="{{ __('main.write-or-choose') }}"
                        data-style="btn-third" name="product_name" id="product_name">
                        @foreach ($products as $product)
                            <option title="{{ $product->product_name }}" @if (isset($product_k) && $product->id == $product_k->id) selected @endif
                                value="{{ $product->id }}">{{ $product->product_name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-md btn-warning text-center px-2"
                        style="display: inline !important; float: left !important;"
                        id="by_product_name"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-6 no-print">
            <form action="{{ route('client.buy_bills.filter.storeId') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="px-1" style="display:block;" for="store_id">{{ __('sales_bills.store-name') }}</label>
                    <div class="d-flex">
                        <select required class="selectpicker form-control mx-1" data-live-search="true" title="{{ __('main.write-or-choose') }}"
                        data-style="btn-third" name="store_id" id="store_id">
                        @if(isset($stores) && $stores->count())
                        @foreach ($stores as $store)
                            <option title="{{ $store->store_name }}" value="{{ $store->id }}">
                                {{ $store->store_name }}
                            </option>
                        @endforeach
                    @else
                        <option disabled>No stores available</option>
                    @endif
                    </select>
                    <button type="submit" class="btn btn-warning text-center px-2"
                        style="display: inline !important; float: left !important;"
                        id="by_product_name"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="row" style="margin-top: 30px !important;">
        <div class="col-lg-12 text-end px-3">
            <form action="{{ route('client.buy_bills.filter.all') }}" method="POST">
                @csrf
                @method('POST')
                <button type="submit" class="btn btnn btn-md btn-warning">
                    <i class="fa fa-list"></i>
                    {{ __('sidebar.purchases-invoices') }}
                </button>
            </form>
        </div>

    </div>

    <input type="hidden" id="total" name="total" />
    <div class="company_details printy" style="display: none;">
        <div class="text-center">
            <img class="logo" style="width: 20%;" src="{{ asset($company->company_logo) }}" alt="">
        </div>
        <div class="text-center">
            <div class="col-lg-12 text-center justify-content-center">
                <p class="alert alert-secondary text-center alert-sm"
                    style="margin: 10px auto; font-size: 17px;line-height: 1.9;" dir="rtl">
                    {{ $company->company_name }} -- {{ $company->business_field }} <br>
                    {{ $company->company_owner }} -- {{ $company->phone_number }} <br>
                </p>
            </div>
        </div>
    </div>
    <div id="bill_details">
        <div class="clearfix"></div>
        @if (isset($buy_bill_k) && !empty($buy_bill_k))
            <h6 class="alert alert-sm alert-danger text-center">
                <i class="fa fa-info-circle"></i>
                بيانات عناصر الفاتورة رقم
                {{ $buy_bill_k->buy_bill_number }}
            </h6>
            <div class="col-lg-12 mb-1  alert alert-secondary alert-sm">
                <div class="col-3 pull-right">
                    رقم الفاتورة :
                    {{ $buy_bill_k->buy_bill_number }}
                </div>
                <div class="col-3 pull-right">
                    تاريخ الفاتورة :
                    {{ $buy_bill_k->date }}
                </div>
                <div class="col-3 pull-right">
                    وقت الفاتورة :
                    {{ $buy_bill_k->time }}
                </div>
                <div class="col-3 pull-right">
                    ملاحظات الفاتورة :
                    {{ $buy_bill_k->notes }}
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="col-lg-12 mb-1  alert alert-secondary alert-sm">
                <div class="col-4 pull-right">
                    اسم المورد :
                    {{ $buy_bill_k->supplier->supplier_name }}
                </div>
                <div class="col-4 pull-right">
                    عنوان المورد :

                </div>
                <div class="col-4 pull-right">
                    تليفون المورد :
                    @if (!$buy_bill_k->supplier->phones->isEmpty())
                        {{ $buy_bill_k->supplier->phones[0]->supplier_phone }}
                    @endif
                </div>
                <div class="clearfix"></div>
            </div>

            <?php
            $tax_value_added = $company->tax_value_added;
            $sum = array();
            if (!$elements->isEmpty()) {
            $i = 0;
            echo "<table class='table table-condensed table-striped table-bordered'>";
            echo "<thead>";
            echo "<th>  # </th>";
            echo "<th> اسم المنتج </th>";
            echo "<th> سعر الوحدة </th>";
            echo "<th> الكمية </th>";
            echo "<th>  الاجمالى </th>";
            echo "<th class='no-print'>  ارتجاع </th>";
            echo "</thead>";
            echo "<tbody>";
            foreach ($elements as $element) {
            array_push($sum, $element->quantity_price);
            echo "<tr>";
            echo "<td>" . ++$i . "</td>";
            echo "<td>" . $element->product->product_name . "</td>";
            echo "<td>" . floatval($element->product_price) . "</td>";
            echo "<td>" . floatval($element->quantity) . " " . $element->unit->unit_name . "</td>";
            echo "<td>" . floatval($element->quantity_price) . "</td>";
            echo "<td class='no-print'>
                    <form action='/client/buy-bills/get-return' method='post'>
                        <input type='hidden' value='" . $element->BuyBill->id . "' name='buy_bill_id' />
                        <input type='hidden' value='" . $element->id . "' name='element_id' />
                        "; ?> @csrf
            <?php
            echo "
                    <button type='submit'
                       class='btn btn-md btn-danger remove_element'>
                        <i class='fa fa-refresh'></i> ارتجاع
                    </button>
                    </form>
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
                <div class='alert alert-dark alert-sm text-center before_totals'>
                    <div class='pull-right col-6 '>
                        اجمالى الفاتورة
                        " . floatval($total) . " " . $currency . "
                    </div>
                    <div class='pull-left col-6 '>
                        اجمالى الفاتورة بعد القيمة المضافة
                        " . floatval($after_total) . " " . $currency . "
                    </div>
                    <div class='clearfix'></div>
                </div>";
            echo "
                <div class='clearfix'></div>
                <div class='alert alert-dark alert-sm text-center'>";
            foreach ($extras as $key) {
                if ($key->action == "discount") {
                    echo "<div class='pull-right col-6 '>";
                    if ($key->action_type == "pound") {
                        echo " خصم " . $key->value . " " . $currency;
                    } else {
                        echo " خصم " . $key->value . " % ";
                    }
                    echo "</div>";
                } else {
                    echo "<div class='pull-right col-6 '>";
                    if ($key->action_type == "pound") {
                        echo " مصاريف شحن " . $key->value . " " . $currency;
                    } else {
                        echo " مصاريف شحن " . $key->value . " % ";
                    }
                    echo "</div>";
                }
            }
            echo "<div class='clearfix'></div>";
            echo "</div>";
            echo "
                <div class='clearfix'></div>
                <div class='col-lg-12 col-md-12 col-sm-12 after_totals'>
                    <div class='alert alert-secondary alert-sm text-center'>
                           اجمالى الفاتورة النهائى بعد الضريبة والشحن والخصم :
                            " . floatval($after_total_all) . " " . $currency . "
                    </div>
                </div>";
            if (!empty($cash)) {
                echo "<div class='clearfix'></div>
                <div class='col-lg-12 col-md-12 col-sm-12'>
                    <div class='alert alert-secondary alert-sm text-center'>
                           المبلغ المدفوع :
                            " . floatval($cash->amount) . " " . $currency . "
                    </div>
                </div>";
            }
            echo '
               <div class="col-lg-12 no-print" style="padding-top: 25px;height: 40px !important;">';
            ?>
            <a target="_blank" role="button" href="{{ route('client.buy_bills.print', $buy_bill_k->buy_bill_number) }}"
                class="btn btn-md btn-info print_btn pull-right"><i class="fa fa-print"></i> طباعة فاتورة المشتريات
            </a>
            @if (!empty($buy_bill_k->supplier->supplier_email))
                <a role="button" href="{{ route('client.buy_bills.send', $buy_bill_k->buy_bill_number) }}"
                    class="btn btn-md btn-warning pull-right ml-2"><i class="fa fa-envelope"></i>
                    ارسال الفاتورة الى بريد المورد
                </a>
            @else
                <span class="alert alert-sm pull-right ml-2 alert-warning text-center">
                    خانه البريد الالكترونى للمورد فارغة
                </span>
            @endif

            @if (!$buy_bill_k->supplier->phones->isEmpty())
                <?php
                $url = 'https://' . request()->getHttpHost() . '/buy-bills/print/' . $buy_bill_k->buy_bill_number;
                $text = 'مرفق رابط لفاتورة مشتريات ' . '%0a' . $url;
                $text = str_replace('&', '%26', $text);
                $phone_number = $buy_bill_k->supplier->phones[0]->supplier_phone;
                ?>
                <a class="btn btn-md btn-success pull-right ml-2" target="_blank"
                    href="https://wa.me/{{ $phone_number }}?text={{ $text }}">
                    ارسال الفاتورة الى واتساب المورد
                </a>
            @else
                <span class="alert alert-sm alert-warning pull-right ml-2 text-center">
                    خانه رقم الهاتف للمورد فارغة
                </span>
            @endif

            <?php echo '
                    <button bill_id="' . $buy_bill_k->id . '" buy_bill_number="' . $buy_bill_k->supplier->supplier_name . '"
                        data-toggle="modal" href="#modaldemo9" title="delete"
                        type="button" class="modal-effect ml-2 btn btn-md btn-danger delete_bill pull-right">
                        <i class="fa fa-trash"></i>
                        حذف الفاتورة
                    </button>

                    <a href="' . route("client.buy_bills.edit", $buy_bill_k->id) . '" role="button" class="ml-2 btn btn-md btn-success pull-right">
                        <i class="fa fa-trash"></i>
                        تعديل الفاتورة
                    </a>
                </div>';
            }
            ?>
        @endif
        @if (isset($supplier_buy_bills))
            @if (!$supplier_buy_bills->isEmpty())
                <div class="alert alert-sm alert-success text-center mt-1 mb-2">
                    الفواتير المتاحة لـ
                    {{ $supplier_k->supplier_name }}
                </div>
                <table class='table table-condensed table-striped table-bordered'>
                    <thead class="text-center">
                        <th>#</th>
                        <th>رقم الفاتورة</th>
                        <th>تاريخ الفاتورة</th>
                        <th> وقت الفاتورة</th>
                        <th>اسم المورد</th>
                        <th>اسم المخزن</th>
                        <th>الاجمالى النهائى</th>
                        <th>عدد العناصر</th>
                        <th>عرض</th>
                    </thead>
                    <tbody>
                        <?php $i = 0;
                        $total = 0; ?>
                        @foreach ($supplier_buy_bills as $buy_bill)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $buy_bill->buy_bill_number }}</td>
                                <td>{{ $buy_bill->date }}</td>
                                <td>{{ $buy_bill->time }}</td>
                                <td>{{ $buy_bill->supplier->supplier_name }}</td>
                                <td>{{ $buy_bill->store->store_name }}</td>

                                <td>
                                    <?php $sum = 0; ?>
                                    @foreach ($buy_bill->elements as $element)
                                        <?php $sum = $sum + $element->quantity_price; ?>
                                    @endforeach
                                    <?php
                                    $extras = $buy_bill->extras;
                                    foreach ($extras as $key) {
                                        if ($key->action == 'discount') {
                                            if ($key->action_type == 'pound') {
                                                $buy_bill_discount_value = $key->value;
                                                $buy_bill_discount_type = 'pound';
                                            } else {
                                                $buy_bill_discount_value = $key->value;
                                                $buy_bill_discount_type = 'percent';
                                            }
                                        } else {
                                            if ($key->action_type == 'pound') {
                                                $buy_bill_extra_value = $key->value;
                                                $buy_bill_extra_type = 'pound';
                                            } else {
                                                $buy_bill_extra_value = $key->value;
                                                $buy_bill_extra_type = 'percent';
                                            }
                                        }
                                    }
                                    if ($extras->isEmpty()) {
                                        $buy_bill_discount_value = 0;
                                        $buy_bill_extra_value = 0;
                                        $buy_bill_discount_type = 'pound';
                                        $buy_bill_extra_type = 'pound';
                                    }
                                    if ($buy_bill_extra_type == 'percent') {
                                        $buy_bill_extra_value = ($buy_bill_extra_value / 100) * $sum;
                                    }
                                    $after_discount = $sum + $buy_bill_extra_value;

                                    if ($buy_bill_discount_type == 'percent') {
                                        $buy_bill_discount_value = ($buy_bill_discount_value / 100) * $sum;
                                    }
                                    $after_discount = $sum - $buy_bill_discount_value;
                                    $after_discount = $sum - $buy_bill_discount_value + $buy_bill_extra_value;
                                    $tax_value_added = $company->tax_value_added;
                                    $percentage = ($tax_value_added / 100) * $after_discount;
                                    $after_total = $after_discount + $percentage;
                                    echo floatval($after_total) . ' ' . $currency;
                                    ?>
                                    <?php $total = $total + $after_total; ?>
                                </td>
                                <td>{{ $buy_bill->elements->count() }}</td>
                                <td>
                                    <form class="d-inline" action="{{ route('client.buy_bills.filter.key') }}"
                                        method="POST">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" name="buy_bill_id" value="{{ $buy_bill->id }}">
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="fa fa-eye"></i> عرض
                                        </button>
                                    </form>
                                    <button bill_id="{{ $buy_bill->id }}"
                                        buy_bill_number="{{ $buy_bill->buy_bill_number }}" data-toggle="modal"
                                        href="#modaldemo9" title="delete" type="button"
                                        class="modal-effect btn btn-sm btn-danger delete_bill d-inline">
                                        <i class="fa fa-trash"></i>
                                        حذف
                                    </button>

                                    <a href="{{ route('client.buy_bills.edit', $buy_bill->id) }}" role="button"
                                        class="btn btn-sm btn-success d-inline">
                                        <i class="fa fa-trash"></i>
                                        تعديل
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    <span class="alert alert-secondary alert-sm mr-5">
                        عدد الفواتير المتاحة لهذا المورد
                        ( {{ $i }} )
                    </span>

                    <span class="alert alert-secondary alert-sm">
                        اجمالى اسعار كل الفواتير لهذا المورد
                        ( {{ floatval($total) }} ) {{ $currency }}
                    </span>
                </div>
            @else
                <div class="alert alert-sm alert-danger text-center mt-3">
                    <i class="fa fa-close"></i>
                    لا توجد اى فواتير لهذا المورد
                </div>
            @endif
        @endif
        @if (isset($store_buy_bills))
            @if (!$store_buy_bills->isEmpty())
                {{-- <div class="alert alert-sm alert-success text-center mt-1 mb-2">
                    الفواتير المتاحة لـ
                    {{ $store_k->store_name }}
                </div> --}}
                <table class='table table-condensed table-striped table-bordered'>
                    <thead class="text-center">
                        <th>#</th>
                        <th>رقم الفاتورة</th>
                        <th>تاريخ الفاتورة</th>
                        <th> وقت الفاتورة</th>
                        <th>اسم المورد</th>
                        <th>اسم المخزن</th>
                        <th>الاجمالى النهائى</th>
                        <th>عدد العناصر</th>
                        <th>عرض</th>
                    </thead>
                    <tbody>
                        <?php $i = 0;
                        $total = 0; ?>
                        @foreach ($store_buy_bills as $buy_bill)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $buy_bill->buy_bill_number }}</td>
                                <td>{{ $buy_bill->date }}</td>
                                <td>{{ $buy_bill->time }}</td>
                                <td>{{ $buy_bill->supplier->supplier_name }}</td>
                                <td>{{ $buy_bill->store->store_name }}</td>
                                <td>
                                    <?php $sum = 0; ?>
                                    @foreach ($buy_bill->elements as $element)
                                        <?php $sum = $sum + $element->quantity_price; ?>
                                    @endforeach
                                    <?php
                                    $extras = $buy_bill->extras;
                                    foreach ($extras as $key) {
                                        if ($key->action == 'discount') {
                                            if ($key->action_type == 'pound') {
                                                $buy_bill_discount_value = $key->value;
                                                $buy_bill_discount_type = 'pound';
                                            } else {
                                                $buy_bill_discount_value = $key->value;
                                                $buy_bill_discount_type = 'percent';
                                            }
                                        } else {
                                            if ($key->action_type == 'pound') {
                                                $buy_bill_extra_value = $key->value;
                                                $buy_bill_extra_type = 'pound';
                                            } else {
                                                $buy_bill_extra_value = $key->value;
                                                $buy_bill_extra_type = 'percent';
                                            }
                                        }
                                    }
                                    if ($extras->isEmpty()) {
                                        $buy_bill_discount_value = 0;
                                        $buy_bill_extra_value = 0;
                                        $buy_bill_discount_type = 'pound';
                                        $buy_bill_extra_type = 'pound';
                                    }
                                    if ($buy_bill_extra_type == 'percent') {
                                        $buy_bill_extra_value = ($buy_bill_extra_value / 100) * $sum;
                                    }
                                    $after_discount = $sum + $buy_bill_extra_value;

                                    if ($buy_bill_discount_type == 'percent') {
                                        $buy_bill_discount_value = ($buy_bill_discount_value / 100) * $sum;
                                    }
                                    $after_discount = $sum - $buy_bill_discount_value;
                                    $after_discount = $sum - $buy_bill_discount_value + $buy_bill_extra_value;
                                    $tax_value_added = $company->tax_value_added;
                                    $percentage = ($tax_value_added / 100) * $after_discount;
                                    $after_total = $after_discount + $percentage;
                                    echo floatval($after_total) . ' ' . $currency;
                                    ?>
                                    <?php $total = $total + $after_total; ?>
                                </td>
                                <td>{{ $buy_bill->elements->count() }}</td>
                                <td>
                                    <form class="d-inline" action="{{ route('client.buy_bills.filter.key') }}"
                                        method="POST">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" name="buy_bill_id" value="{{ $buy_bill->id }}">
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="fa fa-eye"></i> عرض
                                        </button>
                                    </form>
                                    <button bill_id="{{ $buy_bill->id }}"
                                        buy_bill_number="{{ $buy_bill->buy_bill_number }}" data-toggle="modal"
                                        href="#modaldemo9" title="delete" type="button"
                                        class="modal-effect btn btn-sm btn-danger delete_bill d-inline">
                                        <i class="fa fa-trash"></i>
                                        حذف
                                    </button>

                                    <a href="{{ route('client.buy_bills.edit', $buy_bill->id) }}" role="button"
                                        class="btn btn-sm btn-success d-inline">
                                        <i class="fa fa-trash"></i>
                                        تعديل
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    <span class="alert alert-secondary alert-sm mr-5">
                        عدد الفواتير المتاحة لهذا المورد
                        ( {{ $i }} )
                    </span>

                    <span class="alert alert-secondary alert-sm">
                        اجمالى اسعار كل الفواتير لهذا المورد
                        ( {{ floatval($total) }} ) {{ $currency }}
                    </span>
                </div>
            @else
                <div class="alert alert-sm alert-danger text-center mt-3">
                    <i class="fa fa-close"></i>
                    لا توجد اى فواتير لهذا المورد
                </div>
            @endif
        @endif

        @if (isset($product_buy_bills))
            @if (!$product_buy_bills->isEmpty())
                <div class="alert alert-sm alert-success text-center mt-1 mb-2">
                    الفواتير المتاحة لـ
                    {{ $product_k->product_name }}
                </div>
                <table class='table table-condensed table-striped table-bordered'>
                    <thead class="text-center">
                        <th>#</th>
                        <th>رقم الفاتورة</th>
                        <th>اسم المورد</th>
                        <th>تاريخ الفاتورة</th>
                        <th> وقت الفاتورة</th>
                        <th>الاجمالى النهائى</th>
                        <th>عدد العناصر</th>
                        <th style="width: 30% !important;">عرض</th>
                    </thead>
                    <tbody>
                        <?php $i = 0;
                        $total = 0; ?>
                        @foreach ($product_buy_bills as $buy_bill)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $buy_bill->buy_bill_number }}</td>
                                <td>{{ $buy_bill->store->store_name }}</td>
                                <td>{{ $buy_bill->date }}</td>
                                <td>{{ $buy_bill->time }}</td>
                                <td>
                                    <?php $sum = 0; ?>
                                    @foreach ($buy_bill->elements as $element)
                                        <?php $sum = $sum + $element->quantity_price; ?>
                                    @endforeach
                                    <?php
                                    $extras = $buy_bill->extras;
                                    foreach ($extras as $key) {
                                        if ($key->action == 'discount') {
                                            if ($key->action_type == 'pound') {
                                                $buy_bill_discount_value = $key->value;
                                                $buy_bill_discount_type = 'pound';
                                            } else {
                                                $buy_bill_discount_value = $key->value;
                                                $buy_bill_discount_type = 'percent';
                                            }
                                        } else {
                                            if ($key->action_type == 'pound') {
                                                $buy_bill_extra_value = $key->value;
                                                $buy_bill_extra_type = 'pound';
                                            } else {
                                                $buy_bill_extra_value = $key->value;
                                                $buy_bill_extra_type = 'percent';
                                            }
                                        }
                                    }
                                    if ($extras->isEmpty()) {
                                        $buy_bill_discount_value = 0;
                                        $buy_bill_extra_value = 0;
                                        $buy_bill_discount_type = 'pound';
                                        $buy_bill_extra_type = 'pound';
                                    }
                                    if ($buy_bill_extra_type == 'percent') {
                                        $buy_bill_extra_value = ($buy_bill_extra_value / 100) * $sum;
                                    }
                                    $after_discount = $sum + $buy_bill_extra_value;

                                    if ($buy_bill_discount_type == 'percent') {
                                        $buy_bill_discount_value = ($buy_bill_discount_value / 100) * $sum;
                                    }
                                    $after_discount = $sum - $buy_bill_discount_value;
                                    $after_discount = $sum - $buy_bill_discount_value + $buy_bill_extra_value;
                                    $tax_value_added = $company->tax_value_added;
                                    $percentage = ($tax_value_added / 100) * $after_discount;
                                    $after_total = $after_discount + $percentage;
                                    echo floatval($after_total) . ' ' . $currency;
                                    ?>
                                    <?php $total = $total + $after_total; ?>
                                </td>
                                <td>{{ $buy_bill->elements->count() }}</td>
                                <td style="width: 30%!important;padding: 5px !important;">
                                    <form class="d-inline" action="{{ route('client.buy_bills.filter.key') }}"
                                        method="POST">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" name="buy_bill_id" value="{{ $buy_bill->id }}">
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="fa fa-eye"></i> عرض
                                        </button>
                                    </form>
                                    <button bill_id="{{ $buy_bill->id }}"
                                        buy_bill_number="{{ $buy_bill->buy_bill_number }}" data-toggle="modal"
                                        href="#modaldemo9" title="delete" type="button"
                                        class="modal-effect btn btn-sm btn-danger delete_bill d-inline">
                                        <i class="fa fa-trash"></i>
                                        حذف
                                    </button>

                                    <a href="{{ route('client.buy_bills.edit', $buy_bill->id) }}" role="button"
                                        class="btn btn-sm btn-success d-inline">
                                        <i class="fa fa-trash"></i>
                                        تعديل
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    <span class="alert alert-secondary alert-sm mr-5">
                        عدد الفواتير لهذا المنتج
                        ( {{ $i }} )
                    </span>

                    <span class="alert alert-secondary alert-sm">
                        اجمالى اسعار كل الفواتير لهذا المنتج
                        ( {{ floatval($total) }} ) {{ $currency }}
                    </span>
                </div>
            @else
                <div class="alert alert-sm alert-danger text-center mt-3">
                    <i class="fa fa-close"></i>
                    لا توجد اى فواتير لهذا المنتج
                </div>
            @endif
        @endif
        @if (isset($all_buy_bills))
            @if (!$all_buy_bills->isEmpty())
                <div class="alert custom-title">
                    كل فواتير المشتريات
                </div>
                <table class='table table-condensed table-striped table-bordered'>
                    <thead class="text-center">
                        <th>#</th>
                        <th>رقم الفاتورة</th>
                        <th>اسم المورد</th>
                        <th>تاريخ الفاتورة</th>
                        <th> وقت الفاتورة</th>
                        <th>الاجمالى النهائى</th>
                        <th>عدد العناصر</th>
                        <th style="width: 30% !important;">عرض</th>
                    </thead>
                    <tbody>
                        <?php $i = 0;
                        $total = 0; ?>
                        @foreach ($all_buy_bills as $buy_bill)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $buy_bill->buy_bill_number }}</td>
                                <td>{{ $buy_bill->supplier->supplier_name }}</td>
                                <td>{{ $buy_bill->date }}</td>
                                <td>{{ $buy_bill->time }}</td>
                                <td>
                                    <?php $sum = 0; ?>
                                    @foreach ($buy_bill->elements as $element)
                                        <?php $sum = $sum + $element->quantity_price; ?>
                                    @endforeach
                                    <?php
                                    $extras = $buy_bill->extras;
                                    foreach ($extras as $key) {
                                        if ($key->action == 'discount') {
                                            if ($key->action_type == 'pound') {
                                                $buy_bill_discount_value = $key->value;
                                                $buy_bill_discount_type = 'pound';
                                            } else {
                                                $buy_bill_discount_value = $key->value;
                                                $buy_bill_discount_type = 'percent';
                                            }
                                        } else {
                                            if ($key->action_type == 'pound') {
                                                $buy_bill_extra_value = $key->value;
                                                $buy_bill_extra_type = 'pound';
                                            } else {
                                                $buy_bill_extra_value = $key->value;
                                                $buy_bill_extra_type = 'percent';
                                            }
                                        }
                                    }
                                    if ($extras->isEmpty()) {
                                        $buy_bill_discount_value = 0;
                                        $buy_bill_extra_value = 0;
                                        $buy_bill_discount_type = 'pound';
                                        $buy_bill_extra_type = 'pound';
                                    }
                                    if ($buy_bill_extra_type == 'percent') {
                                        $buy_bill_extra_value = ($buy_bill_extra_value / 100) * $sum;
                                    }
                                    $after_discount = $sum + $buy_bill_extra_value;

                                    if ($buy_bill_discount_type == 'percent') {
                                        $buy_bill_discount_value = ($buy_bill_discount_value / 100) * $sum;
                                    }
                                    $after_discount = $sum - $buy_bill_discount_value;
                                    $after_discount = $sum - $buy_bill_discount_value + $buy_bill_extra_value;
                                    $tax_value_added = $company->tax_value_added;
                                    $percentage = ($tax_value_added / 100) * $after_discount;
                                    $after_total = $after_discount + $percentage;
                                    echo floatval($after_total) . ' ' . $currency;
                                    ?>
                                    <?php $total = $total + $after_total; ?>
                                </td>
                                <td>{{ $buy_bill->elements->count() }}</td>
                                <td class="d-flex justify-content-center">
                                    <form class="d-inline" action="{{ route('client.buy_bills.filter.key') }}"
                                        method="POST">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" name="buy_bill_id" value="{{ $buy_bill->id }}">
                                        <a type="submit" class="">
                                            <svg xmlns="http://www.w3.org/2000/svg"width="17" height="20" viewBox="0 0 576 512"><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/></svg>
                                        </a>
                                    </form>
                                    <a bill_id="{{ $buy_bill->id }}"
                                        buy_bill_number="{{ $buy_bill->buy_bill_number }}" data-toggle="modal"
                                        href="#modaldemo9" title="delete" type="button"
                                        class="">
                                        <svg width="17" height="20" viewBox="0 0 17 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M14.912 4.33203L14.111 17.949C14.0812 18.4584 13.8577 18.9371 13.4865 19.2872C13.1153 19.6372 12.6243 19.8321 12.114 19.832H4.886C4.37575 19.8321 3.88475 19.6372 3.5135 19.2872C3.14226 18.9371 2.91885 18.4584 2.889 17.949L2.09 4.33203H0V3.33203C0 3.19942 0.0526785 3.07225 0.146447 2.97848C0.240215 2.88471 0.367392 2.83203 0.5 2.83203H16.5C16.6326 2.83203 16.7598 2.88471 16.8536 2.97848C16.9473 3.07225 17 3.19942 17 3.33203V4.33203H14.912ZM6.5 0.332031H10.5C10.6326 0.332031 10.7598 0.38471 10.8536 0.478478C10.9473 0.572246 11 0.699423 11 0.832031V1.83203H6V0.832031C6 0.699423 6.05268 0.572246 6.14645 0.478478C6.24021 0.38471 6.36739 0.332031 6.5 0.332031ZM5.5 6.83203L6 15.832H7.5L7.1 6.83203H5.5ZM10 6.83203L9.5 15.832H11L11.5 6.83203H10Z" fill="#F55549"/>
                                            </svg>
                                            
                                        
                                    </a>

                                    <a href="{{ route('client.buy_bills.edit', $buy_bill->id) }}" role="button"
                                        class="">
                                        <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M18.21 4.87258C18.6 4.48258 18.6 3.83258 18.21 3.46258L15.87 1.12258C15.5 0.732578 14.85 0.732578 14.46 1.12258L12.62 2.95258L16.37 6.70258M0.5 15.0826V18.8326H4.25L15.31 7.76258L11.56 4.01258L0.5 15.0826Z" fill="#4AA16A"/>
                                            </svg>
                                            
                                        
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    <span class="alert alert-secondary alert-sm mr-5">
                        عدد الفواتير
                        ( {{ $i }} )
                    </span>

                    <span class="alert alert-secondary alert-sm">
                        اجمالى اسعار كل الفواتير
                        ( {{ floatval($total) }} ) {{ $currency }}
                    </span>
                </div>
            @else
                <div class="alert alert-sm alert-danger text-center mt-3">
                    <i class="fa fa-close"></i>
                    لا توجد اى فواتير
                </div>
            @endif
        @endif


    </div>



    <div class="modal" id="modaldemo9">
        <div class="modal-dialog modal-dialog-centered" branch="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header text-center">
                    <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">حذف الفاتورة</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('client.buy_bills.deleteBill') }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>هل انت متأكد من الحذف ?</p><br>
                        <input type="hidden" name="billid" id="billid">
                        <input class="form-control" name="buybillnumber" id="buybillnumber" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">حذف</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.delete_bill').on('click', function() {
            var bill_id = $(this).attr('bill_id');
            var buy_bill_number = $(this).attr('buy_bill_number');
            $('.modal-body #billid').val(bill_id);
            $('.modal-body #buybillnumber').val(buy_bill_number);
        });

        $('#buy_bill_id').on('change', function() {
            let buy_bill_id = $(this).val();
            $('#buy_bill_id_2').val(buy_bill_id);
        });
        $('.remove_element').on('click', function() {
            let element_id = $(this).attr('element_id');
            let buy_bill_number = $(this).attr('buy_bill_number');

            let discount_type = $('#discount_type').val();
            let discount_value = $('#discount_value').val();

            let extra_type = $('#extra_type').val();
            let extra_value = $('#extra_value').val();

            $.post('{{ url('/client/buy-bills/element/delete') }}', {
                    '_token': '{{ csrf_token() }}',
                    element_id: element_id
                },
                function(data) {
                    $.post('{{ url('/client/buy-bills/updateData') }}', {
                            '_token': '{{ csrf_token() }}',
                            buy_bill_number: buy_bill_number
                        },
                        function(elements) {
                            $('.before_totals').html(elements);
                        });
                });
            $.post('{{ url('/client/buy-bills/discount') }}', {
                    '_token': '{{ csrf_token() }}',
                    buy_bill_number: buy_bill_number,
                    discount_type: discount_type,
                    discount_value: discount_value
                },
                function(data) {
                    $('.after_totals').html(data);
                });

            $.post('{{ url('/client/buy-bills/extra') }}', {
                    '_token': '{{ csrf_token() }}',
                    buy_bill_number: buy_bill_number,
                    extra_type: extra_type,
                    extra_value: extra_value
                },
                function(data) {
                    $('.after_totals').html(data);
                });
            $(this).parent().parent().fadeOut(300);
        });
        $('#exec_discount').on('click', function() {
            let buy_bill_number = $(this).attr('buy_bill_number');
            let discount_type = $('#discount_type').val();
            let discount_value = $('#discount_value').val();
            $.post("{{ url('/client/buy-bills/discount') }}", {
                    "_token": "{{ csrf_token() }}",
                    buy_bill_number: buy_bill_number,
                    discount_type: discount_type,
                    discount_value: discount_value
                },
                function(data) {
                    $('.after_totals').html(data);
                });
        });
        $('#exec_extra').on('click', function() {
            let buy_bill_number = $(this).attr('buy_bill_number');
            let extra_type = $('#extra_type').val();
            let extra_value = $('#extra_value').val();
            $.post("{{ url('/client/buy-bills/extra') }}", {
                    "_token": "{{ csrf_token() }}",
                    buy_bill_number: buy_bill_number,
                    extra_type: extra_type,
                    extra_value: extra_value
                },
                function(data) {
                    $('.after_totals').html(data);
                });
        });
    });
</script>
