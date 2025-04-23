<?php if ($currency == 'جنيه مصري') {
    $currency = 'LE';
} elseif ($currency == 'ريال سعودي') {
    $currency = 'SR';
} ?>
<!DOCTYPE html>
<html>

<head>
    <title>
        @if (!empty($sale_bill->outer_client_id))
            <?php echo $sale_bill->OuterClient->client_name . ' - فاتورة رقم ' . $sale_bill->company_counter; ?>
        @else
            <?php echo 'فاتورة بيع نقدى' . ' - فاتورة رقم ' . $sale_bill->company_counter; ?>
        @endif
    </title>
    <meta charset="utf-8" />
    <link href="{{ asset('/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <style type="text/css" media="screen">
        .custom-table {
            width: 100%;
            background-color: #fff;
            /* Set background color to white */
        }
        .btn {
            font-size:1.2rem !important;
        }

        .border-gray {
            border: 2px solid #bfb9b9;
            /* Gray border color */
        }

        .custom-table th,
        .custom-table td {
            padding: 10px;
            border-bottom: 2px solid #fff;
            /* Set border between rows to white */
        }

        .custom-table th {
            font-weight: bold;
        }

        .custom-table td {
            font-size: 20px;
            vertical-align: middle;
            font-weight: 500;
        }

        .custom-table td:nth-child(1),
        /* For dotted vertical lines between columns */
        .custom-table th:nth-child(1),
        .custom-table td:nth-child(2),
        .custom-table th:nth-child(2),
        .custom-table td:nth-child(3),
        .custom-table th:nth-child(3),
        .custom-table td:nth-child(4),
        .custom-table th:nth-child(4),
        .custom-table td:nth-child(5),
        .custom-table th:nth-child(5),
        .custom-table td:nth-child(6),
        .custom-table th:nth-child(6),
        .custom-table td:nth-child(7),
        .custom-table th:nth-child(7) {
            border-right: 2px dotted #bfb9b9;
            ;
        }

        .custom-table th:last-child,
        .custom-table td:last-child {
            border-right: none;
        }

        .custom-table tr {
            position: relative;
        }

        .custom-table thead tr::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            border-bottom: 2px dashed #bfb9b9;
        }

        .custom-table tbody tr:last-child td {
            border-bottom: 2px dashed #bfb9b9;

        }

        .custom-table tbody tr:last-child {
            border-bottom: 2px dashed #bfb9b9;
            border-collapse: separate;
        }

        @font-face {
            font-family: 'Cairo';
            src: url({{ asset('fonts/Cairo.ttf') }});
        }

        .invoice-container {
            width: 80%;
            margin: auto;
        }

        .bordernone {
            border: none !important;
        }

        .border-black {
            border: 2px solid black;
        }

        .right,
        .left {
            width: 49%;
            background: #f8f9fb;
            font-size: 17px;
            border-radius: 2px;
            overflow: hidden;
            font-weight: 400;
        }

        tr {
            border-bottom: 1px solid #2d2d2d20 !important;
            padding-bottom: 4px !important;
            padding-top: 4px !important;
            font-size: 18px !important;
        }

        .txtheader {
            font-weight: 700;
            font-size: 34px;
        }

        .centerTd {
            font-weight: bold;
        }

        .border2 {
            border: 1px solid #2d2d2d03 !important;
        }

        .header-container {
            height: 180px;
            overflow: hidden;
        }

        .headerImg,
        .footerImg {
            height: 200px;
        }

        .headerImg img,
        .footerImg img {
            height: 100%;
            width: 100%;
            object-fit: scale-down;
        }
    </style>
    <style type="text/css" media="print">
        .custom-table {
            width: 100%;
            background-color: #fff;
            /* Set background color to white */
        }

        .border-gray {
            border: 2px solid #bfb9b9;
            /* Gray border color */
        }

        .custom-table th,
        .custom-table td {
            padding: 10px;
            border-bottom: 2px solid #fff;
            /* Set border between rows to white */
        }

        .custom-table th {
            font-weight: bold;
        }

        .custom-table td {
            font-size: 20px;
            vertical-align: middle;
            font-weight: 500;
        }

        .custom-table td:nth-child(1),
        /* For dotted vertical lines between columns */
        .custom-table th:nth-child(1),
        .custom-table td:nth-child(2),
        .custom-table th:nth-child(2),
        .custom-table td:nth-child(3),
        .custom-table th:nth-child(3),
        .custom-table td:nth-child(4),
        .custom-table th:nth-child(4),
        .custom-table td:nth-child(5),
        .custom-table th:nth-child(5),
        .custom-table td:nth-child(6),
        .custom-table th:nth-child(6),
        .custom-table td:nth-child(7),
        .custom-table th:nth-child(7) {
            border-right: 2px dotted #bfb9b9;
            ;
        }

        .custom-table th:last-child,
        .custom-table td:last-child {
            border-right: none;
        }

        .custom-table tr {
            position: relative;
        }

        .custom-table thead tr::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            border-bottom: 2px dashed #bfb9b9;
        }

        .custom-table tbody tr:last-child td {
            border-bottom: 2px dashed #bfb9b9;

        }

        .custom-table tbody tr:last-child {
            border-bottom: 2px dashed #bfb9b9;
            border-collapse: separate;
        }

        #buttons {
            display: none !important;
        }

        .right,
        .left {
            background: #f2f2f2 !important;
            width: 48%;
            font-size: 17px !important;
            border-radius: 2px;
            overflow: hidden;
            font-weight: 400;
        }

        tr {
            border-bottom: 1px solid #2d2d2d20 !important;
            padding-bottom: 10px !important;
            padding-top: 10px !important;
        }

        .txtheader {
            font-weight: 900;
            font-size: 34px;
        }

        /* .txtheader2 {
            font-weight: 100;
            font-size: 28px;
        } */

        .tete>* {
            text-align: right !important;
        }
    </style>
</head>

<body>

    <div class="invoice-container border mt-4">
        <div class="text-center" id="buttons">
            <button class="btn  btn-success" onclick="window.print()">@lang('sales_bills.Print the invoice')</button>
            <a class="btn  btn-danger" href="{{ route('client.sale_bills.create1') }}">@lang('sales_bills.back') </a>
            <button class="show_hide_header btn  btn-warning no-print" dir="ltr">
                <i class="fa fa-eye-slash"></i>
                @lang('sales_bills.Show or hide the header')
            </button>
            <button class="show_hide_footer btn  btn-primary no-print" dir="ltr">
                <i class="fa fa-eye-slash"></i>
                @lang('sales_bills.Show or hide the footer')
            </button>
            <button class="btn  btn-success" dir="ltr" onclick="sendToWhatsApp()">
                <i class="fa fa-whatsapp"></i>
                @lang('sales_bills.Send to whatsapp')
            </button>
        </div>
        <div class="all-data" style="border-top: 1px solid #2d2d2d20;padding-top: 25px;">

            @if (!empty($company->basic_settings->header))
                <div class="headerImg">
                    <img class="img-footer" src="{{ asset($company->basic_settings->header) }}" />
                </div>
            @endif
            @php
                use Salla\ZATCA\GenerateQrCode;
                use Salla\ZATCA\Tags\InvoiceDate;
                use Salla\ZATCA\Tags\InvoiceTaxAmount;
                use Salla\ZATCA\Tags\InvoiceTotalAmount;
                use Salla\ZATCA\Tags\Seller;
                use Salla\ZATCA\Tags\TaxNumber;

                // Ensure date and time are formatted correctly
                $invoiceDate = date('Y-m-d\TH:i:s\Z', strtotime($sale_bill->date . ' ' . $sale_bill->time));

                $displayQRCodeAsBase64 = GenerateQrCode::fromArray([
                    new Seller($company->company_name), // seller name
                    new TaxNumber($company->tax_number), // seller tax number
                    new InvoiceDate($invoiceDate), // invoice date in ISO 8601 format
                    new InvoiceTotalAmount(number_format($sale_bill->final_total, 2, '.', '')), // invoice total amount
                    new InvoiceTaxAmount(number_format($sale_bill->total_tax, 2, '.', '')), // invoice tax amount
                    // Additional tags can be added here if needed
                ])->render();
            @endphp
            <div class="header-container d-flex align-items-center">

                <div class=" col-md-7 qrcode">

                    @if (!$isMoswada)
                        <img width="200" src="{{ $displayQRCodeAsBase64 }}" />
                    @endif
                </div>
                  @php
                    
                        $items = \App\Models\SaleBillElement::where('sale_bill_id', $sale_bill->id)
                            ->where('company_id', $sale_bill->company_id)
                            ->get();
                
                        $allReturned = true;
                
                        foreach ($items as $product) {
                            $alreadyReturnedQty = \App\Models\SaleBillReturn::where('bill_id', $sale_bill->id)
                                ->where('product_id', $product->product_id)
                                ->sum('return_quantity');
                
                            if ($alreadyReturnedQty < $product->quantity) {
                                $allReturned = false;
                                break;
                            }
                        }
                    @endphp
                <div class="col-md-5  mx-auto text-center">
                    
                    <!--<div class="txtheader mx-auto text-center">-->
                    <!--    @if (!$isMoswada && !$allReturned)-->
                    <!--        @lang('sales_bills.Tax invoice')-->
                     
                    <!--        @lang('sales_bills.Draft invoice')-->
                    <!--    @endif-->
                    <!--</div>-->

                    @if (!$isMoswada && !$allReturned)
                        <span class="txtheader text-muted"> @lang('sales_bills.Tax invoice')</span>
                       @elseif($allReturned)
                              <span class="txtheader text-muted">@lang('sales_bills.Return invoice')</span>
                        @else
                        <span class="txtheader text-muted">@lang('sales_bills.Draft invoice')</span>
                    @endif
                    <div class="d-flex justify-content-center mt-5 text-muted" style="font-size: 20px;font-weight:700">
                        <div class="text-center pl-4 pr-4">
                            التاريخ
                            <br>
                            {{ $sale_bill->created_at }}
                        </div>
                        <div class="text-center pl-4 pr-4">
                            الرقم التسلسلي
                            <br>
                            SME00{{ $position }}
                        </div>
                    </div>
                </div>
                {{--
                    <div class="logo">
                        <img class="logo" style="object-fit: scale-down;" width="204"
                            src="{{ asset($company->company_logo) }}">
                    </div> --}}

            </div>

            <hr class="mt-5 pl-4 pr-4" style="border: 1px solid #c9c3c3;">
            <div class="row  pl-4 pr-4">
                <div class="col-md-12 text-right text-muted" style="font-size:28px; font-weight:600">
                    معلومات البائع
                </div>
                <div class="col-md-12">
                    <div class="row mt-2">
                        <div class="col-md-2 d-flex flex-column mt-4 mb-4  text-right text-muted "
                            style="font-size:18px; font-weight:500">
                            <span>رقم التسجيل التجاري</span>
                            <span class="mt-2">{{ $company->civil_registration_number }}</span>
                        </div>
                        <div class="col-md-4 d-flex flex-column mt-4 mb-4 text-right border-left text-muted border-dark"
                            style="font-size:18px; font-weight:500">
                            <span>رقم تسجيل ضريبة القيمة المضافه للبائع</span>
                            <span class="mt-2">{{ $company->tax_number ?? '-' }}</span>
                        </div>
                        <div class="col-md-3 d-flex flex-column mt-4 mb-4 text-right border-left text-muted border-dark"
                            style="font-size:18px; font-weight:500">
                            <span>عنوان البائع</span>
                            <span class="mt-2">{{ $company->company_address ?? '-' }}</span>
                        </div>
                        <div class="col-md-3 d-flex flex-column mt-4 mb-4 text-right border-left text-muted border-dark"
                            style="font-size:18px; font-weight:500">
                            <span>اسم البائع</span>
                            <span class="mt-2">{{ $company->company_name }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="mt-5 pl-4 pr-4" style="border: 1px solid #c9c3c3;">

            <div class="row  pl-4 pr-4">
                <div class="col-md-12 text-right text-muted" style="font-size:28px; font-weight:600">
                    معلومات المشتري
                </div>
                <div class="col-md-12">
                    <div class="row mt-2">
                        <div class="col-md-2 d-flex flex-column mt-4 mb-4  text-right text-muted "
                            style="font-size:18px; font-weight:500">
                            <span>رقم التسجيل التجاري</span>
                            <span class="mt-2">{{ $sale_bill->outerClient->commercial_register }}</span>
                        </div>
                        <div class="col-md-4 d-flex flex-column mt-4 mb-4 text-right border-left text-muted border-dark"
                            style="font-size:18px; font-weight:500">
                            <span>رقم تسجيل ضريبة القيمة المضافه للمشتري</span>
                            <span class="mt-2">{{ $sale_bill->outerClient->tax_number ?? '-' }}</span>
                        </div>
                        <div class="col-md-3 d-flex flex-column mt-4 mb-4 text-right border-left text-muted border-dark"
                            style="font-size:18px; font-weight:500">
                            <span>عنوان المشتري</span>
                            <span
                                class="mt-2">{{ $sale_bill->outerClient->addresses[0]->client_address ?? '-' }}</span>
                        </div>
                        <div class="col-md-3 d-flex flex-column mt-4 mb-4 text-right border-left text-muted border-dark"
                            style="font-size:18px; font-weight:500">
                            <span>اسم المشتري</span>
                            <span
                                class="mt-2">{{ $sale_bill->outerClient->shop_name ?? $sale_bill->outerClient->client_name }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="mt-5 pl-4 pr-4" style="border: 1px solid #c9c3c3;">

            <div class="row mt-4">
                <div class="container">
                    <table class="custom-table text-right">
                        <thead>
                            <tr st class="text-muted">
                                <th>المجموع شامل ضريبة القيمة المضافة</th>
                                <th>قيمة الضريبة</th>
                                <th>قيمة الخصم</th>
                                <th>نسبة الضريبة</th>
                                <th>المجموع الفرعي بدون الضريبة</th>
                                <th>الكمية</th>
                                <th>سعر الوحدة</th>
                                <th>المنتج</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $extras = $sale_bill->extras;
                            @endphp

                            @if (!$elements->isEmpty())
                                @foreach ($elements as $element)
                                    @php
                                        $elementDiscount =
                                            $element->discount_type == 'percent'
                                                ? ($element->quantity_price * $element->discount_value) / 100
                                                : $element->discount_value;
                                        // Calculate Product Tax
                                        $ProdTax = 0;
                                        if ($company->tax_value_added && $company->tax_value_added != 0) {
                                            $ProdTax = $sale_bill->value_added_tax
                                                ? $element->quantity_price - ($element->quantity_price * 20) / 23
                                                : ($element->quantity_price * 15) / 100;
                                        }

                                        // Calculate Product Total
                                        $ProdTotal = $element->quantity_price;
                                        if ($company->tax_value_added && $company->tax_value_added != 0) {
                                            $ProdTotal = $sale_bill->value_added_tax
                                                ? $element->quantity_price
                                                : $element->quantity_price + ($element->quantity_price * 15) / 100;
                                        }

                                        // Calculate Quantity Price Without Tax
                                        $priceWithoutTax = $sale_bill->value_added_tax
                                            ? ($element->quantity_price * 20) / 23
                                            : $element->quantity_price;
                                    @endphp

                                    <tr class="text-muted"
                                        style="font-size:18px !important; height: 34px !important; text-align: center;">
                                        <td>
                                            {{ $element->tax_type == 0 ? $element->quantity_price + $element->tax_value - $elementDiscount : $element->quantity_price - $elementDiscount }}
                                        </td>

                                        <td>{{ $element->tax_value }}</td>
                                        <td>{{ $element->discount_value }}{{ $element->discount_type == 'percent' ? ' %' : '' }}
                                        </td>
                                        <td>{{ $company->tax_value_added ?? '0' }}%</td>
                                        <td>{{ $priceWithoutTax }}</td>
                                        <td class="text-center">
                                            <span>{{ $element->unit->unit_name }}</span>
                                            <span>{{ $element->quantity }}</span>
                                        </td>
                                        <td>{{ $element->product_price }}</td>
                                        <td>{{ $element->product->product_name }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>


                    </table>
                    {{-- <hr style="width:100%;border: none; border-top: 2px dashed #bfb9b9;width: calc(100% - 2rem);"> --}}
                </div>
            </div>
            <hr class="mt-5 pl-4 pr-4" style="border: 1px solid #c9c3c3;">
            <div class="container mb-5">
                <div class="row mt-4 border border-gray rounded p-2">
                    <div class="col-md-2 text-center text-muted" style="font-size: 24px; font-weight: 700;">
                        {{-- @if ($discount->action_type == 'poundAfterTax') --}}
                        {{-- @if ($realtotal > 0) --}}
                        ({{ $sale_bill->final_total - $sale_bill->total_tax }})
                        {{-- @endif --}}
                        {{-- @else
                            @if ($realtotal > 0)
                                {{ $sumWithOutTax }}
                            @endif
                        @endif --}}
                    </div>
                    <div class="col-md-10 text-right text-muted" style="font-size: 24px; font-weight: 700;">
                        المجموع
                    </div>
                </div>
                <div class="row mt-4 border border-gray rounded p-2">
                    <div class="col-md-2 text-center text-muted" style="font-size: 24px; font-weight: 700;">
                        @if ($company->tax_value_added && $company->tax_value_added != 0)
                            {{ $sale_bill->total_tax }}
                        @else
                            0
                        @endif
                    </div>
                    <div class="col-md-10 text-right text-muted" style="font-size: 24px; font-weight: 700;">
                        ضريبة القيمه المضافة ({{ $company->tax_value_added ?? '0' }}%)
                    </div>
                </div>
                <div class="row mt-4 border border-gray rounded p-2">
                    <div class="col-md-2 text-center text-muted" style="font-size: 24px; font-weight: 700;">
                        @if ($company->tax_value_added && $company->tax_value_added != 0)
                            {{-- @if ($discount->action_type == 'poundAfterTax') --}}
                            {{ $sale_bill->final_total }}
                            {{-- @else
                                {{ $sumWithTax }}
                            @endif --}}
                        @else
                            {{ $sumWithOutTax }}
                        @endif
                    </div>
                    <div class="col-md-10 text-right text-muted" style="font-size: 24px; font-weight: 700;">
                        المجموع مع الضريبة
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script>
    function sendToWhatsApp() {
        const clientPhone = '{{ $sale_bill->outerClient->phones[0]->client_phone ?? '-' }}';
        const invoiceUrl = '{{ route('client.sale_bills.sent', [$sale_bill->token, 7, 2, 0]) }}';
        const message = `Please check your invoice at the following link: ${invoiceUrl}`;
        const whatsappUrl = `https://wa.me/${clientPhone}?text=${encodeURIComponent(message)}`;
        setTimeout(() => {
            window.open(whatsappUrl, '_blank');
        }, 1000);
    }
</script>
<script type="text/javascript">
    $('.show_hide_header').on('click', function() {
        $('.headerImg').slideToggle();
    });
    $('.show_hide_footer').on('click', function() {
        $('.footerImg').slideToggle();
    });
</script>

</html>
