<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('email_templates', function (Blueprint $table): void {
            $table->id();
            $table->string('type')->nullable();
            $table->string('subject')->nullable();
            $table->text('value')->nullable();
            $table->text('available_variable')->nullable();
            $table->boolean('status')->nullable()->default(true);
            $table->timestamps();
        });
        DB::statement("INSERT INTO `email_templates` (`id`, `type`, `subject`, `value`, `available_variable`, `created_at`, `updated_at`) VALUES
        (1, 'quotation_template', 'Quotation Invoice', '<div style=\"color: rgb(255, 255, 255); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; text-align: center; background-color: rgb(65, 80, 148); padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0px;\"><h1 style=\"margin: 20px 0px 10px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 1.1; color: inherit; font-size: 36px;\">Quotation Invoice</h1></div><div style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; padding: 20px;\"><p style=\"color: rgb(85, 85, 85);\">Hello {USER_FIRST_NAME}<br><br>An account has been created for you.</p><p style=\"color: rgb(85, 85, 85);\">Please use the following info to login your dashboard:</p><hr style=\"box-sizing: content-box; margin-top: 20px; margin-bottom: 20px; border-top-color: rgb(238, 238, 238);\"><p style=\"color: rgb(85, 85, 85);\"><br></p></div>', '{USER_FIRST_NAME}', Null, '2021-01-20 12:40:59'),
        (2, 'sale_template', '', '<div style=\"font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(255, 255, 255); text-align: center; background-color: rgb(65, 80, 148); padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0px;\"><h1 style=\"margin: 20px 0px 10px; font-size: 36px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 1.1; color: inherit;\">Sale Invoice</h1></div><div style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; padding: 20px;\"><p style=\"color: rgb(85, 85, 85);\">Hello {USER_FIRST_NAME}<br><br>An account has been created for you.</p><p style=\"color: rgb(85, 85, 85);\">Please use the following info to login your dashboard:</p><hr style=\"box-sizing: content-box; margin-top: 20px; margin-bottom: 20px; border-top-color: rgb(238, 238, 238);\"><p style=\"color: rgb(85, 85, 85);\"><br></p></div>','{USER_FIRST_NAME}', NULL, '2021-01-20 12:40:47'),
        (3, 'purchase_template', '', '<div style=\"color: rgb(255, 255, 255); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; text-align: center; background-color: rgb(65, 80, 148); padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0px;\"><h1 style=\"margin: 20px 0px 10px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 1.1; color: inherit; font-size: 36px;\">Purchase Invoice</h1></div><div style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; padding: 20px;\"><p style=\"color: rgb(85, 85, 85);\">Hello {USER_FIRST_NAME}<br><br><span style=\"color: rgb(85, 85, 85);\">An account has been created for you</span><br></p><p style=\"color: rgb(85, 85, 85);\"><br></p><hr style=\"box-sizing: content-box; margin-top: 20px; margin-bottom: 20px; border-top-color: rgb(238, 238, 238);\"><p style=\"color: rgb(85, 85, 85);\"><br></p></div>', '{USER_FIRST_NAME}',NULL, '2021-02-14 06:36:37'),

        (6, 'transaction_mail_template', '', '<div style=\"color: rgb(255, 255, 255); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; text-align: center; background-color: rgb(65, 80, 148); padding: 30px; border-top-left-radius: 3px; border-top-right-radius: 3px; margin: 0px;\"><h1 style=\"margin: 20px 0px 10px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; font-weight: 500; line-height: 1.1; color: inherit; font-size: 36px;\">Transaction Report</h1></div><div style=\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; padding: 20px;\"><p style=\"color: rgb(85, 85, 85);\">Hello {USER_FIRST_NAME}<br><br>An account has been created for you.</p><p style=\"color: rgb(85, 85, 85);\">Please use the following info to login your dashboard:</p><hr style=\"box-sizing: content-box; margin-top: 20px; margin-bottom: 20px; border-top-color: rgb(238, 238, 238);\"><p style=\"color: rgb(85, 85, 85);\"><br></p></div>','{USER_FIRST_NAME}', NULL, '2021-02-14 06:41:07'),
        (7, 'due_customer_sms_template', NULL, 'Hello {USER_FIRST_NAME}\r\nPrevious Due : {PREVIOUS_DUE_AMOUNT}\r\nCurrent Due: {TOTAL_DUE_AMOUNT}\r\nTHANK YOU\r\n{APP_NAME}', '{USER_FIRST_NAME}, {PREVIOUS_DUE_AMOUNT}, {TOTAL_DUE_AMOUNT}, {APP_NAME}', NULL, '2021-02-16 04:47:24')");

        DB::table('email_templates')->insert([
            [
                'type' => 'team_member_invitation',
                'subject' => 'Team Member Invitation',
                'value' => <<<'EOD'
                <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Document</title>
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
                    <style>
                        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');
                        body{
                            font-family: 'Poppins', sans-serif;
                            margin: 0;
                            padding: 0;
                        }
                        .email_invite_wrapper{
                            background: #fff;
                            text-align: center;

                        }
                        h1,h2,h3,h4,h5{
                            color: #415094;
                        }
                        .btn_1 {
                            display: inline-block;
                            padding: 13.5px 45px;
                            border-radius: 5px;
                            font-size: 14px;
                            color: #fff;
                            -o-transition: all .4s ease-in-out;
                            -webkit-transition: all .4s ease-in-out;
                            transition: all .4s ease-in-out;
                            text-transform: capitalize;
                            background-size: 200% auto;
                            border: 1px solid transparent;
                            box-shadow: 0px 10px 20px 0px rgba(108, 39, 255, 0.3);
                            background-image: -webkit-gradient(linear, right top, left top, from(#7c32ff), color-stop(50%, #c738d8), to(#7c32ff));
                            background-image: -webkit-linear-gradient(right, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
                            background-image: -o-linear-gradient(right, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
                            background-image: linear-gradient(to left, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
                        }
                        .btn_1:hover {
                            color: #fff !important;
                            background-position: right center;
                            box-shadow: 0px 10px 20px 0px rgba(108, 39, 255, 0.3);
                        }

                        .banner img{
                            width: 100%;
                        }
                        .invitation_text {
                            max-width: 500px;
                            margin: 30px auto 0 auto
                        }
                        .invitation_text h3{
                            font-size: 20px;
                            text-transform: capitalize;
                            color: #2F353D;
                            margin-bottom: 10px;
                            font-weight: 600;
                        }
                        .invitation_text p{
                            font-family: "Poppins", sans-serif;
                            line-height: 1.929;
                            font-size: 16px;
                            margin-bottom: 0px;
                            color: #828bb2;
                            font-weight: 300;
                            margin: 10px 0 30px 0;
                        }
                        .invitation_text a{}
                        .logo{
                            margin: 30px 0;
                        }
                        .social_links{
                            background: #F4F4F8;
                            padding: 15px;
                            margin: 30px 0 30px 0;
                        }
                        .social_links a{
                            display: inline-block;
                            font-size: 15px;
                            color: #252B33;
                            padding: 5px;
                        }
                        .email_invite_bottom{
                            text-align: center;
                            margin: 20px 0 30px 0;
                        }
                        .email_invite_bottom p{
                            font-size: 14px;
                            font-weight: 400;
                            color: #828bb2;
                            text-transform: capitalize;
                            margin-bottom: 0;
                        }
                        .email_invite_bottom a{
                            font-size: 14px;
                            font-weight: 500;
                            color: #7c32ff  ;

                        }
                        a{
                            text-decoration: none;
                        }
                    </style>



                    <div class="email_invite_wrapper text-center">
                        <div class="logo">
                            <a href="#">
                                <img src="img/logo.png" alt="">
                            </a>
                        </div>
                        <div class="banner">
                            <img src="img/banner_bg.jpg" alt="">
                        </div>
                        <div class="invitation_text">
                            <h3>Team Member Invitation</h3>
                            <p style="text-align: left; ">Hello {USER_NAME}, </p><p style="text-align: left; ">{INVITATION_SENT_BY} has sent you an invitation to join with <a href="http://TEAM_URL" target="_blank">{TEAM_NAME}</a>. </p><p style="text-align: left; ">If you don not want to accept this invitation, simply ignore this email. </p></div>
                        <div class="social_links">
                            <a href="#"> <i class="fab fa-facebook-f"></i> </a>
                            <a href="#"> <i class="fab fa-instagram"></i> </a>
                            <a href="#"> <i class="fab fa-twitter"></i> </a>
                            <a href="#"> <i class="fab fa-pinterest-p"></i> </a>
                        </div>
                        <div class="email_invite_bottom">
                            </div>
                    </div>
EOD
                ,
                'available_variable' => '{USER_NAME},{INVITATION_SENT_BY},{TEAM_NAME},,{TEAM_URL}',
                'status' => true,
            ],
            [
                'type' => 'project_member_invitation',
                'subject' => 'Project Member Invitation',
                'value' => <<<'EOD'
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Document</title>
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
                    <style>
                        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');
                        body{
                            font-family: 'Poppins', sans-serif;
                            margin: 0;
                            padding: 0;
                        }
                        .email_invite_wrapper{
                            background: #fff;
                            text-align: center;

                        }
                        h1,h2,h3,h4,h5{
                            color: #415094;
                        }
                        .btn_1 {
                            display: inline-block;
                            padding: 13.5px 45px;
                            border-radius: 5px;
                            font-size: 14px;
                            color: #fff;
                            -o-transition: all .4s ease-in-out;
                            -webkit-transition: all .4s ease-in-out;
                            transition: all .4s ease-in-out;
                            text-transform: capitalize;
                            background-size: 200% auto;
                            border: 1px solid transparent;
                            box-shadow: 0px 10px 20px 0px rgba(108, 39, 255, 0.3);
                            background-image: -webkit-gradient(linear, right top, left top, from(#7c32ff), color-stop(50%, #c738d8), to(#7c32ff));
                            background-image: -webkit-linear-gradient(right, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
                            background-image: -o-linear-gradient(right, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
                            background-image: linear-gradient(to left, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
                        }
                        .btn_1:hover {
                            color: #fff !important;
                            background-position: right center;
                            box-shadow: 0px 10px 20px 0px rgba(108, 39, 255, 0.3);
                        }

                        .banner img{
                            width: 100%;
                        }
                        .invitation_text {
                            max-width: 500px;
                            margin: 30px auto 0 auto
                        }
                        .invitation_text h3{
                            font-size: 20px;
                            text-transform: capitalize;
                            color: #2F353D;
                            margin-bottom: 10px;
                            font-weight: 600;
                        }
                        .invitation_text p{
                            font-family: "Poppins", sans-serif;
                            line-height: 1.929;
                            font-size: 16px;
                            margin-bottom: 0px;
                            color: #828bb2;
                            font-weight: 300;
                            margin: 10px 0 30px 0;
                        }
                        .invitation_text a{}
                        .logo{
                            margin: 30px 0;
                        }
                        .social_links{
                            background: #F4F4F8;
                            padding: 15px;
                            margin: 30px 0 30px 0;
                        }
                        .social_links a{
                            display: inline-block;
                            font-size: 15px;
                            color: #252B33;
                            padding: 5px;
                        }
                        .email_invite_bottom{
                            text-align: center;
                            margin: 20px 0 30px 0;
                        }
                        .email_invite_bottom p{
                            font-size: 14px;
                            font-weight: 400;
                            color: #828bb2;
                            text-transform: capitalize;
                            margin-bottom: 0;
                        }
                        .email_invite_bottom a{
                            font-size: 14px;
                            font-weight: 500;
                            color: #7c32ff  ;

                        }
                        a{
                            text-decoration: none;
                        }
                    </style>



                    <div class="email_invite_wrapper text-center">
                        <div class="logo">
                            <a href="#">
                                <img src="img/logo.png" alt="">
                            </a>
                        </div>
                        <div class="banner">
                            <img src="img/banner_bg.jpg" alt="">
                        </div>
                        <div class="invitation_text">
                            <h3>Project Member Invitation</h3>
                            <p style="text-align: left; ">Hello {USER_NAME}, </p><p style="text-align: left; ">{INVITATION_SENT_BY} has sent you an invitation to join with <a href="http://PROJECT_URL" target="_blank">{PROJECT_NAME}</a>. </p><p style="text-align: left; ">If you don not want to accept this invitation, simply ignore this email. </p></div>
                        <div class="social_links">
                            <a href="#"> <i class="fab fa-facebook-f"></i> </a>
                            <a href="#"> <i class="fab fa-instagram"></i> </a>
                            <a href="#"> <i class="fab fa-twitter"></i> </a>
                            <a href="#"> <i class="fab fa-pinterest-p"></i> </a>
                        </div>
                        <div class="email_invite_bottom">
                            </div>
                    </div>
EOD
                ,
                'available_variable' => '{USER_NAME},{PROJECT_NAME},{PROJECT_URL},',
                'status' => true,
            ],
            [
                'type' => 'login_from_new_device',
                'subject' => 'Login From New Device',
                'value' => <<<EOD
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Document</title>
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
                    <style>
                        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');
                        body{
                            font-family: 'Poppins', sans-serif;
                            margin: 0;
                            padding: 0;
                        }
                        .email_invite_wrapper{
                            background: #fff;
                            text-align: center;

                        }
                        h1,h2,h3,h4,h5{
                            color: #415094;
                        }
                        .btn_1 {
                            display: inline-block;
                            padding: 13.5px 45px;
                            border-radius: 5px;
                            font-size: 14px;
                            color: #fff;
                            -o-transition: all .4s ease-in-out;
                            -webkit-transition: all .4s ease-in-out;
                            transition: all .4s ease-in-out;
                            text-transform: capitalize;
                            background-size: 200% auto;
                            border: 1px solid transparent;
                            box-shadow: 0px 10px 20px 0px rgba(108, 39, 255, 0.3);
                            background-image: -webkit-gradient(linear, right top, left top, from(#7c32ff), color-stop(50%, #c738d8), to(#7c32ff));
                            background-image: -webkit-linear-gradient(right, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
                            background-image: -o-linear-gradient(right, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
                            background-image: linear-gradient(to left, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
                        }
                        .btn_1:hover {
                            color: #fff !important;
                            background-position: right center;
                            box-shadow: 0px 10px 20px 0px rgba(108, 39, 255, 0.3);
                        }

                        .banner img{
                            width: 100%;
                        }
                        .invitation_text {
                            max-width: 500px;
                            margin: 30px auto 0 auto
                        }
                        .invitation_text h3{
                            font-size: 20px;
                            text-transform: capitalize;
                            color: #2F353D;
                            margin-bottom: 10px;
                            font-weight: 600;
                        }
                        .invitation_text p{
                            font-family: "Poppins", sans-serif;
                            line-height: 1.929;
                            font-size: 16px;
                            margin-bottom: 0px;
                            color: #828bb2;
                            font-weight: 300;
                            margin: 10px 0 30px 0;
                        }
                        .invitation_text a{}
                        .logo{
                            margin: 30px 0;
                        }
                        .social_links{
                            background: #F4F4F8;
                            padding: 15px;
                            margin: 30px 0 30px 0;
                        }
                        .social_links a{
                            display: inline-block;
                            font-size: 15px;
                            color: #252B33;
                            padding: 5px;
                        }
                        .email_invite_bottom{
                            text-align: center;
                            margin: 20px 0 30px 0;
                        }
                        .email_invite_bottom p{
                            font-size: 14px;
                            font-weight: 400;
                            color: #828bb2;
                            text-transform: capitalize;
                            margin-bottom: 0;
                        }
                        .email_invite_bottom a{
                            font-size: 14px;
                            font-weight: 500;
                            color: #7c32ff  ;

                        }
                        a{
                            text-decoration: none;
                        }
                    </style>



                    <div class="email_invite_wrapper text-center">
                        <div class="logo">
                            <a href="#">
                                <img src="img/logo.png" alt="">
                            </a>
                        </div>
                        <div class="banner">
                            <img src="img/banner_bg.jpg" alt="">
                        </div>
                        <div class="invitation_text">
                            <h3>Login From New Device</h3>
                            <p style="text-align: left; line-height: 24px; font-size: 14px; color: rgb(85, 85, 85);" segoe="" ui",="" sans-serif;="" text-align:="" left;"="">Hi {USER_NAME}</p><p style="text-align: left; line-height: 24px; font-size: 14px; color: rgb(85, 85, 85);" segoe="" ui",="" sans-serif;="" text-align:="" left;"="">We Notice a new login in your {APP_NAME} account</p><p style="text-align: left; line-height: 24px; font-size: 14px; color: rgb(85, 85, 85);" segoe="" ui",="" sans-serif;="" text-align:="" left;"=""><span style="color: rgb(85, 85, 85);">{USER_MAIL}</span></p><p style="text-align: left; line-height: 24px; font-size: 14px; color: rgb(85, 85, 85);" segoe="" ui",="" sans-serif;="" text-align:="" left;"=""><span style="color: rgb(21, 27, 38); font-family: -apple-system, BlinkMacSystemFont, " segoe="" ui",="" roboto,="" "helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" font-size:="" 13px;="" font-weight:="" 600;"="">When :\u{a0}</span><span style="color: rgb(21, 27, 38); font-family: -apple-system, BlinkMacSystemFont, " segoe="" ui",="" roboto,="" "helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" font-size:="" 13px;"="">{LOGIN_TIME}</span></p><p style="line-height: 24px; font-size: 14px; color: rgb(85, 85, 85); font-family: " segoe="" ui",="" sans-serif;="" text-align:="" left;"=""><div style="text-align: left;"><span segoe="" ui",="" roboto,="" "helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" font-size:="" 13px;="" font-weight:="" 600;"="" style="color: rgb(21, 27, 38);">Device :\u{a0}</span><span segoe="" ui",="" roboto,="" "helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" font-size:="" 13px;"="" style="color: rgb(21, 27, 38);">{LOGIN_DEVICE}</span></div><span style="color: rgb(34, 34, 34); font-family: Arial; font-size: 12px; white-space: pre-wrap;"><div style="text-align: left;"><span style="color: rgb(34, 34, 34);">If this was you, no further action is needed. If you don't recognize this login, we recommend you secure your account and <a href="http://{PASSWORD_RESET_URL}" target="_blank" style="transition-property: all;">reset your password</a> </span><span style="color: rgb(21, 27, 38); font-size: 13px;">immediately</span></div></span></p><p style="line-height: 24px;" segoe="" ui",="" sans-serif;="" text-align:="" left;"=""><div style="text-align: left;"><span style="font-size: 14px;"><br></span></div><span style="color: rgb(21, 27, 38); font-size: 13px;" segoe="" ui",="" roboto,="" "helvetica="" neue",="" helvetica,="" arial,="" sans-serif;"=""><div style="text-align: left;"><span segoe="" ui",="" roboto,="" "helvetica="" neue",="" helvetica,="" arial,="" sans-serif;"="" style="color: rgb(21, 27, 38);">If you need further help visit our\u{a0}</span><a href="http://%7Bsupport_page_url%7D/" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://app.asana.com/app/asana/-/log?se%3D%257B%2522name%2522%253A%2522LinkClicked%2522%252C%2522action%2522%253A%2522LinkClicked%2522%252C%2522sub_action%2522%253A%2522SupportPage%2522%252C%2522location%2522%253A%2522LoginDetectionEmail%2522%252C%2522luna2%2522%253Atrue%252C%2522domain%2522%253Anull%252C%2522domain_user%2522%253Anull%252C%2522user%2522%253A1187392071136032%252C%2522url%2522%253A%2522https%253A%252F%252Fasana.com%252Fsupport%2522%252C%2522non_user_action_event%2522%253Afalse%252C%2522email_uuid%2522%253A%25221610536551672-b0d32675-3895-41a7-b39b-ec2007a4541b%2522%252C%2522app_name%2522%253A%2522email%2522%257D%26dest%3Dhttps%253A%252F%252Fasana.com%252Fsupport%26hash%3D77fb54da9af0538686bb37b261e89bcbfcc8c0cf2de8b685a521872d22bc0fb4&source=gmail&ust=1610697723148000&usg=AFQjCNGP0mX1NxW3RydL5kT6_yuU4ST4ZA" segoe="" ui",="" roboto,="" "helvetica="" neue",="" helvetica,="" arial,="" sans-serif;="" font-weight:="" 400;="" font-size:="" 13px;"="" style="font-family: Poppins, sans-serif; font-weight: 300; color: rgb(17, 85, 204); font-size: 14px; text-decoration: none; background-color: rgb(255, 255, 255); transition-property: all;"><span style="color: rgb(20, 170, 245); line-height: 20px;">support page</span></a><span segoe="" ui",="" roboto,="" "helvetica="" neue",="" helvetica,="" arial,="" sans-serif;"="" style="color: rgb(21, 27, 38);"><a href="http://%7Bsupport_page_url%7D/" target="_blank" style="transition-property: all;">\u{a0}</a>or contact with us.</span></div></span></p><p style="text-align: left; line-height: 24px; font-size: 14px; color: rgb(121, 131, 139);" segoe="" ui",="" sans-serif;="" text-align:="" left;"=""><font face="-apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Helvetica, Arial, sans-serif"><span style="font-size: 13px;">Thank You.</span></font></p></div>
                        <div class="social_links">
                            <a href="#"> <i class="fab fa-facebook-f"></i> </a>
                            <a href="#"> <i class="fab fa-instagram"></i> </a>
                            <a href="#"> <i class="fab fa-twitter"></i> </a>
                            <a href="#"> <i class="fab fa-pinterest-p"></i> </a>
                        </div>
                        <div class="email_invite_bottom">
                            </div>
                    </div>
EOD
                ,
                'available_variable' => '{USER_NAME},{APP_NAME},{LOGIN_TIME},{LOGIN_DEVICE},{USER_MAIL},{PASSWORD_RESET_URL}',
                'status' => true,
            ],
            [
                'type' => 'email_confirmation',
                'subject' => 'Email Confirmation',
                'value' => <<<'EOD'
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
                <style>
                    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');
                    body{
                        font-family: 'Poppins', sans-serif;
                        margin: 0;
                        padding: 0;
                    }
                    .email_invite_wrapper{
                        background: #fff;
                        text-align: center;

                    }
                    h1,h2,h3,h4,h5{
                        color: #415094;
                    }
                    .btn_1 {
                        display: inline-block;
                        padding: 13.5px 45px;
                        border-radius: 5px;
                        font-size: 14px;
                        color: #fff;
                        -o-transition: all .4s ease-in-out;
                        -webkit-transition: all .4s ease-in-out;
                        transition: all .4s ease-in-out;
                        text-transform: capitalize;
                        background-size: 200% auto;
                        border: 1px solid transparent;
                        box-shadow: 0px 10px 20px 0px rgba(108, 39, 255, 0.3);
                        background-image: -webkit-gradient(linear, right top, left top, from(#7c32ff), color-stop(50%, #c738d8), to(#7c32ff));
                        background-image: -webkit-linear-gradient(right, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
                        background-image: -o-linear-gradient(right, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
                        background-image: linear-gradient(to left, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
                    }
                    .btn_1:hover {
                        color: #fff !important;
                        background-position: right center;
                        box-shadow: 0px 10px 20px 0px rgba(108, 39, 255, 0.3);
                    }

                    .banner img{
                        width: 100%;
                    }
                    .invitation_text {
                        max-width: 500px;
                        margin: 30px auto 0 auto
                    }
                    .invitation_text h3{
                        font-size: 20px;
                        text-transform: capitalize;
                        color: #2F353D;
                        margin-bottom: 10px;
                        font-weight: 600;
                    }
                    .invitation_text p{
                        font-family: "Poppins", sans-serif;
                        line-height: 1.929;
                        font-size: 16px;
                        margin-bottom: 0px;
                        color: #828bb2;
                        font-weight: 300;
                        margin: 10px 0 30px 0;
                    }
                    .invitation_text a{}
                    .logo{
                        margin: 30px 0;
                    }
                    .social_links{
                        background: #F4F4F8;
                        padding: 15px;
                        margin: 30px 0 30px 0;
                    }
                    .social_links a{
                        display: inline-block;
                        font-size: 15px;
                        color: #252B33;
                        padding: 5px;
                    }
                    .email_invite_bottom{
                        text-align: center;
                        margin: 20px 0 30px 0;
                    }
                    .email_invite_bottom p{
                        font-size: 14px;
                        font-weight: 400;
                        color: #828bb2;
                        text-transform: capitalize;
                        margin-bottom: 0;
                    }
                    .email_invite_bottom a{
                        font-size: 14px;
                        font-weight: 500;
                        color: #7c32ff  ;

                    }
                    a{
                        text-decoration: none;
                    }
                </style>



                <div class="email_invite_wrapper text-center">
                    <div class="logo">
                        <a href="#">
                            <img src="img/logo.png" alt="">
                        </a>
                    </div>
                    <div class="banner">
                        <img src="img/banner_bg.jpg" alt="">
                    </div>
                    <div class="invitation_text">
                        <h3>Verify Your Email address</h3>
                        <p style="text-align: left; ">Hello,</p><p style="text-align: left; ">Please click the link below to verify your email address <a href="http://VERIFY_URL" target="_blank">verify link</a>.</p><p style="text-align: left; ">If you did not create an account, no further action is required. </p><p style="text-align: left; ">Regards </p></div>
                    <div class="social_links">
                        <a href="#"> <i class="fab fa-facebook-f"></i> </a>
                        <a href="#"> <i class="fab fa-instagram"></i> </a>
                        <a href="#"> <i class="fab fa-twitter"></i> </a>
                        <a href="#"> <i class="fab fa-pinterest-p"></i> </a>
                    </div>
                    <div class="email_invite_bottom">
                        </div>
                </div>
EOD
                ,
                'available_variable' => '{VERIFY_URL},',
                'status' => true,
            ],
            [
                'type' => 'sign_up_email',
                'subject' => 'Sign up Email',
                'value' => <<<'EOD'
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
                <style>
                    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');
                    body{
                        font-family: 'Poppins', sans-serif;
                        margin: 0;
                        padding: 0;
                    }
                    .email_invite_wrapper{
                        background: #fff;
                        text-align: center;

                    }
                    h1,h2,h3,h4,h5{
                        color: #415094;
                    }
                    .btn_1 {
                        display: inline-block;
                        padding: 13.5px 45px;
                        border-radius: 5px;
                        font-size: 14px;
                        color: #fff;
                        -o-transition: all .4s ease-in-out;
                        -webkit-transition: all .4s ease-in-out;
                        transition: all .4s ease-in-out;
                        text-transform: capitalize;
                        background-size: 200% auto;
                        border: 1px solid transparent;
                        box-shadow: 0px 10px 20px 0px rgba(108, 39, 255, 0.3);
                        background-image: -webkit-gradient(linear, right top, left top, from(#7c32ff), color-stop(50%, #c738d8), to(#7c32ff));
                        background-image: -webkit-linear-gradient(right, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
                        background-image: -o-linear-gradient(right, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
                        background-image: linear-gradient(to left, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
                    }
                    .btn_1:hover {
                        color: #fff !important;
                        background-position: right center;
                        box-shadow: 0px 10px 20px 0px rgba(108, 39, 255, 0.3);
                    }

                    .banner img{
                        width: 100%;
                    }
                    .invitation_text {
                        max-width: 500px;
                        margin: 30px auto 0 auto
                    }
                    .invitation_text h3{
                        font-size: 20px;
                        text-transform: capitalize;
                        color: #2F353D;
                        margin-bottom: 10px;
                        font-weight: 600;
                    }
                    .invitation_text p{
                        font-family: "Poppins", sans-serif;
                        line-height: 1.929;
                        font-size: 16px;
                        margin-bottom: 0px;
                        color: #828bb2;
                        font-weight: 300;
                        margin: 10px 0 30px 0;
                    }
                    .invitation_text a{}
                    .logo{
                        margin: 30px 0;
                    }
                    .social_links{
                        background: #F4F4F8;
                        padding: 15px;
                        margin: 30px 0 30px 0;
                    }
                    .social_links a{
                        display: inline-block;
                        font-size: 15px;
                        color: #252B33;
                        padding: 5px;
                    }
                    .email_invite_bottom{
                        text-align: center;
                        margin: 20px 0 30px 0;
                    }
                    .email_invite_bottom p{
                        font-size: 14px;
                        font-weight: 400;
                        color: #828bb2;
                        text-transform: capitalize;
                        margin-bottom: 0;
                    }
                    .email_invite_bottom a{
                        font-size: 14px;
                        font-weight: 500;
                        color: #7c32ff  ;

                    }
                    a{
                        text-decoration: none;
                    }
                </style>



                <div class="email_invite_wrapper text-center">
                    <div class="logo">
                        <a href="#">
                            <img src="img/logo.png" alt="">
                        </a>
                    </div>
                    <div class="banner">
                        <img src="img/banner_bg.jpg" alt="">
                    </div>
                    <div class="invitation_text">
                        <h3>Welcome to {APP_NAME}</h3>
                        <p style="text-align: left; ">Hello {USER_NAME}, </p><p style="text-align: left; ">Welcome to {APP_NAME} {EMAIL_FOOTER}<br></p></div>
                    <div class="social_links">
                        <a href="#"> <i class="fab fa-facebook-f"></i> </a>
                        <a href="#"> <i class="fab fa-instagram"></i> </a>
                        <a href="#"> <i class="fab fa-twitter"></i> </a>
                        <a href="#"> <i class="fab fa-pinterest-p"></i> </a>
                    </div>
                    <div class="email_invite_bottom">
                        </div>
                </div>
EOD
                ,
                'available_variable' => '{APP_NAME},{USER_NAME},{APP_NAME}',
                'status' => true,
            ],
            [
                'type' => 'sign_up_team_invitation',
                'subject' => 'Sign up Team Invitation',
                'value' => <<<'EOD'
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
                <style>
                    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');
                    body{
                        font-family: 'Poppins', sans-serif;
                        margin: 0;
                        padding: 0;
                    }
                    .email_invite_wrapper{
                        background: #fff;
                        text-align: center;

                    }
                    h1,h2,h3,h4,h5{
                        color: #415094;
                    }
                    .btn_1 {
                        display: inline-block;
                        padding: 13.5px 45px;
                        border-radius: 5px;
                        font-size: 14px;
                        color: #fff;
                        -o-transition: all .4s ease-in-out;
                        -webkit-transition: all .4s ease-in-out;
                        transition: all .4s ease-in-out;
                        text-transform: capitalize;
                        background-size: 200% auto;
                        border: 1px solid transparent;
                        box-shadow: 0px 10px 20px 0px rgba(108, 39, 255, 0.3);
                        background-image: -webkit-gradient(linear, right top, left top, from(#7c32ff), color-stop(50%, #c738d8), to(#7c32ff));
                        background-image: -webkit-linear-gradient(right, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
                        background-image: -o-linear-gradient(right, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
                        background-image: linear-gradient(to left, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
                    }
                    .btn_1:hover {
                        color: #fff !important;
                        background-position: right center;
                        box-shadow: 0px 10px 20px 0px rgba(108, 39, 255, 0.3);
                    }

                    .banner img{
                        width: 100%;
                    }
                    .invitation_text {
                        max-width: 500px;
                        margin: 30px auto 0 auto
                    }
                    .invitation_text h3{
                        font-size: 20px;
                        text-transform: capitalize;
                        color: #2F353D;
                        margin-bottom: 10px;
                        font-weight: 600;
                    }
                    .invitation_text p{
                        font-family: "Poppins", sans-serif;
                        line-height: 1.929;
                        font-size: 16px;
                        margin-bottom: 0px;
                        color: #828bb2;
                        font-weight: 300;
                        margin: 10px 0 30px 0;
                    }
                    .invitation_text a{}
                    .logo{
                        margin: 30px 0;
                    }
                    .social_links{
                        background: #F4F4F8;
                        padding: 15px;
                        margin: 30px 0 30px 0;
                    }
                    .social_links a{
                        display: inline-block;
                        font-size: 15px;
                        color: #252B33;
                        padding: 5px;
                    }
                    .email_invite_bottom{
                        text-align: center;
                        margin: 20px 0 30px 0;
                    }
                    .email_invite_bottom p{
                        font-size: 14px;
                        font-weight: 400;
                        color: #828bb2;
                        text-transform: capitalize;
                        margin-bottom: 0;
                    }
                    .email_invite_bottom a{
                        font-size: 14px;
                        font-weight: 500;
                        color: #7c32ff  ;

                    }
                    a{
                        text-decoration: none;
                    }
                </style>



                <div class="email_invite_wrapper text-center">
                    <div class="logo">
                        <a href="#">
                            <img src="img/logo.png" alt="">
                        </a>
                    </div>
                    <div class="banner">
                        <img src="img/banner_bg.jpg" alt="">
                    </div>
                    <div class="invitation_text">
                        <h3>Invitation</h3>
                        <p style="text-align: left; ">Hello, </p><p style="text-align: left; ">You have an invitation from {FROM_INVIATION_MAIL} </p><p style="text-align: left; ">{FROM_INVIATION_USER_NAME} Invite to join {TEAM_NAME} For continuing and create account <a href="http://{TEAM_INVITATION_REGISTER_URL}" target="_blank">Click here</a></p></div>
                    <div class="social_links">
                        <a href="#"> <i class="fab fa-facebook-f"></i> </a>
                        <a href="#"> <i class="fab fa-instagram"></i> </a>
                        <a href="#"> <i class="fab fa-twitter"></i> </a>
                        <a href="#"> <i class="fab fa-pinterest-p"></i> </a>
                    </div>
                    <div class="email_invite_bottom">
                        </div>
                </div>
EOD
                ,
                'available_variable' => '{FROM_INVIATION_MAIL},{FROM_INVIATION_USER_NAME},{TEAM_NAME},{TEAM_INVITATION_REGISTER_URL}',
                'status' => true,
            ],
            [
                'type' => 'sign_up_project_invitation',
                'subject' => 'Sign up Project Invitation',
                'value' => <<<'EOD'
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
                <style>
                    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');
                    body{
                        font-family: 'Poppins', sans-serif;
                        margin: 0;
                        padding: 0;
                    }
                    .email_invite_wrapper{
                        background: #fff;
                        text-align: center;

                    }
                    h1,h2,h3,h4,h5{
                        color: #415094;
                    }
                    .btn_1 {
                        display: inline-block;
                        padding: 13.5px 45px;
                        border-radius: 5px;
                        font-size: 14px;
                        color: #fff;
                        -o-transition: all .4s ease-in-out;
                        -webkit-transition: all .4s ease-in-out;
                        transition: all .4s ease-in-out;
                        text-transform: capitalize;
                        background-size: 200% auto;
                        border: 1px solid transparent;
                        box-shadow: 0px 10px 20px 0px rgba(108, 39, 255, 0.3);
                        background-image: -webkit-gradient(linear, right top, left top, from(#7c32ff), color-stop(50%, #c738d8), to(#7c32ff));
                        background-image: -webkit-linear-gradient(right, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
                        background-image: -o-linear-gradient(right, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
                        background-image: linear-gradient(to left, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
                    }
                    .btn_1:hover {
                        color: #fff !important;
                        background-position: right center;
                        box-shadow: 0px 10px 20px 0px rgba(108, 39, 255, 0.3);
                    }

                    .banner img{
                        width: 100%;
                    }
                    .invitation_text {
                        max-width: 500px;
                        margin: 30px auto 0 auto
                    }
                    .invitation_text h3{
                        font-size: 20px;
                        text-transform: capitalize;
                        color: #2F353D;
                        margin-bottom: 10px;
                        font-weight: 600;
                    }
                    .invitation_text p{
                        font-family: "Poppins", sans-serif;
                        line-height: 1.929;
                        font-size: 16px;
                        margin-bottom: 0px;
                        color: #828bb2;
                        font-weight: 300;
                        margin: 10px 0 30px 0;
                    }
                    .invitation_text a{}
                    .logo{
                        margin: 30px 0;
                    }
                    .social_links{
                        background: #F4F4F8;
                        padding: 15px;
                        margin: 30px 0 30px 0;
                    }
                    .social_links a{
                        display: inline-block;
                        font-size: 15px;
                        color: #252B33;
                        padding: 5px;
                    }
                    .email_invite_bottom{
                        text-align: center;
                        margin: 20px 0 30px 0;
                    }
                    .email_invite_bottom p{
                        font-size: 14px;
                        font-weight: 400;
                        color: #828bb2;
                        text-transform: capitalize;
                        margin-bottom: 0;
                    }
                    .email_invite_bottom a{
                        font-size: 14px;
                        font-weight: 500;
                        color: #7c32ff  ;

                    }
                    a{
                        text-decoration: none;
                    }
                </style>



                <div class="email_invite_wrapper text-center">
                    <div class="logo">
                        <a href="#">
                            <img src="img/logo.png" alt="">
                        </a>
                    </div>
                    <div class="banner">
                        <img src="img/banner_bg.jpg" alt="">
                    </div>
                    <div class="invitation_text">
                        <h3>Invitation</h3>
                        <p style="text-align: left; ">Hello, </p><p style="text-align: left; ">You have an invitation from {FROM_INVIATION_MAIL} </p><p style="text-align: left; ">{FROM_INVIATION_USER_NAME} Invite to join {PROJECT_NAME} For continuing and create account <a href="http://{PROJECT_INVITATION_REGISTER_URL}" target="_blank">Click here</a></p></div>
                    <div class="social_links">
                        <a href="#"> <i class="fab fa-facebook-f"></i> </a>
                        <a href="#"> <i class="fab fa-instagram"></i> </a>
                        <a href="#"> <i class="fab fa-twitter"></i> </a>
                        <a href="#"> <i class="fab fa-pinterest-p"></i> </a>
                    </div>
                    <div class="email_invite_bottom">
                        </div>
                </div>
EOD
                ,
                'available_variable' => '{FROM_INVIATION_MAIL},{FROM_INVIATION_USER_NAME},{PROJECT_NAME},{PROJECT_INVITATION_REGISTER_URL}',
                'status' => true,
            ],
            [
                'type' => 'task_assign',
                'subject' => 'Task Assign',
                'value' => <<<'EOD'
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
                <style>
                    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');
                    body{
                        font-family: 'Poppins', sans-serif;
                        margin: 0;
                        padding: 0;
                    }
                    .email_invite_wrapper{
                        background: #fff;
                        text-align: center;

                    }
                    h1,h2,h3,h4,h5{
                        color: #415094;
                    }
                    .btn_1 {
                        display: inline-block;
                        padding: 13.5px 45px;
                        border-radius: 5px;
                        font-size: 14px;
                        color: #fff;
                        -o-transition: all .4s ease-in-out;
                        -webkit-transition: all .4s ease-in-out;
                        transition: all .4s ease-in-out;
                        text-transform: capitalize;
                        background-size: 200% auto;
                        border: 1px solid transparent;
                        box-shadow: 0px 10px 20px 0px rgba(108, 39, 255, 0.3);
                        background-image: -webkit-gradient(linear, right top, left top, from(#7c32ff), color-stop(50%, #c738d8), to(#7c32ff));
                        background-image: -webkit-linear-gradient(right, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
                        background-image: -o-linear-gradient(right, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
                        background-image: linear-gradient(to left, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
                    }
                    .btn_1:hover {
                        color: #fff !important;
                        background-position: right center;
                        box-shadow: 0px 10px 20px 0px rgba(108, 39, 255, 0.3);
                    }

                    .banner img{
                        width: 100%;
                    }
                    .invitation_text {
                        max-width: 500px;
                        margin: 30px auto 0 auto
                    }
                    .invitation_text h3{
                        font-size: 20px;
                        text-transform: capitalize;
                        color: #2F353D;
                        margin-bottom: 10px;
                        font-weight: 600;
                    }
                    .invitation_text p{
                        font-family: "Poppins", sans-serif;
                        line-height: 1.929;
                        font-size: 16px;
                        margin-bottom: 0px;
                        color: #828bb2;
                        font-weight: 300;
                        margin: 10px 0 30px 0;
                    }
                    .invitation_text a{}
                    .logo{
                        margin: 30px 0;
                    }
                    .social_links{
                        background: #F4F4F8;
                        padding: 15px;
                        margin: 30px 0 30px 0;
                    }
                    .social_links a{
                        display: inline-block;
                        font-size: 15px;
                        color: #252B33;
                        padding: 5px;
                    }
                    .email_invite_bottom{
                        text-align: center;
                        margin: 20px 0 30px 0;
                    }
                    .email_invite_bottom p{
                        font-size: 14px;
                        font-weight: 400;
                        color: #828bb2;
                        text-transform: capitalize;
                        margin-bottom: 0;
                    }
                    .email_invite_bottom a{
                        font-size: 14px;
                        font-weight: 500;
                        color: #7c32ff  ;

                    }
                    a{
                        text-decoration: none;
                    }
                </style>



                <div class="email_invite_wrapper text-center">
                    <div class="logo">
                        <a href="#">
                            <img src="img/logo.png" alt="">
                        </a>
                    </div>
                    <div class="banner">
                        <img src="img/banner_bg.jpg" alt="">
                    </div>
                    <div class="invitation_text">
                        <h3>{ASSIGNED_FROM} assigned a task to you<br></h3>
                        <p style="text-align: left; ">Task </p><p style="text-align: left; ">{TASK_NAME},</p><p style="text-align: left; "> Assigned To : {ASSIGNED_TO} </p><p style="text-align: left; ">Due Date : {DUE_DATE} </p><p style="text-align: left; ">Projects: <a href="http://PROJECT_URL" target="_blank">{PROJECT_NAME}</a> </p><p style="text-align: left; "><br></p></div>
                    <div class="social_links">
                        <a href="#"> <i class="fab fa-facebook-f"></i> </a>
                        <a href="#"> <i class="fab fa-instagram"></i> </a>
                        <a href="#"> <i class="fab fa-twitter"></i> </a>
                        <a href="#"> <i class="fab fa-pinterest-p"></i> </a>
                    </div>
                    <div class="email_invite_bottom">
                        </div>
                </div>

EOD
                ,
                'available_variable' => '{ASSIGNED_FROM},{TASK_NAME},{ASSIGNED_TO},{DUE_DATE},{PROJECT_NAME},{PROJECT_URL},',
                'status' => true,
            ],
            [
                'type' => 'task_complete',
                'subject' => 'Task Complete',
                'value' => <<<'EOD'
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
                <style>
                    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');
                    body{
                        font-family: 'Poppins', sans-serif;
                        margin: 0;
                        padding: 0;
                    }
                    .email_invite_wrapper{
                        background: #fff;
                        text-align: center;

                    }
                    h1,h2,h3,h4,h5{
                        color: #415094;
                    }
                    .btn_1 {
                        display: inline-block;
                        padding: 13.5px 45px;
                        border-radius: 5px;
                        font-size: 14px;
                        color: #fff;
                        -o-transition: all .4s ease-in-out;
                        -webkit-transition: all .4s ease-in-out;
                        transition: all .4s ease-in-out;
                        text-transform: capitalize;
                        background-size: 200% auto;
                        border: 1px solid transparent;
                        box-shadow: 0px 10px 20px 0px rgba(108, 39, 255, 0.3);
                        background-image: -webkit-gradient(linear, right top, left top, from(#7c32ff), color-stop(50%, #c738d8), to(#7c32ff));
                        background-image: -webkit-linear-gradient(right, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
                        background-image: -o-linear-gradient(right, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
                        background-image: linear-gradient(to left, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
                    }
                    .btn_1:hover {
                        color: #fff !important;
                        background-position: right center;
                        box-shadow: 0px 10px 20px 0px rgba(108, 39, 255, 0.3);
                    }

                    .banner img{
                        width: 100%;
                    }
                    .invitation_text {
                        max-width: 500px;
                        margin: 30px auto 0 auto
                    }
                    .invitation_text h3{
                        font-size: 20px;
                        text-transform: capitalize;
                        color: #2F353D;
                        margin-bottom: 10px;
                        font-weight: 600;
                    }
                    .invitation_text p{
                        font-family: "Poppins", sans-serif;
                        line-height: 1.929;
                        font-size: 16px;
                        margin-bottom: 0px;
                        color: #828bb2;
                        font-weight: 300;
                        margin: 10px 0 30px 0;
                    }
                    .invitation_text a{}
                    .logo{
                        margin: 30px 0;
                    }
                    .social_links{
                        background: #F4F4F8;
                        padding: 15px;
                        margin: 30px 0 30px 0;
                    }
                    .social_links a{
                        display: inline-block;
                        font-size: 15px;
                        color: #252B33;
                        padding: 5px;
                    }
                    .email_invite_bottom{
                        text-align: center;
                        margin: 20px 0 30px 0;
                    }
                    .email_invite_bottom p{
                        font-size: 14px;
                        font-weight: 400;
                        color: #828bb2;
                        text-transform: capitalize;
                        margin-bottom: 0;
                    }
                    .email_invite_bottom a{
                        font-size: 14px;
                        font-weight: 500;
                        color: #7c32ff  ;

                    }
                    a{
                        text-decoration: none;
                    }
                </style>



                <div class="email_invite_wrapper text-center">
                    <div class="logo">
                        <a href="#">
                            <img src="img/logo.png" alt="">
                        </a>
                    </div>
                    <div class="banner">
                        <img src="img/banner_bg.jpg" alt="">
                    </div>
                    <div class="invitation_text">
                        <h3>{USER_NAME} has complete {TASK_NAME}<br></h3>
                        <p style="text-align: left; ">&nbsp;Hello, </p><p style="text-align: left; ">{USER_NAME} has complete <a href="http://TASK_URL" target="_blank">{TASK_NAME}</a> in <a href="http://PROJECT_URL" target="_blank">{PROJECT_NAME}</a> For check <a href="http://TASK_URL" target="_blank">Click here</a><br></p><p style="text-align: left; "><br></p><p style="text-align: left; "></p></div>
                    <div class="social_links">
                        <a href="#"> <i class="fab fa-facebook-f"></i> </a>
                        <a href="#"> <i class="fab fa-instagram"></i> </a>
                        <a href="#"> <i class="fab fa-twitter"></i> </a>
                        <a href="#"> <i class="fab fa-pinterest-p"></i> </a>
                    </div>
                    <div class="email_invite_bottom">
                        </div>
                </div>
EOD
                ,
                'available_variable' => '{USER_NAME},{TASK_NAME},{TASK_URL},{PROJECT_NAME},{PROJECT_URL}',
                'status' => true,
            ],
            [
                'type' => 'due_date_remider',
                'subject' => 'Due date remider',
                'value' => <<<'EOD'
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
                <style>
                    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');
                    body{
                        font-family: 'Poppins', sans-serif;
                        margin: 0;
                        padding: 0;
                    }
                    .email_invite_wrapper{
                        background: #fff;
                        text-align: center;

                    }
                    h1,h2,h3,h4,h5{
                        color: #415094;
                    }
                    .btn_1 {
                        display: inline-block;
                        padding: 13.5px 45px;
                        border-radius: 5px;
                        font-size: 14px;
                        color: #fff;
                        -o-transition: all .4s ease-in-out;
                        -webkit-transition: all .4s ease-in-out;
                        transition: all .4s ease-in-out;
                        text-transform: capitalize;
                        background-size: 200% auto;
                        border: 1px solid transparent;
                        box-shadow: 0px 10px 20px 0px rgba(108, 39, 255, 0.3);
                        background-image: -webkit-gradient(linear, right top, left top, from(#7c32ff), color-stop(50%, #c738d8), to(#7c32ff));
                        background-image: -webkit-linear-gradient(right, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
                        background-image: -o-linear-gradient(right, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
                        background-image: linear-gradient(to left, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
                    }
                    .btn_1:hover {
                        color: #fff !important;
                        background-position: right center;
                        box-shadow: 0px 10px 20px 0px rgba(108, 39, 255, 0.3);
                    }

                    .banner img{
                        width: 100%;
                    }
                    .invitation_text {
                        max-width: 500px;
                        margin: 30px auto 0 auto
                    }
                    .invitation_text h3{
                        font-size: 20px;
                        text-transform: capitalize;
                        color: #2F353D;
                        margin-bottom: 10px;
                        font-weight: 600;
                    }
                    .invitation_text p{
                        font-family: "Poppins", sans-serif;
                        line-height: 1.929;
                        font-size: 16px;
                        margin-bottom: 0px;
                        color: #828bb2;
                        font-weight: 300;
                        margin: 10px 0 30px 0;
                    }
                    .invitation_text a{}
                    .logo{
                        margin: 30px 0;
                    }
                    .social_links{
                        background: #F4F4F8;
                        padding: 15px;
                        margin: 30px 0 30px 0;
                    }
                    .social_links a{
                        display: inline-block;
                        font-size: 15px;
                        color: #252B33;
                        padding: 5px;
                    }
                    .email_invite_bottom{
                        text-align: center;
                        margin: 20px 0 30px 0;
                    }
                    .email_invite_bottom p{
                        font-size: 14px;
                        font-weight: 400;
                        color: #828bb2;
                        text-transform: capitalize;
                        margin-bottom: 0;
                    }
                    .email_invite_bottom a{
                        font-size: 14px;
                        font-weight: 500;
                        color: #7c32ff  ;

                    }
                    a{
                        text-decoration: none;
                    }
                </style>



                <div class="email_invite_wrapper text-center">
                    <div class="logo">
                        <a href="#">
                            <img src="img/logo.png" alt="">
                        </a>
                    </div>
                    <div class="banner">
                        <img src="img/banner_bg.jpg" alt="">
                    </div>
                    <div class="invitation_text">
                        <h3>Due Date reminder<br></h3>
                        <p style="text-align: left; ">Hello {USER_NAME}, </p><p style="text-align: left; ">You have assigned in <a href="http://TASK_URL" target="_blank">{TASK_NAME}</a>, which due date is nearby.&nbsp;</p><p style="text-align: left; "></p></div>
                    <div class="social_links">
                        <a href="#"> <i class="fab fa-facebook-f"></i> </a>
                        <a href="#"> <i class="fab fa-instagram"></i> </a>
                        <a href="#"> <i class="fab fa-twitter"></i> </a>
                        <a href="#"> <i class="fab fa-pinterest-p"></i> </a>
                    </div>
                    <div class="email_invite_bottom">
                        </div>
                </div>
EOD
                ,
                'available_variable' => '{USER_NAME},{TASK_NAME},{TASK_URL}',
                'status' => true,
            ],
            [
                'type' => 'password_reset_template',
                'subject' => 'Password reset template',
                'value' => <<<'EOD'
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
                <style>
                    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');
                    body{
                        font-family: 'Poppins', sans-serif;
                        margin: 0;
                        padding: 0;
                    }
                    .email_invite_wrapper{
                        background: #fff;
                        text-align: center;

                    }
                    h1,h2,h3,h4,h5{
                        color: #415094;
                    }
                    .btn_1 {
                        display: inline-block;
                        padding: 13.5px 45px;
                        border-radius: 5px;
                        font-size: 14px;
                        color: #fff;
                        -o-transition: all .4s ease-in-out;
                        -webkit-transition: all .4s ease-in-out;
                        transition: all .4s ease-in-out;
                        text-transform: capitalize;
                        background-size: 200% auto;
                        border: 1px solid transparent;
                        box-shadow: 0px 10px 20px 0px rgba(108, 39, 255, 0.3);
                        background-image: -webkit-gradient(linear, right top, left top, from(#7c32ff), color-stop(50%, #c738d8), to(#7c32ff));
                        background-image: -webkit-linear-gradient(right, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
                        background-image: -o-linear-gradient(right, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
                        background-image: linear-gradient(to left, #7c32ff 0%, #c738d8 50%, #7c32ff 100%);
                    }
                    .btn_1:hover {
                        color: #fff !important;
                        background-position: right center;
                        box-shadow: 0px 10px 20px 0px rgba(108, 39, 255, 0.3);
                    }

                    .banner img{
                        width: 100%;
                    }
                    .invitation_text {
                        max-width: 500px;
                        margin: 30px auto 0 auto
                    }
                    .invitation_text h3{
                        font-size: 20px;
                        text-transform: capitalize;
                        color: #2F353D;
                        margin-bottom: 10px;
                        font-weight: 600;
                    }
                    .invitation_text p{
                        font-family: "Poppins", sans-serif;
                        line-height: 1.929;
                        font-size: 16px;
                        margin-bottom: 0px;
                        color: #828bb2;
                        font-weight: 300;
                        margin: 10px 0 30px 0;
                    }
.primary_btn_large {
    display: inline-block;
    padding: 17px 23px;
    text-transform: uppercase;
    line-height: 16px;
    font-size: 12px;
    font-weight: 500;
    border-radius: 5px;
    white-space: nowrap;
    -webkit-transition: 0.3s;
    transition: 0.3s;
    color: #fff;
    border: 0;
    cursor: pointer;
    letter-spacing: 0.1em;
}

                    .invitation_text a{}
                    .logo{
                        margin: 30px 0;
                    }
                    .social_links{
                        background: #F4F4F8;
                        padding: 15px;
                        margin: 30px 0 30px 0;
                    }
                    .social_links a{
                        display: inline-block;
                        font-size: 15px;
                        color: #252B33;
                        padding: 5px;
                    }
                    .email_invite_bottom{
                        text-align: center;
                        margin: 20px 0 30px 0;
                    }
                    .email_invite_bottom p{
                        font-size: 14px;
                        font-weight: 400;
                        color: #828bb2;
                        text-transform: capitalize;
                        margin-bottom: 0;
                    }
                    .email_invite_bottom a{
                        font-size: 14px;
                        font-weight: 500;
                        color: #7c32ff  ;

                    }
                    a{
                        text-decoration: none;
                    }

.primary_btn_large {
    display: inline-block;
    padding: 17px 23px;
    text-transform: uppercase;
    line-height: 16px;
    font-size: 12px;
    font-weight: 500;
    border-radius: 5px;
    white-space: nowrap;
    -webkit-transition: 0.3s;
    transition: 0.3s;
    color: #fff;
    border: 0;
    cursor: pointer;
    letter-spacing: 0.1em;
}
                </style>



                <div class="email_invite_wrapper text-center">
                    <div class="logo">
                        <a href="#">
                            <img src="http://demo.infixdev.com/public/uploads/settings/logo.png" alt=""></a></div><div class="invitation_text">
                        <h1 style="text-align: left; " segoe="" ui",="" roboto,="" helvetica,="" arial,="" sans-serif,="" "apple="" color="" emoji",="" "segoe="" ui="" symbol";="" position:="" relative;="" color:="" rgb(61,="" 72,="" 82);="" font-size:="" 18px;="" text-align:="" left;"="">Hello!</h1><p style="text-align: left; color: rgb(113, 128, 150);" segoe="" ui",="" roboto,="" helvetica,="" arial,="" sans-serif,="" "apple="" color="" emoji",="" "segoe="" ui="" symbol";="" position:="" relative;="" line-height:="" 1.5em;="" text-align:="" left;"="">You are receiving this email because we received a password reset request for your account.</p><p style="text-align: left; color: rgb(113, 128, 150);" segoe="" ui",="" roboto,="" helvetica,="" arial,="" sans-serif,="" "apple="" color="" emoji",="" "segoe="" ui="" symbol";="" position:="" relative;="" line-height:="" 1.5em;="" text-align:="" left;"=""><a calss="primary_btn_large" href="http://{RESET_LINK}" target="_blank">Reset Link</a></p><p style="text-align: left; color: rgb(113, 128, 150);" segoe="" ui",="" roboto,="" helvetica,="" arial,="" sans-serif,="" "apple="" color="" emoji",="" "segoe="" ui="" symbol";="" position:="" relative;="" line-height:="" 1.5em;="" text-align:="" left;"="">This password reset link will expire in 60 minutes.</p><p style="text-align: left; color: rgb(113, 128, 150);" segoe="" ui",="" roboto,="" helvetica,="" arial,="" sans-serif,="" "apple="" color="" emoji",="" "segoe="" ui="" symbol";="" position:="" relative;="" line-height:="" 1.5em;="" text-align:="" left;"="">If you did not request a password reset, no further action is required.</p><p style="color: rgb(113, 128, 150); font-family: -apple-system, BlinkMacSystemFont, " segoe="" ui",="" roboto,="" helvetica,="" arial,="" sans-serif,="" "apple="" color="" emoji",="" "segoe="" ui="" symbol";="" position:="" relative;="" line-height:="" 1.5em;="" text-align:="" left;"=""><br></p><p style="position: relative; line-height: 1.5em; text-align: left;"><font color="#828bb2" face="-apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica, Arial, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol"><span style="font-size: 14px;">If you’re having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser: <a href="http://{RESET_LINK}" target="_blank">{RESET_LINK}</a></span></font><br></p></div>
                    <div class="social_links">
                        <a href="#"> <i class="fab fa-facebook-f"></i> </a>
                        <a href="#"> <i class="fab fa-instagram"></i> </a>
                        <a href="#"> <i class="fab fa-twitter"></i> </a>
                        <a href="#"> <i class="fab fa-pinterest-p"></i> </a>
                    </div>
                    <div class="email_invite_bottom">
                        <p><span style="color: rgb(130, 139, 178); font-family: Poppins, sans-serif; font-size: 16px; text-align: left; text-transform: none;"></span><br></p></div>
                </div>
EOD
                ,
                'available_variable' => '{RESET_LINK},{APP_NAME}',
                'status' => true,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_templates');
    }
}
