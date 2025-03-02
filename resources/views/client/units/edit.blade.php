@extends('client.layouts.app-main')
<style>

</style>
@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>الاخطاء :</strong>
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
                    <div class=" d-flex align-items-center justify-content-between">                       
                        <h5 class="alert alert-sm custom-title">
                            {{ __('units.update-units') }}
                        </h5>
                        <a class="btn btnn text-white px-3 py-1" style="background-color: #ec6880" href="{{ route('client.units.index') }}">
                            {{ __('main.back') }}</a>
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('client.units.update', $unit->id) }}" enctype="multipart/form-data"
                        method="post">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                        <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label> {{ __('units.unit-name') }} <span class="text-danger">*</span></label>
                                <input value="{{ $unit->unit_name }}" dir="rtl" required class="form-control"
                                    name="unit_name" type="text">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-start">
                            <button class="btn btnn pd-x-20 text-white px-4" style="background-color: #222751 !important; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);" type="submit">{{ __('main-update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
