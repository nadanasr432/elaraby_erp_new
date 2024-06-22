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
                        <div class="clearfix"></div>
                        <div class="col-lg-12 margin-tb">
                            <h5 class="pull-right d-block mb-2">عرض مراكز التكلفة  </h5>

                            <a class="btn pull-left btn-primary btn-sm"
                               href="{{ route('client.cost_center.create') }}"><i
                                    class="fa fa-plus"></i> اضافة مركز جديد </a>

                        </div>
                        <div class="clearfix"></div>
                        <br>

                    </div> <hr/>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-condensed table-striped table-bordered text-center table-hover"
                               id="example-table">
                            <thead>
                            <tr>
                                <th class="text-center">رقم المركز</th>
                                <th class="text-center">اسم المركز
                                </th>
                                <th class="text-center">الاسم بالانجليزي

                                </th>
                                <th class="text-center">الشخص المسئول
                                </th>
                                <th class="text-center">الهاتف</th>
                                <th class="text-center">القيمة</th>
                                <th class="text-center">المدة</th>
                                <th class="text-center">
                                    تاريخ البداية</th>
                                <th class="text-center">تاريخ الإنتهاء </th>
                                <th class="text-center" style="width: 20% !important;">تحكم</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i=0;
                            @endphp
                            @foreach ($cost_centers as $key => $cost_center)
                                <tr>
                                    <td>{{ $cost_center->account_number }}</td>
                                    <td>{{ $cost_center->account_name }}</td>
                                    <td>{{ $cost_center->account_name_en }}</td>
                                    <td>{{ $cost_center->responsible_name }}</td>
                                    <td>{{ $cost_center->phone }}</td>
                                    <td>{{ $cost_center->period }}</td>
                                    <td>{{ $cost_center->value }}</td>
                                    <td>{{ $cost_center->started_at }}</td>
                                    <td>{{ $cost_center->ended_at }}</td>

                                    <td style="width: 20% !important;">

                                            <a href="{{ route('client.cost_center.create', $cost_center->id) }}"
                                               class="btn btn-sm btn-info" data-toggle="tooltip"
                                               title="تعديل" data-placement="top"><i class="fa fa-edit"></i></a>


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
                    {{-- <form action="{{ route('client.cost_center.destroy', 'test') }}" method="post">
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
                    </form> --}}
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
