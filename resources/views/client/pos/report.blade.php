@extends('client.layouts.app-main')
<style>
    th,
    td {
        padding: 6px !important;
    }

    #example-table_filter {
        text-align: left;
    }
</style>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
</script>
<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
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
                <!-- *****************************Header********************************** -->
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <div class="col-lg-12 margin-tb">
                            <a class="btn pull-left btn-primary btn-sm" target="_blank"
                                href="{{ route('client.pos.sales_products_today') }}">
                                <i class="fa fa-plus"></i>
                                تقرير المنتجات المباعة اليوم
                            </a>

                            <a class="btn pull-left btn-info btn-sm mr-1" id="mainPrintBtn" style="display: none"
                                href="{{ route('pos.sales.report.print') }}">
                                <i class="fa fa-print"></i>
                                {{ __('pos.print-invoice') }}
                            </a>

                            <a class="btn pull-left btn-info btn-sm mr-1" id="todayPrintBtn"
                                href="{{ route('pos.sales.report.print-today') }}">
                                <i class="fa fa-print"></i>
                                {{ __('pos.print-invoice') }}
                            </a>
                            <a class="btn pull-left btn-info btn-sm mr-1" id="todayPrintBtn"
                                href="{{ route('pos.sales.report.button.print-today') }}">
                                <i class="fa fa-print"></i>
                                {{ __('pos.print-button') }}
                            </a>

                            {{-- Button to show today's sales --}}
                            @if (request('filter') == 'all')
                                <a href="{{ route('pos.sales.report', ['filter' => 'today']) }}"
                                    class="btn pull-left btn-dark btn-sm mr-1" id="getPosReports">
                                    عرض تقرير اليوم
                                </a>
                            @endif
                            {{-- Button to show all sales --}}
                            {{-- "عرض كل التقارير" button (only show when filter is NOT 'all') --}}
                            @if (request('filter') !== 'all')
                                <a href="{{ route('pos.sales.report', ['filter' => 'all']) }}"
                                    class="btn pull-left btn-dark btn-sm mr-1" id="getPosReportsToday">
                                    عرض كل التقارير
                                </a>
                            @endif

                            {{-- "عرض بالتاريخ" button (only show when filter IS NOT 'dates') --}}
                            {{-- @if (!request()->has('date_from') && !request()->has('date_to')) --}}
                            <button id="getPosReportsWithDates" class="btn pull-left btn-warning btn-sm mr-1">
                                عرض بالتاريخ
                            </button>
                            {{-- @endif --}}


                            <!-- New Buttons -->
                            <button id="deleteClientPos" class="btn pull-left btn-danger btn-sm mr-1">
                                <i class="fa fa-trash"></i> حذف فواتير الفرع
                            </button>
                            <button id="rearrangeCompanyCounter" class="btn pull-left btn-success btn-sm mr-1">
                                <i class="fa fa-sort-numeric-asc"></i> إعادة ترتيب العداد
                            </button>

                            <h5 class="pull-right alert alert-sm alert-success">
                                {{ __('sidebar.point-of-sale-reports') }}
                            </h5>
                        </div>
                        <br>
                    </div>
                </div>
                <!-- ********************************************************************* -->

                <!-- **************************Search Form******************************** -->
                {{-- Date range filter form --}}
                <form action="{{ route('pos.sales.report') }}" method="GET"
                class="searchFormDates row p-2 pl-3 align-items-end"
                style="{{ request()->has(['date_from', 'date_to']) ? '' : 'display: none;' }}">

                <div class="col-3 form-group">
                    <label>من</label>
                    <input type="date" name="date_from" class="form-control" required
                        value="{{ request('date_from') }}">
                </div>

                <div class="col-3 form-group">
                    <label>إلى</label>
                    <input type="date" name="date_to" class="form-control" required
                        value="{{ request('date_to') }}">
                </div>

                <div class="col-1 form-group">
                    <button type="submit" class="btn btn-success btn-sm">
                        <svg style="width: 20px; fill: white;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path
                                d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352c79.5 0 144-64.5 144-144s-64.5-144-144-144S64 128.5 64 208s64.5 144 144 144z" />
                        </svg>
                    </button>
                </div>
            </form>

                <!-- ********************************************************************* -->

                <!-- ************************mainTable AllReport************************** -->
                <div class="posReportsTodayMain card-body">
                    <div class="table-responsive">
                        <table
                            class="defaultTableMain table table-condensed table-striped table-bordered text-center table-hover"
                            id="example-table">
                            <thead>
                                <tr>
                                    <th class="text-center">{{ __('pos.invoice-number') }}</th>
                                    <th class="text-center">{{ __('pos.client-name') }}</th>
                                    <th class="text-center">{{ __('pos.invoice-date') }}</th>
                                    <th class="text-center">{{ __('pos.invoice-status') }}</th>
                                    <th class="text-center">{{ __('main.amount') }}</th>
                                    <th class="text-center">{{ __('main.paid-amount') }}</th>
                                    <th class="text-center">{{ __('main.remaining-amount') }}</th>
                                    <th class="text-center">{{ __('main.taxes') }}</th>
                                    <th class="text-center">{{ __('main.items') }}</th>
                                    <th class="text-center">{{ __('main.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                    $sum1 = 0; // total-invoices-including-tax
                                    $sum2 = 0; // main.paid-amount
                                    $sum3 = 0; // total-tax-for-all-invoices
                                    $totalCash = 0; // total-cash
                                    $totalBank = 0; // total-tax-for-all-invoices
                                @endphp

                                @foreach ($pos_sales as $key => $pos)
                                    @php
                                        $totalAmount = 0;
                                        $totalPaid = 0;
                                    @endphp
                                    <tr>
                                        <td>{{ $pos->company_counter }}</td>
                                        <td>
                                            @if (isset($pos->outerClient->client_name))
                                                {{ $pos->outerClient->client_name }}
                                            @else
                                                زبون
                                            @endif
                                        </td>
                                        <td>{{ explode(' ', $pos->created_at)[0] }}</td>
                                        <td>
                                            @php
                                                $bill_id = 'pos_' . $pos->id;
                                                $check = App\Models\Cash::where('bill_id', $bill_id)->first();
                                                if (empty($check)) {
                                                    $check2 = App\Models\BankCash::where('bill_id', $bill_id)->first();
                                                    if (empty($check2)) {
                                                        echo 'غير مدفوعة - دين على العميل';
                                                    } else {
                                                        $totalBank += $check2->amount;
                                                        echo 'مدفوعة شيك بنكى';
                                                    }
                                                } else {
                                                    $totalCash += $check->amount;
                                                    echo 'مدفوعة كاش';
                                                }
                                            @endphp
                                        </td>
                                        <td>
                                            {{ $pos->total_amount }}
                                            @php $sum1 += floatval($pos->total_amount);@endphp
                                        </td>
                                        <td>
                                            @if ($pos->class == 'paid')
                                                {{ $pos->total_amount }}
                                                @php
                                                    $restAmount = 0;
                                                    $sum2 += floatval($pos->total_amount);
                                                @endphp
                                            @elseif($pos->class == 'not')
                                                0
                                                @php $restAmount = floatval($pos->total_amount); @endphp
                                            @else
                                                @php
                                                    $bill_id = 'pos_' . $pos->id;
                                                    $cash = App\Models\Cash::where('bill_id', $bill_id)->first();
                                                    if (empty($cash)) {
                                                        $bankCash = App\Models\BankCash::where(
                                                            'bill_id',
                                                            $bill_id,
                                                        )->first();
                                                        if (empty($bankCash)) {
                                                            echo '0';
                                                            $sum2 += 0;
                                                        } else {
                                                            echo round($bankCash->amount, 2);
                                                            $totalPaid = $bankCash->amount;
                                                            $restAmount =
                                                                floatval($pos->total_amount) - $bankCash->amount;
                                                            $sum2 += $bankCash->amount;
                                                        }
                                                    } else {
                                                        echo round($cash->amount, 2);
                                                        $totalPaid = $cash->amount;
                                                        $restAmount = floatval($pos->total_amount) - $cash->amount;
                                                        $sum2 += $cash->amount;
                                                    }
                                                @endphp
                                            @endif
                                        </td>
                                        <td>{{ round($restAmount, 2) }}</td>
                                        <td>
                                            @php
                                                if ($pos->value_added_tax == 1) {
                                                    $pos->tax_amount =
                                                        floatval($pos->total_amount) -
                                                        floatval($pos->total_amount) / 1.15;
                                                }
                                            @endphp
                                            @if ($pos->value_added_tax == 1)
                                                {{ number_format($pos->total_amount - $pos->total_amount / 1.15, 2) }}
                                            @else
                                                {{ round(floatval($pos->tax_amount), 2) }}
                                            @endif
                                            @php $sum3 += floatval($pos->tax_amount); @endphp
                                        </td>
                                        <td>
                                            @if (isset($pos))
                                                @php $pos_elements = $pos->elements; @endphp
                                                {{ $pos_elements->count() }}
                                            @else
                                                0
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('pos.open.print', $pos->id) }}"
                                                class="btn btn-sm btn-primary" title="{{ __('pos.print-invoice') }}">
                                                <i class="fa fa-print"></i> {{ __('pos.print') }}
                                            </a>
                                            <button class="btn btn-sm btn-danger delete-specific-pos"
                                                data-pos-id="{{ $pos->id }}" title="{{ __('pos.delete-invoice') }}">
                                                <i class="fa fa-trash"></i> {{ __('main.delete') }}
                                            </button>
                                            <button class="btn btn-sm btn-danger return-specific-pos"
                                                data-pos-id="{{ $pos->id }}" title="{{ __('pos.return-invoice') }}">
                                                <i class="fa fa-trash"></i> {{ __('main.return') }}
                                            </button>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class='row mb-3 mt-3 text-center'>
                        <div class='badge badge-dark mb-1 p-1'
                            style="margin-right: 5px;width: fit-content;font-size: 11px !important;font-weight: bold;">
                            مبيعات الكاش :
                            <span>{{ round($totalCash, 2) }}</span>
                        </div>
                        <div class='badge badge-warning mb-1 p-1'
                            style="margin-right: 5px;width: fit-content;font-size: 11px !important;font-weight: bold;">
                            مبيعات الشبكة :
                            <span>{{ round($totalBank, 2) }}</span>
                        </div>
                        <div class='badge badge-danger mb-1 p-1'
                            style='margin-right: 5px;width: fit-content;font-size: 11px !important;font-weight: bold;'>
                            {{ __('pos.total-tax-for-all-invoices') }} :
                            <span>{{ round($sum3, 2) }}</span>
                        </div>
                        <div class='badge badge-primary mb-1 p-1'
                            style='margin-right: 5px;width: fit-content;font-size: 11px !important;font-weight: bold;'>
                            {{ __('main.paid-amount') }} :
                            <span>{{ round($sum2, 2) }}</span>
                        </div>
                        <div class='badge badge-success mb-1 p-1'
                            style='margin-right: 5px;width: fit-content;font-size: 11px !important;font-weight: bold;'>
                            {{ __('pos.total-invoices-including-tax') }} :
                            <span>{{ round($sum1, 2) }}</span>
                        </div>
                    </div>
                </div>
                <!-- ********************************************************************* -->

                <!-- ************************SPINNER************************************** -->
                <div class="spinner-box"
                    style="display:none;background: #2d2d2d14; padding: 31px; text-align: center; border: 1px solid #8080803d;">
                    <div class="spinner-border text-primary" style="width: 50px; height: 50px;" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <span class="ml-2"
                        style="position: relative; top: -13px;font-size: 24px !important; font-weight: bold;">جاري تحميل
                        البيانات...</span>
                </div>
                <!-- ********************************************************************* -->

                <!-- ************************posReportsForToday*************************** -->
                <div style="display: none;" class="posReportsTodayCard card-body">
                    <div class="posReportsForTodayContainer table-responsive"></div>
                </div>
                <!-- ********************************************************************* -->
            </div>
        </div>
    </div>
@endsection
<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $("#getPosReportsWithDates").click(function() {
            $(".searchFormDates").fadeToggle(400);
        });
        // CSRF Token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Delete Client POS
        $('#deleteClientPos').click(function() {
            if (confirm('هل أنت متأكد من حذف فواتير الفرع؟')) {
                $('.spinner-box').show();
                $.ajax({
                    url: '{{ route('pos.client.delete') }}',
                    type: 'POST',
                    success: function(response) {
                        $('.spinner-box').hide();
                        // Since the controller redirects, we can't directly get the session message
                        // Reload the page to show the flash message
                        location.reload();
                    },
                    error: function(xhr) {
                        $('.spinner-box').hide();
                        var errorMsg = xhr.responseJSON && xhr.responseJSON.message ?
                            xhr.responseJSON.message :
                            'حدث خطأ أثناء حذف فواتير الفرع';
                        // Display error message
                        $('<div class="alert alert-danger alert-dismissable fade show">' +
                            '<button class="close" data-dismiss="alert" aria-label="Close">×</button>' +
                            errorMsg + '</div>').prependTo('.row-sm').fadeOut(5000);
                    }
                });
            }
        });

        // Delete Specific POS
        $('.delete-specific-pos').click(function() {
            var posId = $(this).data('pos-id');
            if (confirm('هل أنت متأكد من حذف هذه الفاتورة؟')) {
                $('.spinner-box').show();
                $.ajax({
                    url: '{{ route('pos.specific.delete', ':pos_id') }}'.replace(':pos_id',
                        posId),
                    type: 'POST',
                    success: function(response) {
                        $('.spinner-box').hide();
                        location.reload();
                    },
                    error: function(xhr) {
                        $('.spinner-box').hide();
                        var errorMsg = xhr.responseJSON && xhr.responseJSON.message ?
                            xhr.responseJSON.message :
                            'حدث خطأ أثناء حذف الفاتورة';
                        $('<div class="alert alert-danger alert-dismissable fade show">' +
                            '<button class="close" data-dismiss="alert" aria-label="Close">×</button>' +
                            errorMsg + '</div>').prependTo('.row-sm').fadeOut(5000);
                    }
                });
            }
        });
        // Delete Specific POS
        $('.delete-specific-pos').click(function() {
            var posId = $(this).data('pos-id');
            if (confirm('هل أنت متأكد من حذف هذه الفاتورة؟')) {
                $('.spinner-box').show();
                $.ajax({
                    url: '{{ route('pos.specific.delete', ':pos_id') }}'.replace(':pos_id',
                        posId),
                    type: 'POST',
                    success: function(response) {
                        $('.spinner-box').hide();
                        location.reload();
                    },
                    error: function(xhr) {
                        $('.spinner-box').hide();
                        var errorMsg = xhr.responseJSON && xhr.responseJSON.message ?
                            xhr.responseJSON.message :
                            'حدث خطأ أثناء حذف الفاتورة';
                        $('<div class="alert alert-danger alert-dismissable fade show">' +
                            '<button class="close" data-dismiss="alert" aria-label="Close">×</button>' +
                            errorMsg + '</div>').prependTo('.row-sm').fadeOut(5000);
                    }
                });
            }
        });
        // return Specific POS
        $('.return-specific-pos').click(function() {
            var posId = $(this).data('pos-id');
            if (confirm('هل أنت متأكد من ارجاع هذه الفاتورة؟')) {
                $('.spinner-box').show();
                $.ajax({
                    url: '{{ route('pos.specific.return', ':pos_id') }}'.replace(':pos_id',
                        posId),
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('.spinner-box').hide();
                        // Redirect to the pos-returns-list route
                        window.location.href = '{{ route('client.pos-returns.index') }}';
                    },
                    error: function(xhr) {
                        $('.spinner-box').hide();
                        var errorMsg = xhr.responseJSON && xhr.responseJSON.message ?
                            xhr.responseJSON.message :
                            'حدث خطأ أثناء حذف الفاتورة';
                        $('<div class="alert alert-danger alert-dismissable fade show">' +
                            '<button class="close" data-dismiss="alert" aria-label="Close">×</button>' +
                            errorMsg + '</div>').prependTo('.row-sm').fadeOut(5000);
                    }
                });
            }
        });

        // Rearrange Company Counter
        $('#rearrangeCompanyCounter').click(function() {
            if (confirm('هل أنت متأكد من إعادة ترتيب عداد الفواتير؟')) {
                $('.spinner-box').show();
                $.ajax({
                    url: '{{ route('company.counter.rearrange') }}',
                    type: 'POST',
                    success: function(response) {
                        $('.spinner-box').hide();
                        location.reload();
                    },
                    error: function(xhr) {
                        $('.spinner-box').hide();
                        var errorMsg = xhr.responseJSON && xhr.responseJSON.message ?
                            xhr.responseJSON.message :
                            'حدث خطأ أثناء إعادة ترتيب العداد';
                        $('<div class="alert alert-danger alert-dismissable fade show">' +
                            '<button class="close" data-dismiss="alert" aria-label="Close">×</button>' +
                            errorMsg + '</div>').prependTo('.row-sm').fadeOut(5000);
                    }
                });
            }
        });

        // Existing JavaScript
        $('.spinner-box').hide();
        //------show searchFormDates-----//



    });
</script>
