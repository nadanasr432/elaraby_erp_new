<!DOCTYPE html>
<html class="loading" lang="{{ LaravelLocalization::getCurrentLocale() }}">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <!--
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <title> Mooazna </title>
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    @include('site.layouts.common.css_links')
    <style>
        @font-face {
            font-family: 'Cairo';
            src: url("{{ asset('fonts/Cairo.ttf') }}");
        }

        .menu a.active {
            color: #E0A93D;
            /* Highlight color for active link */
            font-weight: bold;
        }

        .footer-section a.active {
            color: #E0A93D;
            /* Highlight color for active footer link */
            font-weight: bold;
        }

        body,
        html {
            font-family: 'Cairo' !important;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        span {
            font-family: 'Cairo' !important;
        }

        .dropdown-item {
            font-size: 14px !important;
        }

        @media screen and (max-width: 992px) {
            .loginBtnAni {
                min-width: 125px !important;
            }

            .partSpan {
                width: 42% !important;
            }

            .fadeBottom {
                width: 186% !important;
            }

            .footer-top {
                display: block !important;
            }

            ul.social-icons {
                display: flex !important;
                justify-content: center !important;
            }

            ul.links {
                display: flex;
                justify-content: center;
            }

            .footer-bottom .left {
                margin-bottom: 25px;
                margin-right: 13%;
                font-size: 14px;
            }
        }

        .registerBtn {
            border: 1px solid white;
            border-radius: 5px;
            padding: 5px 12px !important;
        }

        .loginBtn {
            border: 1px solid #E0A93D;
            border-radius: 5px;
            padding: 5px 12px !important;
            background: #E0A93D;
            transition: all 0.2s ease-in-out;
        }

        .subscribNow {
            border: 1px solid #E0A93D;
            color: #E0A93D !important;
            border-radius: 5px;
            padding: 5px 12px !important;
            background: none;
        }

        @if (LaravelLocalization::getCurrentLocale() == 'ar')

        @else
            .subscribNow {
                float: left;
            }
        @endif
    </style>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-206753129-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());
        gtag('config', 'UA-206753129-1');
    </script>
    <meta name="facebook-domain-verification" content="zlq809za71vnn8lrol6xpfyif2ge02" />

    <!-- Facebook Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '4421747707915385');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=4421747707915385&ev=PageView&noscript=1" /></noscript>
    <!-- End Facebook Pixel Code -->

</head>

<body
    @if (LaravelLocalization::getCurrentLocale() == 'ar') style="direction:rtl;text-align:right"
    @else style="direction:ltr;text-align:left" @endif>

    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>




    <div class="overlay"></div>
    <a href="#0" class="scrollToTop pt-2">
        <i class="fa fa-angle-up" style="font-size: 26px;"></i>
    </a>


    <header class="header-section" style="background: rgba(0, 0, 0, 0.055);">

        <div class="header-wrapper pr-5 pl-5" style="@if (LaravelLocalization::getCurrentLocale() == 'en') direction: ltr; @endif">
            <div class="logo text-center">
                <a class="text-center" href="{{ route('index') }}">
                    @if (empty($system->profile->profile_pic))
                        <img style="height: 65px;margin-top: 10px; margin-bottom: 10px;"
                            src="{{ asset('images/logo.png') }}" alt="logo">
                    @else
                        <img style="height: 55px;margin-top: 10px; margin-bottom: 10px;"
                            src="{{ asset($system->profile->profile_pic) }}" alt="logo">
                    @endif
                </a>
                <br>
            </div>

            <!--pages list -home -contact ... -->
            <ul style="@if (LaravelLocalization::getCurrentLocale() == 'en') direction: ltr; @endif" class="menu">
                <li>
                    <a class="{{ request()->routeIs('index') ? 'active' : '' }}" href="{{ route('index') }}">
                        {{ __('main.home') }}
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                        {{ __('main.features') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('index') }}#invoice">
                        {{ __('main.einvoice') }}
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
                        {{ __('main.contact-us') }}
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('privacy') ? 'active' : '' }}" href="{{ route('privacy') }}">
                        {{ __('main.privacy') }}
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('terms_conditions') ? 'active' : '' }}"
                        href="{{ route('terms_conditions') }}">
                        {{ __('main.terms') }}
                    </a>
                </li>
            </ul>


            <!--actions list-- login register lang-->
            <ul style="@if (LaravelLocalization::getCurrentLocale() == 'en') direction: ltr; @endif" class="menu actionsBtn">


                @if (!auth()->guard('client-web')->check())
                    <li>
                        <a class="registerBtn loginBtnAni" href="{{ route('index3') }}">
                            {{ __('main.register') }}
                        </a>
                    </li>

                    <li>
                        <a class="loginBtn" href="{{ route('client.login') }}">
                            {{ __('main.login') }}
                        </a>
                    </li>
                @else
                    <li>
                        <a class="loginBtn" href="{{ route('client.home') }}">
                            {{ __('main.home') }}
                        </a>
                    </li>
                @endif

                <li>
                    @if (LaravelLocalization::getCurrentLocale() == 'ar')
                        <a href="{{ LaravelLocalization::getLocalizedURL('en') }}">
                            <img src="https://img.icons8.com/color/30/000000/great-britain.png" />
                            {{ __('main.english') }}
                        </a>
                    @else
                        <a href="{{ LaravelLocalization::getLocalizedURL('ar') }}">
                            <img src="https://img.icons8.com/color/30/000000/saudi-arabia.png" />
                            {{ __('main.arabic') }}
                        </a>
                    @endif
                </li>
            </ul>


            <div class="header-bar d-lg-none">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>

    </header>


    @yield('content')

    <div class="modal fade" id="offerModal" tabindex="-1" aria-labelledby="offerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!--<div class="modal-header">-->
                <!--    <h5 class="modal-title" id="offerModalLabel">Special Offer</h5>-->
                <!--    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
                <!--</div>-->
                <!--<div class="modal-body text-center">-->
                <img src="{{ asset('images/offer.jpg') }}" alt="Offer Image" width="100%">
                <!--</div>-->
                <div class="modal-footer">
                    <button type="button" style="background-color:#E0A93D !important" class="btn btn-primary"
                        data-bs-dismiss="modal">@lang('main.close')</button>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer-section"
        style="background: linear-gradient(180deg, #20779C 0%, #065272 100%);padding-top: 213px;clip-path: polygon(0 0, 0% 20%, 0 53%, 0 100%, 18% 100%, 50% 100%, 100% 100%, 100% 80%, 100% 0, 64% 24%, 100% 38%, 100% 37%);">
        <div class="filled-area"
            style=" background: linear-gradient(180deg, #E0A93D 0%, #C89531 100%);
            clip-path: polygon( 100% 0, 64% 24%, 100% 38%, 100% 37%);">
        </div>
        <div class="container">
            <div class="footer-top pb-4 @if (LaravelLocalization::getCurrentLocale() == 'en') flex-row-reverse @endif">
                <div
                    class="col-md-4 mt-5 mb-0 pl-0 logo @if (LaravelLocalization::getCurrentLocale() == 'en') text-left @else text-right @endif">
                    <a href="{{ route('index') }}">
                        @if (empty($system->profile->profile_pic))
                            <img style="width: 80px!important;height: 80px!important;"
                                src="{{ asset('images/logo.png') }}" alt="footer">
                        @else
                            <img style="width: 80px!important;height: 80px!important;"
                                src="{{ asset($system->profile->profile_pic) }}" alt="footer">
                        @endif
                    </a>
                    <br>
                    <br>
                    <p style="color: #FFF; font-size: 16px; font-weight: 300; line-height: 30px;">
                        {{ __('main.footer1') }}
                        <br>
                        {{ __('main.footer2') }}
                        <br>
                        {{ __('main.footer3') }}
                    </p>
                    <div class="d-flex justify-content-center">
                        <!-- Instagram -->
                        <a href="https://www.instagram.com/encryption_world2030" target="_blank" class="mx-2">
                            <i class="fab fa-instagram"
                                style=" font-size: x-large !important;color:#C89531 !important"></i>
                        </a>
                        <!-- X (Twitter) -->
                        <a href="https://www.twitter.com/Encryption2030" target="_blank" class="mx-2">
                            <i class="fa-brands fa-x-twitter fa-rotate-180"
                                style=" font-size: x-large !important;color:#C89531 !important"></i>
                        </a>
                        <!-- Facebook -->
                        <a href="https://www.facebook.com/profile.php?id=61572326990398" target="_blank"
                            class="mx-2">
                            <i class="fab fa-facebook-f"
                                style=" font-size: x-large !important;color:#C89531 !important"></i>
                        </a>
                        <!-- Placeholder for other -->
                        <!--<a href="#" target="_blank" class="btn btn-outline-secondary mx-2">-->
                        <!--    <i class="fas fa-plus"></i> Other-->
                        <!--</a>-->
                    </div>
                </div>

                <div class="col-md-2 mt-5 p-0 logo">
                    <p style="color: #FFF; font-size: 16px; font-weight: 300; line-height: 30px;">
                        {{ __('main.footer4') }}
                        <img style="width: 35%; display: block; margin-right: 7px; @if (LaravelLocalization::getCurrentLocale() == 'en') left: 0; position: absolute; @endif"
                            src="{{ asset('images/zigzag.png') }}">
                    </p>
                    <br>
                    <ul class="mt-0">
                        <li style="margin-top: -40px;">
                            <a class="pt-2 {{ request()->routeIs('index') ? 'active' : '' }}"
                                href="{{ route('index') }}"
                                style="color: #FFF; font-size: 16px; font-weight: 300; line-height: 30px;">
                                <img class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-2 @else ml-1 @endif"
                                    @if (LaravelLocalization::getCurrentLocale() == 'en') style="transform: rotate(181deg); @endif " src="{{ asset('images/mask.png') }}">
                {{ __('main.home') }}
            </a>
        </li>
        <li>
            <a class="pt-1" href="{{ route('index') }}#pricing"
                style="color: #FFF; font-size: 16px; font-weight: 300; line-height: 30px;">
                <img class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-2 @else ml-1 @endif"
                    @if (LaravelLocalization::getCurrentLocale() == 'en') style="transform: rotate(181deg); @endif "
                                    src="{{ asset('images/mask.png') }}">
                                {{ __('main.pricing') }}
                            </a>
                        </li>
                        <li>
                            <a class="pt-1" href="{{ route('index') }}#services"
                                style="color: #FFF; font-size: 16px; font-weight: 300; line-height: 30px;">
                                <img class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-2 @else ml-1 @endif"
                                    @if (LaravelLocalization::getCurrentLocale() == 'en') style="transform: rotate(181deg); @endif " src="{{ asset('images/mask.png') }}">
                {{ __('main.services') }}
            </a>
        </li>
        <li>
            <a class="pt-1 {{ request()->routeIs('terms_conditions') ? 'active' : '' }}" target="_blank" href="{{ route('terms_conditions') }}"
                style="color: #FFF; font-size: 16px; font-weight: 300; line-height: 30px;">
                <img class="@if (LaravelLocalization::getCurrentLocale() == 'en') float-left mr-2 @else ml-1 @endif"
                    @if (LaravelLocalization::getCurrentLocale() == 'en') style="transform: rotate(181deg); @endif "
                                    src="{{ asset('images/mask.png') }}">
                                {{ __('main.terms') }}
                            </a>
                        </li>
                    </ul>
                </div>


                <div class="footer-bottom">
                    <p class="links d-block text-center text-white" dir="rtl"
                        style="color:#f57c00; padding-right: 50px;">
                        {{ __('main.platform-copyright') }}
                        {{ app()->getLocale() == 'en' ? 'world encryptionerp' : '                    شركة عالم التشفير ' }}

                </div>
            </div>
    </footer>
    @include('site.layouts.common.js_links')
</body>

</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"
    integrity="sha512-Eak/29OTpb36LLo2r47IpVzPBLXnAMPAVypbSZiZ4Qkf8p/7S/XRG5xp7OKWPPYfJT6metI+IORkR5G8F900+g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        // Check if the current URL matches https://worldencryptionerp.com
        if (window.location.href === "https://worldencryptionerp.com/ar" || window.location.href ===
            "https://worldencryptionerp.com/en") {
            $('#offerModal').modal('show');
        }

    });
</script>
