<?php

namespace App\Http\Livewire\Profile;

use App\Models\Users\Country;
use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;
use Livewire\Component;

class UpdateProfile extends Component
{
    public $user;

    public $first_name;

    public $last_name;

    public $country;

    public $phone;

    public $dob;

    public $address_line1;

    public $address_line2;

    public $city;

    public $zipcode;

    public $state;

    public $rng_level;

    public $support_pin;

    public $countries;

    public $states;

    public $cc;

    protected $rules = [

    ];

    public function mount(): void
    {
        $this->user = auth()->user();
        $this->first_name = $this->user->first_name;
        $this->last_name = $this->user->last_name;
        $this->country = $this->user->country;
        $this->phone = $this->user->phone;
        $this->dob = $this->user->dob;
        $this->address_line1 = $this->user->address_line1;
        $this->address_line2 = $this->user->address_line2;
        $this->city = $this->user->city;
        $this->zipcode = $this->user->zipcode;
        $this->state = $this->user->state;
        $this->rng_level = $this->user->rng_level;
        $this->support_pin = $this->user->support_pin;
        $this->countries = Country::all();
    }

    public function updateStates(): void
    {
        $country = Country::where('name', $this->country)->first();
        if ($country) {
            $this->states = $country->states;
            $this->cc = $country->phonecode;
        }
    }

    public function updateProfile()
    {
        $validatedData = $this->validate([
            'first_name' => 'required|string|min:3|max:50',
            'last_name' => 'nullable|string|min:3|max:50',
            'phone' => 'nullable|numeric',
            'dob' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'nullable',
            'zipcode' => 'nullable',
            'address_line1' => 'nullable|string|max:200',
            'address_line2' => 'nullable|string|max:200',
            'rng_level' => 'required|numeric',
            'support_pin' => 'digits:4',
        ]);

        $now = Carbon::now()->toDateString();
        $dob = Carbon::parse($this->dob);

        // Checking if a future date is profile for Date of Birth.
        if ($dob->greaterThanOrEqualTo($now)) {
            return $this->addError('dob', Lang::get('alerts.profile.validation.dob_future'));
        }

        $this->user->update($validatedData);

        $this->emit('profileUpdated', true);
    }

    public function render()
    {
        if ($this->user->country) {
            $country = Country::where('name', $this->user->country)->first();
            if ($country) {
                $this->states = $country->states;
                $this->cc = $country->phonecode;
            }
        }

        return view('livewire.profile.update-profile');
    }
}
