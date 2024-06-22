@extends('client.layouts.app-main')
<style>

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
                    <h2 style="font-size: 30px!important;">
                        تقرير دفتر اليومية
                    </h2>
                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-lg-12 no-print"
                            style="border: 1px solid #dedede; padding: 20px;margin-bottom: 20px;">
                            <form action="{{ route('client.daily.post') }}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="pull-right col-lg-4 no-print">
                                    <div class="form-group" dir="rtl">
                                        <label style="display:block;" for="category">{{ __('main.from-date') }}</label>
                                        <input type="date" required name="from_date" class="form-control"
                                            value="<?= isset($from_date) ? $from_date : date('Y-m-d') ?>">
                                    </div>
                                </div>
                                <div class="col-lg-4 pull-right no-print">
                                    <div class="form-group" dir="rtl">
                                        <label style="display:block;" for="category">{{ __('main.to-date') }}</label>
                                        <input type="date" required name="to_date" class="form-control"
                                            value="<?= isset($to_date) ? $to_date : date('Y-m-d', strtotime('+1 day')) ?>">
                                    </div>
                                </div>
                                <div class="col-lg-4 no-print pull-right">
                                    <button type="submit" class="btn btn-md btn-danger"
                                        style="display: inline !important;width: 20% !important; float: right !important;
                                                                                        font-size: 20px; height: 40px; margin-top: 25px;" id="by_emp_name"><i
                                            class="fa fa-search"></i></button>
                                </div>
                            </form>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div id="daily_details" style="border: 1px solid #dedede; padding: 20px;margin-bottom: 20px;">
                        @if (isset($saleBills) || isset($buyBills) || isset($posBills))
                            <p class="alert alert-sm alert-danger mt-3 text-center">
                                {{ __('main.tax-report') }}
                            </p>
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-bordered text-center table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">{{ __('main.taxes-amount') }}</th>
                                            <th class="text-center">{{ __('main.invoice-type') }}</th>
                                            <th class="text-center">{{ __('sales_bills.invoice-number') }}</th>
                                            <th class="text-center"> {{ __('main.invoice-sales-revenue') }}</th>
                                            <th class="text-center">{{ __('main.date') }} - {{ __('main.time') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 0;
                                            $taxes = 0;
                                        @endphp
                                        @foreach ($saleBills as $sale_bill)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>
                                                    <?php $sum = 0; ?>
                                                    @foreach ($sale_bill->elements as $element)
                                                        <?php $sum = $sum + $element->quantity_price; ?>
                                                    @endforeach
                                                    <?php
                                                    $extras = $sale_bill->extras;
                                                    foreach ($extras as $key) {
                                                        if ($key->action == 'discount') {
                                                            if ($key->action_type == 'pound') {
                                                                $sale_bill_discount_value = $key->value;
                                                                $sale_bill_discount_type = 'pound';
                                                            } else {
                                                                $sale_bill_discount_value = $key->value;
                                                                $sale_bill_discount_type = 'percent';
                                                            }
                                                        } else {
                                                            if ($key->action_type == 'pound') {
                                                                $sale_bill_extra_value = $key->value;
                                                                $sale_bill_extra_type = 'pound';
                                                            } else {
                                                                $sale_bill_extra_value = $key->value;
                                                                $sale_bill_extra_type = 'percent';
                                                            }
                                                        }
                                                    }
                                                    if ($extras->isEmpty()) {
                                                        $sale_bill_discount_value = 0;
                                                        $sale_bill_extra_value = 0;
                                                        $sale_bill_discount_type = 'pound';
                                                        $sale_bill_extra_type = 'pound';
                                                    }
                                                    if ($sale_bill_extra_type == 'percent') {
                                                        $sale_bill_extra_value = ($sale_bill_extra_value / 100) * $sum;
                                                    }
                                                    $after_discount = $sum + $sale_bill_extra_value;
                                                    
                                                    if ($sale_bill_discount_type == 'percent') {
                                                        $sale_bill_discount_value = ($sale_bill_discount_value / 100) * $sum;
                                                    }
                                                    $after_discount = $sum - $sale_bill_discount_value;
                                                    $after_discount = $sum - $sale_bill_discount_value + $sale_bill_extra_value;
                                                    $tax_value_added = $company->tax_value_added;
                                                    $percentage = ($tax_value_added / 100) * $after_discount;
                                                    $after_total = $after_discount + $percentage;
                                                    ?>
                                                    {{ $percentage }} {{ $currency }}
                                                    <?php $taxes = $taxes + $percentage; ?>
                                                </td>
                                                <td>فاتورة مبيعات ضريبية</td>
                                                <td>{{ $sale_bill->company_counter }}</td>
                                                <td>{{ $after_total }} {{ $currency }}</td>
                                                <td>{{ $sale_bill->created_at }}</td>
                                            </tr>
                                        @endforeach
                                        @foreach ($buyBills as $buy_bill)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>
                                                    <?php $sum = 0; ?>
                                                    @foreach ($buy_bill->elements as $element)
                                                        <?php $sum = $sum + $element->quantity_price; ?>
                                                    @endforeach
                                                    <?php
                                                    $extras = $buy_bill->extras;
                                                    foreach ($extras as $key) {
                                                        if ($key->action == 'discount') {
                                                            if ($key->action_type == 'pound') {
                                                                $buy_bill_discount_value = $key->value;
                                                                $buy_bill_discount_type = 'pound';
                                                            } else {
                                                                $buy_bill_discount_value = $key->value;
                                                                $buy_bill_discount_type = 'percent';
                                                            }
                                                        } else {
                                                            if ($key->action_type == 'pound') {
                                                                $buy_bill_extra_value = $key->value;
                                                                $buy_bill_extra_type = 'pound';
                                                            } else {
                                                                $buy_bill_extra_value = $key->value;
                                                                $buy_bill_extra_type = 'percent';
                                                            }
                                                        }
                                                    }
                                                    if ($extras->isEmpty()) {
                                                        $buy_bill_discount_value = 0;
                                                        $buy_bill_extra_value = 0;
                                                        $buy_bill_discount_type = 'pound';
                                                        $buy_bill_extra_type = 'pound';
                                                    }
                                                    if ($buy_bill_extra_type == 'percent') {
                                                        $buy_bill_extra_value = ($buy_bill_extra_value / 100) * $sum;
                                                    }
                                                    $after_discount = $sum + $buy_bill_extra_value;
                                                    
                                                    if ($buy_bill_discount_type == 'percent') {
                                                        $buy_bill_discount_value = ($buy_bill_discount_value / 100) * $sum;
                                                    }
                                                    $after_discount = $sum - $buy_bill_discount_value;
                                                    $after_discount = $sum - $buy_bill_discount_value + $buy_bill_extra_value;
                                                    $tax_value_added = $company->tax_value_added;
                                                    $percentage = ($tax_value_added / 100) * $after_discount;
                                                    $after_total = $after_discount + $percentage;
                                                    ?>
                                                    {{ $percentage }} {{ $currency }}
                                                    <?php $taxes = $taxes + $percentage; ?>
                                                </td>
                                                <td>فاتورة مشتريات ضريبية</td>
                                                <td>{{ $buy_bill->buy_bill_number }}</td>
                                                <td>{{ $after_total }} {{ $currency }}</td>
                                                <td>{{ $buy_bill->created_at }}</td>
                                            </tr>
                                        @endforeach
                                        @foreach ($posBills as $pos)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>
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
                                                        $percent = ($tax_value / 100) * $sum;
                                                        $sum = $sum + $percent;
                                                    } elseif (isset($pos) && isset($pos_discount) && empty($pos_tax)) {
                                                        $discount_value = $pos_discount->discount_value;
                                                        $discount_type = $pos_discount->discount_type;
                                                        if ($discount_type == 'pound') {
                                                            $sum = $sum - $discount_value;
                                                        } else {
                                                            $discount_value = ($discount_value / 100) * $sum;
                                                            $sum = $sum - $discount_value;
                                                        }
                                                    } elseif (isset($pos) && !empty($pos_discount) && !empty($pos_tax)) {
                                                        $tax_value = $pos_tax->tax_value;
                                                        $discount_value = $pos_discount->discount_value;
                                                        $discount_type = $pos_discount->discount_type;
                                                        if ($discount_type == 'pound') {
                                                            $sum = $sum - $discount_value;
                                                        } else {
                                                            $discount_value = ($discount_value / 100) * $sum;
                                                            $sum = $sum - $discount_value;
                                                        }
                                                        $percent = ($tax_value / 100) * $sum;
                                                        $sum = $sum + $percent;
                                                    }
                                                    echo $percent . ' ' . $currency;
                                                    $taxes = $taxes + $percent;
                                                    ?>
                                                </td>
                                                <td>فاتورة كاشير نقطة بيع</td>
                                                <td>{{ $pos->id }}</td>
                                                <td>{{ $sum }} {{ $currency }}</td>
                                                <td>{{ $pos->created_at }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <p style="font-size: 17px!important;" class="alert alert-danger alert-md" dir="rtl">
                                        {{ __('main.taxes-amount') }} :
                                        {{ $taxes }} {{ $currency }}
                                    </p>
                                </div>
                            </div>
                        @endif
                        <div class="clearfix"></div>
                        @if (isset($gifts) && !$gifts->isEmpty())
                            <p class="alert alert-sm alert-success mt-3 text-center">
                                {{ __('main.gifts') }}
                            </p>
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-bordered text-center table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">{{ __('sales_bills.client-name') }}</th>
                                            <th class="text-center">{{ __('main.client-name') }}</th>
                                            <th class="text-center">{{ __('main.quantity') }}</th>
                                            <th class="text-center">{{ __('main.product-balance-before') }}</th>
                                            <th class="text-center">{{ __('main.product-balance-after') }}</th>
                                            <th class="text-center">{{ __('main.store') }}</th>
                                            <th class="text-center">{{ __('main.notes') }}</th>
                                            <th class="text-center">{{ __('main.date') }} - {{ __('main.time') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($gifts as $key => $gift)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $gift->outerClient->client_name }}</td>
                                                <td>{{ $gift->product->product_name }}</td>
                                                <td>
                                                    {{ floatval($gift->amount) }}
                                                </td>
                                                <td>
                                                    {{ floatval($gift->balance_before) }}
                                                </td>
                                                <td>
                                                    {{ floatval($gift->balance_after) }}
                                                </td>
                                                <td>{{ $gift->store->store_name }}</td>
                                                <td>{{ $gift->notes }}</td>
                                                <td>{{ $gift->created_at }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                        <div class="clearfix"></div>
                        @if (isset($quotations) && !$quotations->isEmpty())
                            <p class="alert alert-sm alert-info mt-3 text-center">
                                عروض الاسعار
                            </p>
                            <div class="table-responsive">
                                <table class='table table-condensed table-striped table-bordered'>
                                    <thead class="text-center">
                                        <th>#</th>
                                        <th>رقم عرض السعر</th>
                                        <th>العميل</th>
                                        <th> بداية العرض</th>
                                        <th> نهاية العرض</th>
                                        <th>الاجمالى النهائى</th>
                                        <th> القيمة المضافة</th>
                                        <th>عدد العناصر</th>
                                        <th>ملاحظات</th>
                                        <th class="no-print">عرض</th>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0;
                                        $total = 0; ?>
                                        @foreach ($quotations as $quotation)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $quotation->quotation_number }}</td>
                                                <td>{{ $quotation->outerClient->client_name }}</td>
                                                <td>{{ $quotation->start_date }}</td>
                                                <td>{{ $quotation->expiration_date }}</td>
                                                <td>
                                                    <?php $sum = 0; ?>
                                                    @foreach ($quotation->elements as $element)
                                                        <?php $sum = $sum + $element->quantity_price; ?>
                                                    @endforeach
                                                    <?php
                                                    $extras = $quotation->extras;
                                                    foreach ($extras as $key) {
                                                        if ($key->action == 'discount') {
                                                            if ($key->action_type == 'pound') {
                                                                $quotation_discount_value = $key->value;
                                                                $quotation_discount_type = 'pound';
                                                            } else {
                                                                $quotation_discount_value = $key->value;
                                                                $quotation_discount_type = 'percent';
                                                            }
                                                        } else {
                                                            if ($key->action_type == 'pound') {
                                                                $quotation_extra_value = $key->value;
                                                                $quotation_extra_type = 'pound';
                                                            } else {
                                                                $quotation_extra_value = $key->value;
                                                                $quotation_extra_type = 'percent';
                                                            }
                                                        }
                                                    }
                                                    if ($extras->isEmpty()) {
                                                        $quotation_discount_value = 0;
                                                        $quotation_extra_value = 0;
                                                        $quotation_discount_type = 'pound';
                                                        $quotation_extra_type = 'pound';
                                                    }
                                                    if ($quotation_extra_type == 'percent') {
                                                        $quotation_extra_value = ($quotation_extra_value / 100) * $sum;
                                                    }
                                                    $after_discount = $sum + $quotation_extra_value;
                                                    
                                                    if ($quotation_discount_type == 'percent') {
                                                        $quotation_discount_value = ($quotation_discount_value / 100) * $sum;
                                                    }
                                                    $after_discount = $sum - $quotation_discount_value;
                                                    $after_discount = $sum - $quotation_discount_value + $quotation_extra_value;
                                                    $tax_value_added = $company->tax_value_added;
                                                    $percentage = ($tax_value_added / 100) * $after_discount;
                                                    $after_total = $after_discount + $percentage;
                                                    echo floatval($after_total) . ' ' . $currency;
                                                    ?>
                                                    <?php $total = $total + $after_total; ?>
                                                </td>
                                                <td>{{ $percentage }} {{ $currency }}</td>
                                                <td>{{ $quotation->elements->count() }}</td>
                                                <th>{{ $quotation->notes }}</th>
                                                <td class="no-print">
                                                    <form target="_blank"
                                                        action="{{ route('client.quotations.filter.key') }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('POST')
                                                        <input type="hidden" name="quotation_id"
                                                            value="{{ $quotation->id }}">
                                                        <button type="submit" class="btn btn-sm btn-success">
                                                            <i class="fa fa-eye"></i> عرض
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                        <div class="clearfix"></div>
                        @if (isset($posBills) && !$posBills->isEmpty())
                            <p class="alert alert-sm alert-primary mt-3 text-center">
                                فواتير الكاشير ( نقطة البيع )
                            </p>
                            <div class="table-responsive">
                                <table border="1" cellpadding="14" style="width: 100%!important;">
                                    <thead class="text-center">
                                        <tr>
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
                                            $sum1 = 0;
                                            $sum2 = 0;
                                            $sum3 = 0;
                                        @endphp
                                        @foreach ($posBills as $key => $pos)
                                            <tr>
                                                <td>{{ $pos->id }}</td>
                                                <td>
                                                    @if (isset($pos->outerClient->client_name))
                                                        {{ $pos->outerClient->client_name }}
                                                    @else
                                                        زبون
                                                    @endif
                                                </td>
                                                <td>{{ $pos->created_at }}</td>
                                                <td>
                                                    <?php $merchandise_cost = 0; ?>
                                                    @foreach ($pos->elements as $element)
                                                        <?php $merchandise_cost = $merchandise_cost + $element->product->purchasing_price * $element->quantity; ?>
                                                    @endforeach
                                                    {{ $merchandise_cost }}
                                                </td>
                                                <td>
                                                    @if (isset($pos))
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
                                                            $percent = ($tax_value / 100) * $sum;
                                                            $sum = $sum + $percent;
                                                        } elseif (isset($pos) && isset($pos_discount) && empty($pos_tax)) {
                                                            $discount_value = $pos_discount->discount_value;
                                                            $discount_type = $pos_discount->discount_type;
                                                            if ($discount_type == 'pound') {
                                                                $sum = $sum - $discount_value;
                                                            } else {
                                                                $discount_value = ($discount_value / 100) * $sum;
                                                                $sum = $sum - $discount_value;
                                                            }
                                                        } elseif (isset($pos) && !empty($pos_discount) && !empty($pos_tax)) {
                                                            $tax_value = $pos_tax->tax_value;
                                                            $discount_value = $pos_discount->discount_value;
                                                            $discount_type = $pos_discount->discount_type;
                                                            if ($discount_type == 'pound') {
                                                                $sum = $sum - $discount_value;
                                                            } else {
                                                                $discount_value = ($discount_value / 100) * $sum;
                                                                $sum = $sum - $discount_value;
                                                            }
                                                            $percent = ($tax_value / 100) * $sum;
                                                            $sum = $sum + $percent;
                                                        }
                                                        echo $sum;
                                                        $sum1 = $sum1 + $sum;
                                                        ?>
                                                    @else
                                                        0
                                                    @endif
                                                </td>
                                                <td>{{ $percent }}</td>
                                                <td>
                                                    <?php
                                                    $bill_id = 'pos_' . $pos->id;
                                                    $check = App\Models\Cash::where('bill_id', $bill_id)->first();
                                                    if (empty($check)) {
                                                        $check2 = App\Models\BankCash::where('bill_id', $bill_id)->first();
                                                        if (empty($check2)) {
                                                            echo 'غير مدفوعة';
                                                        } else {
                                                            echo 'شيك بنكى' . ' ( ' . $check2->bank->bank_name . ' ) ';
                                                            $paid = $check2->amount;
                                                            $rest = $sum1 - $paid;
                                                            echo '<br/>';
                                                            echo 'مستحق ' . $sum1;
                                                            echo '<br/>';
                                                            echo 'مدفوع ' . $paid;
                                                            echo '<br/>';
                                                            echo 'متبقى ' . $rest;
                                                        }
                                                    } else {
                                                        echo 'نقدى كاش' . ' ( ' . $check->safe->safe_name . ' ) ';
                                                        $paid = $check->amount;
                                                        $rest = $sum1 - $paid;
                                                        echo '<br/>';
                                                        echo 'مستحق ' . $sum1;
                                                        echo '<br/>';
                                                        echo 'مدفوع ' . $paid;
                                                        echo '<br/>';
                                                        echo 'متبقى ' . $rest;
                                                    }
                                                    ?>
                                                </td>
                                                <td>{{ $pos->notes }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                        <div class="clearfix"></div>

                        @if (isset($saleBills) && !$saleBills->isEmpty())
                            <p class="alert alert-sm alert-primary mt-3 text-center">
                                فواتير البيع
                            </p>
                            <div class="table-responsive">
                                <table border="1" cellpadding="14" style="width: 100%!important;">
                                    <thead class="text-center">
                                        <th>رقم</th>
                                        <th>عميل</th>
                                        <th>تاريخ - وقت</th>
                                        <th> تكلفة بضاعة</th>
                                        <th>ايراد مبيعات</th>
                                        <th> ضريبة مبيعات</th>
                                        <th style="min-width: 200px!important;">طريقة الدفع</th>
                                        <th>ملاحظات</th>
                                        <th class="no-print">عرض</th>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0;
                                        $total = 0; ?>
                                        @foreach ($saleBills as $sale_bill)
                                            <tr>
                                                <td>{{ $sale_bill->company_counter }}</td>
                                                <td>
                                                    @if (empty($sale_bill->outer_client_id))
                                                        عميل مبيعات نقدية
                                                    @else
                                                        {{ $sale_bill->outerClient->client_name }}
                                                    @endif
                                                </td>
                                                <td>{{ $sale_bill->date }} <br> {{ $sale_bill->time }}</td>
                                                <td>
                                                    <?php $merchandise_cost = 0; ?>
                                                    @foreach ($sale_bill->elements as $element)
                                                        <?php $merchandise_cost = $merchandise_cost + $element->product->purchasing_price * $element->quantity; ?>
                                                    @endforeach
                                                    {{ $merchandise_cost }}
                                                </td>
                                                <td>
                                                    <?php $sum = 0; ?>
                                                    @foreach ($sale_bill->elements as $element)
                                                        <?php $sum = $sum + $element->quantity_price; ?>
                                                    @endforeach
                                                    <?php
                                                    $extras = $sale_bill->extras;
                                                    foreach ($extras as $key) {
                                                        if ($key->action == 'discount') {
                                                            if ($key->action_type == 'pound') {
                                                                $sale_bill_discount_value = $key->value;
                                                                $sale_bill_discount_type = 'pound';
                                                            } else {
                                                                $sale_bill_discount_value = $key->value;
                                                                $sale_bill_discount_type = 'percent';
                                                            }
                                                        } else {
                                                            if ($key->action_type == 'pound') {
                                                                $sale_bill_extra_value = $key->value;
                                                                $sale_bill_extra_type = 'pound';
                                                            } else {
                                                                $sale_bill_extra_value = $key->value;
                                                                $sale_bill_extra_type = 'percent';
                                                            }
                                                        }
                                                    }
                                                    if ($extras->isEmpty()) {
                                                        $sale_bill_discount_value = 0;
                                                        $sale_bill_extra_value = 0;
                                                        $sale_bill_discount_type = 'pound';
                                                        $sale_bill_extra_type = 'pound';
                                                    }
                                                    if ($sale_bill_extra_type == 'percent') {
                                                        $sale_bill_extra_value = ($sale_bill_extra_value / 100) * $sum;
                                                    }
                                                    $after_discount = $sum + $sale_bill_extra_value;
                                                    
                                                    if ($sale_bill_discount_type == 'percent') {
                                                        $sale_bill_discount_value = ($sale_bill_discount_value / 100) * $sum;
                                                    }
                                                    $after_discount = $sum - $sale_bill_discount_value;
                                                    $after_discount = $sum - $sale_bill_discount_value + $sale_bill_extra_value;
                                                    $tax_value_added = $company->tax_value_added;
                                                    $percentage = ($tax_value_added / 100) * $after_discount;
                                                    $after_total = $after_discount + $percentage;
                                                    echo floatval($after_total) . ' ' . $currency;
                                                    ?>
                                                    <?php $total = $total + $after_total; ?>
                                                </td>
                                                <td>{{ $percentage }} {{ $currency }}</td>
                                                <td style="min-width: 200px!important;">
                                                    <?php
                                                    $bill_id = $sale_bill->sale_bill_number;
                                                    $check = App\Models\Cash::where('bill_id', $bill_id)->first();
                                                    if (empty($check)) {
                                                        $check2 = App\Models\BankCash::where('bill_id', $bill_id)->first();
                                                        if (empty($check2)) {
                                                            echo 'غير مدفوعة';
                                                        } else {
                                                            echo 'شيك بنكى' . ' ( ' . $check2->bank->bank_name . ' ) ';
                                                            $paid = $check2->amount;
                                                            $rest = $total - $paid;
                                                            echo '<br/>';
                                                            echo 'مستحق ' . $total;
                                                            echo '<br/>';
                                                            echo 'مدفوع ' . $paid;
                                                            echo '<br/>';
                                                            echo 'متبقى ' . $rest;
                                                        }
                                                    } else {
                                                        echo ' نقدى كاش' . ' ( ' . $check->safe->safe_name . ' ) ';
                                                        $paid = $check->amount;
                                                        $rest = $total - $paid;
                                                        echo '<br/>';
                                                        echo 'مستحق ' . $total;
                                                        echo '<br/>';
                                                        echo 'مدفوع ' . $paid;
                                                        echo '<br/>';
                                                        echo 'متبقى ' . $rest;
                                                    }
                                                    ?>
                                                </td>
                                                <td>{{ $sale_bill->notes }}</td>
                                                <td class="no-print">
                                                    <form target="_blank"
                                                        action="{{ route('client.sale_bills.filter.key') }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('POST')
                                                        <input type="hidden" name="sale_bill_id"
                                                            value="{{ $sale_bill->id }}">
                                                        <button type="submit" class="btn btn-sm btn-success">
                                                            <i class="fa fa-eye"></i> عرض
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                        <div class="clearfix"></div>
                        @if (isset($returns) && !$returns->isEmpty())
                            <p class="alert alert-sm alert-dark mt-3 text-center">
                                مرتجعات فواتير البيع
                            </p>
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-bordered text-center table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">رقم الفاتورة</th>
                                            <th class="text-center"> العميل</th>
                                            <th class="text-center"> المنتج</th>
                                            <th class="text-center"> الكمية المرتجعة</th>
                                            <th class="text-center"> الوقت</th>
                                            <th class="text-center"> التاريخ</th>
                                            <th class="text-center"> سعر المنتج</th>
                                            <th class="text-center"> سعر الكمية</th>
                                            <th class="text-center"> مديونية العميل قبل الارتجاع</th>
                                            <th class="text-center"> مديونية العميل بعد الارتجاع</th>
                                            <th class="text-center"> رصيد المنتج قبل الارتجاع</th>
                                            <th class="text-center"> رصيد المنتج بعد الارتجاع</th>
                                            <th class="text-center">ملاحظات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($returns as $key => $return)
                                            <tr>
                                                <td>{{ $return->bill_id }}</td>
                                                <td>
                                                    @if (empty($return->outer_client_id))
                                                        عميل مبيعات نقدية
                                                    @else
                                                        {{ $return->outerClient->client_name }}
                                                    @endif
                                                </td>
                                                <td>{{ $return->product->product_name }}</td>
                                                <td>
                                                    {{ floatval($return->return_quantity) }}
                                                </td>
                                                <td>{{ $return->date }}</td>
                                                <td>{{ $return->time }}</td>
                                                <td>
                                                    {{ floatval($return->product_price) }}
                                                </td>
                                                <td>
                                                    {{ floatval($return->quantity_price) }}
                                                </td>
                                                <td>
                                                    {{ floatval($return->balance_before) }}
                                                </td>
                                                <td>
                                                    {{ floatval($return->balance_after) }}
                                                </td>

                                                <td>
                                                    {{ floatval($return->before_return) }}
                                                </td>
                                                <td>
                                                    {{ floatval($return->after_return) }}
                                                </td>
                                                <td>
                                                    {{ $return->notes }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                        <div class="clearfix"></div>
                        @if (isset($bankcashs) && isset($cashs))
                            <p class="alert alert-sm alert-warning mt-3 text-center">
                                مدفوعات العملاء (نقدية او بنكية)
                            </p>
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-bordered text-center table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">رقم العملية</th>
                                            <th class="text-center">العميل</th>
                                            <th class="text-center">المبلغ</th>
                                            <th class="text-center">رقم الفاتورة</th>
                                            <th class="text-center">تاريخ ووقت</th>
                                            <th class="text-center"> تفاصيل الدفع</th>
                                            <th class="text-center">نوع العملية</th>
                                            <th class="text-center">ملاحظات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($bankcashs as $key => $cash)
                                            <tr>
                                                <td>{{ $cash->cash_number }}</td>
                                                <td>
                                                    @if (empty($cash->outer_client_id))
                                                        عميل مبيعات نقدية
                                                    @else
                                                        {{ $cash->outerClient->client_name }}
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ floatval($cash->amount) }}
                                                </td>
                                                <td>{{ $cash->bill_id }}</td>
                                                <td>{{ $cash->date }}
                                                    <br>
                                                    {{ $cash->time }}
                                                </td>
                                                <td>{{ $cash->bank->bank_name }}
                                                    <br>
                                                    {{ $cash->bank_check_number }}
                                                </td>
                                                <td>دفع بنكى</td>
                                                <td>{{ $cash->notes }}</td>
                                            </tr>
                                        @endforeach
                                        @foreach ($cashs as $key => $cash)
                                            <tr>
                                                <td>{{ $cash->cash_number }}</td>
                                                <td>
                                                    @if (empty($cash->outer_client_id))
                                                        عميل مبيعات نقدية
                                                    @else
                                                        {{ $cash->outerClient->client_name }}
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ floatval($cash->amount) }}
                                                </td>
                                                <td>{{ $cash->bill_id }}</td>
                                                <td>{{ $cash->date }}
                                                    <br>
                                                    {{ $cash->time }}
                                                </td>
                                                <td>{{ $cash->safe->safe_name }}</td>
                                                <td>دفع نقدى</td>
                                                <td>
                                                    {{ $cash->notes }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                        <div class="clearfix"></div>
                        @if (isset($borrows) && !$borrows->isEmpty())
                            <p class="alert alert-sm alert-warning mt-3 text-center">
                                سلفيات الى العملاء
                            </p>
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-bordered text-center table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">رقم العملية</th>
                                            <th class="text-center">العميل</th>
                                            <th class="text-center">المبلغ</th>
                                            <th class="text-center">رقم الفاتورة</th>
                                            <th class="text-center">تاريخ ووقت</th>
                                            <th class="text-center">خزنة الدفع</th>
                                            <th class="text-center">ملاحظات</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($borrows as $key => $cash)
                                            <tr>
                                                <td>{{ $cash->cash_number }}</td>
                                                <td>
                                                    @if (empty($cash->outer_client_id))
                                                        عميل مبيعات نقدية
                                                    @else
                                                        {{ $cash->outerClient->client_name }}
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ floatval(abs($cash->amount)) }}
                                                </td>
                                                <td>{{ $cash->bill_id }}</td>
                                                <td>{{ $cash->date }}
                                                    <br>
                                                    {{ $cash->time }}
                                                </td>
                                                <td>{{ $cash->safe->safe_name }}</td>
                                                <td>{{ $cash->notes }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                        <div class="clearfix"></div>

                        @if (isset($buyBills) && !$buyBills->isEmpty())
                            <p class="alert alert-sm alert-primary mt-3 text-center">
                                فواتير المشتريات
                            </p>
                            <div class="table-responsive">
                                <table border="1" cellpadding="14" style="width: 100%!important;">
                                    <thead class="text-center">
                                        <th>رقم</th>
                                        <th>مورد</th>
                                        <th>تاريخ - وقت</th>
                                        <th>الاجمالى النهائى</th>
                                        <th> ضريبة مشتريات</th>
                                        <th style="min-width: 200px!important;">طريقة الدفع</th>
                                        <th>ملاحظات</th>
                                        <th class="no-print">عرض</th>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0;
                                        $total = 0; ?>
                                        @foreach ($buyBills as $buy_bill)
                                            <tr>
                                                <td>{{ $buy_bill->buy_bill_number }}</td>
                                                <td>{{ $buy_bill->supplier->supplier_name }}</td>
                                                <td>{{ $buy_bill->date }} <br> {{ $buy_bill->time }} </td>
                                                <td>
                                                    <?php $sum = 0; ?>
                                                    @foreach ($buy_bill->elements as $element)
                                                        <?php $sum = $sum + $element->quantity_price; ?>
                                                    @endforeach
                                                    <?php
                                                    $extras = $buy_bill->extras;
                                                    foreach ($extras as $key) {
                                                        if ($key->action == 'discount') {
                                                            if ($key->action_type == 'pound') {
                                                                $buy_bill_discount_value = $key->value;
                                                                $buy_bill_discount_type = 'pound';
                                                            } else {
                                                                $buy_bill_discount_value = $key->value;
                                                                $buy_bill_discount_type = 'percent';
                                                            }
                                                        } else {
                                                            if ($key->action_type == 'pound') {
                                                                $buy_bill_extra_value = $key->value;
                                                                $buy_bill_extra_type = 'pound';
                                                            } else {
                                                                $buy_bill_extra_value = $key->value;
                                                                $buy_bill_extra_type = 'percent';
                                                            }
                                                        }
                                                    }
                                                    if ($extras->isEmpty()) {
                                                        $buy_bill_discount_value = 0;
                                                        $buy_bill_extra_value = 0;
                                                        $buy_bill_discount_type = 'pound';
                                                        $buy_bill_extra_type = 'pound';
                                                    }
                                                    if ($buy_bill_extra_type == 'percent') {
                                                        $buy_bill_extra_value = ($buy_bill_extra_value / 100) * $sum;
                                                    }
                                                    $after_discount = $sum + $buy_bill_extra_value;
                                                    
                                                    if ($buy_bill_discount_type == 'percent') {
                                                        $buy_bill_discount_value = ($buy_bill_discount_value / 100) * $sum;
                                                    }
                                                    $after_discount = $sum - $buy_bill_discount_value;
                                                    $after_discount = $sum - $buy_bill_discount_value + $buy_bill_extra_value;
                                                    $tax_value_added = $company->tax_value_added;
                                                    $percentage = ($tax_value_added / 100) * $after_discount;
                                                    $after_total = $after_discount + $percentage;
                                                    echo floatval($after_total) . ' ' . $currency;
                                                    ?>
                                                    <?php $total = $total + $after_total; ?>
                                                </td>
                                                <td>{{ $percentage }} {{ $currency }}</td>
                                                <td style="min-width: 200px!important;">
                                                    <?php
                                                    $bill_id = $buy_bill->buy_bill_number;
                                                    $check = App\Models\BuyCash::where('bill_id', $bill_id)->first();
                                                    if (empty($check)) {
                                                        $check2 = App\Models\BankBuyCash::where('bill_id', $bill_id)->first();
                                                        if (empty($check2)) {
                                                            echo 'غير مدفوعة';
                                                        } else {
                                                            echo 'شيك بنكى' . ' ( ' . $check2->bank->bank_name . ' ) ';
                                                            $paid = $check2->amount;
                                                            $rest = $total - $paid;
                                                            echo '<br/>';
                                                            echo 'مستحق ' . $total;
                                                            echo '<br/>';
                                                            echo 'مدفوع ' . $paid;
                                                            echo '<br/>';
                                                            echo 'متبقى ' . $rest;
                                                        }
                                                    } else {
                                                        echo ' نقدى كاش' . ' ( ' . $check->safe->safe_name . ' ) ';
                                                        $paid = $check->amount;
                                                        $rest = $total - $paid;
                                                        echo '<br/>';
                                                        echo 'مستحق ' . $total;
                                                        echo '<br/>';
                                                        echo 'مدفوع ' . $paid;
                                                        echo '<br/>';
                                                        echo 'متبقى ' . $rest;
                                                    }
                                                    ?>
                                                </td>
                                                <td>{{ $buy_bill->notes }}</td>
                                                <td class="no-print">
                                                    <form target="_blank"
                                                        action="{{ route('client.buy_bills.filter.key') }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('POST')
                                                        <input type="hidden" name="buy_bill_id"
                                                            value="{{ $buy_bill->id }}">
                                                        <button type="submit" class="btn btn-sm btn-success">
                                                            <i class="fa fa-eye"></i> عرض
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                        <div class="clearfix"></div>
                        @if (isset($buyReturns) && !$buyReturns->isEmpty())
                            <p class="alert alert-sm alert-dark mt-3 text-center">
                                مرتجعات فواتير الشراء
                            </p>
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-bordered text-center table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">رقم الفاتورة</th>
                                            <th class="text-center"> المورد</th>
                                            <th class="text-center"> المنتج</th>
                                            <th class="text-center"> الكمية المرتجعة</th>
                                            <th class="text-center"> الوقت</th>
                                            <th class="text-center"> التاريخ</th>
                                            <th class="text-center"> سعر المنتج</th>
                                            <th class="text-center"> سعر الكمية</th>
                                            <th class="text-center"> مستحقات المورد قبل الارتجاع</th>
                                            <th class="text-center"> مستحقات المورد بعد الارتجاع</th>
                                            <th class="text-center"> رصيد المنتج قبل الارتجاع</th>
                                            <th class="text-center"> رصيد المنتج بعد الارتجاع</th>
                                            <th class="text-center">ملاحظات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($buyReturns as $key => $return)
                                            <tr>
                                                <td>{{ $return->bill_id }}</td>
                                                <td>{{ $return->supplier->supplier_name }}</td>
                                                <td>{{ $return->product->product_name }}</td>
                                                <td>
                                                    {{ floatval($return->return_quantity) }}
                                                </td>
                                                <td>{{ $return->date }}</td>
                                                <td>{{ $return->time }}</td>
                                                <td>
                                                    {{ floatval($return->product_price) }}
                                                </td>
                                                <td>
                                                    {{ floatval($return->quantity_price) }}
                                                </td>

                                                <td>
                                                    {{ floatval($return->balance_before) }}
                                                </td>
                                                <td>
                                                    {{ floatval($return->balance_after) }}
                                                </td>

                                                <td>
                                                    {{ floatval($return->before_return) }}
                                                </td>
                                                <td>
                                                    {{ floatval($return->after_return) }}
                                                </td>
                                                <td>{{ $return->notes }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                        <div class="clearfix"></div>
                        @if (isset($buyCashs) && !$buyCashs->isEmpty())
                            <p class="alert alert-sm alert-warning mt-3 text-center">
                                مدفوعات نقدية من الموردين
                            </p>
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-bordered text-center table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">رقم العملية</th>
                                            <th class="text-center">المورد</th>
                                            <th class="text-center">المبلغ</th>
                                            <th class="text-center">رقم الفاتورة</th>
                                            <th class="text-center">التاريخ</th>
                                            <th class="text-center">الوقت</th>
                                            <th class="text-center">خزنة الدفع</th>
                                            <th class="text-center">ملاحظات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($buyCashs as $key => $cash)
                                            <tr>
                                                <td>{{ $cash->cash_number }}</td>
                                                <td>{{ $cash->supplier->supplier_name }}</td>
                                                <td>
                                                    {{ floatval($cash->amount) }}
                                                </td>
                                                <td>{{ $cash->bill_id }}</td>
                                                <td>{{ $cash->date }}</td>
                                                <td>{{ $cash->time }}</td>
                                                <td>{{ $cash->safe->safe_name }}</td>
                                                <td>{{ $cash->notes }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                        <div class="clearfix"></div>
                        @if (isset($buyBorrows) && !$buyBorrows->isEmpty())
                            <p class="alert alert-sm alert-warning mt-3 text-center">
                                سلفيات من الموردين
                            </p>
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-bordered text-center table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">رقم العملية</th>
                                            <th class="text-center">المورد</th>
                                            <th class="text-center">المبلغ</th>
                                            <th class="text-center">رقم الفاتورة</th>
                                            <th class="text-center">التاريخ</th>
                                            <th class="text-center">الوقت</th>
                                            <th class="text-center">خزنة الدفع</th>
                                            <th class="text-center">ملاحظات</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($buyBorrows as $key => $cash)
                                            <tr>
                                                <td>{{ $cash->cash_number }}</td>
                                                <td>{{ $cash->supplier->supplier_name }}</td>
                                                <td>
                                                    {{ floatval(abs($cash->amount)) }}
                                                </td>
                                                <td>{{ $cash->bill_id }}</td>
                                                <td>{{ $cash->date }}</td>
                                                <td>{{ $cash->time }}</td>
                                                <td>{{ $cash->safe->safe_name }}</td>
                                                <td>{{ $cash->notes }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                        <div class="clearfix"></div>

                        @if (isset($bankbuyCashs) && !$bankbuyCashs->isEmpty())
                            <p class="alert alert-sm alert-warning mt-3 text-center">
                                مدفوعات بنكية من الموردين
                            </p>
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-bordered text-center table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">رقم العملية</th>
                                            <th class="text-center">المورد</th>
                                            <th class="text-center">المبلغ</th>
                                            <th class="text-center">رقم الفاتورة</th>
                                            <th class="text-center">التاريخ</th>
                                            <th class="text-center">الوقت</th>
                                            <th class="text-center"> البنك</th>
                                            <th class="text-center"> رقم المعاملة</th>
                                            <th class="text-center"> ملاحظات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($bankbuyCashs as $key => $cash)
                                            <tr>
                                                <td>{{ $cash->cash_number }}</td>
                                                <td>{{ $cash->supplier->supplier_name }}</td>
                                                <td>
                                                    {{ floatval($cash->amount) }}
                                                </td>
                                                <td>{{ $cash->bill_id }}</td>
                                                <td>{{ $cash->date }}</td>
                                                <td>{{ $cash->time }}</td>
                                                <td>{{ $cash->bank->bank_name }}</td>
                                                <td>{{ $cash->bank_check_number }}</td>
                                                <td>{{ $cash->notes }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                        <div class="clearfix"></div>
                        @if (isset($expenses) && !$expenses->isEmpty())
                            <p class="alert alert-sm alert-primary mt-3 text-center">
                                المصروفات
                            </p>
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-bordered text-center table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">رقم المصروف</th>
                                            <th class="text-center">بيان المصروف</th>
                                            <th class="text-center">نوع المصروف</th>
                                            <th class="text-center">المبلغ</th>
                                            <th class="text-center">الموظف</th>
                                            <th class="text-center">الصورة</th>
                                            <th class="text-center">خزنة الدفع</th>
                                            <th class="text-center">ملاحظات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($expenses as $key => $expense)
                                            <tr>
                                                <td>{{ $expense->expense_number }}</td>
                                                <td>{{ $expense->expense_details }}</td>
                                                <td>{{ $expense->fixed->fixed_expense }}</td>
                                                <td>{{ floatval($expense->amount) }}</td>
                                                <td>
                                                    @if (!empty($expense->employee_id))
                                                        {{ $expense->employee->name }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <img data-toggle="modal" href="#modaldemo8"
                                                        src="{{ asset($expense->expense_pic) }}"
                                                        style="width:50px; height: 50px;cursor:pointer;" alt="" />
                                                </td>
                                                <td>{{ $expense->safe->safe_name }}</td>
                                                <td>{{ $expense->notes }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                    <div class="clearfix"></div>
                    <button onclick="window.print();" class="no-print btn btn-success btn-md pull-right"><i
                            class="fa fa-print"></i> طباعة
                    </button>
                    <?php $today = date('Y-m-d'); ?>
                    <input type="hidden" value="<?php echo $today; ?>" id="today" />
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="modaldemo8">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-demo">
                <div class="modal-header text-center">
                    <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">عرض صورة المصروف </h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <img id="image_larger" alt="image" style="width: 100%; " />
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" class="btn btn-sm btn-danger"><i class="fa fa-colse"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('img').on('click', function() {
            var image_larger = $('#image_larger');
            var path = $(this).attr('src');
            $(image_larger).prop('src', path);
        });
    });
</script>
