<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function getParam($key, $default)
    {
        if (!isset($_REQUEST[$key])) {
            return $default;
        }

        return $_REQUEST[$key];
    }

    public function generalFileUpload(Request $request, $key, $dir)
    {
        $ret = '';
        if ($request->hasFile($key)) {
            $fileData = $request->file($key);
            //$filename = $fileData->getClientOriginalName();
            $ext = $fileData->getClientOriginalExtension();

            $dest_dir = 'uploads/avatar/' . $dir;
            $filename = makeUploadFileName() . '.' . $ext;
            $fileData->move($dest_dir, $filename);
            $ret = $dest_dir . '/' . $filename;
        }

        return $ret;
    }

    public function getInactiveUser()
    {
        $customers = Customer::where('is_allow', '=', 'N')->where('role', '=', 'D')->get();

        return $customers;
    }
}
