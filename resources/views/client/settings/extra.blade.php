@extends('client.layouts.app-main')
<style>
    .nav-link {
        border-radius: 5px !important;
        margin: 2px;
    }

    .active {
        background: #4e4ed5;
        color: #fff;

    }

    .form-control,
    .input-group-addon {
        padding: 10px !important;
        height: 40px !important;
        border: 1px solid #ddd;
        border-right: 0;
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
</style>
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissable fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            <p class="alert alert-danger alert-sm text-center">
                الاعدادات العامة للنظام
            </p>
        </div>

        <a class="nav-link" style="border:1px solid #bbb" href="{{ route('client.basic.settings.edit') }}">
            <i class="fa fa-home"></i> {{ __('main.main-information') }} للنظام</a>

        <a class="nav-link active" style="border:1px solid #bbb" href="{{ route('client.extra.settings.edit') }}">
            <i class="fa fa-money"></i> البيانات الاضافية للنظام </a>

        <a class="nav-link " style="border:1px solid #bbb" href="{{ route('client.backup.settings.edit') }}">
            <i class="fa fa-copy"></i> اعدادات النسخة الاحتياطية </a>
        <a class="nav-link " style="border:1px solid #bbb" href="{{ route('client.get.product_expires') }}">
            <i class="fa fa-copy"></i> اعدادات صلاحية المنتجات </a>

        <a class="nav-link" style="border:1px solid #bbb" href="{{ route('client.billing.settings.edit') }}">
            <i class="fa fa-envelope"></i> بيانات الفواتير والضرائب </a>
        <div class="col-12 mt-3">
            <form action="{{ route('client.extra.settings.update') }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="company_id" value="{{ $company->id }}" />
                <div class="col-lg-4 col-xs-12 pull-right">
                    <div class="form-group">
                        <label for="brand_name">الدولة او المدينة</label>
                        <select required name="timezone" class="form-control">
                            <option value="">اختر بلدك</option>
                            @foreach ($timezones as $timezone)
                                <option @if ($extra->timezone == $timezone->timezone) selected @endif value="{{ $timezone->timezone }}">
                                    {{ $timezone->country_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-12 pull-right">
                    <div class="form-group">
                        <label for="person_name">العملة المرادفة لبلدك</label>
                        <select required name="currency" class="form-control">
                            <option value="">اختر العملة</option>
                            @foreach ($currencies as $currency)
                                <option @if ($extra->currency == $currency->currency) selected @endif
                                    value="{{ $currency->currency }}">{{ $currency->currency }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-xs-12 pull-right" dir="ltr">
                    <div class="form-group">
                        <label class="d-block" for="person_name"> حجم الخط بالبيكسل </label>
                        <span class="d-inline pull-right">25 px</span>
                        <input style="width:70%;" name="font_size" type="range" min="10" max="25"
                            value="{{ $extra->font_size }}" class="d-inline pull-right form-control"
                            oninput="showVal(this.value)" step="1" onchange="showVal(this.value)" />
                        <span class="d-inline pull-right">12 px</span>
                    </div>
                    <div class="clearfix"></div>
                    <span class="d-block text-danger tx-16" id="valBox">{{ $extra->font_size }} px</span>
                </div>

                <div class="clearfix"></div>

                <div class="col-lg-12 col-xs-12 pull-right">
                    <div class="form-group">
                        <button class="btn btn-md btn-success"><i class="fa fa-check"></i> حفظ
                        </button>
                    </div>
                </div>
                <div class="clearfix"></div>
            </form>
            <hr>
        </div>
    </div>
    <script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
    <script>
        function showVal(newVal) {
            document.getElementById("valBox").innerHTML = newVal + " px";
        }
    </script>
@endsection
