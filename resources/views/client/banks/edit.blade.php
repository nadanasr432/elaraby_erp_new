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
                        <a class="btn btnn btn-primary btn-sm pull-left" href="{{ route('client.banks.index') }}">
                            {{ __('main.back') }}</a>
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-success">
                            تحديث بيانات البنك
                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('client.banks.update', $bank->id) }}" enctype="multipart/form-data" method="post">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                        <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                        <hr>
                        <div class="row mb-3">

                            <div class="col-md-4">
                                <label> اسم البنك <span class="text-danger">*</span></label>
                                <input dir="rtl" value="{{ $bank->bank_name }}" required class="form-control"
                                    name="bank_name" type="text">
                            </div>

                            <div class="col-md-4">
                                <label> رصيد البنك <span class="text-danger">*</span></label>
                                <input value="{{ $bank->bank_balance }}" dir="ltr" required class="form-control"
                                    name="bank_balance" type="text">
                            </div>

                            <div class="col-md-4">
                                <label>سبب التعديل <span class="text-danger">*</span></label>
                                <input dir="rtl" required class="form-control" name="reason" type="text"
                                    id="reasonInput">
                                <span id="reasonError" class="text-danger" style="display: none;">يجب إدخال سبب
                                    التعديل</span>
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
    <script>
        document.getElementById('reasonInput').addEventListener('input', function() {
            let inputField = this;
            let errorMessage = document.getElementById('reasonError');

            // Trim input and check if it's empty or contains only spaces
            if (inputField.value.trim() === "") {
                inputField.setCustomValidity("يرجى إدخال سبب التعديل");
                errorMessage.style.display = "block";
            } else {
                inputField.setCustomValidity("");
                errorMessage.style.display = "none";
            }
        });
    </script>
@endsection
