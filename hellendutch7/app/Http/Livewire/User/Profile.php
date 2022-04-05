<?php

namespace App\Http\Livewire\User;

use Livewire\Component;

class Profile extends Component
{
    public $name = '';

    public $about = '';

    public function mount(): void
    {
        $this->name = auth()->user()->name;
        $this->about = auth()->user()->about;
    }

    public function render()
    {
        return view('livewire.user.profile');
    }

    public function save(): void
    {
        $profileData = $this->validate([
            'name' => 'max:24',
            'about' => 'max:140',
        ]);

        auth()->user()->update($profileData);

        $this->emitSelf('notify-saved');
    }
}
