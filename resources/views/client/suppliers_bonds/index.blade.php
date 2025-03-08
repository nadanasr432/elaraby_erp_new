@extends('client.layouts.app-main')
<style>
    #example-table_filter {
        float: left;
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
                        <div class="col-lg-12 margin-tb d-flex flex-wrap align-items-center justify-content-between">
                            <h5 class=" alert custom-title">
                                {{ __('bonds.list_all_bonds_suppliers') }}
                            </h5>
                            <a class="btn btnn text-white px-3 py-1 " style="background-color: #36c7d6" href="{{ route('supplier.bonds.create') }}"><i
                                    class="fa fa-plus"></i>{{ __('bonds.add_new_supplier_bonds') }}</a>
                            
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
                                {{ count($blondSuppliers) }}
                                @foreach ($blondSuppliers as $branch)
                                    <tr>
                                        <td style="padding: 10px 3px; width: 5% !important; font-size: 10px !important;">
                                            {{ ++$i }}</td>
                                        <td style="padding: 10px 5px;width: 19% !important;">{{ $branch->supplier }}</td>
                                        <td>
                                            @if ($branch->account == 'النقدية في الخزينة')
                                                كاش
                                            @elseif ($branch->account == 'العقد النقدية')
                                                شبكه
                                            @elseif ($branch->account == 'حساب البنك الجاري')
                                                تحويل بنكي
                                            @else
                                                {{ $branch->account }}
                                            @endif
                                        </td>
                                        <td>{{ $branch->type }}</td>
                                        <td>{{ $branch->amount }}</td>
                                        <td>{{ $branch->date }}</td>
                                        <td class="d-flex justify-content-center align-items-center" style="padding: 0; padding-top: 17px; ">
                                            <div class="all"
                                                style="align-items: center; display: flex;justify-content:space-around;    margin-bottom: 11px;">

                                                <!--edit-->
                                                <a href="{{ route('edit_supplier_bond', $branch->id) }}"
                                                    class="" data-toggle="tooltip"
                                                    title="{{ __('main.edit') }}" data-placement="top">
                                                    <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M18.21 4.87258C18.6 4.48258 18.6 3.83258 18.21 3.46258L15.87 1.12258C15.5 0.732578 14.85 0.732578 14.46 1.12258L12.62 2.95258L16.37 6.70258M0.5 15.0826V18.8326H4.25L15.31 7.76258L11.56 4.01258L0.5 15.0826Z" fill="#4AA16A"/>
                                                        </svg>
                                                    </a>

                                                <!--delete-->
                                                <a class="modal-effectr delete_bonds_supplier"
                                                    bond_supplier_id="{{ $branch->id }}"
                                                    bond_supplier_name="{{ $branch->supplier }}" data-toggle="modal"
                                                    href="#modaldemo9" title="delete">
                                                    <svg width="17" height="20" viewBox="0 0 17 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.912 4.33301L14.111 17.95C14.0812 18.4594 13.8577 18.9381 13.4865 19.2881C13.1153 19.6382 12.6243 19.8331 12.114 19.833H4.886C4.37575 19.8331 3.88475 19.6382 3.5135 19.2881C3.14226 18.9381 2.91885 18.4594 2.889 17.95L2.09 4.33301H0V3.33301C0 3.2004 0.0526785 3.07322 0.146447 2.97945C0.240215 2.88569 0.367392 2.83301 0.5 2.83301H16.5C16.6326 2.83301 16.7598 2.88569 16.8536 2.97945C16.9473 3.07322 17 3.2004 17 3.33301V4.33301H14.912ZM6.5 0.333008H10.5C10.6326 0.333008 10.7598 0.385686 10.8536 0.479455C10.9473 0.573223 11 0.7004 11 0.833008V1.83301H6V0.833008C6 0.7004 6.05268 0.573223 6.14645 0.479455C6.24021 0.385686 6.36739 0.333008 6.5 0.333008ZM5.5 6.83301L6 15.833H7.5L7.1 6.83301H5.5ZM10 6.83301L9.5 15.833H11L11.5 6.83301H10Z" fill="#F55549"/>
                                                        </svg>
                                                        </a>


                                                <!--print-->
                                                <svg xmlns="http://www.w3.org/2000/svg"width="17" height="20" viewBox="0 0 512 512"><path d="M128 0C92.7 0 64 28.7 64 64l0 96 64 0 0-96 226.7 0L384 93.3l0 66.7 64 0 0-66.7c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0L128 0zM384 352l0 32 0 64-256 0 0-64 0-16 0-16 256 0zm64 32l32 0c17.7 0 32-14.3 32-32l0-96c0-35.3-28.7-64-64-64L64 192c-35.3 0-64 28.7-64 64l0 96c0 17.7 14.3 32 32 32l32 0 0 64c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-64zM432 248a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/></svg>
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
