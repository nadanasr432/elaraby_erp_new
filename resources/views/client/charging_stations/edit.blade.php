@extends('client.layouts.app-main')

@section('content')
    <!-- Display Validation Errors -->
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
                            {{ __('sidebar.edit-charging_station') }}
                        </h5>
                        <a class="btn btnn text-white px-3 py-1" style="background-color: #36c7d6" 
                           href="{{ route('charging-stations.index') }}">
                            {{ __('main.back') }}
                        </a>
                    </div>

                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="editForm" name="editForm"
                          action="{{ route('charging-stations.update', $chargingStation->id) }}" 
                          enctype="multipart/form-data" method="post">
                        @csrf
                        @method('PUT')

                        <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                        <hr>

                        <div class="row mb-3">
                            <div class="col-md-4 mb-3">
                                <label> {{ __('main.country') }} <span class="text-danger">*</span></label>
                                <div class="d-flex">
                                    <select required name="country" class="form-control selectpicker py-1"
                                            data-style="btn-third" data-live-search="true"
                                            title="{{ __('main.country') }}">
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->country_name }}" 
                                                {{ $chargingStation->country == $country->country_name ? 'selected' : '' }}>
                                                {{ $country->country_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label> {{ __('main.region') }} </label>
                                <input dir="rtl" class="form-control" name="region" type="text"
                                       value="{{ $chargingStation->region }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label> {{ __('main.city') }} </label>
                                <input dir="rtl" class="form-control" name="city" type="text"
                                       value="{{ $chargingStation->city }}">
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
