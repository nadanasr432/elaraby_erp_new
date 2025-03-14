@extends('client.layouts.app-main')
<style>
    th, td {
        padding: 6px !important;
    }

    #example-table_wrapper .row:first-child .col-md-6:nth-child(2) {
        text-align: left !important;
    }
</style>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
@section('content')

    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">

                <!-- *****************************Header********************************** -->
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <div class="col-lg-12 margin-tb">
                            <a class="btn pull-left btn-primary btn-sm"
                               target="_blank"
                               href="{{ route('client.pos.sales_products_today') }}">
                                <i class="fa fa-plus"></i>
                                تقرير المنتجات المباعة اليوم
                            </a>

                            <a class="btn pull-left btn-info btn-sm mr-1" id="printProductSales"
                               href="{{ route('pos.printProductSales') }}">
                                <i class="fa fa-print"></i>
                                {{ __('pos.print-invoice') }}
                            </a>

                            <a class="btn pull-left btn-info btn-sm mr-1" id="todayPrintBtn" style="display: none"
                               href="{{ route('pos.sales.report.print-today') }}">
                                <i class="fa fa-print"></i>
                                {{ __('pos.print-invoice') }}
                            </a>

                            <button id="getPosReportsToday"
                                    class="btn pull-left btn-dark btn-sm mr-1">
                                عرض تقرير اليوم
                            </button>

                            <button id="getPosReports" style="display: none;"
                                    class="btn pull-left btn-dark btn-sm mr-1">
                                عرض كل التقارير
                            </button>

                            <button id="getPosReportsWithDates"
                                    class="btn pull-left btn-warning btn-sm mr-1">
                                عرض بالتاريخ
                            </button>

                            <h5 class="pull-right alert alert-sm alert-success">
                                {{ __('sidebar.point-of-sale-reports') }}
                            </h5>

                        </div>
                        <br>
                    </div>
                </div>
                <!-- ********************************************************************* -->


                <!-- **************************Search Form******************************** -->
                <div style="display: none" class="searchFormDates row p-2 pl-3 align-items-end">
                    <div class="col-3 form-groub">
                        <label for=""> من</label>
                        <input type="date" id="dateFrom" class="form-control" placeholder="التاريخ من">
                    </div>
                    <div class="col-3 form-groub">
                        <label for=""> الي</label>
                        <input type="date" id="dateTo" class="form-control" placeholder="التاريخ الي">
                    </div>
                    <div class="col-1 form-groub">
                        <button id="btnSearchPosReports" class="btn btn-success btn-sm">
                            <svg style="width: 20px;fill:white" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 512 512">
                                <path
                                    d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352c79.5 0 144-64.5 144-144s-64.5-144-144-144S64 128.5 64 208s64.5 144 144 144z"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- ********************************************************************* -->


                <!-- ************************mainTable AllReport************************** -->
                <div class="posReportsTodayMain card-body">
                    <div class="table-responsive">
                        <table
                            class="defaultTableMain table table-condensed table-striped table-bordered text-center table-hover"
                            id="example-table">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">المنتج</th>
                                <th class="text-center">عدد مرات البيع</th>
                                <th class="text-center">المبلغ قبل الضريبة</th>
                                <th class="text-center">المبلغ الاجمالي</th>
                                <th class="text-center">الضريبة</th>
                            </tr>
                            </thead>
                            <tbody>
                            @empty($productsSoldToday)
                                <tr>
                                    <th class="text-center" colspan="5" style="text-align: center;background: #f69a9a">
                                        لم يتم بيع اي منتج اليوم حتي الان!
                                    </th>
                                </tr>
                            @else
                                @php $i = 1;@endphp
                                @foreach($productsSoldToday as $row)
                                    <tr>
                                        <th class="text-center">{{$i}}</th>
                                        <th class="text-center">{{$row['name']}}</th>
                                        <th class="text-center">{{$row['count']}}</th>
                                        <th class="text-center">{{$row['priceBeforeTax']}}</th>
                                        <th class="text-center">{{$row['price']}}</th>
                                        <th class="text-center">{{$row['tax']}}</th>
                                    </tr>
                                    @php $i++;@endphp
                                @endforeach
                            @endempty

                            </tbody>
                        </table>
                    </div>


                    <div class="row mb-3 mt-3 text-center justify-content-center">
                        <div class="badge badge-danger mb-1 p-1"
                             style="margin-right: 5px;width: fit-content;font-size: 14px !important;font-weight: bold;">
                            الاجمالي قبل الضريبة :
                            {{round($totalPrice - $totalTax,2)}}
                        </div>
                        <div class="badge badge-primary mb-1 p-1"
                             style="margin-right: 5px;width: fit-content;font-size: 14px !important;font-weight: bold;">
                            الاجمالي شامل الضريبة :
                            {{round($totalPrice,2)}}
                        </div>
                        <div class="badge badge-success mb-1 p-1"
                             style="margin-right: 5px;width: fit-content;font-size: 14px !important;font-weight: bold;">
                            اجمالى الضريبة :
                            {{round($totalTax,2)}}
                        </div>
                    </div>
                </div>
                <!-- ********************************************************************* -->


                <!-- ************************SPINNER************************************** -->
                <div class="spinner-box"
                     style="display:none;background: #2d2d2d14; padding: 31px; text-align: center; border: 1px solid #8080803d;">
                    <div class="spinner-border text-primary" style="width: 50px; height: 50px;" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <span class="ml-2"
                          style="position: relative; top: -13px;font-size: 24px !important; font-weight: bold;">جاري تحميل البيانات...</span>
                </div>
                <!-- ********************************************************************* -->


                <!-- ************************posReportsForToday*************************** -->
                <div style="display: none;" class="posReportsTodayCard card-body">
                    <div class="posReportsForTodayContainer table-responsive">

                    </div>
                </div>
                <!-- ********************************************************************* -->

            </div>
        </div>
    </div>
@endsection
<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function () {
        // $('.spinner-box').show();

        //------show searchFormDates-----//
        $("#getPosReportsWithDates").click(function () {
            $(".searchFormDates").fadeToggle(400);
        });

        //------pos reports for today-----//
        $("#getPosReportsToday").click(function () {
            //-----buttons
            $(this).hide();
            $("#getPosReports").show();

            $('#mainPrintBtn').hide();
            $('#todayPrintBtn').show();
            //---------------------

            $(".posReportsTodayMain").hide();
            $(".posReportsTodayCard").hide();
            $('.spinner-box').show();

            //start ajax...
            $.post("{{route('posTodayReport')}}", function (res) {
                if (res) {
                    setTimeout(function () {
                        $(".posReportsForTodayContainer").html(res);
                        $(".posReportsTodayCard").fadeIn(600);
                        $('.spinner-box').hide();
                    }, 700);
                }
            });
        });

        //------get pos reports between dates-----//
        $("#btnSearchPosReports").click(function () {
            //get form data..
            let dateFrom = $("#dateFrom").val();
            let dateTo = $("#dateTo").val();

            $(".posReportsTodayMain").hide();
            $(".posReportsTodayCard").hide();
            $('.spinner-box').show();

            //start ajax...
            $.post("{{route('posReportsBetweenDates')}}", {dateFrom: dateFrom, dateTo: dateTo}, function (res) {
                if (res) {
                    setTimeout(function () {
                        $(".posReportsForTodayContainer").html(res);
                        $(".posReportsTodayCard").fadeIn(600);
                        $('.spinner-box').hide();
                    }, 700);
                }
            });
        });

        //-------show or view all reports div-----//
        $("#getPosReports").click(function () {
            //buttons
            $(this).hide();
            $("#getPosReportsToday").show();

            $('#mainPrintBtn').show();
            $('#todayPrintBtn').hide();
            //---------------------

            $(".posReportsTodayCard").hide();
            $('.spinner-box').show();

            setTimeout(function () {
                $(".posReportsTodayMain").fadeIn(600);
                $('.spinner-box').hide();
            }, 700);
        });


    });
</script>
