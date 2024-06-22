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
        @font-face {
            font-family: 'Cairo';
            src: url({{ asset('fonts/Cairo.ttf') }});
        }

        .invoice-container {
            width: 80%;
            margin: auto;
        }

        .right,
        .left {
            width: 48%;
            background: #f2f2f2;
            font-size: 17px;
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
            font-weight: 700;
            font-size: 28px;
        }

        .centerTd {
            font-weight: bold;
        }

        .border2 {
            border: 1px solid #2d2d2d03 !important;
        }

        .header-container {
            height: 135px;
            overflow: hidden;
        }
    </style>
    <style type="text/css" media="print">
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
            font-weight: 700;
            font-size: 28px;
        }

        .tete>* {
            text-align: right !important;
        }
    </style>
</head>

<body>
    <div class="invoice-container border mt-4">
        <div class="text-center" id="buttons">
            <button class="btn btn-sm btn-success" onclick="window.print()">@lang('sales_bills.Print the invoice') </button>
            <a class="btn btn-sm btn-danger" href="{{ route('client.sale_bills.create') }}"> @lang('sales_bills.back') </a>
        </div>
        <div class="all-data" style="border-top: 1px solid #2d2d2d20;padding-top: 25px;">
            <?php
            use Salla\ZATCA\GenerateQrCode;
            use Salla\ZATCA\Tags\InvoiceDate;
            use Salla\ZATCA\Tags\InvoiceTaxAmount;
            use Salla\ZATCA\Tags\InvoiceTotalAmount;
            use Salla\ZATCA\Tags\Seller;
            use Salla\ZATCA\Tags\TaxNumber;
            $displayQRCodeAsBase64 = GenerateQrCode::fromArray([
                new Seller($company->company_name), // seller name
                new TaxNumber($company->tax_number), // seller tax number
                new InvoiceDate($sale_bill->date . ' ' . $sale_bill->time), // invoice date as Zulu ISO8601 @see https://en.wikipedia.org/wiki/ISO_8601
                new InvoiceTotalAmount($sumWithTax), // invoice total amount
                new InvoiceTaxAmount($totalTax), // invoice tax amount
                // TODO :: Support others tags
            ])->render();
            ?>
            @if (app()->getLocale() == 'en')
                <div class="header-container d-flex align-items-center">

                    <div class="logo">
                        <img class="logo" style="object-fit: scale-down;" width="204"
                            src="{{ asset($company->company_logo) }}">
                    </div>
                    <div class="txtheader mx-auto text-center">
                        @if (!$isMoswada)
                            @lang('sales_bills.Tax bill')
                            <br>
                            TaxInvoice
                        @else
                            @lang('sales_bills.Draft invoice')
                        @endif
                    </div>


                    <div class="qrcode">


                        @if (!$isMoswada)
                            <img width="145" src="{{ $displayQRCodeAsBase64 }}" />
                        @endif

                    </div>
                </div>
            @else
                <div class="header-container d-flex align-items-center">
                    <div class="qrcode">


                        @if (!$isMoswada)
                            <img width="145" src="{{ $displayQRCodeAsBase64 }}" />
                        @endif

                    </div>

                    <div class="txtheader mx-auto text-center">
                        @if (!$isMoswada)
                            @lang('sales_bills.Tax bill')
                            <br>
                            TaxInvoice
                        @else
                            @lang('sales_bills.Draft invoice')
                        @endif
                    </div>

                    <div class="logo">
                        <img class="logo" style="object-fit: scale-down;" width="204"
                            src="{{ asset($company->company_logo) }}">
                    </div>
                </div>
            @endif

            <hr class="mt-1 mb-2">
            @if (app()->getLocale() == 'en')
                <!------------FIRST ROW----------------->
                <div class="invoice-information d-flex justify-content-around">
                    <div class="left border2 pr-2 pl-2">
                        <table style="width: 100%;">
                            <tr class="d-flex">
                                <td width="40%"
                                    style="color: {{ $printColor }}; font-weight: bold;text-align: left !important;">
                                    @lang('sales_bills.invoice to')
                                </td>
                                <td width="60%" class="text-right centerTd">{{ $pageData['clientName'] }}</td>

                            </tr>
                            <tr class="d-flex pt-1">
                                <td width="40%" class="text-left">@lang('sales_bills.address')</td>
                                <td width="60%" class="text-right">{{ $pageData['clientAddress'] }}</td>

                            </tr>
                            <tr class="d-flex pt-1">
                                <td width="40%" class="text-left"> @lang('sales_bills.Tax Number') </td>
                                <td width="60%" class="text-right">{{ $sale_bill->OuterClient->tax_number }}</td>

                            </tr>
                            <tr class="d-flex pt-1" style="border: none !important;">
                                <td width="40%" class="text-left">@lang('sales_bills.phone')</td>
                                <td width="60%" class="text-right">
                                    {{ !empty($sale_bill->OuterClient->phones) && count($sale_bill->OuterClient->phones) != 0 ? $sale_bill->OuterClient->phones[0]->client_phone : 'غير مسجل' }}
                                </td>

                            </tr>
                        </table>
                    </div>
                    <div class="right border2 pr-2 pl-2">
                        <table style="width: 100%;">
                            <tr class="d-flex">
                                <td width="40%"
                                    style="color: {{ $printColor }}; font-weight: bold;text-align: left !important;">
                                    @lang('sales_bills.invoice from')
                                </td>
                                <td width="60%" class="text-right centerTd">{{ $company->company_name }}</td>

                            </tr>
                            <tr class="d-flex pt-1">
                                <td width="40%" class="text-left">@lang('sales_bills.address')</td>
                                <td width="60%" class="text-right">{{ $pageData['branch_address'] }}</td>

                            </tr>
                            <tr class="d-flex pt-1">
                                <td width="40%" class="text-left">@lang('sales_bills.Tax Number') </td>
                                <td width="60%" class="text-right">{{ $company->tax_number }}</td>

                            </tr>
                            <tr class="d-flex pt-1" style="border: none !important;">
                                <td width="40%" class="text-left">@lang('sales_bills.phone')</td>
                                <td width="60%" class="text-right">{{ $pageData['branch_phone'] }}</td>

                            </tr>
                        </table>
                    </div>
                </div>
                <!-------------------------------------->
                <div
                    class="invoice-information2 mt-2 d-flex @if (empty($sale_bill->notes) && $company->company_id != 20) justify-content-left ml-2 @else justify-content-around @endif">
                    <div class="left border2 pr-2 pl-2" style="height: fit-content !important;">
                        <table style="width: 100%;">
                            <tr class="d-flex pt-1">
                                <td width="40%" class="text-left">@lang('sales_bills.invoice number')</td>
                                <td width="60%" class="text-right">100{{ $sale_bill->company_counter }}</td>

                            </tr>
                            <tr class="d-flex pt-1" style="border: none !important;">
                                <td width="40%" class="text-left"> @lang('sales_bills.invoice-date')</td>
                                <td width="60%" class="text-right">
                                    {{ $sale_bill->date . ' -- ' . $sale_bill->time }}
                                </td>

                            </tr>
                        </table>
                    </div>

                    <div class="right pr-2 pl-2" style="height: fit-content !important;">

                    </div>

                </div>
            @else
                <div class="invoice-information d-flex justify-content-around">
                    <div class="left border2 pr-2 pl-2">
                        <table style="width: 100%;">
                            <tr class="d-flex">
                                <td width="60%" class="text-right centerTd">{{ $pageData['clientName'] }}</td>
                                <td width="40%"
                                    style="color: {{ $printColor }}; font-weight: bold;text-align: right !important;">
                                    @lang('sales_bills.invoice to')
                                </td>
                            </tr>
                            <tr class="d-flex pt-1">
                                <td width="60%" class="text-right">{{ $pageData['clientAddress'] }}</td>
                                <td width="40%" class="text-right">@lang('sales_bills.address')</td>
                            </tr>
                            <tr class="d-flex pt-1">
                                <td width="60%" class="text-right">{{ $sale_bill->OuterClient->tax_number }}</td>
                                <td width="40%" class="text-right"> @lang('sales_bills.Tax Number') </td>
                            </tr>
                            <tr class="d-flex pt-1" style="border: none !important;">
                                <td width="60%" class="text-right">
                                    {{ !empty($sale_bill->OuterClient->phones) && count($sale_bill->OuterClient->phones) != 0 ? $sale_bill->OuterClient->phones[0]->client_phone : 'غير مسجل' }}
                                </td>
                                <td width="40%" class="text-right">@lang('sales_bills.phone')</td>
                            </tr>
                        </table>
                    </div>
                    <div class="right border2 pr-2 pl-2">
                        <table style="width: 100%;">
                            <tr class="d-flex">
                                <td width="60%" class="text-right centerTd">{{ $company->company_name }}</td>
                                <td width="40%"
                                    style="color: {{ $printColor }}; font-weight: bold;text-align: right !important;">
                                    @lang('sales_bills.invoice from')
                                </td>
                            </tr>
                            <tr class="d-flex pt-1">
                                <td width="60%" class="text-right">{{ $pageData['branch_address'] }}</td>
                                <td width="40%" class="text-right">@lang('sales_bills.address')</td>
                            </tr>
                            <tr class="d-flex pt-1">
                                <td width="60%" class="text-right">{{ $company->tax_number }}</td>
                                <td width="40%" class="text-right">@lang('sales_bills.Tax Number') </td>
                            </tr>
                            <tr class="d-flex pt-1" style="border: none !important;">
                                <td width="60%" class="text-right">{{ $pageData['branch_phone'] }}</td>
                                <td width="40%" class="text-right">@lang('sales_bills.phone')</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-------------------------------------->
                <div
                    class="invoice-information2 mt-2 d-flex @if (empty($sale_bill->notes) && $company->company_id != 20) justify-content-left ml-2 @else justify-content-around @endif">
                    <div class="left border2 pr-2 pl-2" style="height: fit-content !important;">
                        <table style="width: 100%;">
                            <tr class="d-flex pt-1">
                                <td width="60%" class="text-right">100{{ $sale_bill->company_counter }}</td>
                                <td width="40%" class="text-right">@lang('sales_bills.invoice number')</td>
                            </tr>
                            <tr class="d-flex pt-1" style="border: none !important;">
                                <td width="60%" class="text-right">
                                    {{ $sale_bill->date . ' -- ' . $sale_bill->time }}
                                </td>
                                <td width="40%" class="text-right"> @lang('sales_bills.invoice-date')</td>
                            </tr>
                        </table>
                    </div>

                    <div class="right pr-2 pl-2" style="height: fit-content !important;">

                    </div>

                </div>
            @endif

            @if (app()->getLocale() == 'en')
                <div class="products-details p-2">
                    <table
                        style="width: 100%;width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid;box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                        <thead style="font-size: 15px !important;">
                            <tr
                                style="font-size: 15px !important; background: {{ $printColor }}; color: white; height: 44px !important; text-align: center;">
                                <th style="border: 1px solid white;padding: 6px;">#</th>
                                <th style="border: 1px solid white;">@lang('sales_bills.product name') </th>
                                <th style="border: 1px solid white;">@lang('sales_bills.unit price') </th>
                                <th style="border: 1px solid white;">@lang('sales_bills.Quantity')</th>
                                <th style="border: 1px solid white;">@lang('sales_bills.The amount does not include tax') </th>
                                <th style="border: 1px solid white;">@lang('sales_bills.Tax')</th>
                                <th style="border: 1px solid white;">@lang('sales_bills.total')</th>
                            </tr>

                        </thead>
                        <tbody style="font-size: 15px !important;">
                            <?php
                            $extras = $sale_bill->extras;
                            if (!$elements->isEmpty()) {
                                $i = 0;
                                foreach ($elements as $element) {
                                    #--PRODUCT TAX--#
                                    if ($company->tax_value_added && $company->tax_value_added != 0) {
                                        $ProdTax = ($sale_bill->value_added_tax ? round($element->quantity_price - ($element->quantity_price * 20) / 23, 2) : round(($element->quantity_price * 15) / 100, 2)) . ' ' . $currency;
                                    } else {
                                        $ProdTax = 0 . ' ' . $currency;
                                    }
                                    #--PRODUCT TAX--#
                            
                                    #--PRODUCT TOTAL--#
                                    if ($company->tax_value_added && $company->tax_value_added != 0) {
                                        $ProdTotal = ($sale_bill->value_added_tax ? $element->quantity_price : round($element->quantity_price + ($element->quantity_price * 15) / 100, 2)) . ' ' . $currency;
                                    } else {
                                        $ProdTotal = $element->quantity_price . ' ' . $currency;
                                    }
                                    #--PRODUCT TOTAL--#
                            
                                    echo '
                            <tr style="font-size: 15px !important; height: 44px !important; text-align: center;background: #f2f2f2">
                                <td style="border: 1px solid rgba(161,161,161,0.63);">' .
                                        ++$i .
                                        '</td>
                                <td style="border: 1px solid rgba(161,161,161,0.63);">' .
                                        $element->product->product_name .
                                        '</td>
                                <td style="border: 1px solid rgba(161,161,161,0.63);">' .
                                        $element->product_price .
                                        ' ' .
                                        $currency .
                                        '</td>
                                <td class="text-center" style="border: 1px solid rgba(161,161,161,0.63);">
                                    <span>' .
                                        $element->quantity .
                                        '</span>
                                    <span>' .
                                        $element->unit->unit_name .
                                        '</span>
                                </td>
                                <td style="border: 1px solid rgba(161,161,161,0.63);">' .
                                        ($sale_bill->value_added_tax ? round(($element->quantity_price * 20) / 23, 2) : $element->quantity_price) .
                                        ' ' .
                                        $currency .
                                        '</td>
                                <td style="border: 1px solid rgba(161,161,161,0.63);">' .
                                        $ProdTax .
                                        '</td>
                                <td style="border: 1px solid rgba(161,161,161,0.63);">' .
                                        $ProdTotal .
                                        '</td>
                            </tr>';
                                }
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            @else
                <div class="products-details p-2">
                    <table
                        style="width: 100%;width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid;box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                        <thead style="font-size: 15px !important;">
                            <tr
                                style="font-size: 15px !important; background: {{ $printColor }}; color: white; height: 44px !important; text-align: center;">
                                <th style="border: 1px solid white;">@lang('sales_bills.total')</th>
                                <th style="border: 1px solid white;">@lang('sales_bills.Tax')</th>
                                <th style="border: 1px solid white;">@lang('sales_bills.The amount does not include tax') </th>
                                <th style="border: 1px solid white;">@lang('sales_bills.Quantity')</th>
                                <th style="border: 1px solid white;">@lang('sales_bills.unit price') </th>
                                <th style="border: 1px solid white;">@lang('sales_bills.product name') </th>
                                <th style="border: 1px solid white;padding: 6px;">#</th>
                            </tr>

                        </thead>
                        <tbody style="font-size: 15px !important;">
                            <?php
                            $extras = $sale_bill->extras;
                            if (!$elements->isEmpty()) {
                                $i = 0;
                                foreach ($elements as $element) {
                                    #--PRODUCT TAX--#
                                    if ($company->tax_value_added && $company->tax_value_added != 0) {
                                        $ProdTax = ($sale_bill->value_added_tax ? round($element->quantity_price - ($element->quantity_price * 20) / 23, 2) : round(($element->quantity_price * 15) / 100, 2)) . ' ' . $currency;
                                    } else {
                                        $ProdTax = 0 . ' ' . $currency;
                                    }
                                    #--PRODUCT TAX--#
                            
                                    #--PRODUCT TOTAL--#
                                    if ($company->tax_value_added && $company->tax_value_added != 0) {
                                        $ProdTotal = ($sale_bill->value_added_tax ? $element->quantity_price : round($element->quantity_price + ($element->quantity_price * 15) / 100, 2)) . ' ' . $currency;
                                    } else {
                                        $ProdTotal = $element->quantity_price . ' ' . $currency;
                                    }
                                    #--PRODUCT TOTAL--#
                            
                                    echo '
                                                                            <tr style="font-size: 15px !important; height: 44px !important; text-align: center;background: #f2f2f2">
                                                                                <td style="border: 1px solid rgba(161,161,161,0.63);">' .
                                        $ProdTotal .
                                        '</td>
                                                                                <td style="border: 1px solid rgba(161,161,161,0.63);">' .
                                        $ProdTax .
                                        '</td>
                                                                                <td style="border: 1px solid rgba(161,161,161,0.63);">' .
                                        ($sale_bill->value_added_tax ? round(($element->quantity_price * 20) / 23, 2) : $element->quantity_price) .
                                        ' ' .
                                        $currency .
                                        '</td>
                                                                                <td class="text-center" style="border: 1px solid rgba(161,161,161,0.63);">
                                                                                    <span>' .
                                        $element->unit->unit_name .
                                        '</span>
                                                                                    <span>' .
                                        $element->quantity .
                                        '</span>
                                                                                </td>
                                                                                <td style="border: 1px solid rgba(161,161,161,0.63);">' .
                                        $element->product_price .
                                        ' ' .
                                        $currency .
                                        '</td>
                                                                                <td style="border: 1px solid rgba(161,161,161,0.63);">' .
                                        $element->product->product_name .
                                        ' </td>
                                                                                <td style="border: 1px solid rgba(161,161,161,0.63);">' .
                                        ++$i .
                                        '</td>
                                                                            </tr>
                                                                            ';
                                }
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
            @endif
            <?php
            if ($sale_bill->company_id == 20) {
                echo "<p style='text-align: justify; direction: rtl; font-size: 12px; padding: 11px; background: #f3f3f3; margin: 2px 10px; border-radius: 6px; border: 1px solid #2d2d2d10;'>
                                        <span style='font-weight:bold;'>@lang('sales_bills.comments')</span> :
                                        شروط الاسترجاع والاستبدال (السيراميك و البورسلين):1-يجب علي العميل احضار الفاتورة الأصلية عند الارجاع أو الإستبدال ويبين سبب الإرجاع أو الإستبدال,2- يتم ارجاع او تبديل البضاعة خلال (۳۰) ثلاثين يوما من تاريخ إصدار الفاتورة,3-عند ارجاع أي كمية يتم إعادة شرائها من العميل باقل من (۱۰% ) من قيمتها الأصلية,4-,يجب ان تكون البضاعة في حالتها الأصلية أي سليمة وخالية من أي عيوب وضمن عبواتها أي (كرتون كامل)  للاسترجاع أو الاستبدال و يتم معاينتها للتأكد من سلامتها من قبل موظف المستودع,5- يقوم العميل بنقل البضاعة المرتجعة على حسابه من الموقع إلى مستودعاتنا حصرا خلال أوقات دوام المستودع ما عدا يوم الجمعة ولا يتم قبول أي مرتجع في الصالات المخصصة للعرض و البيع, 6- تم استرجاع أو تبدیل مواد الغراء والروبة أو الأصناف التجارية أو الاستكات أو المغاسل أو الاكسسوارات خلال ٢٤ ساعة من تاريخ إصدارالفاتورة وبحالتها الأصلية ولا يتم استرجاع أجور القص وقيمة البضاعة التي تم قصها بناء على طلب العميل (المذكورة في الفاتورة).
                                        (الرخام ):عند ارجاع أي كمية يتم إعادة شرائها من العميل بأقل (15 %) من قيمتها الأصلية مع إحضار الفاتورة الأصلية,يتم الإرجاع للبضاعة السليمة ضمن عبوتها الأصلية على أن تكون طبلية مقفلة من الرخام وخلال 30 يوما من تاريخ الفاتورة كحد أقصى ولا يقبل ارجاع طلبية مفتوحة من الرخام ولا نقبل بارجاع الرخام المقصوص حسب طلب العميل درج/ سلكو/ألواح
                                    </p>";
            }
            ?>
            @if (app()->getLocale() == 'en')
                <div class="row p-4 d-flex justify-content-end">

                    <div class="products-details p-2 col-6">
                        <table
                            style="width: 100%;width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid;box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">

                            <tr
                                style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 15px !important; height: 44px !important; text-align: center;background: #f2f2f2">
                                <td style="text-align: left;padding-left: 14px;">@lang('sales_bills.Discount')</td>
                                <td dir="rtl">
                                    {{ $discountNote . ' || ' ?? '' }}
                                    {{ $discountValue }} {{ $currency }}
                                </td>

                            </tr>

                            <tr
                                style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 15px !important; height: 44px !important; text-align: center;background: #f2f2f2">
                                <td style="text-align: left;padding-left: 14px;">@lang('sales_bills.Total, excluding tax')</td>
                                <td>{{ $sumWithOutTax }} {{ $currency }}</td>

                            </tr>


                            <?php
                    if (!empty($ifThereIsDiscountNote)) {
                    ?>
                            <tr
                                style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 15px !important; height: 44px !important; text-align: center;background: #f2f2f2">
                                <td style="text-align: left;padding-left: 14px;">:@lang('sales_bills.Discount note') </td>
                                <td style="width: 50% !important;">{{ $ifThereIsDiscountNote }}</td>

                            </tr>
                            <?php
                    }
                    ?>


                            <tr
                                style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 15px !important; height: 44px !important; text-align: center;background: #f2f2f2">
                                <td style="text-align: left;padding-left: 14px;">
                                    @lang('sales_bills.Total tax')
                                    ({{ $company->tax_value_added ?? '0' }}%)
                                </td>
                                @if ($company->tax_value_added && $company->tax_value_added != 0)
                                    <td>{{ $totalTax }} {{ $currency }} </td>
                                @else
                                    <td>0 {{ $currency }} </td>
                                @endif

                            </tr>

                            <tr
                                style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 15px !important; height: 44px !important; text-align: center;background: {{ $printColor }};color:white;">
                                <td style="text-align: left;padding-left: 14px;">@lang('sales_bills.Total including tax') </td>
                                @if ($company->tax_value_added && $company->tax_value_added != 0)
                                    <td>{{ $sumWithTax }} {{ $currency }} </td>
                                @else
                                    <td>{{ $sumWithOutTax }} {{ $currency }} </td>
                                @endif

                            </tr>
                        </table>
                    </div>
                    @if (!empty($sale_bill->notes))
                        <div class="right border2 pr-2 pl-2"
                            style="height: fit-content !important;margin-top: 11px; border-radius: 5px;">
                            <table style="width: 100%;">
                                <tr class=pt-2" style="height: 38px;">
                                    <td class="text-left">:@lang('sales_bills.details')</td>
                                </tr>
                                <tr class="pt-2"
                                    style="border: none !important;padding-top: 7px !important;display: block;direction:rtl;">
                                    <td>
                                        <span class="tete">
                                            {!! $sale_bill->notes !!}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    @endif
                    @if (!empty($company->invoice_note))
                        <div class="products-details p-2 col-6">
                            <div class=" mx-auto text-left p-2" dir="rtl">
                                {{ $company->invoice_note }}
                                <br />
                            </div>
                        </div>
                    @endif
                    @if (!empty($company->basic_settings->sale_bill_condition))
                        <div class="products-details p-2 col-12">
                            <table
                                style="width: 100%;width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid;box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                                <tbody>
                                    <tr
                                        style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 15px !important; height: 44px !important; text-align: center;background: {{ $printColor }};color:white;">
                                        <td style="text-align: left;padding-left: 14px;" colspan="2">
                                            @lang('sales_bills.Terms and Conditions') </td>
                                    </tr>
                                    <tr
                                        style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 15px !important; height: 49px !important; text-align: center;background: #f2f2f2">
                                        <td
                                            style="text-align: left;padding-left: 14px;direction: rtl;padding-top: 15px;">
                                            {!! $company->basic_settings->sale_bill_condition !!}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
            @else
                <div class="row p-4">

                    <div class="products-details p-2 col-6">
                        <table
                            style="width: 100%;width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid;box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">

                            <tr
                                style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 15px !important; height: 44px !important; text-align: center;background: #f2f2f2">
                                <td dir="rtl">
                                    {{ $discountNote . ' || ' ?? '' }}
                                    {{ $discountValue }} {{ $currency }}
                                </td>
                                <td style="text-align: right;padding-right: 14px;">@lang('sales_bills.Discount')</td>
                            </tr>

                            <tr
                                style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 15px !important; height: 44px !important; text-align: center;background: #f2f2f2">
                                <td>{{ $sumWithOutTax }} {{ $currency }}</td>
                                <td style="text-align: right;padding-right: 14px;">@lang('sales_bills.Total, excluding tax')</td>
                            </tr>


                            <?php
                    if (!empty($ifThereIsDiscountNote)) {
                    ?>
                            <tr
                                style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 15px !important; height: 44px !important; text-align: center;background: #f2f2f2">
                                <td style="width: 50% !important;">{{ $ifThereIsDiscountNote }}</td>
                                <td style="text-align: right;padding-right: 14px;">:@lang('sales_bills.Discount note') </td>
                            </tr>
                            <?php
                    }
                    ?>


                            <tr
                                style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 15px !important; height: 44px !important; text-align: center;background: #f2f2f2">
                                @if ($company->tax_value_added && $company->tax_value_added != 0)
                                    <td>{{ $totalTax }} {{ $currency }} </td>
                                @else
                                    <td>0 {{ $currency }} </td>
                                @endif
                                <td style="text-align: right;padding-right: 14px;">
                                    @lang('sales_bills.Total tax')
                                    ({{ $company->tax_value_added ?? '0' }}%)
                                </td>
                            </tr>

                            <tr
                                style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 15px !important; height: 44px !important; text-align: center;background: {{ $printColor }};color:white;">
                                @if ($company->tax_value_added && $company->tax_value_added != 0)
                                    <td>{{ $sumWithTax }} {{ $currency }} </td>
                                @else
                                    <td>{{ $sumWithOutTax }} {{ $currency }} </td>
                                @endif
                                <td style="text-align: right;padding-right: 14px;">@lang('sales_bills.Total including tax') </td>
                            </tr>
                        </table>
                    </div>
                    @if (!empty($sale_bill->notes))
                        <div class="right border2 pr-2 pl-2"
                            style="height: fit-content !important;margin-top: 11px; border-radius: 5px;">
                            <table style="width: 100%;">
                                <tr class=pt-2" style="height: 38px;">
                                    <td class="text-right">:@lang('sales_bills.details')</td>
                                </tr>
                                <tr class="pt-2"
                                    style="border: none !important;padding-top: 7px !important;display: block;direction:rtl;">
                                    <td>
                                        <span class="tete">
                                            {!! $sale_bill->notes !!}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    @endif
                    @if (!empty($company->invoice_note))
                        <div class="products-details p-2 col-6">
                            <div class=" mx-auto text-right p-2" dir="rtl">
                                {{ $company->invoice_note }}
                                <br />
                            </div>
                        </div>
                    @endif
                    @if (!empty($company->basic_settings->sale_bill_condition))
                        <div class="products-details p-2 col-12">
                            <table
                                style="width: 100%;width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid;box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                                <tbody>
                                    <tr
                                        style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 15px !important; height: 44px !important; text-align: center;background: {{ $printColor }};color:white;">
                                        <td style="text-align: right;padding-right: 14px;" colspan="2">
                                            @lang('sales_bills.Terms and Conditions') </td>
                                    </tr>
                                    <tr
                                        style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 15px !important; height: 49px !important; text-align: center;background: #f2f2f2">
                                        <td
                                            style="text-align: right;padding-right: 14px;direction: rtl;padding-top: 15px;">
                                            {!! $company->basic_settings->sale_bill_condition !!}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
            @endif

        </div>
    </div>


</body>

</html>
