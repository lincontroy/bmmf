<?php

namespace App\Services;

use App\Repositories\Interfaces\ArticleLangDataRepositoryInterface;

class ArticleLangDataService
{
    /**
     * ArticleLangDataService constructor.
     *
     * @param ArticleLangDataRepositoryInterface $articleLangDataRepository
     */
    public function __construct(
        protected ArticleLangDataRepositoryInterface $articleLangDataRepository,
    ) {
    }

    /**
     * Find article or throw 404
     *
     * @param  int  $id
     * @return object
     */
    public function findOrFail(int $id): object
    {
        return $this->articleLangDataRepository->findOrFail($id);
    }

    /**
     * All article lang data
     *
     * @param  array  $attributes
     * @return object
     */
    public function all(array $attributes = []): object
    {
        return $this->articleLangDataRepository->all($attributes);
    }

    /**
     * First article lang data
     *
     * @param  array  $attributes
     * @return object
     */
    public function first(array $attributes = []): ?object
    {
        return $this->articleLangDataRepository->first($attributes);
    }

}
