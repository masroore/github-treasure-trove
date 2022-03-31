<?php

namespace Modules\AdminSetting\Http\Controllers;

use App\Utils\Option;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AdminSetting\Http\Requests\UpdateCODSettingRequest;
use Modules\AdminSetting\Http\Requests\UpdateGeneralRequest;
use Modules\AdminSetting\Http\Requests\UpdateGoogleAnalyticsSettingRequest;
use Modules\AdminSetting\Http\Requests\UpdatePaypalSettingRequest;
use Modules\AdminSetting\Http\Requests\UpdateShippingSettingRequest;
use Modules\AdminSetting\Http\Requests\UpdateSocialMediaSettingRequest;
use Modules\AdminSetting\Http\Requests\UpdateStripeSettingRequest;
use Modules\AdminSetting\Services\GeneralSettingService;
use Modules\AdminSetting\Services\UpdateCODSettingService;
use Modules\AdminSetting\Services\UpdateGoogleAnalyticsSettingService;
use Modules\AdminSetting\Services\UpdatePaypalSettingService;
use Modules\AdminSetting\Services\UpdateShippingSettingService;
use Modules\AdminSetting\Services\UpdateSocialMediaSettingService;
use Modules\AdminSetting\Services\UpdateStripeSettingService;

class AdminSettingController extends Controller
{
    public function index()
    {
        $data = [
            'menu' => 'settings',
            'sub_menu' => 'general',
        ];

        return view('adminsetting::index', $data);
    }

    public function updateGeneralSetting(UpdateGeneralRequest $request, GeneralSettingService $service)
    {
        $data = $request->validated();

        if ($service->handle($data)) {
            session()->flash('success_message', 'General setting updated successfully.');
        } else {
            session()->flash('error_message', 'General setting could not be updated.');
        }

        return redirect()->route('admin.settings');
    }

    public function paypalIndex()
    {
        $data = [
            'menu' => 'settings',
            'sub_menu' => 'paypal',
        ];

        return view('adminsetting::paypal', $data);
    }

    public function updatePaypalSetting(UpdatePaypalSettingRequest $request, UpdatePaypalSettingService $service)
    {
        $validatedData = $request->validated();

        if ($service->handle($validatedData)) {
            session()->flash('success_message', 'Paypal setting updated successfully.');
        } else {
            session()->flash('error_message', 'Paypal setting could not be updated.');
        }

        return redirect()->route('admin.settings.paypal');
    }

    public function stripeIndex()
    {
        $data = [
            'menu' => 'settings',
            'sub_menu' => 'stripe',
        ];

        return view('adminsetting::stripe', $data);
    }

    public function updateStripeSetting(UpdateStripeSettingRequest $request, UpdateStripeSettingService $service)
    {
        $validatedData = $request->validated();

        if ($service->handle($validatedData)) {
            session()->flash('success_message', 'Stripe setting updated successfully.');
        } else {
            session()->flash('error_message', 'Stripe setting could not be updated.');
        }

        return redirect()->route('admin.settings.stripe');
    }

    public function codIndex()
    {
        $data = [
            'menu' => 'settings',
            'sub_menu' => 'cod',
        ];

        return view('adminsetting::cod', $data);
    }

    public function updateCODSetting(UpdateCODSettingRequest $request, UpdateCODSettingService $service)
    {
        $validatedData = $request->validated();

        if ($service->handle($validatedData)) {
            session()->flash('success_message', 'Cash On Delivery setting updated successfully.');
        } else {
            session()->flash('error_message', 'Cash On Delivery setting could not be updated.');
        }

        return redirect()->route('admin.settings.cod');
    }

    public function shippingIndex()
    {
        $data = [
            'menu' => 'settings',
            'sub_menu' => 'shipping',
        ];

        return view('adminsetting::shipping', $data);
    }

    public function updateShippingSetting(UpdateShippingSettingRequest $request, UpdateShippingSettingService $service)
    {
        $validatedData = $request->validated();

        if ($service->handle($validatedData)) {
            session()->flash('success_message', 'Shipping setting updated successfully.');
        } else {
            session()->flash('error_message', 'Shipping setting could not be updated.');
        }

        return redirect()->route('admin.settings.shipping');
    }

    public function chatIndex()
    {
        $data = [
            'menu' => 'settings',
            'sub_menu' => 'chat',
        ];

        return view('adminsetting::chat', $data);
    }

    public function updateChatSetting(Request $request)
    {
        Option::set('chat_script', $request->chat_script);
        session()->flash('success_message', 'Chat setting updated successfully.');

        return redirect()->route('admin.settings.chat');
    }

    public function googleAnalyticsIndex()
    {
        $data = [
            'menu' => 'settings',
            'sub_menu' => 'googleanalytics',
        ];

        return view('adminsetting::google-analytics', $data);
    }

    public function updateGoogleAnalyticsSetting(UpdateGoogleAnalyticsSettingRequest $request, UpdateGoogleAnalyticsSettingService $service)
    {
        $validatedData = $request->validated();

        if ($service->handle($validatedData)) {
            session()->flash('success_message', 'GoogleAnalytics setting updated successfully.');
        } else {
            session()->flash('error_message', 'GoogleAnalytics setting could not be updated.');
        }

        return redirect()->route('admin.settings.googleanalytics');
    }

    public function socialMediaIndex()
    {
        $data = [
            'menu' => 'settings',
            'sub_menu' => 'socialmedia',
        ];

        return view('adminsetting::social-media', $data);
    }

    public function updateSocialMediaSetting(UpdateSocialMediaSettingRequest $request, UpdateSocialMediaSettingService $service)
    {
        $validatedData = $request->validated();

        if ($service->handle($validatedData)) {
            session()->flash('success_message', 'Social Media setting updated successfully.');
        } else {
            session()->flash('error_message', 'Social Media setting could not be updated.');
        }

        return redirect()->route('admin.settings.socialmedia');
    }
}
