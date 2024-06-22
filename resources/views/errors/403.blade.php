<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width initial-scale=1.0">
    <title> 403 Error </title>
    <!-- GLOBAL MAINLY STYLES-->
    <link href="{{asset('app-assets/css-rtl/bootstrap.min.css')}}" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="{{asset('app-assets/css-rtl/main.css')}}" rel="stylesheet" />
    <style>
        .content {
            max-width: 450px;
            margin: 0 auto;
            text-align: center;
        }
        .content h1 {
            font-size: 160px
        }
        .error-title {
            font-size: 22px;
            font-weight: 500;
            margin-top: 30px
        }
    </style>
</head>
<body class="bg-silver-100">
<div class="content">
    <h1 class="m-t-20">403</h1>
    <p class="error-title">Access Denied</p>
    <p class="m-b-20">You Are Not Authorized ...  Check Privileges and try Again
        <a class="color-green" href="{{route('index')}}">Go homepage</a> or try the search bar below.</p>
    <form action="javascript:;">
        <div class="input-group">
            <input class="form-control" type="text" placeholder="Search for page">
            <div class="input-group-btn">
                <button class="btn btn-success" type="button">Search</button>
            </div>
        </div>
    </form>
</div>

<!-- END PAGA BACKDROPS-->
<!-- CORE PLUGINS -->
<script src="{{asset('app-assets/js/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('app-assets/js/bootstrap.min.js')}}" type="text/javascript"></script>
<!-- CORE SCRIPTS-->
<script src="{{asset('app-assets/js/app.js')}}" type="text/javascript"></script>
</body>
</html>
