<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; background: black; color: white; height: 100%; hyphens: auto; line-height: 1.4; margin: 0; -moz-hyphens: auto; -ms-word-break: break-all; width: 100% !important; -webkit-hyphens: auto; -webkit-text-size-adjust: none; word-break: break-word;">
<style>
    @media  only screen and (max-width: 600px) {
        .inner-body {
            width: 100% !important;
        }

        .footer {
            width: 100% !important;
        }
    }

    @media  only screen and (max-width: 500px) {
        .button {
            width: 100% !important;
        }
    }
</style>

<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
    <tr>
        <td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 25px 0; text-align: center;">
            <table class="content" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
                <tr>
                    <td>
                        <a href="https://xtremereflection.app"> <img src="{{$estimate->company->logo }}" width="400px" height="100px" alt="XtremeReflectionLog"> </a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 25px 0; text-align: center;">
            <table class="content" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
                <tr>
                    <td>
                        <a href="https://systemx.com"><img src="https://xtremereflection.app/assets/img/systemxlogo.png" width="200px" height="100px" alt="SystemXLogo"></a>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
    <tr>
        <td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 25px 0;">
            <table class="content" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">

                <tr>
                    <td>
                        <p> {{$estimate->customer->firstName ?? ''}} {{$estimate->customer->lastName ?? ''}} I hope this email finds you well </p>

                        <p>You have approved your estimate with Xtreme Reflection @if($estimate->ndp) through National Detail Pro's. Your payment information and details can be obtained through NDP at www.nationaldetailpros.com @else . Please find attached job estimate that you approved. Should you have any question please contact us at any time. @endif</p>

                        <p>
                            Our specialists are certified in applying SystemX ceramic coatings, after providing your vehicle with a like-new shine upgrade your detail with a ceramic coating.
                            Our System X Pro™ is an ultra hydrophobic ceramic coating for automotive paint with up to 6 years continued protection. Pro™ is semi-permanent 9H self-cleaning
                            ceramic with high gloss. This could save you as much as $1000 over the next 6 years. Studies show that the average auto consumer is keeping their vehicle for
                            11 years. Why not protect your vehicle with these benefits.
                        </p>

                        <h3>Why choose ceramic over wax???</h3>
                        <ul>
                            <li>Longer lasting protection.</li>
                            <li>Protection from harmful UV Rays.</li>
                            <li>Protection from Chemical Stains.</li>
                            <li>Hydrophobic Nature, Ease of Cleaning.</li>
                            <li>Candy Like Gloss.</li>
                            <li>Added Protection from Scratches and Swirl Marks.</li>
                            <li>Protection from water spotting.</li>

                        </ul>
                    </td>

                </tr>

            </table>
        </td>
    </tr>

    <tr>
        <td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 25px 0;">
            <div class="row">
                <h4>Approved Package Name: {{$estimate->acceptedPackage->package->description ?? ''}}</h4>
            </div>
            <div class="row">
                <small>Services Included: @foreach($estimate->acceptedPackage->package->items as $item) {{$item->desc->description ?? ''}} Package @if($loop->last) . @else , @endif @endforeach</small>
            </div>
        </td>
    </tr>


    <tr>
        <td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 25px 0; text-align: center;">
            <table class="content" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
                <tr>
                    <td>
                        <img src="https://xtremereflection.app/assets/img/systemxtrmess.png" alt="SystemXLogo">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 25px 0; text-align: center;" >
            <table class="content" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
                <tr>
                    <td>
                        <img src="https://xtremereflection.app/assets/img/seadoo.png" width="200px" height="200px" alt="SystemXLogo">                    </td>
                    <td>
                        <img src="https://xtremereflection.app/assets/img/plane.png" width="200px" height="200px" alt="SystemXLogo">
                    </td>
                    <td>
                        <img src="https://xtremereflection.app/assets/img/rims.png" width="200px" height="200px" alt="SystemXLogo">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 25px 0; text-align: center;" >
            <table class="content" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
                <tr>
                    <td>
                        <img src="https://xtremereflection.app/assets/img/systemx2.png" alt="SystemXLogo">
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html>
