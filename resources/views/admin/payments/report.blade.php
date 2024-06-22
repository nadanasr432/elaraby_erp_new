@extends('admin.layouts.app-main')
<style>

    span.badge {
        font-size: 13px !important;
        padding: 10px !important;
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
                            <h5 class="pull-right alert alert-sm alert-danger"> تقرير المدفوعات </h5>
                        </div>
                        <br>
                    </div>
                </div>
                <div class="card-body">
                    <div class="clearfix"></div>
                    @if(isset($companies))
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered text-center table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">اسم الشركة</th>
                                    <th class="text-center"> المستحق</th>
                                    <th class="text-center"> الدفعات</th>
                                    <th class="text-center"> المتبقى</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $i = 0;
                                $total_deserved = 0;
                                $total_paid = 0;
                                $total_rest = 0;
                                ?>
                                @foreach($companies as $company)
                                    @if(!$company->clients->isEmpty())
                                        <tr>
                                            <td>{{++$i}}</td>
                                            <td>{{ $company->company_name }}</td>
                                            <td>
                                                <?php
                                                echo $deserved = $company->subscription->type->type_price;
                                                $total_deserved = $total_deserved + $deserved;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $payments = $company->payments;
                                                $paid = 0;
                                                foreach ($payments as $payment) {
                                                    $amount = $payment->amount;
                                                    $paid = $paid + $amount;
                                                }
                                                echo $paid;
                                                $total_paid = $total_paid + $paid;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                $rest = $deserved - $paid;
                                                echo $rest;
                                                $total_rest = $total_rest + $rest;
                                                ?>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-2 mb-2">
                            <div class="col-lg-4 pull-right">
                                <div class="bg-danger text-white p-1 m-1">
                                    اجمالى المبالغ المستحقة :
                                    <?php
                                    echo $total_deserved;
                                    ?>
                                </div>
                            </div>
                            <div class="col-lg-4 pull-right">
                                <div class="bg-danger text-white p-1 m-1">
                                    اجمالى المبالغ المدفوعة :
                                    <?php
                                    echo $total_paid;
                                    ?>
                                </div>
                            </div>
                            <div class="col-lg-4 pull-right">
                                <div class="bg-danger text-white p-1 m-1">
                                    اجمالى المبالغ المتبقية :
                                    <?php
                                    echo $total_rest;
                                    ?>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{asset('app-assets/js/jquery.min.js')}}"></script>
<script>
    $(document).ready(function () {

    });
</script>
