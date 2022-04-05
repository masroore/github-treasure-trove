<?php

namespace App\Http\Livewire\Vault;

use App\Models\Vaults\Vault;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class UpdateVault extends Component
{
    public $vault;

    public $name;

    public $description;

    public $icon;

    public $color;

    public function mount(Vault $vault): void
    {
        $this->vault = $vault;
        $this->name = $vault->name;
        $this->description = $vault->description;
        $this->icon = $vault->icon;
        $this->color = $vault->color;
    }

    public function update()
    {
        $messages = [
            'name.required' => Lang::get('alerts.vault.validation.name_required'),
            'name.min' => Lang::get('alerts.vault.validation.name_min'),
            'name.max' => Lang::get('alerts.vault.validation.name_max'),
            'name.string' => Lang::get('alerts.vault.validation.name_string'),
            'description.required' => Lang::get('alerts.vault.validation.description_required'),
            'description.min' => Lang::get('alerts.vault.validation.description_min'),
            'description.max' => Lang::get('alerts.vault.validation.description_max'),
            'icon.required' => Lang::get('alerts.vault.validation.icon_required'),
            'color.required' => Lang::get('alerts.vault.validation.color_required'),
        ];

        $this->validate([
            'name' => 'required|string|min:3|max:14',
            'description' => 'required|string|min:5|max:245',
            'icon' => 'required',
            'color' => 'required',
        ], $messages);

        $this->vault->update([
            'name' => $this->name,
            'description' => $this->description,
            'icon' => $this->icon,
            'color' => $this->color,
        ]);

        laraflash($this->vault->name . ' - ' . Lang::get('alerts.vault.general_updated'), Lang::get('alerts.success'))->success();

        return redirect()->route('vaults.select.settings', $this->vault);
    }

    public function render()
    {
        return view('livewire.vault.update-vault');
    }
}
