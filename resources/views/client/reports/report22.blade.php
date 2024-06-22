@extends('client.layouts.app-main')
<style>
</style>
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissable fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissable fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('error') }}
        </div>
    @endif
    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0 no-print">
                    <div class="d-flex justify-content-between">
                        <div class="col-lg-12 margin-tb">
                            <h5 class="pull-right alert alert-sm alert-success"> تقرير الاقرار الضريبى الشامل </h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="company_details printy" style="display: none;">
                        <div class="text-center">
                            <img class="logo" style="width: 20%;" src="{{asset($company->company_logo)}}" alt="">
                        </div>
                        <div class="text-center">
                            <div class="col-lg-12 text-center justify-content-center">
                                <p class="alert alert-secondary text-center alert-sm"
                                   style="margin: 10px auto; font-size: 17px;line-height: 1.9;" dir="rtl">
                                    {{$company->company_name}} -- {{$company->business_field}} <br>
                                    {{$company->company_owner}} -- {{$company->phone_number}} <br>
                                </p>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <form action="{{route('client.report22.post')}}" class="no-print" method="POST">
                        @csrf
                        @method('POST')
                        <div class="col-lg-3 pull-right no-print">
                            <label for="" class="d-block">من تاريخ</label>
                            <input type="date" @if(isset($from_date) && !empty($from_date)) value="{{$from_date}}"
                                   @endif class="form-control" name="from_date"/>
                        </div>
                        <div class="col-lg-3 pull-right no-print">
                            <label for="" class="d-block">الى تاريخ</label>
                            <input type="date" @if(isset($to_date) && !empty($to_date)) value="{{$to_date}}"
                                   @endif  class="form-control" name="to_date"/>
                        </div>
                        <div class="col-lg-6 text-center  pull-right">
                            <button class="btn btn-md btn-danger"
                                    style="font-size: 15px; height: 40px; margin-top: 25px;" type="submit">
                                <i class="fa fa-check"></i>
                                عرض التقرير
                            </button>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                    <?php
                    $total_sales = 0;
                    ?>
                    @if(isset($sale_bills) && !$sale_bills->isEmpty())
                        <p class="alert alert-sm alert-danger mt-1 mb-1 text-center">
                            فواتير البيع
                        </p>
                        <div class="table-responsive">
                            <table class='table table-condensed table-striped table-bordered'>
                                <thead class="text-center">
                                <th>رقم الفاتورة</th>
                                <th>الاجمالى قبل الضريبة</th>
                                </thead>
                                <tbody>
                                <?php $i = 0; ?>
                                @foreach($sale_bills as $sale_bill)
                                    <tr>
                                        <td>{{$sale_bill->company_counter}}</td>
                                        <td>
                                            <?php $sum = 0;$i = $i + 1; ?>
                                            @foreach($sale_bill->elements as $element)
                                                <?php $sum = $sum + $element->quantity_price; ?>
                                            @endforeach
                                            <?php
                                            $extras = $sale_bill->extras;
                                            foreach ($extras as $key) {
                                                if ($key->action == "discount") {
                                                    if ($key->action_type == "pound") {
                                                        $sale_bill_discount_value = $key->value;
                                                        $sale_bill_discount_type = "pound";
                                                    } else {
                                                        $sale_bill_discount_value = $key->value;
                                                        $sale_bill_discount_type = "percent";
                                                    }
                                                } else {
                                                    if ($key->action_type == "pound") {
                                                        $sale_bill_extra_value = $key->value;
                                                        $sale_bill_extra_type = "pound";
                                                    } else {
                                                        $sale_bill_extra_value = $key->value;
                                                        $sale_bill_extra_type = "percent";
                                                    }
                                                }
                                            }
                                            if ($extras->isEmpty()) {
                                                $sale_bill_discount_value = 0;
                                                $sale_bill_extra_value = 0;
                                                $sale_bill_discount_type = "pound";
                                                $sale_bill_extra_type = "pound";
                                            }
                                            if ($sale_bill_extra_type == "percent") {
                                                $sale_bill_extra_value = $sale_bill_extra_value / 100 * $sum;
                                            }
                                            $after_discount = $sum + $sale_bill_extra_value;

                                            if ($sale_bill_discount_type == "percent") {
                                                $sale_bill_discount_value = $sale_bill_discount_value / 100 * $sum;
                                            }
                                            $after_discount = $sum - $sale_bill_discount_value;
                                            $after_discount = $sum - $sale_bill_discount_value + $sale_bill_extra_value;
                                            $after_total = $after_discount;
                                            $tax_option = $sale_bill->value_added_tax;
                                            if ($tax_option == 1) {
                                                $after_total = $sum * (100 / 115);
                                            }
                                            echo round($after_total,2) . " " . $currency;

                                            ?>
                                            <?php $total_sales = $total_sales + $after_total; ?>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @elseif(isset($sale_bills) && $sale_bills->isEmpty())
                        <div class="alert alert-sm alert-danger text-center mt-1">
                            <i class="fa fa-close"></i>
                            لا توجد اى فواتير بيع
                        </div>
                    @endif
                    <div class="clearfix"></div>
                    @if(isset($pos_bills) && !$pos_bills->isEmpty())
                        <p class="alert alert-sm alert-primary mt-1 text-center">
                            فواتير الكاشير ( نقطة البيع )
                        </p>
                        <div class="table-responsive">
                            <table border="1" cellpadding="14" style="width: 100%!important;">
                                <thead class="text-center">
                                <tr>
                                    <th class="text-center">رقم الفاتورة</th>
                                    <th class="text-center"> الاجمالى قبل الضريبة</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $sum2 = 0 ; $sum3 =0;$j=0;
                                @endphp
                                @foreach ($pos_bills as $key => $pos)
                                    <tr>
                                        <td>{{ ++$j}}</td>
                                        <td>
                                            @if(isset($pos))
                                                <?php
                                                $pos_elements = $pos->elements;
                                                $pos_discount = $pos->discount;
                                                $percent = 0;

                                                $sum = 0;
                                                foreach ($pos_elements as $pos_element) {
                                                    $sum = $sum + $pos_element->quantity_price;
                                                }
                                                if (isset($pos) && empty($pos_discount)) {
                                                    $sum = $sum + $percent;
                                                } elseif (isset($pos) && isset($pos_discount)) {
                                                    $discount_value = $pos_discount->discount_value;
                                                    $discount_type = $pos_discount->discount_type;
                                                    if ($discount_type == "pound") {
                                                        $sum = $sum - $discount_value;
                                                    } else {
                                                        $discount_value = ($discount_value / 100) * $sum;
                                                        $sum = $sum - $discount_value;
                                                    }
                                                } elseif (isset($pos) && !empty($pos_discount)) {
                                                    $discount_value = $pos_discount->discount_value;
                                                    $discount_type = $pos_discount->discount_type;
                                                    if ($discount_type == "pound") {
                                                        $sum = $sum - $discount_value;
                                                    } else {
                                                        $discount_value = ($discount_value / 100) * $sum;
                                                        $sum = $sum - $discount_value;
                                                    }
                                                    $sum = $sum + $percent;
                                                }
                                                $tax_option = $pos->value_added_tax;
                                                if ($tax_option == 1) {
                                                    $sum = $sum * (100 / 115);
                                                    $sum_with_option = $sum;
                                                    $percent = (15 / 100) * $sum_with_option;
                                                    $sum = $percent + $sum_with_option;
                                                }
                                                echo round($sum,2) . " " . $currency;
                                                $total_sales = $total_sales + $sum;
                                                $j = $j + 1;
                                                ?>
                                            @else
                                                0
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-1">
                            <span class="col-lg-4 col-sm-12 alert alert-secondary alert-sm mr-5">
                                عدد فواتير البيع
                                ( {{$i}} )
                            </span>
                            <span class="col-lg-4 col-sm-12 alert alert-cyan alert-sm">
                                اجمالى فواتير البيع قبل الضريبة
                                ( {{round( $total_sales,2  )}} ) {{$currency}}
                            </span>
                        </div>
                    @endif

                    <div class="clearfix"></div>

                    @if(isset($buy_bills) && !empty($buy_bills))
                        <p class="alert alert-sm alert-danger mt-2 mb-2 text-center">
                            فواتير المشتريات
                        </p>
                        <div class="table-responsive">
                            <table class='table table-condensed table-striped table-bordered'>
                                <thead class="text-center">
                                <th>رقم الفاتورة</th>
                                <th>الاجمالى قبل الضريبة</th>
                                </thead>
                                <tbody>
                                <?php $i = 0; $total_buys = 0; ?>
                                @foreach($buy_bills as $buy_bill)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>
                                            <?php $sum = 0; ?>
                                            @foreach($buy_bill->elements as $element)
                                                <?php $sum = $sum + $element->quantity_price; ?>
                                            @endforeach
                                            <?php
                                            $extras = $buy_bill->extras;
                                            foreach ($extras as $key) {
                                                if ($key->action == "discount") {
                                                    if ($key->action_type == "pound") {
                                                        $buy_bill_discount_value = $key->value;
                                                        $buy_bill_discount_type = "pound";
                                                    } else {
                                                        $buy_bill_discount_value = $key->value;
                                                        $buy_bill_discount_type = "percent";
                                                    }
                                                } else {
                                                    if ($key->action_type == "pound") {
                                                        $buy_bill_extra_value = $key->value;
                                                        $buy_bill_extra_type = "pound";
                                                    } else {
                                                        $buy_bill_extra_value = $key->value;
                                                        $buy_bill_extra_type = "percent";
                                                    }
                                                }
                                            }
                                            if ($extras->isEmpty()) {
                                                $buy_bill_discount_value = 0;
                                                $buy_bill_extra_value = 0;
                                                $buy_bill_discount_type = "pound";
                                                $buy_bill_extra_type = "pound";
                                            }
                                            if ($buy_bill_extra_type == "percent") {
                                                $buy_bill_extra_value = $buy_bill_extra_value / 100 * $sum;
                                            }
                                            $after_discount = $sum + $buy_bill_extra_value;

                                            if ($buy_bill_discount_type == "percent") {
                                                $buy_bill_discount_value = $buy_bill_discount_value / 100 * $sum;
                                            }
                                            $after_discount = $sum - $buy_bill_discount_value;
                                            $after_discount = $sum - $buy_bill_discount_value + $buy_bill_extra_value;
                                            $after_total = $after_discount;
                                            echo round($after_total,2) . " " . $currency;
                                            ?>
                                            <?php $total_buys = $total_buys + $after_total; ?>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-1">
                                <span class=" col-lg-4 col-sm-12 alert alert-secondary alert-sm mr-5">
                                    عدد الفواتير
                                    ( {{$i}} )
                                </span>
                            <span class=" col-lg-4 col-sm-12 alert alert-cyan alert-sm">
                                    اجمالى فواتير الشراء قبل الضريبة
                                    ({{round($total_buys,2)}}) {{$currency}}
                                </span>
                        </div>
                    @elseif(isset($buy_bills) && empty($buy_bills))
                        <div class="alert alert-sm alert-danger text-center mt-1">
                            <i class="fa fa-close"></i>
                            لا توجد اى فواتير شراء
                        </div>
                    @endif

                    @if(isset($pos_bills) && isset($buy_bills) && isset($sale_bills))
                        <?php
                        $difference = $total_sales - $total_buys;
                        $tax_value_added = $company->tax_value_added;
                        $percentage = ($tax_value_added / 100) * $difference;
                        ?>
                        <h1 style="font-size: 16px!important;color: black!important;">
                            اجمالى الارباح = اجمالى المبيعات - اجمالى المشتريات
                            <br><br>
                            اجمالى الارباح =
                            {{round($difference,2)}} {{$currency}}
                        </h1>
                        <hr>
                        <h1 style="font-size: 16px!important;color: black!important;">
                            مبلغ الضريبة = الارباح * الضريبة
                            <br><br>
                            مبلغ الضريبة =
                            {{round($percentage,2)}} {{$currency}}
                        </h1>
                        <hr>


                    @endif

                    <div class="clearfix"></div>
                    <div class="row mt-1 no-print">
                        <button type="button" onclick="window.print()" class="btn btn-md btn-info pull-right">
                            <i class="fa fa-print"></i>
                            طباعة التقرير
                        </button>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>

@endsection
<script src="{{asset('app-assets/js/jquery.min.js')}}"></script>
<script>
    $(document).ready(function () {

    });
</script>
