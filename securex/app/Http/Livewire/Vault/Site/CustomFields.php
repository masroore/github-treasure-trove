<?php

namespace App\Http\Livewire\Vault\Site;

use App\Models\Vaults\Site;
use App\Models\Vaults\SiteCustomField;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class CustomFields extends Component
{
    use AuthorizesRequests;

    public $site;

    public $fields;

    public $df;

    public function mount(Site $site): void
    {
        $this->site = $site;
    }

    protected $listeners = ['fieldDeleted' => 'render', 'fieldAdded' => 'render'];

    public function deleteField($field)
    {
        $this->authorize('update', $this->site);

        if ($field) {
            $dField = SiteCustomField::find($field);
            $dField->delete();
            $this->emit('fieldDeleted', Lang::get('alerts.site.custom_field_deleted'));
        } else {
            return back();
        }
    }

    public function render()
    {
        return view('livewire.vault.site.custom-fields', [
            'cfields' => $this->site->custom_fields,
        ]);
    }
}
