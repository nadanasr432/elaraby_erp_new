<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">
<head>
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <meta name="description" content="{{$system->name}}"/>
    <meta name="keywords" content="{{$system->name}}"/>
    <title>{{$system->name}}</title>
    <link rel="icon" href="{{asset('app-assets/images/favicon.ico')}}" type="image/png">
    @include('client.layouts.common.css_links')

    <style type="text/css" media="print">
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                -moz-print-color-adjust: exact;
                print-color-adjust: exact;
                -o-print-color-adjust: exact;
            }

            .no-print {
                display: none;
            }

            .printy {
                display: block !important;
            }
        }
    </style>
    <style>
        .img-icon {
            width: 15px;
            height: 15px;
            margin-left: 10px;
        }

        @font-face {
            font-family: 'Cairo';
            src: url("{{asset('fonts/Cairo.ttf')}}");
        }

        label {
            font-size: 14px !important;
        }

        table {
            font-size: 13px !important;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Cairo' !important;
        }

        .dropdown-menu.dropdown-menu-right.show {
            width: 200px !important;
        }

        body, html {
            font-family: 'Cairo' !important;
            font-size: 13px !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .navigation.navigation-main {
            padding-bottom: 50px !important;
        }

        .alarm-upgrade {
            font-family: 'Cairo' !important;
            font-size: 14px;
        }

        .btn.dropdown-toggle.bs-placeholder, .btn.dropdown-toggle {
            height: 40px !important;
        }
    </style>
    <style>
        .section {
            background: #f5f5f5;
            min-height: 500px !important;
            border: 1px solid #f5f5f5;
            margin: 0px;
        }

        button.no-print {
            position: fixed;
            bottom: 0;
            width: 300px !important;
            right: 10px;
            border-radius: 0;
            z-index: 9999;
            /*font-size:12px!important;*/
        }

        .btn {
            border-radius: 0 !important;
        }

        .section .category {
            height: auto;
            padding: 10px;
            font-size: 14px;
            color: #222;
            border: 1px solid #ddd;
        }

        .section .category:hover {
            background: orangered;
            color: #fff !important;
        }

        .section .category label {
            border: 1px solid #888;
            text-align: center;
            margin: 10px auto !important;
            border-radius: 100%;
            padding: 5px 10px;
            width: 30px;
            height: 30px;
        }

        div.product {
            font-size: 11px;
            width: 100% !important;
            border: 1px solid #0A3551;
            color: #0A3551;
            border-radius: 10px;
            height: auto;
            padding: 5px;
            margin-bottom: 10px;
        }

        div.product:hover {
            cursor: pointer;
            color: #fff;
        }

        div.product img {
            height: 50px !important;

        }

        #product_id {
            width: 90% !important;
        }

        .pending {
            width: 100%;
            text-align: center;
            height: 200px;
            color: #fff !important;
            font-size: 13px !important;
        }

        .pending .slice {
            display: block;
            margin-bottom: 10px;
        }

        .app-content.content {
            display: none;
        }

        .loader {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: inline-block;
            position: relative;
            border: 3px solid;
            border-color: #6ce386 #6ce386 transparent transparent;
            box-sizing: border-box;
            animation: rotation 1s linear infinite;
            margin: auto;
            top: 45%;
            position: relative;
            right: 47vw;
        }

        .loader::after,
        .loader::before {
            content: '';
            box-sizing: border-box;
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            margin: auto;
            border: 3px solid;
            border-color: transparent transparent #FF3D00 #FF3D00;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            box-sizing: border-box;
            animation: rotationBack 0.5s linear infinite;
            transform-origin: center center;

        }

        .loader::before {
            width: 32px;
            height: 32px;
            border-color: #0A246A #0A246A transparent transparent;
            animation: rotation 1.5s linear infinite;
        }

        @keyframes rotation {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes rotationBack {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(-360deg);
            }
        }

    </style>
    <!-----sweetalert------>
    <script src="{{asset('/')}}../js/sweetalert.min.js"></script>
</head>

<body>
<span class="loader"></span>
<div class="app-content content">
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="height: 59px;background: #0A246A !important;">
        <a class="navbar-brand" href="{{route('client.home')}}">
            <img src="{{asset('images/logo.png')}}" class="img-fluid"
                 style="width: 39px; display: block; margin: auto;">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav" style="height: 52px;align-items: flex-start;">

                <li class="nav-item active">
                    <a class="d-flex navbar-brand text-white text-center mt-1 pb-2 mb-2" href="{{route('client.home')}}"
                       style="font-size: 14px !important;margin-right: 8px;border-bottom: 1px solid rgba(255,255,255,0.12)">
                        <svg width="18" style="margin-left: 10px;" viewBox="0 0 25 24" fill="white"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M13.874 0.504193C13.5027 0.180408 13.011 0 12.5 0C11.989 0 11.4973 0.180408 11.126 0.504193L1.438 8.94852C1.14136 9.20741 0.905164 9.51942 0.743873 9.86546C0.582582 10.2115 0.499597 10.5843 0.500001 10.9609V21.235C0.500532 21.9685 0.816836 22.6718 1.37939 23.1903C1.94194 23.7088 2.7047 24 3.5 24H6.5C7.29565 24 8.05871 23.7085 8.62132 23.1896C9.18393 22.6707 9.5 21.967 9.5 21.2332V16.6218C9.5 16.3772 9.60536 16.1426 9.7929 15.9697C9.98043 15.7967 10.2348 15.6996 10.5 15.6996H14.5C14.7652 15.6996 15.0196 15.7967 15.2071 15.9697C15.3946 16.1426 15.5 16.3772 15.5 16.6218V21.2332C15.5 21.967 15.8161 22.6707 16.3787 23.1896C16.9413 23.7085 17.7044 24 18.5 24H21.5C22.2956 24 23.0587 23.7085 23.6213 23.1896C24.1839 22.6707 24.5 21.967 24.5 21.2332V10.9591C24.4999 10.5826 24.4164 10.2101 24.2548 9.86439C24.0932 9.51868 23.8568 9.20703 23.56 8.94852L13.874 0.500503V0.504193Z"
                                fill="#3D3DFF"/>
                            <path
                                d="M13.874 0.504193C13.5027 0.180408 13.011 0 12.5 0C11.989 0 11.4973 0.180408 11.126 0.504193L1.438 8.94852C1.14136 9.20741 0.905164 9.51942 0.743873 9.86546C0.582582 10.2115 0.499597 10.5843 0.500001 10.9609V21.235C0.500532 21.9685 0.816836 22.6718 1.37939 23.1903C1.94194 23.7088 2.7047 24 3.5 24H6.5C7.29565 24 8.05871 23.7085 8.62132 23.1896C9.18393 22.6707 9.5 21.967 9.5 21.2332V16.6218C9.5 16.3772 9.60536 16.1426 9.7929 15.9697C9.98043 15.7967 10.2348 15.6996 10.5 15.6996H14.5C14.7652 15.6996 15.0196 15.7967 15.2071 15.9697C15.3946 16.1426 15.5 16.3772 15.5 16.6218V21.2332C15.5 21.967 15.8161 22.6707 16.3787 23.1896C16.9413 23.7085 17.7044 24 18.5 24H21.5C22.2956 24 23.0587 23.7085 23.6213 23.1896C24.1839 22.6707 24.5 21.967 24.5 21.2332V10.9591C24.4999 10.5826 24.4164 10.2101 24.2548 9.86439C24.0932 9.51868 23.8568 9.20703 23.56 8.94852L13.874 0.500503V0.504193Z"
                                fill="#7777FF"/>
                            <path
                                d="M13.874 0.504193C13.5027 0.180408 13.011 0 12.5 0C11.989 0 11.4973 0.180408 11.126 0.504193L1.438 8.94852C1.14136 9.20741 0.905164 9.51942 0.743873 9.86546C0.582582 10.2115 0.499597 10.5843 0.500001 10.9609V21.235C0.500532 21.9685 0.816836 22.6718 1.37939 23.1903C1.94194 23.7088 2.7047 24 3.5 24H6.5C7.29565 24 8.05871 23.7085 8.62132 23.1896C9.18393 22.6707 9.5 21.967 9.5 21.2332V16.6218C9.5 16.3772 9.60536 16.1426 9.7929 15.9697C9.98043 15.7967 10.2348 15.6996 10.5 15.6996H14.5C14.7652 15.6996 15.0196 15.7967 15.2071 15.9697C15.3946 16.1426 15.5 16.3772 15.5 16.6218V21.2332C15.5 21.967 15.8161 22.6707 16.3787 23.1896C16.9413 23.7085 17.7044 24 18.5 24H21.5C22.2956 24 23.0587 23.7085 23.6213 23.1896C24.1839 22.6707 24.5 21.967 24.5 21.2332V10.9591C24.4999 10.5826 24.4164 10.2101 24.2548 9.86439C24.0932 9.51868 23.8568 9.20703 23.56 8.94852L13.874 0.500503V0.504193Z"
                                fill="black"/>
                            <path
                                d="M13.874 0.504193C13.5027 0.180408 13.011 0 12.5 0C11.989 0 11.4973 0.180408 11.126 0.504193L1.438 8.94852C1.14136 9.20741 0.905164 9.51942 0.743873 9.86546C0.582582 10.2115 0.499597 10.5843 0.500001 10.9609V21.235C0.500532 21.9685 0.816836 22.6718 1.37939 23.1903C1.94194 23.7088 2.7047 24 3.5 24H6.5C7.29565 24 8.05871 23.7085 8.62132 23.1896C9.18393 22.6707 9.5 21.967 9.5 21.2332V16.6218C9.5 16.3772 9.60536 16.1426 9.7929 15.9697C9.98043 15.7967 10.2348 15.6996 10.5 15.6996H14.5C14.7652 15.6996 15.0196 15.7967 15.2071 15.9697C15.3946 16.1426 15.5 16.3772 15.5 16.6218V21.2332C15.5 21.967 15.8161 22.6707 16.3787 23.1896C16.9413 23.7085 17.7044 24 18.5 24H21.5C22.2956 24 23.0587 23.7085 23.6213 23.1896C24.1839 22.6707 24.5 21.967 24.5 21.2332V10.9591C24.4999 10.5826 24.4164 10.2101 24.2548 9.86439C24.0932 9.51868 23.8568 9.20703 23.56 8.94852L13.874 0.500503V0.504193Z"
                                fill="white"/>
                        </svg>
                        الرئيسية
                    </a>
                </li>

                <li class="nav-item">
                    <a class="d-flex navbar-brand text-white text-center mt-1 pb-2 mb-2" target="_blank"
                       href="{{ route('pos.sales.report') }}"
                       style="font-size: 14px !important;margin-right: 11px;border-bottom: 1px solid rgba(255,255,255,0.12)">
                        <svg style="position: relative; top: -3px; margin-left: 6px;" fill="white" width="20"
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path
                                d="M326.3 218.8c0 20.5-16.7 37.2-37.2 37.2h-70.3v-74.4h70.3c20.5 0 37.2 16.7 37.2 37.2zM504 256c0 137-111 248-248 248S8 393 8 256 119 8 256 8s248 111 248 248zm-128.1-37.2c0-47.9-38.9-86.8-86.8-86.8H169.2v248h49.6v-74.4h70.3c47.9 0 86.8-38.9 86.8-86.8z"/>
                        </svg>
                        الفئات والمنتجات
                    </a>
                </li>

                <li class="nav-item">
                    <a class="d-flex navbar-brand text-white text-center mt-1 pb-2 mb-2" target="_blank"
                       href="{{ route('pos.sales.report') }}"
                       style="font-size: 14px !important;margin-right: 11px;border-bottom: 1px solid rgba(255,255,255,0.12)">
                        <svg width="20" style="position: relative; top: -3px; margin-left: 6px;" height="24"
                             viewBox="0 0 25 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M17.3198 2H7.67982C5.54982 2 3.81982 3.74 3.81982 5.86V19.95C3.81982 21.75 5.10982 22.51 6.68982 21.64L11.5698 18.93C12.0898 18.64 12.9298 18.64 13.4398 18.93L18.3198 21.64C19.8998 22.52 21.1898 21.76 21.1898 19.95V5.86C21.1798 3.74 19.4498 2 17.3198 2ZM15.5098 9.75C14.5398 10.1 13.5198 10.28 12.4998 10.28C11.4798 10.28 10.4598 10.1 9.48982 9.75C9.09982 9.61 8.89982 9.18 9.03982 8.79C9.18982 8.4 9.61982 8.2 10.0098 8.34C11.6198 8.92 13.3898 8.92 14.9998 8.34C15.3898 8.2 15.8198 8.4 15.9598 8.79C16.0998 9.18 15.8998 9.61 15.5098 9.75Z"
                                fill="#3D3DFF"/>
                            <path
                                d="M17.3198 2H7.67982C5.54982 2 3.81982 3.74 3.81982 5.86V19.95C3.81982 21.75 5.10982 22.51 6.68982 21.64L11.5698 18.93C12.0898 18.64 12.9298 18.64 13.4398 18.93L18.3198 21.64C19.8998 22.52 21.1898 21.76 21.1898 19.95V5.86C21.1798 3.74 19.4498 2 17.3198 2ZM15.5098 9.75C14.5398 10.1 13.5198 10.28 12.4998 10.28C11.4798 10.28 10.4598 10.1 9.48982 9.75C9.09982 9.61 8.89982 9.18 9.03982 8.79C9.18982 8.4 9.61982 8.2 10.0098 8.34C11.6198 8.92 13.3898 8.92 14.9998 8.34C15.3898 8.2 15.8198 8.4 15.9598 8.79C16.0998 9.18 15.8998 9.61 15.5098 9.75Z"
                                fill="#7777FF"/>
                            <path
                                d="M17.3198 2H7.67982C5.54982 2 3.81982 3.74 3.81982 5.86V19.95C3.81982 21.75 5.10982 22.51 6.68982 21.64L11.5698 18.93C12.0898 18.64 12.9298 18.64 13.4398 18.93L18.3198 21.64C19.8998 22.52 21.1898 21.76 21.1898 19.95V5.86C21.1798 3.74 19.4498 2 17.3198 2ZM15.5098 9.75C14.5398 10.1 13.5198 10.28 12.4998 10.28C11.4798 10.28 10.4598 10.1 9.48982 9.75C9.09982 9.61 8.89982 9.18 9.03982 8.79C9.18982 8.4 9.61982 8.2 10.0098 8.34C11.6198 8.92 13.3898 8.92 14.9998 8.34C15.3898 8.2 15.8198 8.4 15.9598 8.79C16.0998 9.18 15.8998 9.61 15.5098 9.75Z"
                                fill="black"/>
                            <path
                                d="M17.3198 2H7.67982C5.54982 2 3.81982 3.74 3.81982 5.86V19.95C3.81982 21.75 5.10982 22.51 6.68982 21.64L11.5698 18.93C12.0898 18.64 12.9298 18.64 13.4398 18.93L18.3198 21.64C19.8998 22.52 21.1898 21.76 21.1898 19.95V5.86C21.1798 3.74 19.4498 2 17.3198 2ZM15.5098 9.75C14.5398 10.1 13.5198 10.28 12.4998 10.28C11.4798 10.28 10.4598 10.1 9.48982 9.75C9.09982 9.61 8.89982 9.18 9.03982 8.79C9.18982 8.4 9.61982 8.2 10.0098 8.34C11.6198 8.92 13.3898 8.92 14.9998 8.34C15.3898 8.2 15.8198 8.4 15.9598 8.79C16.0998 9.18 15.8998 9.61 15.5098 9.75Z"
                                fill="white"/>
                        </svg>
                        الفواتير السابقة
                    </a>
                </li>
                <li class="nav-item">
                    <a class="d-flex navbar-brand text-white text-center mt-1 pb-2 mb-2" target="_blank"
                       href="{{ route('pos.sales.report') }}"
                       style="font-size: 14px !important;margin-right: 11px;border-bottom: 1px solid rgba(255,255,255,0.12)">
                        <svg width="20" style="position: relative; top: -3px; margin-left: 6px;" height="24"
                             viewBox="0 0 25 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M17.3198 2H7.67982C5.54982 2 3.81982 3.74 3.81982 5.86V19.95C3.81982 21.75 5.10982 22.51 6.68982 21.64L11.5698 18.93C12.0898 18.64 12.9298 18.64 13.4398 18.93L18.3198 21.64C19.8998 22.52 21.1898 21.76 21.1898 19.95V5.86C21.1798 3.74 19.4498 2 17.3198 2ZM15.5098 9.75C14.5398 10.1 13.5198 10.28 12.4998 10.28C11.4798 10.28 10.4598 10.1 9.48982 9.75C9.09982 9.61 8.89982 9.18 9.03982 8.79C9.18982 8.4 9.61982 8.2 10.0098 8.34C11.6198 8.92 13.3898 8.92 14.9998 8.34C15.3898 8.2 15.8198 8.4 15.9598 8.79C16.0998 9.18 15.8998 9.61 15.5098 9.75Z"
                                fill="#3D3DFF"/>
                            <path
                                d="M17.3198 2H7.67982C5.54982 2 3.81982 3.74 3.81982 5.86V19.95C3.81982 21.75 5.10982 22.51 6.68982 21.64L11.5698 18.93C12.0898 18.64 12.9298 18.64 13.4398 18.93L18.3198 21.64C19.8998 22.52 21.1898 21.76 21.1898 19.95V5.86C21.1798 3.74 19.4498 2 17.3198 2ZM15.5098 9.75C14.5398 10.1 13.5198 10.28 12.4998 10.28C11.4798 10.28 10.4598 10.1 9.48982 9.75C9.09982 9.61 8.89982 9.18 9.03982 8.79C9.18982 8.4 9.61982 8.2 10.0098 8.34C11.6198 8.92 13.3898 8.92 14.9998 8.34C15.3898 8.2 15.8198 8.4 15.9598 8.79C16.0998 9.18 15.8998 9.61 15.5098 9.75Z"
                                fill="#7777FF"/>
                            <path
                                d="M17.3198 2H7.67982C5.54982 2 3.81982 3.74 3.81982 5.86V19.95C3.81982 21.75 5.10982 22.51 6.68982 21.64L11.5698 18.93C12.0898 18.64 12.9298 18.64 13.4398 18.93L18.3198 21.64C19.8998 22.52 21.1898 21.76 21.1898 19.95V5.86C21.1798 3.74 19.4498 2 17.3198 2ZM15.5098 9.75C14.5398 10.1 13.5198 10.28 12.4998 10.28C11.4798 10.28 10.4598 10.1 9.48982 9.75C9.09982 9.61 8.89982 9.18 9.03982 8.79C9.18982 8.4 9.61982 8.2 10.0098 8.34C11.6198 8.92 13.3898 8.92 14.9998 8.34C15.3898 8.2 15.8198 8.4 15.9598 8.79C16.0998 9.18 15.8998 9.61 15.5098 9.75Z"
                                fill="black"/>
                            <path
                                d="M17.3198 2H7.67982C5.54982 2 3.81982 3.74 3.81982 5.86V19.95C3.81982 21.75 5.10982 22.51 6.68982 21.64L11.5698 18.93C12.0898 18.64 12.9298 18.64 13.4398 18.93L18.3198 21.64C19.8998 22.52 21.1898 21.76 21.1898 19.95V5.86C21.1798 3.74 19.4498 2 17.3198 2ZM15.5098 9.75C14.5398 10.1 13.5198 10.28 12.4998 10.28C11.4798 10.28 10.4598 10.1 9.48982 9.75C9.09982 9.61 8.89982 9.18 9.03982 8.79C9.18982 8.4 9.61982 8.2 10.0098 8.34C11.6198 8.92 13.3898 8.92 14.9998 8.34C15.3898 8.2 15.8198 8.4 15.9598 8.79C16.0998 9.18 15.8998 9.61 15.5098 9.75Z"
                                fill="white"/>
                        </svg>
                        التقارير
                    </a>
                </li>
                <li class="nav-item">
                    <a class="d-flex navbar-brand text-white text-center mt-1 pb-2 mb-2" target="_blank"
                       href="{{ route('pos.sales.report') }}"
                       style="font-size: 14px !important;margin-right: 11px;border-bottom: 1px solid rgba(255,255,255,0.12)">
                        <svg style="position: relative; top: -3px; margin-left: 6px;" fill="white" width="12"
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                            <path
                                d="M48 64C21.5 64 0 85.5 0 112V400c0 26.5 21.5 48 48 48H80c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48H48zm192 0c-26.5 0-48 21.5-48 48V400c0 26.5 21.5 48 48 48h32c26.5 0 48-21.5 48-48V112c0-26.5-21.5-48-48-48H240z"></path>
                        </svg>
                        الفواتير المعلقة
                    </a>
                </li>
                <li class="nav-item">
                    <a class="d-flex navbar-brand text-white text-center mt-1 pb-2" target="_blank"
                       href="{{ route('pos.settings') }}"
                       style="font-size: 14px !important;margin-right: 5px;border-bottom: 1px solid rgba(255,255,255,0.12)">
                        <svg width="19" style="position: relative; top: -3px; margin-left: 6px;" viewBox="0 0 25 24"
                             fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M2.10682 18C2.93398 19.4356 4.76834 19.9288 6.20393 19.1017C6.20491 19.1011 6.20585 19.1005 6.20684 19.1L6.65182 18.843C7.49182 19.5616 8.45735 20.119 9.4998 20.487V21C9.4998 22.6568 10.843 24 12.4998 24C14.1566 24 15.4998 22.6568 15.4998 21V20.487C16.5424 20.1184 17.508 19.5604 18.3478 18.841L18.7948 19.099C20.2307 19.9274 22.0664 19.4349 22.8948 17.999C23.7232 16.563 23.2308 14.7274 21.7948 13.899L21.3508 13.643C21.5507 12.5554 21.5507 11.4405 21.3508 10.353L21.7948 10.097C23.2307 9.26855 23.7232 7.43292 22.8948 5.99695C22.0664 4.56103 20.2308 4.06852 18.7948 4.89694L18.3498 5.15395C17.509 4.43616 16.5428 3.87984 15.4998 3.513V3C15.4998 1.34316 14.1566 0 12.4998 0C10.843 0 9.4998 1.34316 9.4998 3V3.513C8.45721 3.88158 7.49163 4.43958 6.65182 5.15902L6.20482 4.90003C4.76885 4.07156 2.93323 4.56408 2.1048 6C1.27638 7.43592 1.76885 9.27159 3.20482 10.1L3.64882 10.356C3.44895 11.4435 3.44895 12.5584 3.64882 13.646L3.20482 13.902C1.77284 14.7326 1.28196 16.5647 2.10682 18ZM12.4998 8.00002C14.7089 8.00002 16.4998 9.79088 16.4998 12C16.4998 14.2091 14.7089 16 12.4998 16C10.2907 16 8.49982 14.2091 8.49982 12C8.49982 9.79088 10.2907 8.00002 12.4998 8.00002Z"
                                fill="white"/>
                        </svg>
                        الاعدادات
                    </a>
                </li>
                <li class="nav-item dropdown d-none">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                       aria-expanded="false">
                        Dropdown link
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    @yield('content')
</div>
@include('client.layouts.common.js_links')
</body>
</html>
