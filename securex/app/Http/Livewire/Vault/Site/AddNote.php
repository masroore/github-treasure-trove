<?php

namespace App\Http\Livewire\Vault\Site;

use App\Models\Vaults\Site;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class AddNote extends Component
{
    use AuthorizesRequests;

    public $site;

    public $note;

    public function mount(Site $site): void
    {
        $this->site = $site;
    }

    public function addNote(): void
    {
        $this->validate([
            'note' => 'required|string|max:235',
        ]);

        $this->authorize('update', $this->site);

        $this->site->notes()->create(['body' => $this->note, 'user_id' => auth()->user()->id]);

        $this->emit('noteAdded', Lang::get('alerts.site.note_added'));

        $this->note = null;
    }

    public function render()
    {
        return view('livewire.vault.site.add-note');
    }
}
