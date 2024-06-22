@extends('client.layouts.app-main')
<style>
#example-table_filter{
    float:left;
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
                            <a class="btn pull-left btn-primary btn-sm" href="{{ route('supplier.bonds.create') }}"><i
                                    class="fa fa-plus"></i>{{ __('bonds.add_new_supplier_bonds') }}</a>
                            <h5 class="pull-right alert alert-sm alert-success"> 
                            {{ __('bonds.list_all_bonds_suppliers') }}
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
                                    <th class="text-center">#</th>
                                    <th class="text-center">{{ __('bonds.supplier_name') }}</th>
                                    <th class="text-center">{{ __('bonds.account') }}</th>
                                    <th class="text-center">{{ __('bonds.type') }}</th>
                                    <th class="text-center">{{ __('bonds.date') }}</th>
                                    <th class="text-center">{{ __('bonds.amount') }}</th>
                                    <th class="text-center">{{ __('main.control') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                {{ count($blondSuppliers)}}
                                @foreach ($blondSuppliers as $branch)
                                <tr>
                                    <td style="padding: 10px 3px; width: 5% !important; font-size: 10px !important;">{{ ++$i }}</td>
                                    <td style="padding: 10px 5px;width: 19% !important;">{{ $branch->supplier }}</td>
                                    <td>{{ $branch->account }}</td>
                                    <td>{{ $branch->type }}</td>
                                    <td>{{ $branch->amount }}</td>
                                    <td>{{ $branch->date }}</td>
                                    <td style="padding: 0; padding-top: 17px; ">
                                        <div class="all" style="align-items: center; display: flex;justify-content:space-around;    margin-bottom: 11px;">
                                            
                                            <!--edit-->
                                            <a href="{{ route('edit_supplier_bond', $branch->id) }}"
                                                class="btn btn-sm btn-info" data-toggle="tooltip"
                                                title="{{ __('main.edit') }}" data-placement="top"><i
                                                    class="fa fa-edit"></i></a>
                                    
                                            <!--delete-->
                                            <a class="modal-effect btn btn-sm btn-danger delete_bonds_supplier"
                                                bond_supplier_id="{{ $branch->id }}" bond_supplier_name="{{ $branch->supplier }}"
                                                data-toggle="modal" href="#modaldemo9" title="delete"><i
                                                    class="fa fa-trash"></i></a>
                         
                         
                                            <!--print-->
                                            <svg title="print" onclick="window.location.href='/ar/client/showSupplierBondPrint/{{$branch->id}}'" style="cursor:pointer;background-color: #18be77 !important; border: 2px solid #1ec481 !important; padding: 5px; border-radius: 3px;" xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="white" class="bi bi-printer-fill" viewBox="0 0 16 16">
                                              <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                              <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                                            </svg>
                                        </div>
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
            <div class="modal-dialog modal-dialog-centered" branch="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">{{ __('branches.delete-branche') }}
                        </h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('supplier_bonds_delete') }}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>{{ __('main.are-you-sure-to-delete') }}</p><br>
                            <input type="hidden" name="supplierID" id="supplierID">
                            <input class="form-control" name="supplierName" id="supplierName" type="text" readonly>
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
        $('.delete_bonds_supplier').on('click', function() {
            var supplier_id = $(this).attr('bond_supplier_id');
            var supplier_name = $(this).attr('bond_supplier_name');
            $('.modal-body #supplierID').val(supplier_id);
            $('.modal-body #supplierName').val(supplier_name);
        });
    });
</script>
