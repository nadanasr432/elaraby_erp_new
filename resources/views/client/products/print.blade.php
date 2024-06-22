<!DOCTYPE html>
<html>
<head>
    <title>
        طباعة المنتجات المتوفرة فى المخازن
    </title>
    <meta charset="utf-8"/>
    <link rel="icon" href="{{asset('images/logo-min.png')}}" type="image/png">
    <link href="{{asset('app-assets/css-rtl/bootstrap.min.css')}}" rel="stylesheet"/>
    <style>
        @font-face {
            font-family: 'Cairo';
            src: url("{{asset('fonts/Cairo.ttf')}}");
        }

        body, html {
            font-family: 'Cairo';
            font-size: 15px;
        }

        i.la {
            font-size: 15px !important;
        }

        select.form-control {
            padding: 0 5px !important;
        }
    </style>
    <style type="text/css" media="screen">
        body, html {
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
        body, html {
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
<div class="text-center m-2 p-2">
    <img class="logo" src="{{asset($company->company_logo)}}" alt="">
</div>

<div class="text-center m-2 p-2">
    <div class="col-lg-12 text-center justify-content-center p-2">
        <p class="alert alert-secondary text-center alert-sm"
           style="margin: 10px auto; font-size: 17px;line-height: 1.9;" dir="rtl">
            {{$company->company_name}} <br>
            {{$company->business_field}} <br>
            {{$company->company_owner}} <br>
            {{$company->phone_number}} <br>

        </p>
    </div>
    <h6 class="alert alert-sm alert-success text-center">
        عرض المنتجات المتوفرة فى المخازن
    </h6>
</div>

<table class="table table-condensed table-striped table-bordered text-center table-hover"
       id="example-table" dir="rtl">
    <thead>
    <tr>
        <th class="text-center">رقم الباركود</th>
        <th class="text-center">المخزن</th>
        <th class="text-center">الفئة</th>
        <th class="text-center">الاسم</th>
        <th class="text-center">جملة</th>
        <th class="text-center">قطاعى</th>
        <th class="text-center">تكلفة</th>
        <th class="text-center">رصيد مخزون</th>
    </tr>
    </thead>
    <tbody>
    @php
        $i=0;
    @endphp
    @foreach ($products as $key => $product)
        <tr>
            <td>{{ $product->code_universal ?? ' '}}</td>
            <td>{{ $product->store->store_name ?? ' '}}</td>
            <td>
                {{ $product->category->category_name ?? ' '}}
                @if(!empty($product->sub_category_id))
                    {{ $product->subcategory->sub_category_name ?? ' '}}
                @endif
            </td>
            <td>{{ $product->product_name ?? ' '}}</td>

            <td>
                {{floatval($product->wholesale_price ?? ' ')}}
            </td>
            <td>
                {{floatval($product->sector_price ?? ' ')}}
            </td>
            <td>
                {{floatval($product->purchasing_price ?? ' ')}}
            </td>
            <td>
                {{floatval($product->first_balance ?? ' ')}}
                @if(!empty($product->unit_id))
                    {{$product->unit->unit_name ?? ' '}}
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<button onclick="window.print();" class="no-print btn btn-lg btn-success">طباعة</button>
<a href="{{route('client.products.index')}}" style="margin-right:110px;"
   class="no-print btn btn-lg btn-danger"> عودة الى عرض المنتجات المتوفرة </a>
</body>
</html>
