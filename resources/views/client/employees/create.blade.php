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
                    <div class="col-12">
                        <a class="btn btn-primary btn-sm pull-left" href="{{ route('client.employees.index') }}">
                            {{ __('main.back') }}</a>
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-success">
                            {{ __('sidebar.add-new-employee') }} </h5>
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('client.employees.store', 'test') }}" enctype="multipart/form-data"
                        method="post">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                        <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label> {{ __('employees.employee-name') }} <span class="text-danger">*</span></label>
                                <input dir="rtl" required class="form-control" name="name" type="text">
                            </div>
                            <div class="col-md-3">
                                <label> {{ __('employees.birthdate') }} </label>
                                <input class="form-control" dir="ltr" name="birth_date" type="date">
                            </div>
                            <div class="col-md-3">
                                <label> {{ __('employees.position') }} </label>
                                <input dir="rtl" class="form-control" name="job" type="text">
                            </div>
                            <div class="col-md-3">
                                <label> {{ __('employees.record-civilian') }} </label>
                                <input dir="ltr" class="form-control" name="civil_registry" type="text">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label> {{ __('employees.address') }} </label>
                                <input dir="rtl" class="form-control" name="address" type="text">
                            </div>
                            <div class="col-md-3">
                                <label> {{ __('employees.phone') }} </label>
                                <input class="form-control" dir="ltr" name="phone_number" type="text">
                            </div>
                            <div class="col-md-3">
                                <label> {{ __('employees.email') }} </label>
                                <input dir="ltr" class="form-control" name="email" type="email">
                            </div>
                            <div class="col-md-3">
                                <label> {{ __('employees.salary') }} <span class="text-danger">*</span></label>
                                <input required dir="ltr" class="form-control" name="salary" type="text">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="d-block"> {{ __('employees.pay-by-hour') }} </label>
                                <input type="checkbox" name="works_by_the_hour" /> {{ __('employees.pay-by-hour') }}
                            </div>
                            <div class="col-md-4">
                                <label> {{ __('employees.hours-per-day') }} </label>
                                <input class="form-control" dir="ltr" name="number_of_hours_per_day" type="text">
                            </div>
                            <div class="col-md-4">
                                <label> {{ __('employees.hour-price') }} </label>
                                <input dir="ltr" class="form-control" name="hourly_price" type="text">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label> {{ __('employees.work-start-day') }} </label>
                                <select name="work_start_date" class="form-control">
                                    <option value="">اختر يوم</option>
                                    <option value="Saturday">السبت</option>
                                    <option value="Sunday">الاحد</option>
                                    <option value="Monday">الاثنين</option>
                                    <option value="Tuesday">الثلاثاء</option>
                                    <option value="Wednesday">الاربعاء</option>
                                    <option value="Thursday">الخميس</option>
                                    <option value="Friday">الجمعة</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label> {{ __('employees.work-end-day') }} </label>
                                <select name="work_end_date" class="form-control">
                                    <option value="">اختر يوم</option>
                                    <option value="Saturday">السبت</option>
                                    <option value="Sunday">الاحد</option>
                                    <option value="Monday">الاثنين</option>
                                    <option value="Tuesday">الثلاثاء</option>
                                    <option value="Wednesday">الاربعاء</option>
                                    <option value="Thursday">الخميس</option>
                                    <option value="Friday">الجمعة</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="d-block"> {{ __('employees.work-status') }} <span
                                        class="text-danger">*</span></label>
                                <input type="radio" checked name="work_status" value="working" />
                                {{ __('employees.working') }}
                                <br>
                                <input type="radio" name="work_status" value="quit" /> {{ __('employees.he-quit') }}
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
