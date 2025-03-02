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
                        <div class="col-lg-12 d-flex flex-wrap justify-content-between align-items-center">
                            <h5 class=" alert custom-title">{{ __('sidebar.list-of-stores') }}</h5>
                            <a class="btn btnn text-white px-3 py-1" style="background-color: #ec6880" href="{{ route('client.safes.create') }}"><i
                                    class="fa fa-plus"></i> {{ __('sidebar.add-new-store') }} </a>
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
                                    <th class="text-center"> # </th>
                                    <th class="text-center">{{ __('safes.safe-name') }}</th>
                                    <th class="text-center"> {{ __('safes.in-branch') }} </th>
                                    <th class="text-center"> {{ __('safes.safe-balance') }} </th>
                                    <th class="text-center"> {{ __('safes.safe-type') }}</th>
                                    <th class="text-center">{{ __('main.control') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($safes as $key => $safe)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $safe->safe_name }}</td>
                                        <td>{{ $safe->branch->branch_name }}</td>
                                        <td>{{ floatval($safe->balance) }}</td>
                                        <td>
                                            @if ($safe->type == 'main')
                                                رئيسية
                                            @elseif($safe->type == 'secondary')
                                                فرعية
                                            @endif
                                        </td>
                                        <td class="d-flex justify-content-center">
                                            <a class="modal-effect btn  delete_safe"
                                                safe_id="{{ $safe->id }}" safe_name="{{ $safe->safe_name }}"
                                                data-toggle="modal" href="#modaldemo9" title="delete"><svg width="25" height="22" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M18.912 7.33301L18.111 20.95C18.0812 21.4594 17.8577 21.9381 17.4865 22.2881C17.1153 22.6382 16.6243 22.8331 16.114 22.833H8.886C8.37575 22.8331 7.88475 22.6382 7.5135 22.2881C7.14226 21.9381 6.91885 21.4594 6.889 20.95L6.09 7.33301H4V6.33301C4 6.2004 4.05268 6.07322 4.14645 5.97945C4.24021 5.88569 4.36739 5.83301 4.5 5.83301H20.5C20.6326 5.83301 20.7598 5.88569 20.8536 5.97945C20.9473 6.07322 21 6.2004 21 6.33301V7.33301H18.912ZM10.5 3.33301H14.5C14.6326 3.33301 14.7598 3.38569 14.8536 3.47945C14.9473 3.57322 15 3.7004 15 3.83301V4.83301H10V3.83301C10 3.7004 10.0527 3.57322 10.1464 3.47945C10.2402 3.38569 10.3674 3.33301 10.5 3.33301ZM9.5 9.83301L10 18.833H11.5L11.1 9.83301H9.5ZM14 9.83301L13.5 18.833H15L15.5 9.83301H14Z" fill="#F55549"/>
                                                    </svg></a>
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
            <div class="modal-dialog modal-dialog-centered" safe="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">حذف خزينة</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('client.safes.destroy', 'test') }}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>هل انت متأكد من الحذف ?</p><br>
                            <input type="hidden" name="safeid" id="safeid">
                            <input class="form-control" name="safename" id="safename" type="text" readonly>
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
<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.delete_safe').on('click', function() {
            var safe_id = $(this).attr('safe_id');
            var safe_name = $(this).attr('safe_name');
            $('.modal-body #safeid').val(safe_id);
            $('.modal-body #safename').val(safe_name);
        });
    });
</script>
