<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TFAPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pages')->insert([
            'slug' => 'tfa',
            'title' => 'Two-Factor Authentication',
            'body' => "<p><span style='font-size: 18px;'><b>With 2FA enabled, you'll be asked to provide your 2FA authentication code, as well as your password, when you sign in to our app.</b></span></p><p><span style='color: rgb(3, 102, 214); font-size: 1.25em;'>Providing a 2FA code when signing in to the website</span></p><p style='margin-bottom: 16px;'><font color='#24292e'><span style='font-size: 16px;'>After you sign in to our app using your password, you'll be prompted to provide an authentication code from a text message or your TOTP app.</span></font></p><p style='margin-bottom: 16px;'><font color='#24292e'><span style='font-size: 16px;'>If you chose to set up two-factor authentication using a TOTP application (we recommend using the Google Authenticator app but you can use any other TOTP app as well) on your smartphone, you can generate an authentication code for our app at any time. In most cases, just launching the application will generate a new code.</span></font></p><p style='margin-bottom: 16px;'><font color='#24292e'><span style='font-size: 16px;'>If you delete the mobile application after configuring two-factor authentication, you will no longer be able to access your account. When such a scenario occurs, you can use your ACCESS KEY (which you received when you logged in for the first time) to DISABLE Two-Factor Authentication without TOTP from your phone.</span></font></p><p style='margin-bottom: 16px;'><font color='#24292e'><span style='font-size: 16px;'>If your authentication fails several times, you may wish to synchronize your phone's clock with your mobile provider. Often, this involves checking the <b>Set automatically </b>option on your phone's clock, rather than providing your own time zone. </span></font></p><p style='margin-bottom: 16px;'><font color='#24292e'><span style='font-size: 16px;'>If you are still unable to access your account, get in touch with our support team and we will guide you through the recovery process.</span></font></p>",
            'status' => 'Published',
            'last_updated' => Now(),
            'created_at' => Now(),
            'updated_at' => Now(),
        ]);
    }
}
