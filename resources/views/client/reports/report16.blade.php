@extends('client.layouts.app-main')
<style>
    .btn.dropdown-toggle.bs-placeholder {
        height: 40px;
    }

    .bootstrap-select {
        width: 100% !important;
    }
</style>
@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>الاخطاء :</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="col-12">
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-danger">
                            تقرير العمل الشامل
                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <form action="{{route('client.report16.post')}}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="col-lg-4 pull-right no-print">
                            <label for="" class="d-block">من تاريخ</label>
                            <input type="date" @if(isset($from_date) && !empty($from_date)) value="{{$from_date}}"
                                   @endif class="form-control" name="from_date"/>
                        </div>
                        <div class="col-lg-4 pull-right no-print">
                            <label for="" class="d-block">الى تاريخ</label>
                            <input type="date" @if(isset($to_date) && !empty($to_date)) value="{{$to_date}}"
                                   @endif  class="form-control" name="to_date"/>
                        </div>
                        <div class="col-lg-4 pull-right">
                            <button class="btn btn-md btn-danger"
                                    style="font-size: 15px; height: 40px; margin-top: 25px;" type="submit">
                                <i class="fa fa-check"></i>
                                عرض التقرير
                            </button>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                    @if(isset($result) && !empty($result))
                        <p class="alert alert-sm alert-danger mt-2 mb-2 text-center">
                            تقرير العمل الشامل
                        </p>
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered text-center table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center"> م</th>
                                    <th class="text-center">اسم الحساب</th>
                                    <th class="text-center">نوع الحساب</th>
                                    <th class="text-center"> له دائن</th>
                                    <th class="text-center"> عليه ديون</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $total_for = 0;
                                $total_on = 0;
                                $i = 0;
                                ?>
                                @foreach($outerClients as $outerClient)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>{{ $outerClient->client_name }}</td>
                                        <td>عميل</td>
                                        @if($outerClient->prev_balance > 0)
                                            <?php
                                            $total_on = $total_on + $outerClient->prev_balance;
                                            ?>
                                            <td>0</td>
                                            <td>{{$outerClient->prev_balance}}</td>
                                        @else
                                            <?php
                                            $total_for = $total_for + abs($outerClient->prev_balance);
                                            ?>
                                            <td>{{abs($outerClient->prev_balance)}}</td>
                                            <td>0</td>
                                        @endif
                                    </tr>
                                @endforeach

                                @foreach($suppliers as $supplier)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>{{ $supplier->supplier_name }}</td>
                                        <td>مورد</td>
                                        @if($supplier->prev_balance < 0)
                                            <?php
                                            $total_on = $total_on + $supplier->prev_balance;
                                            ?>
                                            <td>0</td>
                                            <td>{{$supplier->prev_balance}}</td>
                                        @else
                                            <?php
                                            $total_for = $total_for + abs($supplier->prev_balance);
                                            ?>
                                            <td>{{abs($supplier->prev_balance)}}</td>
                                            <td>0</td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row mt-3 mb-3">
                            <span class="col-lg-3 col-sm-12 alert alert-secondary alert-sm mr-2">
                                اجمالى لهم ( عليك ديون )
                                ( {{round($total_for,2)}} )
                            </span>
                            <span class="col-lg-3 col-sm-12 alert alert-secondary alert-sm mr-2">
                                اجمالى عليهم ( لك دائن )
                                ( {{round($total_on,2)}} )
                            </span>

                            <span class="col-lg-3 col-sm-12 alert alert-secondary alert-sm mr-2">
                                عدد العملاء
                                ( {{round($outerClients->count(),2)}} )
                            </span>

                            <span class="col-lg-3 col-sm-12 alert alert-secondary alert-sm mr-2">
                                 عدد الموردين
                                ( {{round($suppliers->count(),2)}} )
                            </span>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered text-center table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center"> م</th>
                                    <th class="text-center"> نوع الفاتورة</th>
                                    <th class="text-center"> رقم الفاتورة</th>
                                    <th class="text-center">التاريخ</th>
                                    <th class="text-center">الاجمالى</th>
                                    <th class="text-center"> الربح</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 0; $total = 0; $total_profits = 0; ?>
                                @foreach($sale_bills as $sale_bill)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>فاتورة مبيعات عملاء</td>
                                        <td>{{ $sale_bill->company_counter }}</td>
                                        <td>{{ $sale_bill->date }}</td>
                                        <td>
                                            <?php $sum = 0; ?>
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
                                            $tax_value_added = $company->tax_value_added;
                                            $percentage = ($tax_value_added / 100) * $after_discount;
                                            $after_total = $after_discount + $percentage;
                                            ?>
                                            <?php $total = $total + $after_total; ?>
                                            <?php
                                            $total_real_price = 0;
                                            foreach ($sale_bill->elements as $element) {
                                                $product_id = $element->product_id;
                                                $product = App\Models\Product::FindOrFail($product_id);
                                                $purchasing_price = $product->purchasing_price;
                                                $real_price = $element->quantity * $purchasing_price;
                                                $total_real_price = $total_real_price + $real_price;
                                            }
                                            $profit = $after_total - $total_real_price;
                                            $total_profits = $total_profits + $profit;
                                            $tax_option = $sale_bill->value_added_tax;
                                            if ($tax_option == 1) {
                                                $total = $sum * (100 / 115);
                                                $total_with_option = $total;
                                                $tax_value = (15 / 100) * $total_with_option;
                                                $after_total = $tax_value + $total_with_option;
                                            }
                                            echo round($after_total,2) . " " . $currency;
                                            ?>
                                        </td>
                                        <td>
                                            {{round($profit,2)}}
                                            {{ $currency }}
                                        </td>
                                    </tr>
                                @endforeach
                                @php
                                    $sum2 = 0 ; $sum3 =0;
                                @endphp
                                @foreach ($pos_bills as $key => $pos)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>فاتورة كاشير نقطة بيع</td>
                                        <td>{{ $pos->id }}</td>
                                        <td>{{ date('Y-m-d',strtotime($pos->created_at))}}</td>
                                        <td>
                                            @if(isset($pos))
                                                <?php
                                                $pos_elements = $pos->elements;
                                                $pos_discount = $pos->discount;
                                                $pos_tax = $pos->tax;
                                                $percent = 0;

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
                                                $tax_option = $pos->value_added_tax;
                                                if ($tax_option == 1) {
                                                    $sum = $sum * (100 / 115);
                                                    $sum_with_option = $sum;
                                                    $percent = (15 / 100) * $sum_with_option;
                                                    $sum = $percent + $sum_with_option;
                                                }
                                                echo round($sum, 2)." ".$currency;
                                                $total = $total + $sum;
                                                ?>
                                            @else
                                                0
                                            @endif
                                        </td>
                                        <td>
                                            <?php
                                            $total_real_price = 0;
                                            foreach ($pos->elements as $element) {
                                                $product_id = $element->product_id;
                                                $product = App\Models\Product::FindOrFail($product_id);
                                                $purchasing_price = $product->purchasing_price;
                                                $real_price = $element->quantity * $purchasing_price;
                                                $total_real_price = $total_real_price + $real_price;
                                            }
                                            $profit = $sum - $total_real_price;
                                            echo round($profit, 2)." ".$currency;
                                            $total_profits = $total_profits + $profit;
                                            ?>
                                        </td>
                                    </tr>
                                @endforeach
                                @foreach($buy_bills as $buy_bill)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>فاتورة مشتريات</td>
                                        <td>{{ $buy_bill->buy_bill_number }}</td>
                                        <td>{{ $buy_bill->date }}</td>
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
                                            $tax_value_added = $company->tax_value_added;
                                            $percentage = ($tax_value_added / 100) * $after_discount;
                                            $after_total = $after_discount + $percentage;
                                            ?>
                                            <?php $total = $total + $after_total;
                                            echo round($after_total,2) . " " . $currency;
                                            ?>
                                        </td>
                                        <td>
                                            0
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row mt-3 mb-3">
                            <span class="col-lg-3 col-sm-12 alert alert-secondary alert-sm mr-4">
                                اجمالى الداخل الى الخزن
                                <?php
                                $total_in = 0;
                                foreach ($cashs as $cash) {
                                    $total_in = $total_in + $cash->amount;
                                }
                                foreach ($capitals as $capital) {
                                    $total_in = $total_in + $capital->amount;
                                }
                                echo "( " . round($total_in,2) . " ) " . $currency;
                                ?>
                            </span>
                            <span class="col-lg-3 col-sm-12 alert alert-secondary alert-sm mr-4">
                                اجمالى الخارج من الخزن
                                <?php
                                $total_out = 0;
                                foreach ($buy_cashs as $cash) {
                                    $total_out = $total_out + $cash->amount;
                                }
                                foreach ($expenses as $expense) {
                                    $total_out = $total_out + $expense->amount;
                                }
                                echo "( " . round($total_out,2) . " ) " . $currency;
                                ?>
                            </span>

                            <span class="col-lg-4 col-sm-12 alert alert-secondary alert-sm mr-4">
                                اجمالى ارصدة الخزن
                                {{round($safes_balances,2)}}
                                {{ $currency }}
                            </span>
                        </div>
                        <div class="clearfix"></div>
                        <div class="row mt-3 mb-3">

                            <span class="col-lg-3 col-sm-12 alert alert-secondary alert-sm mr-4">
                                اجمالى تكلفة المخازن
                                {{round($total_purchase_prices,2)}}
                                {{ $currency }}

                            </span>

                            <span class="col-lg-3 col-sm-12 alert alert-secondary alert-sm mr-4">
                                اجمالى حسابات البنوك
                                {{round($banks_balances,2)}}
                                {{ $currency }}

                            </span>

                            <span class="col-lg-3 col-sm-12 alert alert-secondary alert-sm mr-4">
                                اجمالى الربح
                                {{round($total_profits,2)}}
                                {{ $currency }}

                            </span>

                            <div class="clearfix"></div>
                        </div>

                    @endif

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
