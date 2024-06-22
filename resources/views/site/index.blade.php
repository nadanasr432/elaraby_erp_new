@extends('site.layouts.app-main')
<style>
    .loginBtn:hover, .loginBtnAni:hover {
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

    .partSpan {
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
        @if(LaravelLocalization::getCurrentLocale() == 'ar')
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
        @if(LaravelLocalization::getCurrentLocale() == 'ar')
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
        @if(LaravelLocalization::getCurrentLocale() == 'ar')
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
        @if(LaravelLocalization::getCurrentLocale() == 'ar')
               text-align: right !important;
        font-size: 36px;
        line-height: 54px;
        @else
               text-align: left !important;
        direction: ltr;
        line-height: 42px;
        font-size: 25px;
        @endif
           font-style: normal;
        font-weight: 500;
    }

    .sec3-p {
        color: rgba(34, 39, 81, 0.72);
        @if(LaravelLocalization::getCurrentLocale() == 'ar')
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
        min-height: 284px;
        padding: 15px 19px 0 13px;
        border-radius: 20px;
        border: 1px solid #E6E6E6;
        background: #FFF;
        box-shadow: rgb(149 157 165 / 20%) 0px 8px 24px;
    }

    .lightBox h5 {
        margin-top: 10px;
        margin-bottom: 10px;
        color: #222751;
        @if(LaravelLocalization::getCurrentLocale() == 'ar')
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
        @if(LaravelLocalization::getCurrentLocale() == 'ar')
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

    .lightBox a {
        color: #DF8317 !important;
        text-align: center;
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: 20px;
        margin-bottom: 15px;
    }

    .darkBox {
        transition: all 0.2s ease-in-out;
        margin: 15px 0;
        min-height: 284px;
        height: auto;
        cursor: pointer;
        border-radius: 20px;
        padding: 25px 19px 0 13px;
        border: 1px solid #E6E6E6;
        background: #222751;
        box-shadow: rgb(149 157 165 / 20%) 0px 8px 24px;
    }

    .darkBox h5 {
        margin-top: 10px;
        margin-bottom: 10px;
        color: white;
        @if(LaravelLocalization::getCurrentLocale() == 'ar')
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

    .darkBox p {
        margin-top: 10px;
        color: #FFF;

        @if(LaravelLocalization::getCurrentLocale() == 'ar')
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
        color: #DF8317 !important;
        text-align: center;
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: 20px;
        margin-bottom: 15px;
    }

    .spanLiSec5 {
        color: #ffffffc4;
        @if(LaravelLocalization::getCurrentLocale() == 'ar')
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
        @if(LaravelLocalization::getCurrentLocale() == 'ar')
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

    .lightBox:hover, .darkBox:hover {
        transform: scale(1.05);
    }
</style>
@section('content')
    <!-- =====whatsapp icon===== -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <a href="https://api.whatsapp.com/send?phone=+9660562354761&text=%D8%A7%D9%84%D8%B3%D9%84%D8%A7%D9%85%20%D8%B9%D9%84%D9%8A%D9%83%D9%85  "
       class="float" target="_blank">
        <i class="fa fa-whatsapp my-float"></i>
    </a>
    <!-- ==========Banner-Section========== -->
    <section class="banner-section" style="padding-bottom: 0px; padding-top: 150px;">
        <div class="banner-bg bg_img bg-fixed" data-background="{{ asset('images/banner/banner01.jpg') }}"></div>
        <div class="container m-0 mx-auto">
            <div class="row @if(LaravelLocalization::getCurrentLocale() == 'en') flex-row-reverse @endif">
                <div class="col-sm-6 banner-content pr-4">
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

                    <img style="position: absolute; width: 32px; right: 22px;" src="{{asset('images/sq.png')}}">
                    <img style="position: absolute; width: 32px; right: 422px;"
                         src="{{asset('images/circ.png')}}">

                    <h2 class="h1heading  animate__backInRight" style="animation-duration: 2s">
                        {{__('main.best-option')}}
                    </h2>
                    <p class="p-main-sec1 animate__backInRight"
                       style="animation-duration: 2.4s">{{__('main.best-option-p')}}</p>
                    <img class="animate__backInRight"
                         style="position: absolute; width: 52px; right: 452px;margin-top: -40px;animation-duration: 2.4s"
                         class="animate__backInRight"
                         src="{{asset('images/poin.png')}}">


                    <h3 class="text-white h3heading animate__backInRight" style="animation-duration: 2.6s">
                        {{__('main.certified')}}
                    </h3>
                    <img
                        style="animation-duration: 2.8s;width: 83%; @if(LaravelLocalization::getCurrentLocale() == "en") float: left;  @else float: right; @endif margin-top: 6px;margin-bottom: 26px;"
                        src="{{asset('images/hay2a.png')}}"
                        class="animate__backInRight">

                    <br><br>
                    <div class="col-12 row p-0 animate__backInRight" style="animation-duration: 2.8s">
                        @if (!auth()->guard('client-web')->check() && !auth()->guard('admin-web')->check())
                            <div class="col-6">
                                <a class="loginBtn loginBtnAni"
                                    style=" color: white;padding: 10px 20px !important;min-width: 225px;"
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
                        @elseif(auth()->guard('client-web')->check())
                            <div class="col-6 p-0">
                                <a class="subscribNow loginBtnAni"
                                    style="color: white;padding: 10px 20px !important;min-width: 225px;"
                                    href="{{ route('client.home') }}">
                                    {{ __('main.home') }}
                                </a>
                            </div>
                        @elseif(auth()->guard('admin-web')->check())
                            <div class="col-6 p-0">
                                <a class="subscribNow loginBtnAni"
                                    style="color: white;padding: 10px 20px !important;min-width: 225px;"
                                    href="{{ route('admin.home') }}">
                                    {{ __('main.home') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6 mt-sm-0 mt-4">
                    <div class="img-viewer-app text-center mt-3">
                        <img class="img-fluid" src="{{asset('images/main-app.png')}}">
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="col-12 p-0">
            <img class="fadeBottom" style="height: 226px; width: 108%; margin-top: -29px;"
                 src="{{asset('images/fadeFooter.png')}}">
        </div>
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
                    @if (isset($intro_movie)) src="{{ asset($intro_movie->intro_movie) }}"
                    @else
                    src="" @endif
                    type="video/mp4"/>
        </video>
    </div>
    <!------PARTENERS-------->
    <section class="tour-section padding-top padding-bottom">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <h3 class="h3heading" style="color:#222751 !important;">
                    {{__('main.partners')}}
                </h3>
                <div class="col-12 row justify-content-around mt-5">
                    <div class="partSpan m-1 text-center">
                        <img class="img-fluid" width="67%" src="{{asset('images/1.png')}}">
                    </div>
                    <div class="partSpan m-1 text-center">
                        <img class="img-fluid" width="80%" src="{{asset('images/2.png')}}">
                    </div>
                    <div class="partSpan m-1 text-center">
                        <img class="img-fluid" width="70%" src="{{asset('images/3.png')}}">
                    </div>
                    <div class="partSpan m-1 text-center">
                        <img class="img-fluid" width="60%" src="{{asset('images/4.png')}}">
                    </div>
                    <div class="partSpan m-1 text-center">
                        <img class="img-fluid" width="80%" src="{{asset('images/5.png')}}">
                    </div>
                    <div class="partSpan m-1 text-center">
                        <img class="img-fluid" width="80%" src="{{asset('images/6.png')}}">
                    </div>

                    <div class="partSpan mt-3 text-center">
                        <img class="img-fluid" width="80%" src="{{asset('images/7.png')}}">
                    </div>
                    <div class="partSpan mt-3 text-center">
                        <img class="img-fluid" width="70%" src="{{asset('images/8.png')}}">
                    </div>
                    <div class="partSpan mt-3 text-center">
                        <img class="img-fluid" width="70%" src="{{asset('images/9.png')}}">
                    </div>
                    <div class="partSpan mt-3 text-center">
                        <img class="img-fluid" width="70%" src="{{asset('images/10.png')}}">
                    </div>
                    <div class="partSpan mt-3 text-center">
                        <img class="img-fluid" width="70%" src="{{asset('images/11.png')}}">
                    </div>
                    <div class="partSpan mt-3 text-center">
                        <img class="img-fluid" width="70%" src="{{asset('images/12.png')}}">
                    </div>
                    <div class="partSpan mt-3 text-center">
                        <img class="img-fluid" width="70%" src="{{asset('images/13.png')}}">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--===================-->

    <!---===SECTION3====-->
    <div class="row flex-column p-4" style="margin: 50px 0;">

        <!--first row-->
        <div class="row w-100 m-0 @if(LaravelLocalization::getCurrentLocale() == 'en') flex-row-reverse @endif">
            <svg style="position:absolute;right: 0px;" xmlns="http://www.w3.org/2000/svg" width="113" height="120"
                 viewBox="0 0 113 120" fill="none">
                <path
                    d="M7.52526 119C-0.789905 94.5136 -5.96012 47.4233 39.8803 54.9528C97.1808 64.3648 83.4815 87.8588 76.9281 94.8963C72.1717 100.004 61.3651 101.398 55.9344 78.5976C50.4964 55.7661 49.0188 -11.6195 112 4.44974"
                    stroke="#FCA61F" stroke-opacity="0.4" stroke-width="3"/>
            </svg>
            <div class="col-sm-5">
                <h2 class="sec3-heading" style="color: #222751;">
                    {{__('main.ehymyz-araby1')}}
                    <br>
                    {{__('main.ehymyz-araby2')}}
                </h2>
                <p class="sec3-p mt-4">
                    {{__('main.ehymyz-araby3')}}
                </p>
            </div>
            <div class="col-sm-7 row mt-4 mt-sm-2 mt-md-0 px-0">

                <div class="col-sm-6 pr-0">
                    <div class="inner lightBox" style="min-height: 250px !important;">
                        <img src="{{asset('images/package.svg')}}">
                        <h5>{{__('main.resp')}}</h5>
                        <p>{{__('main.resp2')}}</p>
                        <a>{{__('main.viewMore')}}</a>
                    </div>
                </div>

                <svg style="position:absolute;left: 0px;top: -100px;" xmlns="http://www.w3.org/2000/svg" width="113"
                     height="120" viewBox="0 0 113 120" fill="none">
                    <path
                        d="M7.52526 119C-0.789905 94.5136 -5.96012 47.4233 39.8803 54.9528C97.1808 64.3648 83.4815 87.8588 76.9281 94.8963C72.1717 100.004 61.3651 101.398 55.9344 78.5976C50.4964 55.7661 49.0188 -11.6195 112 4.44974"
                        stroke="#FCA61F" stroke-opacity="0.4" stroke-width="3"/>
                </svg>
                <div class="col-sm-6 pr-0">
                    <div class="inner darkBox" style="min-height: 250px !important;">
                        <img src="{{asset('images/package.svg')}}">
                        <h5>{{__('main.ourprices')}}</h5>
                        <p>{{__('main.ourprices2')}}</p>
                        <a>{{__('main.viewMore')}}</a>
                    </div>
                </div>
            </div>
        </div>


        <!--second row-->
        <div class="row w-100 m-0 mt-5 justify-content-center">
            <div class="col-sm-6 row px-md-3 p-sm-1">

                <div class="col-sm-6 pl-0">
                    <div class="inner darkBox">
                        <img src="{{asset('images/package.svg')}}">
                        <h5>{{__('main.timesaver')}}</h5>
                        <p>{{__('main.timesaver2')}}</p>
                        <a>{{__('main.viewMore')}}</a>
                    </div>
                </div>

                <div class="col-sm-6 pl-0">
                    <div class="inner lightBox">
                        <img src="{{asset('images/package.svg')}}">
                        <h5>{{__('main.easy')}}</h5>
                        <p>{{__('main.easy2')}}</p>
                        <br>
                        <a>{{__('main.viewMore')}}</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 row">
                <div class="col-sm-6 pl-0">
                    <div class="inner darkBox">
                        <img src="{{asset('images/package.svg')}}">
                        <h5>{{__('main.dash')}}</h5>
                        <p>{{__('main.dash2')}}</p>
                        <br>
                        <a>{{__('main.viewMore')}}</a>
                    </div>
                </div>
                <div class="col-sm-6 pl-0">
                    <div class="inner lightBox">
                        <img src="{{asset('images/package.svg')}}">
                        <h5>{{__('main.integ')}}</h5>
                        <p>{{__('main.integ2')}}</p>
                        <a>{{__('main.viewMore')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!---===SECTION3====-->

    <!--====SECTION4====-->
    <div class="row @if(LaravelLocalization::getCurrentLocale() == 'en') flex-row-reverse @endif section4EveryThing p-5"
         style="margin-top: 150px;">
        <div class="col-sm-6 banner-content pr-4">
            <h2 class="sec3-heading">
                {{__('main.allneeded')}}
                <br>
                {{__('main.allneeded2')}}
            </h2>
            <p class="sec3-p mt-4">{{__('main.allneeded3')}}</p>
            <a class="loginBtn"
               style="@if(LaravelLocalization::getCurrentLocale() == 'en') float: left; @else float: right; @endif margin-top:20px;color: white; background: #222751; border: 1px solid #222751; border-radius: 3px; padding: 11px 39px !important;"
               href="http://arabygithub.test/ar/client/login">
                {{__('main.joinNow')}}
                <svg class="mx-1" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15"
                     fill="none">
                    <path
                        d="M13.2678 4.83467L9.82544 0.972897C9.55532 0.670005 9.189 0.499899 8.80708 0.5C8.42516 0.500101 8.05892 0.6704 7.78892 0.973435C7.51892 1.27647 7.36729 1.68742 7.36738 2.11587C7.36747 2.54432 7.51928 2.95519 7.7894 3.25808L10.1307 5.88465H1.68992C1.30803 5.88465 0.941778 6.05483 0.671742 6.35777C0.401705 6.66071 0.25 7.07158 0.25 7.5C0.25 7.92842 0.401705 8.33929 0.671742 8.64223C0.941778 8.94516 1.30803 9.11535 1.68992 9.11535H10.1307L7.7894 11.7419C7.51928 12.0448 7.36747 12.4557 7.36738 12.8841C7.36729 13.3126 7.51892 13.7235 7.78892 14.0266C8.05892 14.3296 8.42516 14.4999 8.80708 14.5C9.189 14.5001 9.55532 14.33 9.82544 14.0271L13.2678 10.1653C13.8968 9.45777 14.25 8.49927 14.25 7.5C14.25 6.50073 13.8968 5.54223 13.2678 4.83467Z"
                        fill="white"/>
                </svg>
            </a>
        </div>
        <div class="col-sm-6">
            <div class="img-viewer-app text-center mt-5">
                <svg style="position:absolute;left: -20px;top:-100px;" xmlns="http://www.w3.org/2000/svg" width="113"
                     height="120" viewBox="0 0 113 120" fill="none">
                    <path
                        d="M7.52526 119C-0.789905 94.5136 -5.96012 47.4233 39.8803 54.9528C97.1808 64.3648 83.4815 87.8588 76.9281 94.8963C72.1717 100.004 61.3651 101.398 55.9344 78.5976C50.4964 55.7661 49.0188 -11.6195 112 4.44974"
                        stroke="#FCA61F" stroke-opacity="0.4" stroke-width="3"/>
                </svg>
                <img class="img-fluid" style="width: 80%" src="{{ asset('images/sec4.png') }}">
            </div>
            <svg style="position:absolute;right: 0" xmlns="http://www.w3.org/2000/svg" width="113" height="120"
                 viewBox="0 0 113 120" fill="none">
                <path
                    d="M7.52526 119C-0.789905 94.5136 -5.96012 47.4233 39.8803 54.9528C97.1808 64.3648 83.4815 87.8588 76.9281 94.8963C72.1717 100.004 61.3651 101.398 55.9344 78.5976C50.4964 55.7661 49.0188 -11.6195 112 4.44974"
                    stroke="#FCA61F" stroke-opacity="0.4" stroke-width="3"/>
            </svg>
        </div>

    </div>
    <!--====SECTION4====-->


    <img style="bottom: -81px; position: relative; width: 104%; margin: 0; padding: 0; height: 109px;"
         src="{{asset('images/fadeFooterUpper.png')}}">
    <!--====SECTION5====-->
    <div class="row" style="background: #222751;padding-top: 70px;">


        <div class="col-sm-6">
            <div class="img-viewer-app text-center">
                <img class="img-fluid" style="max-width: 69%;" src="{{ asset('images/papper.png') }}">
            </div>
        </div>

        <div
            class="col-sm-6 banner-content @if(LaravelLocalization::getCurrentLocale() == 'en') pl-5 @else pr-4 @endif mt-5"
            style="padding-bottom:90px;">
            <h2 class="sec3-heading" style="color: white;font-size: 25px !important;">{{__('main.among')}}</h2>

            <ul class="@if(LaravelLocalization::getCurrentLocale() == 'en') text-left @else text-right @endif">
                <li class="mt-3">
                    <svg class="@if(LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                         xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
                        <path
                            d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>
                        <path
                            d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <span class="spanLiSec5">{{__('main.among2')}}</span>
                </li>
                <li class="mt-3">
                    <svg class="@if(LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                         xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
                        <path
                            d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>
                        <path
                            d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <span class="spanLiSec5">{{__('main.among3')}}</span>
                </li>

                <li class="mt-3">
                    <svg class="@if(LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                         xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
                        <path
                            d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>
                        <path
                            d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <span class="spanLiSec5">{{__('main.among4')}}</span>
                </li>
            </ul>
            <svg style="position:absolute;right: 0" xmlns="http://www.w3.org/2000/svg" width="113" height="120"
                 viewBox="0 0 113 120" fill="none">
                <path
                    d="M7.52526 119C-0.789905 94.5136 -5.96012 47.4233 39.8803 54.9528C97.1808 64.3648 83.4815 87.8588 76.9281 94.8963C72.1717 100.004 61.3651 101.398 55.9344 78.5976C50.4964 55.7661 49.0188 -11.6195 112 4.44974"
                    stroke="#FCA61F" stroke-opacity="0.4" stroke-width="3"/>
            </svg>
        </div>
    </div>
    <img style="top: -144px; position: relative; width: 106%; margin: 0; padding: 0; height: 154px;"
         src="{{asset('images/fadeFooter.png')}}">
    <!--====SECTION5====-->


    <!--====SECTION6====-->
    <div class="row">
        <div class="col-sm-5">
            <div class="img-viewer-app text-center">
                <img class="img-fluid" style="margin-top: -50px;width: 85%;" src="{{ asset('images/pc2.png') }}">
            </div>
        </div>

        <div
            class="col-sm-7 banner-content @if(LaravelLocalization::getCurrentLocale() == 'en') pl-5 @else pr-4 @endif mt-5">
            <h2 class="sec3-heading pt-5" style="color: #222751;">
                {{__('main.develop')}}
                <br>
                {{__('main.develop2')}}
            </h2>
            <svg style="position:absolute;left: 0" xmlns="http://www.w3.org/2000/svg" width="113" height="120"
                 viewBox="0 0 113 120" fill="none">
                <path
                    d="M7.52526 119C-0.789905 94.5136 -5.96012 47.4233 39.8803 54.9528C97.1808 64.3648 83.4815 87.8588 76.9281 94.8963C72.1717 100.004 61.3651 101.398 55.9344 78.5976C50.4964 55.7661 49.0188 -11.6195 112 4.44974"
                    stroke="#FCA61F" stroke-opacity="0.4" stroke-width="3"/>
            </svg>
            <ul class="@if(LaravelLocalization::getCurrentLocale() == 'en') text-left @else text-right @endif">
                <li class="mt-3">
                    <svg class="@if(LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                         xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
                        <path
                            d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>
                        <path
                            d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <span class="spanLiSec6" style="width: 91%;display: block;">{{__('main.develop3')}}</span>
                </li>
                <li class="mt-2">
                    <svg class="@if(LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                         xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
                        <path
                            d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>
                        <path
                            d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <span class="spanLiSec6">{{__('main.develop4')}}</span>
                </li>
                <li class="mt-2">
                    <svg class="@if(LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"
                         xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25" fill="none">
                        <path
                            d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"
                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>
                        <path
                            d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"
                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <span class="spanLiSec6" style="width: 91%;display: block;">{{__('main.develop5')}}</span>
                </li>
            </ul>

        </div>

    </div>
    <!--====SECTION6====-->


    <!--====SECTION7====-->
    <div class="row @if(LaravelLocalization::getCurrentLocale() == 'en') flex-row-reverse @endif"
         style="background: #F2F4FF;margin-top: 50px;padding-bottom: 110px;">
        <div class="col-12 p-0">
            <img style="position: relative; width: 106%; margin: 0; padding: 0; height: 154px;"
                 src="{{asset('images/fadeFooterUpper.png')}}">
        </div>

        <div
            class="col-sm-6 banner-content @if(LaravelLocalization::getCurrentLocale() == 'en') pl-5 @else pr-5 @endif">
            <h2 class="sec3-heading"
                style="color: #222751;font-weight:600;font-size: 25px !important;line-height: 38px;">
                {{__('main.amaraby')}}
                <br>
                {{__('main.amaraby2')}}
            </h2>
            <p class="sec3-p mt-4" style="font-size: 20px;line-height:32px; ">{{__('main.amaraby3')}}</p>

            <div class="d-flex @if(LaravelLocalization::getCurrentLocale() == 'en') justify-content-end @endif mt-2">
                <img src="{{asset('images/appstore.png')}}" width="180">
                <img src="{{asset('images/gplay.png')}}" width="180">
            </div>
        </div>

        <div class="col-sm-6 d-sm-block d-none">
            <div class="img-viewer-app text-center">
                <img class="img-fluid" style="max-width: 30%; position: absolute; bottom: -160px; right: 45px;"
                     src="{{ asset('images/phone2.png') }}">
                <img class="img-fluid" style="max-width: 30%; position: absolute; top: -50px; "
                     src="{{ asset('images/phone1.png') }}">
            </div>
        </div>

        <div class="col-12 p-0" style="margin-top: -124px;">
            <img style="bottom: -118px; position: relative; width: 106%; margin: 0; padding: 0; height: 154px;"
                 src="{{asset('images/fadeFooter.png')}}">
        </div>
    </div>
    <!--====SECTION7====-->


    <!------SECTION8 PRICE-------->
    <div class="sec8 mt-3 mb-5">
        <!--<h3 class="sec3-heading pt-5 text-center" style="color:#222751 !important;">{{__('main.ready')}}</h3>-->
        <!--<p class="text-center mt-1" style="color:#637381;font-size: 23px;">{{__('main.ready2')}}</p>-->
        <!--<div class="row p-2 m-0 justify-content-around mt-5">-->

        <!--    <div class="col-sm-4 p-3">-->
        <!--        <div class="innerSec8">-->
        <!--            <div class="sec8Title text-center p-2">-->
        <!--                <h4 style="color:#222751;font-size: 25px;font-weight: 500 !important;">{{__('main.asasi')}}</h4>-->
        <!--            </div>-->
        <!--            <ul class="@if(LaravelLocalization::getCurrentLocale() == 'en') text-left @else text-right @endif">-->
        <!--                <li class="mt-3">-->
        <!--                    <span class="spanLiSec6 h4">-->
        <!--                        {{__('main.asasi2')}}-->
        <!--                    </span>-->
        <!--                </li>-->
        <!--                <li>-->
        <!--                    <svg class="@if(LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"-->
        <!--                         xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"-->
        <!--                         fill="none">-->
        <!--                        <path-->
        <!--                            d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"-->
        <!--                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>-->
        <!--                        <path-->
        <!--                            d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"-->
        <!--                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>-->
        <!--                    </svg>-->
        <!--                    <span class="spanLiSec6">{{__('main.asasi3')}} </span>-->
        <!--                </li>-->
        <!--                <li>-->
        <!--                    <svg class="@if(LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"-->
        <!--                         xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"-->
        <!--                         fill="none">-->
        <!--                        <path-->
        <!--                            d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"-->
        <!--                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>-->
        <!--                        <path-->
        <!--                            d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"-->
        <!--                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>-->
        <!--                    </svg>-->
        <!--                    <span class="spanLiSec6">{{__('main.asasi4')}}</span>-->
        <!--                </li>-->

        <!--                <li>-->
        <!--                    <svg class="@if(LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"-->
        <!--                         xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"-->
        <!--                         fill="none">-->
        <!--                        <path-->
        <!--                            d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"-->
        <!--                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>-->
        <!--                        <path-->
        <!--                            d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"-->
        <!--                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>-->
        <!--                    </svg>-->
        <!--                    <span class="spanLiSec6">{{__('main.asasi5')}}</span>-->

        <!--                </li>-->
        <!--                <li>-->
        <!--                    <svg class="@if(LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"-->
        <!--                         xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"-->
        <!--                         fill="none">-->
        <!--                        <path-->
        <!--                            d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"-->
        <!--                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>-->
        <!--                        <path-->
        <!--                            d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"-->
        <!--                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>-->
        <!--                    </svg>-->
        <!--                    <span class="spanLiSec6">{{__('main.asasi6')}}</span>-->

        <!--                </li>-->
        <!--                <li>-->
        <!--                    <svg class="@if(LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"-->
        <!--                         xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"-->
        <!--                         fill="none">-->
        <!--                        <path-->
        <!--                            d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"-->
        <!--                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>-->
        <!--                        <path-->
        <!--                            d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"-->
        <!--                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>-->
        <!--                    </svg>-->
        <!--                    <span class="spanLiSec6">{{__('main.asasi7')}}</span>-->

        <!--                </li>-->
        <!--                <li>-->
        <!--                    <a class="subscriptNow">{{__('main.asasi8')}}</a>-->
        <!--                </li>-->
        <!--            </ul>-->
        <!--        </div>-->
        <!--    </div>-->


        <!--    <div class="col-sm-4 p-3">-->
        <!--        <div class="innerSec8" style="background: #222751;transform: scale(1.06);">-->
        <!--            <div class="sec8Title text-center p-2">-->
        <!--                <h4 style="color:white;font-size: 25px;font-weight: 500 !important;">{{__('main.advanced1')}}</h4>-->
        <!--            </div>-->
        <!--            <ul class="@if(LaravelLocalization::getCurrentLocale() == 'en') text-left @else text-right @endif">-->
        <!--                <li class="mt-3">-->
        <!--                    <span class="spanLiSec6 h4"-->
        <!--                          style="color:rgba(255,255,255,0.75);">{{__('main.advanced2')}}</span>-->
        <!--                </li>-->
        <!--                <li>-->
        <!--                    <svg class="@if(LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"-->
        <!--                         xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"-->
        <!--                         fill="none">-->
        <!--                        <path-->
        <!--                            d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"-->
        <!--                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>-->
        <!--                        <path-->
        <!--                            d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"-->
        <!--                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>-->
        <!--                    </svg>-->
        <!--                    <span class="spanLiSec6"-->
        <!--                          style="color:rgba(255,255,255,0.75);width: 91%;display: block">{{__('main.advanced3')}}</span>-->
        <!--                </li>-->
        <!--                <li>-->
        <!--                    <svg class="@if(LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"-->
        <!--                         xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"-->
        <!--                         fill="none">-->
        <!--                        <path-->
        <!--                            d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"-->
        <!--                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>-->
        <!--                        <path-->
        <!--                            d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"-->
        <!--                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>-->
        <!--                    </svg>-->
        <!--                    <span class="spanLiSec6"-->
        <!--                          style="color:rgba(255,255,255,0.75);">{{__('main.asasi4')}}</span>-->
        <!--                </li>-->

        <!--                <li>-->
        <!--                    <svg class="@if(LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"-->
        <!--                         xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"-->
        <!--                         fill="none">-->
        <!--                        <path-->
        <!--                            d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"-->
        <!--                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>-->
        <!--                        <path-->
        <!--                            d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"-->
        <!--                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>-->
        <!--                    </svg>-->
        <!--                    <span class="spanLiSec6" style="color:rgba(255,255,255,0.75);">{{__('main.asasi5')}}</span>-->

        <!--                </li>-->
        <!--                <li>-->
        <!--                    <svg class="@if(LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"-->
        <!--                         xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"-->
        <!--                         fill="none">-->
        <!--                        <path-->
        <!--                            d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"-->
        <!--                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>-->
        <!--                        <path-->
        <!--                            d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"-->
        <!--                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>-->
        <!--                    </svg>-->
        <!--                    <span class="spanLiSec6" style="color:rgba(255,255,255,0.75);">{{__('main.asasi6')}}</span>-->

        <!--                </li>-->
        <!--                <li>-->
        <!--                    <svg class="@if(LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"-->
        <!--                         xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"-->
        <!--                         fill="none">-->
        <!--                        <path-->
        <!--                            d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"-->
        <!--                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>-->
        <!--                        <path-->
        <!--                            d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"-->
        <!--                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>-->
        <!--                    </svg>-->
        <!--                    <span class="spanLiSec6" style="color:rgba(255,255,255,0.75);">{{__('main.asasi7')}}</span>-->
        <!--                </li>-->
        <!--                <li>-->
        <!--                    <a class="subscriptNow2">{{__('main.asasi8')}}</a>-->
        <!--                </li>-->
        <!--            </ul>-->
        <!--        </div>-->
        <!--    </div>-->


        <!--    <div class="col-sm-4 p-3">-->
        <!--        <div class="innerSec8">-->
        <!--            <div class="sec8Title text-center p-2">-->
        <!--                <h4 style="color:#222751;font-size: 25px;font-weight: 500 !important;">{{__('main.inclusive1')}}</h4>-->
        <!--            </div>-->
        <!--            <ul class="@if(LaravelLocalization::getCurrentLocale() == 'en') text-left @else text-right @endif">-->
        <!--                <li class="mt-3">-->
        <!--                    <span class="spanLiSec6 h4">{{__('main.inclusive2')}}</span>-->
        <!--                </li>-->
        <!--                <li>-->
        <!--                    <svg class="@if(LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"-->
        <!--                         xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"-->
        <!--                         fill="none">-->
        <!--                        <path-->
        <!--                            d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"-->
        <!--                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>-->
        <!--                        <path-->
        <!--                            d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"-->
        <!--                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>-->
        <!--                    </svg>-->
        <!--                    <span class="spanLiSec6" style="width: 91%;display: block">{{__('main.inclusive3')}}</span>-->
        <!--                </li>-->
        <!--                <li>-->
        <!--                    <svg class="@if(LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"-->
        <!--                         xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"-->
        <!--                         fill="none">-->
        <!--                        <path-->
        <!--                            d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"-->
        <!--                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>-->
        <!--                        <path-->
        <!--                            d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"-->
        <!--                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>-->
        <!--                    </svg>-->
        <!--                    <span class="spanLiSec6">{{__('main.asasi4')}}</span>-->
        <!--                </li>-->

        <!--                <li>-->
        <!--                    <svg class="@if(LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"-->
        <!--                         xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"-->
        <!--                         fill="none">-->
        <!--                        <path-->
        <!--                            d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"-->
        <!--                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>-->
        <!--                        <path-->
        <!--                            d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"-->
        <!--                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>-->
        <!--                    </svg>-->
        <!--                    <span class="spanLiSec6">{{__('main.asasi5')}}</span>-->

        <!--                </li>-->
        <!--                <li>-->
        <!--                    <svg class="@if(LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"-->
        <!--                         xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"-->
        <!--                         fill="none">-->
        <!--                        <path-->
        <!--                            d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"-->
        <!--                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>-->
        <!--                        <path-->
        <!--                            d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"-->
        <!--                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>-->
        <!--                    </svg>-->
        <!--                    <span class="spanLiSec6">{{__('main.asasi6')}}</span>-->

        <!--                </li>-->
        <!--                <li>-->
        <!--                    <svg class="@if(LaravelLocalization::getCurrentLocale() == 'en') float-left mr-1 @endif"-->
        <!--                         xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"-->
        <!--                         fill="none">-->
        <!--                        <path-->
        <!--                            d="M12.1563 21.5C14.2385 21.5 16.2563 20.778 17.8659 19.457C19.4754 18.1361 20.5771 16.2979 20.9833 14.2557C21.3895 12.2136 21.0751 10.0937 20.0935 8.25737C19.112 6.42104 17.5241 4.98187 15.6004 4.18506C13.6766 3.38825 11.5362 3.28311 9.54364 3.88756C7.55111 4.492 5.8298 5.76863 4.673 7.49992C3.51621 9.23121 2.9955 11.31 3.19961 13.3822C3.40371 15.4544 4.32 17.3917 5.79234 18.864"-->
        <!--                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>-->
        <!--                        <path-->
        <!--                            d="M16.1562 10.5L12.5583 14.818C11.9033 15.604 11.5752 15.998 11.1342 16.018C10.6942 16.038 10.3313 15.675 9.60725 14.951L8.15625 13.5"-->
        <!--                            stroke="#DF8317" stroke-width="2" stroke-linecap="round"/>-->
        <!--                    </svg>-->
        <!--                    <span class="spanLiSec6">{{__('main.asasi7')}}</span>-->

        <!--                </li>-->
        <!--                <li>-->
        <!--                    <a class="subscriptNow">{{__('main.asasi8')}}</a>-->
        <!--                </li>-->
        <!--            </ul>-->
        <!--        </div>-->
        <!--    </div>-->

        <!--</div>-->
    </div>
    <!------SECTION8-------->
    <br>
    <br>
    <!------SECTION9-------->
    <div class="sec8 col-sm-8 col-11 mx-auto mt-5 mb-3">

        <h3 class="sec3-heading pt-5 text-center mb-3"
            style="font-size: 38px;font-weight:bold;background: linear-gradient(180deg, #222751 0%, rgba(103, 111, 178, 0.83) 100%); background-clip: text; -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            <svg style="position: absolute; left: -41px; top: 8px;" xmlns="http://www.w3.org/2000/svg" width="96"
                 height="99" viewBox="0 0 96 99" fill="none">
                <path
                    d="M34.9093 -6.25611e-05C30.3249 -6.27615e-05 25.7855 0.902884 21.5501 2.65723C17.3148 4.41158 13.4664 6.98296 10.2248 10.2246C6.98321 13.4662 4.41182 17.3145 2.65747 21.5499C0.903124 25.7853 0.000177202 30.3247 0.000177002 34.909L34.9093 34.909L34.9093 -6.25611e-05Z"
                    fill="#DF8317"/>
                <path
                    d="M61.0909 28.3632C56.5066 28.3632 51.9671 29.2662 47.7318 31.0205C43.4964 32.7749 39.6481 35.3462 36.4065 38.5879C33.1648 41.8295 30.5935 45.6778 28.8391 49.9132C27.0848 54.1485 26.1818 58.688 26.1818 63.2723L61.0909 63.2723L61.0909 28.3632Z"
                    fill="#3734A9"/>
            </svg>
            {{__('main.discount1')}}
        </h3>
        <p class="text-center mt-1" style="color:#637381;font-size: 22px;">
            {{__('main.discount2')}}
            <br>
            {{__('main.discount3')}}
        </p>
        <div class="row col-sm-10 mx-auto mt-5" style="flex-wrap: nowrap;">
            <input type="text" placeholder="{{__('main.email')}}" name="email" class="form-control"
                   style="background: rgba(208, 209, 216, 0.30); backdrop-filter: blur(5px); height: 65px; border-radius: 0; width: 179%;">
            <button style="background: #222751; height: 65px; border-radius: 0;">{{__('main.send')}}</button>
        </div>
        <svg
            style="right: -50px; position: relative;@if(LaravelLocalization::getCurrentLocale() == 'en') float:right; @endif"
            xmlns="http://www.w3.org/2000/svg" width="97" height="100"
            viewBox="0 0 97 100" fill="none">
            <path
                d="M62.0714 98.3006C66.6544 98.1923 71.1713 97.1825 75.3641 95.3286C79.5568 93.4747 83.3434 90.8132 86.5075 87.4959C89.6717 84.1787 92.1515 80.2707 93.8053 75.9951C95.4592 71.7195 96.2547 67.16 96.1465 62.5769L61.2471 63.4012L62.0714 98.3006Z"
                fill="#DF8317"/>
            <path
                d="M35.0653 69.9473C39.6497 69.9473 44.1891 69.0444 48.4245 67.29C52.6598 65.5357 56.5082 62.9643 59.7498 59.7227C62.9914 56.4811 65.5628 52.6327 67.3171 48.3974C69.0715 44.162 69.9744 39.6226 69.9744 35.0382L35.0653 35.0382L35.0653 69.9473Z"
                fill="#3734A9"/>
        </svg>
    </div>
    <!------SECTION8-------->
    <br>
    <br>

    <!------SECTION9-------->
    <div class="sec8 col-sm-9 col-11 mb-1 mx-auto ">

        <h3 class="sec3-heading pt-1 text-center mb-3"
            style="font-size: 38px;font-weight:bold;background: linear-gradient(180deg, #222751 0%, rgba(103, 111, 178, 0.83) 100%); background-clip: text; -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            {{__('main.people')}}
        </h3>

        <div class="row mx-auto mt-5" style="flex-wrap: nowrap;">
            <div class="col-4">
                <img class="img-fluid" style="z-index: 99999; position: relative; background: #e8f2fa;"
                     src="{{asset('images/user.png')}}">
            </div>
            <div class="col-8 text-right">
                <br>
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="28" viewBox="0 0 32 28" fill="none">
                    <path
                        d="M31.5 0.735244L30.7177 6.35821C29.153 6.22668 27.8817 6.48974 26.9038 7.1474C25.9259 7.77217 25.2413 8.69289 24.8502 9.90956C24.4916 11.0933 24.4264 12.4744 24.6546 14.0528H31.5V27.469H18.2003V14.0528C18.2003 9.31767 19.2923 5.73344 21.4763 3.30011C23.6604 0.833894 27.0016 -0.0210611 31.5 0.735244ZM13.7997 0.735244L13.0173 6.35821C11.4527 6.22668 10.1814 6.48974 9.20347 7.1474C8.22555 7.77217 7.54101 8.69289 7.14984 9.90956C6.79127 11.0933 6.72608 12.4744 6.95426 14.0528H13.7997V27.469H0.5V14.0528C0.5 9.31767 1.59201 5.73344 3.77603 3.30011C5.96004 0.833894 9.30126 -0.0210611 13.7997 0.735244Z"
                        fill="#FF7F5C"/>
                </svg>
                <br>
                <br>

                <svg xmlns="http://www.w3.org/2000/svg" width="146" height="30" viewBox="0 0 146 30" fill="none">
                    <path
                        d="M14.0489 3.39605C14.3483 2.47474 15.6517 2.47473 15.9511 3.39604L18.0309 9.79726C18.1648 10.2093 18.5488 10.4882 18.982 10.4882L25.7126 10.4882C26.6814 10.4882 27.0841 11.7279 26.3004 12.2973L20.8552 16.2534C20.5047 16.5081 20.3581 16.9594 20.4919 17.3715L22.5718 23.7727C22.8712 24.694 21.8167 25.4601 21.033 24.8907L15.5878 20.9346C15.2373 20.6799 14.7627 20.6799 14.4122 20.9346L8.96701 24.8907C8.1833 25.4601 7.12882 24.694 7.42817 23.7727L9.50805 17.3715C9.64193 16.9594 9.49527 16.5081 9.14478 16.2534L3.69958 12.2973C2.91586 11.7279 3.31864 10.4882 4.28736 10.4882L11.018 10.4882C11.4512 10.4882 11.8352 10.2093 11.9691 9.79726L14.0489 3.39605Z"
                        fill="#F9896B"/>
                    <path
                        d="M43.0489 3.39605C43.3483 2.47474 44.6517 2.47473 44.9511 3.39604L47.0309 9.79726C47.1648 10.2093 47.5488 10.4882 47.982 10.4882L54.7126 10.4882C55.6814 10.4882 56.0841 11.7279 55.3004 12.2973L49.8552 16.2534C49.5047 16.5081 49.3581 16.9594 49.4919 17.3715L51.5718 23.7727C51.8712 24.694 50.8167 25.4601 50.033 24.8907L44.5878 20.9346C44.2373 20.6799 43.7627 20.6799 43.4122 20.9346L37.967 24.8907C37.1833 25.4601 36.1288 24.694 36.4282 23.7727L38.5081 17.3715C38.6419 16.9594 38.4953 16.5081 38.1448 16.2534L32.6996 12.2973C31.9159 11.7279 32.3186 10.4882 33.2874 10.4882L40.018 10.4882C40.4512 10.4882 40.8352 10.2093 40.9691 9.79726L43.0489 3.39605Z"
                        fill="#F9896B"/>
                    <path
                        d="M72.0489 3.39605C72.3483 2.47474 73.6517 2.47473 73.9511 3.39604L76.0309 9.79726C76.1648 10.2093 76.5488 10.4882 76.982 10.4882L83.7126 10.4882C84.6814 10.4882 85.0841 11.7279 84.3004 12.2973L78.8552 16.2534C78.5047 16.5081 78.3581 16.9594 78.4919 17.3715L80.5718 23.7727C80.8712 24.694 79.8167 25.4601 79.033 24.8907L73.5878 20.9346C73.2373 20.6799 72.7627 20.6799 72.4122 20.9346L66.967 24.8907C66.1833 25.4601 65.1288 24.694 65.4282 23.7727L67.5081 17.3715C67.6419 16.9594 67.4953 16.5081 67.1448 16.2534L61.6996 12.2973C60.9159 11.7279 61.3186 10.4882 62.2874 10.4882L69.018 10.4882C69.4512 10.4882 69.8352 10.2093 69.9691 9.79726L72.0489 3.39605Z"
                        fill="#F9896B"/>
                    <path
                        d="M101.049 3.39605C101.348 2.47474 102.652 2.47473 102.951 3.39604L105.031 9.79726C105.165 10.2093 105.549 10.4882 105.982 10.4882L112.713 10.4882C113.681 10.4882 114.084 11.7279 113.3 12.2973L107.855 16.2534C107.505 16.5081 107.358 16.9594 107.492 17.3715L109.572 23.7727C109.871 24.694 108.817 25.4601 108.033 24.8907L102.588 20.9346C102.237 20.6799 101.763 20.6799 101.412 20.9346L95.967 24.8907C95.1833 25.4601 94.1288 24.694 94.4282 23.7727L96.5081 17.3715C96.6419 16.9594 96.4953 16.5081 96.1448 16.2534L90.6996 12.2973C89.9159 11.7279 90.3186 10.4882 91.2874 10.4882L98.018 10.4882C98.4512 10.4882 98.8352 10.2093 98.9691 9.79726L101.049 3.39605Z"
                        fill="#F9896B"/>
                    <path
                        d="M130.049 3.39605C130.348 2.47474 131.652 2.47473 131.951 3.39604L134.031 9.79726C134.165 10.2093 134.549 10.4882 134.982 10.4882L141.713 10.4882C142.681 10.4882 143.084 11.7279 142.3 12.2973L136.855 16.2534C136.505 16.5081 136.358 16.9594 136.492 17.3715L138.572 23.7727C138.871 24.694 137.817 25.4601 137.033 24.8907L131.588 20.9346C131.237 20.6799 130.763 20.6799 130.412 20.9346L124.967 24.8907C124.183 25.4601 123.129 24.694 123.428 23.7727L125.508 17.3715C125.642 16.9594 125.495 16.5081 125.145 16.2534L119.7 12.2973C118.916 11.7279 119.319 10.4882 120.287 10.4882L127.018 10.4882C127.451 10.4882 127.835 10.2093 127.969 9.79726L130.049 3.39605Z"
                        fill="#F9896B"/>
                </svg>
                <br>
                <br>

                <p style="color: #1B1C31; text-align: right; font-family: Cairo; font-size: 25px; font-style: normal; font-weight: 400; line-height: 41px; /* 136.667% */ letter-spacing: -0.6px;">{{__('main.people1')}}</p>
                <br>
                <br>
                <div class="userDet">
                    <p style="color: #111C55; font-family: Cairo; font-size: 20px; font-style: normal; font-weight: 700; line-height: 30px; /* 150% */ letter-spacing: -0.6px;">{{__('main.people2')}}</p>
                    <p style="color: #757095; font-family: Poppins; font-size: 16px; font-style: normal; font-weight: 500; line-height: 24px; /* 150% */ letter-spacing: -0.32px;">{{__('main.people3')}}</p>
                </div>
            </div>
        </div>
        <div class="d-md-block d-none"
             style="width: 134px; height: 134px; border-radius: 267px; background: #DF8317; top: -92px; position: relative; z-index: 5; right: -37px;">
        </div>
    </div>
    <!------SECTION9-------->
@endsection
<script src="{{ asset('app-js/jquery.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('.play-btn').on('click', function () {
            $('.overlays').show();
            $('body').css('overflow', 'hidden');
            $('#myvideo').get(0).play();
        });
        $('.remove_layout').on('click', function () {
            $('.overlays').hide();
            $('body').css('overflow', 'auto');
            $('#myvideo').get(0).pause();
            $('#myvideo').get(0).currentTime = 0;
        });
    });
</script>
