<?php

namespace Modules\Merchant\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Merchant\App\DataTables\MerchantPaymentInfoDataTable;
use Modules\Merchant\App\Enums\MerchantPaymentInfoStatusEnum;
use Modules\Merchant\App\Models\MerchantPaymentInfo;
use Modules\Merchant\App\Repositories\Interfaces\MerchantPaymentInfoRepositoryInterface;
use Modules\Merchant\App\Services\MerchantPaymentInfoService;
use App\Traits\ChecksPermissionTrait;
use App\Enums\PermissionMenuEnum;
use App\Enums\PermissionActionEnum;

class MerchantPaymentInfoController extends Controller
{
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * MerchantPaymentInfoController of __construct
     *
     * @param MerchantPaymentInfoService $merchantPaymentInfoService
     */
    public function __construct(
        protected MerchantPaymentInfoService $merchantPaymentInfoService,
        protected MerchantPaymentInfoRepositoryInterface $merchantPaymentInfoRepository,

    ) {
        $this->mapActionPermission = [
            'index'           => PermissionMenuEnum::MERCHANT_TRANSACTIONS->value . '.' . PermissionActionEnum::READ->value,
            'create'          => PermissionMenuEnum::MERCHANT_TRANSACTIONS->value . '.' . PermissionActionEnum::READ->value,
            'store'           => PermissionMenuEnum::MERCHANT_TRANSACTIONS->value . '.' . PermissionActionEnum::READ->value,
            'show'            => PermissionMenuEnum::MERCHANT_TRANSACTIONS->value . '.' . PermissionActionEnum::READ->value,
            'edit'            => PermissionMenuEnum::MERCHANT_TRANSACTIONS->value . '.' . PermissionActionEnum::READ->value,
            'update'          => PermissionMenuEnum::MERCHANT_TRANSACTIONS->value . '.' . PermissionActionEnum::READ->value,
            'destroy'         => PermissionMenuEnum::MERCHANT_TRANSACTIONS->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @param MerchantPaymentInfoDataTable $merchantPaymentInfoDataTable
     * @return mixed
     */
    public function index(MerchantPaymentInfoDataTable $merchantPaymentInfoDataTable)
    {
        cs_set('theme', [
            'title'       => localize('Merchant Transaction'),
            'description' => localize('Merchant Transaction'),
        ]);

        $result     = $merchantPaymentInfoDataTable->query(new MerchantPaymentInfo());
        $totalCount = $result->count();

        $totalPending = $this->merchantPaymentInfoRepository->whereCount('status',
            MerchantPaymentInfoStatusEnum::PENDING->value);
        $totalComplete = $this->merchantPaymentInfoRepository->whereCount('status',
            MerchantPaymentInfoStatusEnum::COMPLETE->value);
        $totalCanceled = $this->merchantPaymentInfoRepository->whereCount('status',
            MerchantPaymentInfoStatusEnum::CANCELED->value);

        return $merchantPaymentInfoDataTable->render('merchant::paymentInfo', compact('totalCount', 'totalPending', 'totalComplete', 'totalCanceled'));
    }

    /**
     * Display total count of the resource.
     * @param string $status
     * @return JsonResponse
     */
    public function totalCount(MerchantPaymentInfoDataTable $merchantPaymentInfoDataTable, string $status): JsonResponse
    {

        if ($status == 'all') {
            $result     = $merchantPaymentInfoDataTable->query(new MerchantPaymentInfo());
            $totalCount = $result->count();
        } else {
            $totalCount = $this->merchantPaymentInfoRepository->whereCount('status', $status);
        }

        return response()->json([
            'success'   => true,
            'title'     => "Count",
            'status'    => $status,
            'countRows' => $totalCount,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('merchant::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return false;
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('merchant::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('merchant::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $attribute['payment_info_id'] = $id;
        $attribute['set_status']      = $request['set_status'];

        $deposit = $this->merchantPaymentInfoService->update($attribute);

        return response()->json([
            'success' => true,
            'message' => localize("Merchant payment info update successfully"),
            'title'   => localize("Merchant"),
            'status'  => $request['set_status'],
            'data'    => $deposit,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

}
