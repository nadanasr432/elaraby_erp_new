<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.css"
    integrity="sha512-NXUhxhkDgZYOMjaIgd89zF2w51Mub53Ru3zCNp5LTlEzMbNNAjTjDbpURYGS5Mop2cU4b7re1nOIucsVlrx9fA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"/>

<script
    src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js"
    integrity="sha512-lOrm9FgT1LKOJRUXF3tp6QaMorJftUjowOWiDcG5GFZ/q7ukof19V0HKx/GWzXCdt9zYju3/KhBNdCLzK8b90Q=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<style>
    .posNavigator > span {
        border: 1px solid #222751;
        padding: 7px 15px;
        border-radius: 30px;
        color: white;
        font-size: 14px !important;
        font-weight: bold;
        font-family: 'Cairo';
        transition: all 0.3s ease-in-out !important;
        display: flex;
        align-items: center;
        background: #222751;
    }

    @media screen and (max-width: 750px) {
        .posLi {
            right: 0 !important;
            font-size: 12px !important;
        }

        .posNavigator > span {
            margin-bottom: 50px;
        }

        .defaultTableMain {
            overflow-x: auto !important;
        }
    }

    .posNavigator svg {
        fill: white !important;
        margin-left: 5px;
        top: 0 !important;
    }

    .posNavigator:hover > span {
        border: 1px solid #222751;
        color: #222751;
        background: white;
    }

    .posNavigator:hover svg {
        fill: #222751 !important;
    }

    .col-md-3.col-sm-12.col-xs-12 {
        padding-left: 0 !important;
    }

    .adding-shortcuts-ul {
        position: absolute;
        background: white;
        border: 1px solid #222751;
        min-width: 122px;
        text-align: center;
        margin-right: -26px;
        margin-top: 9px;
        list-style: none;
        text-align: right;
        padding: 0;
        border-radius: 7px;
    }

    .dropdown-item {
        padding: 13px;
        width: 100%;
        border-bottom: 1px solid #2d2d2d20;
        font-family: 'Cairo';
    }

    .dropdown-item:hover {
        background: #222751;
    }

    .dropdown-item svg {
        width: 12px !important;
        top: 3px;
        position: relative;
        margin-left: 5px;
    }

    .dropdown-item, .dropdown-item svg {
        color: #222751;
        fill: #222751 !important;
    }

    .dropdown-item:hover, .dropdown-item:hover svg {
        color: white;
        fill: white !important;
    }

    .dropdown-menu-footer .dropdown-item {
        padding: 14px !important;
    }

    .mainBtnNewDes {
        background: #222751 !important;
        border: 1px solid #222751 !important;
        padding: 11px 15px !important;
        font-size: 11px !important;
        height: 37px;
    }

    #example-table_filter {
        text-align: left;
    }

    .alert-warning {
        border-color: rgba(245, 147, 86, 0.25) !important;
        background-color: #ffbc9040 !important;
        color: #963B00 !important;
    }

    .btn-newdark {
        border-color: #222751 !important;
        background-color: #222751 !important;
        color: #FFFFFF;
    }

    .bootstrap-select .dropdown-toggle .filter-option {
        text-align: right !important;
    }

    .alert-info {
        border-color: #1e9ff27d !important;
        background-color: #1e9ff229 !important;
        color: #053858 !important;
    }

    .dataTables_wrapper .row .col-sm-12:nth-child(2) {
        text-align: left !important;
    }
</style>
<nav
    class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-dark navbar-shadow no-print">
    <div class="navbar-wrapper navbar-dark"
         style="background: #222751;">
        <div class="navbar-header" style="background: #222751;">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mobile-menu d-md-none mr-auto">
                    <a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#">
                        <i class="fa fa-bars fa-2x"></i>
                    </a>
                </li>
                <li class="nav-item mx-auto text-center d-sm-none d-block"
                    style="margin-top: -10px!important;position: relative">
                    <a class="navbar-brand text-center"
                       style="position: relative; margin-right: 10px; margin-top: 10px; font-family: 'Cairo'; font-size: 14px !important;"
                       href="{{ route('client.home') }}">
                        {{Auth::user()->company->company_name}}
                    </a>
                </li>
                <li class="nav-item mx-auto text-center"
                    style="margin-top: -10px!important;position: relative">
                    <a class="navbar-brand text-center" href="{{ route('client.home') }}">
                        <img src="{{asset('images/logo.png')}}" class="img-fluid"
                             style="width: 63px; display: block; margin: auto;">
                    </a>
                </li>

                <li class="nav-item d-md-none">
                    <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i
                            class="la la-ellipsis-v"></i></a>
                </li>
            </ul>
        </div>
        <div class="navbar-container content" style="background: white; border-bottom: 1px solid #2f2f2f2f;">
            <div class="collapse navbar-collapse" id="navbar-mobile">
                <div class="mr-auto float-left">
                </div>
                <ul class="col-12 nav navbar-nav float-right"
                    style="display: flex; align-items: center;justify-content: left">

                    <!---------------------SIDEBAR TOGGLER------------------------------------------------->
                    <li class="nav-item d-none d-md-block float-right"
                        style="position: absolute; right: 0;margin-top: 5px;">
                        <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                            <img src="{{asset('assets/svgs/mini.svg')}}" width="30">
                        </a>
                    </li>
                    <!---------------------SIDEBAR TOGGLER------------------------------------------------->

                    <!---------------------Messages------------------------------------------------>
                    <li class="nav-item d-none d-md-block float-right"
                        style="position: absolute; right: 50px;margin-top: 10px;">
                        <a class="nav-link nav-link-label" href="#"
                           data-toggle="dropdown" aria-expanded="false">
                            <img src="{{asset('assets/svgs/msgs.svg')}}" width="25">
                            <span
                                class="badge badge-pill badge-default badge-warning badge-default badge-up"
                                id="taskcount">
                                0
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <h4 class="dropdown-header m-0">
                                    <span class="grey darken-2">@lang('home.Messages')  </span>
                                    <span
                                        class="notification-tag badge badge-default badge-danger float-right m-0">
                                       @lang('home.New')  
                                    </span>
                                </h4>
                            </li>

                            <li class="dropdown-menu-footer">
                                <a class="dropdown-item text-muted text-center"
                                   href="#">
                                   @lang('home.There are no current messages!')  
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!---------------------Messages------------------------------------------------>

                    <!---------------------NOTIFICATOINS------------------------------------------------>
                    <li class="nav-item d-none d-md-block float-right"
                        style="position: absolute; right: 100px;margin-top: 10px;">
                        <a class="nav-link nav-link-label" href="#"
                           data-toggle="dropdown" aria-expanded="false">
                            <img src="{{asset('assets/svgs/notifi.svg')}}" width="25">
                            <span
                                class="badge badge-pill badge-default badge-danger badge-default badge-up"
                                id="taskcount">
                                0
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <h4 class="dropdown-header m-0">
                                    <span class="grey darken-2">@lang('home.Notifications')   </span>
                                    <span
                                        class="notification-tag badge badge-default badge-danger float-right m-0">
                                         @lang('home.New') 
                                    </span>
                                </h4>
                            </li>

                            <li class="dropdown-menu-footer">
                                <a class="dropdown-item text-muted text-center"
                                   href="#">
                                 @lang('home.No notifications yet!')  
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!---------------------NOTIFICATIONS------------------------------------------------>

                    <!---------------------ADDING SHORTCUTS------------------------------------------------>
                    <li class="nav-item d-none d-md-block float-right"
                        style="position: absolute; right: 160px;margin-top: 10px;">
                        <a style="background: white; display: block; margin-left: 13px; border: 1px dashed #449f2d; padding: 1px 5px 11px 7px; border-radius: 31px;"
                           class="nav-link nav-link-label" href="#"
                           data-toggle="dropdown" aria-expanded="false">
                            <svg style="width: 15px;height: 15px;fill: #449f2d;" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 448 512">
                                <path
                                    d="M240 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H32c-17.7 0-32 14.3-32 32s14.3 32 32 32H176V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H384c17.7 0 32-14.3 32-32s-14.3-32-32-32H240V80z"/>
                            </svg>


                        </a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
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
                    </li>
                    <!---------------------ADDING SHORTCUTS------------------------------------------------>


                    <!---------------------POS BTN--------------------------------------------------------->
                    <li class="nav-item d-md-block float-right posLi"
                        style="position: absolute; right: 200px;margin-top: 10px;">
                        <a class="posNavigator" href="{{route('client.pos.create')}}">
                            <span class="mr-1">
                                <svg width="30" viewBox="0 0 26 25" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                <g id="material-symbols-light:point-of-sale-sharp">
                                <path id="Vector"
                                      d="M6.95964 8.45086V3.91187H18.8971V8.45086H6.95964ZM8.0013 7.45087H17.8555V4.91187H8.0013V7.45087ZM4.35547 20.3729V17.7569H21.5013V20.3729H4.35547ZM4.35547 16.9879L7.62005 9.44987H18.2367L21.5023 16.9879H4.35547ZM9.12214 15.3729H10.9659V14.6029H9.12214V15.3729ZM9.12214 13.6029H10.9659V12.8339H9.12214V13.6029ZM9.12214 11.8339H10.9659V11.0649H9.12214V11.8339ZM12.0076 15.3729H13.8503V14.6029H12.0065L12.0076 15.3729ZM12.0076 13.6029H13.8503V12.8339H12.0065L12.0076 13.6029ZM12.0076 11.8339H13.8503V11.0649H12.0065L12.0076 11.8339ZM14.8919 15.3729H16.7346V14.6029H14.8909L14.8919 15.3729ZM14.8919 13.6029H16.7346V12.8339H14.8909L14.8919 13.6029ZM14.8919 11.8339H16.7346V11.0649H14.8909L14.8919 11.8339Z"/>
                                </g>
                                </svg>

                                <span style="font-size: 10px !important;">
                                 {{ __('main.POS') }}
                                </span>
                            </span>
                        </a>
                    </li>
                    <!---------------------POS BTN--------------------------------------------------------->


                    <!----------------------------------------LANGUAGE------------------------------------->
                    <li class="dropdown dropdown-user nav-item">
                        <p style="color:black;font-size: 13px !important;margin-top: 10px;margin-left: 15px">
                            <img src="{{asset('assets/svgs/weather.svg')}}" width="25"/>
                            <span style="color: #222751; font-size: 20px; font-family: Cairo; font-weight: 400;">
                                {{date("H:i:s",strtotime(date("H:i:s")) + 60*60)}}
                            </span>
                        </p>

                    </li>
                    <!----------------------------------------LANGUAGE--------------------------------------->


                    <!----------------------------------------LANGUAGE------------------------------------->
                    <li class="dropdown dropdown-user nav-item">
                        @if (Config::get('app.locale') == 'en')
                            <a rel="alternate" hreflang="ar"
                               href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}"
                               style="color:black;font-size: 13px !important">
                                <img src="https://img.icons8.com/color/30/000000/saudi-arabia.png"/>
                            </a>
                        @elseif ( Config::get('app.locale') == 'ar' )

                            <a rel="alternate" hreflang="en"
                               href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}"
                               style="color:black;font-size: 13px !important">
                                <img style="border-radius: 50%;border: 1px dashed #222751;"
                                     src="{{asset('assets/svgs/en.svg')}}" width="25">
                                <span style="color: rgba(0, 0, 0, 0.70); font-size: 20px;font-weight: 500;">En</span>
                            </a>

                        @endif
                    </li>
                    <!----------------------------------------LANGUAGE--------------------------------------->

                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link p-1" data-toggle="dropdown">
                            <span class="avatar avatar-online">
                                @if (isset(Auth::user()->profile->profile_pic) && !empty(Auth::user()->profile->profile_pic))
                                    <img src="{{ asset(Auth::user()->profile->profile_pic) }}" alt="avatar"><i></i>
                                @else
                                    <img src="{{ asset('app-assets/images/user.png') }}" alt="avatar"><i></i>
                                @endif
                            </span>
                            <span style="color:gray">{{Auth::user()->name}}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right p-0" style="width: 150px !important;">

                            <a style="color: #222751;" class="dropdown-item" id="toggleProfileCompany">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                    <path
                                        d="M160 256C160 202.1 202.1 160 256 160C309 160 352 202.1 352 256C352 309 309 352 256 352C202.1 352 160 309 160 256zM512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256zM256 48C141.1 48 48 141.1 48 256C48 370.9 141.1 464 256 464C370.9 464 464 370.9 464 256C464 141.1 370.9 48 256 48z"></path>
                                </svg>
                                بروفايل الشركة
                            </a>

                            <a class="dropdown-item" href="{{ url('client/go-to-upgrade') }}">
                                <i class="fa fa-user"></i> {{ __('main.pricing') }}
                            </a>

                            <a class="dropdown-item" href="{{ route('client.profile.edit', Auth::user()->id) }}">
                                <i class="fa fa-user"></i> {{ __('main.edit-profile') }}
                            </a>

                            <a class="dropdown-item" href="{{ route('client.logout') }}"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="fa fa-power-off"></i>
                                {{ __('main.logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('client.logout') }}" method="POST"
                                  style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>


                </ul>
            </div>
        </div>
    </div>
</nav>
