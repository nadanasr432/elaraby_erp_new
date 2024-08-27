<?php
$company = \App\Models\Company::FindOrFail($sale_bill->company_id);
$company_id = $company->id;
$extra_settings = \App\Models\ExtraSettings::where('company_id', $company->id)->first();
$currency = $extra_settings->currency;
$tax_value_added = $company->tax_value_added;
$print_demo = $company->print_demo;
?>
    <!DOCTYPE html>
<html>
<head>
    <title>
        @if (!empty($sale_bill->outer_client_id))
            <?php echo $sale_bill->OuterClient->client_name . " - فاتورة رقم " . $sale_bill->company_counter;  ?>
        @else
            <?php echo "فاتورة بيع نقدى" . " - فاتورة رقم " . $sale_bill->company_counter;  ?>
        @endif
    </title>
    <meta charset="utf-8"/>
    <link href="{{asset('/assets/css/bootstrap.min.css')}}" rel="stylesheet"/>
    <style type="text/css" media="screen">
        @font-face {
            font-family: 'Cairo';
            src: url({{asset('fonts/Cairo.ttf')}});
        }

        .alert-bordered {
            border: 1px solid #ddd;
        }

        * {
            color: #000 !important;
            font-size: 14px !important;
            font-weight: bold;

        }

        .img-footer {
            width: 100% !important;
            height: 100px !important;
            max-height: 100px !important;

        }

        body, html {
            font-family: 'Cairo' !important;
            font-weight: bold;
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
        body, html {
            font-family: 'Cairo' !important;
        }

        * {
            font-size: 14px !important;
            color: #000 !important;
            font-weight: bold !important;

        }

        .img-footer {

            width: 100% !important;
            height: 100px !important;
            max-height: 100px !important;

        }

        .no-print {
            display: none;
        }
    </style>
</head>
<body
    @if(App::getLocale() == 'ar')
    dir="rtl" style="text-align: right;background: #fff"
    @else
    dir="ltr" style="text-align: left;background: #fff"
    @endif
>
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
                @if (!empty($sale_bill->outer_client_id))
                    <span
                        style="font-size:18px;font-weight:bold; border:5px solid #333; padding: 5px 10px;  background-color:yellow;">فاتورة ضريبية TAX INVOICE</span>
                @else
                    <span
                        style="font-size:18px;font-weight:bold;border:3px solid #ddd; padding: 5px 10px; background-color:yellow;"> فاتورة ضريبية مبيعات نقدية </span>
                @endif
            </center>
            <?php
            $client_id = $sale_bill->client_id;
            $client = \App\Models\Client::FindOrFail($client_id);
            $branch = $client->branch;
            if ($branch) {
                $branch_address = $branch->branch_address;
                $branch_phone = $branch->branch_phone;
            } else {
                $branch_address = $company->company_address;
                $branch_phone = $company->phone_number;
            }
            ?>
            <hr style="border-bottom:1px solid #000;margin:5px auto; width: 90%;"/>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin:10px auto;">

                    <table class="table  table-bordered" style="font-size:12px;">
                        <tr>
                            <td>
                                @if(isset($print_demo) && !empty($print_demo->tax_number_ar)&& !empty($print_demo->tax_number_en))
                                    @if(App::getLocale() == 'ar')
                                        {{$print_demo->tax_number_ar}}
                                    @else
                                        {{$print_demo->tax_number_en}}
                                    @endif
                                @else
                                    اسم المؤسسة
                                @endif
                            </td>
                            <td colspan="2">{{$company->company_name}}</td>
                            <td>
                                @if(isset($print_demo) && !empty($print_demo->bill_date_ar) && !empty($print_demo->bill_date_en))
                                    @if(App::getLocale() == 'ar')
                                        {{$print_demo->bill_date_ar}}
                                    @else
                                        {{$print_demo->bill_date_en}}
                                    @endif
                                @else
                                    رقم الفاتورة
                                @endif
                            </td>
                            <td>{{$sale_bill->company_counter}}</td>
                            <td>
                                @if(isset($print_demo) && !empty($print_demo->commercial_number_ar)&& !empty($print_demo->commercial_number_en))
                                    @if(App::getLocale() == 'ar')
                                        {{$print_demo->commercial_number_ar}}
                                    @else
                                        {{$print_demo->commercial_number_en}}
                                    @endif
                                @else
                                    تاريخ الفاتورة
                                @endif
                            </td>
                            <td colspan="2">{{$sale_bill->date}}</td>

                        </tr>
                        <tr>
                            <td>
                                @if(isset($print_demo) && !empty($print_demo->bill_id_ar)&& !empty($print_demo->bill_id_en))
                                    @if(App::getLocale() == 'ar')
                                        {{$print_demo->bill_id_ar}}
                                    @else
                                        {{$print_demo->bill_id_en}}
                                    @endif

                                @else
                                    العنوان
                                @endif
                            </td>
                            <td colspan="2">{{$branch_address}}</td>
                            <td>
                                @if(isset($print_demo) && !empty($print_demo->company_address_ar)&& !empty($print_demo->company_address_en))
                                    @if(App::getLocale() == 'ar')
                                        {{$print_demo->company_address_ar}}
                                    @else
                                        {{$print_demo->company_address_en}}
                                    @endif

                                @else
                                    السجل التجارى
                                @endif
                            </td>

                            <td>
                                @if(!empty($client->branch_id))
                                    {{$branch->commercial_registration_number}}
                                @endif
                            </td>
                            <td>
                                @if(isset($print_demo) && !empty($print_demo->civil_number_ar)&& !empty($print_demo->civil_number_en))
                                    @if(App::getLocale() == 'ar')
                                        {{$print_demo->civil_number_ar}}
                                    @else
                                        {{$print_demo->civil_number_en}}
                                    @endif

                                @else
                                    الرقم الضريبى
                                @endif
                            </td>
                            <td colspan="2">{{$company->tax_number}}</td>


                        </tr>
                        <tr>
                            <td>
                                @if(isset($print_demo) && !empty($print_demo->company_phone_number_ar)&& !empty($print_demo->company_phone_number_en))
                                    @if(App::getLocale() == 'ar')
                                        {{$print_demo->company_phone_number_ar}}
                                    @else
                                        {{$print_demo->company_phone_number_en}}
                                    @endif
                                @else
                                    رقم الجوال
                                @endif
                            </td>
                            <td colspan="2">{{$branch_phone}}</td>
                            <td></td>
                            <td>
                                @if(isset($print_demo) && !empty($print_demo->client_name_ar)&& !empty($print_demo->client_name_en))
                                    @if(App::getLocale() == 'ar')
                                        {{$print_demo->client_name_ar}}
                                    @else
                                        {{$print_demo->client_name_en}}
                                    @endif
                                @else
                                    اسم مزود الخدمة
                                @endif
                            </td>
                            <td colspan="2">{{$sale_bill->client->name}}</td>

                        </tr>
                    </table>
                </div>
                @if (!empty($sale_bill->outer_client_id))
                    <div class="col-lg-12">
                        <table class="table table-bordered" style="font-size:12px;">
                            <tr class="text-center">
                                <td colspan="6">بيانات العميل</td>
                            </tr>
                            <tr>
                                <td>
                                    @if(isset($print_demo) && !empty($print_demo->outer_client_name_ar)&& !empty($print_demo->outer_client_name_en))
                                        @if(App::getLocale() == 'ar')
                                            {{$print_demo->outer_client_name_ar}}
                                        @else
                                            {{$print_demo->outer_client_name_en}}
                                        @endif
                                    @else
                                        الاسم
                                    @endif
                                </td>
                                <td>{{$sale_bill->OuterClient->client_name}}</td>
                                <td>
                                    @if(isset($print_demo) && !empty($print_demo->outer_client_address_ar)&& !empty($print_demo->outer_client_address_en))
                                        @if(App::getLocale() == 'ar')
                                            {{$print_demo->outer_client_address_ar}}
                                        @else
                                            {{$print_demo->outer_client_address_en}}
                                        @endif
                                    @else
                                        العنوان
                                    @endif
                                </td>
                                <td colspan="3">
                                    @if(!empty($sale_bill->OuterClient->addresses[0]))
                                        {{$sale_bill->OuterClient->addresses[0]->client_address}}
                                    @endif

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    @if(isset($print_demo) && !empty($print_demo->outer_client_phone_ar)&& !empty($print_demo->outer_client_phone_en))
                                        @if(App::getLocale() == 'ar')
                                            {{$print_demo->outer_client_phone_ar}}
                                        @else
                                            {{$print_demo->outer_client_phone_en}}
                                        @endif
                                    @else
                                        رقم الجوال
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($sale_bill->OuterClient->phones[0]))
                                        {{$sale_bill->OuterClient->phones[0]->client_phone}}
                                    @endif
                                </td>
                                <td>
                                    @if(isset($print_demo) && !empty($print_demo->outer_client_tax_number_ar)&& !empty($print_demo->outer_client_tax_number_en))
                                        @if(App::getLocale() == 'ar')
                                            {{$print_demo->outer_client_tax_number_ar}}
                                        @else
                                            {{$print_demo->outer_client_tax_number_en}}
                                        @endif
                                    @else
                                        الرقم الضريبى
                                    @endif
                                </td>
                                <td>{{$sale_bill->OuterClient->tax_number}}</td>
                            </tr>
                        </table>
                    </div>
                @endif
            </div>
            <?php
            $sum = array();

            $extras = $sale_bill->extras;
            if (!$elements->isEmpty()) {
                echo '<h6 class="alert alert-sm alert-info text-center">
                        <i class="fa fa-info-circle"></i>
             <span style="font-size:18px;font-weight:bold; border:5px solid #333; padding: 5px 20px; background-color:yellow;">بيانات عناصر الفاتورة رقم ' . $sale_bill->company_counter . '  </span>
                </h6>';
                $i = 0;
                echo "<div class='table-responsive'>";
                echo "<table style='width:100%;text-align:center' class='table table-bordered'>";
                echo "<thead class='text-center bg-primary' style='text-align:center;'>";
                echo "<td style='border:2px solid #000;font-family:Cairo !important;'>م</td>";

                if (isset($print_demo) && !empty($print_demo->product_code_ar) && !empty($print_demo->product_code_en)) {
                    if (App::getLocale() == 'ar') {
                        echo "<td style='border:2px solid #000;font-family:Cairo !important;'> " . $print_demo->product_code_ar . " </td>";
                    } else {
                        echo "<td style='border:2px solid #000;font-family:Cairo !important;'> " . $print_demo->product_code_en . " </td>";
                    }
                } else {
                    echo "<td style='border:2px solid #000;font-family:Cairo !important;'>الكود</td>";
                }
                if (isset($print_demo) && !empty($print_demo->product_model_ar) && !empty($print_demo->product_model_en)) {
                    if (App::getLocale() == 'ar') {
                        echo "<td style='border:2px solid #000;font-family:Cairo !important;'> " . $print_demo->product_model_ar . " </td>";
                    } else {
                        echo "<td style='border:2px solid #000;font-family:Cairo !important;'> " . $print_demo->product_model_en . " </td>";
                    }
                } else {
                    echo "<td style='border:2px solid #000;font-family:Cairo !important;'>الموديل</td>";
                }
                if (isset($print_demo) && !empty($print_demo->product_name_ar) && !empty($print_demo->product_name_en)) {
                    if (App::getLocale() == 'ar') {
                        echo "<td style='border:2px solid #000;font-family:Cairo !important;'> " . $print_demo->product_name_ar . " </td>";
                    } else {
                        echo "<td style='border:2px solid #000;font-family:Cairo !important;'> " . $print_demo->product_name_en . " </td>";
                    }
                } else {
                    echo "<td style='border:2px solid #000;font-family:Cairo !important;'>بيانات المنتج</td>";
                }
                if (isset($print_demo) && !empty($print_demo->quantity_ar) && !empty($print_demo->quantity_en)) {
                    if (App::getLocale() == 'ar') {
                        echo "<td style='border:2px solid #000;font-family:Cairo !important;'> " . $print_demo->quantity_ar . " </td>";
                    } else {
                        echo "<td style='border:2px solid #000;font-family:Cairo !important;'> " . $print_demo->quantity_en . " </td>";
                    }
                } else {
                    echo "<td style='border:2px solid #000;font-family:Cairo !important;'>العدد</td>";
                }
                if (isset($print_demo) && !empty($print_demo->unit_price_ar) && !empty($print_demo->unit_price_en)) {
                    if (App::getLocale() == 'ar') {
                        echo "<td style='border:2px solid #000;font-family:Cairo !important;'> " . $print_demo->unit_price_ar . " </td>";
                    } else {
                        echo "<td style='border:2px solid #000;font-family:Cairo !important;'> " . $print_demo->unit_price_en . " </td>";
                    }
                } else {
                    echo "<td style='border:2px solid #000;font-family:Cairo !important;'>سعر الوحدة</td>";
                }
                if (isset($print_demo) && !empty($print_demo->quantity_price_ar) && !empty($print_demo->quantity_price_en)) {
                    if (App::getLocale() == 'ar') {
                        echo "<td style='border:2px solid #000;font-family:Cairo !important;'> " . $print_demo->quantity_price_ar . " </td>";
                    } else {
                        echo "<td style='border:2px solid #000;font-family:Cairo !important;'> " . $print_demo->quantity_price_en . " </td>";
                    }
                } else {
                    echo "<td style='border:2px solid #000;font-family:Cairo !important;'>سعر الاجمالى</td>";
                }

                echo "</thead>";
                echo "<tbody>";
                foreach ($elements as $element) {
                    array_push($sum, $element->quantity_price);
                    echo "<tr>";
                    echo "<td style='border:2px solid #000;'>" . ++$i . "</td>";
                    echo "<td style='border:2px solid #000;'>" . $element->product->code_universal . "</td>";
                    echo "<td style='border:2px solid #000;'>" . $element->product->product_model . "</td>";
                    echo "<td style='border:2px solid #000;'>" . $element->product->product_name . "</td>";
                    if (!empty($element->unit_id)) {
                        echo "<td style='border:2px solid #000;'>" . $element->quantity . " " . $element->unit->unit_name . "</td>";
                    } else {
                        echo "<td style='border:2px solid #000;'>" . $element->quantity . "</td>";
                    }
                    echo "<td style='border:2px solid #000;'>" . $element->product_price . "</td>";
                    echo "<td style='border:2px solid #000;'>" . $element->quantity_price . "</td>";
                    echo "</tr>";
                }

                if ($company_id == 20) {
                    echo "
                        <tr>
                            <td style='border:2px solid #000;'colspan='7'>
                                ملاحظات :
                                شروط الاسترجاع والاستبدال (السيراميك و البورسلين):1-يجب علي العميل احضار الفاتورة الأصلية عند الارجاع أو الإستبدال ويبين سبب الإرجاع أو الإستبدال,2- يتم ارجاع او تبديل البضاعة خلال (۳۰) ثلاثين يوما من تاريخ إصدار الفاتورة,3-عند ارجاع أي كمية يتم إعادة شرائها من العميل باقل من (۱۰% ) من قيمتها الأصلية,4-,يجب ان تكون البضاعة في حالتها الأصلية أي سليمة وخالية من أي عيوب وضمن عبواتها أي (كرتون كامل)  للاسترجاع أو الاستبدال و يتم معاينتها للتأكد من سلامتها من قبل موظف المستودع,5- يقوم العميل بنقل البضاعة المرتجعة على حسابه من الموقع إلى مستودعاتنا حصرا خلال أوقات دوام المستودع ما عدا يوم الجمعة ولا يتم قبول أي مرتجع في الصالات المخصصة للعرض و البيع, 6- تم استرجاع أو تبدیل مواد الغراء والروبة أو الأصناف التجارية أو الاستكات أو المغاسل أو الاكسسوارات خلال ٢٤ ساعة من تاريخ إصدارالفاتورة وبحالتها الأصلية ولا يتم استرجاع أجور القص وقيمة البضاعة التي تم قصها بناء على طلب العميل (المذكورة في الفاتورة).
                                (الرخام ):عند ارجاع أي كمية يتم إعادة شرائها من العميل بأقل (15 %) من قيمتها الأصلية مع إحضار الفاتورة الأصلية,يتم الإرجاع للبضاعة السليمة ضمن عبوتها الأصلية على أن تكون طبلية مقفلة من الرخام وخلال 30 يوما من تاريخ الفاتورة كحد أقصى ولا يقبل ارجاع طلبية مفتوحة من الرخام ولا نقبل بارجاع الرخام المقصوص حسب طلب العميل درج/ سلكو/ألواح
                            </td>
                        </tr>";
                } else {
                    echo "
                        <tr>
                            <td style='border:2px solid #000;text-align:right;'colspan='7'>
                                ملاحظات :
                                " . $sale_bill->notes . "
                            </td>
                        </tr>";
                }

                echo "</tbody>";
                echo "</table>";
                echo "</div>";
                $total = array_sum($sum);
                $percentage = ($tax_value_added / 100) * $total;
                $after_total = $total + $percentage;
                $tax_option = $sale_bill->value_added_tax;
                if ($tax_option == 1) {
                    $total = $total * (100 / 115);
                    $total_with_option = $total;
                    $percentage = (15 / 100) * $total_with_option;
                    $after_total = $percentage + $total_with_option;
                }

                $previous_discount = \App\Models\SaleBillExtra::where('sale_bill_id', $sale_bill->id)
                    ->where('action', 'discount')->first();
                if ($previous_discount->action_type != "poundAfterTax" && $previous_discount->action_type != "poundAfterTaxPercent") {
                    $disVall = $previous_discount->action_type == 'pound' ? $previous_discount->value : ($previous_discount->value * array_sum($sum) / 100);
                    $totalAfterDisountt = $total - $disVall;
                } else {
                    if ($previous_discount->action_type == "poundAfterTaxPercent")
                        $totalAfterDisountt = $total - (($previous_discount->value * $total) / 100);
                    else
                        $totalAfterDisountt = $total - $previous_discount->value;
                }
            }

            echo "<table class='table table-bordered' style='font-size:12px;'>
                <tr>
                    <td>الاجمالي بدون الضريبة: " . round($totalAfterDisountt, 2) . "  " . $currency . "</td>";
            echo "<td>";
            foreach ($extras as $key) {
                if ($key->action == "discount") {
                    if ($key->action_type == "pound") {
                        echo " خصم " . $key->value . " " . $currency;
                    } elseif ($key->action_type == "percent") {
                        echo " خصم " . $key->value . " % ";
                        echo "<span style='margin-right:20px;border-right:1px solid gray;padding-right: 15px;'>
                            " . round(($key->value * $total) / 100, 2) . " $currency
                            </span>";

                        if (!empty($extras[0]->discount_note))
                            echo "<span style='margin-right:20px;border-right:1px solid gray;padding-right: 15px;'>
                            " . $extras[0]->discount_note . "
                            </span>";
                    } else if ($key->action_type == "afterTax") {
                        echo " خصم " . $key->value . " % ";
                        echo "<span style='margin-right:20px;border-right:1px solid gray;padding-right: 15px;'>
                            " . round(($key->value * $total) / 100, 2) . " $currency
                            </span>";

                        if (!empty($extras[0]->discount_note))
                            echo "<span style='margin-right:20px;border-right:1px solid gray;padding-right: 15px;'>
                            " . $extras[0]->discount_note . "
                            </span>";
                    } else {
                        if ($key->action_type == "poundAfterTax")
                            echo " خصم " . $key->value . " $currency";
                        else {
                            $totDis = ($key->value * $total) / 100;
                            echo " خصم %" . $key->value . " - (" . $totDis . " $currency) ";
                        }
                    }
                    echo (' || ' . $previous_discount->discount_note) ?? '';

                }
            }
            echo "</td></tr>";
            $tax_value_added = $company->tax_value_added;
            $sum = array();
            foreach ($elements as $element) {
                array_push($sum, $element->quantity_price);
            }
            $total = array_sum($sum);
            $previous_extra = \App\Models\SaleBillExtra::where('sale_bill_id', $sale_bill->id)
                ->where('action', 'extra')->first();
            if (!empty($previous_extra)) {
                $previous_extra_type = $previous_extra->action_type;
                $previous_extra_value = $previous_extra->value;
                if ($previous_extra_type == "percent" || $previous_extra_type == "afterTax") {
                    $previous_extra_value = $previous_extra_value / 100 * $total;
                }
                $after_discount = $total + $previous_extra_value;
            }
            $previous_discount = \App\Models\SaleBillExtra::where('sale_bill_id', $sale_bill->id)
                ->where('action', 'discount')->first();
            if (!empty($previous_discount)) {
                $previous_discount_type = $previous_discount->action_type;
                $previous_discount_value = $previous_discount->value;
                if ($previous_discount_type == "percent" || $previous_discount_type == "afterTax") {
                    $previous_discount_value = $previous_discount_value / 100 * $total;
                }

                if ($previous_discount_type != "poundAfterTax" && $previous_discount_type != "poundAfterTaxPercent")
                    $after_discount = $total - $previous_discount_value;

            }
            if (!empty($previous_extra) && !empty($previous_discount)) {
                if ($previous_discount_type != "poundAfterTax" && $previous_discount_type != "poundAfterTaxPercent")
                    $after_discount = $total - $previous_discount_value + $previous_extra_value;
            } else {
                $after_discount = $total;
            }

            $tax_value = $tax_value_added / 100 * $after_discount;
            if (isset($after_discount) && $after_discount != 0) {
                $percentage = ($tax_value_added / 100) * $after_discount;
                $after_total_all = $after_discount + $percentage;
            } else {
                $percentage = ($tax_value_added / 100) * $after_discount;
                $after_total_all = $after_discount + $percentage;
            }

            $tax_option = $sale_bill->value_added_tax;
            if ($tax_option == 1) {
                $sum = $after_total * (100 / 115);
                $sum_with_option = $sum;
                $tax_value = (15 / 100) * $sum_with_option;
                $after_total_all = $tax_value + $sum_with_option;
            }

            /***********
            if ($previous_discount_type != "poundAfterTax" && $previous_discount_type != "poundAfterTaxPercent") {
            echo "<tr>
            <td>ضريبة القيمة المضافة : ( " . $tax_value_added . "% ) </td>
            <td> " . round((is_array($sum) ? (($sum[0]) * 15 / 100) : $sum * 15 / 100), 2) . " " . $currency . " </td>
            </tr>";
            } else {
            echo "<tr>
            <td>ضريبة القيمة المضافة : ( " . $tax_value_added . "% ) </td>
            <td> " . round($tax_value, 2) . " " . $currency . " </td>
            </tr>";
            }
             ***********/


            echo "<tr>
                <td>ضريبة القيمة المضافة : ( " . $tax_value_added . "% ) </td>
                <td> " . round($sale_bill->final_total - $totalAfterDisountt, 2) . " " . $currency . " </td>
            </tr>";

            echo "<tr>
                <td>  الاجمالي شامل الضريبة   :  " . $sale_bill->final_total . " " . $currency . "</td>";
            $cash_id = $sale_bill->sale_bill_number;
            $cash = \App\Models\Cash::where('bill_id', $cash_id)->get();
            if (!$cash->isEmpty()) {
                $cash_amount = 0;
                foreach ($cash as $item) {
                    $cash_amount = $cash_amount + $item->amount;
                }
            } else {
                $cash_amount = 0;
            }
            $bank_cash = \App\Models\BankCash::where('bill_id', $cash_id)->get();
            if (!$bank_cash->isEmpty()) {
                $cash_bank_amount = 0;
                foreach ($bank_cash as $item) {
                    $cash_bank_amount = $cash_bank_amount + $item->amount;
                }
            } else {
                $cash_bank_amount = 0;
            }
            $total_amount = $cash_amount + $cash_bank_amount;
            if ($previous_discount_type == "poundAfterTax" || $previous_discount_type == "poundAfterTaxPercent")
                $rest = $sale_bill->final_total - $total_amount;
            else
                $rest = $after_total_all - $total_amount;
            //*******************validation***********************
            $rest = $rest < 0 ? 0 : $rest;

            echo "<td>المبلغ المدفوع  :  " . $total_amount . " " . $currency . "</td>";
            echo "</tr>";
            echo "<tr style='text-align:center;'>
                    <td style='border:2px solid #000;''text-align:center;' colspan='2'> المبلغ المتبقى : " . $rest . " " . $currency . " </td>
                </tr>";
            echo "</table>";
            ?>
            @if(!$sale_bill->sale_bill_notes->isEmpty())
                <p class="alert alert-default alert-bordered alert-md">
                    ملاحظات اضافية على الفاتورة :-
                    <br>
                    @foreach($sale_bill->sale_bill_notes as $note)
                        - {{$note->notes}}
                        <br>
                    @endforeach
                </p>
            @endif

            <div class="clearfix"></div>
            <div class="text-center mt-2 mb-2">
            <!--{!! SimpleSoftwareIO\QrCode\Facades\QrCode::size(80)->generate(Request::url()); !!}-->
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
                    new InvoiceDate($sale_bill->date . " " . $sale_bill->time), // invoice date as Zulu ISO8601 @see https://en.wikipedia.org/wiki/ISO_8601
                    new InvoiceTotalAmount($after_total_all), // invoice total amount
                    new InvoiceTaxAmount($tax_value) // invoice tax amount
                    // TODO :: Support others tags
                ])->render();
                ?>
                @if(!$isMoswada)
                    <img src="{{$displayQRCodeAsBase64}}" style="width: 150px; height: 110px;" alt="QR Code"/>
                @endif

                <img style="width: 170px!important;height: 140px!important;"
                     src="{{asset($company->basic_settings->electronic_stamp)}}"/>
            </div>
        </td>
    </tr>
    @if(!empty($company->basic_settings->sale_bill_condition))
        <tr>
            <td>
                <div class="products-details p-2 col-12">
                    <table
                        style="width: 100%;width: 100%; border-radius: 8px !important; overflow: hidden; border: 1px solid;box-shadow: rgb(99 99 99 / 20%) 0px 2px 0px 0px;">
                        <tbody>
                        <tr style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 15px !important; height: 44px !important; text-align: center;background: #007bff;color:white;">
                            <td style="text-align: right;padding-right: 14px;" colspan="2">الشروط والاحكام</td>
                        </tr>
                        <tr style="border-bottom:1px solid #2d2d2d30;font-weight: bold;font-size: 15px !important; height: 49px !important; text-align: center;background: #f2f2f2">
                            <td style="text-align: right;padding-right: 14px;direction: rtl;padding-top: 15px;">{!! $company->basic_settings->sale_bill_condition !!}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </td>

        </tr>
    @endif
    </tbody>
    <tfoot class="footer">
    <tr>
        <td>
            <img style="width: 90%; display: inline;float: left;" class="img-footer"
                 src="{{asset($company->basic_settings->footer)}}"/>
        </td>
    </tr>
    </tfoot>
</table>
<button onclick="window.print();" class="no-print btn btn-md btn-success text-white">اضغط للطباعة</button>
<a href="{{route('client.sale_bills.create')}}" class="no-print btn btn-md btn-danger text-white"> العودة الى فاتورة
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
