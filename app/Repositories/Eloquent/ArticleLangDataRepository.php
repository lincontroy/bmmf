<?php

namespace App\Repositories\Eloquent;

use App\Enums\StatusEnum;
use App\Models\ArticleLangData;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\ArticleLangDataRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class ArticleLangDataRepository extends BaseRepository implements ArticleLangDataRepositoryInterface
{
    public function __construct(ArticleLangData $model)
    {
        parent::__construct($model);
    }

    /**
     * Base query
     *
     * @param  array  $attributes
     * @return Builder
     */
    private function baseQuery(array $attributes = []): Builder
    {
        $query = $this->model->newQuery();

        if (isset($attributes['article_id'])) {
            $query = $query->where('article_id', $attributes['article_id']);
        }

        if (isset($attributes['language_id'])) {
            $query = $query->where('language_id', $attributes['language_id']);
        }

        if (isset($attributes['slug'])) {
            $query = $query->where('slug', $attributes['slug']);
        }

        if (isset($attributes['status'])) {
            $query = $query->where('status', $attributes['status']);
        }

        return $query;
    }

    /**
     * Fillable data
     *
     * @param  array  $attributes
     * @return array
     */
    private function fillable(array $attributes): array
    {
        $data = [
            'article_id'    => $attributes['article_id'],
            'language_id'   => $attributes['language_id'],
            'slug'          => $attributes['slug'],
            'small_content' => $attributes['small_content'] ?? null,
            'large_content' => $attributes['large_content'] ?? null,
        ];

        if (isset($attributes['status'])) {
            $data['status'] = $attributes['status'];
        }

        if (isset($attributes['created_by'])) {
            $data['created_by'] = $attributes['created_by'];
        }

        if (isset($attributes['updated_by'])) {
            $data['updated_by'] = $attributes['updated_by'];
        }

        return $data;

    }

    /**
     * @inheritDoc
     */
    public function all(array $attributes = []): object
    {
        return $this->baseQuery($attributes)->get();
    }

    /**
     * @inheritDoc
     */
    public function first(array $attributes = []): ?object
    {
        return $this->baseQuery($attributes)->first();
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): object
    {
        $data = $this->fillable($attributes);

        if (!isset($data['status'])) {
            $data['status'] = StatusEnum::ACTIVE->value;
        }

        return parent::create($data);
    }

    /**
     * @inheritDoc
     */
    public function updateById(int $id, array $attributes): bool
    {
        $data = $this->fillable($attributes);

        return parent::updateById($id, $data);
    }

    /**
     * @inheritDoc
     */
    public function deleteByCondition(array $conditions): bool
    {
        return $this->model->where($conditions)->delete();
    }

}
