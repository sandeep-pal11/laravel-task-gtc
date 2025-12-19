<?php

namespace App\Repositories;

use App\Models\Country;

class CountryRepository
{
    public function query()
    {
        return Country::query();
    }

    public function create(array $data)
    {
        return Country::create($data);
    }

    public function update(Country $country, array $data)
    {
        return $country->update($data);
    }

    public function delete(Country $country)
    {
        return $country->delete();
    }
}
