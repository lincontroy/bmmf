<?php

namespace Modules\Merchant\App\Http\Controllers;

use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\AcceptCurrencyRepositoryInterface;
use App\Traits\ChecksPermissionTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Merchant\app\DataTables\MerchantApplicationDataTable;
use Modules\Merchant\App\Http\Requests\MerchantFeeRequest;
use Modules\Merchant\App\Services\MerchantFeeService;

class MerchantFeeController extends Controller
{
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * MerchantAccountController of __construct
     *
     * @param AcceptCurrencyRepositoryInterface $acceptCurrencyRepository
     * @param MerchantFeeService $merchantFeeService
     */
    public function __construct(
        protected AcceptCurrencyRepositoryInterface $acceptCurrencyRepository,
        protected MerchantFeeService $merchantFeeService,

    ) {
        $this->mapActionPermission = [
            'index'   => PermissionMenuEnum::MERCHANT_TRANSACTION_FEES->value . '.' . PermissionActionEnum::READ->value,
            'create'  => PermissionMenuEnum::MERCHANT_TRANSACTION_FEES->value . '.' . PermissionActionEnum::READ->value,
            'store'   => PermissionMenuEnum::MERCHANT_TRANSACTION_FEES->value . '.' . PermissionActionEnum::READ->value,
            'show'    => PermissionMenuEnum::MERCHANT_TRANSACTION_FEES->value . '.' . PermissionActionEnum::READ->value,
            'edit'    => PermissionMenuEnum::MERCHANT_TRANSACTION_FEES->value . '.' . PermissionActionEnum::READ->value,
            'update'  => PermissionMenuEnum::MERCHANT_TRANSACTION_FEES->value . '.' . PermissionActionEnum::READ->value,
            'destroy' => PermissionMenuEnum::MERCHANT_TRANSACTION_FEES->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Display a listing of the resource.
     * @param MerchantApplicationDataTable $merchantApplicationDataTable
     * @return mixed
     */
    public function index(Request $request)
    {
        cs_set('theme', [
            'title'       => localize('Merchant Fee'),
            'description' => localize('Merchant Fee'),
        ]);

        $attribute['perPage'] = $request->input('per_page', 30);
        $currencies           = $this->acceptCurrencyRepository->getCurrency($attribute);

        return view('merchant::fee', compact('currencies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MerchantFeeRequest $request): JsonResponse
    {
        $data = $request->validated();

        $fee = $this->merchantFeeService->create($data);

        return response()->json([
            'success' => true,
            'message' => localize("Merchant fee updated successfully"),
            'title'   => localize("Merchant"),
            'data'    => $fee,
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
        $attribute['merchant_id'] = $id;
        $attribute['set_status']  = $request['set_status'];
        $attribute['checked_by']  = Auth::id();

        $deposit = $this->merchantFeeService->update($attribute);

        return response()->json([
            'success' => true,
            'message' => localize("Merchant account update successfully"),
            'title'   => localize("Merchant"),
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
