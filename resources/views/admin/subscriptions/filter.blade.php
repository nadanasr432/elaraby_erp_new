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
                            <h5 class="pull-right alert alert-sm alert-danger">فلترة الشركات حسب نوع الاشتراك </h5>
                        </div>
                        <br>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('subscriptions.filter.post')}}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="row mt-2 mb-2">
                            <div class="col-lg-4 pull-right">
                                <div class="form-group">
                                    <label class="d-block" for="">
                                        اختر نوع الاشتراك
                                    </label>
                                    <select name="type_id" required class="form-control" id="">
                                        <option value="">اختر نوع الاشتراك</option>
                                        @foreach($types as $type)
                                            <option value="{{$type->id}}">{{$type->type_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 pull-right">
                                <button style="margin-top: 25px;" type="submit" class="btn btn-md btn-danger">
                                    <i class="fa fa-check"></i>
                                    عرض الشركات
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                    <hr/>
                    @if(isset($subscriptions))
                        @if(!$subscriptions->isEmpty())
                            <div class="table-responsive">
                                <table
                                    class="table table-condensed table-striped table-bordered text-center table-hover">
                                    <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">اسم الشركة</th>
                                        <th class="text-center">نوع الاشتراك</th>
                                        <th class="text-center">فترة الاشتراك بالايام</th>
                                        <th style="width: 15% !important;" class="text-center">البداية</th>
                                        <th style="width: 15% !important;" class="text-center">النهاية</th>
                                        <th class="text-center">حالة</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $i=0;
                                    @endphp
                                    @foreach ($subscriptions as $key => $subscription)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $subscription->company->company_name }}</td>
                                            <td>{{ $subscription->type->type_name }}</td>
                                            <td>{{ $subscription->type->period }}</td>
                                            <td>{{ $subscription->start_date }}</td>
                                            <td>{{ $subscription->end_date }}</td>
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
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-4 pull-right bg-danger text-white p-1 m-1">
                                عدد الشركات :
                                {{$i}}
                            </div>
                        @else
                            <p class="alert alert-sm alert-danger text-center">
                                لا يوجد شركات لهذا النوع من الاشتراكات
                            </p>
                        @endif
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
