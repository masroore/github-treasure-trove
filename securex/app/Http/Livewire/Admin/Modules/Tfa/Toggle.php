<?php

namespace App\Http\Livewire\Admin\Modules\Tfa;

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
        setting()->set('tfa_enabled', !$this->enabled);

        if ($this->enabled) {
            laraflash(Lang::get('alerts.admin.modules.tfa.disabled'), Lang::get('alerts.warning'))->danger();
        } else {
            laraflash(Lang::get('alerts.admin.modules.tfa.enabled'), Lang::get('alerts.success'))->success();
        }

        return redirect()->route('admin.modules.index');
    }

    public function render()
    {
        return view('livewire.admin.modules.tfa.toggle');
    }
}
