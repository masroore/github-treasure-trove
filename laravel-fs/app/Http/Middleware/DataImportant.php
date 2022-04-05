<?php

namespace App\Http\Middleware;

use App\Helpers\Encryptor;
use App\Models\AccessHistory;
use App\Models\ImportantSetting;
use App\Models\Process;
use Closure;

use Illuminate\Support\Facades\Auth;
use Request;

class DataImportant
{
    protected $dataExclude = ['_token'];

    protected $routeSaveDataGet = ['delete', 'reactivate', 'reset_password', 'delete_logged', 'change_status'];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $position_point = strpos(Request::route()->getName(), '.');
        if ($position_point === false) {
            $nameRoute = Request::route()->getName();
            $data = ['action' => $nameRoute];
            $actionRouteGet = Request::route()->getName();
        } else {
            $nameRoute = explode('.', Request::route()->getName());
            $data = ['action' => $nameRoute[1]];
            $actionRouteGet = $nameRoute[1];
            $nameRoute = $nameRoute[0];
        }
        $Process = Process::where('route', $nameRoute)->first();
        $AccessHistory = AccessHistory::whereNull('date_out')->where('user_id', Auth::user()->id)->first();
        if ($AccessHistory != null && $Process != null) {
            $data = [];
            if ($request->isMethod('post')) {
                foreach ($request->all() as $key => $value) {
                    if (!in_array($key, $this->dataExclude)) {
                        $data[$key] = $value == null ? '' : $value;
                    }
                }
            } else {
                if (in_array($actionRouteGet, $this->routeSaveDataGet)) {
                    foreach ($request->route()->parameters as $key => $value) {
                        if (!in_array($key, $this->dataExclude)) {
                            if ($key == 'id') {
                                $value_aux = Encryptor::decrypt($value);
                            } else {
                                $value_aux = $value;
                            }
                            $data[$key] = $value_aux == null ? '' : $value_aux;
                        }
                    }
                    if (count($data) > 0) {
                        $data['action'] = $actionRouteGet;
                    }
                }
            }
            if (count($data) > 0) {
                $ImportantSetting = new ImportantSetting();
                $ImportantSetting->access_history_id = $AccessHistory->id;
                $ImportantSetting->process_id = $Process->id;
                $ImportantSetting->date_access = now();
                $ImportantSetting->processed_data = json_encode($data);
                $ImportantSetting->save();
            }
        }

        return $next($request);
    }
}
