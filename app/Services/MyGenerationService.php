<?php

namespace App\Services;

use App\Repositories\Interfaces\CustomerRepositoryInterface;

class MyGenerationService
{
    /**
     * MyGenerationService constructor.
     *
     */
    public function __construct(
        protected CustomerRepositoryInterface $customerRepository,
    ) {
    }

    public function getGenerations($userId = '')
    {
        return $this->customerRepository->getGeneration($userId);
    }

}
