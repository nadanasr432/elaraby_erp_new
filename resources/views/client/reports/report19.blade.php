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
    @if (session('error'))
        <div class="alert alert-danger alert-dismissable fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            {{ session('error') }}
        </div>
    @endif
    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <div class="col-lg-12 margin-tb">
                            <h5 class="pull-right alert alert-sm alert-success"> تقرير حركة منتج </h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="company_details printy" style="display: none;">
                        <div class="text-center">
                            <img class="logo" style="width: 20%;" src="{{asset($company->company_logo)}}" alt="">
                        </div>
                        <div class="text-center">
                            <div class="col-lg-12 text-center justify-content-center">
                                <p class="alert alert-secondary text-center alert-sm"
                                   style="margin: 10px auto; font-size: 17px;line-height: 1.9;" dir="rtl">
                                    {{$company->company_name}} -- {{$company->business_field}} <br>
                                    {{$company->company_owner}} -- {{$company->phone_number}} <br>
                                </p>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <form action="{{route('client.report19.post')}}" class="no-print" method="POST">
                        @csrf
                        @method('POST')
                        <div class="col-lg-3 pull-right no-print">
                            <label for="" class="d-block">اسم المنتج </label>
                            <select required name="product_id" id="product_id" class="selectpicker"
                                    data-style="btn-warning" data-live-search="true" title="اكتب او اختار اسم المنتج">
                                @foreach($products as $product)
                                    <option
                                        @if(isset($product_id) && $product->id == $product_id)
                                        selected
                                        @endif
                                        value="{{$product->id}}">{{$product->product_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 pull-right no-print">
                            <label for="" class="d-block">من تاريخ</label>
                            <input type="date" @if(isset($from_date) && !empty($from_date)) value="{{$from_date}}"
                                   @endif class="form-control" name="from_date"/>
                        </div>
                        <div class="col-lg-3 pull-right no-print">
                            <label for="" class="d-block">الى تاريخ</label>
                            <input type="date" @if(isset($to_date) && !empty($to_date)) value="{{$to_date}}"
                                   @endif  class="form-control" name="to_date"/>
                        </div>
                        <div class="col-lg-3 pull-right">
                            <button class="btn btn-md btn-danger"
                                    style="font-size: 15px; height: 40px; margin-top: 25px;" type="submit">
                                <i class="fa fa-check"></i>
                                عرض التقرير
                            </button>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                    @if(isset($product_k) && !empty($product_k))
                        <p class="alert alert-sm alert-danger mt-2 mb-2 text-center">
                            تقرير حركة منتج
                        </p>
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-bordered text-center table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">اسم المنتج</th>
                                    <th class="text-center"> الكود</th>
                                    <th class="text-center"> سعر شراء المنتج</th>
                                    <th class="text-center"> مشتريات المنتج</th>
                                    <th class="text-center"> مبيعات المنتج</th>
                                    <th class="text-center"> رصيد المخازن الحالى من المنتج </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ $product_k->product_name }}</td>
                                    <td>{{ $product_k->code_universal }}</td>
                                    <td>{{floatval( $product_k->purchasing_price  )}}</td>
                                    <td>{{floatval( $total_buy_elements  )}}</td>
                                    <td>{{floatval( $total_sold  )}}</td>
                                    <td>{{floatval( $product_k->first_balance  )}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-3">
                            <span class="col-lg-4 col-sm-12 alert alert-secondary alert-sm mr-5">
                                 اجمالى التكلفة لهذا المنتج
                                ( {{floatval( $product_k->first_balance*$product_k->purchasing_price  ) }} )
                            </span>
                            <span class="col-lg-4 col-sm-12 alert alert-secondary alert-sm mr-5">
                                 رصيد المخازن الحالى من كل المنتجات
                                <?php
                                $sum = 0;
                                foreach ($products as $product){
                                    $sum += $product->first_balance;
                                }
                                echo floatval($sum);
                                ?>
                            </span>
                        </div>
                    @endif
                    <div class="clearfix"></div>
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
