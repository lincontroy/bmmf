<?php

namespace App\Repositories\Eloquent;

use App\Models\WithdrawalAccCredential;
use App\Repositories\Interfaces\WithdrawAccountCredentialRepositoryInterface;

class WithdrawalAccountCredentialRepository extends BaseRepository implements WithdrawAccountCredentialRepositoryInterface
{
    public function __construct(WithdrawalAccCredential $model)
    {
        parent::__construct($model);
    }
}