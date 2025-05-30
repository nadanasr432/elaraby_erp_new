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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style type="text/css" media="screen">
        @font-face {
            font-family: 'Cairo';
            src: url({{ asset('fonts/Cairo.ttf') }});
        }

        .btn {
            font-size: 1.2rem !important;
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
    @php
        $companyId = Auth::user()->company_id;
        // If the form was submitted, set the color in the settings
        $currentColor = \App\Services\SettingsService::getSettingValue($companyId, 'color', 'print2', '#222751');
        if (request()->isMethod('post')) {
            if (Auth::check()) {
                $color = request('page_color', '#222751'); // Default to white if no color is selected
                // Call the setSetting function directly in Blade
                \App\Services\SettingsService::setSetting($companyId, 'color', $color, 'print2');
                $currentColor = \App\Services\SettingsService::getSettingValue(
                    $companyId,
                    'color',
                    'print2',
                    '#222751',
                );
            } else {
                // Optionally, handle unauthenticated users if needed (e.g., redirect or show an error message)
                return redirect()->route('login'); // Redirect to login or show an error
            }
        }

        // Get the current page color from the settings

    @endphp
    <div class="invoice-container border mt-4">
        <div class="text-center" id="buttons">
            <button class="btn  btn-success" onclick="window.print()">@lang('sales_bills.Print the invoice') </button>
            <a class="btn  btn-danger" href="{{ route('client.sale_bills.create1') }}"> @lang('sales_bills.back') </a>
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
            <div class="col-md-3">
                <div class="card shadow-sm border-light rounded p-3 mb-3">
                    <button type="button" class="btn  btn-primary rounded-pill shadow-sm w-100" data-bs-toggle="modal"
                        data-bs-target="#colorModal"
                        style="border-color: {{ old('page_color', $currentColor ?? '#222751') }}; background-color: {{ old('page_color', $currentColor ?? '#222751') }};">
                        @lang('main.Choose Print Color')
                    </button>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="colorModal" tabindex="-1" aria-labelledby="colorModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="colorModalLabel">@lang('main.Select Print Color')</h5>
                            <button type="button" class="btn btn-close" data-bs-dismiss="modal"
                                aria-label="Close">X</button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ url()->current() }}">
                                @csrf
                                <div class="mb-3 text-center">
                                    <input type="color" class="form-control form-control-color mx-auto"
                                        id="page_color" name="page_color"
                                        value="{{ old('page_color', $currentColor ?? '#222751') }}"
                                        title="Choose your color" style="width: 120px; height: 40px; cursor: pointer;">
                                </div>
                                <button type="submit" class="btn btn-secondary">@lang('main.save')</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

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
            @if (app()->getLocale() == 'en')
                <div class="header-container d-flex align-items-center">

                    <div class="logo">
                        <img class="logo" style="object-fit: scale-down;" width="204"
                            src="{{ asset($company->company_logo) }}">
                    </div>
                    <div class="txtheader mx-auto text-center">
                        @if (!$isMoswada)
                            {{ __('sidebar.Goods Receipt Order') }}
                            <br>
                            Goods Receipt Order
                        @else
                            @lang('sales_bills.Draft invoice')
                        @endif
                    </div>


                    <div class="qrcode">


                        @if (!$isMoswada)
                            <img width="200" src="{{ $displayQRCodeAsBase64 }}" />
                        @endif

                    </div>
                </div>
            @else
                <div class="header-container d-flex align-items-center">
                    <div class="qrcode">


                        @if (!$isMoswada)
                            <img width="200" src="{{ $displayQRCodeAsBase64 }}" />
                        @endif

                    </div>

                    <div class="txtheader mx-auto text-center">
                        @if (!$isMoswada)
                            {{ __('sidebar.Goods Receipt Order') }}
                            <br>
                            Goods Receipt Order
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
                                    style="color: {{ $currentColor }}; font-weight: bold;text-align: left !important;">
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
                                    style="color: {{ $currentColor }}; font-weight: bold;text-align: left !important;">
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
                    <div class="left border2 pr-2 pl-2 ml-2" style="height: fit-content !important;">
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
                    <div class="right border2 pr-1 pl-2 ml-3" style="height: fit-content !important;">
                        <table style="width: 100%;">
                            <tr class="d-flex">
                                <td width="40%" class="text-left">@lang('sales_bills.elements number')</td>
                                <td width="60%" class="text-left">{{ $sale_bill->elements->count() }}</td>
                            </tr>
                        </table>

                    </div>
                </div>
            @else
                <div class="invoice-information d-flex justify-content-around">
                    <div class="left border2 pr-2 pl-2">
                        <table style="width: 100%;">
                            <tr class="d-flex">
                                <td width="60%" class="text-right centerTd">{{ $pageData['clientName'] }}</td>
                                <td width="40%"
                                    style="color: {{ $currentColor }}; font-weight: bold;text-align: right !important;">
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
                                    style="color: {{ $currentColor }}; font-weight: bold;text-align: right !important;">
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
                    class="invoice-information2 mt-2 d-flex @if (empty($sale_bill->notes) && $company->company_id != 20) justify-content-around ml-2 @else justify-content-around @endif">
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

                    <div class="right  pr-1 pl-2" style="height: fit-content !important;">
                        <table style="width: 100%;">
                            <tr class="d-flex">
                                <td width="60%" class="text-center">{{ $sale_bill->elements->count() }}</td>
                                <td width="40%" class="text-left">@lang('sales_bills.elements number')</td>
                            </tr>
                        </table>
                    </div>
                </div>

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
            <div class="d-flex justify-content-between">
                <div class="products-details p-2 col-6 ">
                    <br>
                    <h5 class="ml-4" style="margin-left:412px !important">
                        : التوقيع 
                    </h5>
                </div>

                <div class="products-details p-2 col-6">
                    <table
                        style="width: 100%;width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid;box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                        @if (!empty($discount) && $discount > 0)
                            <tr
                                style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 15px !important; height: 44px !important; text-align: center;{{ $currentColor }}">
                                <td style="text-align: left;padding-left: 14px;">@lang('sales_bills.Discount')</td>
                                <td dir="rtl">
                                    <!--{{ $discountNote . '  ' ?? '' }}-->
                                    <!--{{ $discountValue }} {{ $currency }}-->
                                    {{-- @if ($realtotal > 0)
                                            @if ($discount2 && ($discount2->action_type == 'poundAfterTax' || $discount2->action_type == 'pound'))
                                                ({{ $discount2->value }}) --}}
                                    ({{ $sale_bill->total_discount }})

                                    {{ $currency }}
                                    {{-- @elseif($discount2)
                                                ({{ $discount2->value }}%)
                                            @endif
                                        @endif --}}
                                </td>

                            </tr>
                        @endif
                        <tr
                            style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 15px !important; height: 44px !important; text-align: center;{{ $currentColor }}">
                            <td style="text-align: left;padding-left: 14px;">@lang('sales_bills.Total, excluding tax')</td>
                            <td>{{ number_format($sale_bill->final_total - $sale_bill->total_tax, 2) }}
                                {{ $currency }}
                            </td>

                        </tr>


                        <?php
                    if (!empty($ifThereIsDiscountNote)) {
                    ?>
                        <tr
                            style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 15px !important; height: 44px !important; text-align: center;{{ $currentColor }}">
                            <td style="text-align: left;padding-left: 14px;">:@lang('sales_bills.Discount note') </td>
                            <td style="width: 50% !important;">{{ $ifThereIsDiscountNote }}</td>

                        </tr>
                        <?php
                    }
                    ?>


                        <tr
                            style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 15px !important; height: 44px !important; text-align: center;{{ $currentColor }}">
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
                            style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 15px !important; height: 44px !important; text-align: center;background: {{ $currentColor }};color:white;">
                            <td style="text-align: left;padding-left: 14px;">@lang('sales_bills.Total including tax') </td>
                            {{-- @if ($company->tax_value_added && $company->tax_value_added != 0) --}}
                            {{-- @if ($discount->action_type == 'poundAfterTax') --}}
                            <td dir="rtl">
                                {{ $sale_bill->final_total }}
                                {{ $currency }}
                            </td>
                            {{-- @else
                                        <td dir="rtl">
                                            {{ $sumWithTax }}
                                            {{ $currency }}
                                        </td>
                                    @endif --}}
                            {{-- @else
                                    <td dir="rtl">
                                        {{ $sale_bill->final_total - $sale_bill->total_tax }}
                                        {{ $currency }}
                                    </td>
                                @endif --}}

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
                                    style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 15px !important; height: 44px !important; text-align: center;background: {{ $currentColor }};color:white;">
                                    <td style="text-align: left;padding-left: 14px;" colspan="2">
                                        @lang('sales_bills.Terms and Conditions') </td>
                                </tr>
                                <tr
                                    style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 15px !important; height: 49px !important; text-align: center;{{ $currentColor }}">
                                    <td style="text-align: left;padding-left: 14px;direction: rtl;padding-top: 15px;">
                                        {!! $company->basic_settings->sale_bill_condition !!}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
        @else
            <div class="d-flex justify-content-between">
                <div class="products-details p-2 col-6 ">
                    <br>
                    <h5 class="ml-4" style="margin-left:412px !important">
                        : التوقيع 
                    </h5>
                </div>
                <div class="products-details p-2 col-6">
                    <table
                        style="width: 100%;width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid;box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                        @if (!empty($discount) && $discount > 0)
                            <tr
                                style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 15px !important; height: 44px !important; text-align: center;{{ $currentColor }}">
                                <td dir="rtl">
                                    <!--{{ $discountNote . '  ' ?? '' }}-->
                                    <!--{{ $discountValue }} {{ $currency }}-->
                                    {{-- @if ($realtotal > 0)
                                            @if ($discount2 && ($discount2->action_type == 'poundAfterTax' || $discount2->action_type == 'pound'))
                                                ({{ $discount2->value }}) --}}
                                    ({{ $sale_bill->total_discount }})

                                    {{ $currency }}
                                    {{-- @elseif($discount2)
                                                ({{ $discount2->value }}%)
                                            @endif
                                        @endif --}}
                                </td>
                                <td style="text-align: right;padding-right: 14px;">@lang('sales_bills.Discount')</td>
                            </tr>
                        @endif
                        <tr
                            style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 15px !important; height: 44px !important; text-align: center;{{ $currentColor }}">
                            <td>{{ number_format($sale_bill->final_total - $sale_bill->total_tax, 2) }}
                                {{ $currency }}
                            </td>
                            <td style="text-align: right;padding-right: 14px;">@lang('sales_bills.Total, excluding tax')</td>
                        </tr>


                        <?php
                    if (!empty($ifThereIsDiscountNote)) {
                    ?>
                        <tr
                            style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 15px !important; height: 44px !important; text-align: center;{{ $currentColor }}">
                            <td style="width: 50% !important;">{{ $ifThereIsDiscountNote }}</td>
                            <td style="text-align: right;padding-right: 14px;">:@lang('sales_bills.Discount note') </td>
                        </tr>
                        <?php
                    }
                    ?>


                        <tr
                            style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 15px !important; height: 44px !important; text-align: center;{{ $currentColor }}">
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
                            style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 15px !important; height: 44px !important; text-align: center;background: {{ $currentColor }};color:white;">
                            {{-- @if ($company->tax_value_added && $company->tax_value_added != 0) --}}
                            {{-- @if ($discount->action_type == 'poundAfterTax') --}}
                            <td dir="rtl">
                                {{ $sale_bill->final_total }}
                                {{ $currency }}
                            </td>
                            {{-- @else
                                        <td dir="rtl">
                                            {{ $sumWithTax }}
                                            {{ $currency }}
                                        </td>
                                    @endif --}}
                            {{-- @else
                                    <td dir="rtl">
                                        {{ $sale_bill->final_total - $sale_bill->total_tax }}
                                        {{ $currency }}
                                    </td>
                                @endif --}}
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
                                    style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 15px !important; height: 44px !important; text-align: center;background: {{ $currentColor }};color:white;">
                                    <td style="text-align: right;padding-right: 14px;" colspan="2">
                                        @lang('sales_bills.Terms and Conditions') </td>
                                </tr>
                                <tr
                                    style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 15px !important; height: 49px !important; text-align: center;{{ $currentColor }}">
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
        <br>
        @if (!empty($company->basic_settings->footer))
            <div class="footerImg">
                <img class="img-footer" src="{{ asset($company->basic_settings->footer) }}" />
            </div>
            <br>
        @endif

    </div>
    </div>


</body>

</html>
<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>

<script>
    function sendToWhatsApp() {
        const clientPhone = '{{ $sale_bill->outerClient->phones[0]->client_phone ?? '-' }}';
        const invoiceUrl = '{{ route('client.sale_bills.sent', [$sale_bill->token, 2, 1, 0]) }}';
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
