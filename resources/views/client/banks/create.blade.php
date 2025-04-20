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
                    <div class="col-12">
                        <a class="btn btn-primary btn-sm pull-left" href="{{ route('client.banks.index') }}">
                            {{ __('main.back') }}</a>
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-success">
                            {{ __('sidebar.add-new-bank') }} </h5>
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('client.banks.store', 'test') }}" enctype="multipart/form-data" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                        <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label> {{ __('banks.bank-name') }} <span class="text-danger">*</span></label>
                                <input dir="rtl" required class="form-control" name="bank_name" type="text">
                            </div>
                            <div class="col-md-4">
                                <label> {{ __('banks.bank-balance') }} <span class="text-danger">*</span></label>
                                <input dir="ltr" value="0" required class="form-control" name="bank_balance" type="text">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button class="btn btn-info pd-x-20" type="submit">{{ __('main.add') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
