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
                        <p> {{$wo->estimate->customer->firstName ?? ''}} {{$wo->estimate->customer->lastName ?? ''}} I hope this email finds you well </p>

                        <p>Vehicle Information</p>
                        <ul>
                            <li>Year:{{$wo->estimate->vehicle->vehicleInfo->year ?? ''}}</li>
                            <li>Make:{{$wo->estimate->vehicle->vehicleInfo->make ?? ''}}</li>
                            <li>Model:{{$wo->estimate->vehicle->vehicleInfo->model ?? ''}}</li>
                            <li>VIN:{{$wo->estimate->vehicle->vehicleInfo->vin ?? ''}}</li>
                        </ul>

                        <p>We would like to thank you for your allowing us to complete the services on your vehicle.
                        We sincerely hope you are pleased with the work that was completed.</p>

                        <p>If you would not rate us a 5 out of 5 stars we want to hear about it and make things right. Xtreme Reflection will settle for nothing less than the best.</p>

                        <p>Please if you are not satisfied 100% contact us so we can help you. </p>

                        @if($wo->estimate->customer->company->googleReview )
                        <p>If you could please take a moment and head over to our google page and drop us a quick review.</p>

                        <p><a href="{{$wo->estimate->customer->company->googleReview ?? ''}}"> <img src="https://xtremereflection.app/assets/img/googlereview.png" height="100" width="200"></a></p>
                        @endif

                        @if($wo->estimate->customer->company->facebookReview )
                            <p>If you could please take a moment and head over to our facebook page and drop us a quick review.</p>

                            <p><a href="{{$wo->estimate->customer->company->facebookReview ?? ''}}"> <img src="https://xtremereflection.app/assets/img/facebookreview.png" height="100" width="200"></a></p>
                        @endif

                        @if(!$wo->estimate->ceramic)
                        <h3>Do you love the way your vehicle looks after our detail call us within 15 days of the completion date and get 40% off ceramic protection???
                        Keep that fresh detail look for years to come. Benefits of ceramic coatings:</h3>
                        <ul>
                            <li>Longer lasting protection.</li>
                            <li>Protection from harmful UV Rays.</li>
                            <li>Protection from Chemical Stains.</li>
                            <li>Hydrophobic Nature, Ease of Cleaning.</li>
                            <li>Candy Like Gloss.</li>
                            <li>Added Protection from Scratches and Swirl Marks.</li>
                            <li>Protection from water spotting.</li>

                        </ul>
                        @endif
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
                    <td celspan="4"><h2>Check Out Our Work</h2></td>
                </tr>
                <tr>
                    <td>
                        <img src="https://xtremereflection.app/assets/img/ram1.jpg" width="150px" height="150px" alt="SystemXLogo">                    </td>
                    <td>
                        <img src="https://xtremereflection.app/assets/img/jeep.jpg" width="150px" height="150px" alt="SystemXLogo">
                    </td>
                    <td>
                        <img src="https://xtremereflection.app/assets/img/interior.jpg" width="150px" height="150px" alt="SystemXLogo">
                    </td>
                    <td>
                        <img src="https://xtremereflection.app/assets/img/gmc.jpg" width="150px" height="150px" alt="SystemXLogo">
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
