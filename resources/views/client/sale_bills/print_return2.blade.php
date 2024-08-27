<?php
$company = \App\Models\Company::FindOrFail($sale_bill_return->company_id);
?>
    <!DOCTYPE html>
<html>

<head>
    <title>
        @if (!empty($sale_bill_return->outer_client_id))
            <?php echo $sale_bill_return->OuterClient->client_name . ' - فاتورة رقم ' . $sale_bill_return->bill_id; ?>
        @else
            <?php echo 'فاتورة مرتجع' . ' - فاتورة رقم ' . $sale_bill_return->bill_id; ?>
        @endif
    </title>
    <meta charset="utf-8"/>
    <link href="{{ asset('/assets/css/bootstrap.min.css') }}" rel="stylesheet"/>
    <style type="text/css" media="screen">
        @font-face {
            font-family: 'Cairo';
            src: url({{ asset('fonts/Cairo.ttf') }});
        }

        .alert-bordered {
            border: 1px solid #ddd;
        }

        * {
            color: #000 !important;
            font-size: 15px !important;
            font-weight: bold !important;
        }

        .img-footer {
            width: 100% !important;
            height: 120px !important;
            max-height: 120px !important;

        }

        body,
        html {
            font-family: 'Cairo' !important;
        }

        .table-container {
            width: 70%;
            margin: 10px auto;
        }

        .no-print {
            position: fixed;
            bottom: 0;
            left: 10px;
            border-radius: 0;
            z-index: 9999;
            font-size: 12px !important;
        }

        a.no-print {
            bottom: 35px !important;
        }

    </style>
    <style type="text/css" media="print">
        body,
        html {
            font-family: 'Cairo' !important;
        }

        * {
            font-size: 15px !important;
            color: #000 !important;
            font-weight: bold !important;
        }

        .img-footer {

            width: 100% !important;
            height: 120px !important;
            max-height: 120px !important;

        }

        .no-print {
            display: none;
        }

    </style>
</head>

<body
    @if (App::getLocale() == 'ar') dir="rtl" style="text-align: right;background: #fff"
    @else
    dir="ltr" style="text-align: left;background: #fff" @endif>
<table class="table table-bordered table-container">
    <thead class="header">
    <tr>
        <td>
            <img class="img-footer" src="{{ asset($company->basic_settings->header) }}"/>
        </td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="thisTD">
            <center style="margin:20px auto;">
                @if (!empty($sale_bill_return->outer_client_id))
                    <span style="font-size:18px;font-weight:bold;border:1px dashed #333; padding: 5px 30px;">
                                فاتورة مرتجع رقم {{ $sale_bill_return->bill_id }} </span>
                @else
                    <span style="font-size:18px;font-weight:bold;border:1px dashed #333; padding: 5px 30px;">
                                فاتورة مرتجع رقم {{ $sale_bill_return->bill_id }} </span>
                @endif
            </center>
            <hr style="border-bottom:1px solid #000;margin:5px auto; width: 90%;"/>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin:10px auto;">

                    <table class="table  table-bordered" style="font-size:12px;">
                        <tr>
                            <td>
                                اسم العميل
                            </td>
                            <td colspan="2">{{ $sale_bill_return->client->name }}</td>
                            <td>
                                التاريخ
                            </td>
                            <td colspan="2">{{ $sale_bill_return->date }}</td>
                        </tr>
                        <tr>
                            <td>
                                رقم العميل
                            </td>
                            <td colspan="2">{{ $sale_bill_return->client->phone_number }}</td>
                            <td>
                                الرقم الضريبي
                            </td>
                            <td colspan="2">
                                {{ $company->tax_number }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                اسم المؤسسة
                            </td>
                            <td colspan="2">{{ $company->company_name }}</td>
                            <td>
                                العنوان
                            </td>
                            <td colspan="2">{{ $company->company_address }}</td>
                        </tr>
                        <tr>
                            <td>
                                رقم الجوال
                            </td>
                            <td colspan="2">{{ $company->phone_number }}</td>
                            <td>
                                سجل تجاري
                            </td>
                            <td colspan="2">{{ $company->civil_registration_number }}</td>
                        </tr>
                    </table>
                </div>
                @if (!empty($sale_bill_return->outer_client_id))
                    <div class="col-lg-12">
                        <table class="table table-bordered" style="font-size:12px;">
                            <tr class="text-center">
                                <td colspan="6">بيانات العميل</td>
                            </tr>
                            <tr>
                                <td>
                                    @if (isset($print_demo) && !empty($print_demo->outer_client_name_ar) && !empty($print_demo->outer_client_name_en))
                                        @if (App::getLocale() == 'ar')
                                            {{ $print_demo->outer_client_name_ar }}
                                        @else
                                            {{ $print_demo->outer_client_name_en }}
                                        @endif
                                    @else
                                        الاسم
                                    @endif
                                </td>
                                <td>{{ $sale_bill_return->OuterClient->client_name }}</td>
                                <td>
                                    @if (isset($print_demo) && !empty($print_demo->outer_client_address_ar) && !empty($print_demo->outer_client_address_en))
                                        @if (App::getLocale() == 'ar')
                                            {{ $print_demo->outer_client_address_ar }}
                                        @else
                                            {{ $print_demo->outer_client_address_en }}
                                        @endif
                                    @else
                                        العنوان
                                    @endif
                                </td>
                                <td colspan="3">
                                    @if (!empty($sale_bill_return->OuterClient->addresses[0]))
                                        {{ $sale_bill_return->OuterClient->addresses[0]->client_address }}
                                    @endif

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    @if (isset($print_demo) && !empty($print_demo->outer_client_phone_ar) && !empty($print_demo->outer_client_phone_en))
                                        @if (App::getLocale() == 'ar')
                                            {{ $print_demo->outer_client_phone_ar }}
                                        @else
                                            {{ $print_demo->outer_client_phone_en }}
                                        @endif
                                    @else
                                        رقم الجوال
                                    @endif
                                </td>
                                <td>
                                    @if (!empty($sale_bill_return->OuterClient->phones[0]))
                                        {{ $sale_bill_return->OuterClient->phones[0]->client_phone }}
                                    @endif
                                </td>
                                <td>
                                    @if (isset($print_demo) && !empty($print_demo->outer_client_tax_number_ar) && !empty($print_demo->outer_client_tax_number_en))
                                        @if (App::getLocale() == 'ar')
                                            {{ $print_demo->outer_client_tax_number_ar }}
                                        @else
                                            {{ $print_demo->outer_client_tax_number_en }}
                                        @endif
                                    @else
                                        الرقم الضريبى
                                    @endif
                                </td>
                                <td>{{ $sale_bill_return->OuterClient->tax_number }}</td>
                            </tr>
                        </table>
                    </div>
                @endif
            </div>
            <h6 class="alert alert-sm alert-info text-center">
                <i class="fa fa-info-circle"></i>
                البيان
            </h6>
            <div class='table-responsive'>
                <table style='width:100%;text-align:center' class='table table-bordered'>
                    <thead class='text-center bg-primary' style='text-align:center;'>
                    <td style='border:1px solid #ddd;font-family:Cairo !important;'>م</td>
                    <td style='border:1px solid #ddd;font-family:Cairo !important;'>الصنف</td>
                    <td style='border:1px solid #ddd;font-family:Cairo !important;'>سعر الوحدة</td>
                    <td style='border:1px solid #ddd;font-family:Cairo !important;'>عدد المرتجع</td>
                    <td style='border:1px solid #ddd;font-family:Cairo !important;'>الاجمالي</td>
                    <td style='border:1px solid #ddd;font-family:Cairo !important;'>الاجمالي شامل الضريبة</td>
                    <td style='border:1px solid #ddd;font-family:Cairo !important;'>التاريخ</td>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>{{ $sale_bill_return->product->product_name }}</td>
                        <td>{{ $sale_bill_return->product_price }}</td>
                        <td>{{ $sale_bill_return->return_quantity }}</td>
                        <td>{{ $sale_bill_return->quantity_price }}</td>
                        <td>
                            <?php
                            $totalAfterTax = 0;
                            $tax_option = $sale_bill_return->value_added_tax;
                            if ($tax_option == 1) {
                                $total = $sale_bill_return->quantity_price * (100 / 115);
                                $total_with_option = $total;
                                $percentage = (15 / 100) * $total_with_option;
                                $after_total = $percentage + $total_with_option;
                            } else {
                                $totalAfterTax = $sale_bill_return->quantity_price + ($sale_bill_return->quantity_price * (15 / 100));
                            }
                            echo floatval($totalAfterTax);
                            ?>
                        </td>
                        <td>{{ $sale_bill_return->date }}</td>
                    </tr>
                    <tr>
                        <td colspan='7'> ملاحظات : {{ $sale_bill_return->notes }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="clearfix"></div>
            <div class="text-center mt-2 mb-2">
            <!--{!! SimpleSoftwareIO\QrCode\Facades\QrCode::size(80)->generate(Request::url()) !!}-->
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
                    new InvoiceDate($sale_bill_return->date . ' ' . $sale_bill_return->time), // invoice date as Zulu ISO8601 @see https://en.wikipedia.org/wiki/ISO_8601
                    new InvoiceTotalAmount($sale_bill_return->quantity_price), // invoice total amount
                ])->render();
                ?>
                <img src="{{ $displayQRCodeAsBase64 }}" style="width: 150px; height: 130px;" alt="QR Code"/>

                <img style="width: 170px!important;height: 140px!important;"
                     src="{{ asset($company->basic_settings->electronic_stamp) }}"/>
            </div>
            </div>
        </td>
    </tr>
    </tbody>
    <tfoot class="footer">
    <tr>
        <td>
            <img style="width: 90%; display: inline;float: left;" class="img-footer"
                 src="{{ asset($company->basic_settings->footer) }}"/>
        </td>
    </tr>
    </tfoot>
</table>
<button onclick="window.print();" class="no-print btn btn-md btn-success text-white">اضغط للطباعة</button>
<a href="{{ route('client.sale_bills.create') }}" class="no-print btn btn-md btn-danger text-white"> العودة الى
    فاتورة
    المبيعات </a>

<button class="show_hide_header text-white btn btn-dark btn-sm no-print" dir="ltr"
        style="height: 45px!important;bottom: 150px!important;left: 30px!important;font-size: 12px!important;">
    <i class="fa fa-eye-slash"></i>
    اظهار او اخفاء الهيدر
</button>
<button class="show_hide_footer text-white btn btn-dark btn-sm no-print" dir="ltr"
        style="height: 45px!important;left: 30px!important;font-size: 12px!important;bottom: 100px!important;">
    <i class="fa fa-eye-slash"></i>
    اظهار او اخفاء الفوتر
</button>
<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script type="text/javascript">
    $('.show_hide_header').on('click', function () {
        $('.header').toggle();
    });
    $('.show_hide_footer').on('click', function () {
        $('.footer').toggle();
    });
</script>
</body>

</html>
