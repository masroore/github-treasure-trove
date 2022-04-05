<?php

namespace App\Http\Controllers;

use App\Config;
use App\Msg91Setting;
use DotenvEditor;
use Illuminate\Http\Request;

class Msg91Controller extends Controller
{
    public function __construct()
    {
        $this->config = Config::first();

        $this->middleware(['permission:site-settings.sms-settings']);
    }

    public function getSettings()
    {
        $settings = Msg91Setting::get();
        $config = $this->config;

        return view('admin.sms.settings', compact('settings', 'config'));
    }

    public function updateSettings(Request $request)
    {
        $env_keys_save = DotenvEditor::setKeys([
            'MSG91_AUTH_KEY' => $request->MSG91_AUTH_KEY,
        ]);

        $env_keys_save->save();

        $this->config->msg91_enable = isset($request->msg91_enable) ? '1' : '0';
        $this->config->save();

        if (isset($request->keys)) {
            foreach ($request->keys as $key => $k) {
                Msg91Setting::where('id', '=', $key)->update([

                    'message' => 'orders' != $k ? $request->message[$key] : null,
                    'sender_id' => $request->sender_id[$key],
                    'otp_length' => 'orders' != $k ? $request->otp_length[$key] : null,
                    'otp_expiry' => 'orders' != $k ? $request->otp_expiry[$key] : null,
                    'unicode' => isset($request->unicode[$key]) ? 1 : 0,
                    'flow_id' => $request->flow_id[$key],
                ]);
            }
        }

        notify()->success(__('SMS settings has been updated !'));

        return back();
    }
}
