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
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>الاخطاء :</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="col-12">
                        <a class="btn btn-primary btn-sm pull-left" href="{{ route('client.expenses.index') }}">
                            {{ __('main.back') }}</a>
                        <h5 style="min-width: 300px;" class="pull-right alert alert-sm alert-success">
                            {{ __('sidebar.static-expenses') }}
                        </h5>
                    </div>
                    <div class="clearfix"></div>
                    <br>

                    <form class="parsley-style-1" id="selectForm2" name="selectForm2"
                        action="{{ route('client.fixed.expenses.store', 'test') }}" enctype="multipart/form-data"
                        method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                        <h5 class="col-lg-12 d-block mb-2">{{ __('main.main-information') }}</h5>
                        <hr>
                        <div class="row mb-3">

                            <div class="col-md-4">
                                <label> {{ __('finance.fixed-expense-statement') }} <span
                                        class="text-danger">*</span></label>
                                <input dir="rtl" required class="form-control" name="fixed_expense" type="text">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button class="btn btn-info pd-x-20" type="submit">{{ __('main.add') }}</button>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                    @if (!$fixed_expenses->isEmpty())
                        <hr>
                        <p class="alert alert-sm alert-success text-center">
                            {{ __('sidebar.static-expenses') }}
                        </p>
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered text-center table-hover"
                                id="example-table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center"> بيان المصروف الثابت</th>
                                        <th class="text-center">المسؤول</th>
                                        <th class="text-center">تحكم</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach ($fixed_expenses as $key => $fixed_expense)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $fixed_expense->fixed_expense }}</td>
                                            <td>{{ $fixed_expense->client->name }}</td>
                                            <td>
                                                <a href="{{ route('client.fixed.expenses.edit', $fixed_expense->id) }}"
                                                    class="btn btn-sm btn-info" data-toggle="tooltip" title="تعديل"
                                                    data-placement="top">
                                                    <i class="fa fa-edit"></i> تعديل
                                                </a>

                                                <a class="modal-effect btn btn-sm btn-danger delete_fixed_expense"
                                                    fixed_expense_id="{{ $fixed_expense->id }}"
                                                    fixed_expense="{{ $fixed_expense->fixed_expense }}"
                                                    data-toggle="modal" href="#modaldemo9" title="delete"><i
                                                        class="fa fa-trash"></i> حذف وتراجع </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="modaldemo9">
        <div class="modal-dialog modal-dialog-centered" fixed_expense="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header text-center">
                    <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">حذف مصروف ثابت </h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('client.fixed.expenses.destroy', 'test') }}" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>هل انت متأكد من الحذف ?</p><br>
                        <input type="hidden" name="fixed_expenseid" id="fixed_expenseid">
                        <input class="form-control" name="fixed_expensename" id="fixed_expensename" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">حذف وتراجع</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.delete_fixed_expense').on('click', function() {
            var fixed_expense_id = $(this).attr('fixed_expense_id');
            var fixed_expense_name = $(this).attr('fixed_expense');
            $('.modal-body #fixed_expenseid').val(fixed_expense_id);
            $('.modal-body #fixed_expensename').val(fixed_expense_name);
        });
    });
</script>
