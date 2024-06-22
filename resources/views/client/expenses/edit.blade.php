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
                        <a class="btn btn-primary btn-sm pull-left" href="{{ route('client.expenses.index') }}">
                            {{ __('main.back') }}</a>
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-success">
                            تحديث بيانات المصروف
                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('client.expenses.update', $expense->id) }}" enctype="multipart/form-data"
                        method="post">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                        <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label> رقم المصروف <span class="text-danger">*</span></label>
                                <input required readonly value="{{ $expense->expense_number }}" class="form-control"
                                    name="expense_number" type="text">
                            </div>
                            <div class="col-md-3">
                                <label> نوع المصروف <span class="text-danger">*</span></label>
                                <select required name="fixed_expense" class="form-control">
                                    <option value="">اختر المصروف الثابت</option>
                                    @foreach ($fixed_expenses as $fixed_expense)
                                        <option @if ($expense->fixed_expense == $fixed_expense->id) selected @endif
                                            value="{{ $fixed_expense->id }}">{{ $fixed_expense->fixed_expense }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label> تفاصيل المصروف <span class="text-danger">*</span></label>
                                <input dir="rtl" value="{{ $expense->expense_details }}" required class="form-control"
                                    name="expense_details" type="text">
                            </div>
                            <div class="col-md-3">
                                <label> المبلغ <span class="text-danger">*</span></label>
                                <input required class="form-control" value="{{ $expense->amount }}" name="amount"
                                    type="text">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label> خزنة الدفع <span class="text-danger">*</span></label>
                                <select required name="safe_id" class="form-control">
                                    <option value="">اختر خزنة الدفع</option>
                                    @foreach ($safes as $safe)
                                        <option @if ($expense->safe_id == $safe->id) selected @endif
                                            value="{{ $safe->id }}">{{ $safe->safe_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label> الموظف <span class="text-danger">*</span></label>
                                <select name="employee_id" data-live-search="true" data-title="اختر الموظف"
                                    data-style="btn-danger" class="form-control selectpicker show-tick">
                                    @foreach ($employees as $employee)
                                        <option @if ($expense->employee_id == $employee->id) selected @endif
                                            value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label> ملاحظات <span class="text-danger">*</span></label>
                                <input class="form-control" value="{{ $expense->notes }}" name="notes" id="notes"
                                    type="text">
                            </div>
                            <div class="col-md-3">
                                <label> التاريخ <span class="text-danger">*</span></label>
                                <input class="form-control" value="{{ $expense->date }}" name="date" id="date"
                                    type="date">
                            </div>
                            <div class="col-md-3">
                                <label> صورة المصروف <span class="text-danger">*</span></label>
                                <input accept=".jpg,.png,.jpeg" type="file"
                                    oninput="pic.src=window.URL.createObjectURL(this.files[0])" id="file" name="expense_pic"
                                    class="form-control">
                                <label for="" class="d-block"> معاينة الصورة </label>
                                <img id="pic" src="{{ asset($expense->expense_pic) }}"
                                    style="width: 100px; height:100px;" />
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
