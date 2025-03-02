@extends('client.layouts.app-main')
<style>
    #example-table_filter {
        text-align: right;
        float: left;
    }

</style>
@section('content')
@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header border-bottom border-secondary p-1">
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <h3 class="custom-title font-weight-bold">
                            @lang('main.view_voucher_entry')
                        </h3>
                        <a class="btn btnn text-white py-1 px-3 "style="background-color: #ec6880" href="{{ route('client.voucher.create') }}">
                            <i class="fa fa-plus"></i>
                            @lang('main.add_voucher_entry')
                        </a>
                    </div>
                </div>

                <form action="{{ route('client.voucher.get') }}" method="GET" class="p-1 ">
                   <div class="row d-flex">
                        <div class="form-group col-12 col-lg-4">
                            <label for="acount_id">{{ __('sales_bills.choose-account') }}</label>
                            <select name="acount_id" id="acount_id" class="selectpicker form-control py-1"  data-live-search="true"
                                title="{{ __('sales_bills.choose-account') }}">
                                @foreach ($accounts as $account)
                                    <option value="{{ $account->id }}" @selected(request('acount_id') == $account->id)>
                                        {{ $account->account_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-12 col-lg-4">
                            <label for="from_date">{{ __('sales_bills.from_date') }}</label>
                            <input type="date" name="from_date" id="from_date" class="form-control" value="{{ request('from_date') }}">
                        </div>
                        <div class="form-group col-12 col-lg-4">
                            <label for="to_date">{{ __('sales_bills.to_date') }}</label>
                            <input type="date" name="to_date" id="to_date" class="form-control" value="{{ request('to_date') }}">
                        </div>   
                        
                    </div>

                    <div class="form-group align-self-end">
                        <button type="submit" class="btn btnn btn-warning py-1 px-3">{{ __('sales_bills.submit') }}</button>
                    </div>
                </form>

                {{-- <form action="{{ route('client.voucher.get') }}" method="GET">
                    <div class="col-lg-4 pull-right">
                        <label for="acount_id">{{ __('sales_bills.choose-account') }}</label><br>
                        <select name="acount_id" id="acount_id" class="selectpicker form-control" data-style="btn-primary" data-live-search="true"
                                title="{{ __('sales_bills.choose-account') }}">
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}">
                                    {{ $account->account_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form> --}}

                {{-- @dump($vouchers->pluck('transactions')) --}}
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-condensed table-striped table-bordered text-center table-hover"
                            id="example-table">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">@lang('home.dateV')</th>
                                    <th class="text-center">@lang('home.debtor')</th>
                                    <th class="text-center">@lang('home.creditor')</th>
                                    <th class="text-center">@lang('home.notes')</th>
                                    <th class="text-center">{{ __('main.amount') }}</th>
                                    <th class="text-center">{{ __('main.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vouchers as $key=>$voucher)
                                    @php
                                        $credits = [];
                                        $depits = [];
                                        if (isset($voucher->transactions)) {
                                            $collection = collect($voucher->transactions);
                                            $grouped = $collection->groupBy('type');
                                            $credits = $grouped->get(0, collect())->all();
                                            $depits = $grouped->get(1, collect())->all();
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $voucher->date ? \Carbon\Carbon::parse($voucher->date)->format('Y-m-d') : '' }}
                                        </td>
                                        <td>
                                            @foreach ($credits as $credit)
                                                <a
                                                    href="{{ route('account.statement', ['accountId' => $credit?->accountingTree?->id, 'from_date' => request('from_date'), 'to_date' => request('to_date')]) }}">
                                                    <span
                                                        class="badge badge-primary ml-2">{{ $credit?->accountingTree?->account_name }}</span>
                                                </a>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($depits as $depit)
                                            @if (!empty($depit->accountingTree) && !empty($depit->accountingTree->id))
                                                <a href="{{ route('account.statement', ['accountId' => $depit->accountingTree->id, 'from_date' => request('from_date'), 'to_date' => request('to_date')]) }}">
                                                    <span class="badge badge-success ml-2">{{ $depit->accountingTree->account_name }}</span>
                                                </a>
                                            @endif
                                        @endforeach
                                        
                                        </td>
                                        <td>{{ $voucher->notation }}</td>
                                        <td>{{ $voucher->amount }}</td>
                                        <td class="d-flex justify-content-center align-items-center">
                                            <a href="{{ route('client.voucher.edit', $voucher->id) }}" class="">
                                                <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M18.21 4.87258C18.6 4.48258 18.6 3.83258 18.21 3.46258L15.87 1.12258C15.5 0.732578 14.85 0.732578 14.46 1.12258L12.62 2.95258L16.37 6.70258M0.5 15.0826V18.8326H4.25L15.31 7.76258L11.56 4.01258L0.5 15.0826Z" fill="#4AA16A"/>
                                                    </svg>
                                                {{-- @lang('main.edit') --}}
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

        <div class="modal" id="modaldemo9">
            <div class="modal-dialog modal-dialog-centered" voucher="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">{{ __('vouchers.delete-vouchere') }}
                        </h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                                aria-hidden="true">&times;</span></button>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script>

    $(document).ready(function() {
        $('.delete_voucher').on('click', function() {
            var voucher_id = $(this).attr('voucher_id');
            var voucher_name = $(this).attr('voucher_name');
            $('.modal-body #voucherid').val(voucher_id);
            $('.modal-body #vouchername').val(voucher_name);
        });
    });
</script>
