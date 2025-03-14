@extends('client.layouts.app-main')
<style>

</style>
@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissable fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('success') }}
        </div>
    @endif
    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <div class="col-lg-12 margin-tb">
                            <a class="btn pull-left btn-primary btn-sm"
                               href="{{ route('client.products.create') }}"><i
                                    class="fa fa-plus"></i> اضافة منتج جديد </a>
                            <h5 class="pull-right alert alert-sm alert-danger">عرض المنتجات التى نفذت </h5>
                        </div>
                        <br>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-condensed table-striped table-bordered text-center table-hover"
                               id="example-table">
                            <thead>
                            <tr>
                                <th class="text-center">المخزن</th>
                                <th class="text-center">الفئة</th>
                                <th class="text-center">الاسم</th>
                                <th class="text-center">جملة</th>
                                <th class="text-center">قطاعى</th>
                                <th class="text-center">تكلفة</th>
                                <th class="text-center">رصيد مخزون</th>
                                <th class="text-center" style="width: 20% !important;">تحكم</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i=0;
                            @endphp
                            @foreach ($products as $key => $product)
                                <tr>
                                    <td>{{ $product->store ? $product->store->store_name : '' }}</td>
                                    <td>
                                        {{ $product->category->category_name}}
                                        @if(!empty($product->sub_category_id))
                                            {{ $product->subcategory->sub_category_name}}
                                        @endif
                                    </td>
                                    <td>{{ $product->product_name }}</td>
                                    <td>
                                        {{floatval($product->wholesale_price)}}
                                    </td>
                                    <td>
                                        {{floatval($product->sector_price)}}
                                    </td>
                                    <td>
                                        {{floatval($product->purchasing_price)}}
                                    </td>
                                    <td>
                                        {{floatval($product->first_balance)}}
                                        @if(!empty($product->unit_id))
                                            {{$product->unit->unit_name}}
                                        @endif
                                    </td>
                                    <td style="width: 20% !important;">
                                        <a href="{{ route('client.products.show', $product->id) }}"
                                           class="btn btn-sm btn-success" data-toggle="tooltip"
                                           title="عرض" data-placement="top"><i class="fa fa-eye"></i></a>
                                        @can('قائمة المنتجات المتوفرة (تحكم كامل)')

                                            <a href="{{ route('client.products.edit', $product->id) }}"
                                               class="btn btn-sm btn-info" data-toggle="tooltip"
                                               title="تعديل" data-placement="top"><i class="fa fa-edit"></i></a>

                                            <a class="modal-effect btn btn-sm btn-danger delete_product"
                                               product_id="{{ $product->id }}"
                                               product_name="{{ $product->product_name }}" data-toggle="modal"
                                               href="#modaldemo9"
                                               title="delete"><i
                                                    class="fa fa-trash"></i></a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="modaldemo9">
            <div class="modal-dialog modal-dialog-centered" product="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">حذف منتج</h6>
                        <button aria-label="Close" class="close"
                                data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('client.products.destroy', 'test') }}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>هل انت متأكد من الحذف ?</p><br>
                            <input type="hidden" name="productid" id="productid">
                            <input class="form-control" name="productname" id="productname" type="text" readonly>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                            <button type="submit" class="btn btn-danger">حذف</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{asset('app-assets/js/jquery.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $('.delete_product').on('click', function () {
            var product_id = $(this).attr('product_id');
            var product_name = $(this).attr('product_name');
            $('.modal-body #productid').val(product_id);
            $('.modal-body #productname').val(product_name);
        });
    });
</script>
