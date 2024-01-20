<!DOCTYPE html>
<html>
<head>
    <title>aimbgo.com</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <style type="text/css">
        span.im {
            color: #000 !important;
        }
    </style>
</head>
<body style="margin:0; padding:0;">
<section class="main_wrapper " style="background:#efefef; padding:15px 30px; max-width:980px; margin:0 auto; font-family: 'Roboto', sans-serif !important; ">
    <article class="inner_wrapper " style="background:#fff;padding:20px; margin:5px 0; ">
        <div class="header " style="background:#E1F0F8; padding:10px; ">
            <table>
                <tr>
                    <td width="60% ">
                        Click here to reset your password <br>
                        <a href="{{ route('BACKEND-FORM-PROCESS-FORGOT-PASSWORD', $passwordToken) }}">{{ route('BACKEND-FORM-PROCESS-FORGOT-PASSWORD', $passwordToken) }}</a>
                    </td>
                    <td>
                        <h3 style="margin:0; text-align:right; ">September Shell</h3>

                    </td>
                </tr>
            </table>
        </div>

    </article>
    <h3 style="text-align:center;">Thank you, <a href="{{ route('BACKEND-LOGIN') }}" target="_blank" style="text-decoration:none; ">{{config('app.name')}}</a></h3>
</section>
</body>

</html>
