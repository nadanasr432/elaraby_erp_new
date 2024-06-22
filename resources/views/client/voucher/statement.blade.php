@extends('client.layouts.app-main')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header border-bottom border-secondary p-1">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h3 class="pull-right font-weight-bold">كشف الحساب</h3>
                        <a class="btn btn-danger btn-sm pull-left p-1" href="{{ route('client.voucher.get') }}">
                            {{ __('main.back') }}
                        </a>
                    </div>
                </div>
                <div class="card-body p-2">
                    <div class="table-responsive pr-1 pl-1">
                        <table class="table mt-2">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">رقم الحساب</th>
                                    <th scope="col">التاريخ</th>
                                    <th scope="col">بند</th>
                                    <th scope="col">الحساب</th>
                                    <th scope="col">مدين</th>
                                    <th scope="col">دائن</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->accountingTree->id }}</td>
                                        <td>{{ $transaction->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $transaction->voucher->notation }}</td>
                                        <td>{{ $transaction->accountingTree->account_name }}</td>
                                        <td>{{ $transaction->type == 1 ? $transaction->amount : '' }}</td>
                                        <td>{{ $transaction->type == 0 ? $transaction->amount : '' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td style="text-align: start;font-weight: bold">المجموع:</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td style="text-align: center">{{ $totalDebit }}</td>
                                    <td style="text-align: center">{{ $totalCredit }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
