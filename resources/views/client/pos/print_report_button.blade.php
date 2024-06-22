<!DOCTYPE html>
<html>

<head>
    <title>
        طباعة تقرير مبيعات نقاط البيع
    </title>
    <meta charset="utf-8" />
    <link rel="icon" href="{{ asset('images/logo-min.png') }}" type="image/png">
    <link href="{{ asset('app-assets/css-rtl/bootstrap.min.css') }}" rel="stylesheet" />
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
            top: 85%;
    right: 32%;
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
            <p class="alert alert-secondary text-center alert-sm" style="margin: 0px auto; font-size: 14px;line-height: 1.5;" dir="rtl">
                {{ $company->company_name }} --
                {{ $company->business_field }} <br>
                {{ $company->company_owner }} --
                {{ $company->phone_number }} <br>

            </p>
        </div>

    </div>
    <div class="posReportsTodayMain card-body">


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


        <?php
        $bill_id = 'pos_' . $pos->id;
        $check = App\Models\Cash::where('bill_id', $bill_id)->first();

        if (empty($check)) {
            $check2 = App\Models\BankCash::where('bill_id', $bill_id)->first();
            if (empty($check2)) {
            } else {
                $totalBank += $check2->amount;
            }
        } else {
            $totalCash += $check->amount;
        }
        ?>

        @endforeach
        <!---amount-->

        <div class='row mb-3 mt-3 text-center'>
            <div class='badge badge-dark mb-1 p-1' style="margin-right: 5px;width: fit-content;font-size: 14px !important;font-weight: bold;padding: 11px !important;">
                مبيعات الكاش :
                <span>{{ round($totalCash,2) }}</span>
            </div>

            <div class='badge badge-warning mb-1 p-1' style="margin-right: 5px;width: fit-content;font-size: 14px !important;font-weight: bold;padding: 11px !important;">
                مبيعات الشبكة :
                <span>{{ round($totalBank,2) }}</span>
            </div>

            <!--اجمالى الضريبة للفواتير-->
            <div class='badge badge-danger mb-1 p-1' style='margin-right: 5px;width: fit-content;font-size: 14px !important;font-weight: bold;padding: 11px !important;'>
                {{ __('pos.total-tax-for-all-invoices') }} :
                <span>{{ round($sum3,2) }}</span>
            </div>

            <!--المبلغ الاجمالي المدفوع--->
            <div class='badge badge-primary mb-1 p-1' style='margin-right: 5px;width: fit-content;font-size: 14px !important;font-weight: bold;padding: 11px !important;'>
                {{ __('main.paid-amount') }} :
                <span>{{ round($sum2,2) }}</span>
            </div>

            <!--اجمالى الفواتير شامل الضريبة-->
            <div class='badge badge-success mb-1 p-1' style='margin-right: 5px;width: fit-content;font-size: 14px !important;font-weight: bold;'>
                {{ __('pos.total-invoices-including-tax') }} :
                <span>{{ round($sum1,2) }}</span>
            </div>
        </div>
    </div>

    <button onclick="window.print();" class="no-print btn btn-lg btn-success">طباعة</button>
    <a href="{{ route('pos.sales.report') }}" style="margin-right:110px;" class="no-print btn btn-lg btn-danger"> عودة
        الى نقطة البيع </a>

</body>

</html>