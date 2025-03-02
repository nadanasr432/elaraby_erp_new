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
                    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
                        <h5  class=" alert custom-title">
                            اخذ سلفة من مورد
                        </h5>
                        <a class="btn btnn text-white px-3 py-1" style="background-color: #ec6880" href="{{ route('client.cash.suppliers') }}">
                            دفعات نقدية الى الموردين
                        </a>
                        
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('client.store2.cash.suppliers', 'test') }}" enctype="multipart/form-data"
                        method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                        <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-4 mb-1">
                                <label> رقم العملية <span class="text-danger">*</span></label>
                                <input required readonly value="{{ $pre_buy_cash }}" class="form-control"
                                    name="cash_number" type="text">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label> اسم المورد <span class="text-danger">*</span></label>
                                <div class="d-flex">
                                    <select required name="supplier_id" class="form-control selectpicker py-1" data-style="btn-third"
                                    data-live-search="true" title="اختر اسم المورد">
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                                    @endforeach
                                </select>
                                <a target="_blank" href="{{ route('client.suppliers.create') }}" role="button"
                                    s class="btn  btn-warning open_popup d-flex align-items-center">
                                    <i class="fa fa-plus"></i>
                                </a>
                                </div>
                            </div>

                            <div class="col-md-4 mb-1">
                                <label> المبلغ المدفوع <span class="text-danger">*</span></label>
                                <input required class="form-control" name="amount" type="text" dir="ltr">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label> التاريخ <span class="text-danger">*</span></label>
                                <input required class="form-control" name="date" type="date" dir="ltr"
                                    value="{{ date('Y-m-d') }}">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label> الوقت <span class="text-danger">*</span></label>
                                <input required class="form-control" name="time" type="time" dir="ltr"
                                    value="{{ date('H:i:s') }}">
                            </div>
                            <div class="col-md-4 mb-1">
                                <label> خزنة الدفع <span class="text-danger">*</span></label>
                                <div class="d-flex">
                                    <select style="display: inline !important;" required name="safe_id" class="form-control">
                                        <option value="">اختر خزنة الدفع</option>
                                        @foreach ($safes as $safe)
                                            <option value="{{ $safe->id }}">{{ $safe->safe_name }}</option>
                                        @endforeach
                                    </select>
                                    <a target="_blank" href="{{ route('client.safes.create') }}" role="button"
                                         class="btn btn-warning open_popup d-flex align-items-center">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-4 mb-1">
                                <label> ملاحظات <span class="text-danger">*</span></label>
                                <input class="form-control" name="notes" type="text" dir="rtl" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-end">
                            <button class="btn btnn btn-warning pd-x-20 px-3 py-1" type="submit">اضافة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
