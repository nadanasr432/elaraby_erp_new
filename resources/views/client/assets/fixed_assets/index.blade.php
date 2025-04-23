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
                            <a class="btn pull-left btn-primary btn-sm" href="{{ route('fixed.assets.create') }}"><i
                                    class="fa fa-plus"></i> اضافة اصل ثابت </a>
                            <h5 class="pull-right alert alert-sm alert-success">عرض كل الاصول الثابتة
                            </h5>
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
                                    <th class="text-center">الرقم المرجعي</th>
                                    <th class="text-center">اسم الاصل</th>
                                    <th class="text-center">الكمية</th>
                                    <th class="text-center">{{ __('main.control') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                {{-- @foreach ($branches as $branch)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $branch->branch_name }}</td>
                                        <td>{{ $branch->branch_phone }}</td>
                                        <td>{{ $branch->branch_address }}</td>
                                        <td>{{ $branch->commercial_registration_number }}</td>
                                        <td>
                                            <a href="{{ route('client.branches.edit', $branch->id) }}"
                                                class="btn btn-sm btn-info" data-toggle="tooltip"
                                                title="{{ __('main.edit') }}" data-placement="top"><i
                                                    class="fa fa-edit"></i></a>

                                            <a class="modal-effect btn btn-sm btn-danger delete_branch"
                                                branch_id="{{ $branch->id }}" branch_name="{{ $branch->branch_name }}"
                                                data-toggle="modal" href="#modaldemo9" title="delete"><i
                                                    class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" id="modaldemo9">
            <div class="modal-dialog modal-dialog-centered" branch="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">{{ __('branches.delete-branche') }}
                        </h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('client.branches.destroy', 'test') }}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>{{ __('main.are-you-sure-to-delete') }}</p><br>
                            <input type="hidden" name="branchid" id="branchid">
                            <input class="form-control" name="branchname" id="branchname" type="text" readonly>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{ __('main.cancel') }}</button>
                            <button type="submit" class="btn btn-danger">{{ __('main.delete') }}</button>
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
        $('.delete_branch').on('click', function() {
            var branch_id = $(this).attr('branch_id');
            var branch_name = $(this).attr('branch_name');
            $('.modal-body #branchid').val(branch_id);
            $('.modal-body #branchname').val(branch_name);
        });
    });
</script>
