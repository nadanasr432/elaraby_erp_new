@extends('client.layouts.app-main')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Errors:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
                <h5 s class=" alert custom-title">
                    {{ __('main.add-new-owner') }}
                </h5>
                <a class="btn btnn text-white px-3 py-1" style="background-color: #36c7d6" href="{{ route('vehicle-owners.index') }}">
                    {{ __('main.back') }}</a>
            </div>
            <div class="clearfix"></div>
            <br>

            <form action="{{ route('vehicle-owners.store') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>{{ __('main.Company Name') }}</label>
                        <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $company->company_name ?? '') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label>{{ __('main.Supervisor Name') }}</label>
                        <input type="text" name="supervisor_name" class="form-control" value="{{ old('supervisor_name') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label>{{ __('main.Mobile Number') }}</label>
                        <input type="text" name="mobile_number" class="form-control" value="{{ old('mobile_number') }}" required>
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-warning">{{ __('main.add') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
