@extends('site.layouts.app-main')
<style>
    .form-control {
        height: 50px !important;
    }

</style>
@section('content')
    <section class="account-section bg_img" data-background="./assets/images/account/account-bg.jpg">
        <div class="container">
            <div class="padding-top padding-bottom">
                <div class="account-area" style="background: #0a1e5e !important;">
                    <div class="section-header-3">
                        <h3>
                            {{ __('main.reset-your-password') }}
                        </h3>
                    </div>
                    <form dir="rtl" method="POST" action="{{ route('admin.password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('main.email') }}</label>
                            <div class="col-md-8">
                                <input id="email" type="email" style="direction: ltr!important;text-align: left!important;"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-right">{{ __('main.password') }}</label>

                            <div class="col-md-8">
                                <input id="password" type="password"
                                    style="direction: ltr!important;text-align: left!important;"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm"
                                class="col-md-4 col-form-label text-md-right">{{ __('main.confirm-password') }}</label>

                            <div class="col-md-8">
                                <input id="password-confirm" type="password"
                                    style="direction: ltr!important;text-align: left!important;" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mt-5 ">
                            <div class="col-md-12 text-center justify-content-center">
                                <button type="submit" class="btn btn-outline-danger">
                                    {{ __('main.reset-your-password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
