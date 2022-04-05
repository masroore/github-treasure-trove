<?php

namespace App\Http\Livewire\Vault\Folder;

use App\Mail\Alerts\FolderLimitReached as FolderLimitReachedMail;
use App\Models\Vaults\Vault;
use App\Notifications\User\FolderLimitReached;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class CreateFolder extends Component
{
    use AuthorizesRequests;

    public $name;

    public $icon = 'hdd';

    public $vault;

    public $folder;

    public $validatedData;

    // Mount the Livewire Component
    public function mount(Vault $vault): void
    {
        $this->vault = $vault;
    }

    // Create new folder.
    public function createFolder(): void
    {
        $messages = [
            'name.required' => 'Folder Name is required',
            'name.min' => 'Folder Name must contain minimum 3 characters',
            'name.max' => 'Folder Name can have maximum 14 characters',
            'icon.required' => 'Folder Icon is required',
        ];

        $this->validatedData = $this->validate([
            'name' => 'required|min:3|max:14',
            'icon' => 'required',
        ], $messages);

        $this->authorize('update', $this->vault);

        $this->storeFolder();
    }

    // Store new Folder in the database.
    public function storeFolder()
    {
        $user = Auth::user();

        if ($user->hasReachedFolderLimit()) {
            laraflash('Folder Limit Reached. Cannot create new folder', 'Sorry!')->danger();

            return redirect()->route('vaults.select', $this->vault);
        }

        $folder = $this->vault->folders()->create($this->validatedData);

        if ($user->hasReachedFolderLimit()) {
            $user->notify(new FolderLimitReached());
            if (setting()->get('app_email_alerts') === 'true') {
                Mail::to($user->email)->send(new FolderLimitReachedMail($user));
            }
        }

        laraflash(Lang::get('alerts.vault.folder_created', ['folder' => $folder->name]), Lang::get('alerts.success'))->success();

        return redirect()->route('vaults.select', $this->vault);
    }

    // Render the view component
    public function render()
    {
        return view('livewire.vault.folder.create-folder');
    }
}
