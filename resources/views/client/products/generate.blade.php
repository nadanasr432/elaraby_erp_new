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
                        <a class="btn btn-primary btn-sm pull-left" href="{{ route('client.products.index') }}">
                            {{ __('main.back') }}</a>
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-success">
                            طباعة باركود المنتجات
                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <br>
                    <form target="_blank" action="{{ route('generate.barcode') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="col-lg-4 pull-right">
                            <div class="form-group">
                                <label class="d-block" for=""> اسم المنتج </label>
                                <select name="product_id" class="form-control show-tick selectpicker"
                                    data-style="btn-danger" data-live-search="true" title="اختر منتج" required>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 pull-right">
                            <div class="form-group">
                                <label class="d-block" for=""> العدد </label>
                                <input type="number" value="1" class="form-control" min="1" name="count" />
                            </div>
                        </div>
                        <div class="col-lg-4 pull-right">
                            <div class="form-group">
                                <label class="d-block" for=""> {{__('sidebar.expire_date')}} </label>
                                <input type="date" value="<?= date('Y-m-d') ?>" class="form-control" name="exp_date" />
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-12 text-center">
                            <button type="submit" class="btn btn-md btn-success">
                                <i class="fa fa-print"></i>
                                طباعة
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
    <script>

    </script>
@endsection
