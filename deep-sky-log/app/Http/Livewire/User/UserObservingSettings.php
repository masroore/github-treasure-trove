<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;

class UserObservingSettings extends Component
{
    public User $user;

    public $stdlocation;

    public $stdinstrument;

    public $stdeyepiece;

    public $stdlens;

    public $standardAtlasCode;

    public $showInches;

    /**
     * Sets the database values.
     */
    public function mount(): void
    {
        $this->stdlocation = $this->user->stdlocation;
        $this->stdinstrument = $this->user->stdtelescope;
        $this->stdeyepiece = $this->user->stdeyepiece;
        $this->stdlens = $this->user->stdlens;
        $this->standardAtlasCode = $this->user->standardAtlasCode;
        $this->showInches = $this->user->showInches;
    }

    /**
     * Method that is called when the submit button is pushed.
     */
    public function save(): void
    {
        // $this->validate();

        $this->user->update(['stdlocation' => $this->stdlocation]);
        $this->user->update(['stdtelescope' => $this->stdinstrument]);
        $this->user->update(['stdeyepiece' => $this->stdeyepiece]);
        $this->user->update(['stdlens' => $this->stdlens]);
        $this->user->update(['standardAtlasCode' => $this->standardAtlasCode]);
        $this->user->update(['showInches' => $this->showInches]);

        // Message if there was an error or if the changes were written succesfully
        session()->flash('message', 'Settings successfully updated.');
    }

    /**
     * Render the page.
     *
     * @return Factory|View The view for the livewire component
     */
    public function render()
    {
        return view('livewire.user.user-observing-settings');
    }
}
