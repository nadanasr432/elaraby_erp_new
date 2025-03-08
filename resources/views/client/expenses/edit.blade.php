@extends('client.layouts.app-main')
<style>
    .bootstrap-select,
    select.form-control {
        width: 80% !important;
        display: inline !important;
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
                        <a class="btn btnn btn-primary btn-sm pull-left" href="{{ route('client.expenses.index') }}">
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
                                <a target="_blank" href="{{ route('client.fixed.expenses') }}" role="button"
                                    style="width: 15%;display: inline;" class="btn btn-sm btn-warning open_popup">
                                    <i class="fa fa-plus"></i>
                                </a>
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
                                <label for="payment_method">طريقة الدفع <span class="text-danger">*</span></label>
                                <select required id="payment_method" name="payment_method" class="form-control">
                                    <option value="">اختر طريقة الدفع</option>
                                    <option value="cash" @if ($expense->payment_method == 'cash') selected @endif>دفع كاش نقدى</option>
                                    <option value="bank" @if ($expense->payment_method == 'bank') selected @endif>دفع بنكى شبكة</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3 bank-section" style="display: @if ($expense->payment_method == 'bank') block @else none @endif;">
                                <div class="col-md-12">
                                    <label class="d-block"> البنك <span class="text-danger">*</span></label>
                                    <select style="width: 80% !important; display: inline !important;" required
                                        id="bank_id" class="form-control" name="bank_id">
                                        <option value="">اختر البنك</option>
                                        @foreach ($banks as $bank)
                                            <option @if ($expense->bank_id == $bank->id) selected @endif
                                                value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
                                        @endforeach
                                    </select>
                                    <a target="_blank" href="{{ route('client.banks.create') }}" role="button"
                                        style="width: 15%;display: inline;" class="btn btn-sm btn-danger open_popup">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                                <div class="col-md-8 mt-2">
                                    <label for="">رقم المعاملة</label>
                                    <input type="text" name="payment_no" class="form-control" id="bank_check_number"
                                        value="{{ $expense->payment_no }}" />
                                </div>
                            </div>

                            <div class="col-md-3 safe-section" style="display: @if ($expense->payment_method == 'cash') block @else none @endif;">
                                <label> خزنة الدفع <span class="text-danger">*</span></label>
                                <select name="safe_id" class="form-control">
                                    <option value="">اختر خزنة الدفع</option>
                                    @foreach ($safes as $safe)
                                        <option @if ($expense->safe_id == $safe->id) selected @endif
                                            value="{{ $safe->id }}">{{ $safe->safe_name }}</option>
                                    @endforeach
                                </select>
                                <a target="_blank" href="{{ route('client.safes.create') }}" role="button"
                                    style="width: 15%;display: inline;" class="btn btn-sm btn-warning open_popup">
                                    <i class="fa fa-plus"></i>
                                </a>
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
                            <button class="btn btnn btn-info pd-x-20" type="submit">تحديث</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#payment_method').change(function() {
            var paymentMethod = $(this).val();

            if (paymentMethod === 'cash') {
                $('.safe-section').show();
                $('.bank-section').hide();
                $('#safe_id').prop('required', true);
                $('#bank_id').prop('required', false);
            } else if (paymentMethod === 'bank') {
                $('.safe-section').hide();
                $('.bank-section').show();
                $('#bank_id').prop('required', true);
                $('#safe_id').prop('required', false);
            } else {
                $('.safe-section').hide();
                $('.bank-section').hide();
                $('#safe_id').prop('required', false);
                $('#bank_id').prop('required', false);
            }
        }).trigger('change');
    });
</script>
