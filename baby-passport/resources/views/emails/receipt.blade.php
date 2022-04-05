<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
      xmlns:o="urn:schemas-microsoft-com:office:office" class="dj_webkit dj_chrome dj_contentbox">
<head>
    <style type="text/css">
        /* Enable image placeholders */
        @-moz-document url-prefix(http), url-prefix(file) {
            img:-moz-broken {
                -moz-force-broken-image-icon: 1;
                width: 24px;
                height: 24px;
            }
        }

        @font-face {
            font-family: "Campton";
            src: url('{{asset('fonts/Campton-SemiBold.otf')}}') format('truetype');
        }

        @font-face {
            font-family: "Roboto";
            src: url('{{asset('fonts/Roboto-Regular.ttf')}}') format('truetype');
        }

        .social-icon {
            width: 48px;
            height: 48px;
            display: block;
        }


        .checkout__inner {
            max-width: 15rem;
            margin-left: auto;
            margin-right: auto;
        }

        .checkout__inner::after {
            clear: both;
            content: "";
            display: block;
        }

        .card {
            border-radius: 1rem;
            color: #ECECEE;
            font-family: 'Roboto', monospace;
            height: 9.5rem;
            margin-bottom: 2rem;
            position: relative;
            text-transform: uppercase;
            width: 15rem;
        }

        .flip {
            -webkit-transition: 250ms ease;
            transition: 250ms ease;
            border-radius: 1rem;
            height: 100%;
            position: absolute;
            -webkit-transform-style: preserve-3d;
            transform-style: preserve-3d;
            width: 100%;
        }

        .flip__front, .flip__back {
            -webkit-transition: 250ms ease;
            transition: 250ms ease;
            background-color: #00233e;
            border-radius: 1rem;
            left: 0;
            height: 100%;
            opacity: 0;
            position: absolute;
            top: 0;
            width: 100%;
            visibility: hidden;
            z-index: 1;
        }

        .flip__front.shown, .flip__back.shown {
            opacity: 1;
            visibility: visible;
            z-index: 2;
        }

        .flip__back {
            -webkit-transform: rotateY(180deg);
            transform: rotateY(180deg);
        }


    </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vive el #RetoJAPAM</title>
    <style type="text/css">
        p {
            margin: 10px 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
        }

        h1, h2, h3, h4, h5, h6 {
            display: block;
            margin: 0;
            padding: 0;
        }

        img, a img {
            border: 0;
            height: auto;
            outline: none;
            text-decoration: none;
        }

        body, #bodyTable, #bodyCell {
            height: 100%;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .mcnPreviewText {
            display: none !important;
        }

        #outlook a {
            padding: 0;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        table {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        .ReadMsgBody {
            width: 100%;
        }

        .ExternalClass {
            width: 100%;
        }

        p, a, li, td, blockquote {
            mso-line-height-rule: exactly;
        }

        a[href^=tel], a[href^=sms] {
            color: inherit;
            cursor: default;
            text-decoration: none;
        }

        p, a, li, td, body, table, blockquote {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        .ExternalClass, .ExternalClass p, .ExternalClass td, .ExternalClass div, .ExternalClass span, .ExternalClass font {
            line-height: 100%;
        }

        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        a.mcnButton {
            display: block;
        }

        .mcnImage {
            vertical-align: bottom;
        }

        .mcnTextContent {
            word-break: normal;
        }

        .mcnTextContent img {
            height: auto !important;
        }

        .mcnDividerBlock {
            table-layout: fixed !important;
        }

        body, #bodyTable {
            background-color: #f5f5f5;
        }

        #bodyCell {
            border-top: 0;
        }

        h1 {
            color: #f3be9a !important;
            font-family: "Campton", Helvetica;
            font-size: 64px;
            font-style: normal;
            font-weight: bolder;
            line-height: 125%;
            letter-spacing: normal;
            text-align: center;
        }

        h2 {
            color: #f3be9a !important;
            font-family: "Campton", Helvetica;
            font-size: 26px;
            font-style: normal;
            font-weight: bold;
            line-height: 125%;
            letter-spacing: normal;
            text-align: center;
        }

        h3 {
            color: #404040 !important;
            font-family: "Campton", Helvetica;
            font-size: 18px;
            font-style: normal;
            font-weight: bold;
            line-height: 125%;
            letter-spacing: normal;
            text-align: center;
        }

        h4 {
            color: #606060 !important;
            font-family: "Campton", Helvetica;
            font-size: 16px;
            font-style: normal;
            font-weight: bold;
            line-height: 125%;
            letter-spacing: normal;
            text-align: left;
        }

        #templatePreheader {
            background-color: #f3be9a;
            border-top: 0;
            border-bottom: 0;
        }

        #preheaderBackground {
            background-color: #f3be9a;
            border-top: 0;
            border-bottom: 0;
        }

        .preheaderContainer .mcnTextContent, .preheaderContainer .mcnTextContent p {
            color: #FFFFFF;
            font-family: "Campton", Helvetica;
            font-size: 10px;
            line-height: 125%;
            text-align: left;
        }

        .preheaderContainer .mcnTextContent a {
            color: #FFFFFF;
            font-weight: normal;
            text-decoration: underline;
        }

        #templateHeader {
            background-color: #f3be9a;
            border-top: 0;
            border-bottom: 0;
        }

        #headerBackground {
            background-color: #ffffff;
            border-top: 0;
            border-bottom: 0;
        }

        .headerContainer .mcnTextContent, .headerContainer .mcnTextContent p {
            color: #f3be9a;
            font-family: "Campton", Helvetica;
            font-size: 16px;
            line-height: 150%;
            text-align: left;
        }

        .headerContainer .mcnTextContent a {
            color: #013ca6;
            font-weight: normal;
            text-decoration: underline;
        }

        #templateBody {
            background-color: #F5F5F5;
            border-top: 0;
            border-bottom: 0;
        }

        #bodyBackground {
            background-color: #FFFFFF;
            border-top: 0;
            border-bottom: 0;
        }

        .bodyContainer .mcnTextContent, .bodyContainer .mcnTextContent p {
            color: #f3be9a;
            font-family: "Campton", Helvetica;
            font-size: 18px;
            line-height: 150%;
            text-align: center;
        }

        .bodyContainer .mcnTextContent a {
            color: #013ca6;
            font-weight: normal;
            text-decoration: underline;
        }

        #templateFooter {
            background-color: #F5F5F5;
            border-top: 0;
            border-bottom: 0;
        }

        #footerBackground {
            background-color: #FFFFFF;
            border-top: 0;
            border-bottom: 0;
        }

        .footerContainer .mcnTextContent, .footerContainer .mcnTextContent p {
            color: #606060;
            font-family: "Campton", Helvetica;
            font-size: 10px;
            line-height: 125%;
            text-align: center;
        }

        .footerContainer .mcnTextContent a {
            color: #606060;
            font-weight: normal;
            text-decoration: underline;
        }

        @media only screen and (max-width: 480px) {
            body, table, td, p, a, li, blockquote {
                -webkit-text-size-adjust: none !important;
            }

        }

        @media only screen and (max-width: 480px) {
            body {
                width: 100% !important;
                min-width: 100% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .templateContainer {
                max-width: 600px !important;
                width: 100% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnImage {
                width: 100% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnCartContainer, .mcnCaptionTopContent, .mcnRecContentContainer, .mcnCaptionBottomContent, .mcnTextContentContainer, .mcnBoxedTextContentContainer, .mcnImageGroupContentContainer, .mcnCaptionLeftTextContentContainer, .mcnCaptionRightTextContentContainer, .mcnCaptionLeftImageContentContainer, .mcnCaptionRightImageContentContainer, .mcnImageCardLeftTextContentContainer, .mcnImageCardRightTextContentContainer, .mcnImageCardLeftImageContentContainer, .mcnImageCardRightImageContentContainer {
                max-width: 100% !important;
                width: 100% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnBoxedTextContentContainer {
                min-width: 100% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnImageGroupContent {
                padding: 9px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnCaptionLeftContentOuter .mcnTextContent, .mcnCaptionRightContentOuter .mcnTextContent {
                padding-top: 9px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnImageCardTopImageContent, .mcnCaptionBottomContent:last-child .mcnCaptionBottomImageContent, .mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent {
                padding-top: 18px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnImageCardBottomImageContent {
                padding-bottom: 9px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnImageGroupBlockInner {
                padding-top: 0 !important;
                padding-bottom: 0 !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnImageGroupBlockOuter {
                padding-top: 9px !important;
                padding-bottom: 9px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnTextContent, .mcnBoxedTextContentColumn {
                padding-right: 18px !important;
                padding-left: 18px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnImageCardLeftImageContent, .mcnImageCardRightImageContent {
                padding-right: 18px !important;
                padding-bottom: 0 !important;
                padding-left: 18px !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcpreview-image-uploader {
                display: none !important;
                width: 100% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            h1 {
                font-size: 34px !important;
                line-height: 125% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            h2 {
                font-size: 20px !important;
                line-height: 125% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            h3 {
                font-size: 18px !important;
                line-height: 125% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            h4 {
                font-size: 16px !important;
                line-height: 125% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .mcnBoxedTextContentContainer .mcnTextContent, .mcnBoxedTextContentContainer .mcnTextContent p {
                font-size: 18px !important;
                line-height: 125% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            #templatePreheader {
                display: block !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .preheaderContainer .mcnTextContent, .preheaderContainer .mcnTextContent p {
                font-size: 14px !important;
                line-height: 115% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .headerContainer .mcnTextContent, .headerContainer .mcnTextContent p {
                font-size: 18px !important;
                line-height: 125% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .bodyContainer .mcnTextContent, .bodyContainer .mcnTextContent p {
                font-size: 18px !important;
                line-height: 125% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .footerContainer .mcnTextContent, .footerContainer .mcnTextContent p {
                font-size: 14px !important;
                line-height: 115% !important;
            }

        }

        @media only screen and (max-width: 480px) {
            .footerContainer a.utilityLink {
                display: block !important;
            }

        }
    </style>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <style type="text/css">
        /* Enable image placeholders */
        @-moz-document url-prefix(http), url-prefix(file) {
            img:-moz-broken {
                -moz-force-broken-image-icon: 1;
                width: 24px;
                height: 24px;
            }
        }
    </style>
</head>
<!-- NAME: POP-UP -->
<!--[if gte mso 15]>
<xml>
    <o:OfficeDocumentSettings>
        <o:AllowPNG/>
        <o:PixelsPerInch>96</o:PixelsPerInch>
    </o:OfficeDocumentSettings>
</xml>
<![endif]-->

<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0"
      waid71fa0d88-5390-4b5b-a2f4-e45fa93d85e2="SA password protect entry checker" class="mcd np">
<center>
    <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
        <tbody>
        <tr>
            <td align="center" valign="top" id="bodyCell" style="padding-bottom:40px;">
                <!-- BEGIN TEMPLATE // -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody>
                    <tr>
                        <td align="center" valign="top">
                            <!-- BEGIN PREHEADER // -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templatePreheader">
                                <tbody>
                                <tr>
                                    <td align="center" valign="top" style="padding-right:10px; padding-left:10px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="600"
                                               class="templateContainer">
                                            <tbody>
                                            <tr>
                                                <td align="center" valign="top">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                                           id="preheaderBackground">
                                                        <tbody>
                                                        <tr>
                                                            <td valign="top"
                                                                class="preheaderContainer tpl-container dojoDndSource dojoDndTarget dojoDndContainer">
                                                                <!-- Content of the block will get inserted inside of this -->
                                                                <table border="0" cellpadding="0" cellspacing="0"
                                                                       width="100%" class="mcnDividerBlock"
                                                                       style="min-width:100%;">
                                                                    <tbody class="mcnDividerBlockOuter">
                                                                    <tr>
                                                                        <td class="mcnDividerBlockInner"
                                                                            style="min-width:100%; padding:18px;">
                                                                            <table class="mcnDividerContent" border="0"
                                                                                   cellpadding="0" cellspacing="0"
                                                                                   width="100%" style="min-width:100%;">
                                                                                <tbody>
                                                                                <tr>
                                                                                    <td>
                                                                                        <span></span>
                                                                                    </td>
                                                                                </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="top">
                            <!-- BEGIN HEADER // -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateHeader">
                                <tbody>
                                <tr>
                                    <td align="center" valign="top" style="padding-right:10px; padding-left:10px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="600"
                                               class="templateContainer">
                                            <tbody>
                                            <tr>
                                                <td align="center" valign="top">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                                           id="headerBackground">
                                                        <tbody>
                                                        <tr>
                                                            <td valign="top"
                                                                class="headerContainer tpl-container dojoDndSource dojoDndTarget dojoDndContainer">
                                                                <table border="0" cellpadding="0" cellspacing="0"
                                                                       width="100%" class="mcnDividerBlock"
                                                                       style="min-width:100%;">
                                                                    <tbody class="mcnDividerBlockOuter">
                                                                    <tr>
                                                                        <td class="mcnDividerBlockInner"
                                                                            style="min-width:100%; padding:18px;">
                                                                            <table class="mcnDividerContent" border="0"
                                                                                   cellpadding="0" cellspacing="0"
                                                                                   width="100%"
                                                                                   style="min-width: 100%; border-top: 0px;">
                                                                                <tbody>
                                                                                <tr>
                                                                                    <td>
                                                                                        <span></span>
                                                                                    </td>
                                                                                </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                                <table border="0" cellpadding="0" cellspacing="0"
                                                                       width="100%" class="mcnImageBlock"
                                                                       style="min-width:100%;">
                                                                    <tbody class="mcnImageBlockOuter">
                                                                    <tr>
                                                                        <td valign="top" style="padding:9px"
                                                                            class="mcnImageBlockInner">
                                                                            <table align="left" width="100%" border="0"
                                                                                   cellpadding="0" cellspacing="0"
                                                                                   class="mcnImageContentContainer"
                                                                                   style="min-width:100%;">
                                                                                <tbody>
                                                                                <tr>
                                                                                    <td class="mcnImageContent mcnTextContent"
                                                                                        valign="top"
                                                                                        style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;">
                                                                                        <img align="center" alt=""
                                                                                             src="{{asset('img/logos/logo-f3be9a.png')}}"
                                                                                             style="max-width:300px; padding-bottom: 0; display: inline !important; vertical-align: bottom;"
                                                                                             class="mcnImage blockDropTarget"
                                                                                             id="dijit__Templated_0"
                                                                                             widgetid="dijit__Templated_0">
                                                                                        <br>

                                                                                    </td>
                                                                                </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                                <!-- Content of the block will get inserted inside of this -->
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <!-- // END HEADER -->
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="top">
                            <!-- BEGIN BODY // -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateBody">
                                <tbody>
                                <tr>
                                    <td align="center" valign="top" style="padding-right:10px; padding-left:10px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="600"
                                               class="templateContainer">
                                            <tbody>
                                            <tr>
                                                <td align="center" valign="top">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                                           id="bodyBackground">
                                                        <tbody>
                                                        <tr>
                                                            <td valign="top"
                                                                class="bodyContainer tpl-container dojoDndSource dojoDndTarget dojoDndContainer">
                                                                <!-- Content of the block will get inserted inside of this -->

                                                                <!-- Content of the block will get inserted inside of this -->
                                                                <!-- Content of the block will get inserted inside of this -->
                                                                <table style="max-width:100%; min-width:100%;"
                                                                       class="mcnTextContentContainer" align="left"
                                                                       border="0" cellpadding="0" cellspacing="0"
                                                                       width="100%">


                                                                    <tr>
                                                                        <td class="mcnTextContent"
                                                                            style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;"
                                                                            valign="top">
                                                                            <div id="loginNormal">

                                                                                <div style="color:#98989a;text-align: center; font-size: 15px !important; font-weight: bold; text-transform: uppercase; margin-bottom: 1.25rem;">
                                                                                    <h2>Detalles de pago</h2>
                                                                                    <br>
                                                                                    <h3 style="color: #98989a;">{{$payDate}}</h3>
                                                                                </div>

                                                                                <table style="width:100%; margin: 1rem 0; color:#98989a;">
                                                                                    <tbody>
                                                                                    <tr style="font-size: 20x;">
                                                                                        <td width="50%"
                                                                                            style="text-align: left">
                                                                                            Transacción:
                                                                                            <br>{{$paymentId}}</td>
                                                                                        <td width="50%"
                                                                                            style="text-align: right">
                                                                                            Autorización:<br> {{$authCode}}
                                                                                        </td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>

                                                                                <table style="width:100%; margin: 1rem 0; color:#98989a;">
                                                                                    <tr style="text-align:left;width:100%;padding: 1rem"
                                                                                        align="left">
                                                                                        <td width="65%"
                                                                                            style="border-collapse:collapse!important;text-align:left;"
                                                                                            align="left" valign="top">
                                                                                            <div style="clear:both;overflow:hidden; word-wrap: break-word">
                                                                                                      <span style="font-size:20px; font-weight:bold; ">
                                                                                                          {{$concept}}
                                                                                                      </span>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td valign="middle" width="35%"
                                                                                            style="text-align:right;white-space:nowrap;font-size:19px;font-weight:bold;"
                                                                                            align="right" valign="top">
                                                                                            {{$price}}
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>

                                                                                <br>
                                                                                <!-- ------------------------BEGIN CARD INFORMATION------------------------ -->
                                                                                <!-- Checkout content-->
                                                                                <div class="checkout__inner">
                                                                                    <!-- Credit card-->
                                                                                    <div class="card">
                                                                                        <!-- Flip container-->
                                                                                        <div class="flip">
                                                                                            <!-- Flip front-->
                                                                                            <div class="flip__front shown">
                                                                                                <table style="height: 9.5rem;!important;">
                                                                                                    <tbody>
                                                                                                    <tr>
                                                                                                        <td style="padding-left: 11.5rem!important; padding-top: 0.3rem!important;">
                                                                                                            @if($cardType == 'visa')
                                                                                                                <img src="{{asset('img/miscellaneous/visa.png')}}"
                                                                                                                     style="width:35px; ">
                                                                                                            @endif

                                                                                                            @if($cardType == 'mastercard')
                                                                                                                <img src="{{url('img/miscellaneous/mastercard.png')}}"
                                                                                                                     style="width:35px;">
                                                                                                            @endif

                                                                                                            @if($cardType == 'american')
                                                                                                                <img src="{{url('img/miscellaneous/american.png')}}"
                                                                                                                     style="width:35px;">
                                                                                                            @endif

                                                                                                            @if($cardType == 'paypal')
                                                                                                                <img src="{{url('img/miscellaneous/paypal-logo.png')}}"
                                                                                                                     style="width:35px;">
                                                                                                            @endif


                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td style="text-align: left; padding-left: 1rem;padding-top: 0rem;">
                                                                                                            <img src="{{asset('img/miscellaneous/chip.png')}}"
                                                                                                                 style="width:35px;">
                                                                                                        </td>

                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td style="color: #fff; font-size: 1.2rem; padding-left: 0.7rem;">
                                                                                                            {{$cardNumber}}
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                        <td style="color: #fff; padding-left: 0.7rem;font-size: 0.7rem;">
                                                                                                            {{$holderName}}
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    <tr></tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <!-- Checkout form-->
                                                                                </div>
                                                                                <!-- ------------------------END CARD INFORMATION------------------------ -->

                                                                                <div style="text-align:center">
                                                                                    <p class="m_-257677775310693878keep"
                                                                                       style="Padding-top:20px;Padding-bottom:20px;font-size:18px">
                                                                                        Conserve el ticket de para
                                                                                        cualquier aclaración.</p>
                                                                                </div>
                                                                            </div>
                                                                            <div style="text-align: center;">
                                                                                <img src="{{asset('img/logos/logo-f3be9a.png')}}"
                                                                                     style="width:150px; margin-top: 10px;">
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>

                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <!-- // END BODY -->
                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="top">
                            <!-- BEGIN FOOTER // -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateFooter">
                                <tbody>
                                <tr>
                                    <td align="center" valign="top" style="padding-right:10px; padding-left:10px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="600"
                                               class="templateContainer">
                                            <tbody>
                                            <tr>
                                                <td align="center" valign="top">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%"
                                                           id="footerBackground">
                                                        <tbody>
                                                        <tr>
                                                            <td valign="top"
                                                                class="footerContainer tpl-container dojoDndSource dojoDndTarget dojoDndContainer">
                                                                <!-- Content of the block will get inserted inside of this -->
                                                                <table border="0" cellpadding="0" cellspacing="0"
                                                                       width="100%" class="mcnDividerBlock"
                                                                       style="min-width:100%;">
                                                                    <tbody class="mcnDividerBlockOuter">
                                                                    <tr>
                                                                        <td class="mcnDividerBlockInner"
                                                                            style="min-width: 100%; padding: 36px 18px 18px;">
                                                                            <table class="mcnDividerContent" border="0"
                                                                                   cellpadding="0" cellspacing="0"
                                                                                   width="100%"
                                                                                   style="min-width: 100%;border-top: 1px dotted #808080;">
                                                                                <tbody>
                                                                                <tr>
                                                                                    <td>
                                                                                        <span></span>
                                                                                    </td>
                                                                                </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                                <!-- Content of the block will get inserted inside of this -->
                                                                <table border="0" cellpadding="0" cellspacing="0"
                                                                       width="100%" class="mcnTextBlock"
                                                                       style="min-width:100%;">
                                                                    <tbody class="mcnTextBlockOuter">
                                                                    <tr>
                                                                        <td valign="top" class="mcnTextBlockInner"
                                                                            style="padding-top:9px;">
                                                                            <table align="left" border="0"
                                                                                   cellspacing="0" cellpadding="0"
                                                                                   width="100%" style="width:100%;">
                                                                                <tr>
                                                                                    <td valign="top" width="600"
                                                                                        style="width:600px;">
                                                                                        <table align="left" border="0"
                                                                                               cellpadding="0"
                                                                                               cellspacing="0"
                                                                                               style="max-width:100%; min-width:100%;"
                                                                                               width="100%"
                                                                                               class="mcnTextContentContainer">
                                                                                            <tbody>
                                                                                            <tr>
                                                                                                <td valign="top"
                                                                                                    class="mcnTextContent"
                                                                                                    style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">
                                                                                                    <center>
                                                                                                        <em>Copyright
                                                                                                            © {{date('Y')}}
                                                                                                            Medical
                                                                                                            Meeting,
                                                                                                            Todos los
                                                                                                            derechos
                                                                                                            reservados.</em><br>
                                                                                                        BabyPassport<br>
                                                                                                        <br>
                                                                                                        <strong>Correo
                                                                                                            electrónico:</strong><br>
                                                                                                        babypassportc@medicalmeeting.co<br/>
                                                                                                        <br/>

                                                                                                    </center>
                                                                                                </td>
                                                                                            </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                                <!-- Content of the block will get inserted inside of this -->
                                                                <table border="0" cellpadding="0" cellspacing="0"
                                                                       width="100%" class="mcnDividerBlock"
                                                                       style="min-width:100%;">
                                                                    <tbody class="mcnDividerBlockOuter">
                                                                    <tr>
                                                                        <td class="mcnDividerBlockInner"
                                                                            style="min-width:100%; padding:18px;">
                                                                            <table class="mcnDividerContent" border="0"
                                                                                   cellpadding="0" cellspacing="0"
                                                                                   width="100%"
                                                                                   style="min-width: 100%; border-top: 0px;">
                                                                                <tbody>
                                                                                <tr>
                                                                                    <td>
                                                                                        <span></span>
                                                                                    </td>
                                                                                </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <!-- // END FOOTER -->
                        </td>
                    </tr>
                    </tbody>
                </table>
                <!-- // END TEMPLATE -->
            </td>
        </tr>
        </tbody>
    </table>
</center>
</body>
</html>
