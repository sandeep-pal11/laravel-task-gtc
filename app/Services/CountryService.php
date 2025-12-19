<?php

namespace App\Services;

use App\Models\Country;
use App\Repositories\CountryRepository;

class CountryService
{
    public function __construct(
        protected CountryRepository $countryRepository
    ) {}

    public function query()
    {
        return $this->countryRepository->query();
    }

    public function store(array $data)
    {
        return $this->countryRepository->create($data);
    }

    public function update(Country $country, array $data)
    {
        return $this->countryRepository->update($country, $data);
    }

    public function delete(Country $country)
    {
        return $this->countryRepository->delete($country);
    }
}
