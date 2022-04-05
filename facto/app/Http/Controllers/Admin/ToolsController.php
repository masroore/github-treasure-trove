<?php

namespace App\Http\Controllers\Admin;

use App\Cronjob;
use App\Http\Controllers\Controller;

class ToolsController extends Controller
{
    public function status()
    {
        $cronjob = Cronjob::find(1);

        return view('admin.tools.cronjob')->with('cronjob', $cronjob);
        // $status = $cronjob->status;
      // $job_title = $cronjob->job_title;
      // $updated_at = $cronjob->updated_at;
    }
}
