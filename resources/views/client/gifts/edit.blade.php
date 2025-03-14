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
                        <a class="btn btn-primary btn-sm pull-left" href="{{ route('client.gifts.index') }}">
                            {{ __('main.back') }}</a>
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-success">
                            تحديث بيانات الهدية
                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('client.gifts.update', $gift->id) }}" enctype="multipart/form-data"
                        method="post">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                        <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label> اسم العميل <span class="text-danger">*</span></label>
                                <select required name="outer_client_id" class="form-control selectpicker"
                                    data-style="btn-danger" data-live-search="true" title="اختر العميل">
                                    @foreach ($outer_clients as $outer_client)
                                        <option @if ($gift->outer_client_id == $outer_client->id) selected @endif
                                            value="{{ $outer_client->id }}">{{ $outer_client->client_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label> المخزن <span class="text-danger">*</span></label>
                                <select required name="store_id" class="form-control">
                                    <option value="">اختر المخزن</option>
                                    @foreach ($stores as $store)
                                        <option @if ($gift->store_id == $store->id) selected @endif
                                            value="{{ $store->id }}">{{ $store->store_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label> المنتج <span class="text-danger">*</span></label>
                                <select required name="product_id" class="form-control" id="product_id">
                                    @foreach ($products as $product)
                                        <option @if ($gift->product_id == $product->id) selected @endif
                                            value="{{ $product->id }}">{{ $product->product_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label> الكمية <span class="text-danger">*</span></label>
                                <input value="{{ $gift->amount }}" dir="ltr" required class="form-control"
                                    name="amount" type="text">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label> تفاصيل الهدية </label>
                                <input value="{{ $gift->details }}" dir="rtl" class="form-control" name="details"
                                    type="text">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label> ملاحظات </label>
                            <input dir="rtl" value="{{ $gift->notes }}" class="form-control" name="notes" type="text">
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button class="btn btn-info pd-x-20" type="submit">تحديث</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
