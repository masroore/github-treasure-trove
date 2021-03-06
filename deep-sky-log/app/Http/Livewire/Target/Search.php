<?php

namespace App\Http\Livewire\Target;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Search extends Component
{
    public bool $addExtraSearchParameter = false;

    public String $allCatalogs;

    public String $allAtlases;

    public String $constellations;

    public String $types;

    public String $allInstruments;

    public String $allLocations;

    public $catalog;

    // The list with all search criteria that can be used
    public String $searchCriteria;

    // The string with all the html code for the search
    public String $searchHtml = '';

    public array $searchArray = [];

    public $criteria;

    public $numberOfConstellations = 0;

    public $numberOfTypes = 0;

    public $numberOfNames = 0;

    public $constellation;

    public $numberOfSearchOptions = 0;

    public $numberOfAtlases = 0;

    public $numberOfDeclinations = 0;

    public $numberOfRa = 0;

    public $numberOfMagnitude = 0;

    public $numberOfSubr = 0;

    public $numberOfDiameter = 0;

    public $numberOfDiameterRatio = 0;

    public $numberOfDescription = 0;

    public $numberOfContrastReserve = 0;

    public function mount(): void
    {
        $this->searchCriteria = '<option value=""></option>';
        $this->searchCriteria .= '<option value="name">' . _i('Object name') . '</option>';
        $this->searchCriteria .= '<option value="constellation">' . _i('Constellation') . '</option>';
        $this->searchCriteria .= '<option value="type">' . _i('Object type') . '</option>';
        $this->searchCriteria .= '<option value="atlas">' . _i('Atlas page') . '</option>';
        $this->searchCriteria .= '<option value="ra">' . _i('Right Ascension') . '</option>';
        $this->searchCriteria .= '<option value="decl">' . _i('Declination') . '</option>';
        $this->searchCriteria .= '<option value="magnitude">' . _i('Magnitude') . '</option>';
        $this->searchCriteria .= '<option value="subr">' . _i('Surface Brightness') . '</option>';
        $this->searchCriteria .= '<option value="diameter">' . _i('Diameter') . '</option>';
        $this->searchCriteria .= '<option value="diameterRatio">' . _i('Diameter ratio') . '</option>';
        $this->searchCriteria .= '<option value="description">' . _i('Description') . '</option>';
        if (Auth::user()) {
            $this->searchCriteria .= '<option value="contrastReserve">' . _i('Contrast Reserve') . '</option>';
            $this->allInstruments = \App\Models\Instrument::getInstrumentOptionsChoicesDetail();
            $this->allLocations = \App\Models\Location::getLocationOptionsChoicesDetail();
        }
        $this->allCatalogs = \App\Models\TargetName::getCatalogsChoices();
        $this->constellations = \App\Models\Constellation::getConstellationChoices();
        $this->types = \App\Models\TargetType::getTypesChoices();
        $this->allAtlases = \App\Models\Atlas::getAtlasChoices();
    }

    /**
     * Real time validation.
     *
     * @param mixed $propertyName The name of the property
     */
    public function updated($propertyName): void
    {
        if ($propertyName == 'criteria') {
            if ($this->criteria == 'constellation') {
                ++$this->numberOfConstellations;
                $searchString = '<div class="form-group row">';
                if ($this->numberOfConstellations == 1) {
                    $searchString .= '<div class="col-sm-2 col-form-label">' . _i('Constellation') . '</div>';
                } else {
                    $searchString .= '<div class="col-sm-2 col-form-label">' . _i('or constellation') . '</div>';
                }
                $searchString .= '<div class="col-sm-1">';
                $searchString .= '<div x-data="" wire:ignore>';
                $searchString .= '<select class="form-control form-control-sm" id="notConstellation' . $this->numberOfConstellations . '" name="notConstellation' . $this->numberOfConstellations . '">';
                $searchString .= '<option value="0">' . _i('is') . '</option>';
                $searchString .= '<option value="1">' . _i('is not') . '</option>';
                $searchString .= '</select>';
                $searchString .= '</div>';
                $searchString .= '</div>';
                $searchString .= '<div class="col-sm-4">';
                $searchString .= '<div x-data="" wire:ignore>';

                // $this->searchHtml .= '<x-input.select id="catalog{{ $cnt }}" :options="' . $this->allCatalogs . '" name="catalog{{ $cnt }}" />';
                // <x-input.select id="catalog{{ $cnt }}" :options="$allCatalogs" name="catalog{{ $cnt }}" />

                $searchString .= '<select class="form-control form-control-sm" id="constellation' . $this->numberOfConstellations . '" name="constellation' . $this->numberOfConstellations . '">';
                $searchString .= $this->constellations;
                $searchString .= '</select>';
                $searchString .= '</div>';
                $searchString .= '</div>';
                // $searchString .= '<div class="col-sm-1">';
                // $searchString .= '<svg xmlns="http://www.w3.org/2000/svg" wire:click="removeSearch(' . $this->numberOfSearchOptions . ')" width="16" height="16" fill="currentColor" class="bi bi-dash-circle-fill inline" viewBox="0 0 16 16">
                // <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z"/>
                // </svg>';
                // $searchString .= '</div>';
                $searchString .= '</div>';
            }
            if ($this->criteria == 'type') {
                ++$this->numberOfTypes;
                $searchString = '<div class="form-group row">';
                if ($this->numberOfTypes == 1) {
                    $searchString .= '<div class="col-sm-2 col-form-label">' . _i('Object type') . '</div>';
                } else {
                    $searchString .= '<div class="col-sm-2 col-form-label">' . _i('or object type') . '</div>';
                }
                $searchString .= '<div class="col-sm-1">';
                $searchString .= '<div x-data="" wire:ignore>';
                $searchString .= '<select class="form-control form-control-sm" id="notType' . $this->numberOfTypes . '" name="notType' . $this->numberOfTypes . '">';
                $searchString .= '<option value="0">' . _i('is') . '</option>';
                $searchString .= '<option value="1">' . _i('is not') . '</option>';
                $searchString .= '</select>';
                $searchString .= '</div>';
                $searchString .= '</div>';
                $searchString .= '<div class="col-sm-4">';
                $searchString .= '<div x-data="" wire:ignore>';

                // $this->searchHtml .= '<x-input.select id="catalog{{ $cnt }}" :options="' . $this->allCatalogs . '" name="catalog{{ $cnt }}" />';
                // <x-input.select id="catalog{{ $cnt }}" :options="$allCatalogs" name="catalog{{ $cnt }}" />

                $searchString .= '<select class="form-control form-control-sm" id="type' . $this->numberOfTypes . '" name="type' . $this->numberOfTypes . '">';
                $searchString .= $this->types;
                $searchString .= '</select>';
                $searchString .= '</div>';
                $searchString .= '</div>';
                // $searchString .= '<div class="col-sm-1">';
                // $searchString .= '<svg xmlns="http://www.w3.org/2000/svg" wire:click="removeSearch(' . $this->numberOfSearchOptions . ')" width="16" height="16" fill="currentColor" class="bi bi-dash-circle-fill inline" viewBox="0 0 16 16">
                // <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z"/>
                // </svg>';
                // $searchString .= '</div>';
                $searchString .= '</div>';
            }
            if ($this->criteria == 'atlas') {
                ++$this->numberOfAtlases;

                $searchString = '<div class="form-group row">';
                if ($this->numberOfAtlases == 1) {
                    $searchString .= '<div class="col-sm-2 col-form-label">' . _i('Atlas page') . '</div>';
                } else {
                    $searchString .= '<div class="col-sm-2 col-form-label">' . _i('or atlas page') . '</div>';
                }
                $searchString .= '<div class="col-sm-1">';
                $searchString .= '<div x-data="" wire:ignore>';
                $searchString .= '<select class="form-control form-control-sm" id="notAtlas' . $this->numberOfAtlases . '" name="notAtlas' . $this->numberOfAtlases . '">';
                $searchString .= '<option value="0">' . _i('is') . '</option>';
                $searchString .= '<option value="1">' . _i('is not') . '</option>';
                $searchString .= '</select>';
                $searchString .= '</div>';
                $searchString .= '</div>';
                $searchString .= '<div class="col-sm-3">';
                $searchString .= '<input type="text" placeholder="' . _i('Enter page in atlas') . '" class="form-control form-control-lg" name="atlasPage' . $this->numberOfAtlases . '">';
                $searchString .= '</div>';
                $searchString .= '<div class="col-sm-1">';
                $searchString .= _i('of');
                $searchString .= '</div>';
                $searchString .= '<div class="col-sm-4">';
                $searchString .= '<div x-data="" wire:ignore>';
                $searchString .= '<select class="form-control form-control-sm" id="atlas' . $this->numberOfAtlases . '" name="atlas' . $this->numberOfAtlases . '">';
                $searchString .= $this->allAtlases;
                $searchString .= '</select>';
                $searchString .= '</div>';
                $searchString .= '</div>';

                // $searchString .= '<div class="col-sm-1">';
                // $searchString .= '<svg xmlns="http://www.w3.org/2000/svg" wire:click="removeSearch(' . $this->numberOfSearchOptions . ')" width="16" height="16" fill="currentColor" class="bi bi-dash-circle-fill inline" viewBox="0 0 16 16">
                // <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z"/>
                // </svg>';
                // $searchString .= '</div>';
                $searchString .= '</div>';
            }
            if ($this->criteria == 'contrastReserve') {
                ++$this->numberOfContrastReserve;

                if ($this->numberOfContrastReserve > 2) {
                    $searchString = '';
                } else {
                    $searchString = '<div class="form-group row">';
                    if ($this->numberOfContrastReserve == 1) {
                        $searchString .= '<div class="col-sm-2 col-form-label">' . _i('Contrast reserve') . '</div>';
                    } else {
                        $searchString .= '<div class="col-sm-2 col-form-label">' . _i('and contrast reserve') . '</div>';
                    }
                    $searchString .= '<div class="col-sm-1">';
                    $searchString .= '<div x-data="" wire:ignore>';
                    $searchString .= '<select class="form-control form-control-sm" id="compContrast' . $this->numberOfContrastReserve . '" name="compContrast' . $this->numberOfContrastReserve . '">';
                    $searchString .= '<option value="0">' . '>' . '</option>';
                    $searchString .= '<option value="1">' . '<' . '</option>';
                    $searchString .= '</select>';
                    $searchString .= '</div>';
                    $searchString .= '</div>';
                    $searchString .= '<div class="col-sm-1">';
                    $searchString .= '<input type="number" min="-5" max="5" step="0.1" class="form-control form-control-lg" name="contrast' . $this->numberOfContrastReserve . '">';
                    $searchString .= '</div>';
                    if ($this->numberOfContrastReserve == 1) {
                        $searchString .= '<div class="col-sm-1">';
                        $searchString .= _i('with');
                        $searchString .= '</div>';
                        $searchString .= '<div class="col-sm-2">';
                        $searchString .= '<div x-data="" wire:ignore>';
                        $searchString .= '<select class="form-control form-control-sm" id="instrumentContrast' . $this->numberOfContrastReserve . '" name="instrumentContrast' . $this->numberOfContrastReserve . '">';
                        $searchString .= $this->allInstruments;
                        $searchString .= '</select>';
                        $searchString .= '</div>';
                        $searchString .= '</div>';
                        $searchString .= '<div class="col-sm-1">';
                        $searchString .= _i('in');
                        $searchString .= '</div>';
                        $searchString .= '<div class="col-sm-2">';
                        $searchString .= '<div x-data="" wire:ignore>';
                        $searchString .= '<select class="form-control form-control-sm" id="locationContrast' . $this->numberOfContrastReserve . '" name="locationContrast' . $this->numberOfContrastReserve . '">';
                        $searchString .= $this->allLocations;
                        $searchString .= '</select>';
                        $searchString .= '</div>';
                        $searchString .= '</div>';
                    }
                    // $searchString .= '<div class="col-sm-1">';
                    // $searchString .= '<svg xmlns="http://www.w3.org/2000/svg" wire:click="removeSearch(' . $this->numberOfSearchOptions . ')" width="16" height="16" fill="currentColor" class="bi bi-dash-circle-fill inline" viewBox="0 0 16 16">
                    // <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z"/>
                    // </svg>';
                    // $searchString .= '</div>';
                    $searchString .= '</div>';
                }
            }
            if ($this->criteria == 'decl') {
                ++$this->numberOfDeclinations;

                if ($this->numberOfDeclinations > 2) {
                    $searchString = '';
                } else {
                    $searchString = '<div class="form-group row">';
                    if ($this->numberOfDeclinations == 1) {
                        $searchString .= '<div class="col-sm-2 col-form-label">' . _i('Declination') . '</div>';
                    } else {
                        $searchString .= '<div class="col-sm-2 col-form-label">' . _i('and declination') . '</div>';
                    }
                    $searchString .= '<div class="col-sm-1">';
                    $searchString .= '<div x-data="" wire:ignore>';
                    $searchString .= '<select class="form-control form-control" id="compDeclination' . $this->numberOfDeclinations . '" name="compDeclination' . $this->numberOfDeclinations . '">';
                    $searchString .= '<option value="0">' . '>' . '</option>';
                    $searchString .= '<option value="1">' . '<' . '</option>';
                    $searchString .= '</select>';
                    $searchString .= '</div>';
                    $searchString .= '</div>';
                    $searchString .= '<div class="input-group col-sm-4">';
                    $searchString .= '<input type="number" min="-90" max="90" class="form-control" name="declinationDegrees' . $this->numberOfDeclinations . '">';
                    $searchString .= '<div class="input-group-append"><span class="input-group-text">??</span></div>';
                    // $searchString .= '</div>';
                    // $searchString .= '<div class="col-sm-1 inline">';
                    $searchString .= '<input type="number" min="0" max="59" class="form-control" name="declinationMinutes' . $this->numberOfDeclinations . '">';
                    $searchString .= '<div class="input-group-append"><span class="input-group-text">\'</span></div>';
                    // $searchString .= '</div>';
                    // $searchString .= '<div class="col-sm-1 inline">';
                    $searchString .= '<input type="number" min="0" max="59" step="0.1" class="form-control" name="declinationSeconds' . $this->numberOfDeclinations . '">';
                    $searchString .= '<div class="input-group-append"><span class="input-group-text">\'\'</span></div>';
                    $searchString .= '</div>';

                    // $searchString .= '<div class="col-sm-1">';
                    // $searchString .= '<svg xmlns="http://www.w3.org/2000/svg" wire:click="removeSearch(' . $this->numberOfSearchOptions . ')" width="16" height="16" fill="currentColor" class="bi bi-dash-circle-fill inline" viewBox="0 0 16 16">
                    // <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z"/>
                    // </svg>';
                    // $searchString .= '</div>';
                    $searchString .= '</div>';
                }
            }
            if ($this->criteria == 'diameter') {
                ++$this->numberOfDiameter;

                if ($this->numberOfDiameter > 2) {
                    $searchString = '';
                } else {
                    $searchString = '<div class="form-group row">';
                    if ($this->numberOfDiameter == 1) {
                        $searchString .= '<div class="col-sm-2 col-form-label">' . _i('Diameter') . '</div>';
                    } else {
                        $searchString .= '<div class="col-sm-2 col-form-label">' . _i('and diameter') . '</div>';
                    }
                    $searchString .= '<div class="col-sm-1">';
                    $searchString .= '<div x-data="" wire:ignore>';
                    $searchString .= '<select class="form-control form-control" id="compDiameter' . $this->numberOfDiameter . '" name="compDiameter' . $this->numberOfDiameter . '">';
                    $searchString .= '<option value="0">' . '>' . '</option>';
                    $searchString .= '<option value="1">' . '<' . '</option>';
                    $searchString .= '</select>';
                    $searchString .= '</div>';
                    $searchString .= '</div>';
                    $searchString .= '<div class="input-group col-sm-4">';
                    $searchString .= '<input type="number" min="0" max="3600" class="form-control" name="diameterMinutes' . $this->numberOfDiameter . '">';
                    $searchString .= '<div class="input-group-append"><span class="input-group-text">\'</span></div>';
                    // $searchString .= '</div>';
                    // $searchString .= '<div class="col-sm-1 inline">';
                    $searchString .= '<input type="number" min="0" max="59" step="0.1" class="form-control" name="diameterSeconds' . $this->numberOfDiameter . '">';
                    $searchString .= '<div class="input-group-append"><span class="input-group-text">\'\'</span></div>';
                    $searchString .= '</div>';

                    // $searchString .= '<div class="col-sm-1">';
                    // $searchString .= '<svg xmlns="http://www.w3.org/2000/svg" wire:click="removeSearch(' . $this->numberOfSearchOptions . ')" width="16" height="16" fill="currentColor" class="bi bi-dash-circle-fill inline" viewBox="0 0 16 16">
                    // <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z"/>
                    // </svg>';
                    // $searchString .= '</div>';
                    $searchString .= '</div>';
                }
            }
            if ($this->criteria == 'diameterRatio') {
                ++$this->numberOfDiameterRatio;

                if ($this->numberOfDiameterRatio > 2) {
                    $searchString = '';
                } else {
                    $searchString = '<div class="form-group row">';
                    if ($this->numberOfDiameterRatio == 1) {
                        $searchString .= '<div class="col-sm-2 col-form-label">' . _i('Diameter ratio') . '</div>';
                    } else {
                        $searchString .= '<div class="col-sm-2 col-form-label">' . _i('and diameter ratio') . '</div>';
                    }
                    $searchString .= '<div class="col-sm-1">';
                    $searchString .= '<div x-data="" wire:ignore>';
                    $searchString .= '<select class="form-control form-control" id="compDiameterRatio' . $this->numberOfDiameterRatio . '" name="compDiameterRatio' . $this->numberOfDiameterRatio . '">';
                    $searchString .= '<option value="0">' . '>' . '</option>';
                    $searchString .= '<option value="1">' . '<' . '</option>';
                    $searchString .= '</select>';
                    $searchString .= '</div>';
                    $searchString .= '</div>';
                    $searchString .= '<div class="input-group col-sm-4">';
                    $searchString .= '<input type="number" step="0.1" min="0" max="59" class="form-control" name="diameterRatio' . $this->numberOfDiameterRatio . '">';
                    $searchString .= '</div>';

                    // $searchString .= '<div class="col-sm-1">';
                    // $searchString .= '<svg xmlns="http://www.w3.org/2000/svg" wire:click="removeSearch(' . $this->numberOfSearchOptions . ')" width="16" height="16" fill="currentColor" class="bi bi-dash-circle-fill inline" viewBox="0 0 16 16">
                    // <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z"/>
                    // </svg>';
                    // $searchString .= '</div>';
                    $searchString .= '</div>';
                }
            }
            if ($this->criteria == 'description') {
                ++$this->numberOfDescription;

                $searchString = '<div class="form-group row">';
                if ($this->numberOfDescription == 1) {
                    $searchString .= '<div class="col-sm-2 col-form-label">' . _i('Description') . '</div>';
                } else {
                    $searchString .= '<div class="col-sm-2 col-form-label">' . _i('or description') . '</div>';
                }
                $searchString .= '<div class="col-sm-1">';
                $searchString .= '<div x-data="" wire:ignore>';
                $searchString .= '<select class="form-control form-control" id="compDescription' . $this->numberOfDescription . '" name="compDescription' . $this->numberOfDescription . '">';
                $searchString .= '<option value="1">' . _i('contains') . '</option>';
                $searchString .= '<option value="0">' . _i("doesn't contain") . '</option>';
                $searchString .= '</select>';
                $searchString .= '</div>';
                $searchString .= '</div>';
                $searchString .= '<div class="input-group col-sm-8">';
                $searchString .= '<input type="text" class="form-control" name="description' . $this->numberOfDescription . '">';
                $searchString .= '</div>';

                // $searchString .= '<div class="col-sm-1">';
                // $searchString .= '<svg xmlns="http://www.w3.org/2000/svg" wire:click="removeSearch(' . $this->numberOfSearchOptions . ')" width="16" height="16" fill="currentColor" class="bi bi-dash-circle-fill inline" viewBox="0 0 16 16">
                // <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z"/>
                // </svg>';
                // $searchString .= '</div>';
                $searchString .= '</div>';
            }
            if ($this->criteria == 'ra') {
                ++$this->numberOfRa;

                if ($this->numberOfRa > 2) {
                    $searchString = '';
                } else {
                    $searchString = '<div class="form-group row">';
                    if ($this->numberOfRa == 1) {
                        $searchString .= '<div class="col-sm-2 col-form-label">' . _i('Right ascension') . '</div>';
                    } else {
                        $searchString .= '<div class="col-sm-2 col-form-label">' . _i('and right ascension') . '</div>';
                    }
                    $searchString .= '<div class="col-sm-1">';
                    $searchString .= '<div x-data="" wire:ignore>';
                    $searchString .= '<select class="form-control form-control" id="compRa' . $this->numberOfRa . '" name="compRa' . $this->numberOfRa . '">';
                    $searchString .= '<option value="0">' . '>' . '</option>';
                    $searchString .= '<option value="1">' . '<' . '</option>';
                    $searchString .= '</select>';
                    $searchString .= '</div>';
                    $searchString .= '</div>';
                    $searchString .= '<div class="input-group col-sm-4">';
                    $searchString .= '<input type="number" min="-90" max="90" class="form-control" name="raHours' . $this->numberOfRa . '">';
                    $searchString .= '<div class="input-group-append"><span class="input-group-text">h</span></div>';
                    // $searchString .= '</div>';
                    // $searchString .= '<div class="col-sm-1 inline">';
                    $searchString .= '<input type="number" min="0" max="59" class="form-control" name="raMinutes' . $this->numberOfRa . '">';
                    $searchString .= '<div class="input-group-append"><span class="input-group-text">\'</span></div>';
                    // $searchString .= '</div>';
                    // $searchString .= '<div class="col-sm-1 inline">';
                    $searchString .= '<input type="number" min="0" max="59" step="0.1" class="form-control" name="raSeconds' . $this->numberOfRa . '">';
                    $searchString .= '<div class="input-group-append"><span class="input-group-text">\'\'</span></div>';
                    $searchString .= '</div>';

                    // $searchString .= '<div class="col-sm-1">';
                    // $searchString .= '<svg xmlns="http://www.w3.org/2000/svg" wire:click="removeSearch(' . $this->numberOfSearchOptions . ')" width="16" height="16" fill="currentColor" class="bi bi-dash-circle-fill inline" viewBox="0 0 16 16">
                    // <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z"/>
                    // </svg>';
                    // $searchString .= '</div>';
                    $searchString .= '</div>';
                }
            }
            if ($this->criteria == 'magnitude') {
                ++$this->numberOfMagnitude;

                if ($this->numberOfMagnitude > 2) {
                    $searchString = '';
                } else {
                    $searchString = '<div class="form-group row">';
                    if ($this->numberOfMagnitude == 1) {
                        $searchString .= '<div class="col-sm-2 col-form-label">' . _i('Magnitude') . '</div>';
                    } else {
                        $searchString .= '<div class="col-sm-2 col-form-label">' . _i('and magnitude') . '</div>';
                    }
                    $searchString .= '<div class="col-sm-1">';
                    $searchString .= '<div x-data="" wire:ignore>';
                    $searchString .= '<select class="form-control form-control" id="compMagnitude' . $this->numberOfMagnitude . '" name="compMagnitude' . $this->numberOfMagnitude . '">';
                    $searchString .= '<option value="0">' . '>' . '</option>';
                    $searchString .= '<option value="1">' . '<' . '</option>';
                    $searchString .= '</select>';
                    $searchString .= '</div>';
                    $searchString .= '</div>';
                    $searchString .= '<div class="input-group col-sm-4">';
                    $searchString .= '<input type="number" min="-8" max="20" step="0.1" class="form-control" name="magnitude' . $this->numberOfMagnitude . '">';
                    $searchString .= '</div>';

                    // $searchString .= '<div class="col-sm-1">';
                    // $searchString .= '<svg xmlns="http://www.w3.org/2000/svg" wire:click="removeSearch(' . $this->numberOfSearchOptions . ')" width="16" height="16" fill="currentColor" class="bi bi-dash-circle-fill inline" viewBox="0 0 16 16">
                    // <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z"/>
                    // </svg>';
                    // $searchString .= '</div>';
                    $searchString .= '</div>';
                }
            }
            if ($this->criteria == 'subr') {
                ++$this->numberOfSubr;

                if ($this->numberOfSubr > 2) {
                    $searchString = '';
                } else {
                    $searchString = '<div class="form-group row">';
                    if ($this->numberOfSubr == 1) {
                        $searchString .= '<div class="col-sm-2 col-form-label">' . _i('Surface brightness') . '</div>';
                    } else {
                        $searchString .= '<div class="col-sm-2 col-form-label">' . _i('and surface brightness') . '</div>';
                    }
                    $searchString .= '<div class="col-sm-1">';
                    $searchString .= '<div x-data="" wire:ignore>';
                    $searchString .= '<select class="form-control form-control" id="compSubr' . $this->numberOfSubr . '" name="compSubr' . $this->numberOfSubr . '">';
                    $searchString .= '<option value="0">' . '>' . '</option>';
                    $searchString .= '<option value="1">' . '<' . '</option>';
                    $searchString .= '</select>';
                    $searchString .= '</div>';
                    $searchString .= '</div>';
                    $searchString .= '<div class="input-group col-sm-4">';
                    $searchString .= '<input type="number" min="-8" max="20" step="0.1" class="form-control" name="subr' . $this->numberOfSubr . '">';
                    $searchString .= '</div>';

                    // $searchString .= '<div class="col-sm-1">';
                    // $searchString .= '<svg xmlns="http://www.w3.org/2000/svg" wire:click="removeSearch(' . $this->numberOfSearchOptions . ')" width="16" height="16" fill="currentColor" class="bi bi-dash-circle-fill inline" viewBox="0 0 16 16">
                    // <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z"/>
                    // </svg>';
                    // $searchString .= '</div>';
                    $searchString .= '</div>';
                }
            }
            if ($this->criteria == 'name') {
                ++$this->numberOfNames;

                $searchString = '<div class="form-group row">';
                if ($this->numberOfNames == 1) {
                    $searchString .= '<div class="col-sm-2 col-form-label">' . _i('Object name') . '</div>';
                } else {
                    $searchString .= '<div class="col-sm-2 col-form-label">' . _i('or object name') . '</div>';
                }
                $searchString .= '<div class="col-sm-1">';
                $searchString .= '<div x-data="" wire:ignore>';
                $searchString .= '<select class="form-control form-control-sm" id="notName' . $this->numberOfNames . '" name="notName' . $this->numberOfNames . '">';
                $searchString .= '<option value="0">' . _i('is') . '</option>';
                $searchString .= '<option value="1">' . _i('is not') . '</option>';
                $searchString .= '</select>';
                $searchString .= '</div>';
                $searchString .= '</div>';
                $searchString .= '<div class="col-sm-4">';
                $searchString .= '<div x-data="" wire:ignore>';
                $searchString .= '<select class="form-control form-control-sm" id="catalog' . $this->numberOfNames . '" name="catalog' . $this->numberOfNames . '">';
                $searchString .= $this->allCatalogs;
                $searchString .= '</select>';
                $searchString .= '</div>';
                $searchString .= '</div>';
                $searchString .= '<div class="col-sm-3">';

                $searchString .= '<input type="text" placeholder="' . _i('Enter number in catalog') . '" class="form-control form-control-lg" name="number' . $this->numberOfNames . '">';
                $searchString .= '</div>';

                // $searchString .= '<div class="col-sm-1">';
                // $searchString .= '<svg xmlns="http://www.w3.org/2000/svg" wire:click="removeSearch(' . $this->numberOfSearchOptions . ')" width="16" height="16" fill="currentColor" class="bi bi-dash-circle-fill inline" viewBox="0 0 16 16">
                // <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z"/>
                // </svg>';
                // $searchString .= '</div>';
                $searchString .= '</div>';
            }
            $this->addExtraSearchParameter = false;
            $this->criteria = '';
            $this->searchHtml = '';

            $this->searchArray[$this->numberOfSearchOptions] = $searchString;
            foreach ($this->searchArray as $searchString) {
                $this->searchHtml .= $searchString;
            }
            ++$this->numberOfSearchOptions;
        }
    }

    public function clearFields(): void
    {
        $this->addExtraSearchParameter = false;
        $this->criteria = '';
        $this->searchHtml = '';
    }

    public function addSearch(): void
    {
        $this->addExtraSearchParameter = true;
    }

    // Remove a search option
    public function removeSearch($searchToRemove): void
    {
        unset($this->searchArray[$searchToRemove]);
        $this->searchHtml = '';
        foreach ($this->searchArray as $searchString) {
            $this->searchHtml .= $searchString;
        }
        --$this->numberOfSearchOptions;
    }

    public function render()
    {
        return view('livewire.target.search');
    }
}
