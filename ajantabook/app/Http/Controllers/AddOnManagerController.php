<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;
use Nwidart\Modules\Facades\Module;
use Yajra\DataTables\Facades\DataTables;
use ZipArchive;

class AddOnManagerController extends Controller
{
    public function index()
    {
        abort_if(!auth()->user()->can('addon-manager.manage'), 403, __('User does not have the right permissions.'));

        $modules = Module::toCollection();

        $modules = $modules->map(function ($module) {
            $json = @file_get_contents(base_path() . '/Modules/' . $module . '/module.json');

            $module = json_decode($json, true);

            $module['status'] = Module::find($module['name'])->isEnabled() ? 1 : 0;

            return $module;
        });

        if (request()->ajax()) {
            return DataTables::of($modules)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    return '<img width="100px" class="img-responsive pull-left" src="' . Module::asset($row['alias'] . ':logo/' . $row['alias'] . '.png') . '"/>';
                })
                ->addColumn('name', function ($row) {
                    $html = '<b>' . $row['name'] . '</b>';
                    $html .= '<p>' . $row['description'] . '</p>';

                    return $html;
                })
                ->addColumn('status', 'admin.addonmanager.status')
                ->addColumn('version', function ($row) {
                    return $row['version'];
                })
                ->addColumn('action', 'admin.addonmanager.action')
                ->rawColumns(['image', 'name', 'status', 'version', 'action'])
                ->make(true);
        }

        return view('admin.addonmanager.index', compact('modules'));
    }

    public function toggle(Request $request)
    {
        abort_if(!auth()->user()->can('addon-manager.manage'), 403, __('User does not have the right permissions.'));

        if ($request->ajax()) {
            $module = Module::find($request->modulename);

            if (!isset($module)) {
                return response()->json(['msg' => __('Module not found'), 'status' => 'fail']);
            }

            if (1 == env('DEMO_LOCK')) {
                return response()->json(['msg' => __('This action is disabled in demo !'), 'status' => 'fail']);
            }

            if (0 == $request->status) {
                $module->disable();

                return response()->json(['msg' => __(':module Module disabled !', ['module' => $request->modulename]), 'status' => 'success']);
            }
            $module->enable();

            return response()->json(['msg' => __(':module Module enabled !', ['module' => $request->modulename]), 'status' => 'success']);
        }
    }

    public function install(Request $request)
    {
        abort_if(!auth()->user()->can('addon-manager.manage'), 403, __('User does not have the right permissions.'));

        $validator = Validator::make(
            [
                'purchase_code' => 'required',
                'addon_file' => 'required',
                'file' => $request->addon_file,
                'extension' => strtolower($request->addon_file->getClientOriginalExtension()),
            ],
            [
                'purchase_code' => 'required',
                'file' => 'required',
                'extension' => 'required|in:zip,7zip,gzip',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors(__('File should be a valid add-on zip file !'));
        }

        ini_set('max_execution_time', 300);

        $verify = $this->verifycode();

        if (200 !== $verify) {
            return back()->withErrors(filter_var($verify));
        }

        $filename = $request->addon_file;

        $modulename = str_replace('.' . $filename->getClientOriginalExtension(), '', $filename->getClientOriginalName());

        $zip = new ZipArchive();

        $zipped = $zip->open($filename, ZipArchive::CREATE);

        if ($zipped) {
            $extract = $zip->extractTo(base_path() . '/Modules/');

            if ($extract) {
                $module = Module::find($modulename);

                $module->enable();

                Artisan::call('module:publish');

                Artisan::call('migrate'); //If any database tables to migrate

                Artisan::call('module:update ' . $modulename); //If any external pkg. to install.

                notify()->success(__(':module Module Installed Successfully', ['module' => $modulename]), __('Installed'));

                return back();
            }
        }

        $zip->close();
    }

    public function verifycode()
    {
        $code = request()->purchase_code;

        //NL

        $personalToken = '7T9Ichy4xYzXyfDpYjBKwvdYWe48GX5s';

        if (!preg_match('/^(\\w{8})-((\\w{4})-){3}(\\w{12})$/', $code)) {
            //throw new Exception("Invalid code");
            return __('Invalid Purchase Code');
        }

        $ch = curl_init($code);

        curl_setopt_array($ch, [
            \CURLOPT_URL => "https://api.envato.com/v3/market/author/sale?code={$code}",
            \CURLOPT_RETURNTRANSFER => true,
            \CURLOPT_TIMEOUT => 20,

            \CURLOPT_HTTPHEADER => [
                "Authorization: Bearer {$personalToken}",
            ],
        ]);

        // Send the request with warnings supressed
        $response = curl_exec($ch);

        // Handle connection errors (such as an API outage)
        if (curl_errno($ch) > 0) {
            //throw new Exception("Error connecting to API: " . curl_error($ch));
            return __('Error connecting to API !');
        }
        // If we reach this point in the code, we have a proper response!
        // Let's get the response code to check if the purchase code was found
        $responseCode = curl_getinfo($ch, \CURLINFO_HTTP_CODE);

        // HTTP 404 indicates that the purchase code doesn't exist
        if (403 === $responseCode) {
            //throw new Exception("The purchase code was invalid");
            return $this->reverify();
        }

        // HTTP 404 indicates that the purchase code doesn't exist
        if (404 === $responseCode) {
            //throw new Exception("The purchase code was invalid");
            return $this->reverify();
        }

        // Anything other than HTTP 200 indicates a request or API error
        // In this case, you should again ask the user to try again later
        if (200 !== $responseCode) {
            //throw new Exception("Failed to validate code due to an error: HTTP {$responseCode}");
            return $this->reverify();
        }

        // Parse the response into an object with warnings supressed
        $body = json_decode($response);

        // Check for errors while decoding the response (PHP 5.3+)
        if (false === $body && \JSON_ERROR_NONE !== json_last_error()) {
            //new Exception("Error parsing response");
            return $this->reverify();
        }

        return $responseCode;
    }

    public function reverify()
    {

        //MCP

        $personalToken = 'inNy83FTjV2CTPqvNdPGRr2mAJ0raPC4';

        $code = request()->purchase_code;

        $ch = curl_init($code);

        curl_setopt_array($ch, [
            \CURLOPT_URL => "https://api.envato.com/v3/market/author/sale?code={$code}",
            \CURLOPT_RETURNTRANSFER => true,
            \CURLOPT_TIMEOUT => 20,

            \CURLOPT_HTTPHEADER => [
                "Authorization: Bearer {$personalToken}",
            ],
        ]);

        // Send the request with warnings supressed
        $response = curl_exec($ch);

        // Handle connection errors (such as an API outage)
        if (curl_errno($ch) > 0) {
            //throw new Exception("Error connecting to API: " . curl_error($ch));
            return __('Error connecting to API !');
        }
        // If we reach this point in the code, we have a proper response!
        // Let's get the response code to check if the purchase code was found

        $responseCode = curl_getinfo($ch, \CURLINFO_HTTP_CODE);

        // HTTP 404 indicates that the purchase code doesn't exist
        if (404 === $responseCode) {
            //throw new Exception("The purchase code was invalid");
            return __('The purchase code was invalid.');
        }

        // Anything other than HTTP 200 indicates a request or API error
        // In this case, you should again ask the user to try again later
        if (200 !== $responseCode) {
            //throw new Exception("Failed to validate code due to an error: HTTP {$responseCode}");
            return __('Failed to validate code.');
        }

        // Parse the response into an object with warnings supressed
        $body = json_decode($response);

        // Check for errors while decoding the response (PHP 5.3+)
        if (false === $body && \JSON_ERROR_NONE !== json_last_error()) {
            //new Exception("Error parsing response");
            return __("Can't Verify Now.");
        }

        if ('25300293' == $body->item->id) {
            if ('Extended License' == $body->license) {
                return 200;
            }

            return 404;
        }

        return 404;

        return $responseCode;
    }

    public function delete(Request $request)
    {
        abort_if(!auth()->user()->can('addon-manager.manage'), 403, __('User does not have the right permissions.'));

        if (1 == env('DEMO_LOCK')) {
            notify()->error(__('This function is disabled in demo !'));

            return back();
        }

        $module = Module::find($request->modulename);

        if (!isset($module)) {
            notify()->error(__('Module not found !'), '404');

            return back();
        }

        $module->delete();

        notify()->success(__('Module deleted !'), 'Success');

        return back();
    }
}
