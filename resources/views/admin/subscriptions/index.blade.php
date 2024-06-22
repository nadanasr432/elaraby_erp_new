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
                            <h5 class="pull-right alert alert-sm alert-danger">عرض كل الاشتراكات </h5>
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
                                <th class="text-center">اسم الشركة</th>
                                <th class="text-center">نوع الاشتراك</th>
                                <th class="text-center">فترة الاشتراك بالايام</th>
                                <th style="width: 15% !important;" class="text-center">البداية</th>
                                <th style="width: 15% !important;" class="text-center">النهاية</th>
                                <th class="text-center">حالة</th>
                                <th class="text-center">تعديل</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i=0;
                            @endphp
                            @foreach ($subscriptions as $key => $subscription)
                                   @if(!empty($subscription) && !empty($subscription->company) && !empty($subscription->company->clients) && !$subscription->company->clients->isEmpty())
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $subscription->company->company_name ?? '' }}</td>
                                        <td>{{ $subscription->type->type_name ?? '' }}</td>
                                        <td>{{ $subscription->type->period  ?? ''}}</td>
                                        <td>{{ $subscription->start_date  ?? ''}}</td>
                                        <td>{{ $subscription->end_date  ?? ''}}</td>
                                        <td>
                                            @if ($subscription->status == 'active')
                                                <span class="badge badge-success">
                                                    مفعل
                                                </span>
                                            @elseif ($subscription->status == 'blocked')
                                                <span class="badge badge-danger">
                                                    معطل
                                                </span>
                                            @endif
                                        </td>
                                      <!--<td>Company ID: {{ $subscription->company->id }}</td>-->
                                        @if($subscription->company->id == 29)
                                            <td>غير مسموح</td>
                                        @else
                                            <td>
                                                <a href="{{ route('admin.subscriptions.edit', $subscription->id) }}"
                                                   class="btn btn-sm btn-info" data-toggle="tooltip"
                                                   title="تعديل" data-placement="top"><i class="fa fa-edit"></i></a>
                                            </td>
                                        @endif
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
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
