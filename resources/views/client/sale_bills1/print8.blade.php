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
        .table thead th,
        td {
            vertical-align: middle !important;

        }

        .btn {
            font-size: 1.2rem !important;
        }

        .text-container {
            text-decoration: underline !important;
            padding: 10px 0;
        }

        .table thead th {
            border-bottom: 1px solid black;
        }


        .custom-table th {
            font-weight: bold;
        }

        .custom-table td {
            font-size: 20px;
            vertical-align: middle;
            font-weight: 500;
        }

        .table-bordered td,
        .table-bordered tr,
        .table-bordered th {
            border: 1px solid black;
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

        .container {
            width: 100%;

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
            border-bottom: 1px solid black !important;
            padding-bottom: 4px !important;
            padding-top: 4px !important;
            font-size: 11px !important;
        }

        .txtheader {
            font-weight: 600;
            font-size: 20px;
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

        .custom-print-table {
            background-color: #dbdbdb !important;
            border: 1px solid black !important;
        }
    </style>
    <style type="text/css" media="print">
        tr {

            font-size: 11px !important;
        }

        .table thead th,
        td {
            vertical-align: middle !important;

        }

        .table-bordered thead tr th,
        .table-bordered tbody tr td {
            border-left: 2px solid black !important;
            /* Vertical left border color */
            border-right: 2px solid black !important;
            /* Vertical right border color */
        }

        .table-bordered td,
        .table-bordered tr,
        .table-bordered th {
            border: 2px solid black;
        }

        .table-custom-sm td {
            background-color: #dbdbdb !important;

        }

        .table-one {
            background-color: #dbdbdb !important;
            border: 1px solid black !important;
            /* Proper border syntax */
        }

        .text-container {
            text-decoration: underline !important;
            padding: 10px 0;
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

        /*tr {*/
        /*    border-bottom: 1px solid black !important;*/
        /*    padding-bottom: 10px !important;*/
        /*    padding-top: 10px !important;*/
        /*}*/

        .txtheader {
            font-weight: 600;
            font-size: 20px;
        }

        /* .txtheader2 {
            font-weight: 100;
            font-size: 28px;
        } */

        .tete>* {
            text-align: right !important;
        }

        .table-one {
            background-color: #dbdbdb !important;
            border: 1px solid black;
            /* Proper border syntax */
        }
    </style>
</head>

<body>
    <div class="text-center" id="buttons">
        <button class="btn  btn-success" onclick="window.print()">@lang('sales_bills.Print the invoice')</button>
        <a class="btn  btn-danger" href="{{ route('client.sale_bills.create1') }}">@lang('sales_bills.back') </a>
        <button class="btn  btn-success" dir="ltr" onclick="sendToWhatsApp()">
            <i class="fa fa-whatsapp"></i>
            @lang('sales_bills.Send to whatsapp')
        </button>
    </div>
    <div class="invoice-container border">
        <div class="row d-flex justify-content-between mt-4 mb-3">
            <div class="col-md-4 text-container d-flex justify-content-end  pl-2">
                <span class=" text-center" style="font-weight: bold;font-size:27px"> {{ $company->company_name_en }}
                </span>
            </div>

            <div class="logo col-md-4 d-flex justify-content-center ">
                <img class="logo" style="object-fit: scale-down;" width="130"
                    src="{{ asset($company->company_logo) }}">
            </div>
            <div class="col-md-4 text-container d-flex justify-content-start">
                <span class="text-center" style="font-weight: bold;font-size:27px"> {{ $company->company_name }} </span>
            </div>
        </div>

        <div class="container">
            <table class="table table-custom-sm table-sm table-bordered text-center "
                style="background-color: #dbdbdb  !important;border:black;">

                <tbody>
                    <!-- First row -->
                    <tr>
                        <td>
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
                                @if (!$isMoswada && !$allReturned)
                                    <span class="txtheader text-black"> Tax invoice - فاتورة ضريبية</span>
                                @elseif($allReturned)
                                    <span class="txtheader text-black"> Return invoice - فاتورة مرتجع</span>
                                @else
                                    <span class="txtheader text-black"> Tax invoice - فاتورة ضريبية</span>
                                @endif

                            </div>
                        </td>

                    </tr>
                    <!-- Second row -->
                    <tr>
                        <td>
                            <div class="d-flex justify-content-end text-black" style="font-size: 16px;font-weight:600">
                                <div class="text-start pl-4 pr-4">
                                    Invoice Date & Time__ {{ $sale_bill->created_at }} __تاريخ ووقت الفاتورة

                                </div>
                                <div class="text-start pl-4 pr-4">
                                    Invois No__ SME00{{ $position }} __رقم الفاتورة
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="container">
            <table class="table table-sm table-bordered   table-sm text-center"">
                <tbody>
                    <!-- First row -->
                    <tr>
                        <td>
                            <div class="d-flex justify-content-between text-black"
                                style="font-size: 16px;font-weight:600">
                                <div class="col-md-3 text-start d-flex justify-start pl-4 pr-4"
                                    style=" font-size: 12px !important;">
                                    Sub Contractor Name
                                </div>
                                <div class="col-md-7 text-center d-flex justify-content-between pl-4 pr-4"
                                    style="font-weight: bold;">
                                    <span> {{ $company->company_name_en }}</span> <span>
                                        {{ $company->company_name }}</span>
                                </div>
                                <!--<div class="col-md-3 text-center d-flex justify-content-end pl-4 pr-4" style="font-weight: bold;">-->
                                <!--    {{ $company->company_name }}-->
                                <!--</div>-->
                                <div class="col-md-2 text-end d-flex justify-content-end pl-4 pr-4"
                                    style=" font-size: 12px !important;">
                                    اسم المقاول
                                </div>
                            </div>
                        </td>

                    </tr>
                    <!-- Second row -->
                    <tr>
                        <td>
                            <div class="d-flex justify-content-between text-black"
                                style="font-size: 16px;font-weight:600">
                                <div class="col-md-4 text-start d-flex justify-start pl-4 pr-4"
                                    style=" font-size: 12px !important;">
                                    CR No
                                </div>
                                <div class="col-md-4 text-center d-flex justify-content-center pl-4 pr-4">
                                    {{ $company->civil_registration_number }}
                                </div>
                                <div class="col-md-4 text-end d-flex justify-content-end pl-4 pr-4"
                                    style=" font-size: 12px !important;">
                                    رقم السجل التجاري
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex justify-content-between text-black"
                                style="font-size: 16px;font-weight:600">
                                <div class="col-md-4 text-start d-flex justify-start pl-4 pr-4"
                                    style=" font-size: 12px !important;">
                                    VAT Registration No
                                </div>
                                <div class="col-md-4 text-center d-flex justify-content-center pl-4 pr-4">
                                    {{ $company->tax_number ?? '-' }}
                                </div>
                                <div class="col-md-4 text-end d-flex justify-content-end pl-4 pr-4"
                                    style=" font-size: 12px !important;">
                                    رقم الضريبة
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex justify-content-between text-black"
                                style="font-size: 16px;font-weight:600">
                                <div class="col-md-4 text-start d-flex justify-start pl-4 pr-4"
                                    style=" font-size: 12px !important;">
                                    Official Address
                                </div>
                                <div class="col-md-4 text-center d-flex justify-content-center pl-4 pr-4">
                                    {{ $company->company_address ?? '-' }}
                                </div>
                                <div class="col-md-4 text-end d-flex justify-content-end pl-4 pr-4"
                                    style=" font-size: 12px !important;">
                                    العنوان
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="container">
            <table class="table table-sm table-bordered  text-center"">
                <tbody>
                    <!-- First row -->
                    <tr>
                        <td>
                            <div class="d-flex justify-content-between text-black"
                                style="font-size: 20px;font-weight:600">
                                <div class="col-md-4 text-start d-flex justify-start pl-4 pr-4"
                                    style=" font-size: 12px !important;">
                                    Company Name
                                </div>
                                <div class="col-md-4 text-center d-flex justify-content-center pl-4 pr-4"
                                    style="font-weight: bold;">
                                    {{ $sale_bill->outerClient->shop_name ?? $sale_bill->outerClient->client_name }}
                                </div>
                                <div class="col-md-4 text-end d-flex justify-content-end pl-4 pr-4"
                                    style=" font-size: 12px !important;">
                                    اسم العميل
                                </div>
                            </div>
                        </td>

                    </tr>
                    <!-- Second row -->
                    <tr>
                        <td>
                            <div class="d-flex justify-content-between text-black"
                                style="font-size: 16px;font-weight:600">
                                <div class="col-md-4 text-start d-flex justify-start pl-4 pr-4"
                                    style=" font-size: 12px !important;">
                                    CR No
                                </div>
                                <div class="col-md-4 text-center d-flex justify-content-center pl-4 pr-4">
                                    {{ $sale_bill->outerClient->commercial_register }}
                                </div>
                                <div class="col-md-4 text-end d-flex justify-content-end pl-4 pr-4"
                                    style=" font-size: 12px !important;">
                                    رقم السجل التجاري
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex justify-content-between text-black"
                                style="font-size: 16px;font-weight:600">
                                <div class="col-md-4 text-start d-flex justify-start pl-4 pr-4"
                                    style=" font-size: 12px !important;">
                                    VAT Registration No
                                </div>
                                <div class="col-md-4 text-center d-flex justify-content-center pl-4 pr-4">
                                    {{ $sale_bill->outerClient->tax_number ?? '-' }}
                                </div>
                                <div class="col-md-4 text-end d-flex justify-content-end pl-4 pr-4"
                                    style=" font-size: 12px !important;">
                                    رقم الضريبة
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="d-flex justify-content-between text-black"
                                style="font-size: 16px;font-weight:600">
                                <div class="col-md-4 text-start d-flex justify-start pl-4 pr-4"
                                    style=" font-size: 12px !important;">
                                    Official Address
                                </div>
                                <div class="col-md-4 text-center d-flex justify-content-center pl-4 pr-4">
                                    {{ $sale_bill->outerClient->addresses[0]->client_address ?? '-' }}
                                </div>
                                <div class="col-md-4 text-end d-flex justify-content-end pl-4 pr-4"
                                    style=" font-size: 12px !important;">
                                    العنوان
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="container">
            <table class="table table-sm table-bordered  text-center">
                <thead>
                    <tr>
                        <th style="font-size:14px !important">S.No. الرقم</th>
                        <th style="font-size:14px !important">Work Description البيانات</th>
                        <th style="font-size:14px !important">الكمية .Quantity</th>
                        <th style="font-size:14px !important">السعر Price</th>
                        <th style="font-size:14px !important">Deduction الخصم</th>
                        <th style="font-size:14px !important">Total Taxable Amount المجموع بدون ضريبة</th>
                        <th style="font-size:14px !important">Tax Amount {{ $company->tax_value_added ?? '0' }}% مبلغ
                            الضريبة</th>
                        <th style="font-size:14px !important">Total (Incl) VAT الاجمالي شامل الضريبة</th>
                        <th style="font-size:14px !important">Retention 10% تأمين اعمال</th>
                        <th style="font-size:14px !important">Net Amount To Pay صافي المبلغ المستحق</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $extras = $sale_bill->extras;

                        // Initialize variables to store totals for each column
                        $totalQuantity = 0;
                        $totalProductPrice = 0;
                        $totalDiscount = 0;
                        $totalTaxableAmount = 0;
                        $totalTax = 0;
                        $totalInclVAT = 0;
                        $totalRetention = 0;
                        $totalNetAmount = 0;
                    @endphp

                    @if (!$elements->isEmpty())
                        @php $i = 0; @endphp
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

                                // Calculate product price
                                $productPrice =
                                    $element->tax_type == 0
                                        ? $element->product_price + $element->tax_value
                                        : $element->product_price;

                                // Update totals for each column
                                $totalQuantity += $element->quantity;
                                $totalProductPrice += $element->product_price;
                                $totalDiscount += $element->discount_value;
                                $totalTaxableAmount +=
                                    $element->tax_type == 2
                                        ? $element->quantity_price - $element->tax_value
                                        : $element->quantity_price;
                                $totalTax += $element->tax_value;
                                $totalInclVAT +=
                                    $element->tax_type == 0
                                        ? $element->quantity_price + $element->tax_value
                                        : $element->quantity_price;
                                $totalRetention += $element->quantity_price * 0.1;
                                $totalNetAmount +=
                                    $element->tax_type == 0
                                        ? $element->quantity_price + $element->tax_value - $elementDiscount
                                        : $element->quantity_price - $elementDiscount;
                            @endphp

                            <tr>
                                <td>{{ ++$i }}</td>
                                <td class="d-flex justify-content-between"
                                    style="white-space: nowrap; gap: 100px; border: black !important;">
                                    <span>{{ $element->product->product_name_en }}</span>
                                    <span>{{ $element->product->product_name }}</span>

                                </td>


                                <td class="text-center">
                                    <span>{{ $element->quantity }}</span>
                                    <span>{{ $element->unit->unit_name }}</span>
                                </td>
                                <td>{{ round($element->product_price, 2) }}</td>
                                <td>{{ $element->discount_value }}{{ $element->discount_type == 'percent' ? ' %' : '' }}
                                </td>
                                <td>{{ round($element->tax_type == 2 ? $element->quantity_price - $element->tax_value : $element->quantity_price, 2) }}
                                </td>
                                <td>{{ $element->tax_value }}</td>
                                <td>{{ round($element->tax_type == 0 ? $element->quantity_price + $element->tax_value : $element->quantity_price, 2) }}
                                </td>
                                <td>{{ number_format($element->quantity_price * 0.1, 2) }}</td>
                                <td>{{ round($element->tax_type == 0 ? $element->quantity_price + $element->tax_value - $elementDiscount : $element->quantity_price - $elementDiscount, 2) }}
                                </td>
                            </tr>
                        @endforeach

                        <!-- Total Row -->
                        <tr style="border: 3px solid black !important;">
                            <td colspan="2">
                                <span class="d-flex justify-content-end text-right"style="font-size:20px;">Total
                                    =</span>
                            </td>
                            <td style="border: 2px solid black; font-weight: bold;">
                                {{ number_format($totalQuantity, 2) }}</td>
                            <td style="border: 2px solid black; font-weight: bold;">
                                {{ number_format($totalProductPrice, 2) }}</td>
                            <td style="border: 2px solid black; font-weight: bold;">
                                {{ number_format($totalDiscount, 2) }}</td>
                            <td style="border: 2px solid black; font-weight: bold;">
                                {{ number_format($totalTaxableAmount, 2) }}</td>
                            <td style="border: 2px solid black; font-weight: bold;">
                                {{ number_format($sale_bill->total_tax, 2) }}</td>
                            <td style="border: 2px solid black; font-weight: bold;">
                                {{ number_format($totalInclVAT, 2) }}</td>
                            <td style="border: 2px solid black; font-weight: bold;">
                                {{ number_format($totalRetention, 2) }}</td>
                            <td style="border: 2px solid black; font-weight: bold;">
                                {{ number_format($totalNetAmount, 2) }}</td>
                        </tr>

                    @endif
                </tbody>
            </table>

        </div>
        <div class="container">
            <table class="table table-sm table-bordered  text-center"">
                <tbody>
                    <tr style="font-weight: bold;">
                        <td rowspan="8" class="qr-code">
                            @php
                                use Salla\ZATCA\GenerateQrCode;
                                use Salla\ZATCA\Tags\InvoiceDate;
                                use Salla\ZATCA\Tags\InvoiceTaxAmount;
                                use Salla\ZATCA\Tags\InvoiceTotalAmount;
                                use Salla\ZATCA\Tags\Seller;
                                use Salla\ZATCA\Tags\TaxNumber;

                                // Ensure date and time are formatted correctly
                                $invoiceDate = date(
                                    'Y-m-d\TH:i:s\Z',
                                    strtotime($sale_bill->date . ' ' . $sale_bill->time),
                                );

                                $displayQRCodeAsBase64 = GenerateQrCode::fromArray([
                                    new Seller($company->company_name), // seller name
                                    new TaxNumber($company->tax_number), // seller tax number
                                    new InvoiceDate($invoiceDate), // invoice date in ISO 8601 format
                                    new InvoiceTotalAmount(number_format($sale_bill->final_total, 2, '.', '')), // invoice total amount
                                    new InvoiceTaxAmount(number_format($sale_bill->total_tax, 2, '.', '')), // invoice tax amount
                                    // Additional tags can be added here if needed
                                ])->render();
                            @endphp

                            @if (!$isMoswada)
                                <img width="200" class="mt-3 mb-3" src="{{ $displayQRCodeAsBase64 }}" />
                            @endif

                        </td>
                        <td>الاجمالي Total</td>
                        <td>{{ number_format($sale_bill->final_total - $sale_bill->total_tax, 2, '.', '') }}</td>
                    </tr>
                    <tr style="font-weight: bold;">
                        <td>الخصم Deduction</td>
                        <td>{{ $discountNote ? $discountNote . ' || ' : '' }}
                            {{-- @if ($discount->action_type == 'poundAfterTax') --}}
                             <img src="{{ asset('images/Sr_coin.svg') }}" width="10px"> ({{ $sale_bill->total_discount }})
                           
                        </td>
                    </tr>
                    <tr style="font-weight: bold;">
                        <td>الاجمالي الخاضع للضريبة Total Taxable Amount</td>
                        <td>{{ number_format($sale_bill->final_total - $sale_bill->total_tax, 2, '.', '') }}</td>
                    </tr>
                    <tr style="font-weight: bold;">
                        <td>
                            ضريبة القيمة المضافة
                            VAT {{ $company->tax_value_added ?? '0' }}%</td>
                        <td>{{ $sale_bill->total_tax }}</td>
                    </tr>
                    <tr style="font-weight: bold;">
                        <td>الاجمالي شامل الضريبة Total (Incl. VAT)</td>
                        <td>{{ $sale_bill->final_total }}</td>
                    </tr style="font-weight: bold;">
                    <tr style="font-weight: bold;">
                        <td>تامين اعمال Retention 10%</td>
                        <td>{{ number_format($sale_bill->final_total * 0.1, 2) }}</td>
                    </tr>
                    <tr style="font-weight: bold;">
                        <td>صافي المبلغ المستحق الدفع Net Current Amount To Pay</td>
                        <td>{{ number_format($sale_bill->final_total - $sale_bill->paid - $sale_bill->final_total * 0.1, 2) }}
                        </td>
                    </tr>
                </tbody>
            </table>
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
