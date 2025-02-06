<?php

namespace Modules\Package\App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use Modules\Package\App\Models\InvestmentRoi;
use Modules\Package\App\Repositories\Interfaces\InvestmentRoiRepositoryInterface;

class InvestmentRoiRepository extends BaseRepository implements InvestmentRoiRepositoryInterface
{
    public function __construct(InvestmentRoi $model)
    {
        parent::__construct($model);
    }
}
