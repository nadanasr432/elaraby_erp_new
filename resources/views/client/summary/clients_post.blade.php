<?php
$company = \App\Models\Company::FindOrFail($outer_client_k->company_id);
$extra_settings = \App\Models\ExtraSettings::where('company_id', $company->id)->first();
$currency = $extra_settings->currency;
?>

    <!DOCTYPE html>
<html>
<head>
    <title>
        كشف حساب عميل
    </title>
    <meta charset="utf-8"/>
    <link href="{{asset('app-assets/css-rtl/bootstrap.css')}}" rel="stylesheet"/>
    <style type="text/css" media="screen">
        @font-face {
            font-family: 'Cairo';
            src: url({{asset('fonts/Cairo.ttf')}});
        }

        body, html {
            font-family: 'Cairo' !important;
            direction: rtl !important;
            text-align: center !important;
            font-size: 13px;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Cairo' !important;
        }

        .table-container {
            width: 80%;
            margin: 10px auto;
        }

        .no-print {
            bottom: 0;
            right: 30px;
            border-radius: 0;
            z-index: 9999;
        }

        table tr th, table tr td {
            text-align: center !important;
            padding: 4px !important;
        }

        .table-bordered th, .table-bordered td {
            border: 1px solid #626e8240 !important;
        }
    </style>
    <style type="text/css" media="print">
        body, html {
            font-family: 'Cairo' !important;
            direction: rtl !important;
            text-align: center !important;
            font-size: 13px;
            -webkit-print-color-adjust: exact !important;
            -moz-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            -o-print-color-adjust: exact !important;
        }

        table tr th, table tr td {
            text-align: center !important;
        }

        .no-print {
            display: none;
        }
    </style>
</head>
<body style="background: #fff">
<table class="table table-bordered table-container">
    <tbody>
    <tr>
        <td class="thisTD">
            <h3 class="alert alert-sm alert-light text-center" style="margin:20px auto;">
                كشف حساب عميل
            </h3>
            <!---COMPANY DATA--->
            <table width="100%">
                <tbody>
                <tr>
                    <td>
                        <span style="font-weight: bold;margin-left:20px;">اسم الشركة:</span>
                        {{$company ? $company->company_name : '-'}}
                    </td>
                    <td>
                        <span style="font-weight: bold;margin-left:20px;">الرقم الضريبي:</span>
                        {{$company ? $company->tax_number : '-'}}
                    </td>
                </tr>
                </tbody>
            </table>
            <!---COMPANY DATA--->
            @if(isset($outer_client_k) && !empty($outer_client_k))
                <p class="alert alert-sm alert-danger text-center">
                    عرض بيانات العميل
                </p>
                <div class="table-responsive">
                    <table class="table table-condensed table-striped table-bordered text-center table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">تكويد</th>
                            <th class="text-center">الاسم</th>
                            <th class="text-center">الفئة</th>
                            <th class="text-center">الشارع</th>
                            <th class="text-center">اسم المحل</th>
                            <th class="text-center">البريد الالكترونى</th>
                            <th class="text-center">الجنسية</th>
                            <th class="text-center">الرقم الضريبى</th>
                            <th class="text-center"> مديونية</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{ $outer_client_k->client_number }}</td>
                            <td>{{ $outer_client_k->client_name }}</td>
                            <td>{{ $outer_client_k->client_category }}</td>
                            <td>{{ $outer_client_k->client_street }}</td>
                            <td>{{ $outer_client_k->shop_name }}</td>
                            <td>{{ $outer_client_k->client_email }}</td>
                            <td>{{ $outer_client_k->client_national }}</td>
                            <td>{{ $outer_client_k->tax_number }}</td>
                            <td>
                                {{floatval($outer_client_k->prev_balance)}}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            @endif
            <div class="clearfix"></div>
            @if(isset($gifts) && !$gifts->isEmpty())
                <p class="alert alert-sm alert-success mt-3 text-center">
                    عرض هدايا العميل
                </p>
                <div class="table-responsive">
                    <table class="table table-condensed table-striped table-bordered text-center table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">العميل</th>
                            <th class="text-center">المنتج</th>
                            <th class="text-center">الكمية</th>
                            <th class="text-center">رصيد المنتج ما قبل</th>
                            <th class="text-center">رصيد المنتج ما بعد</th>
                            <th class="text-center">المخزن</th>
                            <th class="text-center">تاريخ - وقت</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($gifts as $key => $gift)
                            <tr>
                                <td>{{++$i}}</td>
                                <td>{{ $gift->outerClient->client_name }}</td>
                                <td>{{ $gift->product->product_name }}</td>
                                <td>
                                    {{floatval($gift->amount)}}
                                </td>
                                <td>
                                    {{floatval($gift->balance_before)}}
                                </td>
                                <td>
                                    {{floatval($gift->balance_after)}}
                                </td>
                                <td>{{ $gift->store->store_name }}</td>
                                <td>{{ $gift->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            <div class="clearfix"></div>
            @if(isset($quotations) && !$quotations->isEmpty())
                <p class="alert alert-sm alert-info mt-3 text-center d-none">
                    عروض أسعار العميل
                </p>
                <table class='table table-condensed table-striped table-bordered d-none'>
                    <thead class="text-center">
                    <th>#</th>
                    <th>رقم عرض السعر</th>
                    <th>تاريخ بداية العرض</th>
                    <th>تاريخ نهاية العرض</th>
                    <th>الاجمالى النهائى</th>
                    <th>عدد العناصر</th>
                    </thead>
                    <tbody>
                    <?php $i = 0; $total = 0; ?>
                    @foreach($quotations as $quotation)
                        <tr>
                            <td>{{++$i}}</td>
                            <td>{{$quotation->quotation_number}}</td>
                            <td>{{$quotation->start_date}}</td>
                            <td>{{$quotation->expiration_date}}</td>
                            <td>
                                <?php $sum = 0; ?>
                                @foreach($quotation->elements as $element)
                                    <?php $sum = $sum + $element->quantity_price; ?>
                                @endforeach
                                <?php
                                $extras = $quotation->extras;
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
                                if ($quotation_extra_type == "percent") {
                                    $quotation_extra_value = $quotation_extra_value / 100 * $sum;
                                }
                                $after_discount = $sum + $quotation_extra_value;

                                if ($quotation_discount_type == "percent") {
                                    $quotation_discount_value = $quotation_discount_value / 100 * $sum;
                                }
                                $after_discount = $sum - $quotation_discount_value;
                                $after_discount = $sum - $quotation_discount_value + $quotation_extra_value;
                                $tax_value_added = $company->tax_value_added;
                                $percentage = ($tax_value_added / 100) * $after_discount;
                                $after_total = $after_discount + $percentage;
                                echo floatval($after_total) . " " . $currency;
                                ?>
                                <?php $total = $total + $after_total; ?>
                            </td>
                            <td>{{$quotation->elements->count()}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
            <div class="clearfix"></div>
            @if(isset($saleBills) && !$saleBills->isEmpty())
                <p class="alert alert-sm alert-info mt-3 text-center">
                    فواتير البيع لهذا العميل
                </p>
                <table class='table table-condensed table-striped table-bordered'>
                    <thead class="text-center">
                    <th>#</th>
                    <th>رقم الفاتورة</th>
                    <th>التاريخ</th>
                    <th>البيان</th>
                    <th>مدين</th>
                    <th>دائن</th>
                    <th>الرصيد الحالى</th>
                    </thead>
                    <tbody>
                    <?php $i = 0; $total = 0; ?>
                    @foreach($saleBills as $sale_bill)
                        <tr>
                            <td>{{++$i}}</td>
                            <td>{{$sale_bill->company_counter}}</td>
                            <td>{{$sale_bill->date}}</td>
                            <td>
                                @if($sale_bill->paid == 0)
                                    فاتورة مبيعات اجل
                                @else
                                    فاتورة مبيعات نقدي
                                @endif
                            </td>
                            <td>{{$sale_bill->rest}}</td>
                            <td>{{$sale_bill->paid}}</td>
                            <td>
                                <?php $sum = 0; ?>
                                @foreach($sale_bill->elements as $element)
                                    <?php $sum = $sum + $element->quantity_price; ?>
                                @endforeach
                                <?php
                                $extras = $sale_bill->extras;
                                foreach ($extras as $key) {
                                    if ($key->action == "discount") {
                                        if ($key->action_type == "pound") {
                                            $sale_bill_discount_value = $key->value;
                                            $sale_bill_discount_type = "pound";
                                        } else {
                                            $sale_bill_discount_value = $key->value;
                                            $sale_bill_discount_type = "percent";
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
                                if ($sale_bill_extra_type == "percent") {
                                    $sale_bill_extra_value = $sale_bill_extra_value / 100 * $sum;
                                }
                                $after_discount = $sum + $sale_bill_extra_value;

                                if ($sale_bill_discount_type == "percent") {
                                    $sale_bill_discount_value = $sale_bill_discount_value / 100 * $sum;
                                }
                                $after_discount = $sum - $sale_bill_discount_value;
                                $after_discount = $sum - $sale_bill_discount_value + $sale_bill_extra_value;
                                $tax_value_added = $company->tax_value_added;
                                $percentage = ($tax_value_added / 100) * $after_discount;
                                $after_total = $after_discount + $percentage;
                                echo floatval($after_total) . " " . $currency;
                                ?>
                                <?php $total = $total + $after_total; ?>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif





        <!------------------------------------------------BONDS--------------------------------------------------->
            <div class="clearfix"></div>
            <?= $i = 0; ?>
            @if(isset($bonds) && !$bonds->isEmpty())
                <h3 class="alert alert-sm alert-light text-center" style="margin:20px auto;">
                    السندات للعميل
                </h3>
                <table class='table table-condensed table-striped table-bordered'>
                    <thead class="text-center">
                    <th>رقم السند</th>
                    <th>التاريخ</th>
                    <th>الحساب</th>
                    <th>النوع</th>
                    <th>المبلغ</th>
                    </thead>
                    <tbody>
                    @foreach($bonds as $bond)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{$bond->date}}</td>
                            <td>{{$bond->account}}</td>
                            <td>{{$bond->type}}</td>
                            <td>{{$bond->amount}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        <!------------------------------------------------BONDS--------------------------------------------------->


            <div class="clearfix"></div>
            @if(isset($returns) && !$returns->isEmpty())
                <p class="alert alert-sm alert-dark mt-3 text-center">
                    مرتجعات العميل
                </p>
                <div class="table-responsive">
                    <table class="table table-condensed table-striped table-bordered text-center table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">رقم الفاتورة</th>
                            <th class="text-center"> العميل</th>
                            <th class="text-center"> المنتج</th>
                            <th class="text-center"> الكمية المرتجعة</th>
                            <th class="text-center"> الوقت</th>
                            <th class="text-center"> التاريخ</th>
                            <th class="text-center"> سعر المنتج</th>
                            <th class="text-center"> سعر الكمية</th>
                            <th class="text-center"> مديونية العميل قبل الارتجاع</th>
                            <th class="text-center"> مديونية العميل بعد الارتجاع</th>
                            <th class="text-center"> رصيد المنتج قبل الارتجاع</th>
                            <th class="text-center"> رصيد المنتج بعد الارتجاع</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $i=0;
                        @endphp
                        @foreach ($returns as $key => $return)
                            <tr>
                                <td>{{ $return->bill_id }}</td>
                                <td>{{ $return->outerClient->client_name }}</td>
                                <td>{{ $return->product->product_name}}</td>
                                <td>
                                    {{floatval($return->return_quantity)}}
                                </td>
                                <td>{{ $return->date}}</td>
                                <td>{{ $return->time}}</td>
                                <td>
                                    {{floatval($return->product_price)}}
                                </td>
                                <td>
                                    {{floatval($return->quantity_price)}}
                                </td>

                                <td>
                                    {{floatval($return->balance_before)}}
                                </td>
                                <td>
                                    {{floatval($return->balance_after)}}
                                </td>

                                <td>
                                    {{floatval($return->before_return)}}
                                </td>
                                <td>
                                    {{floatval($return->after_return)}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            <div class="clearfix"></div>
            @if(isset($cashs) && !$cashs->isEmpty())
                <p class="alert alert-sm alert-warning mt-3 text-center">
                    مدفوعات نقدية لهذا العميل
                </p>
                <div class="table-responsive">
                    <table class="table table-condensed table-striped table-bordered text-center table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">رقم العملية</th>
                            <th class="text-center">العميل</th>
                            <th class="text-center">المبلغ</th>
                            <th class="text-center">رصيد قبل</th>
                            <th class="text-center">رصيد بعد</th>
                            <th class="text-center">رقم الفاتورة</th>
                            <th class="text-center">التاريخ</th>
                            <th class="text-center">الوقت</th>
                            <th class="text-center">خزنة الدفع</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $i=0;
                        @endphp
                        @foreach ($cashs as $key => $cash)
                            <tr>
                                <td>{{ $cash->cash_number }}</td>
                                <td>{{ $cash->outerClient->client_name }}</td>
                                <td>
                                    {{floatval($cash->amount)}}
                                </td>
                                <td>
                                    {{floatval($cash->balance_before)}}
                                </td>
                                <td>
                                    {{floatval($cash->balance_after)}}
                                </td>
                                <td>{{ $cash->bill_id }}</td>
                                <td>{{ $cash->date }}</td>
                                <td>{{ $cash->time }}</td>
                                <td>{{ $cash->safe->safe_name }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            @if(isset($borrows) && !$borrows->isEmpty())
                <p class="alert alert-sm alert-warning mt-3 text-center">
                    سلفيات الى العميل
                </p>
                <div class="table-responsive">
                    <table class="table table-condensed table-striped table-bordered text-center table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">رقم العملية</th>
                            <th class="text-center">العميل</th>
                            <th class="text-center">المبلغ</th>
                            <th class="text-center">رصيد قبل</th>
                            <th class="text-center">رصيد بعد</th>
                            <th class="text-center">رقم الفاتورة</th>
                            <th class="text-center">التاريخ</th>
                            <th class="text-center">الوقت</th>
                            <th class="text-center">خزنة الدفع</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $i=0;
                        @endphp
                        @foreach ($borrows as $key => $cash)
                            <tr>
                                <td>{{ $cash->cash_number }}</td>
                                <td>{{ $cash->outerClient->client_name }}</td>
                                <td>
                                    {{floatval(abs($cash->amount))}}
                                </td>
                                <td>
                                    {{floatval($cash->balance_before)}}
                                </td>
                                <td>
                                    {{floatval($cash->balance_after)}}
                                </td>
                                <td>{{ $cash->bill_id }}</td>
                                <td>{{ $cash->date }}</td>
                                <td>{{ $cash->time }}</td>
                                <td>{{ $cash->safe->safe_name }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            @if(isset($bankcashs) && !$bankcashs->isEmpty())
                <p class="alert alert-sm alert-warning mt-3 text-center">
                    مدفوعات بنكية لهذا العميل
                </p>
                <div class="table-responsive">
                    <table class="table table-condensed table-striped table-bordered text-center table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">رقم العملية</th>
                            <th class="text-center">العميل</th>
                            <th class="text-center">المبلغ</th>
                            <th class="text-center">رصيد قبل</th>
                            <th class="text-center">رصيد بعد</th>
                            <th class="text-center">رقم الفاتورة</th>
                            <th class="text-center">التاريخ</th>
                            <th class="text-center">الوقت</th>
                            <th class="text-center">البنك</th>
                            <th class="text-center">رقم المعاملة</th>
                            <th class="text-center">ملاحظات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $i=0;
                        @endphp
                        @foreach ($bankcashs as $key => $cash)
                            <tr>
                                <td>{{ $cash->cash_number }}</td>
                                <td>{{ $cash->outerClient->client_name }}</td>
                                <td>{{floatval( $cash->amount  )}}</td>
                                <td>{{floatval( $cash->balance_before  )}}</td>
                                <td>{{floatval( $cash->balance_after  )}}</td>
                                <td>{{ $cash->bill_id }}</td>
                                <td>{{ $cash->date }}</td>
                                <td>{{ $cash->time }}</td>
                                <td>{{ $cash->bank->bank_name }}</td>
                                <td>{{ $cash->bank_check_number }}</td>
                                <td>{{ $cash->notes }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            @if(isset($outer_client_k) && !empty($outer_client_k))
                <div class="col-lg-12 text-center mt-3 mb-3">
                    <span class="alert alert-info text-center ">
                        مديونية العميل الحالية
                        {{floatval( $outer_client_k->prev_balance  )}}  {{$currency}}
                    </span>
                </div>
            @endif
            <div class="row mt-1 mb-1 no-print">
                <div class="col-lg-12 text-center">
                    <button onclick="window.print()" type="button" class="btn btn-md btn-info">
                        <i class="fa fa-print"></i>
                        طباعة تقرير كشف الحساب
                    </button>
                    @if(isset($_GET['ref']) && $_GET['ref'] == "email")

                    @else
                        @if(isset($outer_client_k) && !empty($outer_client_k))
                            @if(!empty($outer_client_k->client_email))
                                <form class="d-inline" action="{{route('client.summary.send')}}" method="post">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" value="{{url()->full().'&ref=email'}}" name="url"/>
                                    <input type="hidden" value="{{$outer_client_k->id}}" name="id"/>
                                    <button type="submit" class="btn btn-md btn-warning">
                                        <i class="fa fa-envelope-o"></i>
                                        ارسال كشف الحساب الى بريد العميل
                                    </button>
                                </form>
                            @else
                                <span class="alert alert-sm alert-warning text-center">
                                    خانه البريد الالكترونى للعميل فارغة
                                </span>
                            @endif

                            @if(!$outer_client_k->phones->isEmpty())
                                <?php
                                $url = url()->full() . '&ref=email';
                                $text = "مرفق رابط لكشف حسابك " . "%0a" . $url;
                                $text = str_replace("&", "%26", $text);
                                $phone_number = $outer_client_k->phones[0]->client_phone;
                                ?>
                                <a class="btn btn-success btn-md" target="_blank"
                                   href="https://wa.me/{{$phone_number}}?text={{$text}}">
                                    ارسال الى واتساب العميل
                                </a>
                            @else
                                <span class="alert alert-sm alert-warning text-center">
                                    خانه رقم الهاتف للعميل فارغة
                                </span>
                            @endif

                        @endif
                    @endif
                    <a class="btn btn-warning btn-md" href="/client/clients-summary-get">
                        العودة
                    </a>
                </div>
            </div>
        </td>
    </tr>
    </tbody>
</table>
<script src="{{asset('app-assets/js/jquery.min.js')}}"></script>
<script type="text/javascript">

</script>
</body>
</html>
