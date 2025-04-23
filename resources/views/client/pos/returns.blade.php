<?php
// File: resources/views/client/pos-returns/index.blade.php
?>
@extends('client.layouts.app-main')

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

    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h5 class="alert alert-sm alert-success">{{ __('sidebar.returns-sales-invoices') }}</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-condensed table-striped table-bordered text-center table-hover" id="pos-returns-table">
                            <thead>
                                <tr>
                                    <th class="text-center">{{ __('sales_bills.invoice-number') }}</th>
                                    <th class="text-center">{{ __('main.client') }}</th>
                                    <th class="text-center">{{ __('main.date') }}</th>
                                    <th class="text-center">{{ __('sales_bills.including-tax') }}</th>
                                    <th class="text-center">{{ __('main.control') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pos_returns as $return)
                                    <tr>
                                        <td class="text-center">{{ $return->company_counter }}</td>
                                        <td class="text-center">{{ $return->outerClient->client_name ?? 'غير محدد' }}</td>
                                        <td class="text-center">{{ $return->created_at->format('Y-m-d H:i') }}</td>
                                        <td class="text-center">
                                            {{ number_format($return->total_amount + ($return->value_added_tax ? 0 : $return->tax_amount), 2) }}
                                        </td>
                                        <td class="text-center">
                                            <a
                                            href="{{ route('pos-returns.print', $return->id) }}"
                                               class="btn btn-sm btn-info"
                                               data-toggle="tooltip"
                                               title="{{ __('main.view') }}"
                                               data-placement="top">
                                                <i class="fa fa-eye"></i> {{ __('main.print') }}
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
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#pos-returns-table').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/ar.json'
                },
                pageLength: 10,
                responsive: true
            });
        });
    </script>
@endsection
