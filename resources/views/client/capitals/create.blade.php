@extends('client.layouts.app-main')
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
                    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
                        <h5 class=" alert custom-title"> اضافة راس مال
                            جديد </h5>
                        <a class="btn btnn text-white px-3 py-1" style="background-color: #ec6880" href="{{ route('client.capitals.index') }}">
                            {{ __('main.back') }}</a>
                        
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('client.capitals.store', 'test') }}" enctype="multipart/form-data" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                        <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label> المبلغ <span class="text-danger">*</span></label>
                                <input dir="ltr" required class="form-control" name="amount" type="text">
                            </div>

                            <div class="col-md-4">
                                <label class="d-block"> الخزنة <span class="text-danger">*</span></label>
                                <div class="d-flex">
                                    <select required name="safe_id" class="form-control">
                                        <option value="">اختر الخزينة</option>
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
                            <div class="col-md-4">
                                <label> ملاحظات <span class="text-danger">*</span></label>
                                <input class="form-control" name="notes" type="text" dir="rtl" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-end">
                            <button class="btn btnn btn-warning px-3 py-1" type="submit">اضافة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
