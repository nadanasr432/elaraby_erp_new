@extends('admin.layouts.app-main')
<style>
    .count {
        font-size: 30px;
        font-weight: bold;
        line-height: 1.2;
        margin-top: 20px;
    }

    .count_bottom {
        margin-top: 20px;
    }

    .tile_stats_count {
        border: 1px solid #ccc;
        padding: 10px;
        margin: 10px;
    }

    #bar-chart-grouped {
        font-family: 'Cairo' !important;
    }

    .chart_1, .chart_2 {
        background: #fff;
        border-radius: 0;
        border: 1px solid #ddd;
        padding: 10px;
        height: 320px;
    }

    .chart_1 .chart {
        width: 100%;
        height: 250px !important;
    }

    .chart_1 .chart canvas {
        width: 50%;
        height: 250px !important;
    }

    div.shortcut {
        width: 33.3333%;
        color: #40485b;
        height: 94px;
        background: #fff;
        padding: 5px;
        border: 1px solid #ccc;
        border-top: 1px solid #ccc;
        transition: 0.5s
    }

    a div.shortcut {
        font-size: 12px;
        color: #40485b;
    }

    a div.shortcut i {
        font-size: 40px;
        color: #40485b;
        margin-bottom: 15px
    }

    div.shortcut:hover {
        background: #40485b;
    }

    .count {
        margin-top: 20px;
    }

    a:hover div.shortcut {
        color: #fff !important;
    }

    a:hover div.shortcut i {
        color: #fff !important;
    }

    div.shortcuts div.col-lg-7 {
        border-left: 1px solid #ccc;
    }

    .col-md-6 {
        padding: 5px
    }

    div.chart_2 div.shortcuts {
        height: 325px !important;
    }

    .reports hr {
        margin: 15px
    }

    ul.list-unstyled li {
        margin-top: 25px;
        text-align: center;
        background: #eee;
        padding: 20px
    }

    ul.list-unstyled li a {
        font-size: 13px;
        padding: 5px;
        transition: 0.3s
    }

    ul.list-unstyled li a:hover {
        background: #40485b;
        color: #fff;
    }

    .img-watch {
        width: 600px;
        height: 600px;
        margin: 50px auto;
    }

    .first_div {
        margin-bottom: 20px;
    }

    .box {
        color: #000;
        font-size: 14px;
        min-height: 60px;
        text-align: center;
        padding: 10px;
        border-radius: 10px;
        margin-top: 20px;
        background: #fff;
        border: 1px solid #ddd;
        box-shadow: 1px 1px 5px #444;
    }
</style>
@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success alert-dismissable text-center fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(isset($companies))
        <?php $i = 0;
        $total_deserved = 0;
        $total_paid = 0;
        $total_rest = 0;
        ?>
        @foreach($companies as $company)
            @if(!$company->clients->isEmpty())
                <?php
                $deserved = $company->subscription->type->type_price;
                $total_deserved = $total_deserved + $deserved;
                $payments = $company->payments;
                $paid = 0;
                foreach ($payments as $payment) {
                    $amount = $payment->amount;
                    $paid = $paid + $amount;
                }
                $total_paid = $total_paid + $paid;
                $rest = $deserved - $paid;
                $total_rest = $total_rest + $rest;
                ?>
            @endif
        @endforeach
    @endif
    <div class="row tile_count text-center">
        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="tile_stats_count">
                <span class="count_top" style="font-size:16px;background: darkred; color:#fff; padding: 10px;">
                <i class="fa fa-2x fa-money"></i>
                اجمالى المبالغ المستحقة
            </span>
                <div class="count">
                    {{floatval($total_deserved)}}
                </div>
                <span class="count_bottom" style="font-size:16px">
                    ريال سعودى
                </span>
            </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="tile_stats_count">
                <span class="count_top" style="font-size:16px;background: darkgreen; color:#fff; padding: 10px;">
                    <i class="fa fa-2x fa-money"></i>
                    اجمالى المبالغ المدفوعة
                </span>
                <div class="count">
                    {{floatval($total_paid)}}
                </div>
                <span class="count_bottom" style="font-size:16px">
                    ريال سعودى
                </span>
            </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="tile_stats_count">
                <span class="count_top" style="font-size:16px;background: #40485b; color:#fff; padding: 10px;">
                    <i class="fa fa-2x fa-money"></i>
                    اجمالى المبالغ المتبقية
                </span>
                <div class="count">
                    {{floatval($total_rest)}}
                </div>
                <span class="count_bottom" style="font-size:16px">
                    ريال سعودى
                </span>
            </div>
        </div>
    </div>
    <hr>
    <div class="clearfix"></div>
    <div class="row mt-2 mb-2">
        <div class="col-lg-4 pull-right">
            <div class="bg-danger text-white p-2" style="font-size: 14px;">
                الشركات قيد التجربة :
                ( {{$trial_subscriptions->count()}} )
            </div>
        </div>

        <div class="col-lg-4 pull-right">
            <div class="bg-danger text-white p-2" style="font-size: 14px;">
                الشركات شارفت على الانتهاء :
                ( {{$about_end_subscriptions->count()}} )
            </div>
        </div>

        <div class="col-lg-4 pull-right">
            <div class="bg-danger text-white p-2" style="font-size: 14px;">
                الشركات سارية التفعيل :
                ( {{$active_subscriptions->count()}} )
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row mt-2 mb-2">
        <div class="col-lg-6 pull-right">
            <div class="bg-dark text-white p-2" style="font-size: 14px;">
                متوسط ايرد كل عميل :
                <?php
                if($not_trial_subscriptions->isEmpty()){
                    $average = 0;
                }
                else{
                    $average = $total_paid / ($not_trial_subscriptions->count());
                }
                ?>
                {{floatval($average)}}
            </div>
        </div>
        <div class="col-lg-6 pull-right">
            <div class="bg-dark text-white p-2" style="font-size: 14px;">
                نسبة الاحتفاظ بالعملاء  :
                <?php
                echo " عدد الشركات التى جددت ";
                echo $not_trial_subscriptions->count();
                echo " عدد الشركات التى لم تجدد ";
                echo $trial_subscriptions->count();
                ?>
            </div>
        </div>
    </div>
@endsection
