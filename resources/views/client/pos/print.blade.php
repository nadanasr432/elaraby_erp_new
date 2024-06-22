<!DOCTYPE html>
<html>
<head>
    <title>
        <?php echo " فاتورة مبيعات ضريبية رقم " . $pos->id;  ?>
    </title>
    <meta charset="utf-8"/>
    <link href="{{asset('/app-assets/css-rtl/bootstrap.min.css')}}" rel="stylesheet"/>
    <style type="text/css" media="screen">
        @font-face {
            font-family: 'Cairo';
            src: url("{{asset('fonts/Cairo.ttf')}}");
        }

        * {
            color: #000 !important;
        }


        body, html {
            color: #000;
            font-family: 'Cairo' !important;
            font-size: 19px !important;
            font-weight: bold;
            margin: 10;
            padding: 0px;
            page-break-before: avoid;
            page-break-after: avoid;
            page-break-inside: avoid;
        }

        .no-print {
            position: fixed;
            bottom: 0;
            color: #fff !important;
            left: 30px;
            height: 40px !important;
            border-radius: 0;
            padding-top: 10px;
            z-index: 9999;
        }

        table thead tr, table tbody tr {
            border-bottom: 2px solid #aaa;
        }

        table {
            text-align: right;
            width: 20% !important;
            margin-top: 10px !important;
        }
    </style>
    <style type="text/css" media="print">
        table {
            text-align: right;
            width: 100% !important;
            margin-top: 10px !important;
        }

        table thead tr, table tbody tr {
            border-bottom: 1px solid #aaa;
        }

        * {
            color: #000 !important;
        }

        body, html {
            color: #000;
            padding: 5px;
            margin: 5;
            font-family: 'Cairo' !important;
            font-size: 15px !important;
            font-weight: bold;
            page-break-before: avoid;
            page-break-after: avoid;
            page-break-inside: avoid;
        }

        .pos_details {
            width: 100% !important;
            page-break-before: avoid;
            page-break-after: avoid;
            page-break-inside: avoid;
        }

        .no-print {
            display: none;
        }
    </style>
</head>
<body dir="rtl" style="background: #fff;
            page-break-before: avoid;
            page-break-after: avoid;
            page-break-inside: avoid;" class="text-right">
<div class="pos_details">
    <div class="text-right">
        <img class="logo" style="width: 80px;height: 80px;margin-top: 5px;"
             src="{{asset($pos->company->company_logo)}}"
             alt="">
    </div>
    <div class="text-right mt-3">
        <div class="text-right">
            الاسم :
            {{$pos->company->company_name}} <br>
            العنوان :
            {!! $branch_address !!} <br>
            الهاتف :
            {!! $branch_phone !!} <br>
            الرقم الضريبى :
            {!! $pos->company->tax_number !!}
        </div>
    </div>
    <div class="text-right mt-3">
        <div class="text-right">
            نوع الفاتورة :
            فاتورة ضريبية مبسطة
            <br>
            رقم الفاتورة :
            {{$pos->id}}
            <br>
            اسم البائع :
            {{$pos->client->name}}
        </div>
    </div>
    <div class="text-right mt-3">
        <div class="text-right">
            تاريخ - وقت :
            {{$pos->created_at}}
            <br>
            اسم المشترى :
            @if(isset($pos->outerClient->client_name))
                {{$pos->outerClient->client_name}}
                <br/>
                الرقم الضريبى للمشترى :
                {{$pos->outerClient->tax_number}}
            @else
                زبون
            @endif


        </div>
    </div>

    <div class="text-right mt-1">
        <div class="text-right">
            طريقة الدفع :
            @if(isset($pos->id))
                @php
                    if(count(App\Models\Cash::where('bill_id',"pos_". $pos->id)->get())){
                        echo 'كاش';
                    }elseif(count(App\Models\BankCash::where('bill_id',"pos_". $pos->id)->get())){
                        echo 'شبكة';
                    }else{
                        echo '-';
                    }
                @endphp
            @endif
        </div>
    </div>
    @if(isset($pos->tableNum) && $pos->tableNum != 0)
        <div class="text-right mt-1">
            <div class="text-right">
                رقم الطاولة :
                {{$pos->tableNum}}
            </div>
        </div>
    @endif

    <div class="text-right mt-3">
        <table dir="rtl">
            <thead>
            <tr style="border: 1px solid #aaa">
                <td style='border: 1px solid #aaa'>سعر*كميه Qty*P</td>
                <td style='border: 1px solid #aaa'>صنف  Cate</td>
                <td style='border: 1px solid #aaa'>الخصم Dis</td>
                <td style='border: 1px solid #aaa'>اجمالى Total </td>
            </tr>
            </thead>
            <tbody>
            <?php
            $pos_elements = $pos->elements;
            $totalDiscountOnEveryElement = 0;
            ?>
            @if(isset($pos) && isset($pos_elements) && !$pos_elements->isEmpty())
                <?php
                foreach ($pos_elements as $element) {
                    $totalDiscountOnEveryElement += $element->discount;
                    echo "<tr style='border: 1px solid #aaa;'>";
                    echo "<td style='border: 1px solid #aaa;' dir='ltr'><span>" . $element->quantity . " </span> X <span>" . $element->product_price . "</span></td>";
                    echo "<td style='border: 1px solid #aaa;'>" . $element->product->product_name . "</td>";
                    echo "<td style='border: 1px solid #aaa;'>" . $element->discount . "</td>";
                    echo "<td style='border: 1px solid #aaa;'>" . $element->quantity_price . "</td>";
                    echo "</tr>";
                }
                ?>
            @endif
            </tbody>
        </table>
        <div class="clearfix"></div>
        <table dir="rtl">
            <tr>
                <td> البنود</td>
                <td class="text-left">
                    <span class="text-left">
                        @if(isset($pos) && !$pos_elements->isEmpty())
                            {{$pos_elements->count()}}
                            <?php
                            $sum = 0;
                            foreach ($pos_elements as $pos_element) {
                                $sum = $sum + $pos_element->quantity;
                            }
                            ?>
                        @else
                            0
                        @endif
                    </span>
                </td>
            </tr>
            <tr>
                <td> الاجمالي قبل الضريبة | Total</td>
                <td class="text-left">
                    <span class="text-left">
                        <?php $inclusiveTax = 0;?>
                        @if(isset($pos) && !$pos_elements->isEmpty())
                            <?php
                            $sum = 0;
                            foreach ($pos_elements as $pos_element) {
                                $sum = $sum + $pos_element->quantity_price;
                            }
                            ?>
                            @if($pos->value_added_tax)
                                {{round($sum * (100/ 115),2)}}
                                <?php $inclusiveTax = $sum - round($sum * (100 / 115), 2); ?>
                            @else
                                {{round($sum,2)}}
                            @endif
                        @else
                            0
                        @endif
                    </span>
                </td>
            </tr>
            <tr>
                <td>
                    قيمة الضريبة | vat
                </td>
                <td class="text-left">
                    <span class="text-left">
                        <?php
                        $pos_tax = $pos->tax;

                        $pos_discount = $pos->discount;
                        ?>
                        @if(isset($pos) && isset($pos_tax) && !empty($pos_tax))
                            <?php
                            $tax_value = $pos_tax->tax_value;
                            $sum = 0;
                            foreach ($pos_elements as $pos_element) {
                                $sum = $sum + $pos_element->quantity_price;
                            }
                            if (isset($pos) && isset($pos_discount) && !empty($pos_discount)) {
                                $discount_value = $pos_discount->discount_value;
                                $discount_type = $pos_discount->discount_type;
                                if ($discount_type == "pound") {
                                    $sum = $sum - $discount_value;
                                } else {
                                    $discount_value = ($discount_value / 100) * $sum;
                                    $sum = $sum - $discount_value;
                                }
                            }

                            $percent = $tax_value / 100 * $sum;
                            ?>
                            @if($pos_tax && $pos_tax->tax_value == 130)
                                <?php
                                $taxEntka2ya = ($sum * 2) * (15 / 100);
                                $percent = $taxEntka2ya;
                                ?>
                            @endif
                            @if($pos->value_added_tax)
                                {{round($inclusiveTax, 2)}}
                            @else
                                {{round($percent, 2)}}
                            @endif

                        @else
                            <?php $percent = 0; ?>

                            @if($pos->value_added_tax)
                                {{$inclusiveTax}}
                            @else
                                {{$percent}}
                            @endif
                        @endif
                    </span>
                </td>
            </tr>
            @if($pos_tax && $pos_tax->tax_value == 130)
                <?php
                $taxEntka2ya = $sum * (15 / 100);
                ?>
                <tr>
                    <td>
                        رسوم التبغ
                    </td>
                    <td class="text-left">
                        {{round($sum,2)}}
                    </td>
                </tr>


            @endif
            <tr>
                <td>
                    قيمة الخصم | discount
                </td>
                <td class="text-left">
                    <span class="text-left">
                        @if(isset($pos) && !empty($pos_discount))
                            <?php
                            $discount_value = $pos_discount->discount_value;
                            $discount_type = $pos_discount->discount_type;
                            $sum = 0;
                            foreach ($pos_elements as $pos_element) {
                                $sum = $sum + $pos_element->quantity_price;
                            }
                            if ($discount_type == "pound") {
                                echo $discount_value + $totalDiscountOnEveryElement;
                            } else {
                                $discount_value = ($discount_value / 100) * $sum;
                                echo $discount_value + $totalDiscountOnEveryElement;
                            }
                            ?>
                        @else
                            {{$totalDiscountOnEveryElement}}
                        @endif
                    </span>
                </td>
            </tr>
            <tr>
                <td>
                    الاجمالى النهائى | Total+Vat
                </td>
                <td class="text-left">
                    <span class="text-left">
                       @if(isset($pos))
                            <?php
                            $sum = 0;
                            foreach ($pos_elements as $pos_element) {
                                $sum = $sum + $pos_element->quantity_price;
                            }
                            if (isset($pos) && isset($pos_tax) && empty($pos_discount)) {
                                $tax_value = $pos_tax->tax_value;
                                $percent = $tax_value / 100 * $sum;
                                $sum = $sum + $percent;
                            } elseif (isset($pos) && isset($pos_discount) && empty($pos_tax)) {
                                $discount_value = $pos_discount->discount_value;
                                $discount_type = $pos_discount->discount_type;
                                if ($discount_type == "pound") {
                                    $sum = $sum - $discount_value;
                                } else {
                                    $discount_value = ($discount_value / 100) * $sum;
                                    $sum = $sum - $discount_value;
                                }
                            } elseif (isset($pos) && !empty($pos_discount) && !empty($pos_tax)) {
                                $tax_value = $pos_tax->tax_value;

                                $discount_value = $pos_discount->discount_value;
                                $discount_type = $pos_discount->discount_type;
                                if ($discount_type == "pound") {
                                    $sum = $sum - $discount_value;
                                } else {
                                    $discount_value = ($discount_value / 100) * $sum;
                                    $sum = $sum - $discount_value;
                                }
                                $percent = $tax_value / 100 * $sum;
                                $sum = $sum + $percent;

                            }
                            echo round($sum, 2);
                            ?>
                        @else
                            0
                        @endif
                    </span>
                </td>
            </tr>

            <tr>
                <td> المبلغ المدفوع | paid</td>
                <td class="text-left">
                    <?php
                    $cash_id = "pos_" . $pos->id;

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

                    $coupon_cash = \App\Models\CouponCash::where('bill_id', $cash_id)->get();
                    if (!$coupon_cash->isEmpty()) {
                        $cash_coupon_amount = 0;
                        foreach ($coupon_cash as $item) {
                            $cash_coupon_amount = $cash_coupon_amount + $item->amount;
                        }
                    } else {
                        $cash_coupon_amount = 0;
                    }

                    $total_amount = $cash_amount + $cash_bank_amount + $cash_coupon_amount;
                    $rest = $sum - $total_amount;
                    echo round($total_amount, 2);

                    ?>
                </td>
            </tr>

            <tr>
                <td> المتبقى | the rest</td>
                <td class="text-left">
                    <?php
                    echo round($rest, 2);
                    ?>
                </td>
            </tr>
        </table>
        <div class="clearfix"></div>
        <div class="visible-print text-right mt-2 mr-2">

            <?php
            use Salla\ZATCA\GenerateQrCode;
            use Salla\ZATCA\Tags\InvoiceDate;
            use Salla\ZATCA\Tags\InvoiceTaxAmount;
            use Salla\ZATCA\Tags\InvoiceTotalAmount;
            use Salla\ZATCA\Tags\Seller;
            use Salla\ZATCA\Tags\TaxNumber;
            $displayQRCodeAsBase64 = GenerateQrCode::fromArray([
                new Seller($pos->company->company_name), // seller name
                new TaxNumber($pos->company->tax_number), // seller tax number
                new InvoiceDate($pos->created_at), // invoice date as Zulu ISO8601 @see https://en.wikipedia.org/wiki/ISO_8601
                new InvoiceTotalAmount($sum), // invoice total amount
                new InvoiceTaxAmount($percent) // invoice tax amount
                // TODO :: Support others tags
            ])->render();
            ?>
            <style type="text/css">
                .centerImage {
                    text-align: center;
                    display: block;
                }
            </style>
            <img src="{{$displayQRCodeAsBase64}}" style="width: 150px; height: 150px;" alt="QR Code"/>
            <br>
            <tr>*البضاعة المباعة لا ترد ولا تستبدل <br>بدون أصل الفاتورة !تسعدنا خدمتكم..*</tr>
        </div>
    </div>
</div>
<button onclick="window.print();" style="width: 150px; height: 150px; class="no-print btn btn-md btn-success">اضغط للطباعة</button>
<a href="{{route('client.pos.create')}}" class="no-print btn btn-md btn-danger" style="left:200px!important;"> العودة
    الى نقطة البيع
</a>
@if($posSettings->enableProdInvoice)
    <a target="_blank" href="{{route('pos.prod_pos', $pos->id)}}" class="no-print btn btn-md btn-info"
       style="left:430px!important;">
        فاتورة الإعداد
    </a>
@endif
<script src="{{asset('app-assets/js/jquery.min.js')}}"></script>
<script type="text/javascript">
    $(window).on('load', function () {
        // window.print();
    });
</script>
</body>
</html>
