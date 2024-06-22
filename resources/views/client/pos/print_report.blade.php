<!DOCTYPE html>
<html>

<head>
    <title>
        طباعة تقرير مبيعات نقاط البيع
    </title>
    <meta charset="utf-8"/>
    <link rel="icon" href="{{ asset('images/logo-min.png') }}" type="image/png">
    <link href="{{ asset('app-assets/css-rtl/bootstrap.min.css') }}" rel="stylesheet"/>
    <style>
        @font-face {
            font-family: 'Cairo';
            src: url("{{ asset('fonts/Cairo.ttf') }}");
        }

        body,
        html {
            font-family: 'Cairo';
            font-size: 13px;
        }

        i.la {
            font-size: 13px !important;
        }

        select.form-control {
            padding: 0 5px !important;
        }

    </style>
    <style type="text/css" media="screen">
        body,
        html {
            font-family: 'Cairo';
        }

        .table-container {
            width: 50%;
            margin: 10px auto;
        }

        .no-print {
            position: fixed;
            bottom: 0;
            right: 30px;
            border-radius: 0;
            z-index: 9999;
        }

        .logo {
            width: 100px;
            height: 100px;
            border: 1px solid #ccc;
            padding: 3px;
            border-radius: 5px;
        }

    </style>
    <style type="text/css" media="print">
        body,
        html {
            font-family: 'Cairo';
            -webkit-print-color-adjust: exact !important;
            -moz-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            -o-print-color-adjust: exact !important;
        }

        .no-print {
            display: none;
        }

        .img-footer {
            position: fixed;
            bottom: 0;
        }

        .logo {
            width: 100px;
            height: 100px;
            border: 1px solid #ccc;
            padding: 3px;
            border-radius: 5px;
        }

    </style>
</head>

<body style="background: #fff; padding-bottom: 50px;" dir="rtl">
<div class="text-center m-1 p-1">
    <img class="logo" src="{{ asset($company->company_logo) }}" alt="">
</div>

<div class="text-center m-1 p-1">
    <div class="col-lg-12 text-center justify-content-center p-1">
        <p class="alert alert-secondary text-center alert-sm"
           style="margin: 0px auto; font-size: 14px;line-height: 1.5;" dir="rtl">
            {{ $company->company_name }} --
            {{ $company->business_field }} <br>
            {{ $company->company_owner }} --
            {{ $company->phone_number }} <br>

        </p>
    </div>
    <h6 class="alert alert-sm alert-success text-center">
        {{ __('sidebar.pos-reports') }}
    </h6>
</div>
<div class="posReportsTodayMain card-body">
    <div class="table-responsive">
        <table
            class="defaultTableMain table table-condensed table-striped table-bordered text-center table-hover"
            id="example-table">
            <thead>
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">{{ __('pos.invoice-number') }}</th>
                <th class="text-center">{{ __('pos.client-name') }}</th>
                <th class="text-center"> {{ __('pos.invoice-date') }}</th>
                <th class="text-center"> {{ __('pos.invoice-status') }}</th>
                <th class="text-center"> {{ __('main.amount') }}</th>
                <th class="text-center"> {{ __('main.paid-amount') }}</th>
                <th class="text-center"> {{ __('main.remaining-amount') }}</th>
                <th class="text-center"> {{ __('main.taxes') }} </th>
                <th class="text-center"> {{ __('main.items') }}</th>
            </tr>
            </thead>
            <tbody>

            @php #initializaiton
                                $i = 0;
                                $sum1 = 0; # total-invoices-including-tax
                                $sum2 = 0; # main.paid-amount
                                $sum3 = 0; # total-tax-for-all-invoices
                                $totalCash = 0; # total-cash
                                $totalBank = 0; # total-tax-for-all-invoices
            @endphp

            @foreach ($pos_sales as $key => $pos)
                @php
                    //totalamount
                    $totalAmount = 0;
                    //totalPaid
                    $totalPaid = 0;
                @endphp
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $pos->id }}</td>
                    <td>
                        @if (isset($pos->outerClient->client_name))
                            {{ $pos->outerClient->client_name }}
                        @else
                            زبون
                        @endif
                    </td>

                    <!---invoice date--->
                    <td>{{ explode(' ', $pos->created_at)[0] }}</td>

                    <!---invoice-status--->
                    <td>
                        <?php
                        $bill_id = 'pos_' . $pos->id;
                        $check = App\Models\Cash::where('bill_id', $bill_id)->first();

                        if (empty($check)) {
                            $check2 = App\Models\BankCash::where('bill_id', $bill_id)->first();
                            if (empty($check2)) {
                                echo 'غير مدفوعة - دين على العميل';
                            } else {
                                $totalBank += $check2->amount;
                                echo 'مدفوعة شيك بنكى';
                            }
                        } else {
                            $totalCash += $check->amount;
                            echo 'مدفوعة كاش';
                        }
                        ?>
                    </td>

                    <!---amount-->
                    <td>
                        @if (isset($pos))
                            <?php
                            $pos_elements = $pos->elements;
                            $pos_discount = $pos->discount;
                            $pos_tax = $pos->tax;
                            $percent = 0;

                            $sum = 0;
                            foreach ($pos_elements as $pos_element) {
                                $sum = $sum + $pos_element->quantity_price;
                                $totalAmount += $pos_element->quantity_price;
                            }
                            if (isset($pos) && isset($pos_tax) && empty($pos_discount)) {
                                $tax_value = $pos_tax->tax_value;
                                $percent = ($tax_value / 100) * $sum;
                                $sum = $sum + $percent;
                            } elseif (isset($pos) && isset($pos_discount) && empty($pos_tax)) {
                                $discount_value = $pos_discount->discount_value;
                                $discount_type = $pos_discount->discount_type;
                                if ($discount_type == 'pound') {
                                    $sum = $sum - $discount_value;
                                } else {
                                    $discount_value = ($discount_value / 100) * $sum;
                                    $sum = $sum - $discount_value;
                                }
                            } elseif (isset($pos) && !empty($pos_discount) && !empty($pos_tax)) {
                                $tax_value = $pos_tax->tax_value;
                                $discount_value = $pos_discount->discount_value;
                                $discount_type = $pos_discount->discount_type;
                                if ($discount_type == 'pound') {
                                    $sum = $sum - $discount_value;
                                } else {
                                    $discount_value = ($discount_value / 100) * $sum;
                                    $sum = $sum - $discount_value;
                                }
                                $percent = ($tax_value / 100) * $sum;
                                $sum = $sum + $percent;
                            } elseif (isset($pos) && empty($pos_discount) && empty($pos_tax)) {#inclusive
                                if ($pos->value_added_tax)
                                    $percent = round($sum - ((100 / 115) * $sum), 2);
                                else
                                    $percent = 0;
                            }
                            echo round($sum, 2);
                            $sum1 = $sum1 + $sum;
                            ?>
                        @else
                            0
                        @endif
                    </td>

                    <!---paid-amount-->
                    <td>
                        <?php
                        $bill_id = 'pos_' . $pos->id;
                        $check = App\Models\Cash::where('bill_id', $bill_id)->first();
                        if (empty($check)) {
                            $check2 = App\Models\BankCash::where('bill_id', $bill_id)->first();
                            if (empty($check2)) {
                                echo '0';
                                $sum2 = $sum2 + 0;
                            } else {
                                echo round($check2->amount, 2);
                                $totalPaid = $check2->amount;
                                $sum2 = $sum2 + $check2->amount;
                            }
                        } else {
                            echo round($check->amount, 2);
                            $totalPaid = $check->amount;
                            $sum2 = $sum2 + $check->amount;
                        }
                        ?>

                    </td>

                    <!---remaining-amount-->
                    <td>
                        <?php
                        echo round($sum - $totalPaid, 2);
                        #$rest = $totalAmount - $totalPaid;
                        ?>
                    </td>

                    <!--taxes--->
                    <td>
                        {{ round($percent,2) }}
                        <?php
                        $sum3 = $sum3 + $percent;
                        ?>
                    </td>
                    <td>
                        @if (isset($pos))
                            <?php
                            $pos_elements = $pos->elements;
                            ?>
                            {{ $pos_elements->count() }}
                        @else
                            0
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class='row mb-3 mt-3 text-center'>
        <div class='badge badge-dark mb-1 p-1'
             style="margin-right: 5px;width: fit-content;font-size: 14px !important;font-weight: bold;padding: 11px !important;">
            مبيعات الكاش :
            <span>{{ round($totalCash,2) }}</span>
        </div>

        <div class='badge badge-warning mb-1 p-1'
             style="margin-right: 5px;width: fit-content;font-size: 14px !important;font-weight: bold;padding: 11px !important;">
            مبيعات الشبكة :
            <span>{{ round($totalBank,2) }}</span>
        </div>

        <!--اجمالى الضريبة للفواتير-->
        <div class='badge badge-danger mb-1 p-1'
             style='margin-right: 5px;width: fit-content;font-size: 14px !important;font-weight: bold;padding: 11px !important;'>
            {{ __('pos.total-tax-for-all-invoices') }} :
            <span>{{ round($sum3,2) }}</span>
        </div>

        <!--المبلغ الاجمالي المدفوع--->
        <div class='badge badge-primary mb-1 p-1'
             style='margin-right: 5px;width: fit-content;font-size: 14px !important;font-weight: bold;padding: 11px !important;'>
            {{ __('main.paid-amount') }} :
            <span>{{ round($sum2,2) }}</span>
        </div>

        <!--اجمالى الفواتير شامل الضريبة-->
        <div class='badge badge-success mb-1 p-1'
             style='margin-right: 5px;width: fit-content;font-size: 14px !important;font-weight: bold;'>
            {{ __('pos.total-invoices-including-tax') }} :
            <span>{{ round($sum1,2) }}</span>
        </div>
    </div>
</div>

<button onclick="window.print();" class="no-print btn btn-lg btn-success">طباعة</button>
<a href="{{ route('client.pos.create') }}" style="margin-right:110px;" class="no-print btn btn-lg btn-danger"> عودة
    الى نقطة البيع </a>
</body>

</html>
