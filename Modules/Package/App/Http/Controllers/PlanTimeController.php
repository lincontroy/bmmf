<?php

namespace Modules\Package\App\Http\Controllers;

use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Http\Controllers\Controller;
use App\Traits\ChecksPermissionTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Package\App\DataTables\PlanTimeDataTable;
use Modules\Package\App\Http\Requests\PlanTimeRequest;
use Modules\Package\App\Services\PackageService;
use Modules\Package\App\Services\PlanTimeService;

class PlanTimeController extends Controller
{
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * PlanTimeController of __construct
     *
     * @param PackageService $packageService
     */
    public function __construct(
        protected PlanTimeService $planTimeService,
    ) {
        $this->mapActionPermission = [
            'index'   => PermissionMenuEnum::PACKAGE_TIME_LIST->value . '.' . PermissionActionEnum::READ->value,
            'create'  => PermissionMenuEnum::PACKAGE_TIME_LIST->value . '.' . PermissionActionEnum::CREATE->value,
            'store'   => PermissionMenuEnum::PACKAGE_TIME_LIST->value . '.' . PermissionActionEnum::CREATE->value,
            'show'    => PermissionMenuEnum::PACKAGE_TIME_LIST->value . '.' . PermissionActionEnum::READ->value,
            'edit'    => PermissionMenuEnum::PACKAGE_TIME_LIST->value . '.' . PermissionActionEnum::UPDATE->value,
            'update'  => PermissionMenuEnum::PACKAGE_TIME_LIST->value . '.' . PermissionActionEnum::UPDATE->value,
            'destroy' => PermissionMenuEnum::PACKAGE_TIME_LIST->value . '.' . PermissionActionEnum::DELETE->value,
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(PlanTimeDataTable $planTimeDataTable)
    {
        cs_set('theme', [
            'title'       => localize('Package Time'),
            'description' => localize('Package Time'),
        ]);
        return $planTimeDataTable->render('package::plan_time_index');
    }

    /**
     * Store a newly created resource in storage.
     * @param PlanTimeRequest $request
     */
    public function store(PlanTimeRequest $request): JsonResponse
    {
        $data               = $request->validated();
        $data['created_by'] = auth()->id();
        $planTime           = $this->planTimeService->create($data);
        return response()->json([
            'success' => true,
            'message' => localize("Plan time create successfully"),
            'title'   => localize("Plan Time"),
            'data'    => $planTime,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('package::create');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('package::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     */
    public function edit(int $id): JsonResponse
    {
        $package = $this->planTimeService->findById($id);
        return response()->json([
            'success' => true,
            'message' => localize("Plan Time Data"),
            'title'   => localize("Plan Time"),
            'data'    => $package,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlanTimeRequest $request, $id): JsonResponse
    {
        $data                 = $request->validated();
        $data['plan_time_id'] = $id;

        $user = $this->planTimeService->update($data);

        return response()->json([
            'success' => true,
            'message' => localize("Plan time update successfully"),
            'title'   => localize("Plan Time"),
            'data'    => $user,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param Request $request
     * @var int $id
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $this->planTimeService->destroy(['plan_time_id' => $id]);

        return response()->json([
            'success' => true,
            'message' => localize("Plan time data delete successfully"),
            'title'   => localize("Plan Time"),
        ]);

    }
}
