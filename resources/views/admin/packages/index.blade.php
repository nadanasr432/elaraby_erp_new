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
                               href="{{ route('admin.packages.create') }}"><i
                                    class="fa fa-plus"></i> اضافة باقة جديدة </a>
                            <h5 class="pull-right alert alert-sm alert-success">عرض كل الباقات </h5>
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
                                <th class="text-center"> اسم الباقة</th>
                                <th class="text-center"> عدد المستخدمين</th>
                                <th class="text-center"> عدد الموظفين</th>
                                <th class="text-center"> عدد العملاء</th>
                                <th class="text-center"> عدد الموردين</th>
                                <th class="text-center"> عدد الفواتير</th>
                                <th class="text-center"> شاشة المنتجات</th>
                                <th class="text-center"> شاشة الديون</th>
                                <th class="text-center"> شاشة البنوك والخزن</th>
                                <th class="text-center"> شاشة المبيعات</th>
                                <th class="text-center"> شاشة المشتريات</th>
                                <th class="text-center"> شاشة الماليات</th>
                                <th class="text-center"> شاشة التسويق</th>
                                <th class="text-center"> شاشة دفتر اليومية</th>
                                <th class="text-center"> شاشة التقارير</th>
                                <th class="text-center"> شاشة الضبط</th>
                                <th class="text-center">تحكم</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i=0;
                            @endphp
                            @foreach ($packages as $package)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{$package->package_name}}</td>
                                    <td>{{$package->users_count}}</td>
                                    <td>{{$package->employees_count}}</td>
                                    <td>{{$package->outer_clients_count}}</td>
                                    <td>{{$package->suppliers_count}}</td>
                                    <td>{{$package->bills_count}}</td>
                                    <td>
                                        @if($package->products == "0")
                                            لا تظهر
                                        @elseif($package->products == "1")
                                            تظهر
                                        @endif
                                    </td>
                                    <td>
                                        @if($package->debt == "0")
                                            لا تظهر
                                        @elseif($package->debt == "1")
                                            تظهر
                                        @endif
                                    </td>
                                    <td>
                                        @if($package->banks_safes == "0")
                                            لا تظهر
                                        @elseif($package->banks_safes == "1")
                                            تظهر
                                        @endif
                                    </td>
                                    <td>
                                        @if($package->sales == "0")
                                            لا تظهر
                                        @elseif($package->sales == "1")
                                            تظهر
                                        @endif
                                    </td>
                                    <td>
                                        @if($package->purchases == "0")
                                            لا تظهر
                                        @elseif($package->purchases == "1")
                                            تظهر
                                        @endif
                                    </td>
                                    <td>
                                        @if($package->finance == "0")
                                            لا تظهر
                                        @elseif($package->finance == "1")
                                            تظهر
                                        @endif
                                    </td>
                                    <td>
                                        @if($package->marketing == "0")
                                            لا تظهر
                                        @elseif($package->marketing == "1")
                                            تظهر
                                        @endif
                                    </td>
                                    <td>
                                        @if($package->accounting == "0")
                                            لا تظهر
                                        @elseif($package->accounting == "1")
                                            تظهر
                                        @endif
                                    </td>
                                    <td>
                                        @if($package->reports == "0")
                                            لا تظهر
                                        @elseif($package->reports == "1")
                                            تظهر
                                        @endif
                                    </td>
                                    <td>
                                        @if($package->settings == "0")
                                            لا تظهر
                                        @elseif($package->settings == "1")
                                            تظهر
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.packages.edit', $package->id) }}"
                                           class="btn btn-sm btn-info" data-toggle="tooltip"
                                           title="تعديل" data-placement="top"><i class="fa fa-edit"></i></a>

                                        <a class="modal-effect btn btn-sm btn-danger delete_package"
                                           package_id="{{ $package->id }}"
                                           package_name="{{ $package->package_name }}" data-toggle="modal"
                                           href="#modaldemo9"
                                           title="delete"><i
                                                class="fa fa-trash"></i></a>
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
                        <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">حذف باقة</h6>
                        <button aria-label="Close" class="close"
                                data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('admin.packages.destroy', 'test') }}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>هل انت متأكد من الحذف ?</p><br>
                            <input type="hidden" name="packageid" id="packageid">
                            <input class="form-control" name="packagename" id="packagename" type="text" readonly>
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
        $('.delete_package').on('click', function () {
            var package_id = $(this).attr('package_id');
            var package_name = $(this).attr('package_name');
            $('.modal-body #packageid').val(package_id);
            $('.modal-body #packagename').val(package_name);
        });
    });
</script>
