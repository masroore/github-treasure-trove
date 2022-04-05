<?php

namespace App\Http\Livewire\Admin\Dashboard;

use App\Models\Admin\Announcement;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class DeleteAnnouncement extends Component
{
    public $announcement;

    public function mount(Announcement $announcement): void
    {
        $this->announcement = $announcement;
    }

    public function deleteAnnouncement()
    {
        $this->announcement->delete();

        laraflash(Lang::get('alerts.admin.settings.announcement_deleted'), Lang::get('alerts.success'))->success();

        return redirect()->route('admin.dashboard.index');
    }

    public function render()
    {
        return view('livewire.admin.dashboard.delete-announcement', [
            'announcement' => $this->announcement,
        ]);
    }
}
