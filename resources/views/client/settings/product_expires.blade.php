@extends('client.layouts.app-main')
<style>
    .nav-link   {
        border-radius: 5px !important;
        margin: 2px;
    }

    .active {
        background: #222751;
        color: #fff;

    } 
    .active:hover{
        color: #fff;

    }
    .form-control,
    .input-group-addon {
        padding: 10px !important;
        height: 40px !important;
        border: 1px solid #ddd;
        border-right: 0;
    }
    .custom-radio-group label {
        display: block;
        font-size: 18px !important;
        /* Adjust font size as needed */
        margin-bottom: 10px;
        /* Adjust spacing between radio buttons */
    }

    .input-group-addon {
        border-top-left-radius: 5px !important;
        border-bottom-left-radius: 5px !important;
        border-top-right-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
    }

    .input-spec {
        border-right: 0;
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
        border-top-right-radius: 5px !important;
        border-bottom-right-radius: 5px !important;
    }
    .main_lable {
        font-size: 20px !important;
    }

    .custom-radio-group input[type="radio"] {
        transform: scale(1.5);
        /* Adjust the size of the radio buttons */
        margin-right: 5px;
        /* Adjust spacing between radio button and label text */
    }
    
</style>
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissable fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif
    <div class="bg-white p-2 m-1">
        <div class="row">
            <div class="col-12">
                <p class="alert custom-title">
                    اعدادات صلاحية المنتجات
                </p>
            </div>
            <div class="px-2 d-flex flex-wrap">

            <a class="nav-link text-dark " style="border:1px solid #bbb" href="{{ route('client.basic.settings.edit') }}">
                <i class="fa fa-home"></i> {{ __('main.main-information') }} للنظام</a>
    
            <a class="nav-link text-dark" style="border:1px solid #bbb" href="{{ route('client.extra.settings.edit') }}">
                <i class="fa fa-money"></i> البيانات الاضافية للنظام </a>
    
            <a class="nav-link text-dark " style="border:1px solid #bbb" href="{{ route('client.backup.settings.edit') }}">
                <i class="fa fa-copy"></i> اعدادات النسخة الاحتياطية </a>
    
            <a class="nav-link  active" style="border:1px solid #bbb" href="{{ route('client.get.product_expires') }}">
                <i class="fa fa-copy"></i> اعدادات صلاحية المنتجات </a>
    
            <a class="nav-link text-dark " style="border:1px solid #bbb" href="{{ route('client.billing.settings.edit') }}">
                <i class="fa fa-envelope"></i> بيانات الفواتير والضرائب </a>
            </div>
        </div>
        <div class="col-12  mt-3">
            <form action="{{ route('client.product_expires.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <input type="hidden" name="company_id" value="{{ $company->id }}" />
                <div class="form-group">
                    <label for="exp_duration">{{ __('Expiration Duration') }}</label>
                   <div id="expDurationContainer" class="custom-radio-group">
                        <label><input type="radio" name="exp_duration" value="0.33"
                                {{ old('exp_duration', $company->extra_settings->exp_duration) == '0.33' ? 'checked' : '' }}>
                            ثلث المدة </label>
                        <label><input type="radio" name="exp_duration" value="0.66"
                                {{ old('exp_duration', $company->extra_settings->exp_duration) == '0.66' ? 'checked' : '' }}>
                            ثلثين المدة </label>
                        <label><input type="radio" name="exp_duration" value="0.25"
                                {{ old('exp_duration', $company->extra_settings->exp_duration) == '0.25' ? 'checked' : '' }}>
                            ربع المدة </label>
                        <label><input type="radio" name="exp_duration" value="0.75"
                                {{ old('exp_duration', $company->extra_settings->exp_duration) == '0.75' ? 'checked' : '' }}>
                            ثلاثة أرباع المدة </label>
                        <label><input type="radio" name="exp_duration" value="0.5"
                                {{ old('exp_duration', $company->extra_settings->exp_duration) == '0.5' ? 'checked' : '' }}>
                            نصف المدة </label>
                    </div>
    
                </div>
                    <div class="form-group">
                        <button class="btn btn-warning py-1 px-3"><i class="fa fa-check"></i> حفظ
                        </button>
                    </div>
                
    
            </form>
        </div>
    </div>
    <script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
    <script>
        function showVal(newVal) {
            document.getElementById("valBox").innerHTML = newVal + " px";
        }
    </script>
@endsection
