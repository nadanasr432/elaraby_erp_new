@extends('client.layouts.app-main')
<style>

</style>
@section('content')
    @if (session('success'))
        <div class="alert alert-success fade show">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger fade show">
            {{ session('error') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="col-12">
                        <a class="btn btn-primary btn-sm pull-left" href="{{ route('client.stores.index') }}">
                            {{ __('main.back') }}
                        </a>
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-success">
                            {{ __('sidebar.convert-between-storages') }}
                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('client.stores.transfer.post') }}" enctype="multipart/form-data" method="post">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                        <h5 class="col-lg-12 d-block mb-2"> {{ __('main.main-information') }}
                        </h5>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="d-block"> {{ __('stores.from-store') }} <span
                                        class="text-danger">*</span></label>
                                <select required class="form-control selectpicker show-tick"
                                    data-title="{{ __('stores.choose-store') }}" data-live-search="true"
                                    data-style="btn-danger" name="from_store" id="from_store">
                                    @foreach ($stores as $store)
                                        <option value="{{ $store->id }}">{{ $store->store_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="d-block"> {{ __('stores.to-store') }} <span
                                        class="text-danger">*</span></label>
                                <select required class="form-control selectpicker show-tick"
                                    data-title="{{ __('stores.choose-store') }}" data-live-search="true"
                                    data-style="btn-info" name="to_store" id="to_store">
                                    @foreach ($stores as $store)
                                        <option value="{{ $store->id }}">{{ $store->store_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="d-block"> {{ __('sidebar.products') }} <span
                                        class="text-danger">*</span></label>
                                <select required class="form-control selectpicker show-tick"
                                    data-title="{{ __('stores.choose-product') }}" data-live-search="true"
                                    data-style="btn-success" name="product_id" id="product_id">
                                    {{-- @foreach ($products as $product) --}}
                                    {{-- <option value="{{$product->id}}">{{$product->product_name}}</option> --}}
                                    {{-- @endforeach --}}
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="d-block"> {{ __('main.quantity') }} <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="quantity" min="1" id="quantity"
                                    required />
                            </div>

                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <label class="d-block"> {{ __('main.date') }} <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="date" id="date"
                                    value="{{ date('Y-m-d') }}" required />
                            </div>
                            <div class="col-md-3">
                                <label class="d-block"> {{ __('main.notes') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" dir="rtl" class="form-control" id="notes" name="notes" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button class="btn btn-warning pd-x-20" type="submit">
                                {{ __('main.convert') }}
                            </button>
                        </div>
                    </form>
                    <div class="clearfix"></div>

                    @if (!$transfers->isEmpty())
                        <hr>
                        <p class="alert alert-sm alert-success text-center">
                            عمليات التحويل بين المخازن
                        </p>
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered text-center table-hover"
                                id="example-table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center"> من مخزن</th>
                                        <th class="text-center"> الى مخزن</th>
                                        <th class="text-center"> المنتج</th>
                                        <th class="text-center"> الكمية</th>
                                        <th class="text-center"> التاريخ</th>
                                        <th class="text-center">ملاحظات</th>
                                        <th class="text-center">المسؤول</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach ($transfers as $key => $transfer)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $transfer->fromStore->store_name }}</td>
                                            <td>{{ $transfer->toStore->store_name }}</td>
                                            <td>{{ $transfer->product->product_name }}</td>
                                            <td>{{ $transfer->quantity }}</td>
                                            <td>{{ $transfer->date }}</td>
                                            <td>{{ $transfer->notes }}</td>
                                            <td>{{ $transfer->client->name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {

        $('#from_store').on('change', function() {
            let from_store_id = $(this).val();
            $.post("{{ route('get.products.by.store.id') }}", {
                "_token": "{{ csrf_token() }}",
                from_store_id: from_store_id,
            }, function(data) {
                $('#product_id').html(data);
                $('#product_id').selectpicker('refresh');
            });
        });
    });
</script>
