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
                <th class="text-center">المنتج</th>
                <th class="text-center">عدد مرات البيع</th>
                <th class="text-center">المبلغ قبل الضريبة</th>
                <th class="text-center">المبلغ الاجمالي</th>
                <th class="text-center">الضريبة</th>
            </tr>
            </thead>
            <tbody>
            @empty($productsSoldToday)
                <tr>
                    <th class="text-center" colspan="5" style="text-align: center;background: #f69a9a">
                        لم يتم بيع اي منتج اليوم حتي الان!
                    </th>
                </tr>
            @else
                @php $i = 1;@endphp
                @foreach($productsSoldToday as $row)
                    <tr>
                        <th class="text-center">{{$i}}</th>
                        <th class="text-center">{{$row['name']}}</th>
                        <th class="text-center">{{$row['count']}}</th>
                        <th class="text-center">{{$row['priceBeforeTax']}}</th>
                        <th class="text-center">{{$row['price']}}</th>
                        <th class="text-center">{{$row['tax']}}</th>
                    </tr>
                    @php $i++;@endphp
                @endforeach
            @endempty

            </tbody>
        </table>
    </div>


    <div class="row mb-3 mt-3 text-center justify-content-center">
        <div class="badge badge-danger mb-1 p-1"
             style="margin-right: 5px;width: fit-content;font-size: 14px !important;font-weight: bold;">
            الاجمالي قبل الضريبة :
            {{round($totalPrice - $totalTax,2)}}
        </div>
        <div class="badge badge-primary mb-1 p-1"
             style="margin-right: 5px;width: fit-content;font-size: 14px !important;font-weight: bold;">
            الاجمالي شامل الضريبة :
            {{round($totalPrice,2)}}
        </div>
        <div class="badge badge-success mb-1 p-1"
             style="margin-right: 5px;width: fit-content;font-size: 14px !important;font-weight: bold;">
            اجمالى الضريبة :
            {{round($totalTax,2)}}
        </div>
    </div>
</div>

<button onclick="window.print();" class="no-print btn btn-lg btn-success">طباعة</button>
<a href="{{ route('client.pos.create') }}" style="margin-right:110px;" class="no-print btn btn-lg btn-danger"> عودة
    الى نقطة البيع </a>
</body>

</html>
