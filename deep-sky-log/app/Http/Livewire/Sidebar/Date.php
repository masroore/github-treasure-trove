<?php

namespace App\Http\Livewire\Sidebar;

use App\Models\Astrolib;
use Exception;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Date extends Component
{
    public $carbonDate;

    public $carbonDateString;

    public $date;

    public $location;

    public function mount(): void
    {
        // Current date
        $dslDate = Session::get('date');
        $date = \Carbon\Carbon::createFromFormat('Y-m-d', $dslDate);
        $date->hour = 12;
        $this->carbonDate = $date;
        $this->carbonDateString = $this->carbonDate->isoFormat('LL');
        $this->date = $this->carbonDate;
    }

    /**
     * Set the session when updating.
     *
     * @param mixed $propertyName The name of the property
     */
    public function updated($propertyName): void
    {
        try {
            $date = \Carbon\Carbon::parseFromLocale($this->carbonDateString, \deepskylog\LaravelGettext\Facades\LaravelGettext::getLocaleLanguage());
            $date->hour = 12;
            $this->carbonDate = $date;
            Astrolib::getInstance()->getAstronomyLibrary()->setDate($date);

            Request::session()->put('date', $date->isoFormat('Y-M-D'));
            $this->date = $date;
            $this->emit('dateChanged');
        } catch (Exception $e) {
        }
    }

    public function render()
    {
        return view('livewire.sidebar.date');
    }
}
