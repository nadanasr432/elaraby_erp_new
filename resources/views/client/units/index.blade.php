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
                    <div class="col-lg-12 d-flex flex-wrap align-items-center justify-content-between">
                        <h5 class=" alert alert-sm custom-title">{{ __('sidebar.list-products-units') }}</h5>
                        <a class="btn btnn text-white px-3 py-1" style="background-color: #36c7d6" href="{{ route('client.units.create') }}"><i
                                class="fa fa-plus"></i> {{ __('sidebar.add-new-unit') }} </a>
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
                                <th class="text-center">{{ __('units.unit-name') }}</th>
                                <th class="text-center">{{ __('main.control') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($units as $key => $unit)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $unit->unit_name }}</td>
                                    <td class="d-flex align-items-center border-0 justify-content-center">
                                        <a href="{{ route('client.units.edit', $unit->id) }}"
                                            data-toggle="tooltip" title="{{ __('main.update') }}" data-placement="top">
                                                <svg width="19" height="16" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M18.21 4.87258C18.6 4.48258 18.6 3.83258 18.21 3.46258L15.87 1.12258C15.5 0.732578 14.85 0.732578 14.46 1.12258L12.62 2.95258L16.37 6.70258M0.5 15.0826V18.8326H4.25L15.31 7.76258L11.56 4.01258L0.5 15.0826Z" fill="#4AA16A"/>
                                                </svg>
                                            </a>

                                        <!--<a class="modal-effect btn btn-sm btn-danger delete_unit"-->
                                        <!--    unit_id="{{ $unit->id }}" unit_name="{{ $unit->unit_name }}"-->
                                        <!--    data-toggle="modal" href="#modaldemo9" title="{{ __('main.delete') }}"><i-->
                                        <!--        class="fa fa-trash"></i></a>-->
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
        <div class="modal-dialog modal-dialog-centered" unit="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header text-center">
                    <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">{{ __('units.delete-unit') }}</h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('client.units.destroy', 'test') }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>{{ __('main.are-you-sure-to-delete') }}</p><br>
                        <input type="hidden" name="unitid" id="unitid">
                        <input class="form-control" name="unitname" id="unitname" type="text" readonly>
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
    $(document).ready(function () {
        $('.delete_unit').on('click', function () {
            var unit_id = $(this).attr('unit_id');
            var unit_name = $(this).attr('unit_name');
            $('.modal-body #unitid').val(unit_id);
            $('.modal-body #unitname').val(unit_name);
        });
    });
</script>