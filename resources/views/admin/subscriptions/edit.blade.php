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
                        <a class="btn btn-primary btn-sm pull-left" href="{{ route('admin.subscriptions.index') }}">
                            عودة
                            للخلف</a>
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-success">
                            تحديث بيانات الاشتراك
                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                          action="{{route('admin.subscriptions.update',$subscription->id)}}"
                          enctype="multipart/form-data"
                          method="post">
                        @csrf
                        @method('PATCH')
                        <h5 class="col-lg-12 d-block mb-2">البيانات الاساسية</h5>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label> اسم الشركة <span class="text-danger">*</span></label>
                                <input readonly disabled dir="rtl" value="{{$subscription->company->company_name}}"
                                       class="form-control"
                                       type="text">
                                <input value="{{$subscription->company->id}}" required name="company_id" type="hidden">
                            </div>
                            <div class="col-md-6">
                                <label> نوع الاشتراك <span class="text-danger">*</span></label>
                                <select class="form-control" required name="type_id" id="">
                                    <option value="">اختر نوع الاشتراك</option>
                                    @foreach($types as $type)
                                        <option
                                            @if($subscription->type_id == $type->id)
                                            selected
                                            @endif
                                            value="{{$type->id}}">{{$type->type_name}}
                                            @if(!empty($type->package_id))
                                                - {{$type->package->package_name}}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label> تاريخ البداية <span class="text-danger">*</span></label>
                                <input value="{{date('Y-m-d')}}" required class="form-control"
                                       name="start_date" type="date">
                            </div>
                            <div class="col-md-6">
                                <label> الحالة <span class="text-danger">*</span></label>
                                <select required class="form-control" name="status" id="">
                                    <option value="">اختر الحالة</option>
                                    <option value="active">مفعل
                                    </option>
                                    <option value="blocked">
                                        معطل
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button class="btn btn-info pd-x-20" type="submit">تحديث</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
