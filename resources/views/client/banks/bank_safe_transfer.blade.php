@extends('client.layouts.app-main')
<style>
    .bootstrap-select {
        width: 80% !important;
    }

</style>
@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissable fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif

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
                    <div class="col-12">
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-success">
                            {{ __('sidebar.transfer-between-bank-to-store') }}
                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('client.bank.safe.transfer.store', 'test') }}" enctype="multipart/form-data"
                        method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                        <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="d-block"> {{ __('banks.bank-name') }} <span
                                        class="text-danger">*</span></label>
                                <select required class="form-control selectpicker show-tick" data-style="btn-danger"
                                    data-live-search="true" title="{{ __('banks.bank-name') }}" name="bank_id">
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
                                    @endforeach
                                </select>
                                <a target="_blank" href="{{ route('client.banks.create') }}" role="button"
                                    style="width: 15%;display: inline;" class="btn btn-sm btn-danger open_popup">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <label class="d-block"> {{ __('safes.safe-name') }} <span
                                        class="text-danger">*</span></label>
                                <select required class="form-control selectpicker show-tick" data-style="btn-info"
                                    data-live-search="true" title="{{ __('safes.safe-name') }}" name="safe_id">
                                    @foreach ($safes as $safe)
                                        <option value="{{ $safe->id }}">{{ $safe->safe_name }}</option>
                                    @endforeach
                                </select>
                                <a target="_blank" href="{{ route('client.safes.create') }}" role="button"
                                    style="width: 15%;display: inline;" class="btn btn-sm btn-info open_popup">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <label class="d-block"> {{ __('main.amount') }} <span
                                        class="text-danger">*</span></label>
                                <input dir="ltr" required class="form-control" name="amount" type="text">
                            </div>
                            <div class="col-md-3">
                                <label class="d-block"> {{ __('banks.process-reason') }} <span
                                        class="text-danger">*</span></label>
                                <input dir="rtl" required class="form-control" name="reason" type="text">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button class="btn btn-info pd-x-20" type="submit">{{ __('banks.record-process') }}</button>
                        </div>
                    </form>
                    <div class="clearfix"></div>

                    @if (!$bank_safe_transfer->isEmpty())
                        <hr>
                        <p class="alert alert-sm alert-success text-center">
                            عمليات التحويل من بنك الى خزنة
                        </p>
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered text-center table-hover"
                                id="example-table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center"> البنك </th>
                                        <th class="text-center"> الخزنة </th>
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
                                    @foreach ($bank_safe_transfer as $key => $transfer)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $transfer->bank->bank_name }}</td>
                                            <td>{{ $transfer->safe->safe_name }}</td>
                                            <td>
                                                {{ floatval($transfer->amount) }}
                                            </td>
                                            <td>{{ $transfer->reason }}</td>
                                            <td>{{ $transfer->client->name }}</td>
                                            <td>
                                                <a class="modal-effect btn btn-sm btn-danger delete_transfer"
                                                    transfer_id="{{ $transfer->id }}" amount="{{ $transfer->amount }}"
                                                    data-toggle="modal" href="#modaldemo9" title="delete"><i
                                                        class="fa fa-trash"></i> حذف وتراجع </a>
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
                <form action="{{ route('client.bank.safe.transfer.destroy', 'test') }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>هل انت متأكد من الحذف ?</p><br>
                        <input type="hidden" name="transferid" id="transferid">
                        <input class="form-control" name="bankname" id="bankname" type="text" readonly>
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
            var amount = $(this).attr('amount');
            $('.modal-body #transferid').val(transfer_id);
            $('.modal-body #bankname').val(amount);
        });
    });
</script>
