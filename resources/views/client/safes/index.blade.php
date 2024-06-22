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
                            <a class="btn pull-left btn-primary btn-sm" href="{{ route('client.safes.create') }}"><i
                                    class="fa fa-plus"></i> {{ __('sidebar.add-new-store') }} </a>
                            <h5 class="pull-right alert alert-sm alert-success">{{ __('sidebar.list-of-stores') }}</h5>
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
                                        <td>
                                            <a class="modal-effect btn btn-sm btn-danger delete_safe"
                                                safe_id="{{ $safe->id }}" safe_name="{{ $safe->safe_name }}"
                                                data-toggle="modal" href="#modaldemo9" title="delete"><i
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
