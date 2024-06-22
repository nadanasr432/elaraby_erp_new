@extends('admin.layouts.app-main')
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
                               href="{{ route('admin.types.create') }}"><i
                                    class="fa fa-plus"></i> اضافة نوع اشتراك جديد </a>
                            <h5 class="pull-right alert alert-sm alert-success">عرض كل انواع الاشتراكات</h5>
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
                                <th class="text-center">#</th>
                                <th class="text-center">اسم الاشتراك</th>
                                <th class="text-center"> سعر الاشتراك</th>
                                <th class="text-center"> مدة الاشتراك بالايام</th>
                                <th class="text-center"> الباقة</th>
                                <th class="text-center">تحكم</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i=0;
                            @endphp
                            @foreach ($types as $key => $type)
                                <tr
                                    @if($type->type_name == "تجربة" && $type->type_price == "0")
                                    class="bg-danger text-white"
                                    @endif
                                >
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $type->type_name}}</td>
                                    <td>{{ $type->type_price}}</td>
                                    <td>{{ $type->period}}</td>
                                    <td>
                                        @if(!empty($type->package_id))
                                            {{$type->package->package_name}}
                                        @endif
                                    </td>
                                    <td>
                                        @if($type->type_name != "تجربة" && $type->type_price != "0")
                                            <a href="{{ route('admin.types.edit', $type->id) }}"
                                               class="btn btn-sm btn-info" data-toggle="tooltip"
                                               title="تعديل" data-placement="top"><i class="fa fa-edit"></i></a>

                                            <a class="modal-effect btn btn-sm btn-danger delete_type"
                                               type_id="{{ $type->id }}"
                                               type_name="{{ $type->type_name }}" data-toggle="modal" href="#modaldemo9"
                                               title="delete"><i
                                                    class="fa fa-trash"></i></a>
                                        @endif
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
            <div class="modal-dialog modal-dialog-centered" type="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">حذف نوع اشتراك</h6>
                        <button aria-label="Close" class="close"
                                data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('admin.types.destroy', 'test') }}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>هل انت متأكد من الحذف ?</p><br>
                            <input type="hidden" name="typeid" id="typeid">
                            <input class="form-control" name="typename" id="typename" type="text" readonly>
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
        $('.delete_type').on('click', function () {
            var type_id = $(this).attr('type_id');
            var type_name = $(this).attr('type_name');
            $('.modal-body #typeid').val(type_id);
            $('.modal-body #typename').val(type_name);
        });
    });
</script>
