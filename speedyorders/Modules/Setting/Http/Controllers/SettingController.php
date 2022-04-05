<?php

namespace Modules\Setting\Http\Controllers;

use App\Utils\Helper;
use App\Utils\Option;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Setting\Http\Requests\UpdateApiRequest;
use Modules\Setting\Http\Requests\UpdateAvantikRequest;
use Modules\Setting\Http\Requests\UpdateGeneralRequest;
use Modules\Setting\Http\Requests\UpdatePlazmaRequest;
use Modules\Setting\Http\Requests\UpdateSabreRequest;
use Modules\Setting\Services\ApiSettingService;
use Modules\Setting\Services\AvantikSettingService;
use Modules\Setting\Services\GeneralSettingService;
use Modules\Setting\Services\PlazmaSettingService;
use Modules\Setting\Services\SabreSettingService;

class SettingController extends Controller
{
    //const TICKET_FOLDER = 'tickets/';
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = [
            'menu' => 'settings',
            'sub_menu' => 'general',
        ];

        return view('setting::index', $data);
    }

    public function updateGeneralSetting(UpdateGeneralRequest $request, GeneralSettingService $service)
    {
        $data = $request->validated();

        if ($service->handle($data)) {
            session()->flash('success_message', 'General setting updated successfully.');
        } else {
            session()->flash('error_message', 'General setting could not be updated.');
        }

        return redirect()->route('settings.general');
    }

    public function ticket()
    {
        $data = [
            'menu' => 'settings',
            'sub_menu' => 'ticket',
        ];

        return view('setting::ticket', $data);
    }

    public function updateTicketSetting(Request $request)
    {
        try {
            Option::set('ticket_title', $request->ticket_title);
            Option::set('ticket_customer_support_email', $request->ticket_customer_support_email);
            Option::set('ticket_customer_support_phone', $request->ticket_customer_support_phone);
            Option::set('ticket_baggage_note', $request->ticket_baggage_note);
            Option::set('ticket_footer_note', $request->ticket_footer_note);
            Option::set('ticket_notice_note', $request->ticket_notice_note);

            if (isset($request->ticket_logo)) {
                Option::set('ticket_logo', $this->storeImage($request->ticket_logo));
            }

            if (isset($request->ticket_ad)) {
                Option::set('ticket_ad', $this->storeImage($request->ticket_ad));
            }
            session()->flash('success_message', 'Ticket setting updated successfully.');

            return redirect()->route('settings.ticket');
        } catch (Exception $e) {
            session()->flash('error_message', 'Ticket setting could not be updated.');

            return redirect()->route('settings.ticket');
        }
    }

    public function sabre()
    {
        $data = [
            'menu' => 'settings',
            'sub_menu' => 'sabre',
        ];

        return view('setting::sabre', $data);
    }

    public function updateSabre(UpdateSabreRequest $request, SabreSettingService $service)
    {
        $data = $request->validated();

        if ($service->handle($data)) {
            session()->flash('success_message', 'Sabre configuration saved successfully.');
        } else {
            session()->flash('error_message', 'Sabre Configuration could not be saved.');
        }

        return redirect()->back();
    }

    public function api()
    {
        $data = [
            'menu' => 'settings',
            'sub_menu' => 'api',
        ];

        return view('setting::api', $data);
    }

    public function updateApi(UpdateApiRequest $request, ApiSettingService $service)
    {
        $data = $request->validated();

        if ($service->handle($data)) {
            session()->flash('success_message', 'Api setting saved successfully.');
        } else {
            session()->flash('error_message', 'Api setting could not be saved.');
        }

        return redirect()->back();
    }

    public function plazma()
    {
        $data = [
            'menu' => 'settings',
            'sub_menu' => 'plazma',
        ];

        return view('setting::plazma', $data);
    }

    public function updatePlazmaSetting(UpdatePlazmaRequest $request, PlazmaSettingService $service)
    {
        $data = $request->validated();

        if ($service->handle($data)) {
            session()->flash('success_message', 'Domestic api setting saved successfully.');
        } else {
            session()->flash('error_message', 'Domestic api setting could not be saved.');
        }

        return redirect()->back();
    }

    public function avantik()
    {
        $data = [
            'menu' => 'settings',
            'sub_menu' => 'avantik',
        ];

        return view('setting::avantik', $data);
    }

    public function updateAvantikSetting(UpdateAvantikRequest $request, AvantikSettingService $service)
    {
        $data = $request->validated();

        if ($service->handle($data)) {
            session()->flash('success_message', 'Avantik setting updated successfully.');
        } else {
            session()->flash('error_message', 'Avantik setting could not be updated.');
        }

        return redirect()->back();
    }

    private function storeImage($file)
    {
        try {
            $name = time() . '-' . mt_rand() . '.' . $file->getClientOriginalExtension();

            Helper::fileUploadToCloud(config('minio.public.assets') . $name, file_get_contents($file), 'minio-public');

            return $name;
        } catch (Exception $e) {
            return;
        }
    }
}
