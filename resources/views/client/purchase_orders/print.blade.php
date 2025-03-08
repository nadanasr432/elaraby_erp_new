<!DOCTYPE html>
<html>

<head>
    <title>عرض سعر</title>
    <meta charset="utf-8" />
    <link href="{{ asset('/assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <style type="text/css" media="screen">
        @font-face {
            font-family: 'Cairo';
            src: url(http://arabygithub.test/fonts/Cairo.ttf);
        }

        .invoice-container {
            width: 80%;
            margin: auto;
        }


        .right,
        .left {
            width: 49%;
            background: #f8f9fb;
            font-size: 16px;
            color: #222751 !important;
            overflow: hidden;
            font-weight: 400;
            position: relative;
        }

        .bordernone {
            border: none !important;
        }

        tr {
            border-bottom: 1px solid #2d2d2d20 !important;
            padding-bottom: 5px !important;
            padding-top: 5px !important;
        }

        .txtheader {
            font-weight: 400;
            font-size: 28px;
        }

        .border2 {
            border: 1px solid #2d2d2d03 !important;
        }

        .header-container {
            height: 135px;
            overflow: hidden;
        }

        .even {
            background: #f8f9fb;
        }

        tr th {
            font-size: 16px !important;
            font-weight: 500 !important;
        }

        .borderLeftH {
            border-left: 1px solid rgba(229, 229, 229, 0.94) !important;
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

        .borderLeftH {
            border-left: 1px solid rgba(229, 229, 229, 0.94) !important;
        }

        .even {
            background: #f8f9fb;
        }

        .right,
        .left {
            width: 49%;
            background: #f8f9fb;
            font-size: 16px;
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
            <button class="btn btn-sm btn-success" onclick="window.print()">@lang('sales_bills.Print purchase price')</button>
            <a class="btn btn-sm btn-danger" href="{{ route('client.purchase_orders.create') }}">@lang('sales_bills.back')</a>
            <button class="show_hide_header btn btn-sm btn-warning no-print" dir="ltr">
                <i class="fa fa-eye-slash"></i>
                @lang('sales_bills.Show or hide the header')
            </button>
            <button class="show_hide_footer btn btn-sm btn-primary no-print" dir="ltr">
                <i class="fa fa-eye-slash"></i>
                @lang('sales_bills.Show or hide the footer')
            </button>

            <div class="col-lg-12 no-print" style="padding-top: 25px; height: 40px !important;">

                <a role="button" class="btn btn-md btn-primary ml-2 pull-right"
                    href="{{ route('convert.to.buybill', $purchase_order_k->id) }}">
                    <i class="fa fa-refresh"></i>
                    تحويل لفاتورة مشتريات
                </a>

                <a href="{{ route('client.purchase_orders.send', $purchase_order_k->purchase_order_number) }}"
                    role="button" class="btn send_btn btn-md btn-warning pull-right ml-3">
                    <i class="fa fa-check"></i>
                    ارسال امر الشراء الى بريد المورد
                </a>

                <button bill_id="{{ $purchase_order_k->id }}"
                    purchase_order_number="{{ $purchase_order_k->supplier->supplier_name }}" data-toggle="modal"
                    href="#modaldemo9" title="delete" type="button"
                    class="modal-effect ml-4 btn btn-md btn-danger delete_bill pull-right">
                    <i class="fa fa-trash"></i>
                    حذف امر الشراء
                </button>

                <a href="{{ route('client.purchase_orders.edit', $purchase_order_k->id) }}" role="button"
                    class="ml-4 btn btn-md btn-success pull-right">
                    <i class="fa fa-pencil"></i>
                    تعديل امر الشراء
                </a>
            </div>

        </div>

        <div class="all-data" style="border-top: 1px solid #2d2d2d20;padding-top: 25px;">

            @if (!empty($company->basic_settings->header))
                <div class="headerImg">
                    <img class="img-footer" src="{{ asset($company->basic_settings->header) }}" />
                </div>
            @endif
            <div class="header-container pt-3">
                <div class="col-12 txtheader d-flex align-items-center mx-auto text-center justify-content-between"
                    style="color:#222751;">
                    <div class="logo" style="visibility: hidden">
                        <img class="logo" style="object-fit: scale-down;"
                            src="http://arabygithub.test/uploads/companies/logos/1/face-brand1.png">
                    </div>
                    <h2 style="font-size: 24px !important;font-weight: 400;line-height: 40px;">
                        @lang('sales_bills.purchase_order')
                        <br>
                        {{ $company->company_name }}
                    </h2>
                    <div class="logo" style="height: 122px;">
                        <img class="logo" style="width: 100%;height: 100%;object-fit: contain;"
                            src="{{ asset($company->company_logo) }}">
                    </div>
                </div>
            </div>

            <hr class="mt-1 mb-2">


            <!-----------products-section----------->
            <div class="products-details" style="padding: 0px 14px;">
                <table
                    style="width: 100%;width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid;box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                    <thead style="font-size: 16px !important;">
                        <tr
                            style="font-size: 16px !important; background: #222751; color: white; height: 44px !important; text-align: center;">
                            <th>@lang('sales_bills.commercial register') </th>
                            <th>@lang('suppliers.purch_num') </th>
                            <th>@lang('sales_bills.Release Date') </th>
                            <th>@lang('sales_bills.Expiry date') </th>
                            <th>@lang('sales_bills.Start Date') </th>
                        </tr>

                    </thead>
                    <tbody style="font-size: 16px !important;">

                        <tr class="even"
                            style="font-size: 16px !important; height: 40px !important; text-align: center;">
                            <td>{{ $company->civil_registration_number }}</td>
                            <td>{{ $purchase_order_k->purchase_order_number }}</td>
                            <td>{{ $purchase_order_k->created_at }}</td>
                            <td>{{ $purchase_order_k->expiration_date }}</td>
                            <td>{{ $purchase_order_k->start_date }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-------------------------------------->

            <!------------FIRST ROW----------------->
            <div class="invoice-information row justify-content-around p-3">
                <div class="col-12 pr-2 pl-2">
                    <table style="width: 100%;">
                        <tr class="d-flex pt-1"
                            style="background: #222751; color: white; font-size: 16px;border-radius: 7px 7px 0 0">
                            <td width="50%" class="text-right pr-2">@lang('suppliers.supplier data') </td>
                            <td width="50%" class="text-right pr-2">@lang('sales_bills.Company Data') </td>
                        </tr>
                    </table>
                </div>
                <div class="left border2 pr-2 pl-2" style="right: -5px;border-bottom: 1px solid #2d2d2d2d !important;">
                    <table style="width: 100%;">
                        <tr class="d-flex pt-1 bordernone">
                            <td width="60%" class="text-left">{{ $purchase_order_k->supplier->supplier_name }}</td>
                            <td width="40%" class="text-right">@lang('suppliers.supplier-name') </td>
                        </tr>
                        <tr class="d-flex pt-1 bordernone">
                            <td width="60%" class="text-left">
                                {{ $purchase_order_k->supplier->supplier_phone ?? '-' }}</td>
                            <td width="40%" class="text-right">@lang('sales_bills.phone')</td>
                        </tr>
                        {{-- <tr class="d-flex pt-1 bordernone">
                            <td width="60%" class="text-left">
                                {{$purchase_order_k->supplier->addresses[0]->client_address ?? '-' }}</td>
                            <td width="40%" class="text-right">@lang('sales_bills.address')</td>
                        </tr> --}}
                    </table>
                </div>

                <div class="right border2 pr-2 pl-2"
                    style="border-left: 1px solid #2d2d2d2d !important;left: -5px;border-bottom: 1px solid #2d2d2d2d !important;">
                    <table style="width: 100%;">
                        <tr class="d-flex bordernone">
                            <td width="60%" class="text-left">{{ $company->company_name }}</td>
                            <td width="40%" class="text-right">@lang('sales_bills.Company Name') </td>
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
            <!-------------------------------------->

            <!-----------products-section----------->
            <div class="products-details" style="padding: 0px 14px;">
                <table
                    style="width: 100%;width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid;box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                    <thead style="font-size: 16px !important;">
                        <tr
                            style="font-size: 16px !important; background: #222751; color: white; height: 44px !important; text-align: center;">
                            <th>@lang('sales_bills.total')</th>
                            <th>@lang('sales_bills.Quantity')</th>
                            <th>@lang('sales_bills.unit price')</th>
                            <th>@lang('sales_bills.product name') </th>
                            <th>#</th>
                        </tr>

                    </thead>
                    <tbody style="font-size: 16px !important;">
                        @php
                            $counter = 1;
                            $totalSum = 0;
                        @endphp
                        @php $counter = 1; @endphp
                        @foreach ($elements as $product)
                            {{-- @php
                                $prodTax = 0;
                                if ($tax_value_added != 0) {
                                    $prodTax = ($product->quantity_price * $tax_value_added) / 100;
                                }
                            @endphp --}}
                            <tr class="even"
                                style="font-size: 16px !important; height: 40px !important; text-align: center;">

                                <td class="borderLeftH" dir="rtl">
                                    {{ floatval($product->quantity_price) }} <img
                                        src="{{ asset('images/Sr_coin.svg') }}" width="15px">
                                </td>
                                <td class="borderLeftH" dir="rtl">
                                    {{ $product->quantity }}
                                    {{ $product->product->unit ? $product->product->unit->unit_name : '-' }}
                                </td>
                                <td class="borderLeftH" dir="rtl">
                                    {{ $product->product_price }} <img src="{{ asset('images/Sr_coin.svg') }}"
                                        width="15px">
                                </td>
                                <td class="borderLeftH">{{ $product->product->product_name }}</td>
                                <td class="borderLeftH">{{ $counter }}</td>
                            </tr>
                            @php
                                $counter++;
                                $totalSum += floatval($product->quantity_price);
                                $tax_value_added = $company->tax_value_added;
                                $percentage = ($tax_value_added / 100) * $totalSum;
                                $after_total = $totalSum + $percentage;
                            @endphp
                            @php $counter++; @endphp
                        @endforeach

                    </tbody>
                </table>
            </div>
            <!-------------------------------------->

            <!-----------final-details-------------->

            <div class='clearfix'></div>

            <div class="row px-3 pt-1 mt-1">
                <div class="products-details p-2 col-5">
                    <table
                        style="width: 100%;border-radius: 8px !important; overflow: hidden; border: 1px solid #2d2d2d2d;">
                        <!-- Add Discount Row -->
                        <tr class="even"
                            style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 14px !important; height: 40px !important; text-align: center;">
                            <td dir="rtl">
                                @foreach ($extras as $key)
                                    @if ($key->action == 'discount')
                                        @if ($key->action_type == 'pound')
                                            {{ $key->value }} <img src="{{ asset('images/Sr_coin.svg') }}"
                                                width="15px">
                                        @else
                                            {{ ($totalSum * $key->value) / 100 }} <img
                                                src="{{ asset('images/Sr_coin.svg') }}" width="15px">
                                            {{-- Calculate percentage discount --}}
                                        @endif
                                    @endif
                                @endforeach
                            </td>
                            <td style="text-align: right;padding-right: 14px;">
                                @lang('sales_bills.Discount')
                            </td>
                        </tr>

                        <!-- Add Shipping Charges Row -->
                        <tr class="even"
                            style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 14px !important; height: 40px !important; text-align: center;">
                            <td dir="rtl">
                                @foreach ($extras as $key)
                                    @if ($key->action != 'discount')
                                        @if ($key->action_type == 'pound')
                                            {{ $key->value }} <img src="{{ asset('images/Sr_coin.svg') }}"
                                                width="15px">
                                        @else
                                            {{ ($totalSum * $key->value) / 100 }} <img
                                                src="{{ asset('images/Sr_coin.svg') }}" width="15px">
                                            {{-- Calculate percentage shipping charge --}}
                                        @endif
                                    @endif
                                @endforeach
                            </td>
                            <td style="text-align: right;padding-right: 14px;">
                                @lang('sales_bills.Shipping Charges')
                            </td>
                        </tr>

                        <tr class="even"
                            style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 14px !important; height: 40px !important; text-align: center;">
                            <td dir="rtl">
                                {{ $percentage }} <img src="{{ asset('images/Sr_coin.svg') }}" width="15px">
                            </td>
                            <td style="text-align: right;padding-right: 14px;">
                                @lang('sales_bills.Total tax')
                                ({{ $tax_value_added }}%)
                            </td>
                        </tr>
                        <tr
                            style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 16px !important; height: 40px !important; text-align: center;">
                            <td dir="rtl">
                                {{ $totalSum }} <img src="{{ asset('images/Sr_coin.svg') }}" width="15px">
                            </td>
                            <td style="text-align: right;padding-right: 14px;">@lang('sales_bills.Total, excluding tax')</td>
                        </tr>

                        <tr
                            style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 16px !important; height: 40px !important; text-align: center;background: #222751;color:white;">
                            <td dir="rtl">
                                {{ floatval($after_total_all) }} <img src="{{ asset('images/Sr_coin.svg') }}"
                                    width="15px">
                            </td>
                            <td style="text-align: right;padding-right: 14px;">@lang('sales_bills.Total including tax') </td>
                        </tr>
                    </table>
                </div>
            </div>
            @php
                $tax_value_added = $company->tax_value_added;

                $sum = []; // Initialize the $sum array
                foreach ($elements as $product) {
                    array_push($sum, $product->quantity_price);
                }
                $total = array_sum($sum); // Sum up all quantity prices
                $percentage = ($tax_value_added / 100) * $total; // Calculate the percentage based on the total
                $after_total = $total + $percentage; // Add the percentage to the total
            @endphp



            @if (!empty($purchase_order_k->notes))
                <div class="products-details mb-3" style="padding: 0px 14px;">
                    <table
                        style="width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid; box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                        <thead style="font-size: 16px !important;">
                            <tr
                                style="font-size: 16px !important; background: #222751; color: white; height: 44px !important; text-align: right;">
                                <th style="padding-right: 10px !important;">@lang('sales_bills.comments')</th>
                            </tr>
                        </thead>
                        <tbody style="font-size: 16px !important;">
                            <tr class="even"
                                style="font-size: 16px !important; height: 40px !important; text-align: right;">
                                <td style="padding-right: 10px !important;">{!! $purchase_order_k->notes !!}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif

            <!-------------------------------------->

            <!-----------final-details-------------->
            @if (!empty($company->basic_settings->purchase_order_k_condition))
                <div class="products-details mb-3" style="padding: 0px 14px;">
                    <table
                        style="width: 100%;width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid;box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                        <thead style="font-size: 16px !important;">
                            <tr
                                style="font-size: 16px !important; background: #222751; color: white; height: 44px !important; text-align: right;">
                                <th style="padding-right: 10px !important;">@lang('sales_bills.Terms and Conditions') </th>
                            </tr>

                        </thead>
                        <tbody style="font-size: 16px !important;">
                            <tr class="even"
                                style="font-size: 16px !important; height: 40px !important;text-align: right;">
                                <td style="padding-right: 10px !important;">{!! $company->basic_settings->purchase_order_k_condition !!}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif
            <!-------------------------------------->

        </div>
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
