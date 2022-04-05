<?php

namespace App\Http\Livewire\Vault\Folder;

use App\Models\Vaults\Folder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class DeleteFolder extends Component
{
    use AuthorizesRequests;

    public $folder;

    public $password;

    public $confirm;

    public $delete_sites;

    // Mount Folder to the Component
    public function mount(Folder $folder): void
    {
        $this->folder = $folder;
    }

    /**
     * Delete a Folder.
     */
    public function deleteFolder()
    {
        $vault = $this->folder->vault;

        // Verify if the user is authorize to update the vault and the folder
        $this->authorize('update', $vault);
        $this->authorize('update', $this->folder);

        $messages = [
            'password.required' => 'Master Password is required.',
            'confirm.required' => 'Delete Confirmation is required.',
            'delete_sites.required' => 'Select whether to delete sites or not.',
        ];

        $this->validate([
            'password' => 'required',
            'confirm' => 'required',
            'delete_sites' => 'required',
        ], $messages);

        $user = Auth::user();
        // Check if the master password matches.
        if (!Hash::check($this->password, $user->password)) {
            return $this->addError('password', 'Master Password does not match our records.');
        }

        if (!$this->confirm) {
            return $this->addError('confirm', 'Confirmation for Deletion is required.');
        }

        // Retrive all sites linked to this folder.
        $sites = $this->folder->sites;

        // Detach each site from the folder one-by-one.
        foreach ($sites as $site) {
            $this->folder->sites()->detach($site);
        }

        // If selected, delete all linked sites aswell.
        if ($this->delete_sites) {
            foreach ($sites as $site) {
                $site->delete();
            }

            laraflash('All sites in the ' . $this->folder->name . ' Folder Has Been Deleted.', 'Alert!')->info();
        }

        // Delete the folder.
        $this->folder->delete();

        laraflash('Folder Has Been Deleted.')->success();

        return redirect()->route('vaults.select', $vault);
    }

    // Render the View Component
    public function render()
    {
        return view('livewire.vault.folder.delete-folder');
    }
}
