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
                    {{ __('main.Add New Vehicle') }}
                </h5>
                <a class="btn btnn text-white px-3 py-1" style="background-color: #36c7d6" href="{{ route('vehicles.index') }}">
                    {{ __('main.back') }}</a>
            </div>
            <div class="clearfix"></div>
            <br>
            <form action="{{ route('vehicles.store') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>{{ __('main.Vehicle Number') }}</label>
                        <input type="text" name="vehicle_number" class="form-control" value="{{ old('vehicle_number') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label>{{ __('main.Plate Number') }}</label>
                        <input type="text" name="plate_number" class="form-control" value="{{ old('plate_number') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label>{{ __('main.Trailer Type') }}</label>
                        <input type="text" name="trailer_type" class="form-control" value="{{ old('trailer_type') }}">
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-warning">{{ __('main.Add') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
