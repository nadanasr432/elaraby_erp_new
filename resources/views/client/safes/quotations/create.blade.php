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


    .table th, .table td {
        padding: 10px !important;
    }

    tr th {
        background: #222751;
        color: white !important;
        font-size: 12px !important;
        font-weight: 500 !important;
        border: none !important;
    }

    tr td {
        font-size: 12px !important;
        font-weight: 500 !important;
        border: none !important;
    }

    table thead tr th, table tbody tr td {
        border: none !important;
    }

    .dropdown-toggle::after {
        display: none !important;
    }

    .even {
        background: #abd8ff24;
    }

    .badge {
        padding: 14px !important;
    }

    .badge-info {
        padding: 14px !important;
        border-color: #1e9ff27d !important;
        background-color: #1e9ff229 !important;
        color: #053858 !important;
        font-weight: 500;
    }
</style>
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-1">
                <div class="card-header border-bottom border-secondary p-1">

                    <!--PAGE HEADER-->
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h3 class="pull-right font-weight-bold">
                            اضافة عرض سعر
                            <div class="badge btn-newdark font-weight-bold">
                                {{ $quoationsCount }}
                            </div>
                        </h3>
                        <div class="row mr-1">
                            <a onclick="history.back()"
                               class="btn btn-danger pull-left text-white d-flex align-items-center ml-1"
                               style="height: 37px; font-size: 11px !important;">
                                <span
                                    style="border: 1px dashed;border-radius: 50%;margin-left: 10px;width: 20px;height: 20px;">
                                    <svg style="width: 10px;height: 15px;fill: #f5f1f1;margin-top: 1px;"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome  - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path
                                            d="M177.5 414c-8.8 3.8-19 2-26-4.6l-144-136C2.7 268.9 0 262.6 0 256s2.7-12.9 7.5-17.4l144-136c7-6.6 17.2-8.4 26-4.6s14.5 12.5 14.5 22l0 72 288 0c17.7 0 32 14.3 32 32l0 64c0 17.7-14.3 32-32 32l-288 0 0 72c0 9.6-5.7 18.2-14.5 22z"></path></svg>
                                </span>
                                العودة
                            </a>
                        </div>
                    </div>
                    <!--PAGE HEADER END-->

                    <hr>

                    <!--PAGE CONTENT-->
                    <form class="pr-1 pl-1 mb-0 pb-0 mt-2" action="#" method="POST">
                        @csrf
                        @method('POST')
                        <input type="hidden" value="{{ $pre_quotation }}" id="quotation_number"/>


                        <!----STORE--->
                        <div class="col-lg-3 pl-0 pull-right no-print">
                            <label>
                                {{ __('sales_bills.select-store') }}
                                <span class="text-danger font-weight-bold">*</span>
                            </label>
                            <select name="store_id" id="store_id" class="selectpicker w-100"
                                    data-style="btn-newdark" data-live-search="true"
                                    title="{{ __('sales_bills.select-store') }}">
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
                        </div>

                        <!----CLIENT--->
                        <div class="col-lg-3 p-0 pull-right no-print">
                            <label>
                                {{ __('sales_bills.client-name') }}
                                <span class="text-danger font-weight-bold">*</span>
                            </label>
                            <select name="outer_client_id" id="outer_client_id" data-style="btn-newdark"
                                    title="{{ __('sales_bills.client-name') }}"
                                    class="selectpicker w-100" data-live-search="true">
                                @foreach ($outer_clients as $outer_client)
                                    <option value="{{ $outer_client->id }}">{{ $outer_client->client_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!----DATE--->
                        <div class="col-lg-3 col-md-3 col-sm-3 pull-right no-print">
                            <div class="form-group" dir="rtl">
                                <label for="date">
                                    {{ __('sales_bills.offer-start-date') }}
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <input type="date" name="start_date" class="form-control"
                                       value="{{date('Y-m-d')}}" id="start_date"/>
                            </div>
                        </div>

                        <!----TIME--->
                        <div class="col-lg-3 col-md-3 col-sm-3 pull-right no-print">
                            <div class="form-group" dir="rtl">
                                <label for="date">
                                    {{ __('sales_bills.offer-end-date') }}
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <input type="date" name="expiration" value="<?php echo date('Y-m-d'); ?>"
                                       id="expiration_date"
                                       class="form-control"/>
                            </div>
                        </div>

                        <div class="clearfix no-print"></div>
                        <div class="col-lg-12 no-print">
                            <div class="outer_client_details">

                            </div>
                        </div>

                        <hr class="no-print mb-2">

                        <div class="options no-print">

                            <!----PRODUCTS--->
                            <div class="col-lg-3 p-0 pull-right">
                                <label>
                                    {{ __('sales_bills.product-code') }}
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <select name="product_id" id="product_id" class="selectpicker form-control w-100"
                                        data-style="btn-newdark"
                                        data-live-search="true" title="{{ __('sales_bills.product-code') }}">
                                    @foreach ($all_products as $product)
                                        <option value="{{ $product->id }}" data-tokens="{{ $product->code_universal }}">
                                            {{ $product->product_name }}</option>
                                    @endforeach
                                </select>
                                <div class="available text-warning font-weight-bold"
                                     style="margin-top: 10px;text-align:right;"></div>
                            </div>

                            <!----PRICE--->
                            <div class="col-lg-3 pr-0 pull-right">
                                <label>
                                    {{ __('sales_bills.product-price') }}
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <input type="number" placeholder="سعر المتنج" name="product_price" id="product_price"
                                       class="form-control">
                            </div>

                            <!----QT & UNIT--->
                            <div class="col-lg-4 pr-0 pull-right">
                                <label class="d-block" for="">
                                    {{ __('main.quantity') }}
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <input style="width: 40%;" type="number" placeholder="الكمية" name="quantity"
                                       id="quantity"
                                       class="form-control d-inline float-left"/>
                                <select style="width: 59%;" class="form-control d-inline float-right" name="unit_id"
                                        id="unit_id">
                                    <option value="">{{ __('units.unit-name') }}</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->unit_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!----TOTAL--->
                            <div class="col-lg-2 pull-right">
                                <label> {{ __('main.total') }} </label>
                                <input type="number" placeholder="0" name="quantity_price" id="quantity_price"
                                       class="form-control btn-newdark text-white font-weight-bold" readonly/>
                            </div>

                            <!----NOTES--->
                            <div class="col-lg-12 pull-right mt-1 p-0">
                                <label> {{ __('main.notes') }} </label>
                                <textarea name="notes" id="notes" dir="rtl" class="form-control"
                                          style="min-height:70px;"></textarea>
                            </div>

                            <div class="clearfix"></div>
                            <div class="col-lg-12 text-center">
                                <button type="button" id="add" class="btn btn-success btn-md mt-2 mb-1">
                                    <span
                                        style="width: 20px; display: inline-block; height: 20px; border-radius: 50%; border: 1px dashed white; padding-top: 2px; margin-left: 6px;"><i
                                            class="fa fa-plus"></i></span>
                                    اضافة المنتج
                                </button>
                                <button type="button" id="edit" style="display: none"
                                        class="btn btn-success btn-md mt-2 mb-1">
                                    <i class="fa fa-pencil"></i>
                                    {{ __('main.edit') }}
                                </button>
                            </div>
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

                        @if (!empty($sale_bill->outer_client_id))
                            <div class="col-lg-12">
                                <table class="table table-bordered" style="font-size:12px;">
                                    <tr class="text-center">
                                        <td colspan="6" style="font-size:32px;">بيانات العميل</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @if(isset($print_demo) && !empty($print_demo->outer_client_name_ar)&& !empty($print_demo->outer_client_name_en))
                                                @if(App::getLocale() == 'ar')
                                                    {{$print_demo->outer_client_name_ar}}
                                                @else
                                                    {{$print_demo->outer_client_name_en}}
                                                @endif
                                            @else
                                                الاسم
                                            @endif
                                        </td>
                                        <td>{{$sale_bill->OuterClient->client_name}}</td>
                                        <td>
                                            @if(isset($print_demo) && !empty($print_demo->outer_client_address_ar)&& !empty($print_demo->outer_client_address_en))
                                                @if(App::getLocale() == 'ar')
                                                    {{$print_demo->outer_client_address_ar}}
                                                @else
                                                    {{$print_demo->outer_client_address_en}}
                                                @endif
                                            @else
                                                العنوان
                                            @endif
                                        </td>
                                        <td colspan="3">
                                            @if(!empty($sale_bill->OuterClient->addresses[0]))
                                                {{$sale_bill->OuterClient->addresses[0]->client_address}}
                                            @endif

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @if(isset($print_demo) && !empty($print_demo->outer_client_phone_ar)&& !empty($print_demo->outer_client_phone_en))
                                                @if(App::getLocale() == 'ar')
                                                    {{$print_demo->outer_client_phone_ar}}
                                                @else
                                                    {{$print_demo->outer_client_phone_en}}
                                                @endif
                                            @else
                                                رقم الجوال
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($sale_bill->OuterClient->phones[0]))
                                                {{$sale_bill->OuterClient->phones[0]->client_phone}}
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($print_demo) && !empty($print_demo->outer_client_tax_number_ar)&& !empty($print_demo->outer_client_tax_number_en))
                                                @if(App::getLocale() == 'ar')
                                                    {{$print_demo->outer_client_tax_number_ar}}
                                                @else
                                                    {{$print_demo->outer_client_tax_number_en}}
                                                @endif
                                            @else
                                                الرقم الضريبى
                                            @endif
                                        </td>
                                        <td>{{$sale_bill->OuterClient->tax_number}}</td>
                                    </tr>
                                </table>
                            </div>
                    @endif
                </div>


                <div class="bill_details mt-0" style="display: none;">

                </div>

                <hr class="no-print">
                <div class="row no-print" style="margin: 20px 0px;">
                    <div class="col-lg-12 p-0">
                        <!----DISCOUNT---->
                        <div class="col-lg-6 col-md-6 col-xs-6 pull-right">
                            <div class="form-group" dir="rtl">
                                <label for="discount">خصم على اجمالى عرض السعر</label> <br>
                                <select name="discount_type" id="discount_type" class="form-control" disabled
                                        style="width: 35%;display: inline;float: right; margin-left:5px;">
                                    <option value="pound">{{ $extra_settings->currency }}</option>
                                    <option value="percent">%</option>
                                </select>
                                <input type="number" value="0" name="discount_value"
                                       style="width: 30%;display: inline;float: right;"
                                       disabled id="discount_value" class="form-control "/>
                                <button type="button" disabled
                                        class="btn btn-md btn-success pull-right text-center text-white"
                                        style="display: flex; width: 20% !important; height: 40px; margin-right: 5px; justify-content: space-around; align-items: center;"
                                        id="exec_discount">
                                    <svg width="14" fill="white" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 512 512">
                                        <path
                                            d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-111 111-47-47c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l64 64c9.4 9.4 24.6 9.4 33.9 0L369 209z"/>
                                    </svg>
                                    تطبيق
                                </button>
                            </div>
                        </div>
                        <!----DISCOUNT END---->


                        <!----SHIPPING---->
                        <div class="col-lg-6 col-md-6 col-xs-6 pull-right">
                            <div class="form-group" dir="rtl">
                                <label for="extra">مصاريف الشحن</label> <br>
                                <select disabled name="extra_type" id="extra_type" class="form-control"
                                        style="width: 35%;display: inline;float: right;margin-left: 5px">
                                    <option value="pound">{{ $extra_settings->currency }}</option>
                                    <option value="percent">%</option>
                                </select>
                                <input value="0" disabled type="number" name="extra_value"
                                       style="width: 30%;display: inline;float: right;" id="extra_value"
                                       class="form-control"/>
                                <button disabled type="button"
                                        class="btn btn-md btn-success pull-right text-center text-white"
                                        style="display: flex; width: 20% !important; height: 40px; margin-right: 5px; justify-content: space-around; align-items: center;"
                                        id="exec_extra">
                                    <svg width="14" fill="white" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 512 512">
                                        <path
                                            d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-111 111-47-47c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l64 64c9.4 9.4 24.6 9.4 33.9 0L369 209z"/>
                                    </svg>
                                    تطبيق
                                </button>
                            </div>
                        </div>
                        <!----SHIPPING END---->
                    </div>
                    <div class="after_totals">

                    </div>
                </div>
                </form>

                <!--PAGE CONTENT END-->
            </div>

        </div>
    </div>
    </div>
    <div class="col-lg-12 no-print" style="padding-top: 25px;height: 40px !important;margin-bottom:60px;">
        <button type="button" onclick="window.print()" disabled name="print"
                class="btn btn-md btn-info print_btn pull-right d-none"><i class="fa fa-print"></i> طباعة عرض السعر
        </button>
        <form class="d-inline" action="{{ route('client.quotations.destroy', 'test') }}" method="post">
            {{ method_field('delete') }}
            {{ csrf_field() }}
            <input type="hidden" name="quotation_number" value="{{ $pre_quotation }}">
            <button disabled type="submit" class="btn btn-md close_btn btn-danger pull-right ml-3" style="margin-top: 8px;">
                <i class="fa fa-close"></i>
                الغاء وخروج
            </button>
        </form>

        <form style="display:none;padding-top: 18px; height: 72px !important; margin-bottom: 15px; background: white; border-radius: 5px; box-shadow: rgb(100 100 111 / 6%) 0px 7px 29px 0px; margin-top: -9px !important;" id='saveANDPRINT' action="{{ route('client.quotations.redirectANDprint') }}"
              method="POST">
            @csrf
            @method('POST')

            <span id="saveANDREDIRECTBTN" class="btn btn-sm btn-success"
                  style="height: 35px; padding: 10px; margin-right: 16px;">
                <i class="fa fa-eye"></i> حفظ و طباعة
            </span>
        </form>
    </div>



    <input type="hidden" id="product" placeholder="product" name="product"/>
    <input type="hidden" id="total" placeholder="اجمالى قبل الخصم" name="total"/>
    <script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"
            integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css"
          integrity="sha512-DIW4FkYTOxjCqRt7oS9BFO+nVOwDL4bzukDyDtMO7crjUZhwpyrWBFroq+IqRe6VnJkTpRAS6nhDvf0w+wHmxg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script>
        $(document).ready(function () {
            $('#notes').summernote({
                height: 100,
                direction: 'rtl',
            });
        })
        //----saveANDREDIRECTBTN -- حفظ وطابعة----/
        $("#saveANDREDIRECTBTN").click(function () {
            iziToast.success({
                position: 'topRight',
                title: 'تم الحفظ بنجاح',
                timeoute: 800
            });

            setTimeout(function () {
                $("#saveANDPRINT").submit();
            }, 800);
        });

        $('#outer_client_id').on('change', function () {
            let outer_client_id = $(this).val();
            if (outer_client_id != "" || outer_client_id != "0") {
                $.post("{{ url('/client/quotations/getOuterClientDetails') }}", {
                    outer_client_id: outer_client_id,
                    "_token": "{{ csrf_token() }}"
                }, function (data) {
                    $('.outer_client_details').html(data);
                });
            }
        });
        $('#store_id').on('change', function () {
            let store_id = $(this).val();
            if (store_id != "" || store_id != "0") {
                $('.options').fadeIn(200);
                $.post("{{ url('/client/quotations/getProducts') }}", {
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
            let product_id = $(this).val();
            let outer_client_id = $('#outer_client_id').val();
            if (outer_client_id == "") {
                alert("لابد ان تختار العميل أولا");
            } else {
                $.post("{{ url('/client/quotations/get') }}", {
                    product_id: product_id,
                    outer_client_id: outer_client_id,
                    "_token": "{{ csrf_token() }}"
                }, function (data) {
                    $('input#product_price').val(data.order_price);
                    $('input#quantity').attr('max', data.first_balance);
                    $('input#quantity').val(1);
                    $('input#quantity_price').val(data.order_price);
                    $('#unit_id').val(data.unit_id);
                    $('.available').html('الكمية المتاحة : ' + data.first_balance);
                });
            }
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

        //------on adding new qoutation ------//
        $('#add').on('click', function () {
            let outer_client_id = $('#outer_client_id').val();
            let quotation_number = $('#quotation_number').val();
            let product_id = $('#product_id').val();
            let product_price = $('#product_price').val();
            let quantity = $('#quantity').val();
            let unit_id = $('#unit_id').val();
            let start_date = $('#start_date').val();
            let expiration_date = $('#expiration_date').val();
            let quantity_price = quantity * product_price;
            let notes = $('#notes').val();

            let discount_type = $('#discount_type').val();
            let discount_value = $('#discount_value').val();

            let extra_type = $('#extra_type').val();
            let extra_value = $('#extra_value').val();
            let first_balance = parseFloat($('#quantity').attr('max'));
            if (outer_client_id == "") {
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
                    $.post("{{ url('/client/quotations/post') }}", {
                        outer_client_id: outer_client_id,
                        quotation_number: quotation_number,
                        product_id: product_id,
                        product_price: product_price,
                        quantity: quantity,
                        unit_id: unit_id,
                        quantity_price: quantity_price,
                        start_date: start_date,
                        notes: notes,
                        expiration_date: expiration_date,
                        "_token": "{{ csrf_token() }}"
                    }, function (data) {

                        // console.log(data);return;
                        $('#outer_client_id').attr('disabled', true).addClass('disabled');
                        $('#product_id').val('').trigger('change');
                        $('#discount_type').attr('disabled', false);
                        $('.print_btn').attr('disabled', false);
                        $('.close_btn').attr('disabled', false);
                        $('.save_btn').removeClass('disabled');
                        $('.send_btn').removeClass('disabled');
                        $('#discount_value').attr('disabled', false);
                        $('#exec_discount').attr('disabled', false);
                        $('#extra_type').attr('disabled', false);
                        $('#extra_value').attr('disabled', false);
                        $('#exec_extra').attr('disabled', false);
                        $('#product_price').val('0');
                        $('#quantity').val('');
                        $('#unit_id').val('');
                        $('#quantity_price').val('');
                        if (data.status == true) {
                            $('.box_success').removeClass('d-none').fadeIn(200);
                            $('.msg_success').html(data.msg);
                            $('.box_success').delay(3000).fadeOut(300);

                            //----update elements-----//
                            $.post("{{ url('/client/quotations/elements') }}", {
                                "_token": "{{ csrf_token() }}",
                                quotation_number: quotation_number,
                                product_id: product_id
                            }, function (elements) {
                                $("#saveANDPRINT").append('<input type="hidden" name="quotation_id" value="' + quotation_number + '">');
                                $("#saveANDPRINT").show();
                                $('.bill_details').html(elements);
                                $('.bill_details').fadeIn(700);
                            });

                            //----update discount-----//
                            $.post("{{ url('/client/quotations/discount') }}", {
                                "_token": "{{ csrf_token() }}",
                                quotation_number: quotation_number,
                                discount_type: discount_type,
                                discount_value: discount_value
                            }, function (data) {
                                $('.after_totals').html(data);
                            });

                            //----update shipping-----//
                            $.post("{{ url('/client/quotations/extra') }}", {
                                "_token": "{{ csrf_token() }}",
                                quotation_number: quotation_number,
                                extra_type: extra_type,
                                extra_value: extra_value
                            }, function (data) {
                                $('.after_totals').html(data);
                            });

                        } else {
                            $('.box_error').removeClass('d-none').fadeIn(200);
                            $('.msg_error').html(data.msg);
                            $('.box_error').delay(3000).fadeOut(300);

                            //----update elements-----//
                            $.post("{{ url('/client/quotations/elements') }}", {
                                "_token": "{{ csrf_token() }}",
                                quotation_number: quotation_number
                            }, function (elements) {
                                $('.bill_details').html(elements);
                                $('.bill_details').fadeIn(700);
                            });

                            //----update discount-----//
                            $.post("{{ url('/client/quotations/discount') }}", {
                                "_token": "{{ csrf_token() }}",
                                quotation_number: quotation_number,
                                discount_type: discount_type,
                                discount_value: discount_value
                            }, function (data) {
                                $('.after_totals').html(data);
                            });

                            //----update shipping-----//
                            $.post("{{ url('/client/quotations/extra') }}", {
                                "_token": "{{ csrf_token() }}",
                                quotation_number: quotation_number,
                                extra_type: extra_type,
                                extra_value: extra_value
                            }, function (data) {
                                $('.after_totals').html(data);
                            });
                        }
                    });
                }
            }
        });

        //----exec discount-----//
        $('#exec_discount').on('click', function () {
            let quotation_number = $('#quotation_number').val();
            let discount_type = $('#discount_type').val();
            let discount_value = $('#discount_value').val();
            $.post("{{ url('/client/quotations/discount') }}", {
                "_token": "{{ csrf_token() }}",
                quotation_number: quotation_number,
                discount_type: discount_type,
                discount_value: discount_value
            }, function (data) {
                $('.after_totals').html(data);
            });
        });

        //----exec shipping-----//
        $('#exec_extra').on('click', function () {
            let quotation_number = $('#quotation_number').val();
            let extra_type = $('#extra_type').val();
            let extra_value = $('#extra_value').val();
            $.post("{{ url('/client/quotations/extra') }}", {
                "_token": "{{ csrf_token() }}",
                quotation_number: quotation_number,
                extra_type: extra_type,
                extra_value: extra_value
            }, function (data) {
                $('.after_totals').html(data);
            });
        });

        //------on edit qoutation------//
        $('#edit').on('click', function () {
            let element_id = $(this).attr('element_id');
            let quotation_number = $(this).attr('quotation_number');
            let product_id = $('#product_id').val();
            let product_price = $('#product_price').val();
            let quantity = $('#quantity').val();
            let quantity_price = $('#quantity_price').val();
            let unit_id = $('#unit_id').val();
            let discount_type = $('#discount_type').val();
            let discount_value = $('#discount_value').val();
            let extra_type = $('#extra_type').val();
            let extra_value = $('#extra_value').val();

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
                $.post('/client/quotations/element/update', {
                        '_token': "{{ csrf_token() }}",
                        element_id: element_id,
                        product_id: product_id,
                        product_price: product_price,
                        quantity: quantity,
                        quantity_price: quantity_price,
                        unit_id: unit_id,
                    },
                    function (data) {
                        //-------update invoice elements----------//
                        $.post("{{ url('/client/quotations/elements') }}", {
                            "_token": "{{ csrf_token() }}",
                            quotation_number: quotation_number
                        }, function (elements) {
                            $('.bill_details').html(elements);
                            $('.bill_details').fadeIn(700);
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

                //-------update discount----------//
                $.post("{{ url('/client/quotations/discount') }}", {
                    "_token": "{{ csrf_token() }}",
                    quotation_number: quotation_number,
                    discount_type: discount_type,
                    discount_value: discount_value
                }, function (data) {
                    $('.after_totals').html(data);
                });

                //-------update shipping----------//
                $.post("{{ url('/client/quotations/extra') }}", {
                    "_token": "{{ csrf_token() }}",
                    quotation_number: quotation_number,
                    extra_type: extra_type,
                    extra_value: extra_value
                }, function (data) {
                    $('.after_totals').html(data);
                });
            }
        });

        window.addEventListener("pageshow", function (event) {
            var historyTraversal = event.persisted ||
                (typeof window.performance != "undefined" &&
                    window.performance.navigation.type === 2);
            if (historyTraversal) {
                // Handle page restore.
                window.location.reload();
            }
        });
    </script>
@endsection
