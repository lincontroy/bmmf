<?php

namespace App\Http\Controllers\Currency;

use App\DataTables\FiatCurrencyDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\FiatCurrencyRequest;
use App\Services\FiatCurrencyService;
use App\Services\PaymentGatewayService;
use Illuminate\Http\JsonResponse;
use App\Traits\ChecksPermissionTrait;
use App\Enums\PermissionMenuEnum;
use App\Enums\PermissionActionEnum;

class FiatCurrencyController extends Controller
{
    use ChecksPermissionTrait;

    public $mapActionPermission;


    /**
     * FiatCurrencyController of constructor
     *
     * @param FiatCurrencyService $fiatCurrencyService
     * @param PaymentGatewayService $paymentGatewayService
     */
    public function __construct(
        private FiatCurrencyService $fiatCurrencyService,
        private PaymentGatewayService $paymentGatewayService
    ) {
        $this->mapActionPermission = [
            'index'   => PermissionMenuEnum::PAYMENT_SETTING_FIAT_CURRENCY->value  . '.' . PermissionActionEnum::READ->value,
            'create'  => PermissionMenuEnum::PAYMENT_SETTING_FIAT_CURRENCY->value  . '.' . PermissionActionEnum::CREATE->value,
            'store'   => PermissionMenuEnum::PAYMENT_SETTING_FIAT_CURRENCY->value  . '.' . PermissionActionEnum::CREATE->value,
            'edit'    => PermissionMenuEnum::PAYMENT_SETTING_FIAT_CURRENCY->value  . '.' . PermissionActionEnum::UPDATE->value,
            'update'  => PermissionMenuEnum::PAYMENT_SETTING_FIAT_CURRENCY->value  . '.' . PermissionActionEnum::UPDATE->value,
            'destroy' => PermissionMenuEnum::PAYMENT_SETTING_FIAT_CURRENCY->value  . '.' . PermissionActionEnum::DELETE->value,
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(FiatCurrencyDataTable $fiatCurrencyDataTable)
    {
        cs_set('theme', [
            'title'       => localize('Fiat Currency'),
            'description' => localize('Fiat Currency'),
        ]);

        return $fiatCurrencyDataTable->render('backend.currency.fiat');
    }

    /**
     * Store the specified resource in storage.
     *
     * @param  FiatCurrencyRequest  $request
     * @return JsonResponse
     * @throws Exception
     */
    public function store(FiatCurrencyRequest $request): JsonResponse
    {
        $data = $request->validated();

        $fiatCurrency = $this->fiatCurrencyService->create($data);

        return response()->json([
            'success' => true,
            'message' => localize("Fiat Currency create successfully"),
            'title'   => localize("Fiat currency"),
            'data'    => $fiatCurrency,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     * @throws Exception
     */
    public function edit(string $id): JsonResponse
    {
        $fiatCurrency = $this->fiatCurrencyService->findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => localize("Fiat Currency Data"),
            'title'   => localize("Fiat Currency"),
            'data'    => $fiatCurrency,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FiatCurrencyRequest  $request
     * @param  int  $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(FiatCurrencyRequest $request, string $id): JsonResponse
    {
        $validateData = $request->validated();

        $updateData = $this->fiatCurrencyService->update($validateData, $id);

        return response()->json([
            'success' => true,
            'message' => localize("Fiat Currency Updated successfully"),
            'title'   => localize("Fiat currency"),
            'data'    => $updateData,
        ]);
    }

    /**
     * Remove the specified resource in storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(string $id): JsonResponse
    {
        $this->fiatCurrencyService->destroy(['fiat_currency_id' => $id]);

        return response()->json([
            'success' => true,
            'message' => localize("Fiat Currency Deleted successfully"),
            'title'   => localize("Fiat currency"),
        ]);
    }

}
