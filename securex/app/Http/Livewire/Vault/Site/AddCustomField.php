<?php

namespace App\Http\Livewire\Vault\Site;

use App\Models\Vaults\Site;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class AddCustomField extends Component
{
    use AuthorizesRequests;

    public $name;

    public $value;

    public $site;

    public $field;

    public function mount(Site $site): void
    {
        $this->site = $site;
    }

    public function addField(): void
    {
        $this->validate([
            'name' => 'required|string|max:25',
            'value' => 'required|string|max:235',
        ]);

        $this->authorize('update', $this->site);

        $field = $this->site->custom_fields()->create(['name' => $this->name, 'value' => $this->value]);

        $this->emit('fieldAdded', Lang::get('alerts.site.custom_field_added'));

        $this->resetInput();
    }

    public function resetInput(): void
    {
        $this->name = null;
        $this->value = null;
    }

    public function render()
    {
        return view('livewire.vault.site.add-custom-field', [
            's' => $this->site,
        ]);
    }
}
