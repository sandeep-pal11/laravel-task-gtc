<?php

namespace App\Repositories;

use App\Models\State;

class StateRepository
{
    public function query()
    {
        return State::with('country')->latest();
    }

    public function create(array $data)
    {
        return State::create($data);
    }

    public function update(State $state, array $data)
    {
        return $state->update($data);
    }

    public function delete(State $state)
    {
        return $state->delete();
    }
}
