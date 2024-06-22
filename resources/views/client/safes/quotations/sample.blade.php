<!DOCTYPE html>
<html>

<head>
    <title>عرض سعر</title>
    <meta charset="utf-8"/>
    <link href="{{asset('/assets/css/bootstrap.min.css')}}" rel="stylesheet"/>
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
            font-size: 15px;
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
            font-size: 13px !important;
            font-weight: 500 !important;
        }

        .borderLeftH {
            border-left: 1px solid rgba(229, 229, 229, 0.94) !important;
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
            font-size: 15px;
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

        .tete > * {
            text-align: right !important;
        }
    </style>
</head>

<body>
<div class="invoice-container border mt-4">

    <div class="text-center" id="buttons">
        <button class="btn btn-sm btn-success" onclick="window.print()">طباعة الفاتورة</button>
        <a class="btn btn-sm btn-danger" onclick="history.back()"> العودة</a>
    </div>

    <div class="all-data">
        <div class="header-container pt-3">
            <div class="col-12 txtheader d-flex align-items-center mx-auto text-center justify-content-between"
                 style="color:#222751;">
                <div class="logo" style="visibility: hidden">
                    <img class="logo" style="object-fit: scale-down;"
                         src="http://arabygithub.test/uploads/companies/logos/1/face-brand1.png">
                </div>
                <h2 style="font-size: 24px !important;font-weight: 400;line-height: 40px;">
                    عرض سعر
                    <br>
                    {{$company->company_name}}
                </h2>
                <div class="logo" style="height: 122px;">
                    <img class="logo" style="width: 100%;height: 100%;object-fit: contain;"
                         src="{{asset($company->company_logo)}}">
                </div>
            </div>
        </div>

        <hr class="mt-1 mb-2">


        <!-----------products-section----------->
        <div class="products-details" style="padding: 0px 14px;">
            <table
                style="width: 100%;width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid;box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                <thead style="font-size: 15px !important;">
                <tr
                    style="font-size: 15px !important; background: #222751; color: white; height: 44px !important; text-align: center;">
                    <th>السجل التجاري</th>
                    <th>رقم العرض</th>
                    <th>تاريخ الاصدار</th>
                    <th>تاريخ البداية</th>
                    <th>تاريخ الانتهاء</th>
                </tr>

                </thead>
                <tbody style="font-size: 15px !important;">

                <tr class="even" style="font-size: 15px !important; height: 40px !important; text-align: center;">
                    <td>{{$company->civil_registration_number}}</td>
                    <td>{{$quotation->quotation_number}}</td>
                    <td>{{$quotation->created_at}}</td>
                    <td>{{$quotation->start_date}}</td>
                    <td>{{$quotation->expiration_date}}</td>
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
                        <td width="50%" class="text-right pr-2">بيانات العميل</td>
                        <td width="50%" class="text-right pr-2">بيانات الشركة</td>
                    </tr>
                </table>
            </div>
            <div class="left border2 pr-2 pl-2" style="right: -5px;border-bottom: 1px solid #2d2d2d2d !important;">
                <table style="width: 100%;">
                    <tr class="d-flex bordernone">
                        <td width="60%"
                            class="text-left centerTd">{{$quotation->outerClient->shop_name ?? $quotation->outerClient->client_name}}</td>
                        <td width="40%" class="text-right">اسم الشركة</td>
                    </tr>
                    <tr class="d-flex pt-1 bordernone">
                        <td width="60%" class="text-left">{{$quotation->outerClient->tax_number ?? '-'}}</td>
                        <td width="40%" class="text-right">الرقم الضريبي</td>
                    </tr>
                    <tr class="d-flex pt-1 bordernone">
                        <td width="60%"
                            class="text-left">{{$quotation->outerClient->phones[0]->client_phone ?? '-'}}</td>
                        <td width="40%" class="text-right">الجوال</td>
                    </tr>
                    <tr class="d-flex pt-1 bordernone">
                        <td width="60%"
                            class="text-left">{{$quotation->outerClient->addresses[0]->client_address ?? '-'}}</td>
                        <td width="40%" class="text-right">العنوان</td>
                    </tr>
                </table>
            </div>

            <div class="right border2 pr-2 pl-2"
                 style="border-left: 1px solid #2d2d2d2d !important;left: -5px;border-bottom: 1px solid #2d2d2d2d !important;">
                <table style="width: 100%;">
                    <tr class="d-flex bordernone">
                        <td width="60%" class="text-left">{{$company->company_name}}</td>
                        <td width="40%" class="text-right">اسم الشركة</td>
                    </tr>
                    <tr class="d-flex pt-1 bordernone">
                        <td width="60%" class="text-left">{{$company->tax_number ?? '-'}}</td>
                        <td width="40%" class="text-right">الرقم الضريبي</td>
                    </tr>
                    <tr class="d-flex pt-1 bordernone">
                        <td width="60%" class="text-left">{{$company->phone_number ?? '-'}}</td>
                        <td width="40%" class="text-right">الجوال</td>
                    </tr>
                    <tr class="d-flex pt-1 bordernone">
                        <td width="60%" class="text-left">
                            {{$company->company_address ?? '-'}}
                        </td>
                        <td width="40%" class="text-right">العنوان</td>
                    </tr>
                </table>
            </div>
        </div>
        <!-------------------------------------->

        <!-----------products-section----------->
        <div class="products-details" style="padding: 0px 14px;">
            <table
                style="width: 100%;width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid;box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                <thead style="font-size: 15px !important;">
                <tr
                    style="font-size: 15px !important; background: #222751; color: white; height: 44px !important; text-align: center;">
                    <th>المجموع</th>
                    <th>الضريبة</th>
                    <th>المبلغ غير شامل الضريبة</th>
                    <th>الكمية</th>
                    <th>سعر الوحدة</th>
                    <th>اسم المنتج</th>
                    <th>كود المنتج</th>
                </tr>

                </thead>
                <tbody style="font-size: 15px !important;">
                @foreach($products as $product)
                    @php
                        $prodTax = 0;
                        if($tax_value_added != 0)
                        $prodTax = $product->product_price * $tax_value_added / 100;

                    @endphp
                    <tr class="even" style="font-size: 15px !important; height: 40px !important; text-align: center;">
                        <td class="borderLeftH">{{$prodTax + $product->product_price}} {{$company->extra_settings->currency}}</td>
                        <td class="borderLeftH">{{$prodTax}} {{$company->extra_settings->currency}}</td>
                        <td class="borderLeftH"
                            dir="rtl">{{$product->product_price}} {{$company->extra_settings->currency}}</td>
                        <td class="borderLeftH"
                            dir="rtl">{{$product->quantity}} {{$product->product->unit ? $product->product->unit->unit_name : '-'}}</td>
                        <td class="borderLeftH"
                            dir="rtl">{{$product->product->sector_price}} {{$company->extra_settings->currency}}</td>
                        <td class="borderLeftH">{{$product->product->product_name}}</td>
                        <td class="borderLeftH">{{$product->id}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <!-------------------------------------->

        <!-----------final-details-------------->
        <div class="row px-3 pt-1 mt-1">
            <div class="products-details p-2 col-4">
                <table
                    style="width: 100%;border-radius: 8px !important; overflow: hidden; border: 1px solid #2d2d2d2d;">
                    <tr
                        class="even"
                        style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 14px !important; height: 40px !important; text-align: center;">
                        <td dir="rtl">
                            {{$discount_value}} {{$company->extra_settings->currency}}
                        </td>
                        <td style="text-align: right;padding-right: 14px;">الخصم</td>
                    </tr>

                    <tr
                        style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 13px !important; height: 40px !important; text-align: center;">
                        <td dir="rtl">
                            {{$productsTotal}} {{$company->extra_settings->currency}}
                        </td>
                        <td style="text-align: right;padding-right: 14px;">اجمالي غير شامل الضريبة</td>
                    </tr>


                    <tr
                        class="even"
                        style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 14px !important; height: 40px !important; text-align: center;">
                        <td dir="rtl">
                            {{$taxValue}} {{$company->extra_settings->currency}}
                        </td>
                        <td style="text-align: right;padding-right: 14px;">
                            اجمالي الضريبة
                            ({{$tax_value_added}}%)
                        </td>
                    </tr>

                    <tr
                        style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 13px !important; height: 40px !important; text-align: center;background: #222751;color:white;">
                        <td dir="rtl">
                            {{$totalQuotaitonPrice}} {{$company->extra_settings->currency}}
                        </td>
                        <td style="text-align: right;padding-right: 14px;">اجمالي شامل الضريبة</td>
                    </tr>
                </table>
            </div>
        </div>
        <!-------------------------------------->

        <!-----------final-details-------------->
        @if(!empty($quotation->notes))
            <div class="products-details mb-3" style="padding: 0px 14px;">
                <table
                    style="width: 100%;width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid;box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                    <thead style="font-size: 15px !important;">
                    <tr style="font-size: 16px !important; background: #222751; color: white; height: 44px !important; text-align: right;">
                        <th style="padding-right: 10px !important;">الملاحظات</th>
                    </tr>

                    </thead>
                    <tbody style="font-size: 15px !important;">
                    <tr class="even" style="font-size: 15px !important; height: 40px !important;text-align: right;">
                        <td style="padding-right: 10px !important;">{!! $quotation->notes !!}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        @endif
    <!-------------------------------------->

        <!-----------final-details-------------->
        @if(!empty($company->basic_settings->quotation_condition))
            <div class="products-details mb-3" style="padding: 0px 14px;">
                <table
                    style="width: 100%;width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid;box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                    <thead style="font-size: 15px !important;">
                    <tr style="font-size: 16px !important; background: #222751; color: white; height: 44px !important; text-align: right;">
                        <th style="padding-right: 10px !important;">الشروط والاحكام</th>
                    </tr>

                    </thead>
                    <tbody style="font-size: 15px !important;">
                    <tr class="even" style="font-size: 15px !important; height: 40px !important;text-align: right;">
                        <td style="padding-right: 10px !important;">{!! $company->basic_settings->quotation_condition !!}</td>
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
--------------------------------->

    </div>
</div>


</body>

</html>
