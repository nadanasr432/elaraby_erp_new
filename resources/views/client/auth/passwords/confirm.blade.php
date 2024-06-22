@extends('client.layouts.app-login')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="brand text-center">
                <a class="link text-white text-center" href="{{route('index')}}">
                    <img class="text-center" src="{{asset('images/logo.png')}}" style="width:20%; margin: 10px auto ;" />
                </a>
            </div>
            <div class="card">
                <div class="card-header text-center">Confirm Password</div>

                <div class="card-body">
                    <p class="text-center">Please confirm your password before continuing.</p>

                    <form method="POST" action="{{ route('client.password.confirm') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Confirm Password
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('client.password.request') }}">
                                        Forgot Your Password?
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
