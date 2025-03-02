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
                    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center">
                        <h5 class=" alert custom-title">
                            {{ __('sidebar.add-new-store') }} </h5>
                        <a class="btn btnn text-white px-3 py-1" style="background-color: #ec6880" href="{{ route('client.safes.index') }}">
                            {{ __('main.back') }}</a>
                        
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('client.safes.store', 'test') }}" enctype="multipart/form-data" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                        <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                        <hr>
                        <div class="row mb-3">

                            <div class="col-md-6 mb-2">
                                <label> {{ __('safes.safe-name') }} <span class="text-danger">*</span></label>
                                <input dir="rtl" required class="form-control" name="safe_name" type="text">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label> {{ __('safes.in-branch') }} <span class="text-danger">*</span></label>
                                <div class="d-flex">
                                    <select  required name="branch_id"
                                    class="form-control w-100">
                                    <option value="">{{ __('safes.choose-branch') }}</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                    @endforeach
                                </select>
                                <a target="_blank" href="{{ route('client.branches.create') }}" role="button"
                                     class="btn d-flex align-items-center btn-warning open_popup">
                                    <i class="fa fa-plus"></i>
                                </a>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label> {{ __('safes.safe-balance') }} <span class="text-danger">*</span></label>
                                <input dir="ltr" required class="form-control" name="balance" type="number" min="0.001" step="0.001">
                            </div>
                            <div class="col-md-6">
                                <label> {{ __('safes.safe-type') }} <span class="text-danger">*</span></label>
                                <select required name="type" class="form-control">
                                    <option value="">{{ __('safes.safe-type') }}</option>
                                    <option value="main">رئيسية</option>
                                    <option value="secondary">فرعية</option>
                                </select>
                            </div>

                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-end">
                            <button class="btn btnn btn-warning px-3 py-1" type="submit">{{ __('main.add') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
