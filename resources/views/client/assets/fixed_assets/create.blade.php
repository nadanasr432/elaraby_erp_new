@extends('client.layouts.app-main')
<style>
    table thead tr th,
    table tbody tr td {
        border: inherit !importnat
    }
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
                    <div class="col-12 d-flex flex-wrap justify-content-between">
                        <h5 sclass=" alert custom-title">
                            اضف اصل ثابت
                        </h5>
                        <a class="btn btnn text-white px-3 py-1" style="background-color: #36c7d6;" href="{{ route('fixed.assets.index') }}">
                            {{ __('main.back') }}
                        </a>
                        
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('client.branches.store', 'test') }}" enctype="multipart/form-data" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="company_id" value="">
                        <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                        <hr>
                        <div class="row mb-3">
                            <div class=" col-md-4 mb-1">
                                <label> الاسم <span class="text-danger">*</span></label>
                                <input required class="form-control" dir="ltr" name="name">
                            </div>
                            <div class=" col-md-4 mb-1">
                                <label> الرقم المرجعي <span class="text-danger">*</span></label>
                                <input required class="form-control" dir="ltr" name="ref-number">
                            </div>
                            <div class=" col-md-4 mb-1">
                                <label> تصنيف الاصل <span class="text-danger">*</span></label>
                                <div style="display: flex;align-items: center;gap: 5px;">
                                    <select dir="rtl" required class="form-control selectpicker" name="category"
                                       data-live-search="true" style="display: inline !important;">
                                        <option>f</option>
                                    </select>
                                    <a target="_blank" href="{{ route('client.stores.create') }}" role="button"
                                        style="width: 15%;display: inline;" class="btn btn-sm btn-warning open_popup">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class=" col-md-4 mb-1">
                                <label> وحدة القياس <span class="text-danger">*</span></label>
                                <select dir="rtl" required class="form-control" name="unit">
                                    <option>جرام</option>
                                </select>
                            </div>
                            <div class=" col-md-4 mb-1">
                                <label> الضريبة <span class="text-danger">*</span></label>
                                <select dir="rtl" required class="form-control" name="tax">
                                    <option></option>
                                </select>
                            </div>

                            <div class=" col-md-4 mb-1">
                                <label> الباركود </label>
                                <input dir="rtl" class="form-control" name="barcode">
                            </div>

                            <div class=" col-md-4 mb-1">
                                <label> صورة للاصل </label>
                                <input class="form-control" dir="ltr" name="picture" type="file">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-start">
                            <button class="btn btnn btn-warning px-3 py-1" type="submit">{{ __('main.add') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
