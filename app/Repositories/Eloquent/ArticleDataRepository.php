<?php

namespace App\Repositories\Eloquent;

use App\Models\ArticleData;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\ArticleDataRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class ArticleDataRepository extends BaseRepository implements ArticleDataRepositoryInterface
{
    public function __construct(ArticleData $model)
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

        if (isset($attributes['slug'])) {
            $query = $query->where('slug', $attributes['slug']);
        }

        if (isset($attributes['content'])) {
            $query = $query->where('content', $attributes['content']);
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
        return [
            'article_id' => $attributes['article_id'],
            'slug'       => $attributes['slug'],
            'content'    => $attributes['content'],
        ];
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

        return parent::create($data);
    }

    /**
     * @inheritDoc
     */
    public function updateByCondition(array $conditions, array $attributes): bool
    {
        $data = $this->fillable($attributes);

        return $this->baseQuery($conditions)->update($data);
    }

    /**
     * @inheritDoc
     */
    public function deleteByCondition(array $conditions): bool
    {
        return $this->model->where($conditions)->delete();
    }

}
