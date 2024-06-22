@extends('client.layouts.app-pos')
<style>
    .posTable td {
        padding: 5px !important;
    }
</style>
@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
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
    <div class="row">
        <div class="col-lg-6  pull-right">
            <div class="section">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                           role="tab" aria-controls="nav-home"
                           aria-selected="true">{{ __('pos.categories-and-main-categories') }}</a>
                        @if ($pos_settings->suspension_tab == '1')
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                               role="tab" aria-controls="nav-profile"
                               aria-selected="false">{{ __('pos.pending-sales-invoices') }}</a>
                        @endif
                        @if ($pos_settings->edit_delete_tab == '1')
                            <a class="nav-item nav-link" id="nav-bills-tab" data-toggle="tab" href="#nav-bills"
                               role="tab" aria-controls="nav-bills"
                               aria-selected="false"> {{ __('pos.modify-previous-invoices') }}
                            </a>
                        @endif
                        @if ($pos_settings->status == 'open')
                            <a class="nav-item nav-link" id="nav-status-tab" data-toggle="tab" href="#nav-status"
                               role="tab" aria-controls="nav-status" aria-selected="false">
                                {{ __('pos.daily-closing') }}
                            </a>
                        @endif
                        <a class="nav-item nav-link" id="nav-notes-tab" data-toggle="tab" href="#nav-notes" role="tab"
                           aria-controls="nav-notes" aria-selected="false">
                            {{ __('pos.add-notes') }}
                        </a>
                    </div>
                </nav>
                <div class="mb-1">
                    <select autofocus id="product_id" class="col-8 selectpicker form-control"
                            data-style="btn-dark" data-live-search="true"
                            title="{{ __('pos.search-for-products-by-code-name-or-using-a-barcode-device') }}">
                        @foreach ($products as $product)
                            <option
                                value="{{ $product->id }}" data-tokens="{{ $product->code_universal }}"
                                product_name="{{$product->product_name}}"
                                product_price="{{$product->wholesale_price}}">
                                {{ $product->product_name }}
                            </option>
                        @endforeach
                    </select>
                    @if ($pos_settings->add_product == '1')
                        <a role="button" style="width: 3%;display: inline; border-radius: 0;"
                           class="col-1 modal-effect btn btn-sm btn-dark" data-toggle="modal" href="#modaldemo10">
                            <i class="fa fa-plus"></i>
                        </a>
                    @endif
                    <a style="width: 5%;display: inline; border-radius: 0;margin-right: 3px;"
                       class="btn btn-sm btn-success" href="pos-sales-report">
                        تقرير اليوم
                        <i style="font-size: 18px;position: relative;top: 3px;" class="fa fa-eye"></i>
                    </a>


                    @if($company->pos_settings->enableTableNum && $company->pos_settings->enableTableNum != 0)
                        <select
                            style="width: 5%;display: inline; border-radius: 0;margin-right: 3px;margin-top:5px !important;"
                            id="tableNum" autofocus class="col-1 selectpicker form-control" data-style="btn-dark"
                            data-live-search="true" title="{{ __('pos.chooseTableNum') }}">
                            <option value="" selected>اختر</option>
                            @php $counter = 1; @endphp
                            @while($counter <= 25)
                                <option value="{{$counter}}">{{$counter}}</option>

                                @php $counter++; @endphp
                            @endwhile

                        </select>
                    @endif

                </div>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="row mt-1">
                            <?php $i = 0; ?>
                            @foreach ($categories as $category)
                                <a
                                    class="category col-lg-2 pull-right text-center"
                                    category_id=@if($i == 0) "0" @else "{{ $category->id }}" @endif>
                                {{ $category->category_name }}
                                </a>
                                <?php $i++; ?>
                            @endforeach
                            <div class="clearfix"></div>
                        </div>
                        <div class="row pl-2 mt-1 sub_categories">

                        </div>
                        <div class="alert alert-danger"
                             style="display:none;height: 45px; text-align: center; font-weight: bold; font-size: 16px; background: #ff000026 !important;">
                            No Products Found!!
                        </div>
                        <div class="row mt-1 products">
                        </div>
                    </div>
                    <div class="tab-pane fade p-1" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <p>{{ __('pos.click-on-any-of-the-following-items-to-modify-it') }}</p>
                        <div class="row mb-1">
                            @if (isset($pending_pos) && !$pending_pos->isEmpty())
                                @foreach ($pending_pos as $pending)
                                    <div class="col-lg-4">
                                        <a href="#modaldemo3" class="btn btn-md btn-info pending modal-effect"
                                           data-toggle="modal" pos_open_id="{{ $pending->id }}"
                                           notes="{{ $pending->notes }}">
                                <span class="slice">
                                    {{ __('main.notes') }} :
                                    {{ $pending->notes }}
                                </span>
                                            <span class="slice">
                                    {{ __('main.client') }} :
                                    @if (isset($pending->outerClient->client_name))
                                                    {{ $pending->outerClient->client_name }}
                                                @endif
                                </span>
                                            <span class="slice">
                                    {{ __('main.date') }} :
                                    {{ $pending->created_at }}
                                </span>
                                            <span class="slice">
                                    {{ __('main.items') }} :
                                    @if (isset($pending))
                                                    <?php
                                                    $pending_elements = $pending->elements;
                                                    ?>
                                                    {{ $pending_elements->count() }}
                                                @else
                                                    0
                                                @endif
                                </span>
                                            <span class="slice">
                                    {{ __('main.total') }} :
                                    @if (isset($pending))
                                                    <?php
                                                    $pending_elements = $pending->elements;
                                                    $pending_discount = $pending->discount;
                                                    $pending_tax = $pending->tax;

                                                    $sum = 0;
                                                    foreach ($pending_elements as $pending_element) {
                                                        $sum = $sum + $pending_element->quantity_price;
                                                    }
                                                    if (isset($pending) && isset($pending_tax) && empty($pending_discount)) {
                                                        $tax_value = $pending_tax->tax_value;
                                                        $percent = ($tax_value / 100) * $sum;
                                                        $sum = $sum + $percent;
                                                    } elseif (isset($pending) && isset($pending_discount) && empty($pending_tax)) {
                                                        $discount_value = $pending_discount->discount_value;
                                                        $discount_type = $pending_discount->discount_type;
                                                        if ($discount_type == 'pound') {
                                                            $sum = $sum - $discount_value;
                                                        } else {
                                                            $discount_value = ($discount_value / 100) * $sum;
                                                            $sum = $sum - $discount_value;
                                                        }
                                                    } elseif (isset($pending) && !empty($pending_discount) && !empty($pending_tax)) {
                                                        $tax_value = $pending_tax->tax_value;
                                                        $discount_value = $pending_discount->discount_value;
                                                        $discount_type = $pending_discount->discount_type;
                                                        if ($discount_type == 'pound') {
                                                            $sum = $sum - $discount_value;
                                                        } else {
                                                            $discount_value = ($discount_value / 100) * $sum;
                                                            $sum = $sum - $discount_value;
                                                        }
                                                        $sum = $sum - $discount_value;
                                                        $percent = ($tax_value / 100) * $sum;
                                                        $sum = $sum + $percent;
                                                    }
                                                    echo $sum;
                                                    ?>
                                                @else
                                                    0
                                                @endif

                                </span>
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="tab-pane fade p-1" id="nav-bills" role="tabpanel" aria-labelledby="nav-bills-tab">
                        <p class="alert alert-warning alert-sm text-center">
                            {{ __('pos.if-an-invoice-number-is-modified,-the-current-open-invoice-will-be-suspended') }}
                        </p>
                        <div class="row mb-3">
                            <div class="col-lg-6 pull-right">
                                <div class="form-group">
                                    <label for="" class="d-block">{{ __('main.invoice') }}</label>
                                    <select class="form-control selectpicker" data-live-search="true"
                                            title="{{ __('main.invoice') }}" data-style="btn-danger" name="bill_id"
                                            id="bill_id" dir="rtl">
                                        @foreach ($bills as $bill)
                                            <option value="{{ $bill->id }}">({{ $bill->id }})
                                                @if (isset($bill->outerClient->client_name))
                                                    ({{ $bill->outerClient->client_name }})
                                                @endif
                                                ({{ $bill->created_at }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 pull-right" style="padding-top:25px">
                                <div class="form-group">
                                    <button class="btn btn-md btn-info edit_bill">
                                        <i class="fa fa-edit"></i>
                                        {{ __('pos.edit-invoice') }}
                                    </button>

                                    <!--<button class="btn btn-md btn-danger remove_bill">-->
                                    <!--    <i class="fa fa-trash"></i>-->
                                    <!--    حذف الفاتورة-->
                                    <!--</button>-->
                                </div>
                            </div>
                        </div>
                        <p id="msg" class="alert alert-sm alert-danger text-center" style="font-size: 14px;"></p>
                    </div>
                    <div class="tab-pane fade p-1" id="nav-status" role="tabpanel" aria-labelledby="nav-status-tab">
                        <div class="row mb-3">
                            <div class="col-lg-12 float-left pull-left text-left">
                                @if ($pos_settings->status == 'open')
                                    @if ($pos_status == 'none')
                                        <span class="fixed-bottom" style="margin-right: 200px!important; padding-bottom: 10px;
                                                                                                                                                                                                                                                    color: red; font-size: 14px;">
                                هذا المستخدم ليس متاح له اغلاق نقطة البيع لانه لا يتبع فرع معين
                            </span>
                                    @else
                                        <p class="alert alert-warning alert-sm text-center">
                                            باقفال اليومية واغلاق نقطة البيع .. سينتهى البيع فى هذا اليوم وسيتم اغلاق
                                            نقطة البيع
                                        </p>
                                        <a data-toggle="modal" href="#modaldemo30" class="btn btn-md btn-danger ">
                                            <i class="fa fa-close"></i>
                                            {{ __('pos.daily-closing') }}
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade p-1" id="nav-notes" role="tabpanel" aria-labelledby="nav-notes-tab">
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="d-block" for="">
                                            {{ __('main.notes') }}
                                        </label>
                                        <input type="text" name="notes" id="notes" class="form-control"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <button onclick="window.open('home','_self')" class="btn btn-md btn-success no-print">
                {{ __('main.back') }}
            </button>
        </div>
        <div class="col-lg-6 p-0 pr-1 pull-left">
            <div class="section">
                <div class="mb-1">
                    <select id="outer_client_id" class="selectpicker" data-style="btn-dark" data-live-search="true"
                            title="{{ __('pos.choose-client-name') }}">
                        @foreach ($outer_clients as $outer_client)
                            <option
                                @if($outer_client->client_name == 'Cash') selected @endif
                                value="{{ $outer_client->id }}">
                                {{ $outer_client->client_name }}
                            </option>
                        @endforeach
                    </select>
                    <a role="button" style="width: 5%;display: inline; border-radius: 0;margin-left: 5px;"
                       class="modal-effect btn btn-sm btn-dark show_outer_client" data-toggle="modal" href="#">
                        <i class="fa fa-eye"></i>
                    </a>
                    @if ($pos_settings->add_outer_client == '1')
                        <a role="button" style="width: 5%;display: inline; border-radius: 0;"
                           class="modal-effect btn btn-sm btn-dark" data-toggle="modal" href="#modaldemo9">
                            <i class="fa fa-plus"></i>
                        </a>
                    @endif
                </div>

                <div class="table-responsive"
                     style=" border:1px solid orangered;height: 370px; overflow:auto !important;">
                    <table class="table table-striped table-bordered table-condensed table-hover posTable"
                           style="margin-bottom: 0px; padding: 0px;">
                        <thead style="background: orangered; color: #fff;">
                        <tr>
                            <th style="width: 60%!important;"> {{ __('main.product-name') }}</th>
                            <th style="width: 10%!important;"> {{ __('main.amount') }}</th>
                            <th style="width: 15%!important;">{{ __('main.quantity') }}</th>
                            <th style="width: 10%!important;"> {{ __('main.discount') }}</th>
                            <th style="width: 10%!important;"> {{ __('main.total') }}</th>
                            <th style="width: 5%!important;text-align: center;">
                                @if(isset($pos_open) && $pos_open->editing)
                                    {{ __('main.return') }}
                                @else
                                    {{ __('main.delete') }}
                                @endif
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bill_details">
                        </tbody>
                    </table>
                </div>
                <table id="totalTable" style="width:100%; float:right; padding:5px; color:#000; background: #FFF;">
                    <tbody>
                    <tr>
                        <td style="padding: 5px 10px;border-top: 1px solid #DDD;"> {{ __('main.items') }}</td>
                        <td class="text-right"
                            style="padding: 5px 10px;font-size: 14px; font-weight:bold;border-top: 1px solid #DDD;">
                            <span id="items">
                                @if (isset($pos_open) && !$pos_open_elements->isEmpty())
                                    {{ $pos_open_elements->count() }}
                                    <?php
                                    $sum = 0;
                                    foreach ($pos_open_elements as $pos_open_element) {
                                        $sum = $sum + $pos_open_element->quantity;
                                    }
                                    ?>
                                @else
                                    0
                                @endif
                            </span>
                            <span id="total_quantity">
                                @if (isset($pos_open) && !$pos_open_elements->isEmpty())
                                    (
                                    <?php
                                    $sum = 0;
                                    foreach ($pos_open_elements as $pos_open_element) {
                                        $sum = $sum + $pos_open_element->quantity;
                                    }
                                    ?>
                                    {{ $sum }}
                                    )
                                @else
                                (0)
                                @endif
                            </span>
                        </td>
                        <td style="padding: 5px 10px;border-top: 1px solid #DDD;"> {{ __('main.total') }}</td>
                        <td class="text-right"
                            style="padding: 5px 10px;font-size: 14px; font-weight:bold;border-top: 1px solid #DDD;">
                            <span id="sum">
                                @if (isset($pos_open) && !$pos_open_elements->isEmpty())
                                    <?php
                                    $sum = 0;
                                    foreach ($pos_open_elements as $pos_open_element) {
                                        $sum = $sum + $pos_open_element->quantity_price;
                                    }
                                    ?>
                                    {{ $sum }}
                                @else
                                    0
                                @endif
                            </span>
                        </td>
                    </tr>
                    <tr>
                        @if ($pos_settings->tax == '1')
                            <td style="padding: 5px 10px;">
                                {{ __('main.order-tax') }}
                                <a href="#modaldemo6" data-toggle="modal" class="modal-effect">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <span class="text-danger noTaxAddedMsg font-weight-bold ml-2" style="display: none;">(لم يتم اضافة ضريبة)</span>
                                <br>
                                <span style="font-size: 13px;color: red">
                                ( {{ __('pos.it-is-added-to-the-total-bill-after-the-discount') }} )
                            </span>
                            </td>
                            <td class="text-right" style="padding: 5px 10px;font-size: 14px; font-weight:bold;">
                            <span id="tds_2">
                                <span id="taxValueAmount">0</span>
                                ( <span id="posTaxValue">0</span> %)
                            </span>
                            </td>
                        @endif
                        @if ($pos_settings->discount == '1')
                            <td style="padding: 5px 10px;"> {{ __('main.discount') }}
                                <a href="#modaldemo7" style="font-size: 17px !important;" data-toggle="modal"
                                   class="modal-effect">
                                    <i class="fa fa-edit" style="font-size: 17px !important;"></i>
                                </a>
                            </td>
                            <td class="text-right" style="padding: 5px 10px;font-weight:bold;">
                            <span id="tds">
                                @if (isset($pos_open) && !empty($pos_open_discount))
                                    <?php
                                    $discount_value = $pos_open_discount->discount_value;
                                    $discount_type = $pos_open_discount->discount_type;
                                    $sum = 0;
                                    foreach ($pos_open_elements as $pos_open_element) {
                                        $sum = $sum + $pos_open_element->quantity_price;
                                    }
                                    if ($discount_type == 'pound') {
                                        echo $discount_value;
                                    } else {
                                        echo $discount_value = ($discount_value / 100) * $sum;
                                        echo ' ( ' . $pos_open_discount->discount_value . ' % ) ';
                                    }
                                    ?>
                                @else
                                    0
                                @endif
                            </span>
                            </td>
                        @endif
                    </tr>
                    <tr>
                        <td style="padding: 5px 10px; border-top: 1px solid #666; border-bottom: 1px solid #333; font-weight:bold; background:#333; color:#FFF;"
                            colspan="2">
                            {{ __('main.total-amount') }}
                        </td>
                        <td class="text-right"
                            style="padding:5px 10px 5px 10px; font-size: 14px;border-top: 1px solid #666; border-bottom: 1px solid #333; font-weight:bold; background:#333; color:#FFF;"
                            colspan="2">
                            <span id="total" style="color: #fff !important;">
                                @if (isset($pos_open))
                                    <?php
                                    $sum = 0;
                                    foreach ($pos_open_elements as $pos_open_element) {
                                        $sum = $sum + $pos_open_element->quantity_price;
                                    }
                                    if (isset($pos_open) && isset($pos_open_tax) && empty($pos_open_discount)) {
                                        $tax_value = $pos_open_tax->tax_value;
                                        $percent = ($tax_value / 100) * $sum;
                                        $sum = $sum + $percent;
                                    } elseif (isset($pos_open) && isset($pos_open_discount) && empty($pos_open_tax)) {
                                        $discount_value = $pos_open_discount->discount_value;
                                        $discount_type = $pos_open_discount->discount_type;
                                        if ($discount_type == 'pound') {
                                            $sum = $sum - $discount_value;
                                        } else {
                                            $discount_value = ($discount_value / 100) * $sum;
                                            $sum = $sum - $discount_value;
                                        }
                                    } elseif (isset($pos_open) && !empty($pos_open_discount) && !empty($pos_open_tax)) {
                                        $tax_value = $pos_open_tax->tax_value;
                                        $discount_value = $pos_open_discount->discount_value;
                                        $discount_type = $pos_open_discount->discount_type;
                                        if ($discount_type == 'pound') {
                                            $sum = $sum - $discount_value;
                                        } else {
                                            $discount_value = ($discount_value / 100) * $sum;
                                            $sum = $sum - $discount_value;
                                        }
                                        $percent = ($tax_value / 100) * $sum;
                                        $sum = $sum + $percent;
                                    }
                                    echo $sum;
                                    ?>
                                @else
                                    0
                                @endif
                            </span>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="clearfix"></div>
                <div id="botbuttons" class="col-lg-12 text-center">
                    <input type="hidden" name="biller" id="biller" value="3">
                    <div class="row">
                        <div class="col-lg-6" style="padding: 0;">
                            <div class="btn-group-vertical btn-block">
                                @if ($pos_settings->suspension == '1')
                                    <a role="button" class="btn btn-warning btn-block btn-flat modal-effect"
                                       data-toggle="modal" href="#modaldemo4">
                                        <i class="fa fa-pause-circle-o"></i>
                                        {{ __('pos.hold-invoice') }}
                                    </a>
                                @endif
                                @if ($pos_settings->cancel == '1')
                                    <a role="button" class="btn btn-danger btn-block btn-flat modal-effect"
                                       data-toggle="modal" href="#modaldemo5">
                                        <i class="fa fa-trash-o"></i>
                                        {{ __('pos.cancel-invoice') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6" style="padding: 0;">
                            <div class="btn-group-vertical btn-block">
                                @if ($pos_settings->payment == '1')
                                    <a href="#modaldemo" role="button" data-toggle="modal"
                                       class="btn btn-success btn-block modal-effect" id="payment" tabindex="-1">
                                        <i class="fa fa-money"></i>
                                        {{ __('pos.record-payment') }}
                                    </a>
                                @endif
                                @if ($pos_settings->print_save == '1')
                                    <button type="button" class="btn btn-info btn-block" id="save_pos" tabindex="-1">
                                        <i class="fa fa-save"></i>
                                        {{ __('pos.save-and-print') }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if ($pos_settings->fast_finish == '1')
                        <div class="row">
                            <div class="col-lg-12 row p-0 mx-auto">
                                <div class="col-6 p-0">
                                    <button type="button" id="finishBank"
                                            style="background: #053e59d4;border-color:#053e59d4;"
                                            class="btn btn-dark btn-block btn-md modal-effect mb-3">
                                        <i class="fa fa-check-circle-o"></i>
                                        دفع شبكة سريع
                                    </button>
                                </div>
                                <div class="col-6 p-0">
                                    <button type="button" id="finish"
                                            class="btn btn-dark btn-block btn-md modal-effect mb-3">
                                        <i class="fa fa-check-circle-o"></i>
                                        {{ __('pos.pay-the-main-safe-cash-and-save-print-the-bill') }}
                                    </button>
                                </div>

                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" dir="rtl" id="modaldemo" tabindex="-1" role="dialog" aria-labelledby="modaldemo">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header w-100">
                    <h4 class="modal-title text-center" id="modaldemo">{{ __('main.cash') }}</h4>
                </div>
                <div class="modal-body">
                    @if ((isset($pos_cash) && !$pos_cash->isEmpty()) || (isset($pos_bank_cash) && !$pos_bank_cash->isEmpty()) || (isset($pos_coupon_cash) && !$pos_coupon_cash->isEmpty()))
                        <table class="table table-condensed table-striped table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('main.amount') }}</th>
                                <th>{{ __('main.payment-method') }}</th>
                                <th>{{ __('main.delete') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $j = 0; ?>
                            @if (isset($pos_cash) && !$pos_cash->isEmpty())
                                @foreach ($pos_cash as $cash)
                                    <tr>
                                        <td>{{ ++$j }}</td>
                                        <td>{{ $cash->amount }}</td>
                                        <td>{{ __('main.cash') }}
                                            <br>
                                            ({{ $cash->safe->safe_name }})
                                        </td>
                                        <td>
                                            <button type="button" payment_method="cash" cash_id="{{ $cash->id }}"
                                                    class="btn btn-danger delete_pay">{{ __('main.delete') }}
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            @if (isset($pos_bank_cash) && !$pos_bank_cash->isEmpty())
                                @foreach ($pos_bank_cash as $cash)
                                    <tr>
                                        <td>{{ ++$j }}</td>
                                        <td>{{ $cash->amount }}</td>
                                        <td>دفع بنكى شبكة
                                            <br>
                                            @if(!empty($cash->bank_id))
                                                ({{ $cash->bank->bank_name }})
                                            @endif
                                            <br>
                                            ( {{ $cash->bank_check_number }} )
                                        </td>
                                        <td>
                                            <button type="button" payment_method="bank" cash_id="{{ $cash->id }}"
                                                    class="btn btn-danger delete_pay">حذف
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            @if (isset($pos_coupon_cash) && !$pos_coupon_cash->isEmpty())
                                @foreach ($pos_coupon_cash as $cash)
                                    <tr>
                                        <td>{{ ++$j }}</td>
                                        <td>{{ $cash->amount }}</td>
                                        <td>دفع كوبون خصم
                                            <br>
                                            ({{ $cash->coupon->coupon_code }})
                                        </td>
                                        <td>
                                            <button type="button" payment_method="coupon" cash_id="{{ $cash->id }}"
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
                    <h5 class="col-lg-12 d-block mb-1">{{ __('main.main-information') }}</h5>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-md-4" style="display: none;">
                            <label> رقم العملية <span class="text-danger">*</span></label>
                            <input required readonly value="{{ $pre_cash }}" class="form-control" id="cash_number"
                                   type="text">
                        </div>
                        <div class="col-md-6">
                            <label> {{ __('main.paid-amount') }} <span class="text-danger">*</span></label>
                            <input required class="form-control" id="amount" type="number" dir="ltr">
                        </div>
                        <div class="col-md-6">
                            <label> {{ __('main.payment-method') }} <span class="text-danger">*</span></label>
                            <select required id="payment_method" name="payment_method" class="form-control">
                                <option value="">{{ __('main.payment-method') }}</option>
                                <option value="cash">دفع كاش نقدى</option>
                                <option value="bank">دفع بنكى شبكة</option>
                                <option value="coupon">دفع كوبون خصم</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3 extra_div cash" style="display: none;">
                        <div class="col-md-6">
                            <label class="d-block"> خزنة الدفع <span class="text-danger">*</span></label>
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
                    <div class="row mb-3 extra_div coupon" style="display: none;">
                        <div class="col-md-4">
                            <label> رقم كوبون الخصم <span class="text-danger">*</span></label>
                            <select class="form-control selectpicker show-tick" data-style="btn-info"
                                    data-live-search="true" data-title="اختر الكوبون" name="couponcode" id="couponcode">
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3 extra_div bank" style="display: none;">
                        <!------bank_id-------->
                        <div class="col-md-4">
                            <label class="d-block"> {{ __('banks.bank-name') }}
                                <span class="text-danger">*</span>
                            </label>
                            <select
                                style="width: 80% !important; display: inline !important;" id="bank_id"
                                class="form-control" required>
                                <option value="">{{ __('banks.bank-name') }}</option>
                                @foreach ($banks as $bank)
                                    <option value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
                                @endforeach
                            </select>
                            <a target="_blank" href="{{ route('client.banks.create') }}" role="button"
                               style="width: 15%;display: inline;" class="btn btn-sm btn-warning open_popup">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                        <!------bank_check_number-------->
                        <div class="col-md-4">
                            <label for="">رقم المعاملة</label>
                            <input type="text" class="form-control" id="bank_check_number"/>
                        </div>
                        <!------bank_notes-------->
                        <div class="col-md-4">
                            <label for="">{{ __('main.notes') }}</label>
                            <input type="text" class="form-control" id="bank_notes"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button
                            class="btn btn-info pd-x-20 pay_cash"
                            type="button">
                            {{ __('banks.record-process') }}
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="client_name" id="client_name"/>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i>
                        اغلاق
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-----modal for choosing fast bank------->
    <div class="modal" id="finishBankModal">
        <div class="modal-dialog modal-sm modal-dialog-centered" capital="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header text-center">
                    <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">
                        اختر البنك
                    </h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="row extra_div bank">
                    <!------bank_id-------->
                    <div class="col-md-12 p-2">
                        <label class="d-block"> {{ __('banks.bank-name') }}
                            <span class="text-danger">*</span>
                        </label>
                        <select
                            style="width: 90% !important; display: inline !important;" id="fast_bank_id"
                            class="form-control" required>
                            <option value="">{{ __('banks.bank-name') }}</option>
                            @foreach ($banks as $bank)
                                <option value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
                            @endforeach
                        </select>
                        <a target="_blank" href="{{ route('client.banks.create') }}" role="button"
                           style="width: 15%;display: inline;" class="btn btn-sm btn-warning open_popup">
                            <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center mb-2">
                    <button
                        class="btn btn-info finishBank" type="button">
                        {{ __('banks.record-process') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!---------------------------------------->

    <div class="modal" id="modaldemo3">
        <div class="modal-dialog modal-sm modal-dialog-centered" capital="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header text-center">
                    <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">
                        انتبه من فضلك
                    </h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        اضغط على التعديل على الفاتورة المعلقة لترك هذة الصفحة ورجوع للبقاء فى الصفحة
                        <br>
                        سوف تفقد كل بيانات البيع اذا غادرت هذة الصفحة
                    </div>
                    <input type="hidden" id="posopenid"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" id="open_pending"> التعديل على الفاتورة المعلقة</button>
                    <button type="button" class="btn btn-dark" data-dismiss="modal">رجوع</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modaldemo4">
        <div class="modal-dialog modal-sm modal-dialog-centered" capital="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header text-center">
                    <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">
                        تعليق عملية البيع وحفظها كفاتورة مفتوحة
                    </h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <h5>
                        برجاء كتابة الملاحظة المرجعية لتعليق هذة العملية.
                    </h5>
                    <div class="form-group">
                        <label for="">
                            ملاحظة مرجعية
                        </label>
                        <input type="text" class="form-control" id="notes_2"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" id="pending">تعليق الفاتورة</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">رجوع</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modaldemo5">
        <div class="modal-dialog modal-sm modal-dialog-centered" capital="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header text-center">
                    <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">الغاء الفاتورة المفتوحة حاليا
                    </h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        هل تريد بالفعل الغاء الفاتورة المفتوحة حاليا ؟؟
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="reset">الغاء الفاتورة</button>
                    <button type="button" class="btn btn-dark" data-dismiss="modal">رجوع</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modaldemo6">
        <div class="modal-dialog modal-sm modal-dialog-centered" capital="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header text-center">
                    <h6 class="modal-title w-100" style="font-family: 'Cairo'; "> تحرير النظام الضريبي
                    </h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="" class="d-block">ضريبة الطلب</label>

                        <select id="tax_id" class="form-control d-inline float-left w-50">
                            <option value="" selected disabled>اختر نوع الضريبة</option>
                            @foreach ($taxes as $tax)
                                <option
                                    @if (isset($pos_open) && !empty($pos_open_tax) && $pos_open_tax->tax_id == $tax->id)
                                    selected
                                    @endif
                                    @if($pos_settings->taxStatusPos == 1 && $tax->tax_value == 15) selected @endif
                                    @if($pos_settings->taxStatusPos == 2 && $tax->tax_value == 130) selected @endif
                                    taxvalue="{{ $tax->tax_value }}" value="{{ $tax->id }}">{{ $tax->tax_name }}
                                </option>
                            @endforeach

                            <option value="inclusive" @if($pos_settings->taxStatusPos == 3) selected @endif>شامل
                                الضريبة
                            </option>
                        </select>

                        <!--for saving tax value-->
                        <input type="number" id="tax_value"
                               @if (isset($pos_open) && !empty($pos_open_tax))
                               value="{{ $pos_open_tax->tax_value }}"
                               @endif style="width: 40%;" name="tax_value"
                               class="form-control d-inline float-right"
                        />

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success save_tax">حفظ</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modaldemo7">
        <div class="modal-dialog modal-sm modal-dialog-centered" capital="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header text-center">
                    <h6 class="modal-title w-100" style="font-family: 'Cairo'; "> إضافة خصم على إجمالى الفاتورة</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="" class="d-block">قيمة الخصم</label>
                        <select name="discount_type" id="discount_type" class="form-control"
                                style="width: 40%;display: inline;float: right; margin-left:5px;">
                            <option
                                @if (isset($pos_open) && !empty($pos_open_discount) && $pos_open_discount->discount_type == 'pound') selected
                                @endif value="pound">{{ $currency }}
                            </option>
                            <option
                                @if (isset($pos_open) && !empty($pos_open_discount) && $pos_open_discount->discount_type == 'percent') selected
                                @endif value="percent"> %
                            </option>
                        </select>
                        <input type="number" dir="ltr" class="form-control text-right"
                               @if (isset($pos_open) && !empty($pos_open_discount)) value="{{ $pos_open_discount->discount_value }}"
                               @endif style="width: 50%;display: inline;float: right;" id="discount_value"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success save_discount">حفظ</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modaldemo8">
        <div class="modal-dialog modal-lg modal-dialog-centered" capital="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header text-center">
                    <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">عرض بيانات العميل</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body outer_client_details">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modaldemo9">
        <div class="modal-dialog modal-lg modal-dialog-centered" capital="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header text-center">
                    <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">اضافة عميل جديد</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="col-lg-6 pull-right">
                        <div class="form-group col-lg-12 pull-right" dir="rtl">
                            <label for="order">اسم العميل
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="client_name2" class="form-control">
                        </div>
                        <div class="form-group col-lg-12 pull-right" dir="rtl">
                            <label for="client_category">فئة التعامل
                                <span class="text-danger">*</span>
                            </label>
                            <select id="client_category" class="form-control">
                                <option value="">اختر الفئة</option>
                                <option value="جملة">جملة</option>
                                <option selected value="قطاعى">قطاعى</option>
                            </select>
                        </div>
                        <div class="form-group pull-right col-lg-12" dir="rtl">
                            <label for="prev_balance">مديونية العميل
                                <span class="text-danger">*</span>
                            </label>
                            <input type="number" value="0" id="prev_balance" class="form-control" dir="ltr"/>
                        </div>
                        <div class="form-group pull-right col-lg-12" dir="rtl">
                            <label for="address">
                                العنوان
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" value="" id="client_address" class="form-control" dir="rtl"/>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                    <div class="col-lg-6  pull-left">
                        <div class="form-group col-lg-12 pull-right" dir="rtl">
                            <label for="client_email">البريد الالكترونى</label>
                            <input type="email" id="client_email" dir="ltr" class="form-control">
                        </div>
                        <div class="form-group pull-right col-lg-12" dir="rtl">
                            <label for="shop_name">اسم محل / شركة العميل</label>
                            <input type="text" id="shop_name" class="form-control" dir="rtl">
                        </div>
                        <div class="form-group pull-right col-lg-12" dir="rtl">
                            <label for="client_national">جنسية العميل
                                <span class="text-danger">*</span>
                            </label>
                            <select id="client_national" class="form-control">
                                <option value="">اختر دولة</option>
                                @foreach ($timezones as $timezone)
                                    <option @if ($timezone->country_name == 'السعودية') selected @endif
                                    value="{{ $timezone->country_name }}">{{ $timezone->country_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group pull-right col-lg-12" dir="rtl">
                            <label for="client_phone">
                                رقم الهاتف
                                <span class="text-danger">*</span>
                            </label>
                            <input type="number" value="" id="client_phone" class="form-control" dir="ltr"/>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                    <button type="button" class="btn btn-success add_outer_client">اضافة</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modaldemo10">
        <div class="modal-dialog modal-lg modal-dialog-centered" capital="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header text-center">
                    <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">اضافة منتج جديد</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="col-lg-6 pull-right">
                        <div class="form-group  col-lg-6  pull-right" dir="rtl">
                            <label for="store_id">اسم المخزن</label>
                            <select style="width: 80%; display: inline;" id="store_id" class="form-control">
                                <option value="">اختر المخزن</option>
                                @foreach ($stores as $store)
                                    <option value="{{ $store->id }}">{{ $store->store_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group  col-lg-6  pull-right" dir="rtl">
                            <label for="category_id">اسم الفئة</label>
                            <select style="display: inline; width: 80%;" id="category_id" class="form-control">
                                <option value="">اختر الفئة</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" type="{{ $category->category_type }}">
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group  col-lg-12  pull-right" dir="rtl">
                            <label style="display: block;">رقم الباركود </label>
                            <input type="text" value="{{ $code_universal }}" class="form-control text-left" dir="ltr"
                                   id="code_universal"/>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group  col-lg-12  pull-right" dir="rtl">
                            <label for="order">اسم المنتج </label>
                            <input type="text" id="product_name" class="form-control" dir="rtl">
                        </div>
                        <div class="form-group col-lg-12  pull-right" dir="ltr">
                            <label for="first_balance">رصيد المخازن</label>
                            <input value="0" type="number" id="first_balance" class="form-control text-right">
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-lg-6  pull-left">
                        <div class="form-group  pull-right col-lg-12" dir="ltr">
                            <label for="purchasing_price">سعر التكلفة</label>
                            <input value="0" type="number" id='purchasing_price' class="form-control text-right">
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group  pull-right col-lg-12" dir="ltr">
                            <label for="wholesale_price">سعر الجملة</label>
                            <input value="0" type="number" id="wholesale_price" class="form-control text-right">
                        </div>
                        <div class="form-group  pull-right col-lg-12" dir="ltr">
                            <label for="sector_price">سعر القطاعى</label>
                            <input value="0" type="number" id="sector_price" class="form-control text-right">
                        </div>
                        <div class="form-group pull-right col-lg-12" dir="ltr">
                            <label for="min_balance">رصيد حد أدنى المخازن</label>
                            <input value="0" type="number" id="min_balance" class="form-control text-right"/>
                        </div>
                        <div class="clearfix"></div>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                    <button type="button" class="btn btn-success add_product">اضافة</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modaldemo30">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header text-center">
                    <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">
                        اقفال اليومية ( اغلاق نقطة البيع )
                    </h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('pos.open.close') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <p>هل انت متأكد انك تريد اقفال اليومية ( اغلاق نقطة البيع ) ؟</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">
                            اقفال اليومية
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <input type="hidden" id="final_total" @if (isset($pos_open)) value="{{ $sum }}" @else value="0" @endif />
    <input type="hidden" value="{{ date('Y-m-d') }}" id="date"/>
    <input type="hidden" value="{{ date('h:i:s') }}" id="time"/>
    <input
        type="hidden" id="sale_bill_number"
        @if (isset($pos_open))
        value="{{ $pos_open->id }}"
        @else
        value="0"
        @endif >

@endsection
<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        //get tax value
        let posTaxValue = localStorage.getItem('pos_tax_value');
        if (!posTaxValue) {
            $(".noTaxAddedMsg").show();
        } else {
            $("#posTaxValue").text(posTaxValue);
        }
        //chk if الضريبة الانتقائية exists or not. if not add it
        $.post("{{route('pos.open.checkTaxEntka2ya')}}", function (res) {
            if (res === 1)
                window.location.reload();
        });

        //when selecting product from selectbox...
        $('#product_id').on('change', function () {
            let product_id = $(this).val();
            let product_price = $(this).find(':selected').attr('product_price');
            let product_name = $(this).find(':selected').attr('product_name');
            let outer_client_id = $('#outer_client_id').val();
            if (outer_client_id.length == 0) {
                alert('يرجي اختيار العميل');
                return false;
            }

            if ($("#" + product_id).length == 0) {
                //add new row to the table..
                var productRow = '<tr id="' + product_id + '"> <td>' + product_name + '</td> <td><input type="number" id="edit_price-' + product_id + '" class="edit_price w-100" value="' + product_price + '"></td> <td><input type="number" id="edit_quantity-' + product_id + '" class="edit_quantity w-100" value="1"></td> <td><input type="number" id="edit_discount-' + product_id + '" class="edit_discount w-100" value="0"></td> <td id="totalPrice-' + product_id + '" class="totalPrice">' + product_price + '</td> <td class="no-print"> <button class="btn btn-sm btn-danger remove_element"> <i class="fa fa-trash"></i> </button> </td> </tr>';
                $('.bill_details').append(productRow);
            } else {
                //update qty on table of products..
                $('#edit_quantity-' + product_id).val(Number($('#edit_quantity-' + product_id).val()) + 1);
            }
            var audioElement = document.createElement('audio');
            audioElement.setAttribute('src', "{{ asset('app-assets/mp3/beep.mp3') }}");
            audioElement.play();
            $('#product_id').val('');

            refreshBillDetails();
        });

        //save_discount...
        $('.save_discount').on('click', function () {
            let discount_type = $('#discount_type').val();
            let discount_value = $('#discount_value').val();
            if (discount_value == "") {
                $('#discount_value').css('border', '1px solid red');
            } else {
                $('#discount_value').css('border', '1px solid #BABFC7');
                $.post("{{ route('pos.open.store.discount') }}", {
                    discount_type: discount_type,
                    discount_value: discount_value,
                    "_token": "{{ csrf_token() }}"
                }, function (data) {
                    $('#modaldemo7').modal('toggle');
                    if (discount_type == "pound") {
                        $('#tds').html(discount_value);
                    } else {
                        $('#tds').html(discount_value + " % ");
                    }
                    $.post("{{ url('/client/pos-open/refresh') }}", {
                            "_token": "{{ csrf_token() }}"
                        },
                        function (proto) {
                            $('#items').html(proto.items);
                            $('#total_quantity').html("( " + proto.total_quantity + " )");
                            $('#sum').html(proto.sum);
                            $('#total').html(proto.total);
                            $('#final_total').val(proto.total);
                            $('#tds_2').html(proto.percent);
                            $('#tds').html(proto.discount_value);

                        });
                });
            }
        });

        //tax_id...
       $('#tax_id').on('change', function () {
            let tax_id = $(this).val();
            let tax_value = 0;
            if (tax_id == 0) {
                tax_value = 0;
            } else if (tax_id == 'inclusive') {
                tax_value = 'inclusive';
            } else {
                tax_value = $('option:selected', this).attr('taxvalue');
            }
            $('#tax_value').val(tax_value);
        });

        //save_tax...
        $('.save_tax').on('click', function () {
            //getting tax_id & tax_value
            let tax_id = $('#tax_id').val();
            let tax_value = $('#tax_value').val();
            if (tax_id == "") {
                $('#tax_id').css('border', '1px solid red');
            } else if (tax_id != 'inclusive' && tax_value == "") {
                $('#tax_value').css('border', '1px solid red');
            } else {
                localStorage.setItem('pos_tax_value', tax_value);
                window.location.reload();
            }
        });

        //pending...
        $('#pending').on('click', function () {
            let notes = $('#notes_2').val();
            if (notes == "") {
                alert('لابد وان تكتب الملاحظة المرجعية');
            } else {
                $.post("{{ route('pos.open.pending') }}", {
                    "_token": "{{ csrf_token() }}",
                    notes: notes
                }, function (data) {
                    $('#modaldemo4').modal('toggle');
                    alert(data.reason);
                    if (data.success == 1) {
                        location.reload();
                    }
                });
            }
        });

        $('#reset').on('click', function () {
            let final_total = $('#final_total').val();
            $.post("{{ route('pos.open.delete') }}", {
                "_token": "{{ csrf_token() }}",
                final_total: final_total,
            }, function (data) {
                $('#modaldemo5').modal('toggle');
                alert(data.reason);
                if (data.success == 1) {
                    location.reload();
                }
            });
        });

        $('.category').on('click', function () {
            var category_id = $(this).attr('category_id');
            var sub_category_id = "all";
            $.post("{{ url('/client/pos/get-subcategories-by-category-id') }}", {
                category_id: category_id,
                "_token": "{{ csrf_token() }}"
            }, function (data) {
                $('.sub_categories').html(data);
                console.log(data);
                if (data.length !== 0) {
                    $('.products').empty();
                    //  $.post("{{ url('/client/pos/get-products-by-sub-category-id') }}", {
                    //     sub_category_id: sub_category_id,
                    //     category_id: category_id,
                    //     "_token": "{{ csrf_token() }}"
                    // }, function(data) {
                    //     $('.products').html(data);
                    // });
                } else {
                    $.post("{{ url('/client/pos/get-products-by-category-id') }}", {
                        category_id: category_id,
                        "_token": "{{ csrf_token() }}"
                    }, function (data) {
                        if (data.length === 0) {
                            $(".alert-danger").slideDown("slow");
                        } else {
                            $(".alert-danger").slideUp("slow");
                        }
                        $('.products').empty();
                        $('.products').html(data);
                    })
                }
            });
        });

        $('.sub_category').on('click', function () {
            var sub_category_id = $(this).attr('sub_category_id');
            $.post("{{ url('/client/pos/get-products-by-sub-category-id') }}", {
                sub_category_id: sub_category_id,
                "_token": "{{ csrf_token() }}"
            }, function (data) {
                $('.products').html(data);
            });
        });

        $('.add_outer_client').on('click', function () {
            let client_name = $('#client_name2').val();
            let client_email = $('#client_email').val();
            let client_phone = $('#client_phone').val();
            let client_address = $('#client_address').val();
            let client_national = $('#client_national').val();
            let prev_balance = $('#prev_balance').val();
            let shop_name = $('#shop_name').val();
            let client_category = $('#client_category').val();
            if (client_name == "" || client_national == "" || prev_balance == "" || client_category ==
                "") {
                if (client_name == "") {
                    $('#client_name2').css('border', '1px solid red');
                } else {
                    $('#client_name2').css('border', '1px solid #BABFC7');
                }
                if (client_national == "") {
                    $('#client_national').css('border', '1px solid red');
                } else {
                    $('#client_national').css('border', '1px solid #BABFC7');
                }
                if (prev_balance == "") {
                    $('#prev_balance').css('border', '1px solid red');
                } else {
                    $('#prev_balance').css('border', '1px solid #BABFC7');
                }
                if (client_category == "") {
                    $('#client_category').css('border', '1px solid red');
                } else {
                    $('#client_category').css('border', '1px solid #BABFC7');
                }
            } else {
                $.post("{{ route('client.outer_clients.storePos') }}", {
                    client_name: client_name,
                    client_email: client_email,
                    client_phone: client_phone,
                    client_address: client_address,
                    client_national: client_national,
                    prev_balance: prev_balance,
                    shop_name: shop_name,
                    client_category: client_category,
                    "_token": "{{ csrf_token() }}"
                }, function (data) {
                    let outer_client_id = data.outer_client_id;
                    let outer_client_name = data.client_name;
                    $('#client_name2').val('');
                    $('#client_email').val('');
                    $('#client_phone').val('');
                    $('#client_address').val('');
                    $('#client_national').val('');
                    $('#prev_balance').val('');
                    $('#shop_name').val('');
                    $('#client_category').val('');
                    $('#modaldemo9').modal('toggle');
                    $('select#outer_client_id').append('<option selected value="' +
                        outer_client_id + '">' + outer_client_name + '</option>');
                    $('select#outer_client_id').selectpicker('refresh');
                });
            }
        });

        $('.show_outer_client').on('click', function () {
            let outer_client_id = $('#outer_client_id').val();
            if (outer_client_id == "") {
                alert('اختر العميل اولا');
            } else {
                $.post("{{ route('client.outer_clients.showPos') }}", {
                    outer_client_id: outer_client_id,
                    "_token": "{{ csrf_token() }}"
                }, function (data) {
                    $('.outer_client_details').html(data);
                    $('#modaldemo8').modal('toggle');
                });
            }
        });

        $('.add_product').on('click', function () {
            let store_id = $('#store_id').val();
            let category_id = $('#category_id').val();
            let product_name = $('#product_name').val();
            let wholesale_price = $('#wholesale_price').val();
            let first_balance = $('#first_balance').val();
            let sector_price = $('#sector_price').val();
            let purchasing_price = $('#purchasing_price').val();
            let code_universal = $('#code_universal').val();
            let min_balance = $('#min_balance').val();

            if (product_name == "" || store_id == "" || category_id == "" || wholesale_price == "" ||
                first_balance == "" ||
                sector_price == "" || purchasing_price == "" || min_balance == "") {

                if (product_name == "") {
                    $('#product_name').css('border', '1px solid red');
                } else {
                    $('#product_name').css('border', '1px solid #BABFC7');
                }
                if (store_id == "") {
                    $('#store_id').css('border', '1px solid red');
                } else {
                    $('#store_id').css('border', '1px solid #BABFC7');
                }
                if (category_id == "") {
                    $('#category_id').css('border', '1px solid red');
                } else {
                    $('#category_id').css('border', '1px solid #BABFC7');
                }
                if (wholesale_price == "") {
                    $('#wholesale_price').css('border', '1px solid red');
                } else {
                    $('#wholesale_price').css('border', '1px solid #BABFC7');
                }
                if (first_balance == "") {
                    $('#first_balance').css('border', '1px solid red');
                } else {
                    $('#first_balance').css('border', '1px solid #BABFC7');
                }
                if (sector_price == "") {
                    $('#sector_price').css('border', '1px solid red');
                } else {
                    $('#sector_price').css('border', '1px solid #BABFC7');
                }
                if (purchasing_price == "") {
                    $('#purchasing_price').css('border', '1px solid red');
                } else {
                    $('#purchasing_price').css('border', '1px solid #BABFC7');
                }
                if (min_balance == "") {
                    $('#min_balance').css('border', '1px solid red');
                } else {
                    $('#min_balance').css('border', '1px solid #BABFC7');
                }

            } else {
                $.post("{{ route('client.products.storePos') }}", {
                    store_id: store_id,
                    category_id: category_id,
                    product_name: product_name,
                    wholesale_price: wholesale_price,
                    first_balance: first_balance,
                    sector_price: sector_price,
                    purchasing_price: purchasing_price,
                    code_universal: code_universal,
                    min_balance: min_balance,
                    "_token": "{{ csrf_token() }}"
                }, function (data) {
                    let product_id = data.product_id;
                    let product_name = data.product_name;
                    let code_universal = data.code_universal;
                    $('#store_id').val('');
                    $('#category_id').val('');
                    $('#product_name').val('');
                    $('#wholesale_price').val('');
                    $('#first_balance').val('');
                    $('#sector_price').val('');
                    $('#purchasing_price').val('');
                    $('#code_universal').val('');
                    $('#min_balance').val('');
                    $('#modaldemo10').modal('toggle');
                    $('select#product_id').append('<option selected value="' + product_id +
                        '" data-tokens= "' + code_universal + '">' + product_name +
                        '</option>');
                    $('select#product_id').selectpicker('refresh');
                });
            }
        });

        $('.pending').on('click', function () {
            var pos_open_id = $(this).attr('pos_open_id');
            var notes = $(this).attr('notes');
            $('#posopenid').val(pos_open_id);
            $('#notes_2').val(notes);
        });

        $('#open_pending').on('click', function () {
            let pos_open_id = $('#posopenid').val();
            $.post("{{ route('pos.open.restore') }}", {
                "_token": "{{ csrf_token() }}",
                "pos_open_id": pos_open_id
            }, function (data) {
                $('#modaldemo3').modal('toggle');
                location.reload();
            });
        });

        $('#payment_method').on('change', function () {
            let payment_method = $(this).val();
            let outer_client_id = $('#outer_client_id').val();
            if (payment_method == "cash") {
                $('.cash').show();
                $('.bank').hide();
                $('.coupon').hide();
            } else if (payment_method == "bank") {
                $('.bank').show();
                $('.cash').hide();
                $('.coupon').hide();
            } else if (payment_method == "coupon") {
                $.post("{{ route('get.coupon.codes') }}", {
                    "_token": "{{ csrf_token() }}",
                    outer_client_id: outer_client_id,
                }, function (data) {
                    $('#couponcode').html(data);
                    $('#couponcode').selectpicker('refresh');
                });

                $('.coupon').show();
                $('.bank').hide();
                $('.cash').hide();
            } else {
                $('.bank').hide();
                $('.cash').hide();
                $('.coupon').hide();
            }
        });

        $('#couponcode').on('change', function () {
            let coupon_code = $(this).val();
            $.post("{{ route('get.coupon.code') }}", {
                "_token": "{{ csrf_token() }}",
                "coupon_code": coupon_code,
            }, function (data) {
                if (data.status == "success") {
                    $('#amount').val(data.coupon_value).attr('readonly', true);
                    $('.pay_cash').removeClass('disabled');
                    $('.pay_cash').attr('disabled', false);
                } else {
                    $('.pay_cash').addClass('disabled');
                    $('.pay_cash').attr('disabled', true);
                    $('#amount').val("").attr('readonly', false);
                }
            });
        });

        $('#payment').on('click', function () {
            let final_total = $('#final_total').val();
            $('#amount').val(final_total);
            $.post("{{ route('pos.open.check') }}", {
                "_token": "{{ csrf_token() }}",
            }, function (data) {
                if (data.success == 0) {
                    alert(data.reason);
                    $('#modaldemo').modal('hide');
                }
            });
        });

        $('.pay_cash').on('click', function () {
            let company_id = $('#company_id').val();
            let outer_client_id = $('#outer_client_id').val();
            let sale_bill_number = "pos_" + $('#sale_bill_number').val();
            if (sale_bill_number == 'pos_0') {
                //start ajax get last bill to get id of new on...
                $.post("{{route('getNewPosBillID')}}", function (data) {
                    sale_bill_number = "pos_" + data;
                    let date = $('#date').val();
                    let time = $('#time').val();
                    let coupon_code = $('#couponcode').val();
                    let cash_number = $('#cash_number').val();
                    let amount = $('#amount').val();
                    let safe_id = $('#safe_id').val();
                    let bank_id = $('#bank_id').val();
                    let bank_check_number = $('#bank_check_number').val();
                    let notes = $('#bank_notes').val();
                    let payment_method = $('#payment_method').val();
                    if (payment_method == "") {
                        alert('اختر طريقة الدفع');
                    } else {
                        $.post("{{ route('client.store.cash.clients.pos', 'test') }}", {
                            outer_client_id: outer_client_id,
                            company_id: company_id,
                            bill_id: sale_bill_number,
                            date: date,
                            time: time,
                            coupon_code: coupon_code,
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
                                $('<div class="alert alert-dark alert-sm"> ' + data.msg + '</div>')
                                    .insertAfter('#company_id');

                                $('.delete_pay').on('click', function () {
                                    let payment_method = $(this).attr('payment_method');
                                    let cash_id = $(this).attr('cash_id');
                                    $.post("{{ route('pay.delete') }}", {
                                        '_token': "{{ csrf_token() }}",
                                        payment_method: payment_method,
                                        cash_id: cash_id,
                                    }, function (data) {

                                    });
                                    $(this).parent().hide();
                                });
                            } else {
                                $('<p class="alert alert-danger alert-sm"> ' + data.msg + '</p>')
                                    .insertAfter('#company_id');
                            }
                        });
                    }


                    return;
                });
            } else {
                let date = $('#date').val();
                let time = $('#time').val();
                let coupon_code = $('#couponcode').val();
                let cash_number = $('#cash_number').val();
                let amount = $('#amount').val();
                let safe_id = $('#safe_id').val();
                let bank_id = $('#bank_id').val();
                let bank_check_number = $('#bank_check_number').val();
                let notes = $('#bank_notes').val();
                let payment_method = $('#payment_method').val();
                if (payment_method == "") {
                    alert('اختر طريقة الدفع');
                } else {
                    $.post("{{ route('client.store.cash.clients.pos', 'test') }}", {
                        outer_client_id: outer_client_id,
                        company_id: company_id,
                        bill_id: sale_bill_number,
                        date: date,
                        time: time,
                        coupon_code: coupon_code,
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
                            $('<div class="alert alert-dark alert-sm"> ' + data.msg + '</div>')
                                .insertAfter('#company_id');

                            $('.delete_pay').on('click', function () {
                                let payment_method = $(this).attr('payment_method');
                                let cash_id = $(this).attr('cash_id');
                                $.post("{{ route('pay.delete') }}", {
                                    '_token': "{{ csrf_token() }}",
                                    payment_method: payment_method,
                                    cash_id: cash_id,
                                }, function (data) {

                                });
                                $(this).parent().hide();
                            });
                        } else {
                            $('<p class="alert alert-danger alert-sm"> ' + data.msg + '</p>')
                                .insertAfter('#company_id');
                        }
                    });
                }
            }
        });

        $('#save_pos').on('click', function () {
            let final_total = $('#final_total').val();
            let notes = $('#notes').val();
            let tableNum = $('#tableNum').val();
            $.post("{{ route('pos.open.done') }}", {
                "_token": "{{ csrf_token() }}",
                final_total: final_total,
                tableNum: tableNum,
                notes: notes,
            }, function (data) {
                // alert(data.reason);
                if (data.success == 1) {
                    location.href = '/pos-print/' + data.pos_id;
                }
            });
        });

        $(".finishBank").click(function () {
            let tableNum = $('#tableNum').val();
            let final_total = $('#final_total').val();
            let outer_client_id = $('#outer_client_id').val();
            let bank_id = $('#fast_bank_id').val();

            $.post("{{ route('pos.open.finishBank') }}", {
                "_token": "{{ csrf_token() }}",
                final_total: final_total,
                tableNum: tableNum,
                outer_client_id: outer_client_id,
                bank_id: bank_id,
            }, function (data) {
                Swal.fire({
                    icon: 'success',
                    title: 'تم الدفع وحفظ الفاتورة بنجاح!',
                    timeout: 1300
                })

                setTimeout(() => {
                    if (data.success == 1) {
                        window.location.href = '/pos-print/' + data.pos_id;
                    }
                }, 1300);
            });
        });
        // quick Bank button //
        $('#finishBank').on('click', function () {
            $("#finishBankModal").modal();
        });

        $('.edit_bill').on('click', function () {
            let bill_id = $('#bill_id').val();
            $.post("{{ route('pos.edit') }}", {
                "_token": "{{ csrf_token() }}",
                bill_id: bill_id,
            }, function (data) {
                if (data.success == 1) {
                    location.reload();
                } else {
                    $('#msg').html(data.message);
                }
            });
        });

        $('.remove_bill').on('click', function () {
            let bill_id = $('#bill_id').val();
            $.post("{{ route('pos.delete') }}", {
                "_token": "{{ csrf_token() }}",
                bill_id: bill_id,
            }, function (data) {
                if (data.success == 1) {
                    alert(data.message);
                    location.reload();
                } else {
                    $('#msg').html(data.message);
                }
            });
        });

        $('.delete_pay').on('click', function () {
            let payment_method = $(this).attr('payment_method');
            let cash_id = $(this).attr('cash_id');
            $.post("{{ route('pay.delete') }}", {
                "_token": "{{ csrf_token() }}",
                payment_method: payment_method,
                cash_id: cash_id,
            }, function (data) {

            });
            $(this).parent().parent().hide();
        });


        function refreshBillDetails() {
            //----update bill details----//
            let totalSum = 0;
            $(".edit_price").each(function (index) {
                var productPrice = $($(".edit_price")[index]).val();
                var productQty = $($(".edit_quantity")[index]).val();
                var productDiscount = $($(".edit_discount")[index]).val();
                totalSum += productPrice * productQty - productDiscount;
            });
            $("#sum").text(totalSum.toFixed(3));
            //------Calc Tax Value & total PriceWithTax-------//
            let posTaxValue = Number($("#posTaxValue").text());
            let taxValueAmount = totalSum / 100 * posTaxValue;
            $("#taxValueAmount").text(taxValueAmount.toFixed(3));
            $("#total").text((totalSum + taxValueAmount).toFixed(3));
        }

        //on change price...
        $(document).on('keyup', '.edit_price', function () {
            //----update row details----//
            let element_id = $(this).parent().parent().attr('id');
            let edit_price = $(this).val();
            let edit_quantity = $("#edit_quantity-" + element_id).val();
            let edit_discount = $("#edit_discount-" + element_id).val();
            if (edit_price > 0) {
                let totalPrice = (edit_quantity * edit_price) - edit_discount;
                $("#totalPrice-" + element_id).text(totalPrice.toFixed(3));
            } else {
                alert('اكتب رقم صحيح اكبر من 0');
                return false;
            }
            refreshBillDetails();
        });

        //on change price...
        $(document).on('keyup', '.edit_quantity', function () {
            //----update row details----//
            let element_id = $(this).parent().parent().attr('id');
            let edit_quantity = $(this).val();
            let edit_price = $("#edit_price-" + element_id).val();
            let edit_discount = $("#edit_discount-" + element_id).val();
            if (edit_quantity > 0) {
                let totalPrice = (edit_quantity * edit_price) - edit_discount;
                $("#totalPrice-" + element_id).text(totalPrice.toFixed(3));
            } else {
                alert('اكتب رقم صحيح اكبر من 0');
                return false;
            }
            refreshBillDetails();
        });

        //on change price...
        $(document).on('keyup', '.edit_discount', function () {
            //----update row details----//
            let element_id = $(this).parent().parent().attr('id');
            let edit_discount = $(this).val();
            let edit_price = $("#edit_price-" + element_id).val();
            let edit_quantity = $("#edit_quantity-" + element_id).val();
            if (edit_quantity > 0) {
                let totalPrice = (edit_quantity * edit_price) - edit_discount;
                $("#totalPrice-" + element_id).text(totalPrice.toFixed(3));
            } else {
                alert('اكتب رقم صحيح اكبر من 0');
                return false;
            }
            refreshBillDetails();
        });

        //on change price...
        $(document).on('click', '.remove_element', function () {
            //----update row details----//
            $(this).parent().parent().remove();
            var audioElement = document.createElement('audio');
            audioElement.setAttribute('src', "{{ asset('failed.mp3') }}");
            audioElement.play();
            refreshBillDetails();
        });


        // quick cash button //
        $('#finish').on('click', function () {
            //---bill details---//
            let billDetails = {
                outer_client_id: $('#outer_client_id').val(),
                tableNum: $('#tableNum').val(),
                status: 'done',
                value_added_tax: '0',
                notes: $('#notes').val(),
                total_amount: Number($("#total").text()),
                tax_amount: Number($("#taxValueAmount").text()),
                tax_value: Number($("#posTaxValue").text()),
            };

            //---products details---//
            let productsArr = [];
            let totalSum = 0;
            $(".edit_price").each(function (index) {
                let product_id = $($(".edit_price")[index]).parent().parent().attr('id');
                var productPrice = $($(".edit_price")[index]).val();
                var productQty = $($(".edit_quantity")[index]).val();
                var productDiscount = $($(".edit_discount")[index]).val();
                totalSum = productPrice * productQty - productDiscount;

                productsArr.push({
                    product_id: product_id,
                    product_price: productPrice,
                    quantity: productQty,
                    discount: productDiscount,
                    quantity_price: totalSum,
                })
            });
            console.log(productsArr)
            $.post("{{ route('pos.open.finish') }}", {
                "_token": "{{ csrf_token() }}",
                billDetails: billDetails,
                productsArr: productsArr
            }, function (response) {
                console.log(response)
                Swal.fire({
                    icon: 'success',
                    title: 'تم الدفع وحفظ الفاتورة بنجاح!',
                    timeout: 1300
                })

                setTimeout(() => {
                    if (response.success == 1) {
                        window.location.href = '/pos-print/' + response.pos_id;
                    }
                }, 50);
            });
        });
    });
</script>
