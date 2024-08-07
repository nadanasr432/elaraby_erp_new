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
    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <div class="col-lg-12 margin-tb">
                            <h5 class="pull-right alert alert-sm alert-success">{{ __('sidebar.returns-sales-invoices') }}
                            </h5>
                        </div>
                        <br>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-condensed table-striped table-bordered text-center table-hover"
                               id="example-table">
                            <thead>
                            <tr>
                                <th class="text-center">{{ __('sales_bills.invoice-number') }}</th>
                                <th class="text-center"> {{ __('main.client') }}</th>
                                <th class="text-center"> {{ __('main.product') }}</th>
                                <th class="text-center"> {{ __('sales_bills.returns-quantity') }}</th>
                                <th class="text-center"> {{ __('main.time') }}</th>
                                <th class="text-center"> {{ __('main.date') }}</th>
                                <th class="text-center"> {{ __('sales_bills.product-price') }}</th>
                                <th class="text-center"> {{ __('sales_bills.quantity-price') }}</th>
                                <th class="text-center"> {{ __('sales_bills.including-tax') }}</th>
                                <th class="text-center">
                                    {{ __('sales_bills.customer-indebtedness-before-return') }}
                                </th>
                                <th class="text-center">
                                    {{ __('sales_bills.customer-indebtedness-after-return') }}
                                </th>
                                <th class="text-center"> {{ __('sales_bills.product-price-before-return') }}</th>
                                <th class="text-center"> {{ __('sales_bills.product-price-after-return') }}</th>
                                <th class="text-center">{{ __('main.notes') }}</th>
                                <th class="text-center">{{ __('main.control') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($sale_bill_returns as $key => $return)
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
                                        <?php
                                        $totalAfterTax = 0;
                                        $tax_option = $return->value_added_tax;
                                        if ($tax_option == 1)
                                            $totalAfterTax = $return->quantity_price;
//                                            $totalAfterTax = 0;
                                        else
                                            $totalAfterTax = $return->quantity_price + ($return->quantity_price * (15/100));

                                        echo floatval($totalAfterTax);
                                        ?>
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
                                    <td>
                                        <a href="{{ url('/client/sale-bills/print-return', $return->id) }}"
                                           class="btn btn-sm btn-info" data-toggle="tooltip" title="عرض"
                                           data-placement="top"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function () {

    });
</script>
