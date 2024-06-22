@extends('client.layouts.app-main')
<style>
    .bootstrap-select,
    select.form-control {
        width: 80% !important;
        /*display: inline !important;*/
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
                        <a class="btn btn-primary btn-sm pull-left" href="{{ route('client.cashbank.suppliers') }}">
                            دفعات نقدية الى الموردين
                        </a>
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-success">
                            دفع نقدية الى مورد
                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('client.store.cashbank.suppliers', 'test') }}" enctype="multipart/form-data"
                        method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                        <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label> رقم العملية <span class="text-danger">*</span></label>
                                <input required readonly value="{{ $pre_buy_cash }}" class="form-control"
                                    name="cash_number" type="text">
                            </div>
                            <div class="col-md-4">
                                <label> اسم المورد <span class="text-danger">*</span></label>
                                <select required name="supplier_id" class="form-control selectpicker" data-style="btn-info"
                                    data-live-search="true" title="اختر اسم المورد">
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                                    @endforeach
                                </select>
                                <a target="_blank" href="{{ route('client.suppliers.create') }}" role="button"
                                    style="width: 15%;display: inline;" class="btn btn-sm btn-warning open_popup">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>

                            <div class="col-md-4">
                                <label> المبلغ المدفوع <span class="text-danger">*</span></label>
                                <input required class="form-control" name="amount" type="text" dir="ltr">
                            </div>
                        </div>
                        <div class="row mb-3">

                            <div class="col-md-4">
                                <label> التاريخ <span class="text-danger">*</span></label>
                                <input required class="form-control" name="date" type="date" dir="ltr"
                                    value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-4">
                                <label> الوقت <span class="text-danger">*</span></label>
                                <input required class="form-control" name="time" type="time" dir="ltr"
                                    value="{{ date('H:i:s') }}">
                            </div>
                        </div>
                        <div class="row mb-3 bank">
                            <div class="col-md-4">
                                <label class="d-block"> اختر البنك <span class="text-danger">*</span></label>
                                <select required style="display: inline !important;" name="bank_id" class="form-control">
                                    <option value="">اختر البنك</option>
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
                                    @endforeach
                                </select>
                                <a target="_blank" href="{{ route('client.banks.create') }}" role="button"
                                    style="width: 15%;display: inline;" class="btn btn-sm btn-warning open_popup">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <label class="d-block"> رقم المعاملة <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="bank_check_number" />
                            </div>
                            <div class="col-md-4">
                                <label class="d-block"> ملاحظات <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="notes" />
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button class="btn btn-info pd-x-20" type="submit">اضافة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
