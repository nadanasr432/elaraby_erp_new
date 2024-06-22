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
                    <div class="col-12">
                        <a class="btn btn-primary btn-sm pull-left" href="{{ route('client.cash.clients') }}">
                            دفعات نقدية من العملاء
                        </a>
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-success">
                            استلام نقدية من عميل
                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('client.update.cash.clients', $cash->id) }}" enctype="multipart/form-data"
                        method="post">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                        <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label> رقم العملية <span class="text-danger">*</span></label>
                                <input required readonly value="{{ $cash->cash_number }}" class="form-control"
                                    name="cash_number" type="text">
                            </div>
                            <div class="col-md-4">
                                <label> اسم العميل <span class="text-danger">*</span></label>
                                <select required name="outer_client_id" class="form-control selectpicker"
                                    data-style="btn-info" data-live-search="true" title="اختر اسم العميل">
                                    @foreach ($outer_clients as $outer_client)
                                        <option @if ($cash->outerClient->id == $outer_client->id) selected @endif
                                            value="{{ $outer_client->id }}">{{ $outer_client->client_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label> المبلغ المدفوع <span class="text-danger">*</span></label>
                                <input required class="form-control" value="{{ $cash->amount }}" name="amount" type="text"
                                    dir="ltr">
                            </div>
                        </div>
                        <div class="row mb-3">

                            <div class="col-md-3">
                                <label> التاريخ <span class="text-danger">*</span></label>
                                <input required class="form-control" name="date" type="date" dir="ltr"
                                    value="{{ $cash->date }}">
                            </div>
                            <div class="col-md-3">
                                <label> الوقت <span class="text-danger">*</span></label>
                                <input required class="form-control" name="time" type="time" dir="ltr"
                                    value="{{ $cash->time }}">
                            </div>
                            <div class="col-md-3">
                                <label> خزنة الدفع <span class="text-danger">*</span></label>
                                <select required name="safe_id" class="form-control">
                                    <option value="">اختر خزنة الدفع</option>
                                    @foreach ($safes as $safe)
                                        <option @if ($cash->safe->id == $safe->id) selected @endif
                                            value="{{ $safe->id }}">{{ $safe->safe_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label> ملاحظات <span class="text-danger">*</span></label>
                                <input required class="form-control" name="notes" type="text" dir="rtl"
                                    value="{{ $cash->notes }}">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button class="btn btn-info pd-x-20" type="submit">تعديل</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
