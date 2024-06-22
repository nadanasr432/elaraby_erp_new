@extends('site.layouts.app-main')
<style>
    .form-control {
        height: 50px !important;
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
                <h5 class="text-center " style="width: 80%; margin: 20px auto!important;">
                    {{ __('main.administrator-login-information') }}
                </h5>
                <div class="clearfix"></div>
                <form class="mt-4" action="{{ route('company.admin.login.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="company_id" value="{{ $_GET['company_id'] }}" />
                    <input type="hidden" name="Status" value="active" />
                    <input type="hidden" name="role_name[]" value="مدير النظام" />

                    <div class="col-lg-3 col-xs-12 pull-right text-right">
                        <div class="form-group">
                            <label for="" class="d-block">
                                {{ __('main.system-manager-name') }}
                                <span class="text-danger pull-left">*</span>
                            </label>
                            <input required type="text" value="{{ old('name') }}" class="form-control text-right"
                                dir="rtl" name="name" />
                        </div>
                    </div>

                    <div class="col-lg-3 col-xs-12 pull-right text-right">
                        <div class="form-group">
                            <label for="" class="d-block">
                                {{ __('main.phone') }}
                                <span class="text-danger pull-left">*</span>
                            </label>
                            <input value="{{ old('phone_number') }}" required type="text" class="form-control text-left"
                                dir="ltr" name="phone_number" />
                        </div>
                    </div>


                    <div class="col-lg-3 col-xs-12 pull-right text-right">
                        <div class="form-group">
                            <label for="" class="d-block">
                                {{ __('main.email') }}
                                <span class="text-danger pull-left">*</span>
                            </label>
                            <input value="{{ old('email') }}" required type="email" class="form-control text-left"
                                dir="ltr" name="email" />
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-12 pull-right text-right">
                        <div class="form-group">
                            <label for="" class="d-block">
                                {{ __('main.password') }}
                                <span class="text-danger pull-left">*</span>
                            </label>
                            <input required type="password" class="form-control text-left" dir="ltr" name="password" />
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div class="col-lg-12 col-xs-12 text-center justify-content-center mt-5">
                        <button type="submit" dir="rtl" class="col-lg-4 btn btn-md btn-outline-danger"
                            style="color: #fff !important;">
                            <i class="fa fa-check" style="color: #fff !important;"></i>
                            {{ __('main.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
