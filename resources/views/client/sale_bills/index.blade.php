@extends('client.layouts.app-main')
<style>
    .bootstrap-select {
        width: 75% !important;
        height: 40px !important;
    }

    .btn {
        height: 40px !important;
    }

    .btn-sm {
        height: 30px !important;
        padding: 5px !important;
    }


    /*=======NEW TABLE DESIGN==========*/

    .table th, .table td {
        padding: 10px !important;
    }

    .dropdown-toggle::after {
        display: none !important;
    }

    tr th {
        background: #222751;
        color: white !important;
        font-size: 12px !important;
        font-weight: 500 !important;
        border: none !important;
    }

    tr td {
        font-size: 12px !important;
        font-weight: 500 !important;
        border: none !important;
    }

    table thead tr th, table tbody tr td {
        border: none !important;
    }


    .even {
        background: #abd8ff24;
    }

    .dropDownBtn {
        padding: 5px !important;
        border-radius: 50% !important;
        width: 34px !important;
        height: 34px !important;
        text-align: center !important;
    }

    #example-table_wrapper .row:first-child {
        align-items: baseline !important;
    }
    .defaultTableMain {
        overflow-x: hidden !important;
    }
    /*=======NEW TABLE DESIGN==========*/

</style>
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <!------HEADER----->
                <div class="card-header border-bottom border-secondary p-1">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h3 class="pull-right font-weight-bold">
                            {{ __('sidebar.sales-invoices') }}
                            <span class="badge badge-success">{{count($sale_bills)}}</span>
                        </h3>
                        <div class="row mr-1 justify-content-end">
                            <a class="btn btn-primary pull-left p-1 mainBtnNewDes d-flex align-items-center"
                               href="{{route('client.sale_bills.create')}}">
                            <span
                                style="border: 1px dashed;border-radius: 50%;margin-left: 10px;width: 20px;height: 20px;">
                                <svg style="width: 10px;height: 15px;fill: #f5f1f1;margin-top: 1px;"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <path
                                        d="M240 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H32c-17.7 0-32 14.3-32 32s14.3 32 32 32H176V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H384c17.7 0 32-14.3 32-32s-14.3-32-32-32H240V80z"></path>
                                </svg>
                            </span>
                                {{ __('sidebar.Add a new sales invoice') }}
                            </a>
                            <a onclick="history.back()"
                               class="btn btn-danger pull-left text-white d-flex align-items-center ml-1"
                               style="height: 37px; font-size: 11px !important;">
                                <span
                                    style="border: 1px dashed;border-radius: 50%;margin-left: 10px;width: 20px;height: 20px;">
                                    <svg style="width: 10px;height: 15px;fill: #f5f1f1;margin-top: 1px;"
                                         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome  - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path
                                            d="M177.5 414c-8.8 3.8-19 2-26-4.6l-144-136C2.7 268.9 0 262.6 0 256s2.7-12.9 7.5-17.4l144-136c7-6.6 17.2-8.4 26-4.6s14.5 12.5 14.5 22l0 72 288 0c17.7 0 32 14.3 32 32l0 64c0 17.7-14.3 32-32 32l-288 0 0 72c0 9.6-5.7 18.2-14.5 22z"></path></svg>
                                </span>
                               {{ __('sidebar.back') }}
                            </a>
                        </div>
                    </div>
                </div>

                <!------HEADER----->
                <div class="card-body p-1">
                    <div id="example-table_wrapper"
                         class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer p-0">
                        <div class="row p-0">
                            <div class="col-sm-12 p-0">
                                <table style="border-radius: 5px !important; overflow-x: hidden;"
                                       class="defaultTableMain table dataTable no-footer" id="sale_bills_table"
                                       role="grid">
                                    <thead class="text-center">
                                    <tr role="row">
                                        <th style="border-radius: 0 10px 0 0">{{ __('sidebar.invoice number') }}</th>
                                        <th>{{ __('sidebar.customer name') }}</th>
                                        <th>{{ __('sidebar.Invoice date') }}</th>
                                        <th>{{ __('sidebar.Billing time') }}</th>
                                        <th>{{ __('sidebar.Final total') }}</th>
                                        <th>{{ __('sidebar.Number of items') }}</th>
                                        <th style="border-radius: 10px 0 0 0;width: 10% !important;">{{ __('sidebar.Show') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    $total = 0;
                                    ?>
                                    @foreach ($sale_bills as $sale_bill)
                                        <?php $i = 0; ?>
                                        <tr class="@if($i % 2 == 0) even @else odd @endif" role="row">
                                            <td>{{ $sale_bill->company_counter }}</td>
                                            <td>
                                                @if (empty($sale_bill->outer_client_id))
                                                   {{ __('sidebar.Cash sales client') }}
                                                @else
                                                    @if (!empty($sale_bill->OuterClient))
                                                        {{ $sale_bill->OuterClient->client_name }}
                                                    @endif
                                                @endif
                                            </td>
                                            <td>{{ $sale_bill->date }}</td>
                                            <td>{{ $sale_bill->time }}</td>
                                            <td>
                                                @php $total += $sale_bill->final_total; @endphp
                                                {{ $sale_bill->final_total }} {{ $company->extra_settings->currency }}
                                            </td>
                                            <td>{{$sale_bill->elements->count()}}</td>
                                            <td style="padding: 5px !important;">

                                                <div class="dropdown">
                                                    <button class="btn dropDownBtn dropdown-toggle" type="button"
                                                            id="dropdownMenuButton" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                        <svg style="display:block;fill: #36363f;margin: auto"
                                                             height="1em"
                                                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 512">
                                                            <path
                                                                d="M64 360a56 56 0 1 0 0 112 56 56 0 1 0 0-112zm0-160a56 56 0 1 0 0 112 56 56 0 1 0 0-112zM120 96A56 56 0 1 0 8 96a56 56 0 1 0 112 0z"></path>
                                                        </svg>
                                                    </button>
                                                    <div class="dropdown-menu p-0" aria-labelledby="dropdownMenuButton"
                                                         x-placement="bottom-start"
                                                         style="position: absolute; transform: translate3d(0px, 29px, 0px); top: 0px; left: 0px; will-change: transform;">

                                                        <!--SHOW--->
                                                        <a href="{{route('client.sale_bills.print', $sale_bill->token)}}"
                                                           class="dropdown-item" target="_blank"
                                                           style="font-size: 12px !important; padding: 9px 11px;border-bottom: 1px solid #2d2d2d2d">
                                                            <svg
                                                                style="width: 15px; fill: forestgreen;display: inline;margin-left: 5px;"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 576 512">
                                                                <path
                                                                    d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"></path>
                                                            </svg>
                                                            {{ __('sidebar.show') }}
                                                        </a>

                                                        <!--EDIT--->
                                                        <a href="{{ route('client.sale_bills.edit', [$sale_bill->token, $sale_bill->company_id]) }}"
                                                           class="dropdown-item"
                                                           style="font-size: 12px  !important; padding: 9px 11px;border-bottom: 1px solid #2d2d2d2d">
                                                            <svg
                                                                style="width: 15px; fill: #1956ad;display: inline;margin-left: 5px;"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 512 512">
                                                                <path
                                                                    d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152V424c0 48.6 39.4 88 88 88H360c48.6 0 88-39.4 88-88V312c0-13.3-10.7-24-24-24s-24 10.7-24 24V424c0 22.1-17.9 40-40 40H88c-22.1 0-40-17.9-40-40V152c0-22.1 17.9-40 40-40H200c13.3 0 24-10.7 24-24s-10.7-24-24-24H88z"></path>
                                                            </svg>
                                                            {{ __('sidebar.edit') }}
                                                        </a>
                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="mt-1 mb-1">
                        <span class="badge badge-success p-1 font-weight-bold">
                           {{ __('sidebar.Total billing prices') }}
                            ( {{ floatval($total) }} ) {{ $company->extra_settings->currency }}
                        </span>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#sale_bills_table').dataTable({
            ordering: false
        });
        $('.delete_bill').on('click', function () {
            var bill_id = $(this).attr('bill_id');
            var sale_bill_number = $(this).attr('sale_bill_number');
            $('.modal-body #billid').val(bill_id);
            $('.modal-body #salebillnumber').val(sale_bill_number);
        });

        $('#sale_bill_id').on('change', function () {
            let sale_bill_id = $(this).val();
            $('#sale_bill_id_2').val(sale_bill_id);
        });
        $('.remove_element').on('click', function () {
            let element_id = $(this).attr('element_id');
            let sale_bill_number = $(this).attr('sale_bill_number');

            let discount_type = $('#discount_type').val();
            let discount_value = $('#discount_value').val();

            let extra_type = $('#extra_type').val();
            let extra_value = $('#extra_value').val();

            $.post('{{ url('/client/sale-bills/element/delete') }}', {
                    '_token': '{{ csrf_token() }}',
                    element_id: element_id
                },
                function (data) {
                    $.post('{{ url('/client/sale-bills/updateData') }}', {
                            '_token': '{{ csrf_token() }}',
                            sale_bill_number: sale_bill_number
                        },
                        function (elements) {
                            $('.before_totals').html(elements);
                        });
                });
            $.post('{{ url('/client/sale-bills/discount') }}', {
                    '_token': '{{ csrf_token() }}',
                    sale_bill_number: sale_bill_number,
                    discount_type: discount_type,
                    discount_value: discount_value
                },
                function (data) {
                    $('.after_totals').html(data);
                });

            $.post('{{ url('/client/sale-bills/extra') }}', {
                    '_token': '{{ csrf_token() }}',
                    sale_bill_number: sale_bill_number,
                    extra_type: extra_type,
                    extra_value: extra_value
                },
                function (data) {
                    $('.after_totals').html(data);
                });
            $(this).parent().parent().fadeOut(300);
        });
        $('#exec_discount').on('click', function () {
            let sale_bill_number = $(this).attr('sale_bill_number');
            let discount_type = $('#discount_type').val();
            let discount_value = $('#discount_value').val();
            $.post("{{ url('/client/sale-bills/discount') }}", {
                    "_token": "{{ csrf_token() }}",
                    sale_bill_number: sale_bill_number,
                    discount_type: discount_type,
                    discount_value: discount_value
                },
                function (data) {
                    $('.after_totals').html(data);
                });
        });
        $('#exec_extra').on('click', function () {
            let sale_bill_number = $(this).attr('sale_bill_number');
            let extra_type = $('#extra_type').val();
            let extra_value = $('#extra_value').val();
            $.post("{{ url('/client/sale-bills/extra') }}", {
                    "_token": "{{ csrf_token() }}",
                    sale_bill_number: sale_bill_number,
                    extra_type: extra_type,
                    extra_value: extra_value
                },
                function (data) {
                    $('.after_totals').html(data);
                });
        });
    });
</script>
