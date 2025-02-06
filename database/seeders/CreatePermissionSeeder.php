<?php

namespace Database\Seeders;

use App\Enums\PermissionActionEnum;
use App\Enums\PermissionGroupEnum;
use App\Enums\PermissionMenuEnum;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreatePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        Schema::enableForeignKeyConstraints();

        $permissions = [
            PermissionGroupEnum::DASHBOARD->value        => [
                PermissionMenuEnum::DASHBOARD->value . '.' . PermissionActionEnum::READ->value,
            ],

            PermissionGroupEnum::CUSTOMER->value         => [
                PermissionMenuEnum::CUSTOMER_CUSTOMERS->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::CUSTOMER_CUSTOMERS->value . '.' . PermissionActionEnum::CREATE->value,
                PermissionMenuEnum::CUSTOMER_CUSTOMERS->value . '.' . PermissionActionEnum::UPDATE->value,
                PermissionMenuEnum::CUSTOMER_CUSTOMERS->value . '.' . PermissionActionEnum::DELETE->value,

                PermissionMenuEnum::ACCOUNT_VERIFICATION->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::ACCOUNT_VERIFIED->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::ACCOUNT_VERIFIED_CANCELED->value . '.' . PermissionActionEnum::READ->value,
            ],

            PermissionGroupEnum::B2X_LOAN->value         => [
                PermissionMenuEnum::B2X_LOAN_AVAILABLE_PACKAGES->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::B2X_LOAN_AVAILABLE_PACKAGES->value . '.' . PermissionActionEnum::CREATE->value,
                PermissionMenuEnum::B2X_LOAN_AVAILABLE_PACKAGES->value . '.' . PermissionActionEnum::UPDATE->value,
                PermissionMenuEnum::B2X_LOAN_AVAILABLE_PACKAGES->value . '.' . PermissionActionEnum::DELETE->value,

                PermissionMenuEnum::B2X_LOAN_PENDING_LOANS->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::B2X_LOAN_LOAN_SUMMARY->value . '.' . PermissionActionEnum::READ->value,

                PermissionMenuEnum::B2X_LOAN_WITHDRAWAL_PENDING->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::B2X_LOAN_CLOSED_LOANS->value . '.' . PermissionActionEnum::READ->value,

                PermissionMenuEnum::B2X_LOAN_THE_MONTHS_REPAYMENTS->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::B2X_LOAN_ALL_LOAN_REPAYMENTS->value . '.' . PermissionActionEnum::READ->value,
            ],

            PermissionGroupEnum::FINANCE->value          => [
                PermissionMenuEnum::FINANCE_DEPOSIT_LIST->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::FINANCE_PENDING_DEPOSIT->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::FINANCE_WITHDRAW_LIST->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::FINANCE_PENDING_WITHDRAW->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::FINANCE_CREDIT_LIST->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::FINANCE_TRANSFER->value . '.' . PermissionActionEnum::READ->value,
            ],

            PermissionGroupEnum::MERCHANT->value         => [
                PermissionMenuEnum::MERCHANT_APPLICATION->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::MERCHANT_ACCOUNT->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::MERCHANT_TRANSACTIONS->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::MERCHANT_TRANSACTION_FEES->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::MERCHANT_PENDING_WITHDRAW->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::MERCHANT_WITHDRAW_LIST->value . '.' . PermissionActionEnum::READ->value,
            ],

            PermissionGroupEnum::PACKAGE->value          => [
                PermissionMenuEnum::PACKAGE->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::PACKAGE->value . '.' . PermissionActionEnum::CREATE->value,
                PermissionMenuEnum::PACKAGE->value . '.' . PermissionActionEnum::UPDATE->value,
                PermissionMenuEnum::PACKAGE->value . '.' . PermissionActionEnum::DELETE->value,

                PermissionMenuEnum::PACKAGE_TIME_LIST->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::PACKAGE_TIME_LIST->value . '.' . PermissionActionEnum::CREATE->value,
                PermissionMenuEnum::PACKAGE_TIME_LIST->value . '.' . PermissionActionEnum::UPDATE->value,
                PermissionMenuEnum::PACKAGE_TIME_LIST->value . '.' . PermissionActionEnum::DELETE->value,
            ],

            PermissionGroupEnum::QUICK_EXCHANGE->value   => [
                PermissionMenuEnum::QUICK_EXCHANGE_SUPPORTED_COIN->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::QUICK_EXCHANGE_SUPPORTED_COIN->value . '.' . PermissionActionEnum::CREATE->value,
                PermissionMenuEnum::QUICK_EXCHANGE_SUPPORTED_COIN->value . '.' . PermissionActionEnum::UPDATE->value,
                PermissionMenuEnum::QUICK_EXCHANGE_SUPPORTED_COIN->value . '.' . PermissionActionEnum::DELETE->value,

                // PermissionMenuEnum::QUICK_EXCHANGE_BASE_CURRENCY->value . '.' . PermissionActionEnum::READ->value,

                PermissionMenuEnum::QUICK_EXCHANGE_ORDER_REQUEST->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::QUICK_EXCHANGE_TRANSACTION_LIST->value . '.' . PermissionActionEnum::READ->value,
            ],

            PermissionGroupEnum::REPORTS->value          => [
                PermissionMenuEnum::REPORTS_TRANSACTION->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::REPORTS_INVESTMENT->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::REPORTS_FEES->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::REPORTS_LOGIN_HISTORY->value . '.' . PermissionActionEnum::READ->value,
            ],

            PermissionGroupEnum::STAKE->value            => [
                PermissionMenuEnum::STAKE_PLAN->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::STAKE_PLAN->value . '.' . PermissionActionEnum::CREATE->value,
                PermissionMenuEnum::STAKE_PLAN->value . '.' . PermissionActionEnum::UPDATE->value,
                PermissionMenuEnum::STAKE_PLAN->value . '.' . PermissionActionEnum::DELETE->value,

                PermissionMenuEnum::STAKE_SUBSCRIPTION->value . '.' . PermissionActionEnum::READ->value,
            ],

            PermissionGroupEnum::SUPPORT->value          => [
                PermissionMenuEnum::SUPPORT->value . '.' . PermissionActionEnum::READ->value,
            ],

            PermissionGroupEnum::ROLES_MANAGER->value    => [
                PermissionMenuEnum::MANAGES_ROLE->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::MANAGES_ROLE->value . '.' . PermissionActionEnum::CREATE->value,
                PermissionMenuEnum::MANAGES_ROLE->value . '.' . PermissionActionEnum::UPDATE->value,
                PermissionMenuEnum::MANAGES_ROLE->value . '.' . PermissionActionEnum::DELETE->value,

                PermissionMenuEnum::MANAGES_USER->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::MANAGES_USER->value . '.' . PermissionActionEnum::CREATE->value,
                PermissionMenuEnum::MANAGES_USER->value . '.' . PermissionActionEnum::UPDATE->value,
                PermissionMenuEnum::MANAGES_USER->value . '.' . PermissionActionEnum::DELETE->value,
            ],

            PermissionGroupEnum::PAYMENTS_SETTING->value => [
                PermissionMenuEnum::PAYMENT_SETTING_PAYMENT_GATEWAY->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::PAYMENT_SETTING_PAYMENT_GATEWAY->value . '.' . PermissionActionEnum::CREATE->value,
                PermissionMenuEnum::PAYMENT_SETTING_PAYMENT_GATEWAY->value . '.' . PermissionActionEnum::UPDATE->value,
                PermissionMenuEnum::PAYMENT_SETTING_PAYMENT_GATEWAY->value . '.' . PermissionActionEnum::DELETE->value,

                PermissionMenuEnum::PAYMENT_SETTING_ACCEPT_CURRENCY->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::PAYMENT_SETTING_ACCEPT_CURRENCY->value . '.' . PermissionActionEnum::CREATE->value,
                PermissionMenuEnum::PAYMENT_SETTING_ACCEPT_CURRENCY->value . '.' . PermissionActionEnum::UPDATE->value,
                PermissionMenuEnum::PAYMENT_SETTING_ACCEPT_CURRENCY->value . '.' . PermissionActionEnum::DELETE->value,

                PermissionMenuEnum::PAYMENT_SETTING_FIAT_CURRENCY->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::PAYMENT_SETTING_FIAT_CURRENCY->value . '.' . PermissionActionEnum::CREATE->value,
                PermissionMenuEnum::PAYMENT_SETTING_FIAT_CURRENCY->value . '.' . PermissionActionEnum::UPDATE->value,
                PermissionMenuEnum::PAYMENT_SETTING_FIAT_CURRENCY->value . '.' . PermissionActionEnum::DELETE->value,

            ],

            PermissionGroupEnum::CMS->value              => [
                PermissionMenuEnum::CMS_MENU->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::CMS_HOME_SLIDER->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::CMS_SOCIAL_ICON->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::CMS_HOME_ABOUT->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::CMS_JOIN_US_TODAY->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::CMS_PACKAGE_BANNER->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::CMS_MERCHANT->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::CMS_INVESTMENT->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::CMS_WHY_CHOSE->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::CMS_SATISFIED_CUSTOMER->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::CMS_FAQ->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::CMS_BLOG->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::CMS_CONTACT->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::CMS_PAYMENT_WE_ACCEPT->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::CMS_STAKE->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::CMS_B2X->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::CMS_TOP_INVESTOR->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::CMS_OUR_SERVICE->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::CMS_OUR_RATE->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::CMS_TEAM_MEMBER->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::CMS_OUR_DIFFERENCE->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::CMS_QUICK_EXCHANGE->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::CMS_BG_IMAGE->value . '.' . PermissionActionEnum::READ->value,
            ],

            PermissionGroupEnum::SETTING->value          => [
                PermissionMenuEnum::SETTING_APP_SETTING->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::SETTING_FEE_SETTING->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::SETTING_COMMISSION_SETUP->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::SETTING_NOTIFICATION_SETUP->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::SETTING_EMAIL_GATEWAY->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::SETTING_SMS_GATEWAY->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::SETTING_LANGUAGE_SETTING->value . '.' . PermissionActionEnum::READ->value,
                PermissionMenuEnum::SETTING_BACKUP->value . '.' . PermissionActionEnum::READ->value,
            ],
        ];

        $insertPermissions = [];

        foreach ($permissions as $group => $groups) {

            foreach ($groups as $permission) {

                $permissionExists = Permission::query()
                    ->where('guard_name', 'admin')
                    ->where('name', $permission)
                    ->where('group', $group)
                    ->exists();

                if (!$permissionExists) {
                    $insertPermissions[] = [
                        'guard_name' => 'admin',
                        'name'       => $permission,
                        'group'      => $group,
                    ];
                }

            }

        }

        if (!empty($insertPermissions)) {
            Permission::query()->insert($insertPermissions);

            $adminRole     = Role::create(['name' => 'Admin']);
            $permissionIds = Permission::pluck('id')->toArray();
            $user          = User::find(1);

            $adminRole->syncPermissions($permissionIds);
            $user->assignRole($adminRole);
        }

    }

}
