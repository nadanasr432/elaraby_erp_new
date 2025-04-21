<!DOCTYPE html>
<html>

<head>
    <title>
        <?php echo ' فاتورة مبيعات ضريبية رقم ' . $pos->id; ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('/app-assets/css-rtl/bootstrap.min.css') }}" rel="stylesheet" />
    <style type="text/css" media="screen">
        @font-face {
            font-family: 'Cairo';
            src: url("{{ asset('fonts/Cairo.ttf') }}");
        }
        * {
            color: #000 !important;
        }
        body,
        html {
            color: #000;
            font-family: 'Cairo' !important;
            font-size: 12px !important;
            font-weight: bold;
            margin: 8;
            padding: 0px;
            page-break-before: avoid;
            page-break-after: avoid;
            page-break-inside: avoid;
        }

        .no-print {
            /* position: fixed; */
            bottom: 0;
            color: #fff !important;
            left: 30px;
            height: 40px !important;
            border-radius: 0;
            padding-top: 10px;
            z-index: 9999;
        }

        table thead tr,
        table tbody tr {
            border-bottom: 2px solid #aaa;
        }

        table {
            text-align: right;
            width: 55% !important;
            margin-top: 10px !important;
        }
    </style>
    <style type="text/css" media="print">
        @media print {
            body {
                font-family: 'Cairo', sans-serif;
                direction: rtl;
                text-align: right;
                font-size: 14px;
                color: #333;
                margin: 10px;
                padding: 10px;
            }

            .pos_details {
                max-width: 80mm;
                margin: auto;
                background: #fff;
                padding: 15px;
                border: 1px solid #ddd;
                box-shadow: 0px 0px 5px #ddd;
            }

            .logo {
                display: block;
                margin: 0 auto 10px;
            }

            .invoice-title {
                font-size: 18px;
                font-weight: bold;
                text-align: center;
                margin-bottom: 10px;
            }

            .details {
                font-size: 13px;
                line-height: 1.7;
                padding: 5px;
                background: #f8f9fa;
                border-radius: 5px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
            }

            table th,
            table td {
                border: 1px solid #aaa;
                padding: 5px;
                text-align: center;
            }

            .highlight {
                background: #eee;
                font-weight: bold;
            }

            .total-amount {
                font-size: 16px;
                font-weight: bold;
                color: #d9534f;
            }

            .qr-code {
                text-align: center;
                margin-top: 15px;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body dir="rtl"
    style="background: #fff;
            page-break-before: avoid;
            page-break-after: avoid;
            page-break-inside: avoid;"
    class="text-right">
    <div class="d-flex justify-content-end  p-3">
        <button onclick="setFontSize();window.print();" class="ml-3 no-print BTN1 btn btn-md btn-success">اضغط
            للطباعة</button>
        <a href="{{ route('client.pos.create') }}" class="no-print BTN2 btn btn-md btn-danger"
            style="left:170px!important;">
            العودة الى نقطة البيع
        </a>
    </div>
    <div class="pos_details p-2">
        <div class="text-right">
            <img class="logo" style="width: 100px;height: 70px;margin-top: 1px;"
                src="{{ asset($pos->company->company_logo) }}" alt="">
        </div>
        <div class="text-center">
        <span>فاتورة ضريبية مبسطة</span><br>
        </div>
        <div class="no-print">
        <input type="number" value="13" min="10" max="15"
            class="chgTxtSize text-center font-weight-bold rounded mr-4 mt-2"><br>
            </div>
        <hr style="margin: 9px 0 -7px 0;">
        <div class="text-right mt-3">
            <div class="text-right">
                رقم الفاتورة :
                {{ $pos->company_counter }}
                <br>
                تاريخ - وقت :
                {{ $pos->created_at }}

            </div>
        </div>

        <hr style="margin: 9px 0 -7px 0;">

        <div class="text-right mt-3">
            <div class="text-right">
                {{ $pos->company->company_name }}<br>
                {!! $branch_address !!}<br>
                الرقم الضريبى :
                {!! $pos->company->tax_number !!}<br>
                الجوال :
                {{ $company->phone_number ?? '-' }}

                <br />
                جوال العميل :
                {{ $pos->outerClient->phones[0]->client_phone ?? '-' }}
            </div>
        </div>
        <div class="text-right mt-1">
            <div class="text-right">
                اسم البائع :
                {{ $pos->client->name }}
                <br />
                اسم المشترى :
                @if (isset($pos->outerClient->client_name))
                    {{ $pos->outerClient->client_name }}
                    <br />
                    الرقم الضريبى للمشترى :
                    {{ $pos->outerClient->tax_number }}
                    <br />
                @else
                    زبون
                @endif
            </div>
        </div>
        <div class="text-right mt-1">
            <div class="text-right">
                طريقة الدفع :
                @if (isset($pos->id))
                    @php
                        if (count(App\Models\Cash::where('bill_id', 'pos_' . $pos->id)->get())) {
                            echo 'كاش';
                        } elseif (count(App\Models\BankCash::where('bill_id', 'pos_' . $pos->id)->get())) {
                            echo 'شبكة';
                        } else {
                            echo '-';
                        }
                    @endphp
                @endif
            </div>
            <div class="text-right">
                حالة الفاتورة :
                @if (isset($pos->id))
                    @if ($pos->class == 'paid')
                        <span class="badge badge-success text-white p-2 rounded">مدفوعة</span>
                    @elseif($pos->class == 'partial')
                        <span class="badge badge-info text-white p-2 rounded">مدفوعة جزئيا</span>
                    @else
                        <span class="badge badge-danger text-white p-2 rounded">لم تم الدفع</span>
                    @endif
                @endif
            </div>
        </div>
        @if (isset($pos->tableNum) && $pos->tableNum != 0)
            <div class="text-right mt-1">
                <div class="text-right">
                    رقم الطاولة :
                    {{ $pos->tableNum }}
                </div>
            </div>
        @endif

        <hr style="margin: 9px 0 -7px 0;">

        <div class="text-right mt-3">
            <table dir="rtl">
                <thead>
                    <tr style="border: 2px solid #aaa">
                        <td style='border: 1px solid #aaa'>سعر</td>
                        <td style='border: 1px solid #aaa'>كمية</td>
                        <td style='border: 1px solid #aaa'>صنف</td>
                        <td style='border: 1px solid #aaa'>الخصم</td>
                        <td style='border: 1px solid #aaa'>اجمالى</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $pos_elements = $pos->elements;
                    $totalDiscountOnEveryElement = 0;
                    ?>
                    @if (isset($pos) && isset($pos_elements) && !$pos_elements->isEmpty())
                        <?php
                        foreach ($pos_elements as $element) {
                            $totalDiscountOnEveryElement += floatval($element->discount);
                            echo "<tr style='border: 1px solid #aaa;'>";
                            echo "<td style='border: 1px solid #aaa;' dir='ltr'><span>" . $element->product_price . '</span></td>';
                            echo "<td style='border: 1px solid #aaa;' dir='ltr'><span>" . $element->quantity . ' </span></td>';
                            echo "<td style='border: 1px solid #aaa;'>" . $element->product->product_name . '</td>';
                            echo "<td style='border: 1px solid #aaa;'>" . $element->discount . '</td>';
                            echo "<td style='border: 1px solid #aaa;'>" . $element->quantity_price . '</td>';
                            echo '</tr>';
                        }
                        ?>
                    @endif
                </tbody>
            </table>
            <div class="clearfix"></div>
            <table dir="rtl">
                <tr>
                    <td> الاجمالي قبل الضريبة</td>
                    <td class="text-left">
                        <span class="text-left">
                            <?php $inclusiveTax = 0; ?>
                            @if (isset($pos) && !$pos_elements->isEmpty())
                                <?php
                                $sum = 0;
                                foreach ($pos_elements as $pos_element) {
                                    $sum = $sum + floatval($pos_element->quantity_price);
                                }
                                ?>
                                @if ($pos->value_added_tax == 1)
                                    {{ round($sum * (100 / 115), 2) }}
                                    <?php $inclusiveTax = $sum - round($sum * (100 / 115), 2); ?>
                                @else
                                    {{ round($sum, 2) }}
                                @endif
                            @else
                                0
                            @endif
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>الضريبة</td>
                    <td class="text-left">
                        <span class="text-left">
                            <?php
                            $pos_tax = $pos->tax;
                            $pos_discount = $pos->discount;
                            ?>
                            @if ($pos->value_added_tax == 1)
                                %15
                            @else
                                {{ $pos->tax_amount }}
                            @endif
                        </span>
                    </td>
                </tr>
                @if ($pos->value_added_tax == 1)
                    <tr>
                        <td>قيمة الضريبة </td>
                        <td class="text-left">
                            <span class="text-left">
                                <?php
                                $pos_tax = $pos->tax;
                                $pos_discount = $pos->discount;
                                ?>

                                {{ $sum - round($sum * (100 / 115), 2) }}


                            </span>
                        </td>
                    </tr>
                @endif
                <tr>
                    <td>الخصم</td>
                    <td class="text-left">
                        <span class="text-left">
                            @if (isset($pos) && !empty($pos_discount))
                                <?php
                                $discount_value = $pos_discount->discount_value;
                                $discount_type = $pos_discount->discount_type;
                                $sum = 0;
                                foreach ($pos_elements as $pos_element) {
                                    $sum = $sum + $pos_element->quantity_price;
                                }
                                if ($discount_type == 'pound') {
                                    echo $discount_value + $totalDiscountOnEveryElement;
                                } else {
                                    $discount_value = ($discount_value / 100) * $sum;
                                    echo $discount_value + $totalDiscountOnEveryElement;
                                }
                                ?>
                            @else
                                {{ $totalDiscountOnEveryElement }}
                            @endif
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>الاجمالى النهائى</td>
                    <td class="text-left">
                        <span class="text-left">
                            {{ $pos->total_amount }}
                        </span>
                    </td>
                </tr>
            </table>
            <div class="clearfix"></div>
            <div class="visible-print text-right mt-2 mr-2">

                <?php
                use Salla\ZATCA\GenerateQrCode;
                use Salla\ZATCA\Tags\InvoiceDate;
                use Salla\ZATCA\Tags\InvoiceTaxAmount;
                use Salla\ZATCA\Tags\InvoiceTotalAmount;
                use Salla\ZATCA\Tags\Seller;
                use Salla\ZATCA\Tags\TaxNumber;
                // $displayQRCodeAsBase64 = GenerateQrCode::fromArray([
                //     new Seller($pos->company->company_name), // seller name
                //     new TaxNumber($pos->company->tax_number), // seller tax number
                //     new InvoiceDate($pos->created_at), // invoice date as Zulu ISO8601 @see https://en.wikipedia.org/wiki/ISO_8601
                //     new InvoiceTotalAmount($sum), // invoice total amount
                //     new InvoiceTaxAmount($pos->tax_amount) // invoice tax amount
                //     // TODO :: Support others tags
                // ])->render();
                $invoiceDate = date('Y-m-d\TH:i:s\Z', strtotime($pos->created_at . ' ' . $pos->created_at));

                $displayQRCodeAsBase64 = GenerateQrCode::fromArray([
                    new Seller($pos->company->company_name), // seller name
                    new TaxNumber($pos->company->tax_number), // seller tax number
                    new InvoiceDate($invoiceDate), // invoice date in ISO 8601 format
                    new InvoiceTotalAmount(number_format($sum, 2, '.', '')), // invoice total amount
                    new InvoiceTaxAmount(number_format($pos->tax_amount, 2, '.', '')), // invoice tax amount
                    // Additional tags can be added here if needed
                ])->render();
                ?>
                <style type="text/css">
                    .centerImage {
                        text-align: center;
                        display: block;
                    }
                </style>
                <img src="{{ $displayQRCodeAsBase64 }}" style="width: 200px; height: 160px;" alt="QR Code" />
            </div>
        </div>
    </div>

    @if ($posSettings->enableProdInvoice)
        <a target="_blank" href="{{ route('pos.prod_pos', $pos->id) }}" class="no-print btn btn-md btn-info"
            style="left:370px!important;">
            فاتورة الإعداد
        </a>
    @endif
    <script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
    <script type="text/javascript">
        var printFontSize = localStorage.getItem('fontSize') ? localStorage.getItem('fontSize') : '13';
        document.getElementsByClassName('pos_details')[0].style.fontSize = printFontSize + 'px';
        document.getElementsByClassName('chgTxtSize')[0].value = printFontSize;
        $(window).on('load', function() {
            $(".chgTxtSize").change(function() {
                $(".pos_details").css('font-size', $(this).val() + 'px');
            });
        });

        function setFontSize() {
            let selectedFontSize = document.getElementsByClassName('chgTxtSize')[0].value;
            localStorage.setItem('fontSize', selectedFontSize);
        }
    </script>
</body>

</html>
