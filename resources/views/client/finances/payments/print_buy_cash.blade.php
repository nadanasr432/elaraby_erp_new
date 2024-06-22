<!DOCTYPE html>
<html>
<head>
    <title>طباعة صورة السند </title>
    <meta charset="utf-8" />
    <link rel="icon" href="{{asset('images/logo.png')}}" type="image/png"/>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/font-awesome.min.css')}}">
    <style type="text/css">
        @font-face {
            font-family: 'Cairo';
            src: url({{asset('fonts/Cairo.ttf')}});
        }
        body,html{font-family: 'Cairo' !important; direction: rtl !important;}
        .no-print{position: fixed;bottom: 0;right: 30px;border-radius: 0;z-index: 9999;}
        div.img-receipt
        {
            width : 900px; height: 400px; margin: 10px auto !important; font-weight: bold;
            box-shadow: 1px 1px 5px rgba(0,0,0,0.5);
        }
        div.currency{
            width :100%; font-size: 16px ; color: #000;  padding: 70px 100px 0 0; float: right; display: inline;
        }
        div.amount{
            width :30%; font-size: 30px ; color: #000;  padding: 10px 110px 0 0; float: right; display: inline;
        }
        div.amount2{
            width :100%; font-size: 16px ; color: #000;  padding: 10px 200px 0 0; float: right; display: inline;
        }
        div.receipt_id{
            width :30%; font-size: 30px ; color: #000;  padding: 15px 100px 0 0;float: right; display: inline;
        }
        div.receipt_date{
            width :40%; font-size: 16px ; color: #000;  padding: 10px 130px 0 0;float: right; display: inline;
        }
        div.supplier_name{
            width :100%; font-size:16px ; color: #000;  padding: 0px 260px 0 0 ;float: right; display: inline;
        }
        div.payment{
            width :100%; font-size:16px ; color: #000;  padding: 20px 30px 0 0 ;float: right; display: inline;
        }
        div.payment i.fa{
            margin-left: 200px; font-size: 20px;
        }
        div.bank_name{
            width :100%; font-size:16px ; color: #000;  padding: 15px 170px 0 0 ;float: right; display: inline;
        }
        div.bank_name span{
            margin-right: 360px;
        }

        div.pupose{
            width :100%; font-size:16px ; color: #000;  padding: 10px 170px 0 0 ;float: right; display: inline;
        }
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                -moz-print-color-adjust: exact;
                print-color-adjust: exact;
                -o-print-color-adjust: exact;
            }
            .no-print {display:none;}
            .printy {display: block !important;visibility: visible !important;}
        }
    </style>
</head>
<body>
<?php
use ArPHP\I18N\Arabic;
$Arabic = new Arabic();
$today = date('Y-m-d');
$currency = $company->extra_settings->currency;
echo "<div class='col-lg-12 text-right' style='border: 1px solid #aaa; padding:10px!important;'>";
    echo'<img class="text-center" style="width: 100%; border:1px solid #ddd;height:100px!important;" src="'.asset($company->basic_settings->header).'"/>';
    $paid = $cash->amount;
    $supplier = $cash->supplier->supplier_name;
    $datetime = $cash->date;
    $integer = abs($paid);
    $paid_text = $Arabic->int2str($integer);

    if ($paid <0) {
        echo "<div class='img-receipt' style='background: url(".asset('images/receive_cash.png').") !important; '> ";
    }
    else{
        echo "<div class='img-receipt' style='background: url(".asset('images/send_cash.png').") !important; '> ";
    }
    echo "
        <div class='currency text-right'>".$currency."</div>
        <div class='amount text-right'>".$integer."</div>
        <div class='receipt_id'>".$cash->id."</div>
        <div class='receipt_date'>".$datetime."</div>
        <div class='supplier_name'>".$supplier."</div>
        <div class='amount2'>".$integer." ( ".$paid_text." ) ".$currency." فقط لاغير </div>
        ";
    if ($paid <0) {
        echo "<div class='pupose'> دفعة سلفية من المورد للشركة </div>";
    }
    else{
        if (!empty($cash->bill_id)){
            echo "<div class='pupose'> فواتير مشتريات من المورد للشركة </div>";
        }
        else{
            echo "<div class='pupose'> دفعة كاش مقدمة من الشركة للمورد </div>";
        }
    }

    echo "</div>";
    echo '
        <img style="width: 85%; display: inline;float: left;height:120px!important;" src="'.asset($company->basic_settings->footer).'"/>
        <img style="width: 15%; display: inline;float: right; height:120px!important;" src="'.asset($company->basic_settings->electronic_stamp).'"/>';
    echo "<div class='clearfix'></div>";
    echo " </div>";
    echo "</div>";
?>

<button onclick="window.print();" class="no-print btn btn-sm btn-success">اضغط للطباعة</button>
<a href="{{route('client.home')}}" style="margin-right:110px;" class="no-print btn btn-sm btn-danger"> العودة الى الصفحة الرئيسية </a>
<script src="{{asset('app-assets/js/jquery.min.js')}}"></script>
<script type="text/javascript">
    $(window).on('load',function(){
        window.print();
    });
</script>
</body>
</html>
