<?php

namespace App\Services;

use App\Repositories\Interfaces\ArticleDataRepositoryInterface;

class ArticleDataService
{
    /**
     * ArticleDataService constructor.
     *
     * @param ArticleDataRepositoryInterface $articleDataRepository
     */
    public function __construct(
        protected ArticleDataRepositoryInterface $articleDataRepository,
    ) {
    }

    /**
     * All article data
     *
     * @param  array  $attributes
     * @return object
     */
    public function all(array $attributes = []): object
    {
        return $this->articleDataRepository->all($attributes);
    }

    /**
     * First article data
     *
     * @param  array  $attributes
     * @return object
     */
    public function first(array $attributes = []): ?object
    {
        return $this->articleDataRepository->first($attributes);
    }

}
