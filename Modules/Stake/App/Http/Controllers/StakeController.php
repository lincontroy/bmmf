<?php

namespace Modules\Stake\App\Http\Controllers;

use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AcceptCurrencyRepositoryInterface;
use App\Traits\ChecksPermissionTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Modules\Stake\App\DataTables\StakeDataTable;
use Modules\Stake\App\Http\Requests\StakeRequest;
use Modules\Stake\App\Services\StakePlanService;

class StakeController extends Controller
{
    use ChecksPermissionTrait;

    public $mapActionPermission;

    public function __construct(
        private AcceptCurrencyRepositoryInterface $currencyRepository,
        private StakePlanService $planService
    ) {
        $this->mapActionPermission = [
            'index'   => PermissionMenuEnum::STAKE_PLAN->value  . '.' . PermissionActionEnum::READ->value,
            'create'  => PermissionMenuEnum::STAKE_PLAN->value  . '.' . PermissionActionEnum::CREATE->value,
            'store'   => PermissionMenuEnum::STAKE_PLAN->value  . '.' . PermissionActionEnum::CREATE->value,
            'show'    => PermissionMenuEnum::STAKE_PLAN->value  . '.' . PermissionActionEnum::READ->value,
            'edit'    => PermissionMenuEnum::STAKE_PLAN->value  . '.' . PermissionActionEnum::UPDATE->value,
            'update'  => PermissionMenuEnum::STAKE_PLAN->value  . '.' . PermissionActionEnum::UPDATE->value,
            'destroy' => PermissionMenuEnum::STAKE_PLAN->value  . '.' . PermissionActionEnum::DELETE->value,
        ];

    }

    /**
     * Display a listing of the resource.
     */
    public function index(StakeDataTable $stakeDataTable)
    {
        cs_set('theme', [
            'title'       => localize('Stake'),
            'description' => localize('Stake'),
        ]);
        $acceptCurrency = $this->currencyRepository->all();

        return $stakeDataTable->render('stake::index', compact('acceptCurrency'));
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
    public function store(StakeRequest $request): JsonResponse
    {
        $data = $request->validated();

        $stake = $this->planService->create($data);
        return response()->json([
            'success' => true,
            'message' => localize("Stake created successfully"),
            'title'   => localize("Stake"),
            'data'    => $stake,
        ]);
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
    public function edit($id): View
    {
        $data['plan']           = $this->planService->find(['id' => $id]);
        $data['acceptCurrency'] = $this->currencyRepository->all();

        return view("stake::edit", $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StakeRequest $request, $id): JsonResponse
    {
        $data = $request->validated();

        $updateData = $this->planService->update($data, $id);

        return response()->json([
            'success' => true,
            'message' => localize("Stake update successfully"),
            'title'   => localize("Stake"),
            'data'    => $updateData,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $this->planService->destroy(['stake_id' => $id]);

        return response()->json([
            'success' => true,
            'message' => localize("Stake deleted successfully"),
            'title'   => localize("Stake"),
        ]);
    }

}
