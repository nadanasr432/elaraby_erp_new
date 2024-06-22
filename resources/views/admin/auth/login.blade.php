@extends('site.layouts.app-main')
<style>

</style>
@section('content')
    <section class="account-section bg_img" data-background="./assets/images/account/account-bg.jpg">
        <div class="container">
            <div class="padding-top padding-bottom">
                <div class="account-area" style="background: #0a1e5e !important;">
                    <div class="section-header-3">
                        <h3>
                            لوحة تحكم الادارة
                        </h3>
                    </div>
                    <form class="account-form" method="POST" action="{{ route('admin.login') }}">
                        @csrf
                        <div class="form-group">
                            <label class="d-block"
                                   style="direction: rtl!important;text-align: right!important;"
                                   for="email">البريد الالكترونى<span>*</span></label>
                            <input value="{{old('email')}}" name="email" autofocus
                                   style="direction: ltr!important;text-align: left!important;"
                                   type="email" placeholder="اكتب البريد الالكترونى" id="email" required>
                            @error('email')
                            <span style="direction: rtl!important;text-align: right!important;" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="d-block"
                                   style="direction: rtl!important;text-align: right!important;"
                                   for="pass3">كلمة المرور<span>*</span></label>
                            <input type="password" placeholder="كلمة المرور"
                                   name="password" dir="ltr" id="pass3" required
                                   style="direction: ltr!important;text-align: left!important;">
                            @error('password')
                            <span class="text-right" dir="rtl" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group text-center">
                            <input type="submit" value="تسجيل الدخول">
                        </div>
                    </form>
                    @if (Route::has('admin.password.request'))
                        <div class="form-group checkgroup text-right mt-5" dir="rtl">
                            <a href="{{ route('admin.password.request') }}" class="forget-pass text-white234">
                                هل نسيت كلمة المرور ؟
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
