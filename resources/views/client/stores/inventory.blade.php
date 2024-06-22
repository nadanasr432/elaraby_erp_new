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
                            <h5 class="pull-right alert alert-sm alert-success">{{ __('stores.inventory-all-stores') }}
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="company_details printy" style="display: none;">
                        <div class="text-center">
                            <img class="logo" style="width: 20%;" src="{{ asset($company->company_logo) }}"
                                alt="">
                        </div>
                        <div class="text-center">
                            <div class="col-lg-12 text-center justify-content-center">
                                <p class="alert alert-secondary text-center alert-sm"
                                    style="margin: 10px auto; font-size: 17px;line-height: 1.9;" dir="rtl">
                                    {{ $company->company_name }} -- {{ $company->business_field }} <br>
                                    {{ $company->company_owner }} -- {{ $company->phone_number }} <br>
                                </p>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <form action="{{ route('client.inventory.post') }}" class="no-print" method="POST">
                        @csrf
                        @method('POST')
                        <div class="col-lg-3 pull-right no-print">
                            <label for="" class="d-block">{{ __('stores.choose-store') }}</label>
                            <select required name="store_id" id="store_id" class="selectpicker" data-style="btn-info"
                                data-live-search="true" title="{{ __('stores.store-name') }}">
                                <option @if (isset($store_id) && $store_id == 'all') selected @endif value="all">كل المخازن
                                </option>
                                @foreach ($stores as $store)
                                    <option @if (isset($store_id) && $store->id == $store_id) selected @endif value="{{ $store->id }}">
                                        {{ $store->store_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 pull-right no-print">
                            <label for="" class="d-block">{{ __('main.from') }}</label>
                            <input type="date" @if (isset($from_date) && !empty($from_date)) value="{{ $from_date }}" @endif
                                class="form-control" name="from_date" />
                        </div>
                        <div class="col-lg-3 pull-right no-print">
                            <label for="" class="d-block">{{ __('main.to') }}</label>
                            <input type="date" @if (isset($to_date) && !empty($to_date)) value="{{ $to_date }}" @endif
                                class="form-control" name="to_date" />
                        </div>
                        <div class="col-lg-3 pull-right no-print">
                            <label for="" class="d-block">
                                {{ __('main.reports-fields') }}
                            </label>
                            <select class="form-control selectpicker show-tick" data-live-search="true"
                                data-style="btn-success" data-title="{{ __('main.choose-fields') }}" multiple required
                                name="options[]" id="">
                                <option @if (isset($options) && in_array('product_name', $options)) selected @endif value="product_name">
                                    {{ __('main.product-name') }}
                                </option>
                                <option @if (isset($options) && in_array('code_universal', $options)) selected @endif value="code_universal">
                                    {{ __('main.code') }}
                                </option>
                                <option @if (isset($options) && in_array('purchasing_price', $options)) selected @endif value="purchasing_price">
                                    {{ __('main.purchase-price') }}
                                </option>
                                <option @if (isset($options) && in_array('purchases', $options)) selected @endif value="purchases">
                                    {{ __('sidebar.purchases') }}
                                </option>
                                <option @if (isset($options) && in_array('sales', $options)) selected @endif value="sales">
                                    {{ __('sidebar.sales') }}
                                </option>
                                <option @if (isset($options) && in_array('current_quantity', $options)) selected @endif value="current_quantity">
                                    {{ __('main.current-quantity') }}
                                </option>
                            </select>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-lg-12 pull-right">
                            <button class="btn btn-md btn-danger" style="font-size: 15px; height: 40px; margin-top: 25px;"
                                type="submit">
                                <i class="fa fa-check"></i>
                                {{ __('main.show-report') }}
                            </button>
                            @if (isset($store_id))
                                <a href="javascript:;" onclick="window.print()" class="btn btn-md btn-info ml-3"
                                    style="font-size: 15px; height: 40px; margin-top: 25px;" role="button">
                                    <i class="fa fa-print"></i>
                                    {{ __('main.print-report') }}
                                </a>
                                <button class="btn btn-md ml-3 btn-warning" type="submit"
                                    formaction="{{ route('inventory.export') }}"
                                    style="font-size: 15px; height: 40px; margin-top: 25px;" role="button">
                                    <i class="fa fa-file-excel"></i>
                                    {{ __('main.export') }} Excel
                                </button>
                            @endif
                        </div>
                    </form>
                    <div class="clearfix"></div>
                    @if (isset($products_k) && !empty($products_k))
                        <p class="alert alert-sm alert-danger mt-2 mb-2 text-center">
                            تقرير حركة مخزن
                            (
                            <?php
                            if ($store_id == 'all') {
                                echo 'كل المخازن';
                            } else {
                                $store = \App\Models\Store::FindOrFail($store_id);
                                $store_name = $store->store_name;
                                echo $store_name;
                            }
                            ?>
                            )
                        </p>
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered text-center table-hover">
                                <thead>
                                    <tr>
                                        @if (isset($options) && in_array('product_name', $options))
                                            <th class="text-center">اسم المنتج</th>
                                        @endif
                                        @if (isset($options) && in_array('code_universal', $options))
                                            <th class="text-center">الكود</th>
                                        @endif
                                        @if (isset($options) && in_array('purchasing_price', $options))
                                            <th class="text-center">سعر الشراء</th>
                                        @endif
                                        @if (isset($options) && in_array('purchases', $options))
                                            <th class="text-center">مشتريات</th>
                                        @endif
                                        @if (isset($options) && in_array('sales', $options))
                                            <th class="text-center">مبيعات</th>
                                        @endif
                                        @if (isset($options) && in_array('current_quantity', $options))
                                            <th class="text-center">كمية حالية</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $sum = 0; ?>
                                    @foreach ($products_k as $product_k)
                                        <tr>
                                            @if (isset($options) && in_array('product_name', $options))
                                                <td>{{ $product_k->product_name }}</td>
                                            @endif
                                            @if (isset($options) && in_array('code_universal', $options))
                                                <td>{{ $product_k->code_universal }}</td>
                                            @endif
                                            @if (isset($options) && in_array('purchasing_price', $options))
                                                <td>{{ floatval($product_k->purchasing_price) }}</td>
                                            @endif
                                            @if (isset($options) && in_array('purchases', $options))
                                                <td>
                                                    <?php
                                                    $buy_elements = \App\Models\BuyBillElement::where('product_id', $product_k->id)->get();
                                                    $total_buy_elements = 0;
                                                    foreach ($buy_elements as $buy_element) {
                                                        $total_buy_elements = $total_buy_elements + $buy_element->quantity;
                                                    }
                                                    echo floatval($total_buy_elements);
                                                    ?>
                                                </td>
                                            @endif
                                            @if (isset($options) && in_array('sales', $options))
                                                <td>
                                                    <?php
                                                    $sale_elements = \App\Models\SaleBillElement::where('product_id', $product_k->id)->get();
                                                    $total_sale_elements = 0;
                                                    foreach ($sale_elements as $sale_element) {
                                                        $total_sale_elements = $total_sale_elements + $sale_element->quantity;
                                                    }
                                                    $total_sold = $total_sale_elements;
                                                    echo floatval($total_sold);
                                                    ?>
                                                </td>
                                            @endif
                                            @if (isset($options) && in_array('current_quantity', $options))
                                                <td>{{ floatval($product_k->first_balance) }}</td>
                                            @endif
                                        </tr>
                                        <?php $total = $product_k->first_balance * $product_k->purchasing_price;
                                        $sum = $sum + $total;
                                        ?>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            <span class="alert alert-secondary alert-sm mr-5">
                                اجمالى التكلفة
                                ( {{ floatval($sum) }} )
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {

    });
</script>
