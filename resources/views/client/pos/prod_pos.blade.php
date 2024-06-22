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
            font-size: 18px !important;
            font-weight: bold;
            margin: 0;
            padding: 10px;
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
            border-bottom: 1px solid #aaa;
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
            padding: 0px;
            margin: 0;
            font-family: 'Cairo' !important;
            font-size: 10px !important;
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
<?php
//dd($pos->id);
?>
<body dir="rtl" style="background: #fff;
            page-break-before: avoid;
            page-break-after: avoid;
            page-break-inside: avoid;" class="text-right">
<div class="pos_details">
    <div class="text-right mt-3">
        <h6 style="text-align: right;font-weight: bold">فاتورة الإعداد</h6>
        <table dir="rtl">
            <thead>
            <tr style="border: 1px solid #aaa">
                <td style='border: 1px solid #aaa'>
                    Qty*Price سعرxكميه
                </td>
                <td style='border: 1px solid #aaa'>صنف | Category</td>
                <td style='border: 1px solid #aaa'>الخصم</td>
                <td style='border: 1px solid #aaa'>اجمالى | Total</td>
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
    </div>
</div>

<button onclick="window.print();" class="no-print btn btn-md btn-success">اضغط للطباعة</button>
<a href="{{route('client.pos.create')}}" class="no-print btn btn-md btn-danger" style="left:170px!important;"> العودة
    الى نقطة البيع
</a>

<a target="_blank" href="{{route('pos.prod_pos', $pos->id)}}" class="no-print btn btn-md btn-info" style="left:370px!important;">
    فاتورة الإعداد
</a>
<script src="{{asset('app-assets/js/jquery.min.js')}}"></script>
<script type="text/javascript">
    $(window).on('load', function () {
        // window.print();
    });
</script>
</body>
</html>
