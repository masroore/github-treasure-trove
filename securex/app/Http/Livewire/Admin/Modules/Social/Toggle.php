<?php

namespace App\Http\Livewire\Admin\Modules\Social;

use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class Toggle extends Component
{
    public $enabled;

    public function mount($enabled): void
    {
        $this->enabled = $enabled;
    }

    public function switch()
    {
        if (setting()->get('app_mode') == 'PRIVATE') {
            laraflash(Lang::get('alerts.admin.modules.social.public_mode_required'), Lang::get('alerts.warning'))->danger();

            return redirect()->route('admin.modules.index');
        }

        setting()->set('social_logins_enabled', !$this->enabled);

        if ($this->enabled) {
            laraflash(Lang::get('alerts.admin.modules.social.disabled'), Lang::get('alerts.warning'))->danger();
        } else {
            laraflash(Lang::get('alerts.admin.modules.social.enabled'), Lang::get('alerts.success'))->success();
        }

        return redirect()->route('admin.modules.index');
    }

    public function render()
    {
        return view('livewire.admin.modules.social.toggle');
    }
}
