<?php

namespace Vanguard\Http\Controllers\Api;

use Vanguard\Http\Resources\CountryResource;
use Vanguard\Repositories\Country\CountryRepository;

class CountriesController extends ApiController
{
    /**
     * @var CountryRepository
     */
    private $countries;

    public function __construct(CountryRepository $countries)
    {
        $this->countries = $countries;
    }

    /**
     * Get list of all available countries.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return CountryResource::collection($this->countries->all());
    }
}
