<?php

namespace App\Http\Livewire\Admin\Settings\System;

use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;
use Purifier;
use TechTailor\RPG\Facade\RPG;

class MaintenanceMode extends Component
{
    public $secret;

    public $message;

    public function mount(): void
    {
        $this->secret = RPG::Generate('ln', 32, 1, 0);
        $this->message = 'Server Down for Maintenance';
    }

    public function activate()
    {
        $messages = [
            'message.required' => 'A maintenance message is required.',
            'secret.required' => 'A secret code is required for generating the secret access url.',
        ];

        $this->validate([
            'message' => 'required',
            'secret' => 'required|string',
        ], $messages);

        $this->message = Purifier::clean($this->message);

        Artisan::call('down', ['--secret' => $this->secret]);

        $file = json_decode(file_get_contents(storage_path('framework/down')));

        $f = json_encode([
            'time' => Carbon::now(),
            'message' => $this->message,
            'secret' => $file->secret,
            'redirect' => $file->redirect,
            'retry' => $file->retry,
            'status' => $file->status,
            'template' => $file->template,
        ]);

        $update = file_put_contents(storage_path('framework/down'), $f);

        laraflash(Lang::get('alerts.admin.settings.system.maintenance_activated'), Lang::get('alerts.success'))->success();

        return redirect()->route('admin.settings.system.index');
    }

    public function deactivate(): void
    {
    }

    public function render()
    {
        return view('livewire.admin.settings.system.maintenance-mode');
    }
}
