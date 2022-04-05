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
                        <a href="https://xtremereflection.app"> <img src="https://xtremereflection.app/assets/img/Logo1.png" width="400px" height="100px" alt="XtremeReflectionLog"> </a>
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
                        <h2>Below is information and the estimate you requested</h2>
                    </td>
                </tr>

                <tr>
                    <td>
                        <p> {{$estimate->customer->firstName ?? ''}} {{$estimate->customer->lastName ?? ''}} I hope this email finds you well </p>

                        <p>You have requested a quote from us to have your vehicle detailed, we are pleased to provide you with this information. If you do not mind to review the enclosed pricing and info, if you are pleased with the estimate click the approve button at the bottom of this email or you can reply back approved. </p>

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
            <table class="content" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
                <tr>
                    <td>
                        <h3>Estimate</h3>
                    </td>
                    <td></td>
                </tr>

                <tr>
                    <td>
                        <table class="content" width="100%" cellpadding="0" cellspacing="0" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 0; padding: 0; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
                            <tr>
                                <th>Package #</th>
                                <th>Description</th>
                                <th>List Price</th>
                                <th>Your Price</th>
                                <th>Deposit</th>
                            </tr>
                            @foreach($estimate->packages as $packages)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td width="50%">
                                        <h6>{{$packages->package->description}}</h6>
                                        {!! $packages->package->details !!}
                                    </td>
                                    <td>${{$packages->listPrice ?? ''}}</td>
                                    <td>${{$packages->chargedPrice ?? ''}}</td>
                                    <td>${{$packages->deposit ?? ''}}</td>
                                </tr>
                            @endforeach
                        </table>
                    </td>

                </tr>

            </table>
        </td>
    </tr>
    <tr>
        <td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 25px 0;">
            This estimate is not a contract or a bill. It is our best guess at the total price to complete the work started above. Based upon our initial inspection or
            conversation, if prices change or additional parts and labor are required, we will inform you prior to proceeding with the work. Some estimates require security
            deposits at the time of accepting the estimate. Your estimate is valid for 15 days. Please refer to our cancellation policy for more information about security
            deposit refunds.

        </td>
    </tr>

    <tr>
        <td align="center" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; padding: 25px 0;">
            <a href="https://xtremereflection.app/estimate/customerReview/{{$estimate->id}}"><button class="btn-primary btn-block"> Click Here To Accept One Of These Packages</button></a>
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
