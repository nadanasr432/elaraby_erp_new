@extends('admin.layouts.app-main')
<style>

</style>
@section('content')
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
                        <a class="btn btn-primary btn-sm pull-left" href="{{ route('admin.payments.index') }}">
                            عودة
                            للخلف</a>
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-success">
                            تحديث بيانات المدفوعات
                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                          action="{{route('admin.payments.update',$payment->id)}}" enctype="multipart/form-data"
                          method="post">
                        @csrf
                        @method('PATCH')
                        <h5 class="col-lg-12 d-block mb-2">البيانات الاساسية</h5>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label> اختر الشركة <span class="text-danger">*</span></label>
                                <select required class="form-control" name="company_id" id="">
                                    <option value="">اختر الشركة</option>
                                    @foreach($companies as $company)
                                        <option
                                            @if($payment->company_id == $company->id)
                                            selected
                                            @endif
                                            value="{{$company->id}}">{{$company->company_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label> المبلغ المدفوع <span class="text-danger">*</span></label>
                                <input value="{{$payment->amount}}" required class="form-control" dir="ltr" name="amount" type="text">
                            </div>
                            <div class="col-md-3">
                                <label> التاريخ <span class="text-danger">*</span></label>
                                <input required value="{{$payment->date}}" class="form-control" dir="ltr" name="date"
                                       type="date">
                            </div>
                            <div class="col-md-3">
                                <label> الوقت <span class="text-danger">*</span></label>
                                <input required value="{{$payment->time}}" class="form-control" dir="ltr" name="time"
                                       type="time">
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
