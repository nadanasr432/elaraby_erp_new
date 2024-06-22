@extends('client.layouts.app-main')
<style>
    .bootstrap-select,
    select.form-control {
        width: 80% !important;
        /*display: inline !important;*/
    }

    label {
        display: block !important;
    }

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
                        <a class="btn btn-primary btn-sm pull-left" href="{{ route('client.gifts.index') }}">
                            {{ __('main.back') }}</a>
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-success">
                            {{ __('sidebar.add-new-gift') }}
                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('client.gifts.store', 'test') }}" enctype="multipart/form-data" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                        <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label> {{ __('sales_bills.client-name') }} <span class="text-danger">*</span></label>
                                <select required name="outer_client_id" class="form-control selectpicker"
                                    data-style="btn-danger" data-live-search="true"
                                    title="{{ __('sales_bills.client-name') }}">
                                    @foreach ($outer_clients as $outer_client)
                                        <option value="{{ $outer_client->id }}">{{ $outer_client->client_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <a target="_blank" href="{{ route('client.outer_clients.create') }}" role="button"
                                    style="width: 15%;display: inline;" class="btn btn-sm btn-warning open_popup">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <label> {{ __('sales_bills.choose-store') }} <span
                                        class="text-danger">*</span></label>
                                <select style="display: inline !important;" required name="store_id" class="form-control">
                                    <option value="">{{ __('sales_bills.choose-store') }}</option>
                                    <?php $i = 0; ?>
                                    @foreach ($stores as $store)
                                        @if ($stores->count() == 1)
                                            <option selected value="{{ $store->id }}">{{ $store->store_name }}
                                            </option>
                                        @else
                                            @if ($i == 0)
                                                <option selected value="{{ $store->id }}">{{ $store->store_name }}
                                                </option>
                                            @else
                                                <option value="{{ $store->id }}">{{ $store->store_name }}</option>
                                            @endif
                                        @endif
                                        <?php $i++; ?>
                                    @endforeach
                                </select>
                                <a target="_blank" href="{{ route('client.stores.create') }}" role="button"
                                    style="width: 15%;display: inline;" class="btn btn-sm btn-warning open_popup">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>

                            <div class="col-md-3">
                                <label> {{ __('main.product-name') }} <span class="text-danger">*</span></label>
                                <select style="display: inline !important;" required name="product_id"
                                    class="form-control" id="product_id">
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                    @endforeach
                                </select>
                                <a target="_blank" href="{{ route('client.products.create') }}" role="button"
                                    style="width: 15%;display: inline;" class="btn btn-sm btn-warning open_popup">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <label> {{ __('main.quantity') }} <span class="text-danger">*</span></label>
                                <input dir="ltr" required class="form-control" name="amount" type="text">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label> {{ __('main.details') }} </label>
                                <input dir="rtl" class="form-control" name="details" type="text">
                            </div>
                            <div class="col-md-4">
                                <label> {{ __('main.notes') }} </label>
                                <input dir="rtl" class="form-control" name="notes" type="text">
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
