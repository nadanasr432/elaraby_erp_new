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
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-success"> تعديل بيانات الموظف
                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('client.employees.update', $employee->id) }}" enctype="multipart/form-data"
                        method="post">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                        <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label> اسم الموظف <span class="text-danger">*</span></label>
                                <input dir="rtl" value="{{ $employee->name }}" required class="form-control" name="name"
                                    type="text">
                            </div>
                            <div class="col-md-3">
                                <label> تاريخ الميلاد </label>
                                <input class="form-control" value="{{ $employee->birth_date }}" dir="ltr"
                                    name="birth_date" type="date">
                            </div>
                            <div class="col-md-3">
                                <label> الوظيفة </label>
                                <input dir="rtl" value="{{ $employee->job }}" class="form-control" name="job"
                                    type="text">
                            </div>
                            <div class="col-md-3">
                                <label> السجل المدنى </label>
                                <input dir="ltr" value="{{ $employee->civil_registry }}" class="form-control"
                                    name="civil_registry" type="text">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label> العنوان </label>
                                <input dir="rtl" value="{{ $employee->address }}" class="form-control" name="address"
                                    type="text">
                            </div>
                            <div class="col-md-3">
                                <label> الهاتف </label>
                                <input class="form-control" value="{{ $employee->phone_number }}" dir="ltr"
                                    name="phone_number" type="text">
                            </div>
                            <div class="col-md-3">
                                <label> البريد الالكترونى </label>
                                <input dir="ltr" value="{{ $employee->email }}" class="form-control" name="email"
                                    type="email">
                            </div>
                            <div class="col-md-3">
                                <label> المرتب <span class="text-danger">*</span></label>
                                <input required dir="ltr" value="{{ $employee->salary }}" class="form-control"
                                    name="salary" type="text">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="d-block"> الدفع بالساعة </label>
                                <input type="checkbox" @if ($employee->works_by_the_hour == '1') checked @endif
                                    name="works_by_the_hour" /> يعمل بالساعة
                            </div>
                            <div class="col-md-4">
                                <label> عدد الساعات فى اليوم </label>
                                <input value="{{ $employee->number_of_hours_per_day }}" class="form-control" dir="ltr"
                                    name="number_of_hours_per_day" type="text">
                            </div>
                            <div class="col-md-4">
                                <label> ثمن الساعة </label>
                                <input dir="ltr" value="{{ $employee->hourly_price }}" class="form-control"
                                    name="hourly_price" type="text">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label> يوم بداية العمل </label>
                                <select name="work_start_date" class="form-control">
                                    <option value="">اختر يوم</option>
                                    <option @if ($employee->work_start_date == 'Saturday') selected @endif value="Saturday">السبت
                                    </option>
                                    <option @if ($employee->work_start_date == 'Sunday') selected @endif value="Sunday">الاحد</option>
                                    <option @if ($employee->work_start_date == 'Monday') selected @endif value="Monday">الاثنين
                                    </option>
                                    <option @if ($employee->work_start_date == 'Tuesday') selected @endif value="Tuesday">الثلاثاء
                                    </option>
                                    <option @if ($employee->work_start_date == 'Wednesday') selected @endif value="Wednesday">الاربعاء
                                    </option>
                                    <option @if ($employee->work_start_date == 'Thursday') selected @endif value="Thursday">الخميس
                                    </option>
                                    <option @if ($employee->work_start_date == 'Friday') selected @endif value="Friday">الجمعة</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label> يوم نهاية العمل </label>
                                <select name="work_end_date" class="form-control">
                                    <option value="">اختر يوم</option>
                                    <option @if ($employee->work_end_date == 'Saturday') selected @endif value="Saturday">السبت
                                    </option>
                                    <option @if ($employee->work_end_date == 'Sunday') selected @endif value="Sunday">الاحد</option>
                                    <option @if ($employee->work_end_date == 'Monday') selected @endif value="Monday">الاثنين
                                    </option>
                                    <option @if ($employee->work_end_date == 'Tuesday') selected @endif value="Tuesday">الثلاثاء
                                    </option>
                                    <option @if ($employee->work_end_date == 'Wednesday') selected @endif value="Wednesday">الاربعاء
                                    </option>
                                    <option @if ($employee->work_end_date == 'Thursday') selected @endif value="Thursday">الخميس
                                    </option>
                                    <option @if ($employee->work_end_date == 'Friday') selected @endif value="Friday">الجمعة
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="d-block"> حالة العمل <span class="text-danger">*</span></label>
                                <input type="radio" @if ($employee->work_status == 'working') checked @endif name="work_status"
                                    value="working" /> يعمل
                                <br>
                                <input type="radio" @if ($employee->work_status == 'quit') checked @endif name="work_status"
                                    value="quit" /> قدم استقالته
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
