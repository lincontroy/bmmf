<?php

namespace App\Repositories\Eloquent;

use App\Enums\StatusEnum;
use App\Models\TeamMember;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Interfaces\TeamMemberRepositoryInterface;

class ContactUsRepository extends BaseRepository implements TeamMemberRepositoryInterface
{
    public function __construct(TeamMember $model)
    {
        parent::__construct($model);
    }

    public function findAll(): ?object
    {
        return $this->model->with('memberSocials')->where("status", StatusEnum::ACTIVE->value)->get();
    }

}
