<?php

namespace App\Http\Livewire\User;

use deepskylog\LaravelGettext\Facades\LaravelGettext;
use Livewire\Component;

class Register extends Component
{
    public $username;

    public $name;

    public $email;

    public $password;

    public $password_confirmation;

    public String $cclicense;

    public String $copyright;

    public $country;

    public $observationlanguage;

    public $language;

    protected $rules = [
        'username' => [
            'required', 'string', 'max:255', 'min:2', 'unique:users',
        ],
        'name' => ['required', 'string', 'max:255', 'min:5'],
        'email' => [
            'required', 'string', 'email', 'max:255', 'unique:users',
        ],
    ];

    protected $licenses = [
        'Attribution CC BY' => 0,
        'Attribution-ShareAlike CC BY-SA' => 1,
        'Attribution-NoDerivs CC BY-ND' => 2,
        'Attribution-NonCommercial CC BY-NC' => 3,
        'Attribution-NonCommercial-ShareAlike CC BY-NC-SA' => 4,
        'Attribution-NonCommercial-NoDerivs CC BY-NC-ND' => 5,
    ];

    /**
     * Sets the database values.
     */
    public function mount(): void
    {
        $this->cclicense = 0;
        $this->copyright = 'Attribution CC BY';

        $this->observationlanguage = LaravelGettext::getLocaleLanguage();
        $this->language = LaravelGettext::getLocale();
    }

    /**
     * Real time validation.
     *
     * @param mixed $propertyName The name of the property
     */
    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);

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

        if (in_array($this->cclicense, $this->licenses)) {
            $this->copyright = array_search($this->cclicense, $this->licenses);
        } elseif ($this->cclicense == 6) {
            $this->copyright = '';
        }
    }

    public function render()
    {
        return view('livewire.user.register', ['licenses' => $this->licenses]);
    }
}
