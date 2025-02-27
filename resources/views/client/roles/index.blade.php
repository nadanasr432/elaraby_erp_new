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
                            <h5  class="alert custom-title">
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
                                                    <a class=" "
                                                        href="{{ route('client.roles.edit', $role->id) }}"><svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M18.21 4.87258C18.6 4.48258 18.6 3.83258 18.21 3.46258L15.87 1.12258C15.5 0.732578 14.85 0.732578 14.46 1.12258L12.62 2.95258L16.37 6.70258M0.5 15.0826V18.8326H4.25L15.31 7.76258L11.56 4.01258L0.5 15.0826Z" fill="#4AA16A"/>
                                                            </svg>
                                                            {{-- </i> {{ __('main.edit') }} --}}
                                                    </a> 
                                                @endif
                                            @endcan

                                            @can('صلاحيات المستخدمين')
                                                @if ($role->name != 'مدير النظام' && $role->name != 'مستخدمين')
                                                    <a class="modal-effect   delete_role"
                                                        role_id="{{ $role->id }}" role_name="{{ $role->name }}"
                                                        data-toggle="modal" href="#modaldemo9" title="Delete"><svg width="17" height="20" viewBox="0 0 17 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M14.912 4.33203L14.111 17.949C14.0812 18.4584 13.8577 18.9371 13.4865 19.2872C13.1153 19.6372 12.6243 19.8321 12.114 19.832H4.886C4.37575 19.8321 3.88475 19.6372 3.5135 19.2872C3.14226 18.9371 2.91885 18.4584 2.889 17.949L2.09 4.33203H0V3.33203C0 3.19942 0.0526785 3.07225 0.146447 2.97848C0.240215 2.88471 0.367392 2.83203 0.5 2.83203H16.5C16.6326 2.83203 16.7598 2.88471 16.8536 2.97848C16.9473 3.07225 17 3.19942 17 3.33203V4.33203H14.912ZM6.5 0.332031H10.5C10.6326 0.332031 10.7598 0.38471 10.8536 0.478478C10.9473 0.572246 11 0.699423 11 0.832031V1.83203H6V0.832031C6 0.699423 6.05268 0.572246 6.14645 0.478478C6.24021 0.38471 6.36739 0.332031 6.5 0.332031ZM5.5 6.83203L6 15.832H7.5L7.1 6.83203H5.5ZM10 6.83203L9.5 15.832H11L11.5 6.83203H10Z" fill="#F55549"/>
                                                            </svg>
                                                             {{-- {{ __('main.delete') }}  --}}
                                                    </a>
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
