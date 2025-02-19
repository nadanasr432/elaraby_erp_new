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
                    <div class="col-12 d-flex align-items-center justify-content-between">
                        <h5 class=" alert alert-sm custom-title">
                            {{ __('stores.edit-store') }}
                        </h5>
                        <a class="btn  text-white px-3 py-1" style="background-color: #ec6880" href="{{ route('client.stores.index') }}">
                            {{ __('main.back') }}</a>
                        
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('client.stores.update', $store->id) }}" enctype="multipart/form-data"
                        method="post">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                        <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label> {{ __('stores.store-name') }} <span class="text-danger">*</span></label>
                                <input value="{{ $store->store_name }}" dir="rtl" required class="form-control"
                                    name="store_name" type="text">
                            </div>

                            <div class="col-md-4">
                                <label> {{ __('stores.inside-a-branch') }} <span class="text-danger">*</span></label>
                                <select required name="branch_id" class="form-control">
                                    <option value="">اختر فرع</option>
                                    @foreach ($branches as $branch)
                                        <option @if ($branch->id == $store->branch_id) selected @endif
                                            value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-start">
                            <button class="btn btn-info pd-x-20 text-white px-4" style="background-color: #222751 !important; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);" type="submit">{{ __('main.update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
