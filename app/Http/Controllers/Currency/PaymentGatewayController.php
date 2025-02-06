<?php

namespace App\Http\Controllers\Currency;

use App\Enums\PermissionActionEnum;
use App\Enums\PermissionMenuEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentGatewayRequest;
use App\Services\PaymentGatewayService;
use App\Traits\ChecksPermissionTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class PaymentGatewayController extends Controller
{
    use ChecksPermissionTrait;

    public $mapActionPermission;

    public function __construct(
        private PaymentGatewayService $paymentGatewayService
    ) {
        $this->mapActionPermission = [
            'index'   => PermissionMenuEnum::PAYMENT_SETTING_PAYMENT_GATEWAY->value . '.' . PermissionActionEnum::READ->value,
            'create'  => PermissionMenuEnum::PAYMENT_SETTING_PAYMENT_GATEWAY->value . '.' . PermissionActionEnum::CREATE->value,
            'store'   => PermissionMenuEnum::PAYMENT_SETTING_PAYMENT_GATEWAY->value . '.' . PermissionActionEnum::CREATE->value,
            'edit'    => PermissionMenuEnum::PAYMENT_SETTING_PAYMENT_GATEWAY->value . '.' . PermissionActionEnum::UPDATE->value,
            'update'  => PermissionMenuEnum::PAYMENT_SETTING_PAYMENT_GATEWAY->value . '.' . PermissionActionEnum::UPDATE->value,
            'destroy' => PermissionMenuEnum::PAYMENT_SETTING_PAYMENT_GATEWAY->value . '.' . PermissionActionEnum::DELETE->value,
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        cs_set('theme', [
            'title'       => localize('Payment Gateway List'),
            'description' => localize('Payment Gateway List'),
        ]);

        $data['paymentGateway'] = $this->paymentGatewayService->findPaymentGateway();

        return view('backend.currency.gateway_list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        cs_set('theme', [
            'title'       => localize('Add Payment Gateway'),
            'description' => localize('Add Payment Gateway'),
        ]);

        return view('backend.currency.gateway_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentGatewayRequest $request): JsonResponse
    {
        $additionalRules = [
            'gateway_logo' => ["required", 'file', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
        ];
        $rules = array_merge($request->rules(), $additionalRules);

        $validatedData = $request->validate($rules);

        $createData = $this->paymentGatewayService->create($validatedData);
        return response()->json([
            'success' => true,
            'message' => localize("Payment gateway added successfully"),
            'title'   => localize("Payment Gateway"),
            'data'    => $createData,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        cs_set('theme', [
            'title'       => localize('Update Payment Gateway'),
            'description' => localize('Update Payment Gateway'),
        ]);

        $data['gatewayInfo'] = $this->paymentGatewayService->find($id);
        return view('backend.currency.gateway_edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PaymentGatewayRequest $request, string $id)
    {
        $validateData = $request->validated();
        $this->paymentGatewayService->update($validateData, $id);
        $updateData = $this->paymentGatewayService->find($id);
        return response()->json([
            'success' => true,
            'message' => localize("Payment gateway updated successfully"),
            'title'   => localize("Payment Gateway"),
            'data'    => $updateData,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->paymentGatewayService->destroy(['gateway_id' => $id]);

        return response()->json([
            'success' => true,
            'message' => localize("Gateway deleted successfully"),
            'title'   => localize("Gateway"),
        ]);
    }
}
