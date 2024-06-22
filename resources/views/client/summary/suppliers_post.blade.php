<?php
$company = \App\Models\Company::FindOrFail($supplier_k->company_id);
$extra_settings = \App\Models\ExtraSettings::where('company_id', $company->id)->first();
$currency = $extra_settings->currency;
?>

    <!DOCTYPE html>
<html>
<head>
    <title>
        كشف حساب مورد
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
                كشف حساب مورد
            </h3>
            @if(isset($supplier_k) && !empty($supplier_k))
                <p class="alert alert-sm alert-danger text-center">
                    عرض بيانات المورد
                </p>
                <div class="table-responsive">
                    <table class="table table-condensed table-striped table-bordered text-center table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">الاسم</th>
                            <th class="text-center">الفئة</th>
                            <th class="text-center">الشارع</th>
                            <th class="text-center">اسم المحل</th>
                            <th class="text-center">البريد الالكترونى</th>
                            <th class="text-center">الجنسية</th>
                            <th class="text-center">الرقم الضريبى</th>
                            <th class="text-center"> مستحقات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{ $supplier_k->supplier_name }}</td>
                            <td>{{ $supplier_k->supplier_category }}</td>
                            <td>{{ $supplier_k->supplier_street }}</td>
                            <td>{{ $supplier_k->shop_name }}</td>
                            <td>{{ $supplier_k->supplier_email }}</td>
                            <td>{{ $supplier_k->supplier_national }}</td>
                            <td>{{ $supplier_k->tax_number }}</td>
                            <td>{{floatval( $supplier_k->prev_balance  )}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            @endif
            <div class="clearfix"></div>
            @if(isset($buyBills) && !$buyBills->isEmpty())
                <p class="alert alert-sm alert-primary mt-3 text-center">
                    فواتير المشتريات لهذا المورد
                </p>
                <div class="table-responsive">
                    <table class='table table-condensed table-striped table-bordered'>
                        <thead class="text-center">
                        <th>#</th>
                        <th>رقم الفاتورة</th>
                        <th>تاريخ الفاتورة</th>
                        <th> وقت الفاتورة</th>
                        <th>الاجمالى النهائى</th>
                        <th>عدد العناصر</th>
                        </thead>
                        <tbody>
                        <?php $i = 0; $total = 0; ?>
                        @foreach($buyBills as $buy_bill)
                            <tr>
                                <td>{{++$i}}</td>
                                <td>{{$buy_bill->buy_bill_number}}</td>
                                <td>{{$buy_bill->date}}</td>
                                <td>{{$buy_bill->time}}</td>
                                <td>
                                    <?php $sum = 0; ?>
                                    @foreach($buy_bill->elements as $element)
                                        <?php $sum = $sum + $element->quantity_price; ?>
                                    @endforeach
                                    <?php
                                    $extras = $buy_bill->extras;
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
                                    if ($buy_bill_extra_type == "percent") {
                                        $buy_bill_extra_value = $buy_bill_extra_value / 100 * $sum;
                                    }
                                    $after_discount = $sum + $buy_bill_extra_value;

                                    if ($buy_bill_discount_type == "percent") {
                                        $buy_bill_discount_value = $buy_bill_discount_value / 100 * $sum;
                                    }
                                    $after_discount = $sum - $buy_bill_discount_value;
                                    $after_discount = $sum - $buy_bill_discount_value + $buy_bill_extra_value;
                                    $tax_value_added = $company->tax_value_added;
                                    $percentage = ($tax_value_added / 100) * $after_discount;
                                    $after_total = $after_discount + $percentage;
                                    echo floatval($after_total) . " " . $currency;
                                    ?>
                                    <?php $total = $total + $after_total; ?>
                                </td>
                                <td>{{$buy_bill->elements->count()}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            @endif
            <div class="clearfix"></div>
            @if(isset($returns) && !$returns->isEmpty())
                <p class="alert alert-sm alert-dark text-center">
                    مرتجعات المورد
                </p>
                <div class="table-responsive">
                    <table class="table table-condensed table-striped table-bordered text-center table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">رقم الفاتورة</th>
                            <th class="text-center"> المورد</th>
                            <th class="text-center"> المنتج</th>
                            <th class="text-center"> الكمية المرتجعة</th>
                            <th class="text-center"> الوقت</th>
                            <th class="text-center"> التاريخ</th>
                            <th class="text-center"> سعر المنتج</th>
                            <th class="text-center"> سعر الكمية</th>
                            <th class="text-center"> مستحقات المورد قبل الارتجاع</th>
                            <th class="text-center"> مستحقات المورد بعد الارتجاع</th>
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
                                <td>{{ $return->supplier->supplier_name }}</td>
                                <td>{{ $return->product->product_name}}</td>
                                <td>{{floatval( $return->return_quantity  )}}</td>
                                <td>{{ $return->date}}</td>
                                <td>{{ $return->time}}</td>
                                <td>{{floatval( $return->product_price  )}}</td>
                                <td>{{floatval( $return->quantity_price  )}}</td>

                                <td>{{floatval( $return->balance_before  )}}</td>
                                <td>{{floatval( $return->balance_after  )}}</td>

                                <td>{{floatval( $return->before_return  )}}</td>
                                <td>{{floatval( $return->after_return  )}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            <div class="clearfix"></div>
            @if(isset($buyBorrows) && !$buyBorrows->isEmpty())
                <p class="alert alert-sm alert-warning mt-3 text-center">
                    سلفيات من المورد
                </p>
                <div class="table-responsive">
                    <table class="table table-condensed table-striped table-bordered text-center table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">رقم العملية</th>
                            <th class="text-center">المورد</th>
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
                        @foreach ($buyBorrows as $key => $cash)
                            <tr>
                                <td>{{ $cash->cash_number }}</td>
                                <td>{{ $cash->supplier->supplier_name }}</td>
                                <td>{{floatval( abs($cash->amount)  )}}</td>
                                <td>{{floatval( $cash->balance_before  )}}</td>
                                <td>{{floatval( $cash->balance_after  )}}</td>
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
            @if(isset($buyCashs) && !$buyCashs->isEmpty())
                <p class="alert alert-sm alert-warning mt-3 text-center">
                    مدفوعات نقدية لهذا المورد
                </p>
                <div class="table-responsive">
                    <table class="table table-condensed table-striped table-bordered text-center table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">رقم العملية</th>
                            <th class="text-center">المورد</th>
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
                        @foreach ($buyCashs as $key => $cash)
                            <tr>
                                <td>{{ $cash->cash_number }}</td>
                                <td>{{ $cash->supplier->supplier_name }}</td>
                                <td>{{floatval( $cash->amount  )}}</td>
                                <td>{{floatval( $cash->balance_before  )}}</td>
                                <td>{{floatval( $cash->balance_after  )}}</td>
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
            @if(isset($bankbuyCashs) && !$bankbuyCashs->isEmpty())
                <p class="alert alert-sm alert-warning mt-3 text-center">
                    مدفوعات بنكية لهذا المورد
                </p>
                <div class="table-responsive">
                    <table class="table table-condensed table-striped table-bordered text-center table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">رقم العملية</th>
                            <th class="text-center">المورد</th>
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
                        @foreach ($bankbuyCashs as $key => $cash)
                            <tr>
                                <td>{{ $cash->cash_number }}</td>
                                <td>{{ $cash->supplier->supplier_name }}</td>
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
            @if(isset($supplier_k) && !empty($supplier_k))
                <div class="col-lg-12 text-center mt-3 mb-3">
                            <span class="alert alert-secondary text-center ">
                                مستحقات المورد الحالية
                                {{floatval( $supplier_k->prev_balance  )}} {{$currency}}
                            </span>
                </div>
            @endif

            <div class="row mt-1 mb-1 text-center no-print">
                <div class="col-lg-12 text-center">
                    <button onclick="window.print()" type="button" class="btn btn-md btn-info">
                        <i class="fa fa-print"></i>
                        طباعة تقرير كشف الحساب
                    </button>
                    @if(isset($_GET['ref']) && $_GET['ref'] == "email")

                    @else
                        @if(isset($supplier_k) && !empty($supplier_k))
                            @if(!empty($supplier_k->supplier_email))
                                <form class="d-inline" action="{{route('supplier.summary.send')}}" method="post">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" value="{{url()->full().'&ref=email'}}" name="url"/>
                                    <input type="hidden" value="{{$supplier_k->id}}" name="id"/>
                                    <button type="submit" class="btn btn-md btn-warning">
                                        <i class="fa fa-envelope-o"></i>
                                        ارسال كشف الحساب الى بريد المورد
                                    </button>
                                </form>
                            @else
                                <span class="alert alert-sm alert-warning text-center">
                                    خانه البريد الالكترونى للمورد فارغة
                                </span>
                            @endif
                            @if(!$supplier_k->phones->isEmpty())
                                <?php
                                $url = url()->full() . '&ref=email';
                                $text = "مرفق رابط لكشف حسابك " . "%0a" . $url;
                                $text = str_replace("&", "%26", $text);
                                $phone_number = $supplier_k->phones[0]->supplier_phone;
                                ?>
                                <a class="btn btn-success btn-md" target="_blank"
                                   href="https://wa.me/{{$phone_number}}?text={{$text}}">
                                    ارسال الى واتساب المورد
                                </a>
                            @else
                                <span class="alert alert-sm alert-warning text-center">
                                    خانه رقم الهاتف للمورد فارغة
                                </span>
                            @endif
                        @endif
                    @endif
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
