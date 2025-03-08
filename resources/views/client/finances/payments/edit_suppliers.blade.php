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
                    <div class="col-12 d-flex flex-wrap justify-content-between">
                        <h5  class=" alert custom-title">
                            دفع نقدى الى مورد
                        </h5>
                        <a class="btn text-white px-3 py-1" style="background-color: #36c7d6;" href="{{ route('client.cash.suppliers') }}">
                            دفعات نقدية الى الموردين
                        </a>
                       
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('client.update.cash.suppliers', $buy_cash->id) }}" enctype="multipart/form-data"
                        method="post">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                        <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                        <hr>
                        <div class="row mb-3">
                            <div class=" col-md-4 mb-1">
                                <label> رقم العملية <span class="text-danger">*</span></label>
                                <input required readonly value="{{ $buy_cash->cash_number }}" class="form-control"
                                    name="cash_number" type="text">
                            </div>
                            <div class=" col-md-4 mb-1">
                                <label> اسم المورد <span class="text-danger">*</span></label>
                                <select required name="supplier_id" class="form-control selectpicker"
                                    data-live-search="true" title="اختر اسم المورد">
                                    @foreach ($suppliers as $supplier)
                                        <option @if ($buy_cash->supplier->id == $supplier->id) selected @endif
                                            value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class=" col-md-4 mb-1">
                                <label> المبلغ المدفوع <span class="text-danger">*</span></label>
                                <input required class="form-control" name="amount" type="number" value="{{ $buy_cash->amount }}" dir="ltr" min="0.001" step="any">
                            </div>


                            <div class="  col-md-4 mb-1">
                                <label> التاريخ <span class="text-danger">*</span></label>
                                <input required class="form-control" name="date" type="date" dir="ltr"
                                    value="{{ $buy_cash->date }}">
                            </div>
                            <div class="  col-md-4 mb-1">
                                <label> الوقت <span class="text-danger">*</span></label>
                                <input required class="form-control" name="time" type="time" dir="ltr"
                                    value="{{ $buy_cash->time }}">
                            </div>
                            <div class="  col-md-4 mb-1">
                                <label> خزنة الدفع <span class="text-danger">*</span></label>
                                <select required name="safe_id" class="form-control">
                                    <option value="">اختر خزنة الدفع</option>
                                    @foreach ($safes as $safe)
                                        <option @if ($buy_cash->safe->id == $safe->id) selected @endif
                                            value="{{ $safe->id }}">{{ $safe->safe_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="  col-md-4 mb-1">
                                <label> ملاحظات <span class="text-danger">*</span></label>
                                <input required class="form-control" name="notes" type="text" dir="rtl"
                                    value="{{ $buy_cash->notes }}">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-start">
                            <button class="btn btn-warning py-1 px-3" type="submit">تعديل</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
