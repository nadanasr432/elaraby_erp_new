<?php
$company = \App\Models\Company::FindOrFail($buy_bill->company_id);
$company_id = $company->id;
$extra_settings = \App\Models\ExtraSettings::where('company_id', $company->id)->first();
$currency = $extra_settings->currency;
$tax_value_added = $company->tax_value_added;
?>
    <!DOCTYPE html>
<html>
<head>
    <title>
        <?php echo $buy_bill->supplier->supplier_name . " - فاتورة رقم " . $buy_bill->buy_bill_number;  ?>
    </title>
    <meta charset="utf-8"/>
    <link href="{{asset('/assets/css/bootstrap.min.css')}}" rel="stylesheet"/>
    <style type="text/css" media="screen">
        @font-face {
            font-family: 'Cairo';
            src: url({{asset('fonts/Cairo.ttf')}});
        }

        body, html {
            font-family: 'Cairo' !important;
        }

        .table-container {
            width: 50%;
            margin: 10px auto;
        }

        .no-print {
            position: fixed;
            bottom: 0;
            right: 10px;
            border-radius: 0;
            z-index: 9999;
            font-size: 12px !important;
        }

        a.no-print {
            bottom: 35px !important;
        }

    </style>
    <style type="text/css" media="print">
        body, html {
            font-family: 'Cairo' !important;
        }

        .no-print {
            display: none;
        }
    </style>
</head>
<body style="background: #fff">
<table class="table table-bordered table-container">
    <thead class="header">
    <tr>
        <td>
            <img class="img-footer" src="{{asset($company->basic_settings->header)}}"/>
        </td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="thisTD">
            <center style="margin:20px auto;">
                <span style="font-size:18px;font-weight:bold;border:1px dashed #333; padding: 5px 30px;"> فاتورة ضريبية مشتريات </span>
            </center>

            <hr style="border-bottom:1px solid #000;margin:5px auto; width: 90%;"/>

            <!-------------------------ROW1--COMPANY INFO------------------------------->
            <div class="row" dir="rtl">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin:10px auto;">

                    <table class="table  table-bordered text-right" dir="rtl" style="font-size:12px;">
                        <tr>
                            <td style="width:40%;"> تاريخ الفاتورة</td>
                            <td>{{$buy_bill->date}}</td>
                            <td style="width:40%;"> الرقم الضريبى</td>
                            <td>{{$company->tax_number}}</td>
                        </tr>
                        <tr>
                            <td style="width:40%;">رقم الفاتورة</td>
                            <td>{{$buy_bill->buy_bill_number}}</td>
                            <td style="width:40%;">السجل التجارى</td>
                            <?php
                            $client_id = $buy_bill->client_id;
                            $client = \App\Models\Client::FindOrFail($client_id);
                            $branch = $client->branch;?>
                            <td>
                                @if(!empty($client->branch_id))
                                    {{$branch->commercial_registration_number}}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="width:15%;">اسم المؤسسة</td>
                            <td style="width:35%;">{{$company->company_name}}</td>
                            <td colspan="2" style="width:15%;text-align: center;">عنوان المؤسسة</td>
                        </tr>
                        <tr>
                            <td style="width:15%;">رقم التليفون</td>
                            <td style="width:35%;">{{$company->phone_number}}</td>
                            <td colspan="2" style="width:35%;text-align: center;">{{$company->company_address}}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-lg-12">
                    <table class="table table-bordered text-right" dir="rtl" style="font-size:12px;">
                        <tr class="text-center">
                            <td colspan="4">بيانات المورد</td>
                        </tr>
                        <tr>
                            <td style="width:15%;">اسم المورد</td>
                            <td style="width:35%;">{{$buy_bill->supplier->supplier_name}}</td>
                            <td style="width:15%;">فئة التعامل</td>
                            <td style="width:35%;">{{$buy_bill->supplier->supplier_category}}</td>
                        </tr>
                        <tr>
                            <td style="width:15%;">رقم التليفون</td>
                            <td style="width:35%;direction:ltr;">{{$buy_bill->supplier->supplier_phone}}</td>
                            <td style="width:15%;">الرقم الضريبى</td>
                            <td style="width:35%;">{{$buy_bill->supplier->tax_number}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-------------------------ROW1--COMPANY INFO------------------------------->

            <?php
            $sum = array();
            $elements = $buy_bill->elements;
            $extras = $buy_bill->extras;
            $billNum = $buy_bill->company_counter ? $buy_bill->company_counter : $buy_bill->buy_bill_number;
            //<!-------------------------ROW2--PRODUCTS-TABLE------------------------------->
            if (!$elements->isEmpty()) {
                echo '<h6 class="alert alert-sm alert-info text-center">
                        <i class="fa fa-info-circle"></i>
                    بيانات عناصر الفاتورة  رقم
                        '. $billNum .'
                </h6>';
                $i = 0;
                echo "<div class='table-responsive'>";
                echo "<table style='width:100%;text-align:center' dir='rtl' class='table table-bordered text-right'>";
                echo "<thead dir='rtl' class='text-center bg-primary' style='text-align:center;'>";
                echo "<td style='border:1px solid #ddd;font-family:Cairo !important;'>م</td>";
                echo "<td style='border:1px solid #ddd;font-family:Cairo !important;'>الكود</td>";
                echo "<td style='border:1px solid #ddd;font-family:Cairo !important;'>الموديل</td>";
                echo "<td style='border:1px solid #ddd;font-family:Cairo !important;'>بيانات المنتج</td>";
                echo "<td style='border:1px solid #ddd;font-family:Cairo !important;'>العدد</td>";
                echo "<td style='border:1px solid #ddd;font-family:Cairo !important;'> سعر الوحدة </td>";
                echo "<td style='border:1px solid #ddd;font-family:Cairo !important;'> سعر الاجمالى</td>";
                echo "</thead>";
                echo "<tbody>";
                foreach ($elements as $element) {
                    array_push($sum, $element->quantity_price);
                    echo "<tr>";
                    echo "<td>" . ++$i . "</td>";
                    echo "<td>" . $element->product->code_universal . "</td>";
                    echo "<td>" . $element->product->product_model . "</td>";
                    echo "<td>" . $element->product->product_name . "</td>";
                    echo "<td>" . $element->quantity . " " . $element->unit->unit_name . "</td>";
                    echo "<td>" . $element->product_price . "</td>";
                    echo "<td>" . $element->quantity_price . "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
                echo "</div>";
                $total = array_sum($sum);
                $percentage = ($tax_value_added / 100) * $total;
                $after_total = $total + $percentage;
                //                echo "
                //                <div class='clearfix'></div>
                //                <div class='alert alert-dark alert-sm text-center'>
                //                    <div class='pull-right col-lg-6 '>
                //                         اجمالى الفاتورة
                //                        " . $total . " " . $currency . "
                //                    </div>
                //                    <div class='pull-left col-lg-6 '>
                //                        اجمالى الفاتورة  بعد القيمة المضافة
                //                        " . $after_total . " " . $currency . "
                //                    </div>
                //                    <div class='clearfix'></div>
                //                </div>";
            }
            //<!-------------------------ROW2--PRODUCTS-TABLE------------------------------->


            //<!-------------------------ROW3--INVOICE-DETAILS------------------------------->

            echo "<table class='table table-bordered text-right' dir='rtl' style='font-size:12px;'>
                <tr>
                    <td>";
            if ($buy_bill->value_added_tax) { // inclusive
                $totalBeforeTax = round(((100 / 115) * $total), 2);
            } else { // exclusive
                $totalBeforeTax = $total - (($company->value_added_tax / 100) * $total);
            }

            echo "الاجمالى قبل الخصم والضريبة : " . $totalBeforeTax . "  " . $currency . "
                    </td>";
            echo "<td>";

            foreach ($extras as $key) {
                if ($key->action == "discount") {
                    if ($key->action_type == "pound") {
                        echo " خصم " . $key->value . " " . $currency;
                    } else {
                        echo " خصم " . $key->value . " % ";
                    }
                } else {
                    echo "<span style='margin-right:30px;'>";
                    if ($key->action_type == "pound") {
                        echo " مصاريف شحن " . $key->value . " " . $currency;
                    } else {
                        echo " مصاريف شحن " . $key->value . " % ";
                    }
                    echo "</span>";
                }
            }
            echo "</td></tr>";
            $tax_value = ($tax_value_added / 100) * $total;
            $tax_value_added = $company->tax_value_added;
            $sum = array();
            foreach ($elements as $element) {
                array_push($sum, $element->quantity_price);
            }
            $total = array_sum($sum);
            $previous_extra = \App\Models\BuyBillExtra::where('buy_bill_id', $buy_bill->id)
                ->where('action', 'extra')->first();
            if (!empty($previous_extra)) {
                $previous_extra_type = $previous_extra->action_type;
                $previous_extra_value = $previous_extra->value;
                if ($previous_extra_type == "percent") {
                    $previous_extra_value = $previous_extra_value / 100 * $total;
                }
                $after_discount = $total + $previous_extra_value;
            }
            $previous_discount = \App\Models\BuyBillExtra::where('buy_bill_id', $buy_bill->id)
                ->where('action', 'discount')->first();
            if (!empty($previous_discount)) {
                $previous_discount_type = $previous_discount->action_type;
                $previous_discount_value = $previous_discount->value;
                if ($previous_discount_type == "percent") {
                    $previous_discount_value = $previous_discount_value / 100 * $total;
                }
                $after_discount = $total - $previous_discount_value;

            }
            if (!empty($previous_extra) && !empty($previous_discount)) {
                $after_discount = $total - $previous_discount_value + $previous_extra_value;
            } else {
                $after_discount = $total;
            }

            #---- chk if invoice is inclusive or exclusive to print tax_value.
            if ($buy_bill->value_added_tax) { // inclusive
                $tax_value = $after_discount - round(((100 / 115) * $after_discount), 2);

            } else // exclusive
                $tax_value = (($tax_value_added / 100) * $total);
            #----------------------.



            if (isset($after_discount) && $after_discount != 0) {
                # calc final_total with inserted tax if inclusive or exclusive.
                if ($buy_bill->value_added_tax == 0) {#exclusive
                    $percentage = ($tax_value_added / 100) * $after_discount;
                    $after_total_all = $after_discount + $percentage;
                } else # so its inclusive
                    $after_total_all = $after_discount;
            } else {
                # calc final_total with inserted tax if inclusive or exclusive.
                if ($buy_bill->value_added_tax == 0) {#exclusive
                    $percentage = ($tax_value_added / 100) * $total;
                    $after_total_all = $total + $percentage;
                } else # so its inclusive
                    $after_total_all = $total;
            }
            echo "<tr>
                    <td>ضريبة القيمة المضافة : ( " . $tax_value_added . "% ) </td>
                    <td>قيمة ضريبة القيمة المضافة    : " . $tax_value . " " . $currency . " </td>
                </tr>";
            echo "<tr>
                    <td>
اجمالى  الفاتورة بعد الخصم والضريبة :                         " . $after_total_all . " " . $currency . "
                    </td>";
            $cash = \App\Models\BuyCash::where('bill_id', $buy_bill->buy_bill_number)
                ->where('company_id', $company_id)
                ->where('supplier_id', $buy_bill->supplier_id)
                ->where('supplier_id', $buy_bill->supplier_id)
                ->first();
            $bank_cash = \App\Models\BankBuyCash::where('bill_id', $buy_bill->buy_bill_number)
                ->where('company_id', $company_id)
                ->where('supplier_id', $buy_bill->supplier_id)
                ->where('supplier_id', $buy_bill->supplier_id)
                ->first();
            if (!empty($cash)) {
                echo "<td>المبلغ المدفوع :  " . $cash->amount . " " . $currency . "</td>";
                $rest = $after_total_all - $cash->amount;
            } elseif (!empty($bank_cash)) {
                echo "<td>المبلغ المدفوع :  " . $bank_cash->amount . " " . $currency . "</td>";
                $rest = $after_total_all - $bank_cash->amount;
            } else {
                echo "<td>المبلغ المدفوع : 0 " . $currency . "</td>";
                $rest = $after_total_all;
            }
            echo "</tr>";
            echo "<tr style='text-align:center;'>
                    <td style='text-align:center;' colspan='2'> المبلغ المتبقى : " . $rest . " " . $currency . " </td>
                </tr>";
            echo "</table>";
            //<!-------------------------ROW3--INVOICE-DETAILS------------------------------->
            ?>

            <div class="clearfix"></div>
            <div class="visible-print text-center mt-2 mb-2">
                {!! SimpleSoftwareIO\QrCode\Facades\QrCode::size(50)->generate(Request::url()); !!}
            </div>
        </td>
    </tr>
    </tbody>
    <tfoot class="footer">
    <tr>
        <td>
            <img style="width: 90%; display: inline;float: left;" class="img-footer"
                 src="{{asset($company->basic_settings->footer)}}"/>
            <img style="width: 10%;display: inline;float: right; max-height: 60px;" class="img-footer"
                 src="{{asset($company->basic_settings->electronic_stamp)}}"/>
        </td>
    </tr>
    </tfoot>
</table>

<button onclick="window.print();" class="no-print btn btn-md btn-success text-white">اضغط للطباعة</button>
<a href="{{route('client.buy_bills.create')}}" class="no-print btn btn-md btn-danger text-white"> العودة الى فاتورة
    المشتريات </a>

<button class="show_hide_header text-white btn btn-dark btn-sm"
        style="height: 45px!important;bottom: 50px!important;left: 30px!important;font-size: 12px!important;">
    <i class="fa fa-eye-slash"></i>
    اظهار او اخفاء الهيدر
</button>
<button class="show_hide_footer text-white btn btn-dark btn-sm"
        style="height: 45px!important;left: 30px!important;font-size: 12px!important;">
    <i class="fa fa-eye-slash"></i>
    اظهار او اخفاء الفوتر
</button>
<script src="{{asset('app-assets/js/jquery.min.js')}}"></script>
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
