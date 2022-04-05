<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibraryPro\Http\Livewire\Concerns\WithMedia;
use Spatie\MediaLibraryPro\Rules\Concerns\ValidatesMedia;

class UserSettings extends Component
{
    use ValidatesMedia;
    use WithFileUploads;
    use WithMedia;

    public User $user;

    public $country;

    public $about;

    public String $origAbout = '';

    public $email;

    public $username;

    public $name;

    public $sendMail;

    public $fstOffset;

    public $cclicense;

    public $copyright;

    public $changePassword;

    public $password;

    public $password_confirmation;

    public $instrument;

    public $userPicture;

    public $mediaComponentNames = ['userPicture'];

    protected $licenses = [
        'Attribution CC BY' => 0,
        'Attribution-ShareAlike CC BY-SA' => 1,
        'Attribution-NoDerivs CC BY-ND' => 2,
        'Attribution-NonCommercial CC BY-NC' => 3,
        'Attribution-NonCommercial-ShareAlike CC BY-NC-SA' => 4,
        'Attribution-NonCommercial-NoDerivs CC BY-NC-ND' => 5,
    ];

    protected $rules = [
        'name' => 'required|max:64|min:4',
        'email' => 'required|email',
        'about' => 'max:1000',
        'fstOffset' => 'numeric|min:-5.0|max:5.0',
        'copyright' => 'max:128',
    ];

    /**
     * Sets the database values.
     */
    public function mount(): void
    {
        $this->instrument = Auth::user()->stdtelescope;
        $this->username = $this->user->username;
        if ($this->user->about) {
            $this->origAbout = $this->user->about;
        } else {
            $this->origAbout = '';
        }
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->country = $this->user->country;
        $this->fstOffset = $this->user->fstOffset;
        $this->sendMail = $this->user->sendMail;

        if ('' == $this->user->copyright) {
            $this->cclicense = 6;
        } elseif (array_key_exists($this->user->copyright, $this->licenses)) {
            $this->cclicense = $this->licenses[$this->user->copyright];
        } else {
            $this->cclicense = 7;
        }

        $this->copyright = $this->user->copyright;
    }

    /**
     * Real time validation.
     *
     * @param mixed $propertyName The name of the property
     */
    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);

        if (in_array($this->cclicense, $this->licenses)) {
            $this->copyright = array_search($this->cclicense, $this->licenses);
        } elseif ($this->cclicense == 6) {
            $this->copyright = '';
        }

        if ($this->changePassword == 0) {
            $this->password = '';
            $this->password_confirmation = '';
        }

        if ($this->password !== '') {
            $this->validate(
                ['password' => ['required',
                    'min:8',
                    'regex:/[a-z]/',      // must contain at least one lowercase letter
                    'regex:/[A-Z]/',      // must contain at least one uppercase letter
                    'regex:/[0-9]/',      // must contain at least one digit
                    'regex:/[@$!%*#?&^]/',
                    'confirmed', ]]
            );
        }
    }

    /**
     * Method that is called when the submit button is pushed.
     */
    public function save(): void
    {
        $this->validate();

        $this->user->update(['email' => $this->email]);
        $this->user->update(['name' => $this->name]);
        $this->user->update(['country' => $this->country]);
        $this->user->update(['about' => $this->about['body']]);
        $this->user->update(['sendMail' => $this->sendMail]);
        $this->user->update(['fstOffset' => $this->fstOffset]);
        $this->user->update(['copyright' => $this->copyright]);

        // Password change
        if ($this->password !== '') {
            $this->validate(
                ['password' => ['required',
                    'min:8',
                    'regex:/[a-z]/',      // must contain at least one lowercase letter
                    'regex:/[A-Z]/',      // must contain at least one uppercase letter
                    'regex:/[0-9]/',      // must contain at least one digit
                    'regex:/[@$!%*#?&^]/',
                    'confirmed', ]]
            );
            $this->user->update(['password' => $this->password]);
        }

        // Upload of the image
        if ($this->userPicture) {
            if (User::find($this->user->id)->getFirstMedia('observer') != null
            ) {
                // First remove the current image
                User::find($this->user->id)
                    ->getFirstMedia('observer')
                    ->delete();
            }

            // Update the picture
            User::find($this->user->id)
                ->addFromMediaLibraryRequest($this->userPicture)
                ->toMediaCollection('observer');

            $this->emit('newProfilePicture', $this->userPicture);
            $this->clearMedia();
        }

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
        return view('livewire.user.user-settings', ['licenses' => $this->licenses]);
    }
}
