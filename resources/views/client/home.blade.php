@extends('client.layouts.app-main')
<style>
    .mobilePOSBtn {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        border: 3px dashed white;
        color: white;
        font-weight: bold;
        position: fixed;
        z-index: 99999999999999999999;
        display: block;
        left: 23px;
        bottom: 40px;
        background-color: #28d094;
    }
    .mobilePOSBtn2 {

        background: white;  border: 1px dashed #449f2d; padding: 1px 5px 11px 7px !important; border-radius: 31px;
        font-weight: bold;
        position: fixed;
        z-index: 99999999999999999999;
        display: block;
        left: 340px;
        bottom: 70px;

    }

    @media screen and (max-width: 650px) {
        .mobilePOSBtn {
            display: block !important;
        }
        .mobilePOSBtn2 {
            display: block !important;
        }
    }

    .client-border-paid {
        border-right: 3px solid #089d44;
        border-radius: 0 !important;
        padding-right: 4px;
    }

    .client-border-notpaid {
        border-right: 3px solid #e55757;
        border-radius: 0 !important;
        padding-right: 4px;
    }

    .count {
        font-size: 16px !important;
        font-weight: bold;
        line-height: 1.2;
        margin-top: 9px !important;
    }

    .boxShadow {
        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
    }

    .form-control {
        height: 37px !important;
        padding: 10px !important;
    }

    .tile_stats_count {
        box-shadow: rgb(50 50 93 / 25%) -1px -7px 34px -19px, rgb(0 0 0 / 30%) 0px 18px 36px -18px;
        background: white;
        color: gray;
        min-height: 86px !important;
        border-radius: 7px;
        overflow: hidden !important;
        padding: 8px 13px 2px 1px !important;
        transition: all 0.2s ease-in-out;
        cursor: pointer;
    }

    .tile_stats_count:hover {
        transform: scale(1.07) !important;
        background: #222751;
        min-height: 86px !important;
    }

    .tile_stats_count:hover .col-9 span {
        color: white !important;
    }

    .tile_stats_count.active {
        background: #222751;
        color: white;
        min-height: 86px !important;
    }

    .tile_stats_count.col-9 {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding-top: 10px;
    }

    .col-9.count {
        padding-right: 6px;
    }

    .verticalCenter {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    div.shortcut {
        width: 100%;
        color: #40485b;
        height: auto;
        background: #fff;
        padding: 10px;
        margin-top: 5px;
        border-bottom: 1px solid #ccc;
        transition: 0.5s;
        padding-bottom: 15px;
        font-size: 15px !important;
        display: flex;
        align-items: center;
    }

    div.shortcut svg {
        width: 18px !important;
        fill: #6571ff;
        margin-left: 10px;
    }

    a div.shortcut {
        font-size: 12px;
        color: #40485b;
    }

    a div.shortcut i {
        font-size: 40px;
        color: #40485b;
        margin-bottom: 5px
    }

    div.shortcut:hover {
        background: #e0e0e0;
    }

    .count {
        margin-top: 20px;
    }

    a:hover div.shortcut {
        color: #fff !important;
    }

    a:hover div.shortcut i {
        color: #fff !important;
    }

    div.chart_2 div.shortcuts {
        height: auto !important;
    }

    .reports hr {
        margin: 15px
    }

    ul.list-unstyled li {
        margin-top: 25px;
        text-align: center;
        background: #eee;
        padding: 20px
    }

    ul.list-unstyled li a {
        font-size: 13px;
        padding: 5px;
        transition: 0.3s
    }

    ul.list-unstyled li a:hover {
        background: #40485b;
        color: #fff;
    }

    .first_div {
        margin-bottom: 20px;
    }

    .btn-common {
        background-color: #e91e63;
        position: relative;
        color: #fff;
        z-index: 1;
        border-radius: 4px;
        transition: all .2s ease-in-out;
        -moz-transition: all .2s ease-in-out;
        -webkit-transition: all .2s ease-in-out;
    }

    ul.points {
        list-style: none !important;
        color: #000 !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    ul.points li {
        font-size: 14px !important;
        text-align: right !important;
    }

    ul.points li span {
        font-size: 14px !important;
        text-align: right !important;
    }

    .btn-common:hover {
        color: #fff;
    }

    .col-lg-12 a {
        border-radius: 30px !important;
    }

    .row.mt-1,
    .newCardDesign {
        background: white;
        border: 1px solid #2f2f2f2f;
        border-radius: 10px;
        overflow: hidden !important;
        padding: 20px 10px 10px;
        box-shadow: rgb(149 157 165 / 20%) 0px 8px 24px;
    }

    .newCardDesign .topParagraph {
        font-size: 20px !important;
        background: #6571ff;
        padding: 15px;
        color: white;
        margin: 0;
    }


    .btn-success {
        border-color: #1EC481 !important;
        background-color: #28D094 !important;
        color: #FFFFFF;
        transition: all 0.2s ease-in-out !important;
    }

    .btn-success:hover {
        border-color: #1EC481 !important;
        color: #1EC481;
        transform: scale(1.05);
        background: white !important;
    }

    .count_top {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px !important;
        padding: 0 !important;
    }

    .tile_stats_count i {
        font-size: 25px !important;
    }

    .count div span {
        font-size: 12px !important;
    }

    .count_bottom {
        top: 20px !important;
        position: relative;

        background: white;
        color: #000;
        padding: 2px 15px;
        border-radius: 30px;
        font-size: 11px !important;
    }

    #recent-orders th, #recent-orders td, #transactions th, #transactions td {
        padding: 11px !important;
        text-align: center;
        border: none !important;
        color: dimgray !important;
    }

    #recent-orders tr, #transactions tr {
        border-top: 1px solid #2d2d2d20;
    }

    #recent-orders thead tr th, #transactions thead tr th {
        border-top: 1px solid #2d2d2d20 !important;
        background: #222751 !important;
        color: white !important;
    }

    .client_statistic {
        border-bottom: 1px solid rgba(45, 45, 45, 0.06) !important;
        padding-bottom: 11px !important;
        border-radius: 0 !important;
    }

    .homeBoxs {
        padding: 4px !important;
    }

    .scsss {
        background-color: #28d09424 !important;
        color: #089D44 !important;
    }

    .errr {
        color: #FF4961 !important;
        background: #ff496121 !important;
    }

    .styled-card {
    }
</style>
@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success alert-dismissable text-center fade show">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger text-center">
            <button class="close" data-dismiss="alert" aria-label="Close">×</button>
            <span>{{ session('error') }}</span>
        </div>
    @endif
    <?php $uncompleted = 0; ?>

    <div class="row ComeletionProcessDiv " style="display: none;">
        <div class="col-lg-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="col-lg-6 pull-right text-right p-0 m-0">
                        <ul class="points">
                            <li>
                                <a href="{{ route('client.basic.settings.edit') }}">
                                    <?php
                                    if ($company->company_name == "") {
                                    $uncompleted++;
                                    echo "<span class='text-danger'>
                                              <i class='fa fa-close'></i>";
                                    ?>
                                    {{ __('home.register-company-name') }}
                                    <?php
                                    echo "</span>";
                                    } else {
                                    echo "<span class='text-success'>
                                              <i class='fa fa-check'></i>";
                                    ?>
                                    {{ __('home.register-company-name') }}
                                    <?php
                                    echo "</span>";
                                    }
                                    ?>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('client.basic.settings.edit') }}">
                                    @if ($company->company_owner == '')
                                        <?php $uncompleted++; ?>
                                        <span class='text-danger'>
                                            <i class='fa fa-close'></i>{{ __('home.register-company-manager') }}</span>
                                    @else
                                        <span class='text-success'><i
                                                class='fa fa-check'></i>{{ __('home.register-company-manager') }}</span>
                                    @endif

                                </a>
                            </li>
                            <li>
                                <a href="{{ route('client.basic.settings.edit') }}">
                                    @if ($company->business_field == '')
                                        <?php $uncompleted++; ?>
                                        <span class='text-danger'>
                                            <i class='fa fa-close'></i>{{ __('home.register-company-type') }}</span>
                                    @else
                                        <span class='text-success'>
                                            <i class='fa fa-check'></i>{{ __('home.register-company-type') }}</span>
                                    @endif
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('client.basic.settings.edit') }}">
                                    @if ($company->phone_number == '')
                                        <?php $uncompleted++; ?>
                                        <span class='text-danger'>
                                            <i class='fa fa-close'></i>{{ __('home.register-company-phone') }}</span>
                                    @else
                                        <span class='text-success'>
                                            <i class='fa fa-check'></i>{{ __('home.register-company-phone') }}</span>
                                @endif
                            </li>
                            <li>
                                <a href="{{ route('client.basic.settings.edit') }}">
                                    @if ($company->company_logo == '')
                                        <?php $uncompleted++; ?>
                                        <span class='text-danger'>
                                            <i class='fa fa-close'></i>{{ __('home.register-company-logo') }}</span>
                                    @else
                                        <span class='text-success'>
                                            <i class='fa fa-check'></i>{{ __('home.register-company-logo') }}</span>
                                    @endif
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('client.basic.settings.edit') }}">
                                    @if ($company->company_address == '')
                                        <?php $uncompleted++; ?>
                                        <span class='text-danger'>
                                            <i class='fa fa-close'></i>{{ __('home.register-company-address') }}</span>
                                    @else
                                        <span class='text-success'>
                                            <i class='fa fa-check'></i>{{ __('home.register-company-address') }}</span>
                                    @endif
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('client.billing.settings.edit') }}">
                                    @if ($company->tax_number == '')
                                        <?php $uncompleted++; ?>
                                        <span class='text-danger'>
                                            <i
                                                class='fa fa-close'></i>{{ __('home.register-company-tax-number') }}</span>
                                    @else
                                        <span class='text-success'>
                                            <i
                                                class='fa fa-check'></i>{{ __('home.register-company-tax-number') }}</span>
                                    @endif
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('client.billing.settings.edit') }}">
                                    @if ($company->civil_registration_number == '')
                                        <?php $uncompleted++; ?>
                                        <span class='text-danger'>
                                            <i
                                                class='fa fa-close'></i>{{ __('home.register-company-civil-registry') }}</span>
                                    @else
                                        <span class='text-success'>
                                            <i
                                                class='fa fa-check'></i>{{ __('home.register-company-civil-registry') }}</span>
                                    @endif
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('client.billing.settings.edit') }}">
                                    @if ($company->tax_value_added == '')
                                        <?php $uncompleted++; ?>
                                        <span class='text-danger'>
                                            <i class='fa fa-close'></i>{{ __('home.register-value-added-tax') }}</span>
                                    @else
                                        <span class='text-success'>
                                            <i class='fa fa-check'></i>{{ __('home.register-value-added-tax') }}</span>
                                    @endif
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('client.billing.settings.edit') }}">
                                    @if ($company->taxes->isEmpty())
                                        <?php $uncompleted++; ?>
                                        <span class='text-danger'>
                                            <i
                                                class='fa fa-close'></i>{{ __('home.register-tax-rates-in-invoices') }}</span>
                                    @else
                                        <span class='text-success'>
                                            <i
                                                class='fa fa-check'></i>{{ __('home.register-tax-rates-in-invoices') }}</span>
                                    @endif
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-6 pull-left text-center justify-content-center">
                        <h3 style="font-size: 17px!important;color: #fff!important;"
                            class="alert alert-md btn-common text-center">
                            {{ __('home.company-profile-completion-rate') }}
                        </h3>
                        <?php
                        $completed = 10 - $uncompleted;
                        $percentage = ($completed / 10) * 100;
                        ?>
                        <input type="hidden" id="compeletionProcess" value="{{$percentage}}">
                        <div class="progress-pie-chart" data-percent="{{ $percentage }}">
                            <div class="ppc-progress">
                                <div class="ppc-progress-fill"></div>
                            </div>
                            <div class="ppc-percents">
                                <div class="pcc-percents-wrapper">
                                    <span>%</span>
                                </div>
                            </div>
                        </div>
                        @if ($percentage != 100)
                            <a href="{{ route('client.basic.settings.edit') }}" class="btn btn-md btn-common mt-2">
                                <i class="fa fa-plus"></i>
                                {{ __('home.complete-the-company-information') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!----row1---->
    <div class="card-header border-bottom border-secondary p-1">
        <div class="d-flex justify-content-between align-items-baseline flex-wrap">
            <h3 class="pull-right font-weight-bold">

                @if(session()->get('locale') == 'ar')
                    <span style="font-size: 16px !important;">{{__('main.dashboard')}}</span>
                    <<
                    <span style="color:#542472;font-size: 17px;">{{__('main.main')}}</span>
                @else
                    <span style="color:#542472;font-size: 17px;">{{__('main.main')}}</span>
                    <<
                    <span style="font-size: 16px !important;">{{__('main.dashboard')}}</span>
                @endif
            </h3>
            <div class="row pr-2 mt-sm-0 mt-2 pl-sm-0 pl-2">
                <a class="btn btn-danger border-0" style="background: #222751 !important;border-radius: 7px;"
                   href="{{ route('client.sale_bills.create') }}">
                    <img src="{{asset('assets/svgs/plus.svg')}}"
                         style="border: 1px dashed; border-radius: 50%; margin-left: 6px;">

                    {{__('main.add-sale-bill')}}
                </a>
                <a class="btn bg-none border-0 ml-1"
                   style="    background: white !important;color: gray;border: 1px solid gray !important;border-radius: 7px;"
                   href="{{ route('client.sale_bills.index') }}">
                    <img src="{{asset('assets/svgs/paper.svg')}}">
                    {{__('main.mnge-bills')}}
                </a>
            </div>
        </div>
    </div>
    <!------------>

    <!----row2---->
    <div class="row mb-1">
        <div class="col-lg-12">
            @if (empty($package) || $package->products == '1')
                @if ($all_products->isEmpty())
                    @can('اضافة منتج جديد')
                        <div class="col-lg-3 pull-right">
                            <a href="{{ route('client.products.create') }}" class="btn btn-md btn-common btn-block">
                                <i class="fa fa-plus"></i>
                                {{ __('home.add-first-product') }}
                            </a>
                        </div>
                    @endcan
                @endif
            @endif
            @if (empty($package) || $package->debt == '1')
                @if ($all_outer_clients->isEmpty())
                    @can('اضافة عميل جديد')
                        <div class="col-lg-3 pull-right">
                            <a href="{{ route('client.outer_clients.create') }}"
                               class="btn btn-md btn-common btn-block">
                                <i class="fa fa-plus"></i>
                                {{ __('home.add-first-customer') }}
                            </a>
                        </div>
                    @endcan
                @endif
            @endif
            @if (empty($package) || $package->debt == '1')
                @if ($all_suppliers->isEmpty())
                    @can('اضافة مورد جديد')
                        <div class="col-lg-3 pull-right">
                            <a href="{{ route('client.suppliers.create') }}" class="btn btn-md btn-common btn-block">
                                <i class="fa fa-plus"></i>
                                {{ __('home.add-first-supplier') }}
                            </a>
                        </div>
                    @endcan
                @endif
            @endif
            @if ($pos_settings->status == 'closed')
                @if ($pos_status != 'none')
                    <div class="col-lg-3 pull-right">
                        <a data-toggle="modal" href="#modaldemo30" class="btn btn-md btn-success btn-block">
                            <i class="fa fa-check"></i>
                            {{ __('home.daily-opening-opening-point-of-sale)') }}
                        </a>
                    </div>
                @endif
            @endif
        </div>
    </div>
    <!------------>

    <div class="modal" id="modaldemo30">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header text-center">
                    <h6 class="modal-title w-100" style="font-family: 'Cairo'; ">
                        {{ __('home.daily-opening-opening-point-of-sale)') }}
                    </h6>
                    <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('pos.open.open') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <p>{{ __('home.are-you-sure-you-want-to-open-the-point-of-sale') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{ __('main.cancel') }}</button>
                        <button type="submit" class="btn btn-success">
                            {{ __('home.open-daily') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <button class="btn btn-sm btn-danger pb-1 d-none" id="toggleProfileCompany">
        بروفايل الشركة
        <svg style="width: 20px;fill:white;position: relative;top: 5px;margin-right: 5px;"
             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
            <path
                d="M160 256C160 185.3 217.3 128 288 128C358.7 128 416 185.3 416 256C416 326.7 358.7 384 288 384C217.3 384 160 326.7 160 256zM288 336C332.2 336 368 300.2 368 256C368 211.8 332.2 176 288 176C287.3 176 286.7 176 285.1 176C287.3 181.1 288 186.5 288 192C288 227.3 259.3 256 224 256C218.5 256 213.1 255.3 208 253.1C208 254.7 208 255.3 208 255.1C208 300.2 243.8 336 288 336L288 336zM95.42 112.6C142.5 68.84 207.2 32 288 32C368.8 32 433.5 68.84 480.6 112.6C527.4 156 558.7 207.1 573.5 243.7C576.8 251.6 576.8 260.4 573.5 268.3C558.7 304 527.4 355.1 480.6 399.4C433.5 443.2 368.8 480 288 480C207.2 480 142.5 443.2 95.42 399.4C48.62 355.1 17.34 304 2.461 268.3C-.8205 260.4-.8205 251.6 2.461 243.7C17.34 207.1 48.62 156 95.42 112.6V112.6zM288 80C222.8 80 169.2 109.6 128.1 147.7C89.6 183.5 63.02 225.1 49.44 256C63.02 286 89.6 328.5 128.1 364.3C169.2 402.4 222.8 432 288 432C353.2 432 406.8 402.4 447.9 364.3C486.4 328.5 512.1 286 526.6 256C512.1 225.1 486.4 183.5 447.9 147.7C406.8 109.6 353.2 80 288 80V80z"/>
        </svg>
    </button>




    <!----dashboard-content---->
    <div class="dashboard-content mt-2" style="display: none;">

        <!--------------------------8 boxes---------------------------->
        <div class="row tile_count text-center px-1">


            @if (empty($package) || $package->banks_safes == '1')
                <div class="col-md-2 col-6 homeBoxs">
                    <div class="tile_stats_count active d-flex">
                        <div class="col-3 verticalCenter">
                            <span style="background: #383d62; padding: 9px; border-radius: 50%;">
                                <img src="{{asset('assets/svgs/money.svg')}}" alt="">
                            </span>
                        </div>
                        <div class="col-9 count text-center pr-0">
                            @if (in_array('مدير النظام', Auth::user()->role_name))
                                <span
                                    style="font-size: 14px !important; margin-bottom: 8px !important; display: block;">{{ round($safes_balances,2) }}</span>
                            @else
                                *****
                            @endif
                            <span class="count_top">
                                {{ __('home.total-storage') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-2 col-6 homeBoxs">
                    <div class="tile_stats_count d-flex">
                        <div class="col-3 verticalCenter">
                            <span style="background: #f3f0ff; padding: 9px; border-radius: 50%;">
                                <img src="{{asset('assets/svgs/bank.svg')}}" alt="">
                            </span>
                        </div>
                        <div class="col-9 count text-center pr-0">
                            @if (in_array('مدير النظام', Auth::user()->role_name))
                                <span
                                    style="color: #030229;font-size: 20px;font-weight: 600;margin-bottom: 8px !important; display: block;">{{ round($banks_balances,2) }}</span>
                            @else
                                ***********
                            @endif
                            <span class="count_top"
                                  style="color: #030229;font-size: 15px;font-weight: 500;margin-bottom: 8px !important; display: block;">
                            {{ __('home.total-banks') }}
                            </span>
                        </div>
                    </div>
                </div>
            @endif


            @if (empty($package) || $package->products == '1')
                <div class="col-md-2 col-6 homeBoxs">
                    <div class="tile_stats_count d-flex">
                        <div class="col-3 verticalCenter">
                            <span style="background: #f3f0ff; padding: 9px; border-radius: 50%;">
                                <img src="{{asset('assets/svgs/coins.svg')}}" alt="">
                            </span>
                        </div>
                        <div class="col-9 count text-center pr-0">
                            @if (in_array('مدير النظام', Auth::user()->role_name))
                                <span
                                    style="color: #030229;font-size: 20px;font-weight: 600;margin-bottom: 8px !important; display: block;">{{ round($total_purchase_prices,2) }}</span>
                            @else
                                *****
                            @endif
                            <span class="count_top"
                                  style="color: #030229;font-size: 15px;font-weight: 500;margin-bottom: 8px !important; display: block;">
                                    {{ __('home.the-total-value-of-the-merchandise-in-stock') }}
                                </span>
                        </div>
                    </div>
                </div>
            @endif



            @if (empty($package) || $package->debt == '1')

                <div class="col-md-2 col-6 homeBoxs">
                    <div class="tile_stats_count d-flex">
                        <div class="col-3 verticalCenter">
                            <span style="background: #f3f0ff; padding: 9px; border-radius: 50%;">
                                <img src="{{asset('assets/svgs/fluent_people.svg')}}" alt="">
                            </span>
                        </div>
                        <div class="col-9 count text-center pr-0">
                            @if (in_array('مدير النظام', Auth::user()->role_name))
                                <span
                                    style="color: #030229;font-size: 20px;font-weight: 600;margin-bottom: 8px !important; display: block;">{{ round($total_clients_balances ,2) }}</span>
                            @else
                                *****
                            @endif
                            <span class="count_top"
                                  style="color: #030229;font-size: 15px;font-weight: 500;margin-bottom: 8px !important; display: block;">
                                {{__('clients.total-clients-indebtedness')}}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-2 col-6 homeBoxs">
                    <div class="tile_stats_count d-flex">
                        <div class="col-3 verticalCenter">
                            <span style="background: #f3f0ff; padding: 9px; border-radius: 50%;">
                                <img src="{{asset('assets/svgs/55.svg')}}" alt="">
                            </span>
                        </div>
                        <div class="col-9 count text-center pr-0">
                            @if (in_array('مدير النظام', Auth::user()->role_name))
                                <span
                                    style="color: #030229;font-size: 20px;font-weight: 600;margin-bottom: 8px !important; display: block;">{{ round($total_suppliers_balances,2) }}</span>
                            @else
                                *****
                            @endif
                            <span class="count_top"
                                  style="color: #030229;font-size: 15px;font-weight: 500;margin-bottom: 8px !important; display: block;">
                                {{ __('home.egmaly-elrased') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-2 col-6 homeBoxs">
                    <div class="tile_stats_count d-flex">
                        <div class="col-3 verticalCenter">
                            <span style="background: #f3f0ff; padding: 9px; border-radius: 50%;">
                                <img src="{{asset('assets/svgs/66.svg')}}" alt="">
                            </span>
                        </div>
                        <div class="col-9 count text-center pr-0">
                            @if (in_array('مدير النظام', Auth::user()->role_name))
                                <span
                                    style="color: #030229;font-size: 20px;font-weight: 600;margin-bottom: 8px !important; display: block;">{{ round($total_suppliers_balances,2) }}</span>
                            @else
                                *****
                            @endif
                            <span class="count_top"
                                  style="color: #030229;font-size: 15px;font-weight: 500;margin-bottom: 8px !important; display: block;">
                                {{ __('home.total-customer-debts') }}
                            </span>
                        </div>
                    </div>
                </div>

            @endif

        </div>
        <!------------------------------------------------------------------->

        <!----------------------------Center Row----------------------------->
        <div class="row match-height p-1 mt-1">
            <div class="col-md-8 px-0">
                <div class="card" style="height: 460px;border: 1px solid #2d2d2d30;">
                    <div class="card-header p-1" style="background: #222751;">
                        <h4 class="card-title text-left" style="font-weight: 600;color:white;">

                            {{__('main.income-expenses-jan')}}
                        </h4>
                    </div>
                    <div class="card-content">
                        <div id="container" style="min-width: 310px; height: 372px; margin: 0 auto"></div>
                    </div>

                </div>
            </div>
            <div class="col-md-4 pr-0 pl-sm-1 pl-0">
                <div class="card styled-card" style="border: 1px solid #2d2d2d30;">
                    <div class="card-header p-1" style="background: #222751;">
                        <h4 class="card-title" style="font-weight: 600;color:white;">
                            {{__('main.latest-customers')}}
                        </h4>
                    </div>
                    <div class="card-content px-1">
                        <div id="recent-buyers" class=" mt-1 position-relative">
                            @foreach($all_outer_clients as $client)
                                <a target="_blank" href="{{route('client.outer_clients.edit', $client->id)}}"
                                   class="media client_statistic mt-1" style="border-radius: 0 !important;">
                                    <div class="media-left pr-1">
                                        <span
                                            class="avatar avatar-md avatar-online
                                            @if($client->prev_balance > 0) client-border-paid @else client-border-notpaid @endif">

                                            <img class="media-object rounded-circle"
                                                 src="{{asset('assets/images/mty-client.png')}}">
                                            <i></i>
                                        </span>
                                    </div>
                                    <div class="media-body w-100">
                                        <h6 class="list-group-item-heading font-medium-2">{{$client->client_name}}
                                            <span
                                                class="float-right badge @if($client->prev_balance > 0) badge-success scsss @else badge-danger errr @endif"
                                                style="border-radius: 30px;font-size: 10px !important;font-weight: 500;padding: 9px 14px;">
                                            @if($client->prev_balance > 0) {{__('main.t-paid')}} @else {{__('main.notpaid')}} @endif
                                        </span>
                                        </h6>
                                        <p class="list-group-item-text mb-0">
                                            <span class="float-left"
                                                  style="color: #B5B5C3; font-size: 16px; font-weight: 500;">
                                                المبلغ المدفوع:
                                                {{abs($client->prev_balance)}}
                                            </span>
                                        </p>
                                    </div>
                                </a>
                            @endforeach


                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
        <!------------------------------------------------------------------->

        <!--------------------------8 boxes---------------------------------->
        <div class="row text-center mb-2" style="margin-top: -26px !important;">
            <div class="col-lg-12">
                <div class="card-header p-1" style="background: #f4f5fa;">
                    <h3 class="card-title text-left" style="font-weight: 600;">{{__('main.latest-transactions')}}</h3>
                </div>
                <div class="card" style="height: fit-content !important;border: 1px solid #2d2d2d30;">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="transactions" class="table table-hover mb-1"
                                   style="border-radius: 9px !important; overflow: hidden;">
                                <thead>
                                <tr>
                                    <th class="text-center">{{__('main.rkm-fat')}}</th>
                                    <th class="text-center">{{__('main.date')}}</th>
                                    <th class="text-center">{{__('main.client')}}</th>
                                    <th class="text-center">{{__('main.price')}}</th>
                                    <th class="text-center">{{__('main.pmethod')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($cashs) && !$cashs->isEmpty())
                                    @php
                                        $i=0;
                                    @endphp
                                    @foreach ($cashs as $key => $cash)
                                        <tr>
                                            <td style="color: #47427C !important; font-size: 18px; font-family: Cairo; font-weight: 600;">{{ $cash->bill_id }}</td>
                                            <td style="color: #637381 !important; font-size: 18px; font-family: Cairo; font-weight: 600;">{{ $cash->date }}</td>
                                            <td style="color: #637381 !important; font-size: 18px; font-family: Cairo; font-weight: 600;">{{ $cash->outerClient ? $cash->outerClient->client_name : 'نقدا'}}</td>
                                            <td style="color: #637381 !important; font-size: 18px; font-family: Cairo; font-weight: 600;">{{round($cash->amount,2)}}</td>
                                            <td style="color: #637381 !important; font-size: 18px; font-family: Cairo; font-weight: 600;">{{ $cash->safe->safe_name }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-truncate" colspan="5" style="background: #ff000021;">
                                            <span>لم يتم اضافة فواتير بيع حتي الان</span>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!------------------------------------------------------------------->

        <!----------------------------LAST INVOICES-------------------------->
        <div class="row match-height" style="margin-top: -20px !important;">
            <div class="col-md-12 ">
                <div class="card-header p-1" style="background: #f4f5fa;">
                    <h3 class="card-title text-left" style="font-weight: 600;">{{__('main.latest-bills')}}</h3>
                    <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="table-responsive">
                            <table id="recent-orders" class="table mb-1"
                                   style="border-radius: 9px !important; overflow: hidden;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{__('main.client')}}</th>
                                    <th>{{__('main.status')}}</th>
                                    <th>{{__('main.date')}}</th>
                                    <th>{{__('main.total')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($sale_bills && count($sale_bills) != 0)
                                    @foreach($sale_bills as $invoice)
                                        <tr>
                                            <td class="text-truncate">
                                                <a target="_blank"
                                                   style="color: #47427C !important; font-size: 18px; font-family: Cairo; font-weight: 600;"
                                                   href="{{route('client.sale_bills.print', $invoice->token)}}">{{$invoice->sale_bill_number}}</a>
                                            </td>

                                            <td class="text-truncate"
                                                style="color: #637381 !important; font-size: 18px; font-family: Cairo; font-weight: 600;">{{$invoice->outerClient ? $invoice->outerClient->client_name : 'بيع نقدي'}}</td>
                                            <td class="text-truncate">
                                            <span
                                                class="badge p-1 font-weight-bold @if($invoice->rest == 0) badge-success scsss @else badge-danger errr @endif"
                                                style="font-size: 10px !important; border-radius: 30px;">
                                                @if($invoice->rest == 0) {{__('main.t-paid')}} @else {{__('main.notpaid')}} @endif
                                            </span></td>
                                            <td class="text-truncate"
                                                style="color: #637381 !important; font-size: 18px; font-family: Cairo; font-weight: 600;">{{$invoice->date}}</td>
                                            <td class="text-truncate"
                                                style="color: #637381 !important; font-size: 18px; font-family: Cairo; font-weight: 600;">{{$invoice->final_total}} {{$company->currency}}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-truncate" colspan="5" style="background: #ff000021;">
                                            <span>لم يتم اضافة فواتير بيع حتي الان</span>
                                        </td>
                                    </tr>
                                @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!------------------------------------------------------------------->

    </div>
    <!------------>

    <a href="{{route("client.pos.create")}}" class="mobilePOSBtn" style="display: none;">
        <svg width="30" viewBox="0 0 26 25" fill="white" xmlns="http://www.w3.org/2000/svg">
            <g id="material-symbols-light:point-of-sale-sharp">
                <path id="Vector" d="M6.95964 8.45086V3.91187H18.8971V8.45086H6.95964ZM8.0013 7.45087H17.8555V4.91187H8.0013V7.45087ZM4.35547 20.3729V17.7569H21.5013V20.3729H4.35547ZM4.35547 16.9879L7.62005 9.44987H18.2367L21.5023 16.9879H4.35547ZM9.12214 15.3729H10.9659V14.6029H9.12214V15.3729ZM9.12214 13.6029H10.9659V12.8339H9.12214V13.6029ZM9.12214 11.8339H10.9659V11.0649H9.12214V11.8339ZM12.0076 15.3729H13.8503V14.6029H12.0065L12.0076 15.3729ZM12.0076 13.6029H13.8503V12.8339H12.0065L12.0076 13.6029ZM12.0076 11.8339H13.8503V11.0649H12.0065L12.0076 11.8339ZM14.8919 15.3729H16.7346V14.6029H14.8909L14.8919 15.3729ZM14.8919 13.6029H16.7346V12.8339H14.8909L14.8919 13.6029ZM14.8919 11.8339H16.7346V11.0649H14.8909L14.8919 11.8339Z"></path>
            </g>
        </svg>
        <span>POS</span>
    </a>
    <a class="mobilePOSBtn2" style="display: none;"
       class="nav-link nav-link-label" href="#"
       data-toggle="dropdown" aria-expanded="false">
        <svg style="width: 15px;height: 15px;fill: #449f2d;" xmlns="http://www.w3.org/2000/svg"
             viewBox="0 0 448 512">
            <path
                d="M240 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H32c-17.7 0-32 14.3-32 32s14.3 32 32 32H176V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H384c17.7 0 32-14.3 32-32s-14.3-32-32-32H240V80z"/>
        </svg>
    </a>
    <ul class="dropdown-menu dropdown-menu-media dropdown-menu-left pr-5 pl-5 mt-5 mb-5" style="margin-left:50px;margin-right:50px">
        <li class="dropdown-menu-header">
            <h4 class="dropdown-header m-0">
                <span class="grey darken-2"
                      style="font-size: 16px !important;">@lang('home.Quick shortcuts') </span>
                <span
                    class="notification-tag badge badge-default badge-danger float-right m-0">
                   @lang('home.New')
                </span>
            </h4>
        </li>

        <li class="dropdown-menu-footer">
            <a class="dropdown-item" href="{{ route('client.categories.create') }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path
                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"></path>
                </svg>
                @lang('home.Add category')
            </a>

            <a class="dropdown-item" href="{{ route('client.products.create') }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path
                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"></path>
                </svg>
                @lang('home.Add a product')
            </a>

            <a class="dropdown-item" href="{{ route('client.outer_clients.create') }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path
                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"></path>
                </svg>
              @lang('home.Add a client')
            </a>

            <a class="dropdown-item" href="{{ route('client.suppliers.create') }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path
                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"></path>
                </svg>
              @lang('home.Add a resource')
            </a>

            <a class="dropdown-item" href="{{ route('client.sale_bills.create') }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path
                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"></path>
                </svg>
              @lang('home.New bill of sale')
            </a>

            <a class="dropdown-item" href="{{ route('client.purchase_orders.create') }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path
                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"></path>
                </svg>
               @lang('home.New purchase invoice')
            </a>

            <a class="dropdown-item" href="{{ route('client.add.cash.suppliers') }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path
                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"></path>
                </svg>
               @lang('home.Cash payment to a supplier')
            </a>

            <a class="dropdown-item" href="{{ route('client.give.cash.clients') }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path
                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"></path>
                </svg>
              @lang('home.Cash payment to a customer')
            </a>

            <a class="dropdown-item" href="{{ route('employees.get.cash') }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path
                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"></path>
                </svg>
             @lang('home.Cash payment to an employee')
            </a>

            <a class="dropdown-item" href="{{ route('client.add.cash.clients') }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path
                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"></path>
                </svg>
              @lang('home.Register a payment from a customer')
            </a>

            <a class="dropdown-item" href="{{ route('client.give.cash.suppliers') }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path
                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"></path>
                </svg>
               @lang('home.Register a batch from a supplier')
            </a>

            <a class="dropdown-item" href="{{ route('client.expenses.create') }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path
                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"></path>
                </svg>
               @lang('home.Register a batch from an employee')
            </a>
        </li>
    </ul>
    <div class="spinner-gif">
        <img src="/spinner.gif"
             style="margin: auto; text-align: center; width: 88px; display: block;top:200px;position: relative;">
    </div>

@endsection

<script src="{{ asset('app-assets/js/jquery.min.js') }}"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    $(document).ready(function () {
        let compeletionPercentage = $("#compeletionProcess").val();
        if (compeletionPercentage != 100) {
            $(".ComeletionProcessDiv").fadeIn(1200);
        }

        $("#toggleProfileCompany").click(function () {
            $(".ComeletionProcessDiv").slideToggle(1000);
        });


        setTimeout(function () {
            $(".spinner-gif").hide();
            $(".dashboard-content").fadeIn(500);
        }, 1500);

        //start chars
        Highcharts.chart('container', {
            chart: {
                type: 'column',
            },
            plotOptions: {
                series: {
                    stacking: 'normal',
                    animation: {
                        duration: 3000
                    }
                },
                column: {
                    stacking: 'normal',
                    borderWidth: 10,
                    borderRadius: 10,
                    pointRange: 1,
                }
            },
            title: '',
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },


            yAxis: {
                allowDecimals: false,
                min: 0,
                title: {
                    text: 'Count medals'
                }
            },

            tooltip: {
                format: '<b>{key}</b><br/>{series.name}: {y}<br/>' +
                    'Total: {point.stackTotal}'
            },

            //dataset
            series: [{
                name: 'Income',
                data: [148, 133, 124, 133, 124, 133, 124, 133, 124, 133, 124, 124],
                stack: 'Europe',
                color: '#449f2d',
            }, {
                name: 'Expenses',
                data: [55, 68, 25, 13, 35, 48, 15, 20, 30, 55, 50, 65],
                stack: 'Europe',
                color: '#f6a600'
            }, {
                name: 'Revenues',
                data: [102, 98, 65, 98, 65, 98, 65, 98, 65, 98, 65, 65],
                stack: 'Europe',
                color: '#45c5cd'
            }
            ]
        });
        //end chars

    });
</script>
