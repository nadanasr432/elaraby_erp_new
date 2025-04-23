@extends('client.layouts.app-main')
<!-- Internal Data table css -->
<style>
    i.la {
        font-size: 15px !important;
    }

    div#DataTables_Table_0_filter {
        text-align: left !important;
        float: left !important;
        display: inline !important;
    }

    div#DataTables_Table_0_length {
        text-align: right !important;
        float: right !important;
        display: inline !important;
    }

    select[name='DataTables_Table_0_length'] {
        height: 40px !important;
        padding: 10px !important;
        margin-top: 20px;
    }

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
                            <h5 style="min-width: 300px;" class="pull-left alert alert-sm alert-success">
                                {{ __('sidebar.list-of-permissions') }}</h5>
                        </div>
                        <br>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mg-b-0 text-md-nowrap table-hover " id="example-table">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">{{ __('main.permission') }}</th>
                                    <th class="text-center">{{ __('main.date') }}</th>
                                    <th class="text-center">{{ __('main.control') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($roles as $key => $role)
                                    <tr class="text-center">
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->created_at }}</td>
                                        <td>
                                            @can('صلاحيات المستخدمين')
                                                @if ($role->name != 'مدير النظام')
                                                    <a class="btn btn-primary btn-md"
                                                        href="{{ route('client.roles.edit', $role->id) }}"><i
                                                            class="fa fa-pencil"></i> {{ __('main.edit') }} </a>
                                                @endif
                                            @endcan

                                            @can('صلاحيات المستخدمين')
                                                @if ($role->name != 'مدير النظام' && $role->name != 'مستخدمين')
                                                    <a class="modal-effect btn btn-md btn-danger delete_role"
                                                        role_id="{{ $role->id }}" role_name="{{ $role->name }}"
                                                        data-toggle="modal" href="#modaldemo9" title="Delete"><i
                                                            class="fa fa-trash"></i> {{ __('main.delete') }} </a>
                                                @endif
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
        <!--/div-->
        <!-- Modal effects -->
        <div class="modal" id="modaldemo9">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">حذف الدور او الصلاحية</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('client.roles.destroy', 'test') }}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>هل انت متأكد انك تريد الحذف ?</p><br>
                            <input type="hidden" name="role_id" id="role_id" value="">
                            <input class="form-control" name="rolename" id="rolename" type="text" readonly>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء
                            </button>
                            <button type="submit" class="btn btn-danger">تأكيد</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.delete_role').on('click', function() {
            var role_id = $(this).attr('role_id');
            var role_name = $(this).attr('role_name');
            $('.modal-body #role_id').val(role_id);
            $('.modal-body #rolename').val(role_name);
        });
    });
</script>
