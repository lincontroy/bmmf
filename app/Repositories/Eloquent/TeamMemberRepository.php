<?php

namespace App\Repositories\Eloquent;

use App\Enums\StatusEnum;
use App\Models\TeamMember;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\TeamMemberRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class TeamMemberRepository extends BaseRepository implements TeamMemberRepositoryInterface
{
    public function __construct(TeamMember $model)
    {
        parent::__construct($model);
    }

    /**
     * @inheritDoc
     */
    public function all(array $attributes = []): Collection
    {
        $query = $this->baseQuery($attributes);

        return $this->transformToCollection($query);
    }

    /**
     * Base query
     *
     * @param array $attributes
     * @return Builder
     */
    private function baseQuery(array $attribute = []): Builder
    {
        $query = $this->model->newQuery();

        if (isset($attribute['status'])) {
            $query = $query->where('status', $attribute['status']);
        }

        return $query;
    }

    /**
     * Find all
     *
     * @return object|null
     */
    public function findAll(): ?object
    {
        return $this->baseQuery(["status" => StatusEnum::ACTIVE->value])->with('memberSocials')->get();
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
     * Fillable data for expense
     *
     * @param array $attributes
     * @return array
     */
    private function fillable(array $attributes): array
    {
        $data = [
            'name'        => $attributes['name'],
            'designation' => $attributes['designation'],
        ];

        if (isset($attributes['avatar'])) {
            $data['avatar'] = $attributes['avatar'];
        }

        if (isset($attributes['status'])) {
            $data['status'] = $attributes['status'];
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function updateById(int $settingId, array $attributes): bool
    {
        $data = $this->fillable($attributes);

        return parent::updateById($settingId, $data);
    }

    /**
     * @inheritDoc
     */
    public function destroyById(int $id): bool
    {
        return $this->model->where('id', $id)->forceDelete();
    }

}
