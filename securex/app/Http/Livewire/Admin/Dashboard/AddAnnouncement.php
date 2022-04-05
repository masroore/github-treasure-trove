<?php

namespace App\Http\Livewire\Admin\Dashboard;

use App\Models\Admin\Announcement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class AddAnnouncement extends Component
{
    public $body;

    public function add()
    {
        $messages = [
            'body.required' => Lang::get('alerts.admin.settings.validation.announcement_msg_required'),
            'body.max' => Lang::get('alerts.admin.settings.validation.announcement_msg_max'),
        ];

        $this->validate([
            'body' => 'required|max:245',
        ], $messages);

        Announcement::create(['body' => $this->body, 'user' => Auth::user()->first_name]);

        laraflash(Lang::get('alerts.admin.settings.announcement_added'), Lang::get('alerts.success'))->success();

        return redirect()->route('admin.dashboard.index');
    }

    public function render()
    {
        return view('livewire.admin.dashboard.add-announcement');
    }
}
