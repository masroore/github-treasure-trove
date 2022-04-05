<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width" initial-scale="1">
    <meta name="x-apple-disable-message-reformatting">
    <style>
        html,
        body {
            width: 100% !important;
            height: 100% !important;
            margin: 0;
            padding: 0;
        }

        body {
            background: #F5F5F5;
        }

        *,
        *:after,
        *:before {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        @media screen and (max-width: 620px) {
            .letter {
                width: 100%;
            }

            .letter-content {
                padding-left: 15px !important;
                padding-right: 15px !important;
            }

            .letter-button {
                width: 100% !important;
            }
        }
    </style>
</head>

<body>
<table width="100%" align="center" height="100%" border="0" cellpadding="0" cellspacing="0" data-mobile="true">
    <tr>
        <td valign="top" align="center" style="padding:0;margin:0;">
            <table class="letter" style="max-width:600px;padding-top: 50px; padding-bottom: 50px;" align="center"
                   border="0" cellspacing="0" cellpadding="0">
                @yield('content')
            </table>
        </td>
    </tr>
</table>
</body>

</html>
