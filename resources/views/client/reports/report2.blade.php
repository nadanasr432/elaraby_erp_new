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
                    <div class="col-12 no-print">
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-danger">
                            تقرير مبيعات حسب المنتج
                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <form action="{{route('client.report2.post')}}" class="no-print" method="POST">
                        @csrf
                        @method('POST')
                        <div class="col-lg-3 pull-right no-print">
                            <label for="" class="d-block">اسم المنتج</label>
                            <select required name="product_id" id="product_id" class="selectpicker"
                                    data-style="btn-info" data-live-search="true" title="اكتب او اختار اسم المنتج">
                                <option
                                    @if(isset($product_id) && $product_id == "all")
                                    selected
                                    @endif
                                    value="all">كل المنتجات
                                </option>
                                @foreach($products as $product)
                                    <option
                                        @if(isset($product_id) && $product->id == $product_id)
                                        selected
                                        @endif
                                        value="{{$product->id}}">{{$product->product_name}}</option>
                                @endforeach
                            </select>
                        </div>
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
                        <div class="col-lg-3 pull-right">
                            <button class="btn btn-md btn-danger"
                                    style="font-size: 15px; height: 40px; margin-top: 25px;" type="submit">
                                <i class="fa fa-check"></i>
                                عرض التقرير
                            </button>
                        </div>
                    </form>
                    <div class="clearfix"></div>

                    <?php $i = 0; $total = 0;$totalBeforeTax = $totalTax = 0; ?>
                    @if(isset($posBills) && !empty($posBills))
                        <p class="alert alert-sm alert-primary mt-3 text-center">
                            فواتير الكاشير ( نقطة البيع )
                        </p>
                        <div class="table-responsive">
                            <table border="1" cellpadding="14" style="width: 100%!important;">
                                <thead class="text-center">
                                <tr>
                                    <th>#</th>
                                    <th class="text-center">رقم</th>
                                    <th class="text-center">عميل</th>
                                    <th class="text-center"> تاريخ - وقت</th>
                                    <th class="text-center"> تكلفة بضاعة</th>
                                    <th class="text-center">ايراد مبيعات</th>
                                    <th class="text-center"> ضريبة مبيعات</th>
                                    <th class="text-center"> طريقة الدفع</th>
                                    <th class="text-center"> ملاحظات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $sum2 = 0 ; $sum3 =0;
                                @endphp
                                @foreach ($posBills as $key => $pos)
                                    @if(empty($pos))
                                        @php continue; @endphp
                                    @endif
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
                                            <?php $merchandise_cost = 0; ?>
                                            @foreach($pos->elements as $element)
                                                <?php $merchandise_cost = $merchandise_cost + $element->product->purchasing_price * $element->quantity; ?>
                                            @endforeach
                                            {{round($merchandise_cost,2)}}
                                        </td>
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
                                                $totalTax += $percent;
                                                $totalBeforeTax += $sum - $percent;
                                                echo round($sum, 2);
                                                $total = $total + $sum;
                                                ?>
                                            @else
                                                0
                                            @endif
                                        </td>
                                        <td>{{round($percent,2)}}</td>
                                        <td>
                                            <?php
                                            $bill_id = "pos_" . $pos->id;
                                            $check = App\Models\Cash::where('bill_id', $bill_id)->first();
                                            if (empty($check)) {
                                                $check2 = App\Models\BankCash::where('bill_id', $bill_id)->first();
                                                if (empty($check2)) {
                                                    echo "غير مدفوعة";
                                                } else {
                                                    echo "شيك بنكى" . " ( " . $check2->bank->bank_name . " ) ";
                                                    $paid = $check2->amount;
                                                    $rest = $sum - $paid;
                                                    echo "<br/>";
                                                    echo "مستحق " . $sum;
                                                    echo "<br/>";
                                                    echo "مدفوع " . $paid;
                                                    echo "<br/>";
                                                    echo "متبقى " . $rest;
                                                }
                                            } else {
                                                echo "نقدى كاش" . " ( " . $check->safe->safe_name . " ) ";
                                                $paid = $check->amount;
                                                $rest = $sum - $paid;
                                                echo "<br/>";
                                                echo "مستحق " . $sum;
                                                echo "<br/>";
                                                echo "مدفوع " . $paid;
                                                echo "<br/>";
                                                echo "متبقى " . $rest;
                                            }
                                            ?>
                                        </td>
                                        <td>{{$pos->notes}}</td>
                                    </tr>
                                @endforeach


                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-3">

                            <div class="badge badge-success p-1"
                                 style="width: auto;font-weight: bold;margin-right:4px;">
                                عدد فواتير نقطة البيع
                                ( {{$i}} )
                            </div>
                            <div class="badge badge-danger p-1" style="width: auto;font-weight: bold;margin-right:4px;">
                                اجمالي فواتير نقطة البيع قبل الضريبة
                                ( {{round($totalBeforeTax,2)}} )
                            </div>
                            <div class="badge badge-dark p-1" style="width: auto;font-weight: bold;margin-right:4px;">
                                اجمالي الضريبة لنقطة البيع
                                ( {{round($totalTax,2)}} )
                            </div>
                            <div class="badge badge-primary p-1"
                                 style="width: auto;font-weight: bold;margin-right:4px;">
                                اجمالى اسعار كل الفواتير
                                ( {{round($total,2)}} ) {{$currency}}
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="mt-3 no-print">
                            <button type="button" onclick="window.print()" class="btn btn-md btn-info pull-right">
                                <i class="fa fa-print"></i>
                                طباعة التقرير
                            </button>
                        </div>

                    @else
                        <div class="alert alert-sm alert-danger text-center mt-3">
                            <i class="fa fa-close"></i>
                            لا توجد اى فواتير كاشير لهذا المنتج
                        </div>
                    @endif
                    <div class="clearfix"></div>


                    <!--*******************************START_SALE_BILLS**********************************-->
                    <?php $totalTax = 0;$totalBeforeTax = 0; ?>
                    @if(isset($saleBills) && !empty($saleBills))
                        <p class="alert alert-sm alert-danger mt-2 mb-2 text-center">
                            تقرير مبيعات حسب المنتج
                        </p>
                        <div class="table-responsive">
                            <table class='table table-condensed table-striped table-bordered'>
                                <thead class="text-center">
                                <th>#</th>
                                <th>رقم الفاتورة</th>
                                <th>العميل</th>
                                <th>تاريخ الفاتورة</th>
                                <th>الاجمالى شامل الضريبة</th>
                                <th>مبلغ الضريبة</th>
                                <th>الاجمالى قبل الضريبة</th>
                                <th>عدد العناصر</th>
                                </thead>
                                <tbody>
                                @foreach($saleBills as $sale_bill)

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

                                        <!--date--->
                                        <td>{{$sale_bill->date}}</td>

                                        <!--final_total--->
                                        <td>
                                            <!--get total price of products--->
                                            <?php $sum = 0;$realTaxValue = 0; ?>
                                            @foreach($sale_bill->elements as $element)
                                                <?php $sum = $sum + $element->quantity_price; ?>
                                            @endforeach
                                            <?php

                                            //---get discount and shipping---//
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
                                                $total_sale = $sum * (100 / 115);
                                                $total_with_option = $total_sale;
                                                $tax_value = (15 / 100) * $total_with_option;
                                                $after_total = $tax_value + $total_with_option;
                                            }
                                            echo round($after_total, 2) . " " . $currency;
                                            ?>
                                            <?php $total = $total + $after_total; ?>
                                        </td>

                                        <!---------TAX_VALUE------->
                                        <td>
                                            <?php
                                            if ($sale_bill->value_added_tax) {//inclusive
                                                $realTaxValue = $after_total - ((100 / 115) * $after_total);
                                                $totalBeforeTax += ((100 / 115) * $after_total);
                                                echo round($realTaxValue, 2);
                                                $totalTax += $realTaxValue;
                                            } else {
                                                $realTaxValue = (($sum * 15) / 100);
                                                $totalBeforeTax = $totalBeforeTax + ($after_total - $realTaxValue);

                                                echo $realTaxValue;
                                                $totalTax += $realTaxValue;
                                            }

                                            ?>
                                        </td>
                                        <td>{{ round($after_total - $realTaxValue, 2) }}</td>
                                        <td>{{$sale_bill->elements->count()}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-3">

                            <div class="badge badge-success p-2 mr-1" style="width: auto;font-weight: bold;">
                                عدد الفواتير
                                ( {{$i}} )
                            </div>
                            <div class="badge badge-danger p-2 mr-1" style="width: auto;font-weight: bold;">
                                اجمالي المبيعات قبل الضريبة
                                ( {{round($totalBeforeTax,2)}} )
                            </div>
                            <div class="badge badge-dark p-2 mr-1" style="width: auto;font-weight: bold;">
                                اجمالي الضريبة للمبيعات
                                ( {{round($totalTax,2)}} )
                            </div>
                            <div class="badge badge-primary p-2 mr-1" style="width: auto;font-weight: bold;">
                                اجمالى اسعار كل الفواتير
                                ( {{round($total,2)}} ) {{$currency}}
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="mt-3 no-print">
                            <button type="button" onclick="window.print()" class="btn btn-md btn-info pull-right">
                                <i class="fa fa-print"></i>
                                طباعة التقرير
                            </button>
                        </div>
                    @elseif(isset($saleBills) && empty($saleBills))
                        <div class="alert alert-sm alert-danger text-center mt-3">
                            <i class="fa fa-close"></i>
                            لا توجد اى فواتير لهذا المنتج
                        </div>
                @endif
                <!--*******************************END_SALE_BILLS**********************************-->

                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{asset('app-assets/js/jquery.min.js')}}"></script>
<script>

</script>
