@extends('client.layouts.app-main')
<style>

</style>
@section('content')
    @if (session('success'))
        <div class="alert alert-success fade show">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger fade show">
            {{ session('error') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="col-12">
                        <a class="btn btn-primary btn-sm pull-left" href="{{ route('client.safes.index') }}">
                            {{ __('main.back') }}</a>
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-success">
                            {{ __('sidebar.transfer-between-stores') }}
                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('client.safes.transfer.post') }}" enctype="multipart/form-data" method="post">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                        <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="d-block"> {{ __('stores.from-store') }} <span
                                        class="text-danger">*</span></label>
                                <select required class="form-control selectpicker show-tick"
                                    data-title="{{ __('stores.from-store') }}" data-live-search="true"
                                    data-style="btn-danger" name="from_safe" id="">
                                    @foreach ($safes as $safe)
                                        <option value="{{ $safe->id }}">{{ $safe->safe_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="d-block"> {{ __('stores.to-store') }} <span
                                        class="text-danger">*</span></label>
                                <select required class="form-control selectpicker show-tick"
                                    data-title="{{ __('stores.to-store') }}" data-live-search="true"
                                    data-style="btn-info" name="to_safe" id="">
                                    @foreach ($safes as $safe)
                                        <option value="{{ $safe->id }}">{{ $safe->safe_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="d-block"> {{ __('main.amount') }} <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="amount" min="1" required />
                            </div>
                            <div class="col-md-3">
                                <label class="d-block"> {{ __('safes.notes') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" dir="rtl" class="form-control" name="reason" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button class="btn btn-info pd-x-20" type="submit">
                                {{ __('main.transfer') }}
                            </button>
                        </div>
                    </form>
                    <div class="clearfix"></div>

                    @if (!$transfers->isEmpty())
                        <hr>
                        <p class="alert alert-sm alert-success text-center">
                            عمليات التحويل بين الخزن
                        </p>
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered text-center table-hover"
                                id="example-table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center"> من خزنة </th>
                                        <th class="text-center"> الى خزنة </th>
                                        <th class="text-center"> المبلغ</th>
                                        <th class="text-center">السبب</th>
                                        <th class="text-center">المسؤول</th>
                                        <th class="text-center">تحكم</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach ($transfers as $key => $transfer)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $transfer->fromSafe->safe_name }}</td>
                                            <td>{{ $transfer->toSafe->safe_name }}</td>
                                            <td>
                                                {{ floatval($transfer->amount) }}
                                            </td>
                                            <td>{{ $transfer->reason }}</td>
                                            <td>{{ $transfer->client->name }}</td>
                                            <td>
                                                <a class="modal-effect btn btn-sm btn-danger delete_transfer"
                                                    transfer_id="{{ $transfer->id }}"
                                                    from_safe="{{ $transfer->fromSafe->safe_name }}"
                                                    to_safe="{{ $transfer->toSafe->safe_name }}"
                                                    amount="{{ $transfer->amount }}" data-toggle="modal"
                                                    href="#modaldemo9" title="delete"><i class="fa fa-trash"></i> حذف
                                                    وتراجع </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="modaldemo9">
        <div class="modal-dialog modal-dialog-centered" bank="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header text-center">
                    <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">حذف عملية </h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('client.safes.transfer.destroy') }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>هل انت متأكد من الحذف ?</p><br>
                        <input type="hidden" name="transferid" id="transferid">
                        <input class="form-control" name="amount" id="amount" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">حذف وتراجع</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.delete_transfer').on('click', function() {
            var transfer_id = $(this).attr('transfer_id');
            var from_safe = $(this).attr('from_safe');
            var to_safe = $(this).attr('to_safe');
            var amount = $(this).attr('amount');
            $('.modal-body #transferid').val(transfer_id);
            $('.modal-body #amount').val("من " + from_safe + " الى " + to_safe + " ( " + amount + " )");
        });
    });
</script>
