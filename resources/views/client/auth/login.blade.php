@extends('site.layouts.app-main')
<style>
    .leftEng {
        text-align: left;
        direction: ltr !important;
    }

    .starEN {
        float: right;
        margin-left: 7px !important;
    }

    footer {
        display: none !important;
    }

    /* New styles for terms checkbox */
    .terms-checkbox {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        @if (Config::get('app.locale')=='en') justify-content: flex-start;
        @else justify-content: flex-end;
        @endif
    }

    .terms-checkbox label {
        margin-bottom: 0;
        font-size: 14px;
        color: #1e2246;
    }

    .terms-link {
        color: #1e2246;
        text-decoration: underline;
        margin-right: 5px;
        margin-left: 5px;
    }

    .terms-error {
        color: #f64e60;
        font-size: 12px;
        margin-top: 5px;
        @if (Config::get('app.locale')=='en') text-align: left;
        @else text-align: right;
        @endif
    }
</style>
@section('content')
<main class="m-lg-5 m-md-4 m-3 border" style="display: block;margin-top:120px !important;">
    <!--begin::Login-->
    <div class="d-flex bg-white pb-3 overflow-hidden" @if (Config::get('app.locale')=='en' ) style="direction: ltr;" @endif>
        <!--begin::Aside-->
        <div class="col-sm-5 order-2 order-md-1 d-flex flex-row-auto position-relative overflow-hidden">
            <!--begin: Aside Container-->
            <div class="w-100 d-flex flex-column-fluid flex-column justify-content-around p-md-3 p-sm-2 p-1">
                <!--begin::Logo-->
                <a class="mb-sm-2 mb-4 text-center" href="/">
                    <span class="logo-icon">
                        <img src="{{ asset('images/logo.png') }}" width="54">
                    </span>
                    <h4 class="text-center" style="color:#1e2246;">
                        {{ __('main.elaraby') }}
                    </h4>
                </a>

                <div class="d-flex flex-column-fluid flex-column flex-center">
                    <!--begin::Signin-->
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-12 col-lg-12"> <!-- updated widths -->
                                <div class="login-form login-signin py-5 px-7 p-2 px-md-5 bg-white rounded shadow-sm">

                                    <form class="account-form" method="POST" action="{{ route('client.login') }}">
                                        @csrf

                                        <!-- Email -->
                                        <div class="form-group">
                                            <label class="font-weight-bold text-dark mb-2">
                                                {{ __('main.email') }} <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="email" value="{{ old('email') }}"
                                                class="form-control @error('email') is-invalid @enderror"
                                                placeholder="{{ __('main.email') }}" required autocomplete="off">
                                            @error('email')
                                            <span class="text-danger d-block" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>

                                        <!-- Password -->
                                        <div class="form-group">
                                            <label class="font-weight-bold text-dark mb-2">
                                                {{ __('main.password') }} <span class="text-danger">*</span>
                                            </label>
                                            <input type="password" name="password" id="pass3"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="{{ __('main.password') }}" required autocomplete="off">
                                            @error('password')
                                            <span class="text-danger d-block" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>

                                        <!-- Terms and Conditions -->
                                        <div class="form-group d-flex align-items-center gap-2 p-2" style="gap: 0.5rem;">
                                            <input type="checkbox" id="agree_terms" checked style="height: 20px !important;" name="agree_terms" required
                                                class="@error('agree_terms') is-invalid @enderror">
                                                <label for="agree_terms" class="mb-0 d-inline" style="font-size: 0.5rem; white-space: nowrap;">
                                                    {{ __('main.agree_terms') }}
                                                </label>
                                                <a href="{{ route('terms_conditions') }}" target="_blank" class="d-inline" style="font-size: 0.5rem; white-space: nowrap;">
                                                    {{ __('main.terms_conditions') }}
                                                </a>
                                                
                                                
                                        </div>
                                        @error('agree_terms')
                                        <span class="text-danger d-block" role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror

                                        <!-- Buttons -->
                                        <div class="text-center mt-4">
                                            <button type="submit" class="btn btn-dark w-100 mb-2">
                                                {{ __('main.login') }}
                                            </button>
                                            <a href="{{ route('index3') }}" class="btn btn-warning w-100">
                                                {{ __('main.register') }}
                                            </a>
                                        </div>

                                        <!-- Forgot Password -->
                                        @if (Route::has('client.password.request'))
                                        <div class="text-center mt-3">
                                            <a href="{{ route('client.password.request') }}" class="text-primary">
                                                {{ __('main.forget-your-password') }}
                                            </a>
                                        </div>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--end::Signin-->
                </div>
            </div>
            <!--end: Aside Container-->
        </div>
        <!--begin::Content-->
        <div class="content order-1 d-sm-block d-none order-lg-2 flex-column w-100 pb-3"
            style="background-color: #1e2246;">
            <!--begin::Title-->
            <div class="d-flex flex-column justify-content-center text-center">
                <h3 class="display4 font-weight-bolder text-dark"
                    style="color: #ff9f53 !important;padding-top:100px;font-weight: bold !important;">
                    {{ __('main.manst-elaraby') }}
                </h3>
                <p class="px-5 mt-2" style="color: white !important;opacity: 0.9">
                    {{ __('main.best-option') }}
                    <br>
                    <br>
                    {{ __('main.best-option-p') }}
                </p>
            </div>
            <!--end::Title-->
            <!--begin::Image-->
            <div class="content-img d-md-flex d-sm-none flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center">
                <svg style="margin: 10px auto;top: -45px;position: relative;" width="500" height="400"
                    viewBox="0 0 850 773" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- SVG content remains the same -->
                </svg>
            </div>
            <!--end::Image-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Login-->
</main>
@endsection