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
    <meta charset="utf-8" />
    <link href="{{ asset('app-assets/css-rtl/bootstrap.css') }}" rel="stylesheet" />
    <style type="text/css" media="screen">
        @font-face {
            font-family: 'Cairo';
            src: url({{ asset('fonts/Cairo.ttf') }});
        }

        body,
        html {
            font-family: 'Cairo' !important;
            direction: rtl !important;
            text-align: center !important;
            font-size: 13px;
            overflow-x: hidden;
            /* Hide horizontal scroll */
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Cairo' !important;
        }

        .table-container {
            width: 80%;
            margin: 10px auto;
            overflow-x: auto;
            /* Allow horizontal scroll within the container if necessary */
        }

        .no-print {
            bottom: 0;
            right: 30px;
            border-radius: 0;
            z-index: 9999;
        }

        table {
            width: 100%;
            table-layout: auto;
        }

        table tr th,
        table tr td {
            text-align: center !important;
            padding: 4px !important;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #626e8240 !important;
        }
    </style>
    <style type="text/css" media="print">
        body,
        html {
            font-family: 'Cairo' !important;
            direction: rtl !important;
            text-align: center !important;
            font-size: 13px;
            overflow-x: hidden;
            /* Hide horizontal scroll */
            -webkit-print-color-adjust: exact !important;
            -moz-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            -o-print-color-adjust: exact !important;
        }

        .table-container {

            margin: 0px auto;
        }

        .table-respo table {
            width: 100%;
            border-radius: 8px !important;
            overflow: hidden;
            border: 1px solid;
            box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;
        }

        .table-respo table tr th,
        table tr td {
            text-align: center !important;
        }

        .table-respo thead th {
            background: #222751 !important;
            color: white;
            height: 44px !important;
            text-align: center;
        }

        thead th {
            background: #222751 !important;
            color: white;
            height: 44px !important;
            text-align: center;
        }

        .no-print {
            display: none;
        }

        tr {
            border-bottom: 1px solid #2d2d2d20 !important;
            padding-bottom: 4px !important;
            padding-top: 4px !important;
            font-size: 15px !important;
        }
    </style>
</head>

<body style="background: #fff">

    <table class="table table-bordered table-container">
        <tbody>
            <tr>
                <div class="row mt-1 mb-1 no-print ">
                    <div class="col-lg-12 text-center">
                        <button onclick="window.print()" type="button" class="btn btn-md btn-info">
                            <i class="fa fa-print"></i>
                            طباعة تقرير كشف الحساب
                        </button>
                        @if (isset($_GET['ref']) && $_GET['ref'] == 'email')
                        @else
                            @if (isset($outer_client_k) && !empty($outer_client_k))
                                @if (!empty($outer_client_k->client_email))
                                    <form class="d-inline" action="{{ route('client.summary.send') }}" method="post">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" value="{{ url()->full() . '&ref=email' }}"
                                            name="url" />
                                        <input type="hidden" value="{{ $outer_client_k->id }}" name="id" />
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

                                @if (!$outer_client_k->phones->isEmpty())
                                    <?php
                                    $url = url()->full() . '&ref=email';
                                    $text = 'مرفق رابط لكشف حسابك ' . '%0a' . $url;
                                    $text = str_replace('&', '%26', $text);
                                    $phone_number = $outer_client_k->phones[0]->client_phone;
                                    ?>
                                    <a class="btn btn-success btn-md" target="_blank"
                                        href="https://wa.me/{{ $phone_number }}?text={{ $text }}">
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

                <td class="thisTD">

                    <div class="header-container d-flex justify-content-center">
                        <div class="logo">
                            <img class="logo" style="object-fit: scale-down;" width="204"
                                src="{{ asset($company->company_logo) }}">
                        </div>
                    </div>
                    <hr class="mt-1 mb-2">
                    <?php
                    $from_date = request()->get('from_date');
                    $to_date = request()->get('to_date');
                    ?>
                    <h3 class="alert alert-sm alert-light text-center" style="margin:20px auto;">
                        كشف حساب عميل من {{ $from_date }} إلى {{ $to_date }}
                    </h3>

                    <!---COMPANY DATA--->
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td>
                                    <span style="font-weight: bold;margin-left:20px;">اسم الشركة:</span>
                                    {{ $company ? $company->company_name : '-' }}
                                </td>
                                <td>
                                    <span style="font-weight: bold;margin-left:20px;">الرقم الضريبي:</span>
                                    {{ $company ? $company->tax_number : '-' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!---COMPANY DATA--->
                    @if (isset($outer_client_k) && !empty($outer_client_k))
                        <p class="alert alert-sm alert-danger text-center">
                            عرض بيانات العميل {{ $outer_client_k->client_name }}
                        </p>
                        <div class="table-respo mb-3">
                            <table
                                style="width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid;box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                                <thead style="font-size: 15px !important;">

                                    <tr
                                        style="font-size: 13px !important; background: #222751; color: white; height: 44px !important; text-align: center;">
                                        <th class="text-center">تكويد</th>
                                        <th class="text-center">الاسم</th>
                                        <th class="text-center">الفئة</th>
                                        <th class="text-center">الشارع</th>
                                        <th class="text-center">اسم المحل</th>
                                        <th class="text-center">البريد الالكترونى</th>
                                        <th class="text-center">الجنسية</th>
                                        <th class="text-center">الرقم الضريبى</th>
                                        <th class="text-center">
                                            @if ($outer_client_k->prev_balance == 0)
                                                مديونية
                                            @else
                                                مديونية بتاريخ ( {{ $outer_client_k->created_at->format('d-m-Y') }} )
                                            @endif
                                        </th>
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
                                            {{ floatval($outer_client_k->prev_balance) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                    <div class="clearfix"></div>
                    @if (isset($gifts) && !$gifts->isEmpty())
                        <p class="alert alert-sm alert-success mt-3 text-center">
                            عرض هدايا العميل
                        </p>
                        <div class="table-respo ">
                            <table
                                style="width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid;box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                                <thead style="font-size: 15px !important;">
                                    <tr
                                        style="font-size: 13px !important; background: #222751; color: white; height: 44px !important; text-align: center;">

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
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $gift->outerClient->client_name }}</td>
                                            <td>{{ $gift->product->product_name }}</td>
                                            <td>
                                                {{ floatval($gift->amount) }}
                                            </td>
                                            <td>
                                                {{ floatval($gift->balance_before) }}
                                            </td>
                                            <td>
                                                {{ floatval($gift->balance_after) }}
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
                    @if (isset($quotations) && !$quotations->isEmpty())
                        <p class="alert alert-sm alert-info mt-3 text-center d-none">
                            عروض أسعار العميل
                        </p>
                        <div class="table-respo ">
                            <table
                                style="width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid;box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                                <thead style="font-size: 15px !important;">
                                    <tr
                                        style="font-size: 13px !important; background: #222751; color: white; height: 44px !important; text-align: center;">
                                        <th>#</th>
                                        <th>رقم عرض السعر</th>
                                        <th>تاريخ بداية العرض</th>
                                        <th>تاريخ نهاية العرض</th>
                                        <th>الاجمالى النهائى</th>
                                        <th>عدد العناصر</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 0;
                                    $total = 0; ?>
                                    @foreach ($quotations as $quotation)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $quotation->quotation_number }}</td>
                                            <td>{{ $quotation->start_date }}</td>
                                            <td>{{ $quotation->expiration_date }}</td>
                                            <td>
                                                <?php $sum = 0; ?>
                                                @foreach ($quotation->elements as $element)
                                                    <?php $sum = $sum + $element->quantity_price; ?>
                                                @endforeach
                                                <?php
                                                $extras = $quotation->extras;
                                                foreach ($extras as $key) {
                                                    if ($key->action == 'discount') {
                                                        if ($key->action_type == 'pound') {
                                                            $quotation_discount_value = $key->value;
                                                            $quotation_discount_type = 'pound';
                                                        } else {
                                                            $quotation_discount_value = $key->value;
                                                            $quotation_discount_type = 'percent';
                                                        }
                                                    } else {
                                                        if ($key->action_type == 'pound') {
                                                            $quotation_extra_value = $key->value;
                                                            $quotation_extra_type = 'pound';
                                                        } else {
                                                            $quotation_extra_value = $key->value;
                                                            $quotation_extra_type = 'percent';
                                                        }
                                                    }
                                                }
                                                if ($extras->isEmpty()) {
                                                    $quotation_discount_value = 0;
                                                    $quotation_extra_value = 0;
                                                    $quotation_discount_type = 'pound';
                                                    $quotation_extra_type = 'pound';
                                                }
                                                if ($quotation_extra_type == 'percent') {
                                                    $quotation_extra_value = ($quotation_extra_value / 100) * $sum;
                                                }
                                                $after_discount = $sum + $quotation_extra_value;
                                                
                                                if ($quotation_discount_type == 'percent') {
                                                    $quotation_discount_value = ($quotation_discount_value / 100) * $sum;
                                                }
                                                $after_discount = $sum - $quotation_discount_value;
                                                $after_discount = $sum - $quotation_discount_value + $quotation_extra_value;
                                                $tax_value_added = $company->tax_value_added;
                                                $percentage = ($tax_value_added / 100) * $after_discount;
                                                $after_total = $after_discount + $percentage;
                                                echo floatval($after_total) . ' ' . $currency;
                                                ?>
                                                <?php $total = $total + $after_total; ?>
                                            </td>
                                            <td>{{ $quotation->elements->count() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                    <div class="clearfix"></div>
                    @if (isset($saleBills) && !$saleBills->isEmpty())
                        <p class="alert alert-sm alert-info mt-3 text-center">
                            فواتير البيع للعميل {{ $outer_client_k->client_name }}
                        </p>
                        <div class="table-respo ">
                            <table
                                style="width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid; box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                                <thead style="font-size: 15px !important;">
                                    <tr
                                        style="font-size: 13px !important; background: #222751; color: white; height: 44px !important; text-align: center;">
                                        <th>#</th>
                                        <th>رقم الفاتورة</th>
                                        <th>التاريخ</th>
                                        <th>البيان</th>
                                        <th>مدين</th>
                                        <th>دائن</th>
                                        <th>الرصيد الحالى</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    $total = 0;
                                    $previous_balance = 0; // نبدأ برصيد سابق 0
                                    $final_balance = 0; // متغير لتخزين الرصيد النهائي
                                    $allSaleBills = App\Models\SaleBill::where('company_id', $outer_client_k->company_id)
                                        ->where('status', 'done')
                                        ->orderBy('id')
                                        ->pluck('id')
                                        ->toArray();
                                    
                                    $saleBills = $outer_client_k->saleBills->where('status', 'done');
                                    
                                    $globalIndexMap = array_flip($allSaleBills); // ID => Position
                                    ?>
                                    @foreach ($saleBills as $index => $sale_bill)
                                        <tr class="{{ $index % 2 == 0 ? 'even' : 'odd' }}" role="row">
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $globalIndexMap[$sale_bill->id] + 1 }}</td> <!-- Index + 1 -->
                                            <td>{{ $sale_bill->date }}</td>
                                            <td>
                                                @if ($sale_bill->paid == 0)
                                                    فاتورة مبيعات اجل
                                                @else
                                                    فاتورة مبيعات نقدي
                                                @endif
                                            </td>
                                            <td>{{ $sale_bill->final_total - $sale_bill->paid }}</td>
                                            <td>{{ $sale_bill->paid }}</td>
                                            <td>
                                                <?php
                                                // حساب المجموع الكلي للمدين
                                                $sum = 0;
                                                foreach ($sale_bill->elements as $element) {
                                                    $sum += floatval($element->quantity_price);
                                                }
                                                
                                                // حساب الخصومات والإضافات
                                                $sale_bill_discount_value = 0;
                                                $sale_bill_discount_type = 'pound';
                                                $sale_bill_extra_value = 0;
                                                $sale_bill_extra_type = 'pound';
                                                
                                                $extras = $sale_bill->extras;
                                                foreach ($extras as $key) {
                                                    if ($key->action == 'discount') {
                                                        $sale_bill_discount_value = $key->action_type == 'pound' ? floatval($key->value) : ($key->value / 100) * $sum;
                                                    } else {
                                                        $sale_bill_extra_value = $key->action_type == 'pound' ? floatval($key->value) : ($key->value / 100) * $sum;
                                                    }
                                                }
                                                
                                                // حساب المبلغ بعد الخصم
                                                $after_discount = $sum - $sale_bill_discount_value + $sale_bill_extra_value;
                                                
                                                // حساب الضريبة
                                                $tax_value_added = floatval($company->tax_value_added);
                                                $tax_amount = ($tax_value_added / 100) * $after_discount;
                                                
                                                // المبلغ الإجمالي بعد الضريبة
                                                $debit = $sale_bill->final_total - $sale_bill->paid;
                                                
                                                // حساب المدين والدائن
                                                $credit = floatval($sale_bill->paid);
                                                
                                                // حساب الرصيد الحالي بناءً على الرصيد السابق
                                                $current_balance = $previous_balance + ($debit - $credit);
                                                
                                                // تحديث الرصيد السابق للسطر التالي
                                                $previous_balance = $current_balance;
                                                
                                                // تحديث الرصيد النهائي
                                                $final_balance = $current_balance;
                                                
                                                // عرض الرصيد الحالي
                                                if ($current_balance < 0) {
                                                    echo '(' . floatval(abs($current_balance)) . ') ' . $currency;
                                                } else {
                                                    echo floatval($current_balance) . ' ' . $currency;
                                                }
                                                
                                                ?>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr
                                        style="font-size: 15px; font-weight: bold; background: #f1f1f1; text-align: center;">
                                        <td colspan="6">اجمالي المديونية للمبيعات </td>
                                        <td>
                                            <?php
                                            if ($final_balance < 0) {
                                                echo '(' . floatval(abs($final_balance)) . ') ' . $currency;
                                            } else {
                                                echo floatval($final_balance) . ' ' . $currency;
                                            }
                                            ?>

                                        </td>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                    @endif
                    <!------------------------------------------------BONDS--------------------------------------------------->
                    <div class="clearfix"></div>
                    <php?= $i=0 ?>
                        @if (isset($bonds) && !$bonds->isEmpty())
                            <h3 class="alert alert-sm alert-light text-center" style="margin:20px auto;">
                                السندات للعميل
                            </h3>
                            <div class="table-respo ">
                                <table
                                    style="width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid; box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                                    <thead style="font-size: 15px !important;">
                                        <tr
                                            style="font-size: 13px !important; background: #222751; color: white; height: 44px !important; text-align: center;">
                                            <th>رقم السند</th>
                                            <th>التاريخ</th>
                                            <th>الحساب</th>
                                            <th>النوع</th>
                                            <th>المبلغ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalReceipts = 0; // مجموع القبض
                                            $totalPayments = 0; // مجموع الصرف
                                            $i = 0; // عداد لرقم السند
                                        @endphp
                                        @foreach ($bonds as $bond)
                                            @php
                                                // جمع المبلغ بناءً على النوع
                                                if ($bond->type == 'قبض') {
                                                    $totalReceipts += floatval($bond->amount);
                                                } elseif ($bond->type == 'صرف') {
                                                    $totalPayments += floatval($bond->amount);
                                                }
                                            @endphp
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $bond->date }}</td>
                                                <td>{{ $bond->account }}</td>
                                                <td>{{ $bond->type }}</td>
                                                <td>{{ $bond->amount }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        @php
                                            $difference = $totalPayments - $totalReceipts; // الفارق بين القبض والصرف
                                        @endphp

                                        <tr
                                            style="font-size: 13px !important; background: #f1f1f1; color: #222751; text-align: center;">
                                            <td colspan="3" class="text-center"><strong>إجمالي الصرف</strong></td>
                                            <td colspan="2" class="text-center">
                                                <strong>{{ $totalPayments }}</strong>
                                            </td>
                                        </tr>
                                        <tr
                                            style="font-size: 13px !important; background: #f1f1f1; color: #222751; text-align: center;">
                                            <td colspan="3" class="text-center"><strong>إجمالي القبض</strong></td>
                                            <td colspan="2" class="text-center">
                                                <strong>{{ $totalReceipts }}</strong>
                                            </td>
                                        </tr>
                                        <tr
                                            style="font-size: 13px !important; background: #e6e6e6; color: #222751; text-align: center;">
                                            <td colspan="3" class="text-center"><strong>
                                                    اجمالي المديونية
                                                    (الصرف - القبض)</strong></td>
                                            <td colspan="2" class="text-center">
                                                <strong>
                                                    @if ($difference < 0)
                                                        ({{ abs($difference) }})
                                                    @else
                                                        {{ $difference }}
                                                    @endif
                                                </strong>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @endif

                        <!------------------------------------------------BONDS--------------------------------------------------->


                        <div class="clearfix"></div>
                        @if (isset($returns) && !$returns->isEmpty())
                            <p class="alert alert-sm alert-dark mt-3 text-center">
                                مرتجعات العميل
                            </p>
                            <div class="table-respo">
                                <table
                                    style="width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid; box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                                    <thead style="font-size: 15px !important;">
                                        <tr
                                            style="font-size: 13px !important; background: #222751; color: white; height: 44px !important; text-align: center;">
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
                                            <!--<th class="text-center"> الفرق في المديونية</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalDifference = 0;

                                            // Get all SaleBill IDs globally (e.g., ordered by `id`)
                                            $allSaleBills = App\Models\SaleBill::where(
                                                'company_id',
                                                $outer_client_k->company_id,
                                            )
                                                ->where('status', 'done')
                                                ->orderBy('id')
                                                ->pluck('id')
                                                ->toArray();

                                            // Create a mapping: SaleBill ID => Global Index (starting from 1)
                                            $globalIndexMap = array_flip($allSaleBills); // Flip to create ID => Index mapping

                                        @endphp

                                        @foreach ($returns as $key => $return)
                                            @php
                                                $differences =
                                                    floatval($return->balance_before) -
                                                    floatval($return->balance_after);
                                                $totalDifference += $differences;

                                                // Get the global index of the SaleBill
                                                $globalIndex = isset($globalIndexMap[$return->bill_id])
                                                    ? $globalIndexMap[$return->bill_id] + 1
                                                    : 'N/A';
                                            @endphp
                                            <tr>
                                                <td>{{ $globalIndex }}</td> <!-- Correct syntax for Blade output -->

                                                <td>{{ $return->outerClient->client_name }}</td>
                                                <td>{{ $return->product->product_name }}</td>
                                                <td>{{ floatval($return->return_quantity) }}</td>
                                                <td>{{ $return->time }}</td>
                                                <td>{{ $return->date }}</td>
                                                <td>{{ floatval($return->product_price) }}</td>
                                                <td>{{ floatval($return->quantity_price) }}</td>
                                                <td>{{ floatval($return->balance_before) }}</td>
                                                <td>{{ floatval($return->balance_after) }}</td>
                                                <td>{{ floatval($return->before_return) }}</td>
                                                <td>{{ floatval($return->after_return) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr
                                            style="font-size: 13px !important; background: #f1f1f1; color: #222751; text-align: center;">
                                            <td colspan="11" class="text-center"><strong>إجمالي المديونية</strong>
                                            </td>
                                            <td class="text-center">
                                                <strong>
                                                    @if ($totalDifference < 0)
                                                        ({{ abs($totalDifference) }})
                                                    @else
                                                        {{ $totalDifference }}
                                                    @endif
                                                </strong>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @endif

                        <div class="clearfix"></div>
                        @if (isset($cashs) && !$cashs->isEmpty())
                            <p class="alert alert-sm alert-warning mt-3 text-center">
                                مدفوعات نقدية لهذا العميل
                            </p>
                            <div class="table-respo">
                                <table
                                    style="width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid; box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                                    <thead style="font-size: 15px !important;">
                                        <tr
                                            style="font-size: 13px !important; background: #222751; color: white; height: 44px !important; text-align: center;">
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
                                            $totalAmountCash = 0;
                                            $cash_entries = App\Models\Cash::where(
                                                'company_id',
                                                $outer_client_k->company_id,
                                            )
                                                ->orderBy('id')
                                                ->get();
                                        @endphp

                                        @foreach ($cashs as $key => $cash)
                                            @php
                                                $cash_position =
                                                    $cash_entries->search(function ($item) use ($cash) {
                                                        return $item->id == $cash->id; // Use $cash->id if $id is undefined
                                                    }) + 1;

                                                $totalAmountCash += floatval($cash->amount);
                                            @endphp
                                            <tr>
                                                <td>{{ $cash_position }}</td>
                                                <td>{{ $cash->outerClient->client_name }}</td>
                                                <td>{{ floatval($cash->amount) }}</td>
                                                <td>{{ floatval($cash->balance_before) }}</td>
                                                <td>{{ floatval($cash->balance_after) }}</td>
                                                <td>{{ $cash->bill_id }}</td>
                                                <td>{{ $cash->date }}</td>
                                                <td>{{ $cash->time }}</td>
                                                <td>{{ $cash->safe->safe_name }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr
                                            style="font-size: 13px !important; background: #f1f1f1; color: #222751; text-align: center;">
                                            <td colspan="2" class="text-center"><strong> إجمالي المبلغ
                                                    المدفوع</strong></td>
                                            <td class="text-center"><strong>
                                                    @if ($totalAmountCash < 0)
                                                        ({{ abs($totalAmountCash) }})
                                                    @else
                                                        {{ $totalAmountCash }}
                                                    @endif
                                                </strong></td>
                                            <td colspan="6"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @endif

                        @if (isset($borrows) && !$borrows->isEmpty())
                            <p class="alert alert-sm alert-warning mt-3 text-center">
                                سلفيات الى العميل
                            </p>
                            <div class="table-respo">
                                <table
                                    style="width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid; box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                                    <thead style="font-size: 15px !important;">
                                        <tr
                                            style="font-size: 13px !important; background: #222751; color: white; height: 44px !important; text-align: center;">
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
                                            $totalAmount = 0;
                                            $totalBorrowedAmount = 0;
                                        @endphp
                                        @foreach ($borrows as $key => $cash)
                                            @php
                                                $amount = floatval(abs($cash->amount));
                                                $totalAmount += $amount;
                                                $totalBorrowedAmount += $amount;
                                            @endphp
                                            <tr>
                                                <td>{{ $cash->cash_number }}</td>
                                                <td>{{ $cash->outerClient->client_name }}</td>
                                                <td>{{ $amount }}</td>
                                                <td>{{ floatval($cash->balance_before) }}</td>
                                                <td>{{ floatval($cash->balance_after) }}</td>
                                                <td>{{ $cash->bill_id }}</td>
                                                <td>{{ $cash->date }}</td>
                                                <td>{{ $cash->time }}</td>
                                                <td>{{ $cash->safe->safe_name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr
                                            style="font-size: 13px !important; background: #e9ecef; color: #222751; text-align: center;">
                                            <td colspan="2" class="text-center"><strong>إجمالي المبلغ
                                                    المستلف</strong></td>
                                            <td class="text-center"><strong>
                                                    @if ($totalBorrowedAmount < 0)
                                                        ({{ abs($totalBorrowedAmount) }})
                                                    @else
                                                        {{ $totalBorrowedAmount }}
                                                    @endif
                                                </strong></td>
                                            <td colspan="6"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @endif
                        @if (isset($bankcashs) && !$bankcashs->isEmpty())
                            <p class="alert alert-sm alert-warning mt-3 text-center">
                                مدفوعات بنكية لهذا العميل
                            </p>
                            <div class="table-respo">
                                <table
                                    style="width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid; box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                                    <thead style="font-size: 15px !important;">
                                        <tr
                                            style="font-size: 13px !important; background: #222751; color: white; height: 44px !important; text-align: center;">
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
                                            $totalAmount = 0;
                                        @endphp
                                        @foreach ($bankcashs as $key => $cash)
                                            @php
                                                $amount = floatval($cash->amount);
                                                $totalAmount += $amount;
                                            @endphp
                                            <tr>
                                                <td>{{ $cash->cash_number }}</td>
                                                <td>{{ $cash->outerClient->client_name }}</td>
                                                <td>{{ $amount }}</td>
                                                <td>{{ floatval($cash->balance_before) }}</td>
                                                <td>{{ floatval($cash->balance_after) }}</td>
                                                <td>{{ $cash->bill_id }}</td>
                                                <td>{{ $cash->date }}</td>
                                                <td>{{ $cash->time }}</td>
                                                <td>{{ $cash->bank->bank_name }}</td>
                                                <td>{{ $cash->bank_check_number }}</td>
                                                <td>{{ $cash->notes }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr
                                            style="font-size: 13px !important; background: #f1f1f1; color: #222751; text-align: center;">
                                            <td colspan="2" class="text-center"><strong>إجمالي المبلغ المدفوع
                                                    بنكيًا</strong></td>
                                            <td class="text-center"><strong>
                                                    @if ($totalAmount < 0)
                                                        ({{ abs($totalAmount) }})
                                                    @else
                                                        {{ $totalAmount }}
                                                    @endif
                                                </strong></td>
                                            <td colspan="8"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @endif

                        @if (isset($outer_client_k) && !empty($outer_client_k))
                            <div class="col-lg-12 text-center mt-3 mb-3">
                                <span class="alert alert-info text-center ">
                                    مديونية العميل الحالية
                                    <!--{{ floatval($outer_client_k->prev_balance) }} {{ $currency }}-->
                                    <?php
                                    // Ensure each variable is defined, defaulting to 0 if not set
                                    $final_balance = isset($final_balance) ? $final_balance : 0;
                                    $difference = isset($difference) ? $difference : 0;
                                    $totalBorrowedAmount = isset($totalBorrowedAmount) ? $totalBorrowedAmount : 0;
                                    $totalAmountCash = isset($totalAmountCash) ? $totalAmountCash : 0;
                                    $totalAmount = isset($totalAmount) ? $totalAmount : 0;
                                    $totalDifference = isset($totalDifference) ? $totalDifference : 0;
                                    $currency = isset($currency) ? $currency : ''; // Default to empty string if currency isn't set
                                    
                                    // Calculate totals
                                    $totalDepit = $final_balance + $difference + $totalBorrowedAmount;
                                    $totalCridit = $totalAmountCash + $totalAmount + $totalDifference;
                                    
                                    $totalIndebtedness = $totalIndebtedness = round($totalDepit - $totalCridit + $outer_client_k->prev_balance, 3);
                                    
                                    // Output the total indebtedness with currency
                                    
                                    if ($totalIndebtedness < 0) {
                                        echo '(' . floatval(abs($totalIndebtedness)) . ') ' . $currency;
                                    } else {
                                        echo floatval($totalIndebtedness) . ' ' . $currency;
                                    }
                                    ?>

                                </span>
                            </div>
                        @endif

                </td>
            </tr>
        </tbody>
    </table>
    <script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
    <script type="text/javascript"></script>
</body>

</html>
