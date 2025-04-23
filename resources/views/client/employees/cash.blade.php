@extends('client.layouts.app-main')
<style>
    .btn.dropdown-toggle.bs-placeholder,
    .form-control {
        height: 40px !important;
    }

    a,
    a:hover {
        text-decoration: none;
        color: #444;
    }

    .bootstrap-select {
        width: 80% !important;
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
    @if (session('success'))
        <div class="alert alert-success alert-dismissable fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="col-12">
                        <a class="btn btn-primary btn-sm pull-left" href="{{ route('client.employees.index') }}">
                            {{ __('main.back') }}</a>
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-success">
                            {{ __('sidebar.employees-payments') }}
                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('employees.post.cash', 'test') }}" enctype="multipart/form-data" method="post">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                        <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label> {{ __('employees.employee-name') }} <span class="text-danger">*</span></label>
                                <select required name="employee_id" id="employee_id" class="selectpicker"
                                    data-style="btn-warning" data-live-search="true" title="اكتب او اختار اسم العميل">
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                                <a target="_blank" href="{{ route('client.employees.create') }}" role="button"
                                    style="width: 15%;display: inline;" class="btn btn-sm btn-warning open_popup">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <label> {{ __('main.date') }} <span class="text-danger">*</span></label>
                                <input required class="form-control" value="{{ date('Y-m-d') }}" dir="ltr" name="date"
                                    type="date">
                            </div>
                            <div class="col-md-3">
                                <label> {{ __('main.amount') }} <span class="text-danger">*</span></label>
                                <input required dir="ltr" class="form-control" name="amount" type="text">
                            </div>
                            <div class="col-md-3">
                                <label> {{ __('main.store') }} <span class="text-danger">*</span></label>
                                <select required name="safe_id" id="safe_id" class="selectpicker" data-style="btn-info"
                                    data-live-search="true" title="اكتب او اختار اسم الخزنة">
                                    @foreach ($safes as $safe)
                                        <option value="{{ $safe->id }}">{{ $safe->safe_name }}</option>
                                    @endforeach
                                </select>
                                <a target="_blank" href="{{ route('client.safes.create') }}" role="button"
                                    style="width: 15%;display: inline;" class="btn btn-sm btn-info open_popup">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label> {{ __('main.notes') }} </label>
                                <input dir="rtl" class="form-control" name="notes" type="text">
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
