@extends('site.layouts.app-main')
<style>
    .loginBtn:hover,
    .loginBtnAni:hover {
        box-shadow: rgb(97 71 211 / 55%) 5px 0px 60px 28px;
        transform: scale(1.05);
    }

    .subscriptNow {
        width: 100%;
        border-radius: 8px;
        background: #222751;
        padding: 12px;
        text-align: center;
        color: white !important;
        font-weight: bold;
        font-size: 16px;
        margin-top: 13px;
    }

    .subscriptNow2 {
        width: 100%;
        border-radius: 8px;
        background: white;
        padding: 12px;
        text-align: center;
        color: #222751 !important;
        font-weight: bold;
        font-size: 16px;
        margin-top: 13px;
    }

    .rtl {
        direction: rtl;
    }

    .ltr {
        direction: ltr;
    }

    . {
        padding: 10px 0 !important;
        border-radius: 8px !important;
        background: white !important;
        box-shadow: rgb(149 157 165 / 13%) 0px 8px 30px;
        height: 67px;
    }

    .color-theme p {
        text-align: center !important;
        justify-content: center !important;
        direction: rtl !important;
    }

    i.fa-check {
        margin-left: 20px;
    }

    div.content p {
        margin-bottom: 70px;
    }


    .p-main-sec1 {
        color: #FFF !important;

        @if (LaravelLocalization::getCurrentLocale() == 'ar')
            text-align: right !important;
        @else
            text-align: left !important;
        @endif
        font-family: Cairo !important;
        font-size: 20px !important;
        font-style: normal !important;
        font-weight: 400 !important;
        line-height: 164% !important;
        text-transform: uppercase !important;
        opacity: 0.6 !important;
    }

    .h3heading {
        color: #FFF !important;

        @if (LaravelLocalization::getCurrentLocale() == 'ar')
            text-align: right !important;
        @else
            text-align: left !important;
        @endif
        font-family: Cairo !important;
        font-size: 28px !important;
        font-style: normal !important;
        font-weight: 400 !important;
        line-height: 164% !important;
        text-transform: uppercase !important;
        margin-top: 35px;
    }

    .h1heading {
        margin-top: 30px;
        color: white;

        @if (LaravelLocalization::getCurrentLocale() == 'ar')
            text-align: right !important;
        @else
            text-align: left !important;
        @endif
        font-family: Cairo !important;
        font-size: 35px !important;
        font-style: normal !important;
        font-weight: 600 !important;
        line-height: 164% !important;
        text-transform: uppercase !important;
        margin-bottom: 32px;
    }

    .custom-btn {
        margin-top: 5px;
        text-align: center !important;
        justify-content: center !important;
        direction: rtl !important;
        text-transform: uppercase;
        border-radius: 10px;
        background-image: -webkit-linear-gradient(169deg, #5560ff 17%, #aa52a1 63%, #ff4343 100%);
        -webkit-transition: all ease 0.3s;
        transition: all ease 0.3s;
        border: none;
        width: auto;
        color: #fff;
        min-width: 250px;
        padding: 10px 50px;
        height: 50px !important;
        font-weight: 600;
    }

    .cd-words-wrapper {
        text-align: center !important;
    }

    h4.title a {
        color: #ccc !important;
    }

    .overlays {
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.85);
        color: #fff;
        z-index: 9999999999 !important;
        position: fixed;
        display: none;
        padding: 30px;
        top: 0;
        left: 0;
    }

    @media only screen and (max-width: 768px) {
        #myvideo {
            width: 100% !important;
            height: 70% !important;
            margin: 10px;
        }
    }

    #myvideo {
        width: 70%;
        height: 70%;
        margin: 10px;
    }

    .sec3-heading {
        @if (LaravelLocalization::getCurrentLocale() == 'ar')
            text-align: right !important;

        @else
            text-align: left !important;
            direction: ltr;

        @endif

    }

    .sec3-p {
        color: rgba(34, 39, 81, 0.72);

        @if (LaravelLocalization::getCurrentLocale() == 'ar')
            text-align: right !important;
        @else
            text-align: left !important;
            direction: ltr;
        @endif
        font-size: 20px;
        font-style: normal;
        font-weight: 400;
        line-height: 31px;
    }

    .lightBox {
        transition: all 0.2s ease-in-out;
        margin: 15px 0;
        cursor: pointer;
        height: auto;
        min-height: 305px;
        padding: 15px 19px 0 13px;
        border-radius: 20px;
        border: 1px solid #E6E6E6;
        background: #FFF;
        box-shadow: rgb(149 157 165 / 20%) 0px 8px 24px;
    }

    .lightBox h5 {
        /* margin-top: 10px; */
        margin-bottom: 10px;
        color: #222751;

        @if (LaravelLocalization::getCurrentLocale() == 'ar')
            text-align: right !important;
        @else
            text-align: left !important;
            direction: ltr;
        @endif
        font-size: 18px;
        font-style: normal;
        font-weight: 500;
        line-height: 26px;
    }

    .lightBox p {
        margin-top: 10px;
        color: #222751;

        @if (LaravelLocalization::getCurrentLocale() == 'ar')
            text-align: right !important;
        @else
            text-align: left !important;
            direction: ltr;
        @endif
        font-size: 15px;
        font-style: normal;
        font-weight: 400;
        line-height: 23px;
    }

    .lightBox a {
        color: #E0A93D !important;
        text-align: center;
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: 20px;
        margin-bottom: 10px;
    }

    .darkBox {
        transition: all 0.2s ease-in-out;
        margin: 15px 0;
        min-height: 305px;
        height: auto;
        cursor: pointer;
        border-radius: 20px;
        padding: 25px 19px 0 13px;
        border: 1px solid #E6E6E6;
        background: #222751;
        box-shadow: rgb(149 157 165 / 20%) 0px 8px 24px;
    }

    .darkBox h5 {
        margin-top: ;
        margin-bottom: 10px;
        color: white;

        @if (LaravelLocalization::getCurrentLocale() == 'ar')
            text-align: right !important;
        @else
            text-align: left !important;
            direction: ltr;
        @endif
        font-size: 24px;
        font-weight: 500;
        line-height: 44.98px;
        text-align: right;

    }

    .darkBox p {
        margin-top: 6px;
        color: #FFF;

        @if (LaravelLocalization::getCurrentLocale() == 'ar')
            text-align: right !important;
        @else
            text-align: left !important;
            direction: ltr;
        @endif
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: 23px;
    }

    .darkBox a {
        color: #E0A93D !important;
        text-align: center;
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: 20px;
        margin-bottom: 15px;
    }

    .spanLiSec5 {
        color: #ffffffc4;

        @if (LaravelLocalization::getCurrentLocale() == 'ar')
            text-align: right !important;
        @else
            text-align: left !important;
            direction: ltr;
        @endif
        font-size: 20px;
        font-style: normal;
        font-weight: 300;
        line-height: 182%;
        text-transform: uppercase;
    }

    .spanLiSec6 {
        color: rgba(34, 39, 81, 0.73);

        @if (LaravelLocalization::getCurrentLocale() == 'ar')
            text-align: right !important;
            font-size: 20px;

        @else
            text-align: left !important;
            direction: ltr;
            font-size: 16px;

        @endif
        font-style: normal;
        font-weight: 300;
        line-height: 182%;
        text-transform: uppercase;
    }

    .innerSec8 {
        border-radius: 8px;
        padding: 25px 15px;
        border: 1px solid rgba(232, 232, 232, 0.40);
        background: #FFF;
        box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    }

    .sec8Title {
        border-bottom: 1px solid #80808029;
    }

    .sec8Title h4 {
        margin-bottom: 10px !important;
    }

    .lightBox:hover,
    .darkBox:hover {
        transform: scale(1.05);
    }

    .banner-section {
        position: relative;
        overflow: hidden;
        clip-path: polygon(20% 0%, 0 0, 0 74%, 48% 86%, 0 99%, 0 74%, 100% 99%, 100% 80%, 100% 50%, 100% 0, 80% 0%, 46% 0);
    }

    .filled-area {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        clip-path: polygon(48% 86%, 0 99%, 0 74%);
        background: linear-gradient(180deg, #E0A93D 0%, #C89531 100%);
        ;

    }
</style>
@section('content')
    <!-- =====whatsapp icon===== -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <a href="https://api.whatsapp.com/send?phone=+966508847497&text=%D8%A7%D9%84%D8%B3%D9%84%D8%A7%D9%85%20%D8%B9%D9%84%D9%8A%D9%83%D9%85  "
        class="float" target="_blank">
        <i class="fa fa-whatsapp my-float"></i>
    </a>
    <!-- ==========Banner-Section========== -->
    <section class="banner-section"
        style="padding-bottom: 0px; padding-top: 220px; background: linear-gradient(169.59deg, #1D7296 19.1%, #0B435A 99.21%);">
        <div class="filled-area"></div>

        <div class="container m-0 mx-auto">
            <div style="margin-top: -60px;" class="row @if (LaravelLocalization::getCurrentLocale() == 'en') flex-row-reverse @endif">
                <div style="margin-top: -60px;" class="col-md-6 banner-content pr-4">
                    @if (session('error'))
                        <div class="alert alert-danger fade show">
                            {{ session('error') }}
                            <a class="dropdown-item" href="{{ route('client.logout') }}"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="fa fa-power-off"></i> {{ __('main.logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('client.logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </div>
                    @endif


                    <h2 class="h1heading  animate__backInRight" style="animation-duration: 2s">
                        {{ __('main.best-option') }}<br>{{ __('main.best-option2') }}

                    </h2>
                    <p class="p-main-sec1 animate__backInRight" style="animation-duration: 2.4s">
                        {{ __('main.best-option-p') }}
                    </p>

                    {{-- <h3 class="text-white h3heading animate__backInRight" style="animation-duration: 2.6s">
                        {{ __('main.certified') }}
                    </h3>
                    <img style="animation-duration: 2.8s;width: 83%; @if (LaravelLocalization::getCurrentLocale() == 'en') float: left;  @else float: right; @endif margin-top: 6px;margin-bottom: 26px;"
                        src="{{ asset('images/hay2a.png') }}" class="animate__backInRight"> --}}
                    @if (LaravelLocalization::getCurrentLocale() == 'en')
                    @else
                        <br><br>
                    @endif
                    <div class="col-12 row p-0 animate__backInRight" style="animation-duration: 2.8s">
                        @if (!auth()->guard('client-web')->check())
                            <div class="col-6">
                                <a class="loginBtn loginBtnAni"
                                    style="background:#E0A93D;border:#E0A93D;  color: white;padding: 10px 20px !important;min-width: 225px;"
                                    href="{{ route('index3') }}">
                                    {{ __('main.register') }}
                                </a>
                            </div>

                            <div class="col-6 p-0">
                                <a class="subscribNow loginBtnAni"
                                    style="color: white;padding: 10px 20px !important;min-width: 225px;"
                                    href="{{ route('client.login') }}">
                                    {{ __('main.login') }}
                                </a>
                            </div>
                        @else
                            <div class="col-6 p-0">
                                <a class="subscribNow loginBtnAni"
                                    style="color: white;padding: 10px 20px !important;min-width: 225px;"
                                    href="{{ route('client.home') }}">
                                    {{ __('main.home') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-6 ">
                    <div class=" text-center" style="margin-bottom: 80px;">
                        <img class="img-fluid" src="{{ asset('images/cash1.svg') }}">
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <section class="p-0">
        {{-- <div class="row d-flex justify-content-center">
            <div class="col-md-8  d-flex justify-content-center">
                <img src="{{ asset('images/offer.jpg') }}"width="80%" >
            </div>
        </div> --}}
    </section>
    <!-- ==========Banner-Section========== -->
    <section class="why-us section-bg d-none">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <a href="javascript:;" class="play-btn mb-4"></a>
                </div>
                <div class="col-lg-6 d-flex flex-column justify-content-center p-5">

                    <div class="icon-box">
                        <div class="icon"><i class="bx bx-fingerprint"></i></div>
                        <h4 class="title"><a href="">
                                {{ __('index.what-is-elaraby-erp') }}
                            </a></h4>
                        <p class="description">
                            {{ __('index.elaraby-erp-integrated-project-management-shops-and-warehouses') }}
                        </p>
                    </div>

                    <div class="icon-box">
                        <div class="icon"><i class="bx bx-gift"></i></div>
                        <h4 class="title"><a href="">
                                {{ __('index.what-is-benefits') }}
                            </a></h4>
                        <p class="description">
                            {{ __('index.save-your-time-and-effort-and-start-managing-your-business-professionally') }}
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <div class="overlays text-center justify-content-center">
        <button
            style="width: 40px; height: 40px;top:10px;border-radius: 0; right: 10px; float: right;z-index: 999999; display: inline;position:fixed;"
            class="remove_layout btn btn-md btn-danger">
            <i class="fa fa-close"></i>
        </button>
        <video id='myvideo' controls>
            <source media="all"
                @if (isset($intro_movie)) src="{{ asset($intro_movie->intro_movie) }}" @else src="" @endif
                type="video/mp4" />
        </video>
    </div>
    <!---===SECTION3====-->
    <div class="row flex-column p-4" style="margin: 50px 0;">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-12 d-flex justify-content-center">
                    <div class=""
                        style="color:#E0A93D !important;font-family: Cairo; font-size: 16px; font-weight: 700; line-height: 29.98px; text-align: center;">
                        {{ __('main.partners') }}

                    </div>
                </div>
                <div class="col-12 d-flex justify-content-center">
                    <div class="mt-0 "
                        style="color:#1E1F4B !important;font-family: Cairo; font-size: 36px; font-weight: 400; line-height: 48px; letter-spacing: -0.03em; text-align: center;">
                        {{ __('main.partners2') }}

                    </div>
                </div>
                <div class="col-8 d-flex justify-content-center">
                    <div class="text-muted mt-0 "
                        style="font-family: Cairo; font-size: 20px; font-weight: 400; line-height: 36px; text-align: center; color:#696984">
                        {{ __('main.partners3') }}

                    </div>
                </div>
            </div>
            <!--second row-->
            <div class="row w-100 m-0 mt-5 justify-content-center">
                <div class="col-sm-4">
                    <!-- First Column -->
                    <div class="inner lightBox">
                        <img src="{{ asset('images/dark.svg') }}">

                        <h5> {{ __('main.title1') }}</h5>
                        <p>{{ __('main.sub-title1') }}</p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <!-- Second Column -->
                    <div class="inner darkBox" style="background: linear-gradient(180deg, #20779C 0%, #065272 100%);">
                        <img src="{{ asset('images/light.svg') }}">
                        <h5>{{ __('main.title2') }}</h5>
                        <p>{{ __('main.sub-title2') }}</p>
                    </div>
                </div>
                <div class="col-sm-4">
                    <!-- Third Column -->
                    <div class="inner lightBox">
                        <img src="{{ asset('images/dark.svg') }}">
                        <h5> {{ __('main.title3') }}</h5>
                        <p>{{ __('main.sub-title3') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!---===SECTION3====-->

    <!------PARTENERS-------->
    <section class="tour-section padding-top padding-bottom" id="par">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-12 d-flex justify-content-center">
                    <h3 class="h3heading" style="color:#E0A93D !important;">
                        {{ __('main.partners4') }}

                    </h3>
                </div>
                </br>
                <div class="col-12 d-flex justify-content-center">
                    <h4 class="h3heading mt-0 " style="color:#1E1F4B !important;">
                        {{ __('main.partners5') }}

                        <span style="color:#E0A93D !important;"> {{ __('main.partners6') }} </span>
                    </h4>
                </div>
                @php
                    $companies = \App\Models\Company::whereNotNull('company_logo')
                        ->orderBy('id', 'desc')
                        ->take(13)
                        ->get();
                @endphp

                <div class="container my-5">
                    <div class="row justify-content-center gap-3">
                        @foreach ($companies as $company)
                            @php
                                $logoPath = ltrim($company->company_logo, '/'); // Remove leading slash if exists
                                $fullPath = public_path($logoPath);
                            @endphp

                            @if (file_exists($fullPath))
                                <div class="col-6 col-sm-4 col-md-3 col-lg-2 d-flex align-items-center justify-content-start gap-2"
                                    style="height: 100px;">
                                    <img src="{{ asset($logoPath) }}" class="img-fluid"
                                        style="max-height: 50px; object-fit: contain;"
                                        alt="{{ $company->company_name }}">
                                    {{-- <span class="fw-semibold small text-nowrap">{{ $company->company_name }}</span> --}}
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>


            </div>
        </div>

    </section>
    <!--===================-->


    <!--====SECTION4====-->
    <div class="row @if (LaravelLocalization::getCurrentLocale() == 'en') flex-row-reverse @endif section4EveryThing p-5"
        style="margin-top: 150px;">
        <div class="col-sm-6">
            <div class="img-viewer-app text-center ">

                <img class="img-fluid" style="width: 80%" src="{{ asset('images/sec4.png') }}">
            </div>

        </div>
        <div class="col-sm-6 banner-content pr-4">
            <div class="sec3-heading"
                style="font-family: Cairo;
                        font-size: 20px;
                        font-weight: 600;
                        line-height: 37.48px;

                        color:#DF8317;
                        ">

                {{ __('main.allneeded') }}

            </div>
            <br>
            <div class="sec3-heading"
                style="font-family: Cairo;
                       font-family: Cairo;
                font-size: 40px;
                font-weight: 700;
                line-height: 60px;
                letter-spacing: -0.03em;


                        ">

                {{ __('main.allneeded2') }}

            </div>
            {{-- <p class="sec3-p mt-4"></p> --}}
            <p class="sec3-p mt-4"
                style="font-family: Cairo;
                    font-size: 22px;
                    font-weight: 400;
                    line-height: 40px;
                    letter-spacing: 0.02em;
                    text-align: right;
                    color:background: #757095;

                    ">
                {{ __('main.allneeded3') }}
            </p>
            <a class="loginBtn"
                style="@if (LaravelLocalization::getCurrentLocale() == 'en') float: left; @else float: right; @endif margin-top:20px;color: white; background: linear-gradient(180deg, #20779C 0%, #11668A 100%);Width
                                                                          189px; border: 1px solid #222751; border-radius: 80px; padding: 11px 39px !important;"
                href="{{ route('client.login') }}">
                {{ __('main.joinNow') }}


            </a>
        </div>


    </div>
    <!--====SECTION4====-->



    <!--====SECTION5====-->
    <div class="row d-flex justify-content-center" id="invoice"
        style="background-image: url('{{ asset('images/framm.png') }}'); background-size: cover;">
        <div class="col-md-8  d-flex justify-content-center  mt-5" style="padding-bottom:20px;">
            {{-- <h2 class="sec3-heading" style="color: white;font-size: 25px !important;">{{ __('main.among') }}</h2> --}}
            <p class="mt-3"
                style="font-family: Cairo;
                font-size: 43px;
                font-weight: 500 !important;
                line-height: 70.52px;
                letter-spacing: 0.02em;
                text-align: center;
                color: white;">

                {{ __('main.among') }}
            </p>

        </div>
        <div class="mb-4"
            style="font-family: Cairo;
                font-size: 30px !important;
                font-weight:100 !important;
                line-height: 49.2px !important;
                letter-spacing: 0.02em !important;
                text-align: center ;
                color: white;">
            {{ __('main.among2') }}<br> {{ __('main.among3') }}
        </div>
        <div class="col-md-10  d-flex justify-content-center ">

            <img class="img-fluid" src="{{ asset('images/taxs.png') }}">

        </div>

    </div>

    <!--====SECTION5====-->

    <div class="row @if (LaravelLocalization::getCurrentLocale() == 'en') flex-row-reverse @endif section4EveryThing p-5"
        style="margin-top: 150px;">
        <div class="col-sm-6 banner-content pr-4">
            <div class="sec3-heading"
                style="font-family: Cairo;
                        font-size: 20px;
                        font-weight: 600;
                        line-height: 37.48px;

                        color:#E0A93D;
;
                        ">

                {{ __('main.allneeded4') }}

            </div>
            <br>
            <div class="sec3-heading"
                style="font-family: Cairo;
                       font-family: Cairo;
                font-size: 40px;
                font-weight: 700;
                line-height: 60px;
                letter-spacing: -0.03em;
                color:#065272;



                        ">

                {{ __('main.allneeded5') }}

            </div>
            {{-- <p class="sec3-p mt-4">{{ __('main.allneeded3') }}</p> --}}
            <p class="sec3-p mt-4"
                style="font-family: Cairo;
                    font-size: 22px;
                    font-weight: 400;
                    line-height: 40px;
                    letter-spacing: 0.02em;
                    text-align: right;
                    color:background: #757095;

                    ">
                {{ __('main.allneeded6') }}

            </p>
            <a class="loginBtn"
                style="@if (LaravelLocalization::getCurrentLocale() == 'en') float: left; @else float: right; @endif margin-top:20px;color: white; background: linear-gradient(180deg, #20779C 0%, #11668A 100%);Width
                                                                          189px; border: 1px solid #222751; border-radius: 80px; padding: 11px 39px !important;"
                href="{{ route('client.login') }}">
                {{ __('main.joinNow2') }}


            </a>
        </div>
        <div class="col-sm-6">
            <div class="img-viewer-app text-center mt-5">

                <img class="img-fluid" style="width: 80%" src="{{ asset('images/graph.png') }}">
            </div>

        </div>

    </div>
    <!--====SECTION6====-->
    <div class="row mt-5" id="services">
        <div class="col-sm-5">
            <div class="img-viewer-app text-center">
                <img class="img-fluid" style="" src="{{ asset('images/image2.png') }}">
            </div>
        </div>

        <div class="col-sm-7 banner-content @if (LaravelLocalization::getCurrentLocale() == 'en') pl-5 @else pr-4 @endif mt-5">
            <div class="sec3-heading pt-5"
                style="color: #E0A93D;font-family: Cairo;
                font-size: 20px;
                font-weight: 600;
                line-height: 37.48px;
                text-align: left;
                ">
                {{ __('main.develop') }}

            </div>
            <div class="sec3-heading pt-5 mb-4"
                style="color: #065272;font-family: Cairo;
                    font-size: 43px;
                    font-weight: 700;
                    letter-spacing: 0.01em;
                    text-align: right;
                    line-height: 1.5;
                    ">
                {{ __('main.develop2') }}


            </div>

            <ul
                class="row d-flex justify-content-center @if (LaravelLocalization::getCurrentLocale() == 'en') text-left @else text-right @endif">
                <div class="col-md-6">
                    <li class="mt-3">
                        <div class="d-flex align-items-center @if (LaravelLocalization::getCurrentLocale() == 'en') flex-row-reverse @endif">
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-right ml-1 @else float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6" style="width: 91%;display: block;">
                                {{ __('main.develop4') }} </span>

                        </div>
                    </li>
                    <li class="mt-2">
                        <div class="d-flex align-items-center @if (LaravelLocalization::getCurrentLocale() == 'en') flex-row-reverse @endif">
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-right ml-1 @else float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6" style="width: 91%;display: block;">
                                {{ __('main.develop5') }}
                            </span>
                        </div>
                    </li>
                    <li class="mt-2">
                        <div class="d-flex align-items-center @if (LaravelLocalization::getCurrentLocale() == 'en') flex-row-reverse @endif">
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-right ml-1 @else float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6" style="width: 91%;display: block;">

                                {{ __('main.develop6') }}
                            </span>
                        </div>
                    </li>
                </div>
                <div class="col-md-6">
                    <li class="mt-3">
                        <div class="d-flex align-items-center @if (LaravelLocalization::getCurrentLocale() == 'en') flex-row-reverse @endif">
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-right ml-1 @else float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6" style="width: 91%;display: block;">

                                {{ __('main.develop7') }}
                            </span>
                        </div>
                    </li>

                    <li class="mt-2">
                        <div class="d-flex align-items-center @if (LaravelLocalization::getCurrentLocale() == 'en') flex-row-reverse @endif">
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-right ml-1 @else float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6" style="width: 91%;display: block;">

                                {{ __('main.develop8') }}
                            </span>
                        </div>
                    </li>
                    <li class="mt-2">
                        <div class="d-flex align-items-center @if (LaravelLocalization::getCurrentLocale() == 'en') flex-row-reverse @endif">
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-right ml-1 @else float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6" style="width: 91%;display: block;">
                                {{ __('main.develop3') }}
                            </span>
                        </div>
                    </li>
                </div>
            </ul>
            <a class="loginBtn"
                style="@if (LaravelLocalization::getCurrentLocale() == 'en') float: left; @else float: right; @endif margin-top:20px;color: white; background: linear-gradient(180deg, #20779C 0%, #11668A 100%);Width
                                                                          189px; border: 1px solid #222751; border-radius: 80px; padding: 11px 39px !important;"
                href="{{ route('client.login') }}">
                {{ __('main.joinNow') }}

            </a>

        </div>

    </div>
    <!--====SECTION6====-->


    <!--====SECTION7====-->
    <div class="row @if (LaravelLocalization::getCurrentLocale() == 'en') flex-row-reverse @endif"
        style="background-image: url('{{ asset('images/frame2.png') }}'); background-size: cover;margin-top: 50px;padding-bottom: 130px;padding-top: 130px;">
        <div class="col-sm-6 banner-content @if (LaravelLocalization::getCurrentLocale() == 'en') pl-5 @else pr-5 @endif">
            <h2 class="sec3-heading"
                style="font-family: Cairo;
font-size: 32px;
font-weight: 700;
line-height: 39.68px;
letter-spacing: 0.01em;

color:#FFFFFF;
">
                {{ __('main.exp1') }}

            </h2>
            <p class="sec3-p mt-4" style="color: #FFFFFFD9;
font-size: 20px;line-height:32px; ">
                {{ __('main.exp2') }}<br>{{ __('main.exp3') }}</p>

            <div class="d-flex @if (LaravelLocalization::getCurrentLocale() == 'en') justify-content-end @endif mt-2">
                <a class="loginBtn"
                    style="@if (LaravelLocalization::getCurrentLocale() == 'en') float: left; @else float: right; @endif margin-top:20px;color: #09395B; background: white;Width
                                                                          189px; border: 1px solid white; border-radius: 80px; padding: 11px 39px !important;"
                    href="{{ route('client.login') }}">
                    {{ __('main.joinNow') }}

                </a>
            </div>
        </div>

        <div class="col-sm-6 d-sm-block d-none">
            <div class="img-viewer-app text-center">
                <img class="img-fluid" style="width: 80%; position: absolute; bottom: -160px; right: 45px;"
                    src="{{ asset('images/mockup.png') }}">
            </div>
        </div>
    </div>
    <!--====SECTION7====-->


    <!------SECTION8 PRICE-------->
    <div class="sec8 mt-3 mb-5" id="pricing">
        <h3 class="sec3-heading pt-5 text-center" style="color:#222751 !important;">{{ __('main.ready') }}</h3>
        <p class="text-center mt-1" style="color:#637381;font-size: 23px;">{{ __('main.ready2') }}</p>
        <div class="row p-2 m-0 justify-content-around mt-5">

            <div class="col-sm-4 p-3">
                <div class="innerSec8">
                    <div class="sec8Title text-center p-2">
                        <h4 style="color:#222751;font-size: 25px;font-weight: 500 !important;">{{ __('main.asasi') }}</h4>
                    </div>
                    <ul class="@if (LaravelLocalization::getCurrentLocale() == 'en') text-left @else text-right @endif">
                        <li class="mt-3">
                            <span class="spanLiSec6 h4">
                                {{ __('main.asasi2') }}
                            </span>
                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6">{{ __('main.asasi3') }} </span>
                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6">{{ __('main.asasi4') }}</span>
                        </li>

                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6">{{ __('main.asasi5') }}</span>

                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6">{{ __('main.asasi6') }}</span>

                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6">{{ __('main.asasi7') }}</span>

                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6">{{ __('main.asasi18') }}</span>

                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6">{{ __('main.asasi9') }}</span>

                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6">{{ __('main.asasi10') }}</span>

                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6">{{ __('main.asasi11') }}</span>

                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6">{{ __('main.asasi12') }}</span>

                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6">{{ __('main.asasi13') }}</span>

                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6">{{ __('main.asasi14') }}</span>

                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6">{{ __('main.asasi15') }}</span>

                        </li>
                        <li>
                            <a href="{{ route('index3') }}" class="subscriptNow">{{ __('main.asasi8') }}</a>
                        </li>
                    </ul>
                </div>
            </div>


            <div class="col-sm-4 p-3">
                <div class="innerSec8" style="background: #222751;transform: scale(1.06);">
                    <div class="sec8Title text-center p-2">
                        <h4 style="color:white;font-size: 25px;font-weight: 500 !important;">{{ __('main.advanced1') }}
                        </h4>
                    </div>
                    <ul class="@if (LaravelLocalization::getCurrentLocale() == 'en') text-left @else text-right @endif">
                        <li class="mt-3">
                            <span class="spanLiSec6 h4"
                                style="color:rgba(255,255,255,0.75);">{{ __('main.advanced2') }}</span>
                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6"
                                style="color:rgba(255,255,255,0.75);width: 91%;">{{ __('main.advanced3') }}</span>
                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6" style="color:rgba(255,255,255,0.75);">{{ __('main.asasi4') }}</span>
                        </li>

                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6" style="color:rgba(255,255,255,0.75);">{{ __('main.asasi5') }}</span>

                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6" style="color:rgba(255,255,255,0.75);">{{ __('main.asasi6') }}</span>

                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6" style="color:rgba(255,255,255,0.75);">{{ __('main.asasi7') }}</span>
                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6 text-white">{{ __('main.asasi18') }}</span>

                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6 text-white">{{ __('main.asasi9') }}</span>

                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6 text-white">{{ __('main.asasi10') }}</span>

                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6 text-white">{{ __('main.asasi11') }}</span>

                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6 text-white">{{ __('main.asasi12') }}</span>

                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6 text-white">{{ __('main.asasi13') }}</span>

                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6 text-white">{{ __('main.asasi14') }}</span>

                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6 text-white">{{ __('main.asasi15') }}</span>

                        </li>
                        <li>
                            <a href="{{ route('index3') }}" class="subscriptNow2">{{ __('main.asasi8') }}</a>
                        </li>
                    </ul>
                </div>
            </div>


            <div class="col-sm-4 p-3">
                <div class="innerSec8">
                    <div class="sec8Title text-center p-2">
                        <h4 style="color:#222751;font-size: 25px;font-weight: 500 !important;">
                            {{ __('main.inclusive1') }}</h4>
                    </div>
                    <ul class="@if (LaravelLocalization::getCurrentLocale() == 'en') text-left @else text-right @endif">
                        <li class="mt-3">
                            <span class="spanLiSec6 h4">{{ __('main.inclusive2') }}</span>
                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6" style="width: 91%">{{ __('main.inclusive3') }}</span>
                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6">{{ __('main.asasi4') }}</span>
                        </li>

                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6">{{ __('main.asasi5') }}</span>

                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6">{{ __('main.asasi6') }}</span>

                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6">{{ __('main.asasi7') }}</span>

                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6">{{ __('main.asasi18') }}</span>

                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6">{{ __('main.asasi9') }}</span>

                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6">{{ __('main.asasi10') }}</span>

                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6">{{ __('main.asasi11') }}</span>

                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6">{{ __('main.asasi12') }}</span>

                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6">{{ __('main.asasi13') }}</span>

                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6">{{ __('main.asasi14') }}</span>

                        </li>
                        <li>
                            <svg class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                                xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"
                                fill="none">
                                <path
                                    d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                                <path
                                    d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                                    stroke="#E0A93D" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span class="spanLiSec6">{{ __('main.asasi15') }}</span>

                        </li>
                        <li>
                            <a href="{{ route('index3') }}" class="subscriptNow">{{ __('main.asasi8') }}</a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <!------SECTION8-------->
    <br>
    <br>
    <!------SECTION9-------->
    <div class="sec8 col-sm-8 col-11 mx-auto mt-5 mb-3">

        <h3 class="sec3-heading pt-5 text-center mb-3"
            style="font-family: Cairo;
                font-size: 16px;
                font-weight: 700;
                line-height: 29.98px;
                text-align: center;
                color:#E0A93D
                ">

            {{ __('main.discount1') }}

        </h3>
        <p class="text-center mt-1"
            style="font-family: Cairo;
            font-size: 40px;
            font-weight: 400;
            line-height: 48px;
            letter-spacing: -0.03em;
            text-align: center;
            ">
            {{ __('main.discount2') }}


            {{-- {{ __('main.discount3') }} --}}
        </p>
        <div class="text-center mt-1"
            style="font-family: Manrope;
            font-size: 20px;
            font-weight: 400;
            line-height: 35px;
            letter-spacing: -0.02em;
            text-align: center;
            color:#757095;

            ">
            {{-- {{ __('main.discount2') }} --}}

            {{ __('main.discount3') }}
        </div>
        <div class="row col-sm-10 d-flex justify-content-center mx-auto mt-3" style="flex-wrap: nowrap;">
            <div class="d-flex justify-content-center   @if (LaravelLocalization::getCurrentLocale() == 'en') justify-content-center @endif"
                style=" gap:20px;">
                <a class="loginBtn"
                    style="@if (LaravelLocalization::getCurrentLocale() == 'en') float: left; @else float: right; @endif margin-top:20px;color: white;background: #20779C;;Width
                                                                          189px; border: 1px solid white; border-radius: 80px; padding: 11px 39px !important;"
                    href="{{ route('contact') }}">
                    {{ __('main.joinNow3') }}

                </a>

                <a class="loginBtn"
                    style="@if (LaravelLocalization::getCurrentLocale() == 'en') float: left; @else float: right; @endif margin-top:20px;color: white; background: #E0A93D;;Width
                                                                          189px; border: 1px solid white; border-radius: 80px; padding: 11px 39px !important;"
                    href="{{ route('client.login') }}">
                    {{ __('main.joinNow') }}

                </a>

            </div>
        </div>
    </div>
    <!------SECTION8-------->
    <br>
    <br>

    {{-- <!------SECTION9-------->
    <div class="sec8 col-sm-9 col-11 mb-1 mx-auto ">

        <h3 class="sec3-heading pt-1 text-center mb-3"
            style="font-size: 38px;font-weight:bold;background: linear-gradient(180deg, #222751 0%, rgba(103, 111, 178, 0.83) 100%); background-clip: text; -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            {{ __('main.people') }}
        </h3>

        <div class="row mx-auto mt-5" style="flex-wrap: nowrap;">
            <div class="col-4">
                <img class="img-fluid" style="z-index: 99999; position: relative; background: #e8f2fa;"
                    src="{{ asset('images/user.png') }}">
            </div>
            <div class="col-8 text-right">
                <br>
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="28" viewBox="0 0 32 28"
                    fill="none">
                    <path
                        d="M31.5 0.735244L30.7177 6.35821C29.153 6.22668 27.8817 6.48974 26.9038 7.1474C25.9259 7.77217 25.2413 8.69289 24.8502 9.90956C24.4916 11.0933 24.4264 12.4744 24.6546 14.0528H31.5V27.469H18.2003V14.0528C18.2003 9.31767 19.2923 5.73344 21.4763 3.30011C23.6604 0.833894 27.0016 -0.0210611 31.5 0.735244ZM13.7997 0.735244L13.0173 6.35821C11.4527 6.22668 10.1814 6.48974 9.20347 7.1474C8.22555 7.77217 7.54101 8.69289 7.14984 9.90956C6.79127 11.0933 6.72608 12.4744 6.95426 14.0528H13.7997V27.469H0.5V14.0528C0.5 9.31767 1.59201 5.73344 3.77603 3.30011C5.96004 0.833894 9.30126 -0.0210611 13.7997 0.735244Z"
                        fill="#FF7F5C" />
                </svg>
                <br>
                <br>

                <svg xmlns="http://www.w3.org/2000/svg" width="146" height="30" viewBox="0 0 146 30"
                    fill="none">
                    <path
                        d="M14.0489 3.39605C14.3483 2.47474 15.6517 2.47473 15.9511 3.39604L18.0309 9.79726C18.1648 10.2093 18.5488 10.4882 18.982 10.4882L25.7126 10.4882C26.6814 10.4882 27.0841 11.7279 26.3004 12.2973L20.8552 16.2534C20.5047 16.5081 20.3581 16.9594 20.4919 17.3715L22.5718 23.7727C22.8712 24.694 21.8167 25.4601 21.033 24.8907L15.5878 20.9346C15.2373 20.6799 14.7627 20.6799 14.4122 20.9346L8.96701 24.8907C8.1833 25.4601 7.12882 24.694 7.42817 23.7727L9.50805 17.3715C9.64193 16.9594 9.49527 16.5081 9.14478 16.2534L3.69958 12.2973C2.91586 11.7279 3.31864 10.4882 4.28736 10.4882L11.018 10.4882C11.4512 10.4882 11.8352 10.2093 11.9691 9.79726L14.0489 3.39605Z"
                        fill="#F9896B" />
                    <path
                        d="M43.0489 3.39605C43.3483 2.47474 44.6517 2.47473 44.9511 3.39604L47.0309 9.79726C47.1648 10.2093 47.5488 10.4882 47.982 10.4882L54.7126 10.4882C55.6814 10.4882 56.0841 11.7279 55.3004 12.2973L49.8552 16.2534C49.5047 16.5081 49.3581 16.9594 49.4919 17.3715L51.5718 23.7727C51.8712 24.694 50.8167 25.4601 50.033 24.8907L44.5878 20.9346C44.2373 20.6799 43.7627 20.6799 43.4122 20.9346L37.967 24.8907C37.1833 25.4601 36.1288 24.694 36.4282 23.7727L38.5081 17.3715C38.6419 16.9594 38.4953 16.5081 38.1448 16.2534L32.6996 12.2973C31.9159 11.7279 32.3186 10.4882 33.2874 10.4882L40.018 10.4882C40.4512 10.4882 40.8352 10.2093 40.9691 9.79726L43.0489 3.39605Z"
                        fill="#F9896B" />
                    <path
                        d="M72.0489 3.39605C72.3483 2.47474 73.6517 2.47473 73.9511 3.39604L76.0309 9.79726C76.1648 10.2093 76.5488 10.4882 76.982 10.4882L83.7126 10.4882C84.6814 10.4882 85.0841 11.7279 84.3004 12.2973L78.8552 16.2534C78.5047 16.5081 78.3581 16.9594 78.4919 17.3715L80.5718 23.7727C80.8712 24.694 79.8167 25.4601 79.033 24.8907L73.5878 20.9346C73.2373 20.6799 72.7627 20.6799 72.4122 20.9346L66.967 24.8907C66.1833 25.4601 65.1288 24.694 65.4282 23.7727L67.5081 17.3715C67.6419 16.9594 67.4953 16.5081 67.1448 16.2534L61.6996 12.2973C60.9159 11.7279 61.3186 10.4882 62.2874 10.4882L69.018 10.4882C69.4512 10.4882 69.8352 10.2093 69.9691 9.79726L72.0489 3.39605Z"
                        fill="#F9896B" />
                    <path
                        d="M101.049 3.39605C101.348 2.47474 102.652 2.47473 102.951 3.39604L105.031 9.79726C105.165 10.2093 105.549 10.4882 105.982 10.4882L112.713 10.4882C113.681 10.4882 114.084 11.7279 113.3 12.2973L107.855 16.2534C107.505 16.5081 107.358 16.9594 107.492 17.3715L109.572 23.7727C109.871 24.694 108.817 25.4601 108.033 24.8907L102.588 20.9346C102.237 20.6799 101.763 20.6799 101.412 20.9346L95.967 24.8907C95.1833 25.4601 94.1288 24.694 94.4282 23.7727L96.5081 17.3715C96.6419 16.9594 96.4953 16.5081 96.1448 16.2534L90.6996 12.2973C89.9159 11.7279 90.3186 10.4882 91.2874 10.4882L98.018 10.4882C98.4512 10.4882 98.8352 10.2093 98.9691 9.79726L101.049 3.39605Z"
                        fill="#F9896B" />
                    <path
                        d="M130.049 3.39605C130.348 2.47474 131.652 2.47473 131.951 3.39604L134.031 9.79726C134.165 10.2093 134.549 10.4882 134.982 10.4882L141.713 10.4882C142.681 10.4882 143.084 11.7279 142.3 12.2973L136.855 16.2534C136.505 16.5081 136.358 16.9594 136.492 17.3715L138.572 23.7727C138.871 24.694 137.817 25.4601 137.033 24.8907L131.588 20.9346C131.237 20.6799 130.763 20.6799 130.412 20.9346L124.967 24.8907C124.183 25.4601 123.129 24.694 123.428 23.7727L125.508 17.3715C125.642 16.9594 125.495 16.5081 125.145 16.2534L119.7 12.2973C118.916 11.7279 119.319 10.4882 120.287 10.4882L127.018 10.4882C127.451 10.4882 127.835 10.2093 127.969 9.79726L130.049 3.39605Z"
                        fill="#F9896B" />
                </svg>
                <br>
                <br>

                <p
                    style="color: #1B1C31; text-align: right; font-family: Cairo; font-size: 25px; font-style: normal; font-weight: 400; line-height: 41px; /* 136.667% */ letter-spacing: -0.6px;">
                    {{ __('main.people1') }}</p>
                <br>
                <br>
                <div class="userDet">
                    <p
                        style="color: #111C55; font-family: Cairo; font-size: 20px; font-style: normal; font-weight: 700; line-height: 30px; /* 150% */ letter-spacing: -0.6px;">
                        {{ __('main.people2') }}</p>
                    <p
                        style="color: #757095; font-family: Poppins; font-size: 16px; font-style: normal; font-weight: 500; line-height: 24px; /* 150% */ letter-spacing: -0.32px;">
                        {{ __('main.people3') }}</p>
                </div>
            </div>
        </div>
        <div class="d-md-block d-none"
            style="width: 134px; height: 134px; border-radius: 267px; background: #E0A93D; top: -92px; position: relative; z-index: 5; right: -37px;">
        </div>
    </div> --}}
    <!------SECTION9-------->
@endsection
<script src="{{ asset('app-js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.play-btn').on('click', function() {
            $('.overlays').show();
            $('body').css('overflow', 'hidden');
            $('#myvideo').get(0).play();
        });
        $('.remove_layout').on('click', function() {
            $('.overlays').hide();
            $('body').css('overflow', 'auto');
            $('#myvideo').get(0).pause();
            $('#myvideo').get(0).currentTime = 0;
        });
    });
</script>
