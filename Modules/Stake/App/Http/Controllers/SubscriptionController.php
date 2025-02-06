<?php

namespace Modules\Stake\App\Http\Controllers;

use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Http\Controllers\Controller;
use App\Traits\ChecksPermissionTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Stake\App\DataTables\StakeSubscriptionDataTable;
use Modules\Stake\App\Enums\CustomerStakeEnum;
use Modules\Stake\App\Repositories\Interfaces\CustomerStakeRepositoryInterface;

class SubscriptionController extends Controller
{
    use ChecksPermissionTrait;

    public $mapActionPermission;

    public function __construct(
        private CustomerStakeRepositoryInterface $customerStakeRepository
    ) {
        $this->mapActionPermission = [
            'index'   => PermissionMenuEnum::MANAGES_ROLE->value . '.' . PermissionActionEnum::READ->value,
            'create'  => PermissionMenuEnum::MANAGES_ROLE->value . '.' . PermissionActionEnum::READ->value,
            'store'   => PermissionMenuEnum::MANAGES_ROLE->value . '.' . PermissionActionEnum::READ->value,
            'show'    => PermissionMenuEnum::MANAGES_ROLE->value . '.' . PermissionActionEnum::READ->value,
            'edit'    => PermissionMenuEnum::MANAGES_ROLE->value . '.' . PermissionActionEnum::READ->value,
            'update'  => PermissionMenuEnum::MANAGES_ROLE->value . '.' . PermissionActionEnum::READ->value,
            'destroy' => PermissionMenuEnum::MANAGES_ROLE->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(StakeSubscriptionDataTable $stakeSubscriptionDataTable)
    {
        cs_set('theme', [
            'title'       => localize('Stake Subscription'),
            'description' => localize('Stake Subscription'),
        ]);

        $holding  = $this->customerStakeRepository->whereCount('status', CustomerStakeEnum::REDEEMED_ENABLE->value);
        $redeemed = $this->customerStakeRepository->whereCount('status', CustomerStakeEnum::REDEEMED->value);
        $pending  = $this->customerStakeRepository->whereCount('status', CustomerStakeEnum::RUNNING->value);

        return $stakeSubscriptionDataTable->with('tab', request()->input('tab', 'all'))->render('stake::subscription', compact('holding', 'redeemed', 'pending'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('stake::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('stake::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('stake::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
