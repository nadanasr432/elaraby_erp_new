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
                            <a class="btn pull-left btn-primary btn-sm" href="{{ route('client.banks.create') }}"><i
                                    class="fa fa-plus"></i> {{ __('sidebar.add-new-bank') }} </a>
                            <h5 class="pull-right alert alert-sm alert-success">{{ __('sidebar.list-of-banks') }}</h5>
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
                                    <th class="text-center">{{ __('banks.bank-name') }}</th>
                                    <th class="text-center">{{ __('banks.bank-balance') }}</th>
                                    <th class="text-center">{{ __('main.control') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($banks as $key => $bank)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $bank->bank_name }}</td>
                                        <td>
                                            {{ floatval($bank->bank_balance) }}
                                        </td>
                                        <td>
                                            <a href="{{ route('client.banks.edit', $bank->id) }}"
                                                class="btn btn-sm btn-info" data-toggle="tooltip" title="تعديل"
                                                data-placement="top"><i class="fa fa-edit"></i></a>

                                            <a class="modal-effect btn btn-sm btn-danger delete_bank"
                                                bank_id="{{ $bank->id }}" bank_name="{{ $bank->bank_name }}"
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
            <div class="modal-dialog modal-dialog-centered" bank="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header text-center">
                        <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">حذف بنك</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{ route('client.banks.destroy', 'test') }}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>هل انت متأكد من الحذف ?</p><br>
                            <input type="hidden" name="bankid" id="bankid">
                            <input class="form-control" name="bankname" id="bankname" type="text" readonly>
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
        $('.delete_bank').on('click', function() {
            var bank_id = $(this).attr('bank_id');
            var bank_name = $(this).attr('bank_name');
            $('.modal-body #bankid').val(bank_id);
            $('.modal-body #bankname').val(bank_name);
        });
    });
</script>
