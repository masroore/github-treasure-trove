<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

class OtherController extends Controller
{
    public function getsettings()
    {
        abort_if(!auth()->user()->getRoleNames()->contains('Super Admin'), 403, __('No Permission !'));

        return view('admin.others.index');
    }

    public function forcehttps()
    {
        if (1 == env('DEMO_LOCK')) {
            notify()->error(__('This feature is restricted in demo !'));

            return back();
        }

        abort_if(!auth()->user()->getRoleNames()->contains('Super Admin'), 403, __('No Permission !'));

        $force_https = DotenvEditor::setKeys([
            'FORCE_HTTPS' => 1 == env('FORCE_HTTPS') ? '0' : '1',
        ]);

        $force_https->save();

        notify()->success(__('Settings updated !'));

        return back();
    }

    public function removepublic()
    {
        if (1 == env('DEMO_LOCK')) {
            notify()->error(__('This feature is restricted in demo !'));

            return back();
        }

        abort_if(!auth()->user()->getRoleNames()->contains('Super Admin'), 403, __('No Permission !'));

        $content =

            '<IfModule mod_rewrite.c>
            RewriteEngine On
            RewriteRule ^(.*)$ public/$1 [L]
        </IfModule>';

        @file_put_contents(base_path() . '/.htaccess', $content);

        notify()->success(__('Settings updated !'));

        return back();
    }
}
