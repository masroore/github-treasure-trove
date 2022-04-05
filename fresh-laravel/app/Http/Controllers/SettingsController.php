<?php

namespace App\Http\Controllers;

use App\Facades\UtilityFacades;
use App\Mail\TestMail;
use Artisan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Str;
use Validator;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    public function appNameUpdate(Request $request)
    {
        $this->validate($request, [
            'app_logo' => 'nullable|image|max:2048|mimes:png',
            'app_small_logo' => 'nullable|image|max:2048|mimes:png',
            'favicon_logo' => 'nullable|image|max:2048|mimes:png',
            'app_name' => 'required',
        ]);
        $data = [];
        if ($request->app_logo) {
            Storage::delete(UtilityFacades::getsettings('app_logo'));
            $app_logo_name = 'app-logo.' . $request->app_logo->extension();
            $request->app_logo->storeAs('logo', $app_logo_name);
            $data['app_logo'] = 'logo/' . $app_logo_name;
        }
        if ($request->app_small_logo) {
            Storage::delete(UtilityFacades::getsettings('app_small_logo'));
            $app_small_logo_name = 'app-small-logo.' . $request->app_small_logo->extension();
            $request->app_small_logo->storeAs('logo', $app_small_logo_name);
            $data['app_small_logo'] = 'logo/' . $app_small_logo_name;
        }

        if ($request->favicon_logo) {
            Storage::delete(UtilityFacades::getsettings('favicon_logo'));
            $favicon_logo_name = 'app-favicon-logo.' . $request->favicon_logo->extension();
            $request->favicon_logo->storeAs('logo', $favicon_logo_name);
            $data['favicon_logo'] = 'logo/' . $favicon_logo_name;
        }
        $data['app_name'] = $request->app_name;

        foreach ($data as $key => $value) {
            UtilityFacades::storesettings(['key' => $key, 'value' => $value]);
        }

        return redirect()->back()->with('success', __('App Setting changed successfully'));
    }

    public function pusherSettingUpdate(Request $request)
    {
        $this->validate($request, [
            'pusher_id' => 'required|regex:/^[0-9]+$/',
            'pusher_key' => 'required|regex:/^[A-Za-z0-9_.,()]+$/',
            'pusher_secret' => 'required|regex:/^[A-Za-z0-9_.,()]+$/',
            'pusher_cluster' => 'required|regex:/^[A-Za-z0-9_.,()]+$/',
        ], [
            'pusher_id.regex' => 'Invalid Entry! The pusher id only letters, underscore and numbers are allowed',
            'pusher_key.regex' => 'Invalid Entry! The pusher key only letters, underscore and numbers are allowed',
            'pusher_secret.regex' => 'Invalid Entry! The pusher secret only letters, underscore and numbers are allowed',
            'pusher_cluster.regex' => 'Invalid Entry! The pusher cluster only letters, underscore and numbers are allowed',
        ]);
        $data = [
            'pusher_id' => $request->pusher_id,
            'pusher_key' => $request->pusher_key,
            'pusher_secret' => $request->pusher_secret,
            'pusher_cluster' => $request->pusher_cluster,
        ];

        foreach ($data as $key => $value) {
            UtilityFacades::storesettings(['key' => $key, 'value' => $value]);
        }

        return redirect()->back()->with('success', __('Pusher API Keys Updated Successfully'));
    }

    public function s3SettingUpdate(Request $request)
    {
        if ($request->settingtype == 's3') {
            $this->validate($request, [
                's3_key' => 'required',
                's3_secret' => 'required',
                's3_region' => 'required',
                's3_bucket' => 'required',
                's3_url' => 'required',
                's3_endpoint' => 'required',
            ], [
                's3_key.regex' => 'Invalid Entry! The s3 key only letters, underscore and numbers are allowed',
                's3_secret.regex' => 'Invalid Entry! The s3 secret only letters, underscore and numbers are allowed',
            ]);

            $data = [
                's3_key' => $request->s3_key,
                's3_secret' => $request->s3_secret,
                's3_region' => $request->s3_region,
                's3_bucket' => $request->s3_bucket,
                's3_url' => $request->s3_url,
                's3_endpoint' => $request->s3_endpoint,
                'settingtype' => $request->settingtype,
            ];

            foreach ($data as $key => $value) {
                UtilityFacades::storesettings(['key' => $key, 'value' => $value]);
            }
        } else {
            UtilityFacades::storesettings(['key' => 'settingtype', 'value' => $request->settingtype]);
        }

        return redirect()->back()->with('success', __('S3 API Keys Updated Successfully'));
    }

    public function emailSettingUpdate(Request $request)
    {
        $this->validate($request, [
            'mail_mailer' => 'required',
            'mail_host' => 'required',
            'mail_port' => 'required',
            'mail_username' => 'required|email',
            'mail_password' => 'required',
            'mail_encryption' => 'required',
            'mail_from_address' => 'required',
            'mail_from_name' => 'required',
        ], [
            'mail_mailer.regex' => 'Required Entry! The Mail Mailer Not allow empty',
            'mail_host.regex' => 'Required Entry! The Mail Host Not allow empty',
            'mail_port.regex' => 'Required Entry! The Mail Port Not allow empty',
            'mail_username.regex' => 'Required Entry! The Username Mailer Not allow empty',
            'mail_password.regex' => 'Required Entry! The Password Mailer Not allow empty',
            'mail_encryption.regex' => 'Invalid Entry! The Mail encryption Mailer Not allow empty',
            'mail_from_address.regex' => 'Invalid Entry! The Mail From Address Not allow empty',
            'mail_from_name.regex' => 'Invalid Entry! The From name Not allow empty',
        ]);
        $data = [
            'mail_mailer' => $request->mail_mailer,
            'mail_host' => $request->mail_host,
            'mail_port' => $request->mail_port,
            'mail_username' => $request->mail_username,
            'mail_password' => $request->mail_password,
            'mail_encryption' => $request->mail_encryption,
            'mail_from_address' => $request->mail_from_address,
            'mail_from_name' => $request->mail_from_name,
        ];
        foreach ($data as $key => $value) {
            UtilityFacades::storesettings(['key' => $key, 'value' => $value]);
        }

        return redirect()->back()->with('success', __('Email Setting Updated Successfully'));
    }

    public function authSettingsUpdate(Request $request)
    {
        $data = [
            '2fa' => ($request->two_factor_auth == 'on') ? 1 : 0,
            'captcha' => ($request->captcha == 'on') ? 1 : 0,
            'email_verification' => ($request->email_verification == 'on') ? 1 : 0,
            'date_format' => $request->date_format,
            'time_format' => $request->time_format,
        ];
        foreach ($data as $key => $value) {
            UtilityFacades::storesettings(['key' => $key, 'value' => $value]);
        }

        return redirect()->back()->with('success', __('General Settings Updated Successfully'));
    }

    public function backupFiles()
    {
        Artisan::call('backup:run', ['--only-files' => true]);
        $output = Artisan::output();
        if (Str::contains($output, 'Backup completed!')) {
            return redirect()->back()->with('success', __('Application Files Backed-up successfully'));
        }

        return redirect()->back()->with('error', __('Application Files Backed-up failed'));
    }

    public function backupDb()
    {
        Artisan::call('backup:run', ['--only-db' => true]);
        $output = Artisan::output();
        if (Str::contains($output, 'Backup completed!')) {
            return redirect()->back()->with('success', __('Application Database Backed-up successfully'));
        }

        return redirect()->back()->with('error', __('Application Database Backed-up failed'));
    }

    private function getBackups()
    {
        $path = storage_path('app/app-backups');
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        $files = File::allFiles($path);
        $backups = collect([]);
        foreach ($files as $dt) {
            $backups->push([
                'filename' => pathinfo($dt->getFilename(), PATHINFO_FILENAME),
                'extension' => pathinfo($dt->getFilename(), PATHINFO_EXTENSION),
                'path' => $dt->getPath(),
                'size' => $dt->getSize(),
                'time' => $dt->getMTime(),
            ]);
        }

        return $backups;
    }

    public function downloadBackup($name, $ext)
    {
        $path = storage_path('app/app-backups');
        $file = $path . '/' . $name . '.' . $ext;
        $status = Storage::disk('backup')->download($name . '.' . $ext, $name . '.' . $ext);

        return $status;
    }

    public function deleteBackup($name, $ext)
    {
        $path = storage_path('app/app-backups');
        $file = $path . '/' . $name . '.' . $ext;
        $status = File::delete($file);
        if ($status) {
            return redirect()->back()->with('success', __('Backup deleted successfully'));
        }

        return redirect()->back()->with('error', __('Ops! an error occured, Try Again'));
    }

    public function loadsetting($type)
    {
        $t = ucfirst(str_replace('-', ' ', $type));

        return view('settings.' . $type, compact('t'));
    }

    public function testMail()
    {
        return view('settings.test_mail');
    }

    public function testSendMail(Request $request)
    {
        $validator = Validator::make($request->all(), ['email' => 'required|email']);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        try {
            Mail::to($request->email)->send(new TestMail());
        } catch (Exception $e) {
            $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
        }

        return redirect()->back()->with('success', __('Email send Successfully.') . ((isset($smtp_error)) ? '<br> <span class="text-danger">' . $smtp_error . '</span>' : ''));
    }
}
