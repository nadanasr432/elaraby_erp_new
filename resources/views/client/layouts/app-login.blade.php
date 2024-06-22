<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$system->name}}</title>
    <link rel="icon" type="image/png" href="{{asset('images/icons/favicon.ico')}}"/>
    <link rel="apple-touch-icon" href="{{asset('app-assets/images/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('app-assets/images/favicon.ico')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/bootstrap.css')}}">
    <link href="{{asset('app-assets/css-rtl/bootstrap-select.css')}}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="{{asset('css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/main.css')}}">
    <style>
        @font-face {
            font-family: 'Cairo';
            src: url("{{asset('fonts/Cairo.ttf')}}");
        }
        body, html {
            font-family: 'Cairo' !important;
        }
        h1,h2,h3,h4,h5,h6,p{
            font-family: 'Cairo' !important;
        }
        .pull-right{
            float: right !important;
        }
        .pull-left{
            float: left !important;
        }
        .text-right{
            text-align: right !important;
        }
        .text-left{
            text-align: left !important;
        }
        .form-control , .form-control:hover ,.form-control:focus{
            border: 1px solid #ccc !important;
        }
        .btn.dropdown-toggle.bs-placeholder , .bootstrap-select ,.form-control,select{
            height: 40px !important;
            color: #000 !important;
        }
    </style>
</head>
<body>
<div id="app">
    <main class="">
        @yield('content')
    </main>
</div>
<script src="{{asset('app-assets/js/vendors.min.js')}}" type="text/javascript"></script>
<script src="{{asset('app-assets/js/bootstrap-select.js')}}" type="text/javascript"></script>
<script src="{{asset('js/main.js')}}"></script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
    $(function () {
        $('#example-table').DataTable({});
    });
    $(".alert.alert-success.alert-dismissable").fadeTo(2000, 5000).slideUp(500);
    $(function () {
        $('#summernote').summernote();
        $('.note-popover').css({
            'display': 'none'
        });
    });
</script>
</body>
</html>
