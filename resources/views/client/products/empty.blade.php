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
                        {{-- <div class="col-lg-12 margin-tb">
                            <a class="btn text-white px-3 py-1" style="background-color: #36c7d6"
                               href="{{ route('client.products.create') }}"><i
                                    class="fa fa-plus"></i> اضافة منتج جديد </a>
                            <h5 class="pull-right alert custom-title">عرض المنتجات التى نفذت </h5>
                        </div> --}}
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
                                    <td class="d-flex border-0 justify-content-center align-items-center">
                                        <a href="{{ route('client.products.show', $product->id) }}"
                                           class="" data-toggle="tooltip"
                                           title="عرض" data-placement="top"><svg width="19" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" fill="#222751"><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/></svg></a>
                                        @can('قائمة المنتجات المتوفرة (تحكم كامل)')

                                            <a href="{{ route('client.products.edit', $product->id) }}"
                                               class="" data-toggle="tooltip"
                                               title="تعديل" data-placement="top"><svg width="19" height="16" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M18.21 4.87258C18.6 4.48258 18.6 3.83258 18.21 3.46258L15.87 1.12258C15.5 0.732578 14.85 0.732578 14.46 1.12258L12.62 2.95258L16.37 6.70258M0.5 15.0826V18.8326H4.25L15.31 7.76258L11.56 4.01258L0.5 15.0826Z" fill="#4AA16A"/>
                                                </svg></a>

                                            <a class="modal-effect  delete_product"
                                               product_id="{{ $product->id }}"
                                               product_name="{{ $product->product_name }}" data-toggle="modal"
                                               href="#modaldemo9"
                                               title="delete"><svg width="25" height="22" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M18.912 7.33301L18.111 20.95C18.0812 21.4594 17.8577 21.9381 17.4865 22.2881C17.1153 22.6382 16.6243 22.8331 16.114 22.833H8.886C8.37575 22.8331 7.88475 22.6382 7.5135 22.2881C7.14226 21.9381 6.91885 21.4594 6.889 20.95L6.09 7.33301H4V6.33301C4 6.2004 4.05268 6.07322 4.14645 5.97945C4.24021 5.88569 4.36739 5.83301 4.5 5.83301H20.5C20.6326 5.83301 20.7598 5.88569 20.8536 5.97945C20.9473 6.07322 21 6.2004 21 6.33301V7.33301H18.912ZM10.5 3.33301H14.5C14.6326 3.33301 14.7598 3.38569 14.8536 3.47945C14.9473 3.57322 15 3.7004 15 3.83301V4.83301H10V3.83301C10 3.7004 10.0527 3.57322 10.1464 3.47945C10.2402 3.38569 10.3674 3.33301 10.5 3.33301ZM9.5 9.83301L10 18.833H11.5L11.1 9.83301H9.5ZM14 9.83301L13.5 18.833H15L15.5 9.83301H14Z" fill="#F55549"/>
                                                </svg></a>
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
