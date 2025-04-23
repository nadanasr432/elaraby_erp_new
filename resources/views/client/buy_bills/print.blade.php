<?php
$company = \App\Models\Company::FindOrFail($buy_bill->company_id);
$company_id = $company->id;
$extra_settings = \App\Models\ExtraSettings::where('company_id', $company->id)->first();
$currency = $extra_settings->currency;
$tax_value_added = $company->tax_value_added;
?>
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'en' ? 'ltr' : 'rtl' }}">

<head>
    <title>
        <?php echo $buy_bill->supplier->supplier_name . ' - فاتورة رقم ' . $buy_bill->company_counter; ?>
    </title>

    <meta charset="utf-8" />
    <link href="{{ asset('/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <!-- Bootstrap CSS -->
    <!-- Bootstrap JS (with Popper.js) -->
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

        .headerImg img,
        .footerImg img {
            height: 150px;
            width: 100%;
            object-fit: scale-down;
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
        $currentColor = \App\Services\SettingsService::getSettingValue($companyId, 'color', 'print1', '#222751');
        // If the form was submitted, set the color in the settings
        if (request()->isMethod('post')) {
            if (Auth::check()) {
                $color = request('page_color', '#222751'); // Default to white if no color is selected
                // Call the setSetting function directly in Blade
                \App\Services\SettingsService::setSetting($companyId, 'color', $color, 'print1');
                $currentColor = \App\Services\SettingsService::getSettingValue(
                    $companyId,
                    'color',
                    'print1',
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
            <button class="btn  btn-success" onclick="window.print()">@lang('sales_bills.Print the invoice')</button>
            <a class="btn  btn-danger" href="{{ route('client.buy_bills.create') }}">@lang('sales_bills.back') </a>
            <button class="show_hide_header btn  btn-warning no-print" dir="ltr">
                <i class="fa fa-eye-slash"></i>
                @lang('sales_bills.Show or hide the header')
            </button>
            <button class="show_hide_footer btn  btn-primary no-print" dir="ltr">
                <i class="fa fa-eye-slash"></i>
                @lang('sales_bills.Show or hide the footer')
            </button>
            {{-- <button class="btn  btn-success" dir="ltr" onclick="sendToWhatsApp()">
                <i class="fa fa-whatsapp"></i>
                @lang('sales_bills.Send to whatsapp')
            </button> --}}
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
                            <form method="POST" action="{{ route('buy-bills.update-color') }}">
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
            {{-- @php
                use Salla\ZATCA\GenerateQrCode;
                use Salla\ZATCA\Tags\InvoiceDate;
                use Salla\ZATCA\Tags\InvoiceTaxAmount;
                use Salla\ZATCA\Tags\InvoiceTotalAmount;
                use Salla\ZATCA\Tags\Seller;
                use Salla\ZATCA\Tags\TaxNumber;

                // Ensure date and time are formatted correctly
                $invoiceDate = date('Y-m-d\TH:i:s\Z', strtotime($buy_bill->date . ' ' . $buy_bill->time));

                $displayQRCodeAsBase64 = GenerateQrCode::fromArray([
                    new Seller($company->company_name), // seller name
                    new TaxNumber($company->tax_number), // seller tax number
                    new InvoiceDate($invoiceDate), // invoice date in ISO 8601 format
                    new InvoiceTotalAmount(number_format($buy_bill->final_total, 2, '.', '')), // invoice total amount
                    new InvoiceTaxAmount(number_format($buy_bill->total_tax, 2, '.', '')), // invoice tax amount
                    // Additional tags can be added here if needed
                ])->render();
            @endphp --}}

            <div class="header-container d-flex align-items-center">
                <div class="logo">
                    <img class="logo" style="object-fit: scale-down;" width="204"
                        src="{{ asset($company->company_logo) }}">
                </div>
                <div class="txtheader mx-auto text-center">

                    {{ __('sales_bills.purchases_tax_invoice') }}

                </div>
                <div class="qrcode" style="max-width: 100%">
                    {!! SimpleSoftwareIO\QrCode\Facades\QrCode::size(165)->generate(Request::url()) !!}
                </div>
            </div>

            <hr class="mt-1 mb-2">
            <div class="products-details" style="padding: 0px 18px;">
                <table
                    style="width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid; box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px; direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};">
                    <thead style="font-size:18px !important;">
                        <tr
                            style="font-size:18px !important; background: {{ $currentColor }}; color: white; height: 44px !important; text-align: center;">
                            <th>@lang('sales_bills.Release Date')</th>
                            <th>@lang('sales_bills.invoice number')</th>
                            <th>@lang('sales_bills.commercial register')</th>
                        </tr>
                    </thead>
                    @php
                        $billNum = $buy_bill->company_counter ? $buy_bill->company_counter : $buy_bill->company_counter;
                    @endphp
                    <tbody style="font-size:18px !important;">
                        <tr class="even"
                            style="font-size:18px !important; height: 40px !important; text-align: center;">
                            <td>{{ $buy_bill->date }}</td>
                            <td>{{ $billNum }}</td>
                            <td>{{ $company->civil_registration_number }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>



            <!------------FIRST ROW----------------->
            <div class="invoice-information row justify-content-around mt-3"
                style="padding: 0px 24px; direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};">
                <div class="col-12 pr-2 pl-2">
                    <table style="width: 100%;">
                        <tr class="d-flex pt-1"
                            style="background: {{ $currentColor }}; color: white; font-size: 16px; border-radius: 7px 7px 0 0; padding: 8px !important; direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};">
                            <td width="50%" class="text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                                {{ __('sales_bills.invoice from') }}</td>
                            <td width="50%" class="text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                                {{ __('sales_bills.Supplier data') }}</td>
                        </tr>

                    </table>
                </div>
                <div class="right pr-2 pl-2"
                    style="border-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}: 1px solid #2d2d2d2d !important; border-bottom: 1px solid #25252525;">
                    <table style="width: 100%;">
                        <tr class="d-flex bordernone">
                            <td width="40%" class="text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                                {{ __('main.name') }}</td>
                            <td width="60%" class="text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}">
                                {{ $company->company_name }}</td>
                        </tr>
                        <tr class="d-flex pt-1 bordernone">
                            <td width="40%" class="text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                                {{ __('sales_bills.Tax Number') }}</td>
                            <td width="60%" class="text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}">
                                {{ $company->tax_number ?? '-' }}</td>
                        </tr>
                        <tr class="d-flex pt-1 bordernone">
                            <td width="40%" class="text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                                {{ __('sales_bills.phone') }}</td>
                            <td width="60%" class="text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}">
                                {{ $company->phone_number ?? '-' }}</td>
                        </tr>
                        <tr class="d-flex pt-1 bordernone">
                            <td width="40%" class="text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                                {{ __('sales_bills.address') }}</td>
                            <td width="60%" class="text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}">
                                {{ $company->company_address ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="left pr-2 pl-2" style="border-bottom: 1px solid #25252525;">
                    <table style="width: 100%;">
                        <tr class="d-flex bordernone">
                            <td width="40%" class="text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                                {{ __('suppliers.supplier-name') }}</td>
                            <td width="60%" class="text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}">
                                {{ $buy_bill->supplier->supplier_name }}</td>
                        </tr>
                        <tr class="d-flex pt-1 bordernone">
                            <td width="40%" class="text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                                {{ __('sales_bills.transaction_category') }}
                            </td>
                            <td width="60%" class="text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}">
                                {{ $buy_bill->supplier->supplier_category }}</td>
                        </tr>
                        <tr class="d-flex pt-1 bordernone">
                            <td width="40%" class="text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                                {{ __('sales_bills.phone') }}</td>
                            <td width="60%" class="text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}">
                                {{ $buy_bill->supplier->supplier_phone }}</td>
                        </tr>
                        <tr class="d-flex pt-1 bordernone">
                            <td width="40%" class="text-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}">
                                {{ __('sales_bills.tax_number') }} </td>
                            <td width="60%" class="text-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}">
                                {{ $buy_bill->supplier->tax_number }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-------------------------------------->

            <div class="products-details mt-2" style=" padding: 0px 16px;">
                <table class="invoice-information"
                    style="width: 100%;background: {{ $currentColor }} !important; border-radius: 8px !important; overflow: hidden;box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                    <thead>
                        <tr
                            style="font-size:18px !important; background: {{ $currentColor }}; color: white; height: 44px !important; text-align: center;">
                            <th>@lang('sales_bills.Product number')</th>
                            <th>{{ __('sales_bills.code') }}</th>
                            <th>{{ __('sales_bills.model') }}</th>
                            <th>{{ __('sales_bills.product_details') }}</th>
                            <th>{{ __('sales_bills.quantity') }}</th>
                            <th>{{ __('sales_bills.unit_price') }}</th>
                            <th>{{ __('sales_bills.total_price') }}</th>

                        </tr>

                    </thead>
                    <tbody style="font-size: 14px !important;">
                        @php
                            $i = 0;

                            $sum = [];
                            $elements = $buy_bill->elements;
                            $extras = $buy_bill->extras;
                            $billNum = $buy_bill->company_counter
                                ? $buy_bill->company_counter
                                : $buy_bill->company_counter;

                        @endphp
                        @foreach ($elements as $element)
                            <tr
                                style="font-size:18px !important; height: 34px !important; text-align: center; background: #f8f9fb">
                                <td>{{ ++$i }}</td>
                                <td>{{ $element->product->code_universal }}</td>
                                <td>{{ $element->product->product_model }}
                                </td>
                                <td>
                                    {{ $element->product->product_name }}
                                </td>
                                <td>
                                    {{ $element->quantity }}
                                </td>
                                <td>
                                    {{ $element->product_price }}
                                </td>
                                <td>
                                    {{ $element->quantity_price }}

                                </td>
                            </tr>
                        @endforeach



                    </tbody>
                </table>
            </div>

            @php
                $sum = [];
                foreach ($elements as $element) {
                    array_push($sum, $element->quantity_price);
                }
                $total = array_sum($sum);
                $percentage = ($tax_value_added / 100) * $total;
                $after_total = $total + $percentage;
                if ($buy_bill->value_added_tax) {
                    // inclusive
                    $totalBeforeTax = round((100 / 115) * $total, 2);
                } else {
                    // exclusive
                    $totalBeforeTax = $total - ($company->value_added_tax / 100) * $total;
                }
                $tax_value = ($tax_value_added / 100) * $total;
                $tax_value_added = $company->tax_value_added;
                $sum = [];
                foreach ($elements as $element) {
                    array_push($sum, $element->quantity_price);
                }
                $total = array_sum($sum);
                $previous_extra = \App\Models\BuyBillExtra::where('buy_bill_id', $buy_bill->id)
                    ->where('action', 'extra')
                    ->first();
                if (!empty($previous_extra)) {
                    $previous_extra_type = $previous_extra->action_type;
                    $previous_extra_value = $previous_extra->value;
                    if ($previous_extra_type == 'percent') {
                        $previous_extra_value = ($previous_extra_value / 100) * $total;
                    }
                    $after_discount = $total + $previous_extra_value;
                }
                $previous_discount = \App\Models\BuyBillExtra::where('buy_bill_id', $buy_bill->id)
                    ->where('action', 'discount')
                    ->first();
                if (!empty($previous_discount)) {
                    $previous_discount_type = $previous_discount->action_type;
                    $previous_discount_value = $previous_discount->value;
                    if ($previous_discount_type == 'percent') {
                        $previous_discount_value = ($previous_discount_value / 100) * $total;
                    }
                    $after_discount = $total - $previous_discount_value;
                }
                if (!empty($previous_extra) && !empty($previous_discount)) {
                    $after_discount = $total - $previous_discount_value + $previous_extra_value;
                } else {
                    $after_discount = $total;
                }

                #---- chk if invoice is inclusive or exclusive to print tax_value.
                if ($buy_bill->value_added_tax) {
                    // inclusive
                    $tax_value = $after_discount - round((100 / 115) * $after_discount, 2);
                }
                // exclusive
                else {
                    $tax_value = ($tax_value_added / 100) * $total;
                }
                #----------------------.

                if (isset($after_discount) && $after_discount != 0) {
                    # calc final_total with inserted tax if inclusive or exclusive.
                    if ($buy_bill->value_added_tax == 0) {
                        #exclusive
                        $percentage = ($tax_value_added / 100) * $after_discount;
                        $after_total_all = $after_discount + $percentage;
                    }
                    # so its inclusive
                    else {
                        $after_total_all = $after_discount;
                    }
                } else {
                    # calc final_total with inserted tax if inclusive or exclusive.
                    if ($buy_bill->value_added_tax == 0) {
                        #exclusive
                        $percentage = ($tax_value_added / 100) * $total;
                        $after_total_all = $total + $percentage;
                    }
                    # so its inclusive
                    else {
                        $after_total_all = $total;
                    }
                }
            @endphp

            <div class="row px-4 pt-2 d-flex justify-content-between">

                <div class="products-details p-0 col-6"
                    style="border: 1px solid #2d2d2d1c; border-radius: 7px; overflow: hidden; box-shadow: rgb(149 157 165 / 20%) 0px 8px 24px;">
                    <table
                        style="width: 100%;width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid;box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">

                        <tr
                            style="border-bottom: 1px solid #2d2d2d30; font-weight: bold; font-size: 16px !important; height: 37px !important; text-align: center; background: #f8f9fb; direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};">
                            <td
                                style="text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }}; padding-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: 14px;">
                                {{ __('sales_bills.total_before_discount_tax') }}
                            </td>
                            <td>
                                {{ $totalBeforeTax }} <img src="{{ asset('images/Sr_coin.svg') }}" width="15px">
                            </td>
                        </tr>

                        @foreach ($extras as $key)
                            @if ($key->value != 0)
                                <tr
                                    style="border-bottom: 1px solid #2d2d2d30; font-weight: bold; font-size: 16px !important; height: 37px !important; text-align: center; background: #f8f9fb; direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};">
                                    <td
                                        style="text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }}; padding-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: 14px;">
                                        {{ $key->action == 'discount' ? __('sales_bills.discount') : __('sales_bills.shipping_fees') }}
                                    </td>
                                    <td>
                                        {{ $key->value }} {{ $key->action_type == 'pound' ? $currency : '%' }}
                                    </td>
                                </tr>
                            @endif
                        @endforeach


                        {{-- <tr
                            style="border-bottom: 1px solid #2d2d2d30; font-weight: bold; font-size: 16px !important; height: 37px !important; text-align: center; background: #f8f9fb; direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};">
                            <td
                                style="text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }}; padding-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: 14px;">
                                {{ __('sales_bills.vat_tax') }}
                            </td>
                            <td>( {{ $tax_value_added }}% )</td>
                        </tr> --}}

                        <tr
                            style="border-bottom: 1px solid #2d2d2d30; font-weight: bold; font-size: 16px !important; height: 37px !important; text-align: center; background: #f8f9fb; direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};">
                            <td
                                style="text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }}; padding-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: 14px;">
                                {{ __('sales_bills.vat_value') }} ( {{ $tax_value_added }}% )
                            </td>
                            <td> {{ $tax_value }} <img src="{{ asset('images/Sr_coin.svg') }}" width="15px"></td>
                        </tr>

                        <tr
                            style="border-bottom: 1px solid #2d2d2d30; font-weight: bold; font-size: 16px !important; height: 37px !important; text-align: center; background: #f8f9fb; direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};">
                            <td
                                style="text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }}; padding-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: 14px;">
                                {{ __('sales_bills.total_after_discount_and_tax') }}
                            </td>
                            <td> {{ $after_total_all }} <img src="{{ asset('images/Sr_coin.svg') }}" width="15px"></td>
                        </tr>

                        @php
                            $cash = \App\Models\BuyCash::where('bill_id', $buy_bill->company_counter)
                                ->where('company_id', $company_id)
                                ->where('supplier_id', $buy_bill->supplier_id)
                                ->first();
                            $bank_cash = \App\Models\BankBuyCash::where('bill_id', $buy_bill->company_counter)
                                ->where('company_id', $company_id)
                                ->where('supplier_id', $buy_bill->supplier_id)
                                ->first();

                            $paid_amount = !empty($cash)
                                ? $cash->amount
                                : (!empty($bank_cash)
                                    ? $bank_cash->amount
                                    : 0);
                            $rest = $after_total_all - $paid_amount;
                        @endphp

                        <tr
                            style="border-bottom: 1px solid #2d2d2d30; font-weight: bold; font-size: 16px !important; height: 37px !important; text-align: center; background: #f8f9fb; direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};">
                            <td
                                style="text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }}; padding-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: 14px;">
                                {{ __('sales_bills.paid_amount') }}
                            </td>
                            <td>{{ $paid_amount }} <img src="{{ asset('images/Sr_coin.svg') }}" width="15px"></td>
                        </tr>

                        <tr
                            style="border-bottom: 1px solid #2d2d2d30; font-weight: bold; font-size: 16px !important; height: 37px !important; text-align: center; background: #f8f9fb; direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};">
                            <td
                                style="text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }}; padding-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}: 14px;">
                                {{ __('sales_bills.remaining_amount') }}
                            </td>
                            <td>{{ $rest }} <img src="{{ asset('images/Sr_coin.svg') }}" width="15px"></td>
                        </tr>

                    </table>
                </div>

            </div>
            <br>
            @if (!empty($company->basic_settings->footer))
                <div class="footerImg">
                    <img class="img-footer" src="{{ asset($company->basic_settings->footer) }}" />
                </div>
                <br>
            @endif
        </div>
</body>

</html>
<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>

<script type="text/javascript">
    $('.show_hide_header').on('click', function() {
        $('.headerImg').slideToggle();
    });
    $('.show_hide_footer').on('click', function() {
        $('.footerImg').slideToggle();
    });
</script>
