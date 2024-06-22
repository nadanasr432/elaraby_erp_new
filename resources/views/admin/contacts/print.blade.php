<!DOCTYPE html>
<html>
<head>
    <title>
        طباعة الرسالة
    </title>
    <meta charset="utf-8"/>
    <link rel="icon" href="{{asset($system->profile->profile_pic)}}" type="image/png">
    <link href="{{asset('app-assets/css-rtl/bootstrap.min.css')}}" rel="stylesheet"/>
    <style>
        @font-face {
            font-family: 'Cairo';
            src: url("{{asset('fonts/Cairo.ttf')}}");
        }

        body, html {
            font-family: 'Cairo';
            font-size: 15px;
        }

        i.la {
            font-size: 15px !important;
        }

        select.form-control {
            padding: 0 5px !important;
        }
    </style>
    <style type="text/css" media="screen">
        body, html {
            font-family: 'Cairo';
        }

        .table-container {
            width: 50%;
            margin: 10px auto;
        }

        .no-print {
            position: fixed;
            bottom: 0;
            right: 30px;
            border-radius: 0;
            z-index: 9999;
        }

    </style>
    <style type="text/css" media="print">
        body, html {
            font-family: 'Cairo';
            -webkit-print-color-adjust: exact !important;
            -moz-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            -o-print-color-adjust: exact !important;
        }

        .no-print {
            display: none;
        }

        .img-footer {
            position: fixed;
            bottom: 0;
        }
    </style>
</head>
<body style="background: #fff">
<table class="table table-bordered table-container text-right" @if(App::getLocale()=='ar') dir="rtl" @endif>
    <thead>
    <tr class="text-center">
        <td><img src="{{asset($system->profile->profile_pic)}}" class="w-50" alt=""></td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="thisTD p-3"> الاسم :
            {{$message->name}}</td>
    </tr>
    <tr>
        <td class="thisTD p-3">رقم الهاتف :
            {{$message->phone}}</td>
    </tr>
    <tr>
        <td class="thisTD p-3">الموضوع :
            {{$message->subject}}</td>
    </tr>
    <tr>
        <td class="thisTD p-3">الرسالة : <br>
            <hr class="w-50"> {{$message->message}}</td>
    </tr>
    </tbody>
    <tfoot>
    <tr>
        <td class="thisTD p-3">وقت الرسالة :
            {{$message->created_at->diffForHumans()}}</td>
    </tr>
    </tfoot>
</table>
<button onclick="window.print();" class="no-print btn btn-md btn-success">طباعة</button>
<a href="{{route('admin.contacts.index')}}" style="margin-right:110px;"
   class="no-print btn btn-md btn-danger"> عودة الى الرسائل  </a>
</body>
</html>
