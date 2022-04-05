<?php

namespace App\Http\Livewire\Admin\Modules\Recaptcha;

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
        if (setting()->get('recaptcha_site_key') == null || setting()->get('recaptcha_secret_key') == null) {
            laraflash(Lang::get('alerts.admin.modules.configuration_required'), Lang::get('alerts.sorry'))->warning();

            return redirect()->route('admin.modules.index');
        }

        setting()->set('recaptcha_enabled', !$this->enabled);

        if ($this->enabled) {
            laraflash(Lang::get('alerts.admin.modules.recaptcha.disabled'), Lang::get('alerts.warning'))->danger();
        } else {
            laraflash(Lang::get('alerts.admin.modules.recaptcha.enabled'), Lang::get('alerts.success'))->success();
        }

        return redirect()->route('admin.modules.index');
    }

    public function render()
    {
        return view('livewire.admin.modules.recaptcha.toggle');
    }
}
