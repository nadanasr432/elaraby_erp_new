@extends('client.layouts.app-main')
<style>
    .btn.dropdown-toggle.bs-placeholder {
        height: 40px;
    }

    .bootstrap-select {
        width: 100% !important;
    }

    thead {
        background: #4e73dfe0;
    }

    table thead tr th, table tbody tr td {
        padding: 7px 5px !important;
    }

    thead tr th {
        color: white !important;
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
                    <div class="col-12 row justify-content-between pr-0">
                        <h2 style="font-size: 20px !important; margin-bottom: 19px !important;">تقرير الارباح</h2>
                        <button class="btn btn-danger p-1 rounded border" onclick="history.back()">الرجوع</button>
                    </div>
                    <div class="clearfix"></div>
                    <hr>

                    <form action="{{route('client.report13.post')}}" method="POST" class="mt-2">
                        @csrf
                        @method('POST')
                        <div class="col-lg-5 pull-right no-print">
                            <label>من تاريخ</label>
                            <input
                                type="date" class="form-control" name="from_date"
                                @if(isset($from_date) && !empty($from_date)) value="{{$from_date}}" @endif
                            />
                        </div>
                        <div class="col-lg-5 pull-right no-print">
                            <label>الى تاريخ</label>
                            <input
                                type="date" class="form-control" name="to_date"
                                @if(isset($to_date) && !empty($to_date)) value="{{$to_date}}"@endif
                            />
                        </div>
                        <div class="col-lg-2 pull-right p-0">
                            <label class="invisible">sdf</label>
                            <br>
                            <button class="btn btn-md btn-success" type="submit">
                                <i class="fa fa-check"></i>
                                عرض التقرير
                            </button>
                        </div>
                    </form>
                    <br>
                    <br>
                    <br>
                    <br>
                    <hr>

                    <?php
                    $i = 0; $total = 0; $total_profits = 0;
                    ?>
                    <div class="clearfix"></div>

                    @if(isset($pos_bills) && !$pos_bills->isEmpty())
                        <p class="alert alert-info font-weight-bold text-white mt-1 text-center">
                            ارباح فواتير نقطة البيع
                        </p>
                        <div class="table-responsive">
                            <table border="1" cellpadding="14" style="width: 100%!important;">
                                <thead class="text-center">
                                <tr>
                                    <th>#</th>
                                    <th class="text-center">رقم</th>
                                    <th class="text-center">العميل</th>
                                    <th class="text-center"> تاريخ - وقت</th>
                                    <th class="text-center"> سعر المبيعات</th>
                                    <th class="text-center">سعر الشراء</th>
                                    <th class="text-center"> الربح</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $sum2 = 0 ; $sum3 =0;
                                    $total_profits = 0;
                                @endphp

                                @foreach ($pos_bills as $key => $pos)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>{{ $pos->id }}</td>
                                        <td>
                                            @if(isset($pos->outerClient->client_name))
                                                {{$pos->outerClient->client_name}}
                                            @else
                                                زبون
                                            @endif
                                        </td>
                                        <td>{{ $pos->created_at}}</td>
                                        <td>
                                            @if(isset($pos))
                                                <?php
                                                $pos_elements = $pos->elements;
                                                $pos_discount = $pos->discount;
                                                $pos_tax = $pos->tax;
                                                $percent = 0;

                                                $realPrice = 0;
                                                $sum = 0;
                                                foreach ($pos_elements as $pos_element) {
                                                    $sum = $sum + $pos_element->quantity_price;
                                                    $realProduct = \App\Models\Product::where('company_id', $pos->company_id)
                                                        ->where('id', $pos_element->product_id)
                                                        ->firstOrFail();
                                                    $realPrice += ($realProduct->purchasing_price * $pos_element->quantity) ?? 0;
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
                                                echo round($sum, 2);
                                                $total = $total + $sum;
                                                ?>
                                            @else
                                                0
                                            @endif
                                        </td>
                                        <td>
                                            {{ $realPrice }}
                                        </td>
                                        <td>
                                            @php
                                                echo $finalTotal = ($sum - $realPrice);
                                                $total_profits += $finalTotal;
                                            @endphp
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif


                    <div class="clearfix"></div>


                    @if(isset($sale_bills) && !$sale_bills->isEmpty())
                        <?php
                        ?>
                        <p class="alert alert-info font-weight-bold mt-2 mb-1 text-center">
                            ارباح فواتير المبيعات
                        </p>
                        <div class="table-responsive">
                            <table class='table table-condensed table-striped table-bordered'>
                                <thead class="text-center">
                                <th>#</th>
                                <th>رقم</th>
                                <th>العميل</th>
                                <th>التاريخ-وقت</th>
                                <th>سعر المبيعات</th>
                                <th>سعر الشراء</th>
                                <th>الربح</th>
                                </thead>
                                <tbody>
                                @foreach($sale_bills as $sale_bill)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>{{$sale_bill->company_counter}}</td>
                                        <td>
                                            @if(empty($sale_bill->outer_client_id))
                                                عميل مبيعات نقدية
                                            @else
                                                {{$sale_bill->outerClient->client_name}}
                                            @endif
                                        </td>
                                        <td>{{$sale_bill->date . ' -- ' . $sale_bill->time}}</td>
                                        <td>
                                            <?php
                                            $sum = 0;
                                            $realPrice = 0;
                                            ?>
                                            @foreach($sale_bill->elements as $element)
                                                <?php
                                                $sum = $sum + $element->quantity_price;
                                                $realProduct = \App\Models\Product::where('company_id', $pos->company_id)
                                                    ->where('id', $element->product_id)
                                                    ->firstOrFail();
                                                $realPrice += ($realProduct->purchasing_price * $element->quantity) ?? ($element->product_price * $element->quantity);
                                                ?>
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

                                            $tax_option = $sale_bill->value_added_tax;
                                            if ($tax_option == 1) {
                                                $total_sale = $sale_bill->final_total * (100 / 115);
                                                echo $total_sale;
                                            } else {
                                                echo round($after_total, 2);
                                            }
                                            ?>

                                            <?php $total = $total + $after_total; ?>
                                        </td>
                                        <td>{{$realPrice}}</td>
                                        <td>
                                            @php
                                                echo $finalTotal = ($after_total - $realPrice);
                                                $total_profits += $finalTotal;
                                            @endphp
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-3 justify-content-center">
                            <span class="badge badge-success p-1 rounded border-success font-weight-bold">
                                عدد الفواتير
                                ( {{$i}} )
                            </span>
                            <span class="badge badge-info p-1 mr-1 ml-1 rounded border-info font-weight-bold">
                                اجمالى اسعار كل الفواتير
                                ( {{round( $total,2  )}} ) {{$currency}}
                            </span>
                            <span class="badge badge-primary p-1 rounded border-primary font-weight-bold">
                                اجمالى الارباح
                                (  {{round( $total_profits,2  )}} ) {{$currency}}
                            </span>
                        </div>
                    @elseif(isset($sale_bills) && $sale_bills->isEmpty())
                        <div class="alert alert-sm alert-danger text-center mt-3">
                            <i class="fa fa-close"></i>
                            لا توجد اى فواتير
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{asset('app-assets/js/jquery.min.js')}}"></script>
<script>

</script>
