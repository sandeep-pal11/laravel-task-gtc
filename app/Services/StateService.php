<?php

namespace App\Services;

use App\Models\State;
use App\Repositories\StateRepository;

class StateService
{

    public function __construct(
        protected StateRepository $stateRepository
    ) {}

    public function query()
    {
        return $this->stateRepository->query();
    }

    public function store(array $data)
    {
        return $this->stateRepository->create($data);
    }

    public function update(State $state, array $data)
    {
        return $this->stateRepository->update($state, $data);
    }

    public function delete(State $state)
    {
        return $this->stateRepository->delete($state);
    }
}
