<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ManyArticlesResource;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Repositories\Interfaces\ExternalApiRepositoryInterface;

class ExternalApiSetupService
{
    /**
     * ExternalApiSetupService constructor.
     *
     * @param ExternalApiRepositoryInterface $externalApiRepository
     */
    public function __construct(
        protected ExternalApiRepositoryInterface $externalApiRepository,
    ) {
    }

    public function all(): ?object
    {
        return $this->externalApiRepository->all();
    }

    public function findOrFail($id): ?object
    {
        return $this->externalApiRepository->findOrFail($id);
    }

    public function update(array $attributes): bool
    {
        $id = $attributes['id'];

        $data['data'] = json_encode(array( 'api_key'=> $attributes['api_key'], 'create_link'=> $attributes['url']));

        return $this->externalApiRepository->updateById($id, $data);
    }

}
