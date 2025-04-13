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
                            {{ __('main.add-new-shipment') }}
                        </h5>
                        <a class="btn btnn text-white px-3 py-1" style="background-color: #36c7d6" href="{{ route('shipments.index') }}">
                            {{ __('main.back') }}</a>
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('shipments.store') }}" enctype="multipart/form-data" method="post">
                        {{ csrf_field() }}
                        <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-4 mb-3">
                                <label> {{ __('main.name') }} </label>
                                <input dir="rtl" class="form-control" name="name" type="text">
                            </div>
                             <div class="col-md-4 mb-3">
                            <label>{{ __('main.Payload Type') }}</label>
                            <input type="text" name="payload_type" class="form-control" value="{{ old('payload_type') }}" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>{{ __('main.Containers No') }}</label>
                            <input type="text" name="containers_no" class="form-control" value="{{ old('containers_no') }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>{{ __('main.Weight') }}</label>
                            <input type="text" name="weight" class="form-control" value="{{ old('weight') }}">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>{{ __('main.Height') }}</label>
                            <input type="text" name="height" class="form-control" value="{{ old('height') }}">
                        </div>

                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-end">
                            <button class="btn btnn btn-warning py-1 px-3" type="submit">{{ __('main.add') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
