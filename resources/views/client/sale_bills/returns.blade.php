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
                                <th class="text-center"> {{ __('main.date') . ' - ' . __('main.time') }}</th>
                                <th class="text-center"> {{ __('sales_bills.including-tax') }}</th>
                                <th class="text-center">{{ __('main.control') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i = 0;
                            @endphp
                            @foreach($returnSaleInvoices as $arr)
                                <tr>
                                    <th class="text-center">{{$arr[0]->bill->company_counter}}</th>
                                    <th class="text-center">{{@$arr[0]->outerClient->client_name}}</th>
                                    <th class="text-center">{{$arr[0]->date}} - {{$arr[0]->time}}</th>
                                    <th class="text-center">
                                        <?php
                                        $totalAfterTax = 0;
                                        foreach ($arr as $returnInv) {
                                            $tax_option = $returnInv->value_added_tax;
                                            $quantity_price = is_numeric($returnInv->quantity_price) ? $returnInv->quantity_price : 0;
                                            if ($tax_option == 1)
                                                $totalAfterTax += $quantity_price;
                                            else
                                                $totalAfterTax += $quantity_price + ($quantity_price * (15 / 100));
                                        }
                                        echo floatval($totalAfterTax);
                                        ?>
                                    </th>
                                    <th class="text-center">
                                        <a href="{{ url('/client/sale-bills/print-returnAll', $arr[0]->bill_id) }}"
                                           class="btn btn-sm btn-info" data-toggle="tooltip" title="عرض"
                                           data-placement="top">
                                            <i class="fa fa-eye"></i>
                                            print
                                        </a>
                                    </th>
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
