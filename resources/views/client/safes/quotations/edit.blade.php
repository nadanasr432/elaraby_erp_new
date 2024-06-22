@extends('client.layouts.app-main')
<style>
    .btn.dropdown-toggle.bs-placeholder, .form-control {
        height: 40px !important;
    }

    a, a:hover {
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
        <input type="hidden" value="{{$quotation->quotation_number}}" id="quotation_number"/>
        <h6 class="alert alert-dark alert-sm text-center no-print" dir="rtl">
            <center>تعديل عرض سعر
                <span>
                        ( رقم العملية  :
                        {{$quotation->id}}
                        )</span></center>
        </h6>
        <div class="col-lg-3 pull-right no-print">
            <label for="" class="d-block">اسم العميل</label>
            <select name="outer_client_id" id="outer_client_id" class="selectpicker"
                    data-style="btn-success" data-live-search="true" title="اكتب او اختار اسم العميل">
                @foreach($outer_clients as $outer_client)
                    <option
                        @if($quotation->outer_client_id == $outer_client->id)
                            selected
                        @endif
                        value="{{$outer_client->id}}">{{$outer_client->client_name}}</option>
                @endforeach
            </select>
            <a target="_blank" href="{{route('client.outer_clients.create')}}" role="button"
               style="width: 15%;display: inline;"
               class="btn btn-sm btn-warning open_popup">
                <i class="fa fa-plus"></i>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 pull-right no-print">
            <div class="form-group" dir="rtl">
                <label for="date">تاريخ بدأ العرض</label>
                <input type="date" name="start_date" value="{{$quotation->start_date}}" id="start_date"
                       class="form-control"/>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 pull-right no-print">
            <div class="form-group" dir="rtl">
                <label for="date">تاريخ انتهاء العرض</label>
                <input type="date" name="expiration" value="{{$quotation->expiration_date}}" id="expiration_date"
                       class="form-control"/>
            </div>
        </div>
        <div class="col-lg-3 pull-right no-print">
            <label for=""> اختر المخزن </label>
            <select name="store_id" id="store_id" class="selectpicker"
                    data-style="btn-warning" data-live-search="true" title="اختر المخزن">
                @foreach($stores as $store)
                    <option value="{{$store->id}}">{{$store->store_name}}</option>
                @endforeach
            </select>
            <a target="_blank" href="{{route('client.stores.create')}}" role="button"
               style="width: 15%;display: inline;"
               class="btn btn-sm btn-warning open_popup">
                <i class="fa fa-plus"></i>
            </a>
        </div>

        <div class="clearfix no-print"></div>

        <div class="client_details no-print">
            <div class="col-lg-4 pull-right">
                <label for=""> الفئة </label>
                <input type="text" value="{{$quotation->outerClient->client_category}}" class="form-control" readonly
                       id="category"/>
            </div>
            <div class="col-lg-4 pull-right">
                <label for="">مديونية العميل </label>
                <?php
                if($quotation->outerClient->prev_balance > 0 ){
                    $balance = "عليه ". floatval($quotation->outerClient->prev_balance);
                }
                elseif($quotation->outerClient->prev_balance < 0){
                    $balance = "له ". floatval(abs($quotation->outerClient->prev_balance));
                }
                else{
                    $balance = 0;
                }
                ?>
                <input type="text" class="form-control" value="{{$balance}}" readonly
                       id="balance_before"/>
            </div>
            <div class="col-lg-4 pull-right">
                <label for="">جنسية العميل</label>
                <input type="text" class="form-control" value="{{$quotation->outerClient->client_national}}" readonly
                       id="client_national"/>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>

        <hr class="no-print">
        <div class="options no-print">
            <div class="col-lg-3 pull-right">
                <label for=""> كود المنتج او الاسم </label>
                <select name="product_id" id="product_id" class="selectpicker form-control"
                        data-style="btn-danger" data-live-search="true" title="كود المنتج او الاسم">
                    @foreach($all_products as $product)
                        <option value="{{$product->id}}">{{$product->product_name}}</option>
                    @endforeach
                </select>
                <a target="_blank" href="{{route('client.products.create')}}" role="button"
                   style="width: 15%;display: inline;"
                   class="btn btn-sm btn-warning open_popup">
                    <i class="fa fa-plus"></i>
                </a>
                <div class="available text-center" style="color: #000; font-size: 14px; margin-top: 10px;"></div>

            </div>
            <div class="col-lg-3 pull-right">
                <label for="">سعر المنتج</label>
                <input type="text" name="product_price" id="product_price" class="form-control">
            </div>
            <div class="col-lg-3 pull-right">
                <label class="d-block" for=""> الكمية </label>
                <input style="width: 50%;" type="text" name="quantity" id="quantity" class="form-control d-inline float-left"/>
                <select style="width: 50%;" class="form-control d-inline float-right" name="unit_id" id="unit_id">
                    <option value="">اختر الوحدة</option>
                    @foreach($units as $unit)
                        <option value="{{$unit->id}}">{{$unit->unit_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3 pull-right">
                <label for=""> الاجمالى </label>
                <input type="text" name="quantity_price" id="quantity_price" class="form-control"/>
                <label for=""> ملاحظات </label>
                <input type="text" name="notes" id="notes" class="form-control" value="{{$quotation->notes}}"/>
            </div>
            <div class="clearfix"></div>
            <div class="col-lg-12 text-center">
                <button type="button" id="add" class="btn btn-info btn-md mt-3">
                    <i class="fa fa-plus"></i>
                    اضافة الى عرض السعر
                </button>

                <button type="button" id="edit" style="display: none" class="btn btn-success btn-md mt-3">
                    <i class="fa fa-pencil"></i>
                    تعديل
                </button>
            </div>
            <hr>
        </div>
        <div class="company_details printy" style="display: none;">
            <div class="text-center">
                <img class="logo" style="width: 20%;" src="{{asset($company->company_logo)}}" alt="">
            </div>
            <div class="text-center">
                <div class="col-lg-12 text-center justify-content-center">
                    <p class="alert alert-secondary text-center alert-sm"
                       style="margin: 10px auto; font-size: 17px;line-height: 1.9;" dir="rtl">
                        {{$company->company_name}} -- {{$company->business_field}} <br>
                        {{$company->company_owner}} -- {{$company->phone_number}} <br>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 bill_details">
            <?php

            $elements = \App\Models\QuotationElement::where('quotation_id', $quotation->id)->get();
            $extras = \App\Models\QuotationExtra::where('quotation_id', $quotation->id)->get();
            $extra_settings = \App\Models\ExtraSettings::where('company_id', $company_id)->first();
            $currency = $extra_settings->currency;
            $tax_value_added = $company->tax_value_added;
            $sum = array();
            if (!$elements->isEmpty()) {
                echo '<h6 class="alert alert-sm alert-danger text-center">
                <i class="fa fa-info-circle"></i>
            بيانات عناصر عرض السعر رقم
                ' . $quotation->id . '
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
                            <button type='button' quotation_number='" . $element->quotation->quotation_number . "' element_id='" . $element->id . "' class='btn btn-sm btn-info edit_element'>
                                <i class='fa fa-pencil'></i> تعديل
                            </button>
                            <button type='button' quotation_number='" . $element->quotation->quotation_number . "' element_id='" . $element->id . "' class='btn btn-sm btn-danger remove_element'>
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
                     اجمالى عرض السعر
                    " . $total . " " . $currency . "
                </div>
                <div class='pull-left col-lg-6 '>
                    اجمالى عرض السعر بعد القيمة المضافة
                    " . $after_total . " " . $currency . "
                </div>
                <div class='clearfix'></div>
            </div>";
            }
            ?>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 after_totals">
            <?php
            $tax_value_added = $company->tax_value_added;
            $sum = array();
            foreach ($elements as $element) {
                array_push($sum, $element->quantity_price);
            }
            $total = array_sum($sum);
            $previous_extra = \App\Models\QuotationExtra::where('quotation_id', $quotation->id)
                ->where('action', 'extra')->first();
            if (!empty($previous_extra)) {
                $previous_extra_type = $previous_extra->action_type;
                $previous_extra_value = $previous_extra->value;
                if ($previous_extra_type == "percent") {
                    $previous_extra_value = $previous_extra_value / 100 * $total;
                }
                $after_discount = $total + $previous_extra_value;
            }
            $previous_discount = \App\Models\QuotationExtra::where('quotation_id', $quotation->id)
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
            echo "
            <div class='clearfix'></div>
            <div class='alert alert-secondary alert-sm text-center'>
                   اجمالى الفاتورة النهائى بعد الضريبة  والخصم :
                    " . $after_total_all . " " . $currency . "
            </div>";
            ?>
        </div>
        <?php
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
        ?>
        <div class="clearfix no-print"></div>
        <hr class="no-print">
        <div class="row no-print" style="margin: 20px auto;">
            <div class="col-lg-12">
                <div class="col-lg-6 col-md-6 col-xs-6 pull-right">
                    <div class="form-group" dir="rtl">
                        <label for="discount">خصم على اجمالى عرض السعر</label> <br>
                        <select name="discount_type" id="discount_type" class="form-control"
                                style="width: 20%;display: inline;float: right; margin-left:5px;">
                            <option @if($quotation_discount_type == "pound") selected
                                    @endif value="pound">{{$extra_settings->currency}}</option>
                            <option @if($quotation_discount_type == "percent") selected
                                    @endif value="percent">%</option>
                        </select>
                        <input type="text" value="{{$quotation_discount_value}}" name="discount_value"
                               style="width: 50%;display: inline;float: right;"
                                id="discount_value" class="form-control "/>
                        <button type="button"  class="btn btn-md btn-success pull-right text-center"
                                style="display: inline !important;width: 20% !important; height: 40px;margin-right: 20px; "
                                id="exec_discount">تطبيق
                        </button>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-xs-6 pull-right">
                    <div class="form-group" dir="rtl">
                        <label for="extra">مصاريف الشحن</label> <br>
                        <select  name="extra_type" id="extra_type" class="form-control"
                                style="width: 20%;display: inline;float: right;margin-left: 5px">
                            <option @if($quotation_extra_type == "pound") selected
                                    @endif value="pound">{{$extra_settings->currency}}</option>
                            <option @if($quotation_extra_type == "percent") selected
                                    @endif value="percent">%</option>
                        </select>
                        <input value="{{$quotation_extra_value}}"  type="text" name="extra_value"
                               style="width: 50%;display: inline;float: right;"
                               id="extra_value" class="form-control"/>
                        <button  type="button" class="btn btn-md btn-success pull-right text-center"
                                style="display: inline !important;width: 20% !important; height: 40px;margin-right: 20px; "
                                id="exec_extra">
                            تطبيق
                        </button>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div> <!--  End Col-lg-12 -->
        </div><!--  End Row -->
    </form>
    <div class="col-lg-12 no-print" style="padding-top: 25px;height: 40px !important;">
        <a href="{{route('client.quotations.view', $quotation->quotation_number)}}"  name="print"
                class="btn btn-md btn-info print_btn pull-right"><i
                class="fa fa-print"></i> طباعة عرض السعر
        </a>
    </div>
    <input type="hidden" id="product" placeholder="product" name="product"/>
    <input type="hidden" id="total" placeholder="اجمالى قبل الخصم" name="total"/>
    <script src="{{asset('app-assets/js/jquery.min.js')}}"></script>
    <script>
        $('#outer_client_id').on('change', function () {
            let outer_client_id = $(this).val();
            if (outer_client_id != "" || outer_client_id != "0") {
                $.post("{{url('/client/quotations/getOuterClientDetails')}}", {
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
                $.post("{{url('/client/quotations/getProducts')}}", {
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
            $.post("{{url('/client/quotations/get')}}", {
                product_id: product_id,
                outer_client_id: outer_client_id,
                "_token": "{{ csrf_token() }}"
            }, function (data) {
                $('input#product_price').val(data.order_price);
                $('input#quantity').attr('max',data.first_balance);
                $('input#quantity').val(1);
                $('input#quantity_price').val(data.order_price);
                $('.available').html('الكمية المتاحة : ' + data.first_balance);
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
        $('#add').on('click', function () {
            let outer_client_id = $('#outer_client_id').val();
            let quotation_number = $('#quotation_number').val();
            let product_id = $('#product_id').val();
            let product_price = $('#product_price').val();
            let quantity = $('#quantity').val();
            let start_date = $('#start_date').val();
            let expiration_date = $('#expiration_date').val();
            let quantity_price = quantity * product_price;
            let unit_id = $('#unit_id').val();

            let discount_type = $('#discount_type').val();
            let discount_value = $('#discount_value').val();

            let extra_type = $('#extra_type').val();
            let extra_value = $('#extra_value').val();
            let first_balance = parseFloat($('#quantity').attr('max'));

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
            }
            else {
                $.post("{{url('/client/quotations/post')}}", {
                    outer_client_id: outer_client_id,
                    quotation_number: quotation_number,
                    product_id: product_id,
                    product_price: product_price,
                    quantity: quantity,
                    unit_id: unit_id,
                    quantity_price: quantity_price,
                    start_date: start_date,
                    expiration_date: expiration_date,
                    "_token": "{{ csrf_token() }}"
                }, function (data) {
                    $('#product_id').val('').trigger('change');
                    $('#product_price').val('0');
                    $('#quantity').val('');
                    $('#unit_id').val('');
                    $('#quantity_price').val('');
                    if (data.status == true) {
                        $('.box_success').removeClass('d-none').fadeIn(200);
                        $('.msg_success').html(data.msg);
                        $('.box_success').delay(3000).fadeOut(300);
                        $.post("{{url('/client/quotations/elements')}}",
                            {"_token": "{{ csrf_token() }}", quotation_number: quotation_number},
                            function (elements) {
                                $('.bill_details').html(elements);
                            });

                        $.post("{{url('/client/quotations/discount')}}",
                            {
                                "_token": "{{ csrf_token() }}",
                                quotation_number: quotation_number,
                                discount_type: discount_type,
                                discount_value: discount_value
                            },
                            function (data) {
                                $('.after_totals').html(data);
                            });

                        $.post("{{url('/client/quotations/extra')}}",
                            {
                                "_token": "{{ csrf_token() }}",
                                quotation_number: quotation_number,
                                extra_type: extra_type,
                                extra_value: extra_value
                            },
                            function (data) {
                                $('.after_totals').html(data);
                            });

                    } else {
                        $('.box_error').removeClass('d-none').fadeIn(200);
                        $('.msg_error').html(data.msg);
                        $('.box_error').delay(3000).fadeOut(300);
                        $.post("{{url('/client/quotations/elements')}}",
                            {"_token": "{{ csrf_token() }}", quotation_number: quotation_number},
                            function (elements) {
                                $('.bill_details').html(elements);
                            });

                        $.post("{{url('/client/quotations/discount')}}",
                            {
                                "_token": "{{ csrf_token() }}",
                                quotation_number: quotation_number,
                                discount_type: discount_type,
                                discount_value: discount_value
                            },
                            function (data) {
                                $('.after_totals').html(data);
                            });

                        $.post("{{url('/client/quotations/extra')}}",
                            {
                                "_token": "{{ csrf_token() }}",
                                quotation_number: quotation_number,
                                extra_type: extra_type,
                                extra_value: extra_value
                            },
                            function (data) {
                                $('.after_totals').html(data);
                            });
                    }
                });
            }
        });
        $('#exec_discount').on('click', function () {
            let quotation_number = $('#quotation_number').val();
            let discount_type = $('#discount_type').val();
            let discount_value = $('#discount_value').val();
            $.post("{{url('/client/quotations/discount')}}",
                {
                    "_token": "{{ csrf_token() }}",
                    quotation_number: quotation_number,
                    discount_type: discount_type,
                    discount_value: discount_value
                },
                function (data) {
                    $('.after_totals').html(data);
                });
        });
        $('#exec_extra').on('click', function () {
            let quotation_number = $('#quotation_number').val();
            let extra_type = $('#extra_type').val();
            let extra_value = $('#extra_value').val();
            $.post("{{url('/client/quotations/extra')}}",
                {
                    "_token": "{{ csrf_token() }}",
                    quotation_number: quotation_number,
                    extra_type: extra_type,
                    extra_value: extra_value
                },
                function (data) {
                    $('.after_totals').html(data);
                });
        });
        $('.remove_element').on('click',function(){
            let element_id = $(this).attr('element_id');
            let quotation_number = $(this).attr('quotation_number');

            let discount_type = $('#discount_type').val();
            let discount_value = $('#discount_value').val();

            let extra_type = $('#extra_type').val();
            let extra_value = $('#extra_value').val();

            $.post("{{url('/client/quotations/element/delete')}}",
                {"_token": "{{ csrf_token() }}", element_id: element_id},
                function (data) {
                    $.post("{{url('/client/quotations/elements')}}",
                        {"_token": "{{ csrf_token() }}", quotation_number: quotation_number},
                        function (elements) {
                            $('.bill_details').html(elements);
                        });
                });
            $.post("{{url('/client/quotations/discount')}}",
                {"_token": "{{ csrf_token() }}",quotation_number:quotation_number, discount_type: discount_type, discount_value: discount_value},
                function (data) {
                    $('.after_totals').html(data);
                });

            $.post("{{url('/client/quotations/extra')}}",
                {"_token": "{{ csrf_token() }}",quotation_number:quotation_number, extra_type: extra_type, extra_value: extra_value},
                function (data) {
                    $('.after_totals').html(data);
                });

            $(this).parent().parent().fadeOut(300);
        });

        $('.edit_element').on('click', function () {
            let element_id = $(this).attr('element_id');
            let quotation_number = $(this).attr('quotation_number');
            $.post("{{url('/client/quotations/edit-element')}}",
                {
                    "_token": "{{ csrf_token() }}",
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
                $.post('/client/quotations/element/update',
                    {
                        '_token': "{{ csrf_token() }}",
                        element_id: element_id,
                        product_id: product_id,
                        product_price: product_price,
                        quantity: quantity,
                        quantity_price: quantity_price,
                        unit_id: unit_id,
                    },
                    function (data) {
                        $.post("{{url('/client/quotations/elements')}}",
                            {"_token": "{{ csrf_token() }}", quotation_number: quotation_number},
                            function (elements) {
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
                $.post("{{url('/client/quotations/discount')}}",
                    {
                        "_token": "{{ csrf_token() }}",
                        quotation_number: quotation_number,
                        discount_type: discount_type,
                        discount_value: discount_value
                    },
                    function (data) {
                        $('.after_totals').html(data);
                    });

                $.post("{{url('/client/quotations/extra')}}",
                    {
                        "_token": "{{ csrf_token() }}",
                        quotation_number: quotation_number,
                        extra_type: extra_type,
                        extra_value: extra_value
                    },
                    function (data) {
                        $('.after_totals').html(data);
                    });
            }
        });


    </script>
@endsection
