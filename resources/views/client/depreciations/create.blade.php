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
                    <div class="col-12">
                        <a class="btn btn-primary btn-sm pull-left" href="{{ route('client.depreciations.index') }}">
                            {{ __('main.back') }}
                        </a>
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-success">
                            اضف اهلاك جديد
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
                            <div class="col-md-3">
                                <label> تصنيف الاصل <span class="text-danger">*</span></label>
                                <select dir="rtl" required name="category" data-live-search="true"
                                    data-style="btn-danger" class="form-control selectpicker show-tick">
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label> اسم الاصل <span class="text-danger">*</span></label>
                                <select dir="rtl" required name="category" data-live-search="true"
                                    data-style="btn-danger" class="form-control selectpicker show-tick">
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label> نوع فترة الاهلاك <span class="text-danger">*</span></label>
                                <select dir="rtl" required name="category" data-live-search="true"
                                    data-style="btn-danger" class="form-control selectpicker show-tick">
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label> الفترة من <span class="text-danger">*</span></label>
                                <input required type="date" class="form-control" dir="ltr" name="ref-number">
                            </div>
                            <div class="col-md-3">
                                <label> الفترة الي <span class="text-danger">*</span></label>
                                <input required type="date" class="form-control" dir="ltr" name="ref-number">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button class="btn btn-info pd-x-20" type="submit">{{ __('main.add') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
