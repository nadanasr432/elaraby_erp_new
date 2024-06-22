<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body
    style="box-sizing: border-box; font-family:'Cairo'; position: relative; -webkit-text-size-adjust: none; background-color: #ffffff; color: #718096; height: 100%; line-height: 1.4; margin: 0; padding: 0; width: 100% !important;">
<style>
    @media only screen and (max-width: 600px) {
        .inner-body {
            width: 100% !important;
        }

        .footer {
            width: 100% !important;
        }
    }

    @media only screen and (max-width: 500px) {
        .button {
            width: 100% !important;
        }
    }
</style>

<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation"
       style="box-sizing: border-box; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; background-color: #edf2f7; margin: 0; padding: 0; width: 100%;">
    <!-- Email Body -->
    <tr>
        <td class="body" width="100%" cellpadding="0" cellspacing="0"
            style="box-sizing: border-box; font-family: 'Cairo'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; background-color: #edf2f7; border-bottom: 1px solid #edf2f7; border-top: 1px solid #edf2f7; margin: 0; padding: 0; width: 100%;">
            <table class="inner-body" width="570" cellpadding="0" cellspacing="0"
                   role="presentation"
                   style="box-sizing: border-box; font-family: 'Cairo'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 570px; background-color: #ffffff; border-color: #e8e5ef; border-radius: 2px; border-width: 1px; box-shadow: 0 2px 0 rgba(0, 0, 150, 0.025), 2px 4px 0 rgba(0, 0, 150, 0.015); margin: 0 auto; padding: 0; width: 570px;">
                <!-- Body content -->
                <tr>
                    <td class="content-cell"
                        style="box-sizing: border-box; font-family: 'Cairo'; position: relative; max-width: 100vw; padding: 32px;">
                        <div style="width: 90%; height: 30px; padding: 10px; background: #0d3349; color:#fff; font-family: 'Cairo';
                            font-size: 16px; margin: 10px auto; border-radius: 5px;"> رسالة من
                            {{$system->name}}
                        </div>
                        <h1 style="box-sizing: border-box; font-family: 'Cairo';
                        position: relative; color: #3d4852; font-size: 18px;
                        font-weight: bold; margin-top: 0; text-align: right;">
                            {{$data['subject']}} </h1>
                        <p style="box-sizing: border-box; font-family: 'Cairo'; position: relative;
                        font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: right;">
                            من فضلك اقرا محتوى الرسالة جيدا</p>
                        <table class="action" width="100%" cellpadding="0" cellspacing="0"
                               role="presentation"
                               style="box-sizing: border-box; font-family: 'Cairo'; position: relative; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%; margin: 30px auto; padding: 0; width: 100%;">
                            <tr>
                                <td
                                    style="box-sizing: border-box; font-family: 'Cairo'; position: relative;">
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0"
                                           role="presentation" align="right" dir="rtl"
                                           style="box-sizing: border-box; font-family: 'Cairo'; position: relative;">
                                        <tr>
                                            <td
                                                style="box-sizing: border-box; font-family: 'Cairo'; position: relative;">
                                                <table border="0" cellpadding="0" cellspacing="0"
                                                       role="presentation"
                                                       style="box-sizing: border-box; font-family: 'Cairo';
                                                       position: relative;">
                                                    <tr>
                                                        <td style="box-sizing: border-box;
                                                        font-family: 'Cairo'; position: relative;text-align: center;">
                                                            <p style="text-align: center;">{{$data['body']}}</p>
                                                            <p style="text-align: center;">
                                                                اضغط على هذا الرابط من فضلك للاطلاع على كشف الحساب
                                                                <br>
                                                                {{$data['url']}}
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <p style="box-sizing: border-box; font-family: 'Cairo'; position: relative;
                        font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: right;">
                            اذا كنت تعتقد انها رسالة وهمية او مزيفة .. قم بتجاهلها </p>

                        <p style="box-sizing: border-box; font-family: 'Cairo'; position: relative; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: right;">
                            مع خالص التحيات,<br>
                            {{$system->name}} </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
