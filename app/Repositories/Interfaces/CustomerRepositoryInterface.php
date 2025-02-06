<?php

namespace App\Repositories\Interfaces;

use App\Repositories\Interfaces\BaseRepositoryInterface;

interface CustomerRepositoryInterface extends BaseRepositoryInterface
{
    public function create(array $attributes): object;
    public function countCurrentMonthCustomer(): int;
    public function countPreviousMonthCustomer(): int;
    public function countYearlyCustomer(): array;

    /**
     * Create Customer
     *
     * @param array $attributes
     * @return object
     */
    public function customerCreate(array $attributes): object;

    /**
     * Update Customer Information
     *
     * @param integer $id
     * @param array $attributes
     * @return array
     */
    public function updateCustomerInformation(int $id, array $attributes): bool;

    /**
     * Update Customer Avatar
     *
     * @param integer $id
     * @param string|null $avatar
     * @return array
     */
    public function updateAvatar(int $id, ?string $avatar): bool;

    /**
     * Update Customer Password
     *
     * @param integer $id
     * @param string $password
     * @return array
     */
    public function updatePassword(int $id, string $password): bool;

    /**
     * Update Customer Last Login
     *
     * @param integer $id
     * @param array $attributes
     * @return array
     */
    public function updateLastLogin(int $id, array $attributes): bool;

    /**
     * Update Customer Last Logout
     *
     * @param integer $id
     * @param array $attributes
     * @return array
     */
    public function updateLastLogout(int $id, array $attributes): bool;

    /**
     * Customer Verify Status Update
     *
     * @param integer $id
     * @param array $attributes
     * @return array
     */
    public function updateVerifiedStatus(int $id, array $attributes): bool;

    /**
     * Customer Site Align Update
     *
     * @param integer $id
     * @param array $attributes
     * @return array
     */
    public function updateSiteAlignById(int $id, array $attributes): bool;

    /**
     * Add Customer google 2fa auth
     *
     * @param integer $id
     * @param string $secretKey
     * @return array
     */
    public function addGoogle2faAuth(int $id, string $secretKey): bool;

    /**
     * Add Customer google 2fa auth
     *
     * @param integer $id
     * @param string $secretKey
     * @return array
     */
    public function removeGoogle2faAuth(int $id): bool;

    /**
     * Update Customer merchant verified status
     *
     * @param integer $id
     * @param integer $merchantVerifiedStatus
     * @return array
     */
    public function updateMerchantVerifiedStatus(int $id, int $merchantVerifiedStatus): bool;

    /**
     * Undocumented function
     *
     * @param array $attributes
     * @return object|null
     */
    public function findCustomer(array $attributes): ?object;

    public function updateVerifyStatusById(int $id, array $attributes): bool;

}
