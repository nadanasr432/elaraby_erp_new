<!DOCTYPE html>
<html>
<head>
    <title>
        طباعة ليبل الباركود للمنتج
    </title>
    <meta charset="utf-8"/>
    <link rel="icon" href="{{asset('images/logo-min.png')}}" type="image/png">
    <style>
        body {
            font-family: system-ui !important;
            -webkit-print-color-adjust: exact;
            -moz-print-color-adjust: exact;
            print-color-adjust: exact;
            -o-print-color-adjust: exact;
            padding: 0;
            margin: 0;
            color: #000 !important;

            /*page-break-before: avoid;*/
            /*page-break-after: avoid;*/
            /*page-break-inside: avoid;*/
        }

        div.barcode {
            max-width: 400px !important;
            min-width: 200px !important;
            width: auto !important;
            height: auto;
            border: 1px solid #000;
            text-align: center;
            padding-bottom: 5px;
            margin: 5px auto;
            font-size: 14px;
            page-break-before: always;
            page-break-after: always;
            page-break-inside: avoid;
        }

        div.barcode div.barcode-img div {
            text-align: center;
            margin: 0px auto;
        }

        div.barcode div {
            margin-top: 5px;
        }

        div.barcode div.barcode-number {
            margin-top: 0px;
        }
    </style>
</head>
<body>
@php $i=1; @endphp
@if(isset($count) && !empty($count))
    @while($i <= $count)
    @php
    $code_barre = $product->code_universal;
    $Bar = new Picqer\Barcode\BarcodeGeneratorHTML();
    $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
    $code = $Bar->getBarcode($code_barre, $Bar::TYPE_CODE_128);
    @endphp
        <div class="barcode">
            <div style="display: flex; justify-content: center;">
                <div class="col-6" style="margin-right: 10px;"><div>{{$product->product_name}}</div></div>
                <div class="col-6"><div>Exp: {{$exp_date}}</div></div>
            </div>
            <div class="barcode-img">
                <?php echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($code_barre, $generator::TYPE_CODE_128)) . '">'; ?>
            </div>
            
            <div style="letter-spacing: 5px;font-weight: 600;" class="barcode-number">* {{$product->code_universal}} *</div>
            <div>
                السعر
                :
                {{$product->sector_price}}
            </div>
        </div>
        @php $i++; @endphp
    @endwhile
@endif

<script src="{{asset('app-assets/js/jquery.min.js')}}"></script>
<script>
    $(window).on('load', function () {
        window.print();
    });
</script>

</body>
</html>

