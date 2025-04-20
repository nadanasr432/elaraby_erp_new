```php
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

    .summary-card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-top: 20px;
        background: #f8f9fc;
    }

    .summary-card h4 {
        font-size: 1.5rem;
        color: #4e73df;
        margin-bottom: 20px;
        text-align: center;
    }

    .summary-item {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
        background: #ffffff;
        border-radius: 8px;
        margin: 10px 0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .summary-item i {
        font-size: 1.5rem;
        margin-left: 10px;
    }

    .summary-item span {
        font-size: 1.2rem;
        font-weight: bold;
    }
</style>
@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">×</span>
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

                    @php
                        $i = 0;
                        $total = 0;
                        $total_cost = 0;
                        $total_profits = 0;

                        // Fetch all necessary products at once for pos_bills
                        $productPrices = \App\Models\Product::whereIn('id', $pos_bills->pluck('elements.*.product_id')->flatten())
                            ->where('company_id', $pos_bills->pluck('company_id')->unique())
                            ->pluck('purchasing_price', 'id');
                    @endphp

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
                                @foreach ($pos_bills as $pos)
                                    @php
                                        $i++;
                                        $sum = 0;
                                        $realPrice = 0;

                                        foreach ($pos->elements as $pos_element) {
                                            $sum += $pos_element->quantity_price;
                                            $realPrice += ($productPrices[$pos_element->product_id] ?? 0) * $pos_element->quantity;
                                        }

                                        // Apply Discount
                                        if ($pos->discount) {
                                            $discount = $pos->discount->discount_value;
                                            $sum -= ($pos->discount->discount_type === "pound") ? $discount : ($discount / 100) * $sum;
                                        }

                                        // Apply Tax
                                        if ($pos->tax) {
                                            $sum += ($pos->tax->tax_value / 100) * $sum;
                                        }

                                        // Value Added Tax Adjustment
                                        if ($pos->value_added_tax == 1) {
                                            $sum = ($sum * (100 / 115)) * 1.15;
                                        }

                                        $sum = round($sum, 2);
                                        $total += $sum;
                                        $total_cost += $realPrice;
                                        $profit = $sum - $realPrice;
                                        $total_profits += $profit;
                                    @endphp

                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $pos->company_counter }}</td>
                                        <td>{{ $pos->outerClient->client_name ?? 'زبون' }}</td>
                                        <td>{{ $pos->created_at }}</td>
                                        <td>{{ $sum }}</td>
                                        <td>{{ $realPrice }}</td>
                                        <td>{{ $profit }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <div class="clearfix"></div>

                    @if(isset($sale_bills) && !$sale_bills->isEmpty())
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
                                            @php
                                                $sum = 0;
                                                $realPrice = 0;
                                                foreach($sale_bill->elements as $element) {
                                                    $sum += $element->quantity_price;
                                                    $realProduct = \App\Models\Product::where('company_id', $sale_bill->company_id)
                                                        ->where('id', $element->product_id)
                                                        ->firstOrFail();
                                                    $realPrice += ($realProduct->purchasing_price * $element->quantity) ?? ($element->product_price * $element->quantity);
                                                }

                                                $sale_bill_discount_value = 0;
                                                $sale_bill_extra_value = 0;
                                                $sale_bill_discount_type = "pound";
                                                $sale_bill_extra_type = "pound";
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
                                                $after_discount = $sum - $sale_bill_discount_value + $sale_bill_extra_value;
                                                $tax_value_added = $company->tax_value_added;
                                                $percentage = ($tax_value_added / 100) * $after_discount;
                                                $after_total = $after_discount + $percentage;

                                                $tax_option = $sale_bill->value_added_tax;
                                                if ($tax_option == 1) {
                                                    $total_sale = $sale_bill->final_total * (100 / 115);
                                                    echo round($total_sale, 2);
                                                } else {
                                                    echo round($after_total, 2);
                                                }

                                                $total += $after_total;
                                                $total_cost += $realPrice;
                                                $finalTotal = ($after_total - $realPrice);
                                                $total_profits += $finalTotal;
                                            @endphp
                                        </td>
                                        <td>{{$realPrice}}</td>
                                        <td>{{$finalTotal}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @elseif(isset($sale_bills) && $sale_bills->isEmpty() && isset($pos_bills) && $pos_bills->isEmpty())
                        <div class="alert alert-sm alert-danger text-center mt-3">
                            <i class="fa fa-close"></i>
                            لا توجد اى فواتير
                        </div>
                    @endif

                    <!-- Single Summary Section for Both POS and Sale Bills -->
                    @if((isset($pos_bills) && !$pos_bills->isEmpty()) || (isset($sale_bills) && !$sale_bills->isEmpty()))
                        <div class="summary-card">
                            <h4>ملخص التقرير</h4>
                            <div class="row justify-content-center">
                                <div class="col-md-4">
                                    <div class="summary-item badge-info">
                                        <i class="fa fa-money"></i>
                                        <span>إجمالي المبيعات: {{ round($total, 2) }} {{$company->currency}}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="summary-item badge-warning">
                                        <i class="fa fa-shopping-cart"></i>
                                        <span>إجمالي التكلفة: {{ round($total_cost, 2) }} {{$company->currency}}</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="summary-item badge-success">
                                        <i class="fa fa-line-chart"></i>
                                        <span>إجمالي الأرباح: {{ round($total_profits, 2) }} {{$company->currency}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center mt-3">
                                <div class="col-md-4">
                                    <div class="summary-item badge-primary">
                                        <i class="fa fa-file-invoice"></i>
                                        <span>عدد الفواتير: {{ $i }}</span>
                                    </div>
                                </div>
                            </div>
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
```
