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

        <a class="nav-link active" style="border:1px solid #bbb" href="{{ route('client.basic.settings.edit') }}">
            <i class="fa fa-home"></i> {{ __('main.main-information') }} للنظام</a>

        <a class="nav-link" style="border:1px solid #bbb" href="{{ route('client.extra.settings.edit') }}">
            <i class="fa fa-money"></i> البيانات الاضافية للنظام </a>

        <a class="nav-link " style="border:1px solid #bbb" href="{{ route('client.backup.settings.edit') }}">
            <i class="fa fa-copy"></i> اعدادات النسخة الاحتياطية </a>

        <a class="nav-link " style="border:1px solid #bbb" href="{{ route('client.get.product_expires') }}">
            <i class="fa fa-copy"></i> اعدادات صلاحية المنتجات </a>

        <a class="nav-link " style="border:1px solid #bbb" href="{{ route('client.billing.settings.edit') }}">
            <i class="fa fa-envelope"></i> بيانات الفواتير والضرائب </a>
        <div class="col-12  mt-3">
            <form action="{{ route('client.basic.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <input type="hidden" name="company_id" value="{{ $company->id }}" />
                <div class="col-lg-4 col-xs-12 pull-right">
                    <div class="form-group">
                        <label class="company_name"> @lang('main.name_ar')</label>
                        <input type="text" class="form-control" name="company_name" id="company_name"
                            @if ($company->company_name) value="{{ $company->company_name }}" @endif
                            {{ $company->company_name ? 'disabled' : '' }} />
                    </div>
                </div>

                <div class="col-lg-4 col-xs-12 pull-right">
                    <div class="form-group">
                        <label for="company_name_en"> @lang('main.name_en')</label>
                        <input type="text" class="form-control" name="company_name_en" id="company_name_en"
                            @if ($company->company_name_en) value="{{ $company->company_name_en }}" @endif
                            {{ $company->company_name_en ? 'disabled' : '' }} />
                    </div>
                </div>

                <div class="col-lg-4 col-xs-12 pull-right">
                    <div class="form-group">
                        <label for="person_name">اسم صاحب المشروع</label>
                        <input type="text" class="form-control" name="company_owner"
                            value="{{ $company->company_owner }}" id="person_name" />
                    </div>
                </div>
                <div class="col-lg-4 col-xs-12 pull-right">
                    <div class="form-group">
                        <label for="person_name"> مجال او نشاط المشروع</label>
                        <input type="text" class="form-control" name="business_field"
                            value="{{ $company->business_field }}" id="person_name" />
                    </div>
                </div>
                <div class="col-lg-4 col-xs-12 pull-right">
                    <div class="form-group">
                        <label for="location">عنوان المشروع</label>
                        <input type="text" class="form-control" name="company_address"
                            value="{{ $company->company_address }}" id="location" />
                    </div>
                </div>
                <div class="col-lg-4 col-xs-12 pull-right">
                    <div class="form-group">
                        <label for="phone_1">رقم تليفون</label>
                        <input type="text" value="{{ $company->phone_number }}" dir="ltr" class="form-control"
                            name="phone_number" id="phone_1" />
                    </div>
                </div>

                <div class="col-lg-4 col-xs-12 pull-right">
                    <div class="form-group">
                        <label for="fileToUpload30">لوجو المشروع</label>
                        <input accept=".jpg,.png,.jpeg" oninput="pic.src=window.URL.createObjectURL(this.files[0])"
                            type="file" class="form-control" name="company_logo" />
                        <label for="" class="d-block"> معاينة الصورة </label>
                        <img id="pic" src="{{ asset($company->company_logo) }}"
                            style="width: 100px; height:100px;" />
                    </div>
                </div>

                <div class="col-lg-4 col-xs-12 pull-right">
                    <div class="form-group">
                        <label for="fileToUpload40"> هيدر الطباعة </label>
                        <input accept=".jpg,.png,.jpeg" oninput="pic2.src=window.URL.createObjectURL(this.files[0])"
                            type="file" class="form-control" name="header" />
                        <label for="" class="d-block"> معاينة الصورة </label>
                        <img id="pic2" src="{{ asset($company->basic_settings->header) }}"
                            style="width: 100%; height:100px;" />
                    </div>
                </div>

                <div class="col-lg-4 col-xs-12 pull-right">
                    <div class="form-group">
                        <label for="fileToUpload50"> فوتر الطباعة </label>
                        <input accept=".jpg,.png,.jpeg" oninput="pic3.src=window.URL.createObjectURL(this.files[0])"
                            type="file" class="form-control" name="footer" />
                        <label for="" class="d-block"> معاينة الصورة </label>
                        <img id="pic3" src="{{ asset($company->basic_settings->footer) }}"
                            style="width: 100%; height:100px;" />
                    </div>
                </div>

                <div class="col-lg-4 col-xs-12 pull-right">
                    <div class="form-group">
                        <label for="fileToUpload60"> الختم الالكترونى </label>
                        <input accept=".jpg,.png,.jpeg" oninput="pic4.src=window.URL.createObjectURL(this.files[0])"
                            type="file" class="form-control" name="electronic_stamp" />
                        <label for="" class="d-block"> معاينة الصورة </label>
                        <img id="pic4" src="{{ asset($company->basic_settings->electronic_stamp) }}"
                            style="width: 100px; height:100px;" />
                    </div>
                </div>

                <div class="clearfix"></div>
                <div class="col-lg-12 col-xs-12 pull-right">
                    <div class="form-group">
                        <button class="btn btn-md btn-success"><i class="fa fa-check"></i> حفظ
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
    // إذا كان هناك قيمة محفوظة بالفعل للـcompany_name أو company_name_en
    const companyNameField = document.getElementById('company_name');
    const companyNameEnField = document.getElementById('company_name_en');
    
    // إذا كان الإدخال موجودًا، اجعل الحقل معطل (disabled)
    if (companyNameField.value) {
        companyNameField.disabled = true;
    }
    if (companyNameEnField.value) {
        companyNameEnField.disabled = true;
    }

    // حدث عند إرسال النموذج
    const form = document.querySelector('form');
    form.addEventListener('submit', function () {
        // إضافة حالة disable بعد الحفظ
        if (companyNameField.value) {
            companyNameField.disabled = true;
        }
        if (companyNameEnField.value) {
            companyNameEnField.disabled = true;
        }
    });
});
</script>
@endsection
