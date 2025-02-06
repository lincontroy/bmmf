<?php

namespace App\Repositories\Eloquent;

use App\Models\Setting;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\SettingRepositoryInterface;

class SettingRepository extends BaseRepository implements SettingRepositoryInterface
{
    public function __construct(Setting $model)
    {
        parent::__construct($model);
    }

    /**
     * Fillable data for expense
     *
     * @param  array  $attributes
     * @return array
     */
    private function fillable(array $attributes): array
    {
        return [
            'title'              => $attributes['title'],
            'email'              => $attributes['email'] ?? null,
            'language_id'        => $attributes['language_id'] ?? null,
            'site_align'         => $attributes['site_align'] ?? null,
            'footer_text'        => $attributes['footer_text'] ?? null,
            'logo'               => $attributes['logo'] ?? null,
            'description'        => $attributes['description'] ?? null,
            'phone'              => $attributes['phone'] ?? null,
            'time_zone'          => $attributes['time_zone'],
            'office_time'        => $attributes['office_time'] ?? null,
            'latitude_longitude' => $attributes['latitude_longitude'] ?? null,
            'favicon'            => $attributes['favicon'] ?? null,
            'login_bg_img'       => $attributes['login_bg_img'] ?? null,
        ];
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
    public function create(array $attributes): object
    {
        $data = $this->fillable($attributes);
        return parent::create($data);
    }

    /**
     * @inheritDoc
     */
    public function findSettingWithLanguage(): ?object
    {
        return $this->model->with('language')->first();
    }
}
