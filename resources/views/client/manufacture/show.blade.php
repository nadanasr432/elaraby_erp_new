@extends('client.layouts.app-main')
<style>
    .btn.dropdown-toggle.bs-placeholder {
        height: 40px;
    }

    .bootstrap-select {
        width: 100% !important;
    }

    .form-control {
        height: 45px !important;
        padding: 10px !important;
    }

    .form-switch .form-check-input {
        width: 50px !important;
        height: 20px !important;
    }
</style>
@section('content')

    <div class="row p-0">
        <div class="col-md-12">
            <div class="card">
                <!------HEADER----->
                <div class="card-header border-bottom border-secondary p-1">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h3 class="pull-right font-weight-bold ml-1">
                            {{ __('manufactures.addnewmanufacture') }}
                        </h3>
                        <a class="btn btn-danger btn-sm pull-left p-1" href="http://arabygithub.test/ar/client/journal/get">
                            {{ __('products.back') }}
                        </a>
                    </div>
                </div>

                <!------HEADER----->
                <div class="card-body p-2">

                        <div class="row p-0">

                            <!----store---->
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label for="store_id">

                                    {{ __('products.store_name') }}
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <input disabled type="text" disabled class="form-control" value="{{$manufacture->store->store_name ?? " "}}">
                            </div>
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label for="status">

                                    {{ __('manufactures.status') }}
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <input disabled type="text" disabled class="form-control" value="{{$manufacture->status ?? " "}}">

                            </div>
                            <div class="form-group col-lg-3 pr-0" dir="rtl">
                                <label for="date">

                                    {{ __('manufactures.date') }}
                                    <span class="text-danger font-weight-bold">*</span>
                                </label>
                                <input disabled type="date" value="{{$manufacture->date ?? " "}}" name="date" class="form-control"
                                    value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">

                            </div>
                        </div>
                        <div class='row'>
                           <h2>{{ __('manufactures.Products') }}</h2>
                            <table class="table table-bordered mt-3 mb-3">
                                <thead>
                                    <tr>
                                        <th>{{ __('manufactures.Product Name') }}</th>
                                        <th>{{ __('manufactures.Price') }}</th>
                                        <th>{{ __('manufactures.Quantity') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="productTable">
                                @foreach ($manufacture->products as $product )
                                <tr>
                                    <td>{{$product->product->product_name }}</td>
                                    <td>{{$product->product->sector_price }}</td>
                                    <td>{{$product->qty }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">{{ __('manufactures.Total') }}</td>
                                        <td colspan="2" id="totalPrice">{{$manufacture->total }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">{{ __('manufactures.Total Quantity') }}</td>
                                        <td colspan="2" id="totalQty">{{$manufacture->qty }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="form-group row">
                            <label for="date">

                                {{ __('manufactures.note') }}
                            </label>
                            <textarea disabled name="note" class="form-control">{{$manufacture->note ?? " "}}</textarea>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection
