@extends('site.layouts.app-main')
<style>
    p {
        margin-top: 10px !important;
        font-size: 15px !important;
        color: #fff !important;
        background: #ff5976;
        padding: 15px;
    }

</style>
@section('content')
    <!-- ==========Banner-Section========== -->
    <section class="banner-section">
        <div class="banner-bg bg_img bg-fixed" data-background="{{ asset('assets/images/banner/banner01.jpg') }}"></div>
        <div class="container">
            <div class="banner-content">
                @if (session('error'))
                    <div class="alert alert-danger fade show">
                        {{ session('error') }}
                    </div>
                @endif
                <h1 class="text-center">
                    {{ __('main.create-new-company') }}
                </h1>
                <h6 dir="rtl" class="text-center alert alert-success alert-sm"
                    style="width: 80%; margin: 20px auto!important;">
                    <i class="fa fa-check-circle"></i>
                    تم انشاء شركتك بنجاح يمكنك الان التوجه الى تسجيل الدخول ومباشرة اعمالك
                </h6>
                <h6 class="text-right" dir="rtl">
                    بيانات تسجيل الدخول الى لوحة التحكم الخاصة بشركتك :
                </h6>
                <p>
                    الخانة الاولى تستطيع كتابة رقم الهاتف او البريد الالكترونى -
                </p>
                <p>
                    الخانة الثانية تستطيع كتابة كلمة المرور الخاصة بك -
                </p>
                <p>
                    يمكنك التحكم فى تلك البيانات من خلال لوحة التحكم كما يمكنك التحكم فى اى بيانات اخرى ايضا -
                </p>
                <div class="clearfix"></div>
                <a href="{{ route('client.login') }}" style="color: #fff !important;"
                    class="btn btn-md btn-success text-center mt-5 pull-left" dir="rtl">
                    التوجه الى تسجيل الدخول لوحة التحكم
                    <i style="color: #fff !important;" class="fa fa-long-arrow-left"></i>
                </a>
            </div>
        </div>
    </section>
@endsection
