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

        .bordernone {
            border: none !important;
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
        $currentColor = \App\Services\SettingsService::getSettingValue($companyId, 'color', 'print4', '#222751');
        // If the form was submitted, set the color in the settings
        if (request()->isMethod('post')) {
            if (Auth::check()) {
                $color = request('page_color', '#222751'); // Default to white if no color is selected
                // Call the setSetting function directly in Blade
                \App\Services\SettingsService::setSetting($companyId, 'color', $color, 'print4');
            } else {
                // Optionally, handle unauthenticated users if needed (e.g., redirect or show an error message)
                return redirect()->route('login'); // Redirect to login or show an error
            }
            $currentColor = \App\Services\SettingsService::getSettingValue($companyId, 'color', 'print4', '#222751');
        }

        // Get the current page color from the settings

    @endphp
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
                            @lang('sales_bills.Tax invoice')
                        @else
                            @lang('sales_bills.Draft invoice')
                        @endif
                    </div>


                    <div class="qrcode ">

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
                            @lang('sales_bills.Tax invoice')
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
                <div class="products-details" style="padding: 0px 18px;">
                    <table
                        style="width: 100%;width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid;box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                        <thead style="font-size:18px !important;">
                            <tr
                                style="font-size:18px !important; background:{{ $currentColor }}; color: white; height: 44px !important; text-align: center;">
                                <th>@lang('sales_bills.Release Date')</th>
                                <th>@lang('sales_bills.invoice number')</th>
                                <th>@lang('sales_bills.commercial register')</th>

                            </tr>
                        </thead>
                        <tbody style="font-size:18px !important;">

                            <tr class="even"
                                style="font-size:18px !important; height: 40px !important; text-align: center;">
                                <td>{{ $sale_bill->date }}</td>
                                <td>{{ $position }}</td>
                                <td>{{ $company->civil_registration_number }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @else
                <div class="products-details" style="padding: 0px 18px;">
                    <table
                        style="width: 100%;width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid;box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                        <thead style="font-size:18px !important;">
                            <tr
                                style="font-size:18px !important; background:{{ $currentColor }}; color: white; height: 44px !important; text-align: center;">
                                <th>@lang('sales_bills.commercial register')</th>
                                <th>@lang('sales_bills.invoice number')</th>
                                <th>@lang('sales_bills.Release Date')</th>
                            </tr>
                        </thead>
                        <tbody style="font-size:18px !important;">

                            <tr class="even"
                                style="font-size:18px !important; height: 40px !important; text-align: center;">
                                <td>{{ $company->civil_registration_number }}</td>
                                <td>{{ $position }}</td>
                                <td>{{ $sale_bill->date }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif
            @if (app()->getLocale() == 'en')
                <!------------FIRST ROW----------------->
                <div class="invoice-information row justify-content-around mt-3" style=" padding: 0px 24px;">
                    <div class="col-12 pr-2 pl-2">
                        <table style="width: 100%;">
                            <tr class="d-flex pt-1"
                                style="background:{{ $currentColor }}; color: white; font-size: 16px;border-radius: 7px 7px 0 0;padding: 8px !important;">

                                <td width="50%" class="text-left pr-2">@lang('sales_bills.invoice from')</td>
                                <td width="50%" class="text-left pr-2">@lang('sales_bills.Customer data')</td>
                            </tr>
                        </table>
                    </div>
                    <div class="right pr-2 pl-2"
                        style="border-left: 1px solid #2d2d2d2d !important;border-bottom: 1px solid #25252525;left: -5px;">
                        <table style="width: 100%;">
                            <tr class="d-flex bordernone">

                                <td width="40%" class="text-left">@lang('main.name')</td>
                                <td width="60%" class="text-right">{{ $company->company_name }}</td>
                            </tr>
                            <tr class="d-flex pt-1 bordernone">

                                <td width="40%" class="text-left">@lang('sales_bills.Tax Number') </td>
                                <td width="60%" class="text-right">{{ $company->tax_number ?? '-' }}</td>
                            </tr>
                            <tr class="d-flex pt-1 bordernone">

                                <td width="40%" class="text-left">@lang('sales_bills.phone')</td>
                                <td width="60%" class="text-right">{{ $company->phone_number ?? '-' }}</td>
                            </tr>
                            <tr class="d-flex pt-1 bordernone">

                                <td width="40%" class="text-left">@lang('sales_bills.address')</td>
                                <td width="60%" class="text-right">
                                    {{ $company->company_address ?? '-' }}
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="left pr-2 pl-2"
                        style="right: -5px;position:relative;border-bottom: 1px solid #25252525;">
                        <table style="width: 100%;">
                            <tr class="d-flex bordernone">

                                <td width="40%" class="text-left">@lang('sales_bills.client-name')</td>
                                <td width="60%" class="text-right centerTd">
                                    {{ $sale_bill->outerClient->shop_name ?? $sale_bill->outerClient->client_name }}
                                </td>
                            </tr>
                            <tr class="d-flex pt-1 bordernone">

                                <td width="40%" class="text-left">@lang('sales_bills.Tax Number')</td>
                                <td width="60%" class="text-right">
                                    {{ $sale_bill->outerClient->tax_number ?? '-' }}</td>
                            </tr>
                            <tr class="d-flex pt-1 bordernone">

                                <td width="40%" class="text-left">@lang('sales_bills.phone')</td>
                                <td width="60%" class="text-right">
                                    {{ $sale_bill->outerClient->phones[0]->client_phone ?? '-' }}</td>
                            </tr>
                            <tr class="d-flex pt-1 bordernone">

                                <td width="40%" class="text-left">@lang('sales_bills.address')</td>
                                <td width="60%" class="text-right">
                                    {{ $sale_bill->outerClient->addresses[0]->client_address ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>


                </div>
            @else
                <div class="invoice-information row justify-content-around mt-3" style=" padding: 0px 24px;">
                    <div class="col-12 pr-2 pl-2">
                        <table style="width: 100%;">
                            <tr class="d-flex pt-1"
                                style="background:{{ $currentColor }}; color: white; font-size: 16px;border-radius: 7px 7px 0 0;padding: 8px !important;">
                                <td width="50%" class="text-right pr-2">@lang('sales_bills.Customer data')</td>
                                <td width="50%" class="text-right pr-2">@lang('sales_bills.invoice from')</td>
                            </tr>
                        </table>
                    </div>
                    <div class="left pr-2 pl-2"
                        style="right: -5px;position:relative;border-bottom: 1px solid #25252525;">
                        <table style="width: 100%;">
                            <tr class="d-flex bordernone">
                                <td width="60%" class="text-left centerTd">
                                    {{ $sale_bill->outerClient->shop_name ?? $sale_bill->outerClient->client_name }}
                                </td>
                                <td width="40%" class="text-right">@lang('main.name')</td>
                            </tr>
                            <tr class="d-flex pt-1 bordernone">
                                <td width="60%" class="text-left">{{ $sale_bill->outerClient->tax_number ?? '-' }}
                                </td>
                                <td width="40%" class="text-right">@lang('sales_bills.Tax Number')</td>
                            </tr>
                            <tr class="d-flex pt-1 bordernone">
                                <td width="60%" class="text-left">
                                    {{ $sale_bill->outerClient->phones[0]->client_phone ?? '-' }}</td>
                                <td width="40%" class="text-right">@lang('sales_bills.phone')</td>
                            </tr>
                            <tr class="d-flex pt-1 bordernone">
                                <td width="60%" class="text-left">
                                    {{ $sale_bill->outerClient->addresses[0]->client_address ?? '-' }}</td>
                                <td width="40%" class="text-right">@lang('sales_bills.address')</td>
                            </tr>
                        </table>
                    </div>

                    <div class="right pr-2 pl-2"
                        style="border-left: 1px solid #2d2d2d2d !important;border-bottom: 1px solid #25252525;left: -5px;">
                        <table style="width: 100%;">
                            <tr class="d-flex bordernone">
                                <td width="60%" class="text-left">{{ $company->company_name }}</td>
                                <td width="40%" class="text-right">@lang('sales_bills.Company Name')</td>
                            </tr>
                            <tr class="d-flex pt-1 bordernone">
                                <td width="60%" class="text-left">{{ $company->tax_number ?? '-' }}</td>
                                <td width="40%" class="text-right">@lang('sales_bills.Tax Number') </td>
                            </tr>
                            <tr class="d-flex pt-1 bordernone">
                                <td width="60%" class="text-left">{{ $company->phone_number ?? '-' }}</td>
                                <td width="40%" class="text-right">@lang('sales_bills.phone')</td>
                            </tr>
                            <tr class="d-flex pt-1 bordernone">
                                <td width="60%" class="text-left">
                                    {{ $company->company_address ?? '-' }}
                                </td>
                                <td width="40%" class="text-right">@lang('sales_bills.address')</td>
                            </tr>
                        </table>
                    </div>
                </div>
            @endif
            <!-------------------------------------->
            @if (app()->getLocale() == 'en')
                <div class="products-details mt-2" style=" padding: 0px 16px;">
                    <table class="invoice-information"
                        style="width: 100%;background:#222751; border-radius: 8px !important; overflow: hidden;box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                        <thead>
                            <tr
                                style="font-size:18px !important; background:{{ $currentColor }}; color: white; height: 44px !important; text-align: center;">
                                <th>@lang('sales_bills.Product number')</th>
                                <th>@lang('main.name')</th>
                                <th>@lang('sales_bills.unit price')</th>
                                <th>@lang('products.pmodel1')</th>
                                <th>@lang('sales_bills.Quantity')</th>
                                <th>@lang('sales_bills.The amount does not include tax')</th>
                                <th>@lang('sales_bills.Tax')</th>
                                <th>@lang('sales_bills.Discount')</th>
                                <th>@lang('sales_bills.total')</th>

                            </tr>

                        </thead>
                        <tbody style="font-size: 14px !important;">
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
                                        $i = $loop->iteration; // Use Blade's $loop variable for iteration count

                                        // Product Tax Calculation
                                        if ($company->tax_value_added && $company->tax_value_added != 0) {
                                            $ProdTax = $sale_bill->value_added_tax
                                                ? round(
                                                    $element->quantity_price - ($element->quantity_price * 20) / 23,
                                                    2,
                                                )
                                                : round(($element->quantity_price * 15) / 100, 2);
                                        } else {
                                            $ProdTax = 0;
                                        }

                                        // Product Total Calculation
                                        if ($company->tax_value_added && $company->tax_value_added != 0) {
                                            $ProdTotal = $sale_bill->value_added_tax
                                                ? $element->quantity_price
                                                : round(
                                                    $element->quantity_price + ($element->quantity_price * 15) / 100,
                                                    2,
                                                );
                                        } else {
                                            $ProdTotal = $element->quantity_price;
                                        }

                                        $priceBeforeTax = $sale_bill->value_added_tax
                                            ? round(($element->quantity_price * 20) / 23, 2)
                                            : $element->quantity_price;
                                    @endphp

                                    <tr
                                        style="font-size:18px !important; height: 34px !important; text-align: center; background: #f8f9fb">
                                        <td>{{ $i }}</td>
                                        <td>{{ $element->product->product_name }}</td>
                                        <td>{{ round($element->product_price, 2) }}</td>
                                        <td>{{ $element->product->product_model }}</td>
                                        <td class="text-center">
                                            <span>{{ $element->quantity }}</span>
                                            <span>{{ $element->unit->unit_name }}</span>
                                        </td>
                                        <td> {{ $element->tax_type == 2 ? round($element->quantity_price - $element->tax_value, 2) : round($element->quantity_price, 2) }}
                                        </td>
                                        <td>{{ $element->tax_value }}</td>
                                        <td>{{ $element->discount_value }}{{ $element->discount_type == 'percent' ? ' %' : '' }}
                                        </td>
                                        <td>
                                            {{ $element->tax_type == 0 ? round($element->quantity_price + $element->tax_value - $elementDiscount, 2) : round($element->quantity_price - $elementDiscount, 2) }}
                                        </td>

                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>

                    </table>
                </div>
            @else
                <div class="products-details mt-2" style=" padding: 0px 16px;">
                    <table class="invoice-information"
                        style="width: 100%;width: 100%;background:#222751; border-radius: 8px !important; overflow: hidden;box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                        <thead>
                            <tr
                                style="font-size:18px !important; background:{{ $currentColor }}; color: white; height: 44px !important; text-align: center;">
                                <th>@lang('sales_bills.total')</th>
                                <th>@lang('sales_bills.Tax')</th>
                                <th>@lang('sales_bills.Discount')</th>
                                <th>@lang('sales_bills.The amount does not include tax')</th>
                                <th>@lang('sales_bills.Quantity')</th>
                                <th>@lang('products.pmodel1')</th>
                                <th>@lang('sales_bills.unit price')</th>
                                <th>@lang('main.name')</th>
                                <th>@lang('sales_bills.Product number')</th>
                            </tr>

                        </thead>
                        <tbody style="font-size: 14px !important;">
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
                                        // Use Blade's $loop variable for iteration count
                                        $i = $loop->iteration;

                                        // Product Tax Calculation
                                        $ProdTax = 0;
                                        if ($company->tax_value_added && $company->tax_value_added != 0) {
                                            $ProdTax = $sale_bill->value_added_tax
                                                ? round(
                                                    $element->quantity_price - ($element->quantity_price * 20) / 23,
                                                    2,
                                                )
                                                : round(($element->quantity_price * 15) / 100, 2);
                                        }

                                        // Product Total Calculation
                                        $ProdTotal = $element->quantity_price;
                                        if ($company->tax_value_added && $company->tax_value_added != 0) {
                                            $ProdTotal = $sale_bill->value_added_tax
                                                ? $element->quantity_price
                                                : round(
                                                    $element->quantity_price + ($element->quantity_price * 15) / 100,
                                                    2,
                                                );
                                        }

                                        $priceBeforeTax = $sale_bill->value_added_tax
                                            ? round(($element->quantity_price * 20) / 23, 2)
                                            : $element->quantity_price;
                                    @endphp

                                    <tr
                                        style="font-size:18px !important; height: 34px !important; text-align: center; background: #f8f9fb">
                                        <td>
                                            {{ $element->tax_type == 0 ? round($element->quantity_price + $element->tax_value - $elementDiscount, 2) : round($element->quantity_price - $elementDiscount, 2) }}
                                        </td>
                                        </td>
                                        <td>{{ $element->tax_value }}</td>
                                        <td>{{ $element->discount_value }}{{ $element->discount_type == 'percent' ? ' %' : '' }}
                                        </td>
                                        <td>
                                            {{ $element->tax_type == 2 ? round($element->quantity_price - $element->tax_value, 2) : round($element->quantity_price, 2) }}

                                        </td>
                                        <td class="text-center">
                                            <span>{{ $element->unit->unit_name }}</span>
                                            <span>{{ $element->quantity }}</span>
                                        </td>
                                        <td>{{ $element->product->product_model }}</td>
                                        <td>{{ round($element->product_price, 2) }}</td>
                                        <td>{{ $element->product->product_name }}</td>
                                        <td>{{ $i }}</td>
                                    </tr>
                                @endforeach
                            @endif
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
                <div class="row px-4 pt-2 d-flex justify-content-between">

                    <div class="products-details p-0 col-6"
                        style="border: 1px solid #2d2d2d1c; border-radius: 7px; overflow: hidden; box-shadow: rgb(149 157 165 / 20%) 0px 8px 24px;">
                        <table
                            style="width: 100%;width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid;box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                            @if (!empty($discount) && $discount > 0)
                                <tr
                                    style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size:16px !important; height: 37px !important; text-align: center;background: #f8f9fb">

                                    <td style="text-align: left;padding-right: 14px;">@lang('sales_bills.Discount')</td>
                                    <td dir="rtl">
                                        <!--{{-- @dd( $discountValue) --}}-->
                                        <!--{{ $discountNote ? $discountNote . ' || ' : '' }}-->
                                        <!--{{-- @if ($discount->action_type == 'poundAfterTax') --}}-->
                                        <!--@if ($realtotal > 0)
-->
                                        <!--    ({{ round($discount) }})-->

                                        <!--    <img src="{{ asset('images/Sr_coin.svg') }}" width="15px">-->
                                        <!--
@endif-->
                                        <!--{{-- @else --}}-->
                                        <!--{{-- @if ($realtotal > 0)-->
                                        <!--        ({{ round(($discountValue / $realtotal) * 100, 1) }}%)-->
                                        <!--        {{ $discountValue }}-->
                                        <!--    @endif-->
                                        <!--    <img src="{{ asset('images/Sr_coin.svg') }}" width="15px"> --}}-->
                                        <!--{{-- @endif --}}-->
                                        ({{ $sale_bill->total_discount }})
                                        <img src="{{ asset('images/Sr_coin.svg') }}" width="15px">



                                    </td>
                                </tr>
                            @endif
                            <tr
                                style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size:16px !important; height: 37px !important; text-align: center;background: #f8f9fb">
                                <td style="text-align: left;padding-right: 14px;">@lang('sales_bills.Total, excluding tax')</td>
                                <td dir="rtl">
                                    {{-- @if ($discount->action_type == 'poundAfterTax') --}}
                                    {{-- @if ($realtotal > 0) --}}
                                    ({{ number_format($sale_bill->final_total - $sale_bill->total_tax, 2, '.', '') }})

                                    <img src="{{ asset('images/Sr_coin.svg') }}" width="15px">
                                    {{-- @endif --}}
                                    {{-- @else
                                        @if ($realtotal > 0)
                                            {{ $sale_bill->final_total - $sale_bill->total_tax }} <img src="{{ asset('images/Sr_coin.svg') }}" width="15px">
                                        @endif

                                    @endif --}}
                                </td>
                            </tr>

                            @if (!empty($ifThereIsDiscountNote))
                                <tr
                                    style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size:16px !important; height: 37px !important; text-align: center;background: #f8f9fb">
                                    <td style="text-align: left;padding-right: 14px;">:@lang('sales_bills.Discount note') </td>
                                    <td style="width: 50% !important;">{{ $ifThereIsDiscountNote }}</td>

                                </tr>
                            @endif

                            <tr
                                style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size:16px !important; height: 37px !important; text-align: center;background: #f8f9fb">

                                <td style="text-align: left;padding-right: 14px;">
                                    @lang('sales_bills.Total tax')
                                    ({{ $company->tax_value_added ?? '0' }}%)
                                </td>
                                @if ($company->tax_value_added && $company->tax_value_added != 0)
                                    <td dir="rtl">{{ $sale_bill->total_tax }} <img src="{{ asset('images/Sr_coin.svg') }}" width="15px"> </td>
                                @else
                                    <td dir="rtl">0 <img src="{{ asset('images/Sr_coin.svg') }}" width="15px"> </td>
                                @endif
                            </tr>



                            <tr
                                style="background:#222751;border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size:16px !important; height: 37px !important; text-align: center;background:{{ $currentColor }};color:white;">
                                <td style="text-align: left;padding-right: 14px;background:#222751;">
                                    @lang('sales_bills.total')
                                </td>
                                @if ($company->tax_value_added && $company->tax_value_added != 0)
                                    {{-- @if ($discount->action_type == 'poundAfterTax') --}}
                                    <td dir="rtl">
                                        {{-- Apply discount after tax --}}
                                        {{ $sale_bill->final_total }}
                                        <img src="{{ asset('images/Sr_coin.svg') }}" width="15px">
                                    </td>
                                    {{-- @else
                                        <td dir="rtl">
                                            {{ $sumWithTax }}
                                            <img src="{{ asset('images/Sr_coin.svg') }}" width="15px">
                                        </td>
                                    @endif --}}
                                @else
                                    <td dir="rtl">
                                        {{ round($sumWithOutTax, 2) }}
                                        <img src="{{ asset('images/Sr_coin.svg') }}" width="15px">
                                    </td>
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
                            <div class=" mx-auto text-right p-2" dir="rtl">
                                {{ $company->invoice_note }}
                                <br />
                            </div>
                        </div>
                    @endif
                    @if (!empty($company->basic_settings->sale_bill_condition))
                        <div class="products-details py-2 px-0 col-12">
                            <table
                                style="width: 100%;width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid;box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                                <tbody>
                                    <tr
                                        style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size:18px !important; height: 44px !important; text-align: center;background:{{ $currentColor }};color:white;">
                                        <td style="text-align: left;padding-left: 14px;font-size: 14px;"
                                            colspan="2">
                                            @lang('sales_bills.Terms and Conditions')
                                        </td>
                                    </tr>
                                    <tr
                                        style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size:18px !important; height: 49px !important; text-align: center;background: #f8f9fb">
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
                <div class="row px-4 pt-2 d-flex justify-content-between">

                    <div class="products-details p-0 col-6"
                        style="border: 1px solid #2d2d2d1c; border-radius: 7px; overflow: hidden; box-shadow: rgb(149 157 165 / 20%) 0px 8px 24px;">
                        <table
                            style="width: 100%;width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid;box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                            @if (!empty($discount) && $discount > 0)
                                <tr
                                    style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size:18px !important; height: 37px !important; text-align: center;background: #f8f9fb">
                                    <td dir="rtl">
                                        <!--{{ $discountNote ? $discountNote . ' || ' : '' }}-->
                                        <!--{{-- @if ($discount->action_type == 'poundAfterTax') --}}-->
                                        <!--@if ($realtotal > 0)
-->
                                        <!--    ({{ round($discount) }})-->
                                        <!--    <img src="{{ asset('images/Sr_coin.svg') }}" width="15px">-->
                                        <!--
@endif-->
                                        <!--{{-- @else-->
                                        <!--    @if ($realtotal > 0)-->
                                        <!--        ({{ round(($discountValue / $realtotal) * 100, 1) }}%)-->
                                        <!--        {{ $discountValue }}-->
                                        <!--    @endif-->
                                        <!--    <img src="{{ asset('images/Sr_coin.svg') }}" width="15px">-->
                                        <!--@endif --}}-->
                                        ({{ $sale_bill->total_discount }})
                                        <img src="{{ asset('images/Sr_coin.svg') }}" width="15px">


                                    </td>
                                    <td style="text-align: right;padding-right: 14px;">@lang('sales_bills.Discount')</td>
                                </tr>
                            @endif

                            <tr
                                style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size:18px !important; height: 37px !important; text-align: center;background: #f8f9fb">
                                <td dir="rtl">
                                    {{-- @if ($discount->action_type == 'poundAfterTax') --}}
                                    {{-- @if ($realtotal > 0) --}}
                                    ({{ number_format($sale_bill->final_total - $sale_bill->total_tax, 2, '.', '') }})

                                    <img src="{{ asset('images/Sr_coin.svg') }}" width="15px">
                                    {{-- @endif --}}
                                    {{-- @else
                                        @if ($realtotal > 0)
                                            {{ $sale_bill->final_total - $sale_bill->total_tax }} <img src="{{ asset('images/Sr_coin.svg') }}" width="15px">
                                        @endif

                                    @endif --}}
                                </td>
                                <td style="text-align: right;padding-right: 14px;"style="background:#222751">
                                    @lang('sales_bills.Total, excluding tax')</td>
                            </tr>

                            @if (!empty($ifThereIsDiscountNote))
                                <tr
                                    style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size:18px !important; height: 37px !important; text-align: center;background: #f8f9fb">
                                    <td style="width: 50% !important;">{{ $ifThereIsDiscountNote }}</td>
                                    <td style="text-align: right;padding-right: 14px;">:@lang('sales_bills.Discount note') </td>
                                </tr>
                            @endif

                            <tr
                                style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size:18px !important; height: 37px !important; text-align: center;background: #f8f9fb">
                                @if ($company->tax_value_added && $company->tax_value_added != 0)
                                    <td dir="rtl">{{ $sale_bill->total_tax }} <img src="{{ asset('images/Sr_coin.svg') }}" width="15px"> </td>
                                @else
                                    <td dir="rtl">0 <img src="{{ asset('images/Sr_coin.svg') }}" width="15px"> </td>
                                @endif
                                <td style="text-align: right;padding-right: 14px;">
                                    @lang('sales_bills.Total tax')
                                    ({{ $company->tax_value_added ?? '0' }}%)
                                </td>
                            </tr>
                            <tr
                                style="background:#222751;border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size:18px !important; height: 37px !important; text-align: center;background:{{ $currentColor }};color:white;">
                                @if ($company->tax_value_added && $company->tax_value_added != 0)
                                    {{-- @if ($discount->action_type == 'poundAfterTax') --}}
                                    <td dir="rtl">
                                        {{-- Apply discount after tax --}}
                                        {{ $sale_bill->final_total }}
                                        <img src="{{ asset('images/Sr_coin.svg') }}" width="15px">
                                    </td>
                                    {{-- @else
                                        <td dir="rtl">
                                            {{ $sumWithTax }}
                                            <img src="{{ asset('images/Sr_coin.svg') }}" width="15px">
                                        </td>
                                    @endif --}}
                                @else
                                    <td dir="rtl">
                                        {{ round($sumWithOutTax, 2) }}
                                        <img src="{{ asset('images/Sr_coin.svg') }}" width="15px">
                                    </td>
                                @endif
                                <td style="text-align: right;padding-right: 14px;">@lang('sales_bills.total')</td>
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
                        <div class="products-details py-2 px-0 col-12">
                            <table
                                style="width: 100%;width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid;box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                                <tbody>
                                    <tr
                                        style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size:18px !important; height: 44px !important; text-align: center;background:{{ $currentColor }};color:white;">
                                        <td style="text-align: right;padding-right: 14px;font-size: 14px;"
                                            colspan="2">
                                            @lang('sales_bills.Terms and Conditions')
                                        </td>
                                    </tr>
                                    <tr
                                        style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size:18px !important; height: 49px !important; text-align: center;background: #f8f9fb">
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
<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script>
    function sendToWhatsApp() {
        const clientPhone = '{{ $sale_bill->outerClient->phones[0]->client_phone ?? '-' }}';
        const invoiceUrl = '{{ route('client.sale_bills.sent', [$sale_bill->token, 5, 2, 0]) }}';
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
