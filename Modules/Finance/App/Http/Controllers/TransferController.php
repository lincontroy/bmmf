<?php

namespace Modules\Finance\App\Http\Controllers;

use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Services\SettingService;
use App\Traits\ChecksPermissionTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Finance\App\DataTables\TransferDataTable;
use Modules\Finance\App\Services\TransferService;

class TransferController extends Controller
{
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * Summary of __construct
     * @param TransferService $transferService
     */
    public function __construct(
        protected TransferService $transferService,
        protected CustomerRepositoryInterface $customerRepository,
        protected SettingService $settingService,
    ) {
        $this->mapActionPermission = [
            'index'   => PermissionMenuEnum::FINANCE_TRANSFER->value . '.' . PermissionActionEnum::READ->value,
            'create'  => PermissionMenuEnum::FINANCE_TRANSFER->value . '.' . PermissionActionEnum::READ->value,
            'store'   => PermissionMenuEnum::FINANCE_TRANSFER->value . '.' . PermissionActionEnum::READ->value,
            'show'    => PermissionMenuEnum::FINANCE_TRANSFER->value . '.' . PermissionActionEnum::READ->value,
            'edit'    => PermissionMenuEnum::FINANCE_TRANSFER->value . '.' . PermissionActionEnum::READ->value,
            'update'  => PermissionMenuEnum::FINANCE_TRANSFER->value . '.' . PermissionActionEnum::READ->value,
            'destroy' => PermissionMenuEnum::FINANCE_TRANSFER->value . '.' . PermissionActionEnum::READ->value,
        ];

    }

    /**
     * Display a listing of the resource.
     */
    public function index(TransferDataTable $transferDataTable)
    {
        cs_set('theme', [
            'title'       => localize('Transfer List'),
            'description' => localize('Transfer List'),
        ]);

        return $transferDataTable->render('finance::transfer.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('finance::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $settingInfo     = $this->settingService->formData();
        $transferDetails = $this->transferService->transferDetails($id);

        $html = view('finance::transfer.transfer_details', compact('transferDetails', 'settingInfo'))->render();

        $response = ['info' => $html, 'details' => $transferDetails];

        return response()->json([
            'success' => true,
            'message' => "",
            'title'   => "Transfer Details",
            'data'    => $response,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('finance::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
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
