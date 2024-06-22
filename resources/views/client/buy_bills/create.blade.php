@extends('client.layouts.app-main')
<style>
    .btn.dropdown-toggle.bs-placeholder,
    .form-control {
        height: 40px !important;
    }

    a,
    a:hover {
        text-decoration: none;
        color: #444;
    }

    .bootstrap-select {
        width: 80% !important;
    }

    .bill_details {
        margin-top: 30px !important;
        min-height: 150px !important;
    }

</style>
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissable fade show text-center">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif
    <div class="alert alert-success alert-dismissable text-center box_success d-none no-print">
        <button class="close" data-dismiss="alert" aria-label="Close">×</button>
        <span class="msg_success"></span>
    </div>

    <div class="alert alert-danger alert-dismissable text-center box_error d-none no-print">
        <button class="close" data-dismiss="alert" aria-label="Close">×</button>
        <span class="msg_error"></span>
    </div>
    @if (count($errors) > 0)
        <div class="alert alert-danger no-print">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>الاخطاء :</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form target="_blank" action="#" method="POST">
        @csrf
        @method('POST')
        @if (isset($open_buy_bill) && !empty($open_buy_bill))
            <input type="hidden" value="{{ $open_buy_bill->buy_bill_number }}" id="buy_bill_number"/>
        @else
            <input type="hidden" value="{{ $pre_bill }}" id="buy_bill_number"/>
        @endif
        <h6 class="alert alert-info alert-sm text-center no-print mb-3" dir="rtl">
            <center>
                @if (isset($open_buy_bill) && !empty($open_buy_bill))
                    تعديل فاتورة مشتريات موردين
                @else
                    {{ __('sidebar.add-new-purchase-invoice') }}
                @endif

                <span>
                    ( {{ __('main.process-number') }} :
                    @if (isset($open_buy_bill) && !empty($open_buy_bill))
                        {{ $countBills }} )
                    @else
                        {{ $countBills }} )
                    @endif
                </span>
            </center>
        </h6>

        <!------------------------------------------row1-------------------------------------->
        <div class="row firstrow p-0">
            <!------supplier_name------>
            <div class="col-lg-4 pull-right no-print">
                <label for="" class="d-block">{{ __('suppliers.supplier-name') }}</label>
                <select required name="supplier_id" id="supplier_id" class="selectpicker" data-style="btn-success"
                        data-live-search="true" title="{{ __('suppliers.supplier-name') }}">
                    @foreach ($suppliers as $supplier)
                        <option
                            @if (isset($open_buy_bill) && !empty($open_buy_bill) && $supplier->id == $open_buy_bill->supplier_id) selected
                            value="{{ $open_buy_bill->supplier_id }}"
                            @else
                            value="{{ $supplier->id }}" @endif>
                            {{ $supplier->supplier_name }}</option>
                    @endforeach
                </select>
                <a target="_blank" href="{{ route('client.suppliers.create') }}" role="button"
                   style="width: 15%;display: inline;" class="btn btn-sm btn-success open_popup">
                    <i class="fa fa-plus"></i>
                </a>
            </div>

            <!------invoice_store------>
            <div class="col-lg-4 pull-right">
                <label for=""> {{ __('sales_bills.choose-store') }} </label><br>
                <select name="store_id" id="store_id" class="selectpicker" data-style="btn-primary"
                        data-live-search="true"
                        title="{{ __('sales_bills.choose-store') }}">
                    <?php $i = 0; ?>
                    @foreach ($stores as $store)
                        @if ($stores->count() == 1)
                            <option selected value="{{ $store->id }}">{{ $store->store_name }}</option>
                        @else
                            @if ($i == 0)
                                <option selected value="{{ $store->id }}">{{ $store->store_name }}</option>
                            @else
                                <option value="{{ $store->id }}">{{ $store->store_name }}</option>
                            @endif
                        @endif
                        <?php $i++; ?>
                    @endforeach
                </select>
                <a target="_blank" href="{{ route('client.stores.create') }}" role="button"
                   style="width: 15%;display: inline;" class="btn btn-sm btn-primary open_popup">
                    <i class="fa fa-plus"></i>
                </a>
            </div>

            <!------invoice_tax------>
            <div class="col-lg-4 pull-right">
                <label> {{ __('sales_bills.choose-tax') }} </label><br>
                <select name="value_added_tax" id="value_added_tax" class="selectpicker"
                        data-style="btn-warning" title="{{ __('sales_bills.choose-store') }}">
                    <option value="0" selected>غير شامل الضريبة</option>
                    <option value="1">شامل الضريبة</option>
                </select>
            </div>
        </div>
        <!------------------------------------------row1-------------------------------------->


        <!------------------------------------------row2-------------------------------------->
        <div class="row secondrow p-0">
            <!------invoice_date------>
            <div class="col-lg-4 mt-2 col-md-3 col-sm-3 pull-right no-print">
                <div class="form-group" dir="rtl">
                    <label for="date">{{ __('sales_bills.invoice-date') }}</label>
                    <input type="date" required name="date"
                           @if (isset($open_buy_bill) && !empty($open_buy_bill)) value="{{ $open_buy_bill->date }}"
                           @else
                           value="<?php echo date('Y-m-d'); ?>" @endif
                           id="date" class="form-control"/>
                </div>
            </div>

            <!------invoice_time------>
            <div class="col-lg-4 mt-2 col-md-3 col-sm-3 pull-right no-print">
                <div class="form-group" dir="rtl">
                    <label for="time">{{ __('sales_bills.invoice-time') }}</label>
                    <input type="time" required name="time"
                           @if (isset($open_buy_bill) && !empty($open_buy_bill)) value="{{ $open_buy_bill->time }}"
                           @else
                           value="<?php echo date('H:i:s'); ?>" @endif
                           id="time" class="form-control"/>
                </div>
            </div>
        </div>
        <!------------------------------------------row2-------------------------------------->

        <div class="clearfix no-print"></div>
        <div class="supplier_details no-print"
             @if (!isset($open_buy_bill) || empty($open_buy_bill)) style="display: none !important;" @endif>
            <div class="col-lg-3 pull-right">
                <label for=""> {{ __('main.category') }} </label>
                <input type="text" class="form-control"
                       @if (isset($open_buy_bill) && !empty($open_buy_bill)) value="{{ $open_buy_bill->supplier->supplier_category }}"
                       @endif
                       readonly id="category"/>
            </div>

            <div class="col-lg-3 pull-right">
                <label for="">مستحقات المورد قبل الفاتورة</label>
                <input type="text"
                       @if (isset($open_buy_bill) && !empty($open_buy_bill)) value="{{ $open_buy_bill->supplier->prev_balance }}"
                       @endif
                       class="form-control"
                       readonly id="balance_before"
                />
            </div>

            <div class="col-lg-3 pull-right">
                <label for="">{{ __('suppliers.supplier-nationality') }}</label>
                <input type="text" class="form-control"
                       @if (isset($open_buy_bill) && !empty($open_buy_bill)) value="{{ $open_buy_bill->supplier->supplier_national }}"
                       @endif
                       readonly id="supplier_national"
                />
            </div>

            <div class="col-lg-3 col-md-3 col-sm-3 pull-right no-print">
                <div class="form-group" dir="rtl">
                    <label for="time">{{ __('main.notes') }}</label>
                    <input type="text" name="notes"
                           @if (isset($open_buy_bill) && !empty($open_buy_bill)) value="{{ $open_buy_bill->notes }}"
                           @endif id="notes" class="form-control"
                    />
                </div>
            </div>

            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        <hr class="no-print">

        <!------------------------------------------row3-------------------------------------->
        <div class="options no-print mt-2">

            <!------products------>
            <div class="col-lg-4 pull-right">
                <label for=""> {{ __('main.product') }} </label><br>
                <select name="product_id" id="product_id" class="selectpicker" data-style="btn-success"
                        data-live-search="true" title="كود المنتج او الاسم">
                    @foreach ($all_products as $product)
                        <option value="{{ $product->id }}"
                                data-tokens="{{ $product->code_universal }}">
                            {{ $product->product_name }}</option>
                    @endforeach
                </select>
                <a target="_blank" href="{{ route('client.products.create') }}" role="button"
                   style="width: 15%;display: inline;" class="btn btn-sm btn-warning open_popup">
                    <i class="fa fa-plus"></i>
                </a>
            </div>

            <!------price------>
            <div class="col-lg-2 pull-right">
                <label for="">{{ __('sales_bills.product-price') }}</label>
                <input type="text" name="product_price" value="0" id="product_price" class="form-control"/>
            </div>

            <!------quantity and unit------>
            <div class="col-lg-4 pull-right">
                <label class="d-block" for=""> {{ __('main.quantity') }} </label>
                <input style="width: 50%;" type="text" name="quantity" id="quantity"
                       class="form-control d-inline float-left"/>
                <select style="width: 50%;" class="form-control d-inline float-right" name="unit_id" id="unit_id">
                    <option value="">{{ __('units.unit-name') }}</option>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->unit_name }}</option>
                    @endforeach
                </select>
            </div>

            <!------total price------>
            <div class="col-lg-2 pull-right">
                <label for=""> {{ __('main.total') }} </label>
                <input type="text" name="quantity_price" id="quantity_price" class="form-control"/>
            </div>

        </div>
        <!------------------------------------------row3-------------------------------------->


        <!------------------------------------------row4 buttons-------------------------------------->
        <br><br>
        <br><br>
        <br><br>
        <div class="col-lg-12 text-center">
            <button type="button" id="add" class="btn btn-primary btn-md mt-3">
                <i class="fa fa-plus"></i>
                {{ __('sidebar.add-new-purchase-invoice') }}
            </button>

            <button type="button" id="edit" style="display: none" class="btn btn-success btn-md mt-3">
                <i class="fa fa-pencil"></i>
                {{ __('main.update') }}
            </button>
        </div>
        <!------------------------------------------row4 buttons-------------------------------------->

        <hr>
        </div>
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
        <div class="col-lg-12 col-md-12 col-sm-12 bill_details">
            <h6 class="alert alert-sm alert-warning text-center">
                <i class="fa fa-info-circle"></i>
                بيانات عناصر فاتورة المشتريات رقم

                @if (isset($open_buy_bill) && !empty($open_buy_bill))
                    <span class="badge badge-dark">{{ $countBills }}</span>

                @else
                    <span class="badge badge-dark">{{ $countBills }}</span>
                @endif
            </h6>

            <?php
            if (isset($open_buy_bill) && !empty($open_buy_bill)) {
                $elements = \App\Models\BuyBillElement::where('buy_bill_id', $open_buy_bill->id)->get();
                $extras = \App\Models\BuyBillExtra::where('buy_bill_id', $open_buy_bill->id)->get();
                $extra_settings = \App\Models\ExtraSettings::where('company_id', $company_id)->first();
                $currency = $extra_settings->currency;
                $tax_value_added = $company->tax_value_added;
                $sum = [];
                if (!$elements->isEmpty()) {
                    $i = 0;
                    echo "<table class='table table-condensed table-striped table-bordered'>";
                    echo '<thead>';
                    echo '<th>  # </th>';
                    echo '<th> اسم المنتج </th>';
                    echo '<th> سعر الوحدة </th>';
                    echo '<th> الكمية </th>';
                    echo '<th>  الاجمالى </th>';
                    echo "<th class='no-print'>  تحكم </th>";
                    echo '</thead>';
                    echo '<tbody>';
                    foreach ($elements as $element) {
                        array_push($sum, $element->quantity_price);
                        echo '<tr>';
                        echo '<td>' . ++$i . '</td>';
                        echo '<td>' . $element->product->product_name . '</td>';
                        echo '<td>' . $element->product_price . '</td>';
                        echo '<td>' . $element->quantity . ' ' . $element->unit->unit_name . '</td>';
                        echo '<td>' . $element->quantity_price . '</td>';
                        echo "<td class='no-print'>
                                                                                                                                                                                                                                                                                                                                                                <button type='button' buy_bill_number='" .
                            $element->BuyBill->buy_bill_number .
                            "' element_id='" .
                            $element->id .
                            "' class='btn btn-sm btn-info edit_element'>
                                                                                                                                                                                                                                                                                                                                                                    <i class='fa fa-pencil'></i> تعديل
                                                                                                                                                                                                                                                                                                                                                                </button>
                                                                                                                                                                                                                                                                                                                                                                    <button type='button' buy_bill_number='" .
                            $element->BuyBill->buy_bill_number .
                            "' element_id='" .
                            $element->id .
                            "' class='btn btn-sm btn-danger remove_element'>
                                                                                                                                                                                                                                                                                                                                                                        <i class='fa fa-trash'></i> حذف
                                                                                                                                                                                                                                                                                                                                                                    </button>
                                                                                                                                                                                                                                                                                                                                                                </td>";
                        echo '</tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                    $total = array_sum($sum);
                    $percentage = ($tax_value_added / 100) * $total;
                    $after_total = $total + $percentage;
                    echo "
                                                                                                                                                                                                                                                                                                                                                <div class='clearfix'></div>
                                                                                                                                                                                                                                                                                                                                                <div class='alert alert-dark alert-sm text-center'>
                                                                                                                                                                                                                                                                                                                                                    <div class='pull-right col-lg-6 '>
                                                                                                                                                                                                                                                                                                                                                         اجمالى الفاتورة
                                                                                                                                                                                                                                                                                                                                                        " .
                        $total .
                        ' ' .
                        $currency .
                        "
                                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                                                    <div class='pull-left col-lg-6 '>
                                                                                                                                                                                                                                                                                                                                                        اجمالى الفاتورة  بعد القيمة المضافة
                                                                                                                                                                                                                                                                                                                                                        " .
                        $after_total .
                        ' ' .
                        $currency .
                        "
                                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                                                    <div class='clearfix'></div>
                                                                                                                                                                                                                                                                                                                                                </div>";
                }
            }
            ?>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 after_totals">
            <?php
            if (isset($open_buy_bill) && !empty($open_buy_bill)) {
                $tax_value_added = $company->tax_value_added;
                $sum = [];
                foreach ($elements as $element) {
                    array_push($sum, $element->quantity_price);
                }
                $total = array_sum($sum);
                $previous_extra = \App\Models\BuyBillExtra::where('buy_bill_id', $open_buy_bill->id)
                    ->where('action', 'extra')
                    ->first();
                if (!empty($previous_extra)) {
                    $previous_extra_type = $previous_extra->action_type;
                    $previous_extra_value = $previous_extra->value;
                    if ($previous_extra_type == 'percent') {
                        $previous_extra_value = ($previous_extra_value / 100) * $total;
                    }
                    $after_discount = $total + $previous_extra_value;
                }
                $previous_discount = \App\Models\BuyBillExtra::where('buy_bill_id', $open_buy_bill->id)
                    ->where('action', 'discount')
                    ->first();
                if (!empty($previous_discount)) {
                    $previous_discount_type = $previous_discount->action_type;
                    $previous_discount_value = $previous_discount->value;
                    if ($previous_discount_type == 'percent') {
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
                echo "
                                                                                                                                                                                                                                                                                                                                                    <div class='clearfix'></div>
                                                                                                                                                                                                                                                                                                                                                    <div class='alert alert-secondary alert-sm text-center'>
                                                                                                                                                                                                                                                                                                                                                           اجمالى الفاتورة النهائى بعد الضريبة والشحن والخصم :
                                                                                                                                                                                                                                                                                                                                                            " .
                    $after_total_all .
                    ' ' .
                    $currency .
                    "
                                                                                                                                                                                                                                                                                                                                                    </div>";
            }
            ?>
        </div>

        <div class="clearfix no-print"></div>
        <hr class="no-print">
        <div class="row no-print" style="margin: 20px auto;">
            <div class="col-lg-12">
                <div class="col-lg-6 col-md-6 col-xs-6 pull-right">
                    <div class="form-group" dir="rtl">
                        <label for="discount">{{ __('sales_bills.discount-on-the-total-bill') }}</label> <br>
                        <?php
                        if (isset($open_buy_bill) && !empty($open_buy_bill)) {
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
                        }
                        ?>
                        @if (isset($open_buy_bill) && !empty($open_buy_bill))
                            <select name="discount_type" id="discount_type" class="form-control"
                                    style="width: 20%;display: inline;float: right; margin-left:5px;">
                                <option @if (isset($buy_bill_discount_type) && $buy_bill_discount_type == 'pound') selected @endif value="pound">
                                    {{ $extra_settings->currency }}
                                </option>
                                <option @if (isset($buy_bill_discount_type) && $buy_bill_discount_type == 'percent') selected @endif value="percent">
                                    %
                                </option>
                            </select>
                            <input type="text" value="{{ isset($buy_bill_discount_value) ? $buy_bill_discount_value : 0 }}" name="discount_value"
                                   style="width: 50%;display: inline;float: right;" id="discount_value"
                                   class="form-control "/>
                            <button type="button" class="btn btn-md btn-info pull-right text-center"
                                    style="display: inline !important;width: 20% !important; height: 40px;margin-right: 20px; "
                                    id="exec_discount">{{ __('main.apply') }}
                            </button>
                        @else
                            <select name="discount_type" id="discount_type" class="form-control" disabled
                                    style="width: 20%;display: inline;float: right; margin-left:5px;">
                                <option value="pound">{{ $extra_settings->currency }}</option>
                                <option value="percent">%</option>
                            </select>
                            <input type="text" value="0" name="discount_value"
                                   style="width: 50%;display: inline;float: right;" disabled id="discount_value"
                                   class="form-control "/>
                            <button type="button" disabled class="btn btn-md btn-info pull-right text-center"
                                    style="display: inline !important;width: 20% !important; height: 40px;margin-right: 20px; "
                                    id="exec_discount">{{ __('main.apply') }}
                            </button>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-xs-6 pull-right">
                    <div class="form-group" dir="rtl">
                        <label for="extra">{{ __('main.shipping-expenses') }}</label> <br>
                        @if (isset($open_buy_bill) && !empty($open_buy_bill))
                            <select name="extra_type" id="extra_type" class="form-control"
                                    style="width: 20%;display: inline;float: right;margin-left: 5px">
                                <option @if (isset($buy_bill_extra_type) && $buy_bill_extra_type == 'pound') selected @endif value="pound">
                                    {{ $extra_settings->currency }}</option>
                                <option @if (isset($buy_bill_extra_type) && $buy_bill_extra_type == 'percent') selected @endif value="percent">%
                                </option>
                            </select>
                            <input value="{{ isset($buy_bill_extra_value) ? $buy_bill_extra_value : 0 }}" type="text" name="extra_value"
                                   style="width: 50%;display: inline;float: right;" id="extra_value"
                                   class="form-control"/>
                            <button type="button" class="btn btn-md btn-info pull-right text-center"
                                    style="display: inline !important;width: 20% !important; height: 40px;margin-right: 20px; "
                                    id="exec_extra">
                                {{ __('main.apply') }}
                            </button>
                        @else
                            <select disabled name="extra_type" id="extra_type" class="form-control"
                                    style="width: 20%;display: inline;float: right;margin-left: 5px">
                                <option value="pound">{{ $extra_settings->currency }}</option>
                                <option value="percent">%</option>
                            </select>
                            <input disabled value="0" type="text" name="extra_value"
                                   style="width: 50%;display: inline;float: right;" id="extra_value"
                                   class="form-control"/>
                            <button disabled type="button" class="btn btn-md btn-info pull-right text-center"
                                    style="display: inline !important;width: 20% !important; height: 40px;margin-right: 20px; "
                                    id="exec_extra">
                                {{ __('main.apply') }}
                            </button>
                        @endif
                    </div>
                </div>
                <div class="clearfix"></div>
            </div> <!--  End Col-lg-12 -->
        </div><!--  End Row -->
    </form>
    <div class="col-lg-12 no-print" style="padding-top: 25px;height: 40px !important;">
        <button type="button" @if (!isset($open_buy_bill) || empty($open_buy_bill)) disabled @endif data-toggle="modal"
                data-target="#myModal2" class="btn btn-md btn-dark pay_btn pull-right">
            <i class="fa fa-money"></i>
            {{ __('pos.record-payment') }}
        </button>

        <form class="d-inline" method="POST" action="{{ route('client.buy_bills.cancel') }}">
            @csrf
            @method('POST')
            @if (isset($open_buy_bill) && !empty($open_buy_bill))
                <input type="hidden" value="{{ $open_buy_bill->buy_bill_number }}" name="buy_bill_number"/>
            @else
                <input type="hidden" value="{{ $pre_bill }}" name="buy_bill_number"/>
            @endif
            <button href="" type="submit" @if (!isset($open_buy_bill) || empty($open_buy_bill)) disabled @endif
            class="btn btn-md close_btn btn-danger pull-right ml-3"><i class="fa fa-check"></i>
                {{ __('main.cancel') }}
            </button>
        </form>
        <a href="javascript:;" role="button"
           class="btn @if (!isset($open_buy_bill) || empty($open_buy_bill)) disabled @endif save_btn btn-md btn-success pull-right ml-3"><i
                class="fa fa-check"></i>
            {{ __('main.save') }}
        </a>
    </div>

    <div class="modal fade" dir="rtl" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header w-100">
                    <h4 class="modal-title text-center" id="myModalLabel2">دفع نقدى</h4>
                </div>
                <div class="modal-body">
                    @if ((isset($buy_bill_cash) && !$buy_bill_cash->isEmpty()) || (isset($buy_bill_bank_cash) && !$buy_bill_bank_cash->isEmpty()))
                        <table class="table table-condensed table-striped table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>المبلغ</th>
                                <th>طريقة الدفع</th>
                                <th>حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $j = 0; ?>
                            @if (isset($buy_bill_cash) && !$buy_bill_cash->isEmpty())
                                @foreach ($buy_bill_cash as $cash)
                                    <tr>
                                        <td>{{ ++$j }}</td>
                                        <td>{{ $cash->amount }}</td>
                                        <td>دفع كاش نقدى
                                            <br>
                                            ({{ $cash->safe->safe_name }})
                                        </td>
                                        <td>
                                            <button type="button" payment_method="cash" cash_id="{{ $cash->id }}"
                                                    class="btn btn-danger delete_pay">حذف
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            @if (isset($buy_bill_bank_cash) && !$buy_bill_bank_cash->isEmpty())
                                @foreach ($buy_bill_bank_cash as $cash)
                                    <tr>
                                        <td>{{ ++$j }}</td>
                                        <td>{{ $cash->amount }}</td>
                                        <td>دفع بنكى شبكة
                                            <br>
                                            ({{ $cash->bank->bank_name ?? '' }})
                                            <br>
                                            ({{ $cash->bank_check_number ?? '' }})
                                        </td>
                                        <td>
                                            <button type="button" payment_method="bank" cash_id="{{ $cash->id }}"
                                                    class="btn btn-danger delete_pay">حذف
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    @endif
                    <input type="hidden" id="company_id" value="{{ $company_id }}">
                    <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label> رقم العملية <span class="text-danger">*</span></label>
                            <input required readonly value="{{ $pre_cash }}" class="form-control" id="cash_number"
                                   type="text">
                        </div>
                        <div class="col-md-4">
                            <label> المبلغ المدفوع <span class="text-danger">*</span></label>
                            <input required class="form-control" id="amount" type="text" dir="ltr">
                        </div>
                        <div class="col-md-4">
                            <label> طريقة الدفع <span class="text-danger">*</span></label>
                            <select required id="payment_method" name="payment_method" class="form-control">
                                <option value="">اختر طريقة الدفع</option>
                                <option value="cash">دفع كاش نقدى</option>
                                <option value="bank">دفع بنكى شبكة</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3 cash" style="display: none;">
                        <div class="col-md-4">
                            <label> خزنة الدفع <span class="text-danger">*</span></label>
                            <select style="width: 80% !important; display: inline !important;" required id="safe_id"
                                    class="form-control">
                                <option value="">اختر خزنة الدفع</option>
                                @foreach ($safes as $safe)
                                    <option value="{{ $safe->id }}">{{ $safe->safe_name }}</option>
                                @endforeach
                            </select>
                            <a target="_blank" href="{{ route('client.safes.create') }}" role="button"
                               style="width: 15%;display: inline;" class="btn btn-sm btn-warning open_popup">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="row mb-3 bank" style="display: none;">
                        <div class="col-md-4">
                            <label class="d-block"> البنك <span class="text-danger">*</span></label>
                            <select style="width: 80% !important; display: inline !important;" required id="bank_id"
                                    class="form-control">
                                <option value="">اختر البنك</option>
                                @foreach ($banks as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
                                @endforeach
                            </select>
                            <a target="_blank" href="{{ route('client.banks.create') }}" role="button"
                               style="width: 15%;display: inline;" class="btn btn-sm btn-warning open_popup">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <label for="">رقم المعاملة</label>
                            <input type="text" class="form-control" id="bank_check_number"/>
                        </div>
                        <div class="col-md-4">
                            <label for="">ملاحظات</label>
                            <input type="text" class="form-control" id="bank_notes"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button class="btn btn-info pd-x-20 pay_cash" type="button">تسجيل الدفع</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="supplier_name" id="supplier_name"/>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i>
                        اغلاق
                    </button>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="final_total"
           @if (isset($open_buy_bill) && !empty($open_buy_bill)) value="{{ $open_buy_bill->final_total }}" @endif />
    <input type="hidden" id="product" placeholder="product" name="product"/>
    <input type="hidden" id="total" placeholder="اجمالى قبل الخصم" name="total"/>
    <input type="hidden" value="0" id="check"/>
    <script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
    <script>

        //-----save buy_invoice -- finish-----//
        $('.save_btn').on('click', function () {
            let buy_bill_number = $('#buy_bill_number').val();
            let payment_method = $('#payment_method').val();
            $.post("{{ url('/client/buy-bills/saveAll') }}", {
                buy_bill_number: buy_bill_number,
                payment_method: payment_method,
                "_token": "{{ csrf_token() }}"
            }, function (data) {
                location.href = '/buy-bills/print/' + buy_bill_number;
            });
        });

        //-----onclick record payment------//
        $('.pay_cash').on('click', function () {
            let company_id = $('#company_id').val();
            let supplier_id = $('#supplier_id').val();
            let buy_bill_number = $('#buy_bill_number').val();
            let date = $('#date').val();
            let time = $('#time').val()
            let cash_number = $('#cash_number').val();
            let amount = $('#amount').val();
            let safe_id = $('#safe_id').val();
            let bank_id = $('#bank_id').val();
            let bank_check_number = $('#bank_check_number').val();
            let notes = $('#bank_notes').val();
            let payment_method = $('#payment_method').val();
            $.post("{{ route('client.store.cash.suppliers.buyBill', 'test') }}", {
                supplier_id: supplier_id,
                company_id: company_id,
                bill_id: buy_bill_number,
                date: date,
                time: time,
                cash_number: cash_number,
                amount: amount,
                safe_id: safe_id,
                bank_id: bank_id,
                bank_check_number: bank_check_number,
                notes: notes,
                payment_method: payment_method,
                "_token": "{{ csrf_token() }}"
            }, function (data) {
                if (data.status == true) {
                    $('<div class="alert alert-dark alert-sm"> ' + data.msg + '</div>').insertAfter(
                        '#company_id');

                    $('.delete_pay').on('click', function () {
                        let payment_method = $(this).attr('payment_method');
                        let cash_id = $(this).attr('cash_id');
                        $.post("{{ route('buy_bills.pay.delete') }}", {
                            '_token': "{{ csrf_token() }}",
                            payment_method: payment_method,
                            cash_id: cash_id,
                        }, function (data) {

                        });
                        $(this).parent().hide();
                    });
                } else {
                    $('<br/><br/> <p class="alert alert-danger alert-sm"> ' + data.msg + '</p>')
                        .insertAfter('#company_id');
                }
            });
        });

        $('.delete_pay').on('click', function () {
            let payment_method = $(this).attr('payment_method');
            let cash_id = $(this).attr('cash_id');
            $.post("{{ route('buy_bills.pay.delete') }}", {
                '_token': "{{ csrf_token() }}",
                payment_method: payment_method,
                cash_id: cash_id,
            }, function (data) {

            });
            $(this).parent().parent().hide();

        });

        $('#supplier_id').on('change', function () {
            let supplier_id = $(this).val();
            if (supplier_id != "" || supplier_id != "0") {
                $('.supplier_details').fadeIn(200);
                $.post("{{ url('/client/buy-bills/getSupplierDetails') }}", {
                    supplier_id: supplier_id,
                    "_token": "{{ csrf_token() }}"
                }, function (data) {
                    $('#category').val(data.category);
                    $('#balance_before').val(data.balance_before);
                    $('#supplier_national').val(data.supplier_national);
                });
            } else {
                $('.supplier_details').fadeOut(200);
            }
        });

        $('#store_id').on('change', function () {
            let store_id = $(this).val();
            if (store_id != "" || store_id != "0") {
                $('.options').fadeIn(200);
                $.post("{{ url('/client/buy-bills/getProducts') }}", {
                    store_id: store_id,
                    "_token": "{{ csrf_token() }}"
                }, function (data) {
                    $('select#product_id').html(data);
                    $('select#product_id').selectpicker('refresh');
                });
            } else {
                $('.options').fadeOut(200);
            }
        });

        $('#product_id').on('change', function () {
            $('#product_price').val('0');
            let product_id = $(this).val();
            $.post("{{ url('/client/buy-bills/get') }}", {
                product_id: product_id,
                "_token": "{{ csrf_token() }}"
            }, function (data) {
                $('input#product_price').val(data.purchasing_price);
            });
        });

        $('#quantity').on('keyup change', function () {
            let product_id = $('#product_id').val();
            let product_price = $('#product_price').val();
            let quantity = $(this).val();
            let quantity_price = quantity * product_price;
            $('#quantity_price').val(quantity_price);
        });

        $('#product_price').on('keyup change', function () {
            let product_id = $('#product_id').val();
            let product_price = $(this).val();
            let quantity = $('#quantity').val();
            let quantity_price = quantity * product_price;
            $('#quantity_price').val(quantity_price);
        });

        //---------on adding new product to buy_invoice-------//
        $('#add').on('click', function () {
            let supplier_id = $('#supplier_id').val();
            let buy_bill_number = $('#buy_bill_number').val();
            let product_id = $('#product_id').val();
            let product_price = $('#product_price').val();
            let quantity = $('#quantity').val();
            let date = $('#date').val();
            let time = $('#time').val();
            let notes = $('#notes').val();
            let unit_id = $('#unit_id').val();
            let quantity_price = quantity * product_price;
            let discount_type = $('#discount_type').val();
            let discount_value = $('#discount_value').val();
            let extra_type = $('#extra_type').val();
            let extra_value = $('#extra_value').val();
            let value_added_tax = $('#value_added_tax').val();
            let company_counter = {{$countBills}};
            if (supplier_id == "") {
                alert("لابد ان تختار المورد أولا");
            } else {

                if (product_id == "" || product_id <= "0") {
                    alert("لابد ان تختار المنتج أولا");
                } else if (product_price == "" || product_price == "0") {
                    alert("لم يتم اختيار سعر المنتج");
                } else if (quantity == "" || quantity <= "0") {
                    alert("الكمية غير مناسبة");
                } else if (quantity_price == "" || quantity_price == "0") {
                    alert("الكمية غير مناسبة او الاجمالى غير صحيح");
                } else if (unit_id == "" || unit_id == "0") {
                    alert("اختر الوحدة");
                } else {
                    $.post("{{ url('/client/buy-bills/post') }}", {
                        supplier_id: supplier_id,
                        buy_bill_number: buy_bill_number,
                        product_id: product_id,
                        product_price: product_price,
                        quantity: quantity,
                        unit_id: unit_id,
                        quantity_price: quantity_price,
                        value_added_tax: value_added_tax,
                        date: date,
                        notes: notes,
                        time: time,
                        company_counter: company_counter,
                        "_token": "{{ csrf_token() }}"
                    }, function (data) {
                        $('#supplier_id').attr('disabled', true).addClass('disabled');
                        $('#product_id').val('').trigger('change');
                        $('#discount_type').attr('disabled', false);
                        $('.print_btn').removeClass('disabled');
                        $('.pay_btn').attr('disabled', false);
                        $('.close_btn').attr('disabled', false);
                        $('.save_btn').removeClass('disabled');
                        $('.send_btn').removeClass('disabled');
                        $('#discount_value').attr('disabled', false);
                        $('#exec_discount').attr('disabled', false);
                        $('#extra_type').attr('disabled', false);
                        $('#extra_value').attr('disabled', false);
                        $('#exec_extra').attr('disabled', false);
                        $('#unit_id').val('');
                        $('#product_price').val('0');
                        $('#quantity').val('');
                        $('#quantity_price').val('');

                        if (data.status == true) {
                            $('.box_success').removeClass('d-none').fadeIn(200);
                            $('.msg_success').html(data.msg);
                            $('.box_success').delay(3000).fadeOut(300);

                            //-----get elements to show----//
                            $.post("{{ url('/client/buy-bills/elements') }}", {
                                "_token": "{{ csrf_token() }}",
                                buy_bill_number: buy_bill_number
                            }, function (elements) {
                                $('.bill_details').html(elements);
                            });

                            //-----apply discount----//
                            $.post("{{ url('/client/buy-bills/discount') }}", {
                                "_token": "{{ csrf_token() }}",
                                buy_bill_number: buy_bill_number,
                                discount_type: discount_type,
                                discount_value: discount_value
                            }, function (data) {
                                $('.after_totals').html(data);
                            });

                            //-----apply shipping value----//
                            $.post("{{ url('/client/buy-bills/extra') }}", {
                                "_token": "{{ csrf_token() }}",
                                buy_bill_number: buy_bill_number,
                                extra_type: extra_type,
                                extra_value: extra_value
                            }, function (data) {
                                $('.after_totals').html(data);
                            });

                            //-----refresh----//
                            $.post("{{ url('/client/buy-bills/refresh') }}", {
                                "_token": "{{ csrf_token() }}",
                                buy_bill_number: buy_bill_number,
                            }, function (data) {
                                $('#final_total').val(data.final_total);
                            });

                        } else {
                            $('.box_error').removeClass('d-none').fadeIn(200);
                            $('.msg_error').html(data.msg);
                            $('.box_error').delay(3000).fadeOut(300);

                            $.post("{{ url('/client/buy-bills/elements') }}", {
                                "_token": "{{ csrf_token() }}",
                                buy_bill_number: buy_bill_number
                            }, function (elements) {
                                $('.bill_details').html(elements);
                            });

                            $.post("{{ url('/client/buy-bills/discount') }}", {
                                "_token": "{{ csrf_token() }}",
                                buy_bill_number: buy_bill_number,
                                discount_type: discount_type,
                                discount_value: discount_value
                            }, function (data) {
                                $('.after_totals').html(data);
                            });

                            $.post("{{ url('/client/buy-bills/extra') }}", {
                                "_token": "{{ csrf_token() }}",
                                buy_bill_number: buy_bill_number,
                                extra_type: extra_type,
                                extra_value: extra_value
                            }, function (data) {
                                $('.after_totals').html(data);
                            });

                            $.post("{{ url('/client/buy-bills/refresh') }}", {
                                "_token": "{{ csrf_token() }}",
                                buy_bill_number: buy_bill_number,
                            }, function (data) {
                                $('#final_total').val(data.final_total);
                            });
                        }
                    });
                }
            }

        });
        //----------------------------------------------------//


        //------on apply discount to the invoice---------------//
        $('#exec_discount').on('click', function () {
            let buy_bill_number = $('#buy_bill_number').val();
            let discount_type = $('#discount_type').val();
            let discount_value = $('#discount_value').val();
            $.post("{{ url('/client/buy-bills/discount') }}", {
                "_token": "{{ csrf_token() }}",
                buy_bill_number: buy_bill_number,
                discount_type: discount_type,
                discount_value: discount_value
            }, function (data) {
                $('.after_totals').html(data);
            });

            $.post("{{ url('/client/buy-bills/refresh') }}", {
                "_token": "{{ csrf_token() }}",
                buy_bill_number: buy_bill_number,
            }, function (data) {
                $('#final_total').val(data.final_total);
            });
        });
        //---------------------------------------------------/

        //-----------record payment btn------------------//
        $('.pay_btn').on('click', function () {
            let final_total = $('#final_total').val();
            $('#amount').val(final_total);
        })
        //---------------------------------------------------/


        //-----------onclick edit element ----------------//
        $('.edit_element').on('click', function () {
            let element_id = $(this).attr('element_id');
            let buy_bill_number = $(this).attr('buy_bill_number');
            $.post("{{ url('/client/buy-bills/edit-element') }}", {
                "_token": "{{ csrf_token() }}",
                buy_bill_number: buy_bill_number,
                element_id: element_id
            }, function (data) {
                $('#product_id').val(data.product_id);
                $('#product_id').selectpicker('refresh');
                $('#product_price').val(data.product_price);
                $('#unit_id').val(data.unit_id);
                $('#quantity').val(data.quantity);
                $('#quantity_price').val(data.quantity_price);
                let product_id = data.product_id;
                $.post("{{ url('/client/buy-bills/get-edit') }}", {
                    product_id: product_id,
                    buy_bill_number: buy_bill_number,
                    "_token": "{{ csrf_token() }}"
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
        //---------------------------------------------------/


        //-----------onclick edit invoice ----------------//
        $('#edit').on('click', function () {
            let element_id = $(this).attr('element_id');
            let buy_bill_number = $(this).attr('buy_bill_number');

            let product_id = $('#product_id').val();
            let product_price = $('#product_price').val();
            let quantity = $('#quantity').val();
            let quantity_price = $('#quantity_price').val();
            let unit_id = $('#unit_id').val();

            let discount_type = $('#discount_type').val();
            let discount_value = $('#discount_value').val();
            let first_balance = parseFloat($('#quantity').attr('max'));
            let extra_type = $('#extra_type').val();
            let extra_value = $('#extra_value').val();
            if (product_id == "" || product_id <= "0") {
                alert("لابد ان تختار المنتج أولا");
            } else if (product_price == "" || product_price == "0") {
                alert("لم يتم اختيار سعر المنتج");
            } else if (quantity == "" || quantity <= "0" || quantity > first_balance) {
                alert("الكمية غير مناسبة");
            } else if (quantity_price == "" || quantity_price == "0") {
                alert("الكمية غير مناسبة او الاجمالى غير صحيح");
            } else if (unit_id == "" || unit_id == "0") {
                alert("اختر الوحدة");
            } else {
                $.post('/client/buy-bills/element/update', {
                    '_token': "{{ csrf_token() }}",
                    element_id: element_id,
                    product_id: product_id,
                    product_price: product_price,
                    quantity: quantity,
                    quantity_price: quantity_price,
                    unit_id: unit_id,
                }, function (data) {
                    $.post('/client/buy-bills/elements', {
                        '_token': "{{ csrf_token() }}",
                        buy_bill_number: buy_bill_number
                    }, function (elements) {
                        $('.bill_details').html(elements);
                    });
                    $('#add').show();
                    $('#edit').hide();
                    $('#product_id').val('').trigger('change');
                    $('#unit_id').val('');
                    $('.available').html("");
                    $('#product_price').val('0');
                    $('#quantity').val('');
                    $('#quantity_price').val('');
                });

                $.post('/client/buy-bills/discount', {
                    '_token': "{{ csrf_token() }}",
                    buy_bill_number: buy_bill_number,
                    discount_type: discount_type,
                    discount_value: discount_value
                }, function (data) {
                    $('.after_totals').html(data);
                });

                $.post('/client/buy-bills/extra', {
                    '_token': "{{ csrf_token() }}",
                    buy_bill_number: buy_bill_number,
                    extra_type: extra_type,
                    extra_value: extra_value
                }, function (data) {
                    $('.after_totals').html(data);
                });

                $.post("{{ url('/client/buy-bills/refresh') }}", {
                    "_token": "{{ csrf_token() }}",
                    buy_bill_number: buy_bill_number,
                }, function (data) {
                    $('#final_total').val(data.final_total);
                });
            }

        });
        //---------------------------------------------------/


        //-----------onclick removing elements ----------------//
        $('.remove_element').on('click', function () {
            let element_id = $(this).attr('element_id');
            let buy_bill_number = $(this).attr('buy_bill_number');

            let discount_type = $('#discount_type').val();
            let discount_value = $('#discount_value').val();

            let extra_type = $('#extra_type').val();
            let extra_value = $('#extra_value').val();

            $.post('/client/buy-bills/element/delete', {
                '_token': "{{ csrf_token() }}",
                element_id: element_id
            }, function (data) {
                $.post('/client/buy-bills/elements', {
                    '_token': "{{ csrf_token() }}",
                    buy_bill_number: buy_bill_number
                }, function (elements) {
                    $('.bill_details').html(elements);
                });
            });

            $.post('/client/buy-bills/discount', {
                '_token': "{{ csrf_token() }}",
                buy_bill_number: buy_bill_number,
                discount_type: discount_type,
                discount_value: discount_value
            }, function (data) {
                $('.after_totals').html(data);
            });

            $.post('/client/buy-bills/extra', {
                '_token': "{{ csrf_token() }}",
                buy_bill_number: buy_bill_number,
                extra_type: extra_type,
                extra_value: extra_value
            }, function (data) {
                $('.after_totals').html(data);
            });

            $.post("{{ url('/client/buy-bills/refresh') }}", {
                "_token": "{{ csrf_token() }}",
                buy_bill_number: buy_bill_number,
            }, function (data) {
                $('#final_total').val(data.final_total);
            });

            $(this).parent().parent().fadeOut(300);
        });
        //---------------------------------------------------/


        //-----------apply shipping value ----------------//
        $('#exec_extra').on('click', function () {
            let buy_bill_number = $('#buy_bill_number').val();
            let extra_type = $('#extra_type').val();
            let extra_value = $('#extra_value').val();

            $.post("{{ url('/client/buy-bills/extra') }}", {
                "_token": "{{ csrf_token() }}",
                buy_bill_number: buy_bill_number,
                extra_type: extra_type,
                extra_value: extra_value
            }, function (data) {
                $('.after_totals').html(data);
            });

            $.post("{{ url('/client/buy-bills/refresh') }}", {
                "_token": "{{ csrf_token() }}",
                buy_bill_number: buy_bill_number,
            }, function (data) {
                $('#final_total').val(data.final_total);
            });
        });
        //---------------------------------------------------/


        //-----------on change payment method ----------------//
        $('#payment_method').on('change', function () {
            let payment_method = $(this).val();
            if (payment_method == "cash") {
                $('.cash').show();
                $('.bank').hide();
            } else if (payment_method == "bank") {
                $('.bank').show();
                $('.cash').hide();
            } else {
                $('.bank').hide();
                $('.cash').hide();
            }
        });
        //---------------------------------------------------/
    </script>
@endsection
