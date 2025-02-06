<?php

namespace Modules\Merchant\App\Http\Controllers;

use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Http\Controllers\Controller;
use App\Traits\ChecksPermissionTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Merchant\App\DataTables\MerchantApplicationDataTable;
use Modules\Merchant\App\DataTables\MerchantConfirmedDataTable;
use Modules\Merchant\App\Models\MerchantAccount;
use Modules\Merchant\App\Services\MerchantAccountService;

class MerchantAccountController extends Controller
{
    use ChecksPermissionTrait;

    public $mapActionPermission;

    /**
     * MerchantAccountController of __construct
     * @param MerchantAccountService $merchantAccountService
     */
    public function __construct(
        protected MerchantAccountService $merchantAccountService,
    ) {
        $this->mapActionPermission = [
            'index'           => PermissionMenuEnum::MERCHANT_APPLICATION->value . '.' . PermissionActionEnum::READ->value,
            'confirmMerchant' => PermissionMenuEnum::MERCHANT_ACCOUNT->value . '.' . PermissionActionEnum::READ->value,
            'create'          => PermissionMenuEnum::MERCHANT_APPLICATION->value . '.' . PermissionActionEnum::READ->value,
            'store'           => PermissionMenuEnum::MERCHANT_APPLICATION->value . '.' . PermissionActionEnum::READ->value,
            'show'            => PermissionMenuEnum::MERCHANT_APPLICATION->value . '.' . PermissionActionEnum::READ->value,
            'edit'            => PermissionMenuEnum::MERCHANT_APPLICATION->value . '.' . PermissionActionEnum::READ->value,
            'update'          => PermissionMenuEnum::MERCHANT_APPLICATION->value . '.' . PermissionActionEnum::READ->value,
            'destroy'         => PermissionMenuEnum::MERCHANT_APPLICATION->value . '.' . PermissionActionEnum::READ->value,
        ];
    }

    /**
     * Display a listing of the resource.
     * @param MerchantApplicationDataTable $merchantApplicationDataTable
     * @return mixed
     */
    public function index(MerchantApplicationDataTable $merchantApplicationDataTable)
    {
        cs_set('theme', [
            'title'       => localize('Merchant Application'),
            'description' => localize('Merchant Application'),
        ]);

        return $merchantApplicationDataTable->render('merchant::index');
    }

    /**
     * Display a listing of the resource.
     */
    public function confirmMerchant(MerchantConfirmedDataTable $merchantConfirmedDataTable)
    {
        cs_set('theme', [
            'title'       => localize('Merchant Accounts'),
            'description' => localize('Merchant Accounts'),
        ]);

        return $merchantConfirmedDataTable->render('merchant::confirmed');
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
    public function store(Request $request)
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
        $attribute['merchant_id'] = $id;
        $attribute['set_status']  = $request['set_status'];
        $attribute['checked_by']  = Auth::id();

        $deposit = $this->merchantAccountService->update($attribute);

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
