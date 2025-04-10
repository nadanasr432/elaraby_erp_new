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
                        <h5 s class=" alert custom-title">
                            {{ __('sidebar.Add Transport Policy') }}
                        </h5>
                        <a class="btn btnn text-white px-3 py-1" style="background-color: #36c7d6"
                            href="{{ route('transport-policies.index') }}">
                            {{ __('main.back') }}</a>
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('transport-policies.store') }}" enctype="multipart/form-data" method="post">
                        {{ csrf_field() }}
                        <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-4 mb-3">
                                <label>{{ __('main.client') }} <span class="text-danger">*</span></label>
                                <div class="d-flex">
                                    <select required name="outer_client_id" class="form-control selectpicker py-1"
                                        data-style="btn-third" data-live-search="true" title="{{ __('main.client') }}">
                                        @foreach ($outer_clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->client_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>{{ __('main.discharging_station') }} <span class="text-danger">*</span></label>
                                <div class="d-flex">
                                    <select required name="discharging_station_id" class="form-control selectpicker py-1"
                                        data-style="btn-third" data-live-search="true"
                                        title="{{ __('main.discharging_station') }}">
                                        @foreach ($discharge_stations as $station)
                                            <option value="{{ $station->id }}">{{ $station->country }} -
                                                {{ $station->city }} - {{ $station->region }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>{{ __('main.charging_station') }} <span class="text-danger">*</span></label>
                                <div class="d-flex">
                                    <select required name="charging_station_id" class="form-control selectpicker py-1"
                                        data-style="btn-third" data-live-search="true"
                                        title="{{ __('main.charging_station') }}">
                                        @foreach ($charge_stations as $station)
                                            <option value="{{ $station->id }}">{{ $station->country }} -
                                                {{ $station->city }} - {{ $station->region }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>{{ __('main.driver') }} <span class="text-danger">*</span></label>
                                <div class="d-flex">
                                    <select required name="driver_id" class="form-control selectpicker py-1"
                                        data-style="btn-third" data-live-search="true" title="{{ __('main.driver') }}">
                                        @foreach ($drivers as $driver)
                                            <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>{{ __('main.shipment') }} <span class="text-danger">*</span></label>
                                <div class="d-flex">
                                    <select required name="shipment_id" class="form-control selectpicker py-1"
                                        data-style="btn-third" data-live-search="true" title="{{ __('main.shipment_containers_no') }}">
                                        @foreach ($shipments as $shipment)
                                            <option value="{{ $shipment->id }}">{{ $shipment->containers_no }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>{{ __('main.vehicle') }} <span class="text-danger">*</span></label>
                                <div class="d-flex">
                                    <select required name="vehicle_id" class="form-control selectpicker py-1"
                                        data-style="btn-third" data-live-search="true" title="{{ __('main.vehicle') }}">
                                        @foreach ($vehicles as $vehicle)
                                            <option value="{{ $vehicle->id }}">{{ $vehicle->plate_number }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>{{ __('main.vehicle_owner') }} <span class="text-danger">*</span></label>
                                <div class="d-flex">
                                    <select required name="vehicle_owner_id" class="form-control selectpicker py-1"
                                        data-style="btn-third" data-live-search="true"
                                        title="{{ __('main.vehicle_owner') }}">
                                        @foreach ($vehicleOwners as $owner)
                                            <option value="{{ $owner->id }}">{{ $owner->company_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 text-end">
                                <button class="btn btnn btn-warning py-1 px-3" type="submit">{{ __('main.add') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
