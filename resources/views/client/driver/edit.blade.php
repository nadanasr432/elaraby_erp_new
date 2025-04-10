@extends('client.layouts.app-main')

@section('content')
    <!-- main-content closed -->
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Errors :</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
                        <h5 class="alert custom-title">
                            {{ __('sidebar.edit-driver') }}
                        </h5>
                        <a class="btn btnn text-white px-3 py-1" style="background-color: #36c7d6"
                            href="{{ route('charging-stations.index') }}">
                            {{ __('main.back') }}
                        </a>
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="editForm" name="editForm"
                        action="{{ route('drivers.update', $driver->id) }}"
                        enctype="multipart/form-data" method="post">
                        @csrf
                        @method('PUT')
                        
                        <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-4 mb-3">
                                <label> {{ __('main.name') }} </label>
                                <input dir="rtl" class="form-control" name="name" type="text"
                                    value="{{ old('name', $driver->name) }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label> {{ __('main.iqama_number') }} </label>
                                <input dir="rtl" class="form-control" name="iqama_number" type="text"
                                    value="{{ old('iqama_number', $driver->iqama_number) }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label> {{ __('main.nationality') }} </label>
                                <input dir="rtl" class="form-control" name="nationality" type="text"
                                    value="{{ old('nationality', $driver->nationality) }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label> {{ __('main.mobile_number') }} </label>
                                <input dir="rtl" class="form-control" name="mobile_number" type="text"
                                    value="{{ old('mobile_number', $driver->mobile_number) }}">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-end">
                            <button class="btn btnn btn-warning py-1 px-3" type="submit">{{ __('main.update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
