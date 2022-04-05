<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Models\Admin\ScheduledTasksExecuted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class AutomationSettingController extends Controller
{
    /**
     * Adding auth middleware to this controller.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', '2fa', 'is_admin', 'password.confirm']);
    }

    /**
     * Display the automation settings page.
     */
    public function index()
    {
        $backup_task = ScheduledTasksExecuted::where('command', 'backup:run --only-db')->latest()->first();

        return view('admin.settings.automation.index', compact('adc_task', 'alc_task', 'backup_task'));
    }

    /**
     * Adding the MYSQL DUMP PATH for Backup Manager.
     */
    public function addMysqlPath(Request $request)
    {
        $messages = [
            'db_mysql_dump_path.required' => Lang::get('alerts.admin.settings.validation.mysql_dump_path_required'),
        ];

        $this->validate($request, [
            'db_mysql_dump_path' => 'required',
        ], $messages);

        setting()->set('db_mysql_dump_path', $request->db_mysql_dump_path);

        laraflash(Lang::get('alerts.admin.settings.automation.mysql_dump_update_success'), Lang::get('alerts.success'))->success();

        return back();
    }
}
