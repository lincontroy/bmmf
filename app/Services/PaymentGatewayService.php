<?php

namespace App\Services;

use App\Enums\AssetsFolderEnum;
use App\Enums\AuthGuardEnum;
use App\Helpers\ImageHelper;
use App\Repositories\Interfaces\GatewayCredentialRepositoryInterface;
use App\Repositories\Interfaces\PaymentGatewayRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentGatewayService
{
    /**
     * MessengerService constructor.
     *
     */
    public function __construct(
        private PaymentGatewayRepositoryInterface $paymentGatewayRepository,
        private GatewayCredentialRepositoryInterface $credentialRepository
    ) {
    }

    /**
     * Create Payment Gateway
     * @param array $attributes
     * @return object
     */
    public function create(array $attributes): object
    {
        try {
            DB::beginTransaction();
            $gatewayLogo  = $attributes["gateway_logo"];
            $documentPath = ImageHelper::upload($gatewayLogo, AssetsFolderEnum::PAYMENT_GATEWAY_DIR->value);
            $gatewayData  = $this->paymentGatewayRepository->create([
                "name"        => $attributes["gateway_name"],
                "min_deposit" => $attributes["min_transaction_amount"],
                "max_deposit" => $attributes["max_transaction_amount"],
                "fee_percent" => 0,
                "logo"        => $documentPath ?? null,
                "status"      => $attributes["status"],
                "created_by"  => auth()->user()->id,
            ]);

            if ($gatewayData) {

                foreach ($attributes['credential_name'] as $key => $value) {
                    $type = Str::lower($value);
                    $type = Str::replace(' ', '_', $type);
                    $this->credentialRepository->create([
                        "payment_gateway_id" => $gatewayData->id,
                        "type"               => $type,
                        "name"               => $value,
                        "credentials"        => $attributes['credential_value'][$key],
                    ]);
                }

            }

            DB::commit();

            return $gatewayData;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

    }

    /**
     * Find all payment gateways
     * @return void
     */
    public function findPaymentGateway(): ?object
    {
        return $this->paymentGatewayRepository->all();
    }

    /**
     * Find all payment gateways
     * @return void
     */
    public function findGateway(): ?object
    {
        return $this->paymentGatewayRepository->findWhere('status', 1);
    }

    /**
     * Delete stake plan data
     * @param array $attributes
     * @return bool
     */
    public function destroy(array $attributes): bool
    {
        $gateway_id = $attributes['gateway_id'];
        try {
            DB::beginTransaction();

            $this->paymentGatewayRepository->delete($gateway_id);
            $this->credentialRepository->destroyCredential($gateway_id);

            DB::commit();

            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

    }

    /**
     * Find Payment Gateway Data
     * @param int $id
     * @return object|null
     */
    public function find(int $id): ?object
    {
        return $this->paymentGatewayRepository->find($id);
    }

    /**
     * Update Payment Gateway
     * @param array $attributes
     * @param string $id
     * @return bool
     */
    public function update(array $attributes, string $id): bool
    {
        try {

            $updateData = [
                "name"        => $attributes["gateway_name"],
                "min_deposit" => $attributes["min_transaction_amount"],
                "max_deposit" => $attributes["max_transaction_amount"],
                "status"      => $attributes["status"],
                'updated_by'  => auth(AuthGuardEnum::ADMIN->value)->user()->id,
            ];

            DB::beginTransaction();

            $updateResult = $this->paymentGatewayRepository->updateById($id, $updateData);

            if ($updateResult) {
                $this->credentialRepository->destroyCredential($id);

                foreach ($attributes['credential_name'] as $key => $value) {
                    $type = Str::lower($value);
                    $type = Str::replace(' ', '_', $type);
                    $this->credentialRepository->create([
                        "payment_gateway_id" => $id,
                        "type"               => $type,
                        "name"               => $value,
                        "credentials"        => $attributes['credential_value'][$key],
                    ]);
                }

            }

            DB::commit();

            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

    }

    /**
     * Find by attributes
     *
     * @param array $attributes
     * @return object|null
     */
    public function findByAttributes(array $attributes): ?object
    {
        return $this->paymentGatewayRepository->findByAttributes($attributes);
    }

}
