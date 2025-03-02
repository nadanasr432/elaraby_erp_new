@extends('client.layouts.app-main')
<style>
    #example-table-false-ordering_filter {
        float: left !important;
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
                    <div class="d-flex flex-wrap justify-content-between">
                        <div class="col-lg-12 d-flex flex-wrap justify-content-between">
                            <h5 class=" alert custom-title">
                                {{ __('bonds.list_all_bonds_clients') }}
                            </h5>
                            <a class="btn btnn px-3 py-1 text-white" style="background-color: #ec6880" href="{{ route('client.bonds.create') }}">
                                <i class="fa fa-plus"></i>{{ __('bonds.add_new_client_bonds') }} 
                            </a>
                        </div>
                        <br>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-condensed table-striped table-bordered text-center table-hover"
                            id="example-table-false-ordering">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">{{ __('bonds.client_name') }}</th>
                                    <th class="text-center">{{ __('bonds.account') }}</th>
                                    <th class="text-center">{{ __('bonds.type') }}</th>
                                    <th class="text-center">{{ __('bonds.amount') }}</th>
                                    <th class="text-center">{{ __('bonds.date') }}</th>
                                    <th class="text-center">{{ __('main.control') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($bondClients as $branch)
                                    <tr>
                                        <td style="padding: 10px 3px; width: 5% !important; font-size: 10px !important;">
                                            {{ ++$i }}</td>
                                        <td style="padding: 10px 5px;width: 19% !important;">{{ $branch->client }}</td>
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
                                        <td class="d-flex justify-content-center" style="padding: 0; padding-top: 17px; ">
                                            <div class="all"
                                                style="align-items: center; display: flex;justify-content:center; margin-bottom: 11px;">
                                                <a href="{{ route('edit_client_bond', $branch->id) }}"
                                                    data-toggle="tooltip"
                                                    title="{{ __('main.edit') }}" data-placement="top"><svg width="19" height="16" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M18.21 4.87258C18.6 4.48258 18.6 3.83258 18.21 3.46258L15.87 1.12258C15.5 0.732578 14.85 0.732578 14.46 1.12258L12.62 2.95258L16.37 6.70258M0.5 15.0826V18.8326H4.25L15.31 7.76258L11.56 4.01258L0.5 15.0826Z" fill="#4AA16A"/>
                                                        </svg></a>

                                                <a class="modal-effect  delete_bonds_client"
                                                    bond_client_id="{{ $branch->id }}"
                                                    bond_client_name="{{ $branch->client }}" data-toggle="modal"
                                                    href="#modaldemo9" title="delete"><svg width="25" height="22" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M18.912 7.33301L18.111 20.95C18.0812 21.4594 17.8577 21.9381 17.4865 22.2881C17.1153 22.6382 16.6243 22.8331 16.114 22.833H8.886C8.37575 22.8331 7.88475 22.6382 7.5135 22.2881C7.14226 21.9381 6.91885 21.4594 6.889 20.95L6.09 7.33301H4V6.33301C4 6.2004 4.05268 6.07322 4.14645 5.97945C4.24021 5.88569 4.36739 5.83301 4.5 5.83301H20.5C20.6326 5.83301 20.7598 5.88569 20.8536 5.97945C20.9473 6.07322 21 6.2004 21 6.33301V7.33301H18.912ZM10.5 3.33301H14.5C14.6326 3.33301 14.7598 3.38569 14.8536 3.47945C14.9473 3.57322 15 3.7004 15 3.83301V4.83301H10V3.83301C10 3.7004 10.0527 3.57322 10.1464 3.47945C10.2402 3.38569 10.3674 3.33301 10.5 3.33301ZM9.5 9.83301L10 18.833H11.5L11.1 9.83301H9.5ZM14 9.83301L13.5 18.833H15L15.5 9.83301H14Z" fill="#F55549"/>
                                                        </svg>
                                                </a>
                                                <a href="">
                                                    <svg width="21" height="18" viewBox="0 0 512 512" fill="#222751"><path d="M128 0C92.7 0 64 28.7 64 64l0 96 64 0 0-96 226.7 0L384 93.3l0 66.7 64 0 0-66.7c0-17-6.7-33.3-18.7-45.3L400 18.7C388 6.7 371.7 0 354.7 0L128 0zM384 352l0 32 0 64-256 0 0-64 0-16 0-16 256 0zm64 32l32 0c17.7 0 32-14.3 32-32l0-96c0-35.3-28.7-64-64-64L64 192c-35.3 0-64 28.7-64 64l0 96c0 17.7 14.3 32 32 32l32 0 0 64c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-64zM432 248a24 24 0 1 1 0 48 24 24 0 1 1 0-48z"/></svg>
                                                </a>
                                                
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
                    <form action="{{ route('client_bonds_delete') }}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>{{ __('main.are-you-sure-to-delete') }}</p><br>
                            <input type="hidden" name="client_bond_id" id="client_bond_id">
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
        $('#example-table-false-ordering').dataTable({
            "ordering": false
        });


        $('.delete_bonds_client').on('click', function() {
            var bond_id = $(this).attr('bond_client_id');
            var bond_name = $(this).attr('bond_client_name');
            $('.modal-body #client_bond_id').val(bond_id);
            $('.modal-body #branchname').val(bond_name);
        });
    });
</script>
