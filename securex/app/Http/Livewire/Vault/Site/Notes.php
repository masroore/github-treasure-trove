<?php

namespace App\Http\Livewire\Vault\Site;

use App\Models\Vaults\Site;
use App\Models\Vaults\SiteNote;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class Notes extends Component
{
    use AuthorizesRequests;

    public $site;

    public function mount(Site $site): void
    {
        $this->site = $site;
    }

    protected $listeners = ['noteDeleted' => 'render', 'noteAdded' => 'render'];

    public function deleteNote($note)
    {
        if ($note) {
            $dNote = SiteNote::find($note);
            $dNote->delete();
            $this->emit('noteDeleted', Lang::get('alerts.site.note_deleted'));
        } else {
            return back();
        }
    }

    public function render()
    {
        return view('livewire.vault.site.notes', [
            'notes' => $this->site->notes,
        ]);
    }
}
