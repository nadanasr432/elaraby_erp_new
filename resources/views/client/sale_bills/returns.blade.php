@extends('client.layouts.app-main')
<style>
    tr th {
        color: white !important;
        font-weight: normal !important;
        font-size: 12px !important;
    }

    tr td {
        padding: 5px !important;
        font-size: 11px !important;
    }

    .dropdown-toggle::after {
        display: none !important;
    }

    .btn-sm-new {
        font-size: 10px !important;
        padding: 10px !important;
        font-weight: bold !important;
    }
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
                    <table class="table table-condensed table-striped table-bordered text-center" id="example-table">
                        <thead>
                            <tr style="background: #222751;">
                                <th class="text-center">{{ __('sales_bills.invoice-number') }}</th>
                                <th class="text-center"> {{ __('main.client') }}</th>
                                <th class="text-center"> {{ __('main.date') . ' - ' . __('main.time') }}</th>
                                <th class="text-center"> {{ __('sales_bills.including-tax') }}</th>
                                <th class="text-center">{{ __('main.control') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($returnSaleInvoices->sortByDesc(function ($returnInv) {
            return $returnInv->date . ' ' . $returnInv->time;
        }) as $returnInv)
                                <tr>
                                    <td class="text-center">{{ $returnInv->bill->company_counter ?? '' }}</td>
                                    <td class="text-center">{{ $returnInv->outerClient->client_name ?? '' }}</td>
                                    <td class="text-center">{{ $returnInv->date }} - {{ $returnInv->time }}</td>
                                    <td class="text-center">
                                        @php
                                            $tax_option = $returnInv->value_added_tax;
                                            $quantity_price = is_numeric($returnInv->quantity_price)
                                                ? $returnInv->quantity_price
                                                : 0;
                                            $totalAfterTax =
                                                $tax_option == 1
                                                    ? $quantity_price
                                                    : $quantity_price + $quantity_price * 0.15;
                                        @endphp
                                        {{ number_format($totalAfterTax, 2) }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ url('/client/sale-bills/print-returnAll', $returnInv->bill_id) }}"
                                            class="btn btn-sm btn-info" data-toggle="tooltip" title="عرض"
                                            data-placement="top">
                                            <i class="fa fa-eye"></i> print
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
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
