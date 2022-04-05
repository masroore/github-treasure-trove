<?php

namespace Modules\Setting\Http\Controllers;

use App\Traits\ImageStore;
use App\Traits\SendMail;
use App\Traits\SendSMS;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use LogActivity;
use Modules\Setting\Model\Currency;
use Modules\Setting\Model\EmailTemplate;
use Modules\Setting\Model\GeneralSetting;
use Modules\Setting\Model\SmsGateway;
use Modules\Setting\Repositories\GeneralSettingRepositoryInterface;

class GeneralSettingsController extends Controller
{
    use ImageStore;
    use SendMail;
    use SendSMS;

    protected $generalsettingRepository;

    public function __construct(GeneralSettingRepositoryInterface $generalsettingRepository)
    {
        $this->middleware(['auth', 'permission']);
        $this->middleware('prohibited.demo.mode')->except(['change_view', 'post_change_view']);
        $this->generalsettingRepository = $generalsettingRepository;
    }

    public function update(Request $request)
    {
        if ($request->email) {
            $request->validate([
                'email' => 'required',
                'phone' => 'required',
                'address' => 'required',
            ]);
        } else {
            $request->validate([
                'site_title' => 'required|string|max:30',
                'file_supported' => 'nullable|string',
                'copyright_text' => 'nullable|string',
                'language_id' => 'required',
                'date_format_id' => 'required',
                'currency_id' => 'required',
                'time_zone_id' => 'required',
                'preloader' => 'required',
                'invoice_prefix' => 'nullable',
                'agent_commission_type' => 'nullable',
                'sale_margin_price' => 'nullable',
                'site_logo' => 'nullable|mimes:jpg,png,jpeg',
                'favicon_logo' => 'nullable|mimes:jpg,png,jpeg',
            ]);
        }

        if ($request->favicon_logo != null) {
            $url = $this->saveSettingsImage($request->favicon_logo);
            $request->merge(['favicon' => $url]);
        }
        if ($request->site_logo != null) {
            $url = $this->saveSettingsImage($request->site_logo);
            $request->merge(['logo' => $url]);
        }
        if ($request->currency_id != null) {
            $currency = Currency::findOrFail($request->currency_id);
            $request->merge(['currency_symbol' => $currency->symbol, 'currency' => $request->currency_id, 'currency_code' => $currency->code]);
        }

        try {
            $this->generalsettingRepository->update($request->except('_token', 'favicon_logo', 'site_logo', 'currency_id', 'status', 'g_set'));
            if ($request->ajax()) {
                return 1;
            }
            Toastr::success(__('GeneralSetting Credentials has been updated Successfully'));
            session()->put('g_set', '1');
            session()->forget('sms_set');
            session()->forget('smtp_set');
            session()->forget('email_template');
            session()->forget('sms_template');

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            if ($request->ajax()) {
                return response()->json(['error' => trans('common.Something Went Wrong')]);
            }

            Toastr::error('Something happend Wrong!', 'Error!!');

            return back();
        }
    }

    public function invoice_update(Request $request)
    {
        try {
            $this->generalsettingRepository->update($request->only(['remarks_title', 'remarks_body', 'terms_conditions']));
            if ($request->ajax()) {
                return 1;
            }
            Toastr::success(__('GeneralSetting Credentials has been updated Successfully'));
            session()->put('invoice', '1');
            session()->forget('sms_set');
            session()->forget('smtp_set');
            session()->forget('email_template');
            session()->forget('sms_template');
            session()->forget('g_set');

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());

            if ($request->ajax()) {
                return response()->json(['error' => trans('common.Something Went Wrong')]);
            }

            Toastr::error('Something happend Wrong!', 'Error!!');

            return back();
        }
    }

    public function sms_gateway_credentials_update(Request $request)
    {
        $request->validate([
            'sms_gateway_id' => 'required',
        ]);

        try {
            foreach (SmsGateway::all() as $key => $sms_gateway) {
                $sms_gateway->status = 0;
                $sms_gateway->save();
            }
            $sms_gateway = SmsGateway::findOrFail($request->sms_gateway_id);
            $sms_gateway->status = 1;
            $sms_gateway->save();
            foreach ($request->types as $key => $type) {
                $this->overWriteEnvFile($type, $request[$type]);
            }
            session()->forget('g_set');
            session()->forget('smtp_set');
            session()->forget('email_template');
            session()->forget('sms_template');
            session()->put('sms_set', '1');
            Toastr::success(__('setting.SMS Gateways Credentials has been updated Successfully'));

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Something happend Wrong!', 'Error!!');

            return redirect()->back();
        }
    }

    public function overWriteEnvFile($data)
    {
        try {
            if (!count($data)) {
                return false;
            }

            $env = file_get_contents(base_path() . '/.env');
            $env = explode("\n", $env);
            foreach ((array) $data as $key => $value) {
                foreach ($env as $env_key => $env_value) {
                    $entry = explode('=', $env_value, 2);
                    if ($entry[0] === $key) {
                        $env[$env_key] = $key . '=' . (is_string($value) ? '"' . $value . '"' : $value);
                    } else {
                        $env[$env_key] = $env_value;
                    }
                }
            }
            $env = implode("\n", $env);
            file_put_contents(base_path() . '/.env', $env);

            return true;
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error(__('common.Something Went Wrong'));

            return back();
        }
    }

    public function sms_send_demo(Request $request)
    {
        try {
            $this->sendSMS($request->number, env('APP_NAME'), $request->message);
            Toastr::success(__('setting.SMS has been sent Successfully'));

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Something happend Wrong!', 'Error!!');

            return redirect()->back();
        }
    }

    public function smtp_gateway_credentials_update(Request $request)
    {
        $request->validate([
            'mail_protocol' => 'required',
        ]);

        try {
            $general_setting = GeneralSetting::first();
            $general_setting->mail_protocol = $request->mail_protocol;
            $general_setting->mail_signature = $request->mail_signature;
            $general_setting->save();

            if ($request->mail_protocol == 'sendmail') {
                $request->merge(['MAIL_MAILER' => 'sendmail']);
            } else {
                $request->merge(['MAIL_MAILER' => $request->mail_protocol]);
            }

            $arr = [];
            foreach ($request->types as $key => $type) {
                $arr[$type] = $request[$type];
            }

            $this->overWriteEnvFile($arr);
            session()->forget('g_set');
            session()->forget('sms_set');
            session()->forget('email_template');
            session()->forget('sms_template');
            session()->put('smtp_set', '1');

            Toastr::success(__('setting.SMTP Gateways Credentials has been updated Successfully'));

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Something happend Wrong!', 'Error!!');

            return redirect()->back();
        }
    }

    public function test_mail_send(Request $request)
    {
        try {
            $mail = $this->sendMailTest($request->email, 'Test Mail', $request->content);

            if ($mail == true) {
                Toastr::success(__('setting.Mail has been sent Successfully'));

                return back();
            }
            Toastr::success(__('setting.Please Configure SMTP settings first'));

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Something happend Wrong!', 'Error!!');

            return redirect()->back();
        }
    }

    public function template_update(Request $request)
    {
        $email_template = EmailTemplate::where('type', $request->name)->first();
        $email_template->subject = $request->subject;
        $email_template->value = $request[$request->name];
        $email_template->save();
        if ($request->has('sms_template')) {
            session()->put('sms_template', '1');
            session()->forget('email_template');
            session()->forget('g_set');
            session()->forget('sms_set');
            session()->forget('smtp_set');
            Toastr::success(__('setting.SMS Template has been updated Successfully'));
        } else {
            session()->put('email_template', '1');
            session()->forget('g_set');
            session()->forget('smtp_set');
            session()->forget('sms_set');
            session()->forget('sms_template');
            Toastr::success(__('setting.Email Template has been updated Successfully'));
        }

        return back();
    }

    public function footer_update(Request $request)
    {
        try {
            $general_setting = GeneralSetting::first();
            $general_setting->mail_footer = $request->mail_footer;
            $general_setting->save();
            session()->put('email_template', '1');
            session()->forget('g_set');
            session()->forget('smtp_set');
            session()->forget('smtp_set');

            Toastr::success(__('setting.Email Footer has been updated Successfully'));

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Something happend Wrong!', 'Error!!');

            return redirect()->back();
        }
    }

    public function update_bg(Request $request)
    {
        try {
            $data['setting'] = GeneralSetting::first();

            return view('setting::bg', $data);
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Something happend Wrong!', 'Error!!');

            return redirect()->back();
        }
    }

    public function post_update_bg(Request $request)
    {
        try {
            $general_setting = GeneralSetting::first();

            if ($request->login_bg != null) {
                $general_setting->login_bg = $this->saveSettingsImage($request->login_bg);
            }

            if ($request->error_page_bg != null) {
                $general_setting->error_page_bg = $this->saveSettingsImage($request->error_page_bg);
            }

            $general_setting->save();

            Toastr::success(__('setting.Background image updated Successfully'));

            return back();
        } catch (Exception $e) {
            LogActivity::errorLog($e->getMessage());
            Toastr::error('Something happend Wrong!', 'Error!!');

            return redirect()->back();
        }
    }

    public function remove($type)
    {
        $setting = $this->generalsettingRepository->all();
        if ($type == 'logo') {
            if ($setting->log != 'public/uploads/settings/logo.png') {
                $this->deleteImage($setting->logo);
            }
            $this->generalsettingRepository->update(['logo' => 'public/uploads/settings/logo.png']);
        } elseif ($type == 'favicon') {
            if ($setting->log != 'public/uploads/settings/favicon.png') {
                $this->deleteImage($setting->favicon);
            }
            $this->generalsettingRepository->update(['favicon' => 'public/uploads/settings/favicon.png']);
        } else {
            Toastr::error(__('setting. Invalid Parameter'));

            return back();
        }

        Toastr::success(__('setting.' . ucfirst($type) . ' image remove Successfully'));

        return back();
    }

    public function change_view()
    {
        $default_view = $this->generalsettingRepository->all()->default_view;

        return view('setting::themes.change_view', compact('default_view'));
    }

    public function post_change_view(Request $request)
    {
        $request->validate([
            'view' => ['required', 'string', Rule::in(['normal', 'compact'])],
        ]);

        $this->generalsettingRepository->update(['default_view' => $request->view]);

        Toastr::success(__('setting.' . ucfirst($request->view) . ' view changed as default view'));

        return back();
    }
}
