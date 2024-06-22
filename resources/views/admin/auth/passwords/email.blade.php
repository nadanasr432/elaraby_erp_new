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
                    @if (session('status'))
                        <div class="alert alert-success text-center" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form dir="rtl" class="" method="POST" action="{{ route('admin.password.email') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="email" class="d-block">
                                {{ __('main.email') }}
                            </label>
                            <input id="email" type="email" dir="ltr"
                                class="form-control text-left @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group row mt-5">
                            <div class="col-md-12">
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
