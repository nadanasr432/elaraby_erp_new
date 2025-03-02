@extends('client.layouts.app-main')
<style>
/* From Uiverse.io by suda-code */ 

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
                    <div class="col-12 d-flex flex-wrap align-items-center justify-content-between">
                        <h2 class=" alert alert-sm font-weight-bold m-0 p-0 d-flex custom-title align-items-end " style="white-space: nowrap">
                            {{ __('sidebar.add-new-branche') }} 
                        </h2>
                        <a class="btn text-white px-3 py-1 btnn" style="background-color: #ec6880" href="{{ route('client.branches.index') }}">
                            {{ __('main.back') }}
                        </a>
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('client.branches.store', 'test') }}" enctype="multipart/form-data" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                        <h5 class="col-lg-12 d-block">{{ __('main.main-information') }}</h5>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label> {{ __('branches.branche-name') }} <span class="text-danger">*</span></label>
                                <input dir="rtl" required class="form-control" name="branch_name" type="text">
                            </div>

                            <div class="col-md-3">
                                <label> {{ __('branches.branche-phone') }} <span class="text-danger">*</span></label>
                                <input required class="form-control" dir="ltr" name="branch_phone" type="text">
                            </div>

                            <div class="col-md-3">
                                <label> {{ __('branches.branche-address') }} <span
                                        class="text-danger">*</span></label>
                                <input required dir="rtl" class="form-control" name="branch_address" type="text">
                            </div>
                            <div class="col-lg-3">
                                <label for="commercial_register">{{ __('branches.commercial-record') }}</label>
                                <input type="text" class="form-control" dir="ltr" name="commercial_registration_number"
                                    id="commercial_registration_number" />
                            </div>

                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 d-flex justify-content-start">
                            <button style="background-color: #222751 !important; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);"
                             class="btn btn-info pd-x-20 btnn px-5 py-1" type="submit">{{ __('main.add') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
