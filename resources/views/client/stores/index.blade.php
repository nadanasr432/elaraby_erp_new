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
                            <a class="btn pull-left btn-primary btn-sm" href="{{ route('client.stores.create') }}"><i
                                    class="fa fa-plus"></i> {{ __('sidebar.add-new-storage') }} </a>
                            <h5 class="pull-right alert alert-sm alert-success">{{ __('stores.show-all-stores') }}</h5>
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
                                    <th class="text-center">{{ __('stores.store-name') }}</th>
                                    <th class="text-center"> {{ __('stores.inside-a-branch') }} </th>
                                    <th class="text-center">{{ __('main.control') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($stores as $key => $store)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $store->store_name }}</td>
                                        <td>{{ $store->branch ? $store->branch->branch_name : '-' }}</td>
                                        <td>
                                            <a href="{{ route('client.stores.edit', $store->id) }}"
                                                class="btn btn-sm btn-info" data-toggle="tooltip"
                                                title="{{ __('main.edit') }}" data-placement="top"><i
                                                    class="fa fa-edit"></i></a>

                                            <a class="modal-effect btn btn-sm btn-danger delete_store"
                                                store_id="{{ $store->id }}" store_name="{{ $store->store_name }}"
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
            <div class="modal-dialog modal-dialog-centered" store="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">{{ __('stores.delete-store') }}</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('client.stores.destroy', 'test') }}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>{{ __('main.are-you-sure-to-delete') }}</p><br>
                            <input type="hidden" name="storeid" id="storeid">
                            <input class="form-control" name="storename" id="storename" type="text" readonly>
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
        $('.delete_store').on('click', function() {
            var store_id = $(this).attr('store_id');
            var store_name = $(this).attr('store_name');
            $('.modal-body #storeid').val(store_id);
            $('.modal-body #storename').val(store_name);
        });
    });
</script>
