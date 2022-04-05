<?php

namespace App\Http\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Menu extends Component
{
    public $picture;

    protected $listeners = ['newProfilePicture' => 'newProfilePicture'];

    public function newProfilePicture($userPicture): void
    {
        if ($userPicture) {
            $this->picture = reset($userPicture)['previewUrl'];
        }
    }

    public function mount(): void
    {
        $this->picture = '/users/' . Auth::user()->slug . '/getImage';
    }

    public function render()
    {
        return view('livewire.user.menu');
    }
}
