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
                        <a class="btn btn-primary btn-sm pull-left" href="{{ route('admin.types.index') }}">
                            عودة
                            للخلف</a>
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-success">
                            اضافة نوع اشتراك جديد
                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                          action="{{route('admin.types.store','test')}}" enctype="multipart/form-data"
                          method="post">
                        {{csrf_field()}}
                        <h5 class="col-lg-12 d-block mb-2">البيانات الاساسية</h5>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label> اسم الاشتراك <span class="text-danger">*</span></label>
                                <input dir="rtl" placeholder="مثال :  شهرى" required class="form-control" name="type_name" type="text">
                            </div>
                            <div class="col-md-3">
                                <label> سعر الاشتراك <span class="text-danger">*</span></label>
                                <input required placeholder="مثال :  3000" class="form-control" dir="ltr" name="type_price" type="text">
                            </div>
                            <div class="col-md-3">
                                <label> مدة الاشتراك بالايام <span class="text-danger">*</span></label>
                                <input required placeholder="مثال :  30" class="form-control" dir="ltr" name="period" type="text">
                            </div>
                            <div class="col-md-3">
                                <label> الباقة <span class="text-danger">*</span></label>
                                <select name="package_id" required class="form-control">
                                    <option value="">اختر الباقة</option>
                                    @foreach($packages as $package)
                                        <option value="{{$package->id}}">{{$package->package_name}}</option>
                                    @endforeach
                                </select>
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
