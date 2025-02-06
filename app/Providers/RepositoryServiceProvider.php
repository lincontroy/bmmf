<?php

namespace App\Providers;

use App\Repositories\Eloquent\AcceptCurrencyGatewayRepository;
use App\Repositories\Eloquent\AcceptCurrencyRepository;
use App\Repositories\Eloquent\ArticleDataRepository;
use App\Repositories\Eloquent\ArticleLangDataRepository;
use App\Repositories\Eloquent\ArticleRepository;
use App\Repositories\Eloquent\CommissionSetupRepository;
use App\Repositories\Eloquent\CustomerRepository;
use App\Repositories\Eloquent\CustomerVerifyRepository;
use App\Repositories\Eloquent\ExternalApiSetupRepository;
use App\Repositories\Eloquent\FeeSettingRepository;
use App\Repositories\Eloquent\FiatCurrencyRepository;
use App\Repositories\Eloquent\GatewayCredentialRepository;
use App\Repositories\Eloquent\InvestmentDetailsRepository;
use App\Repositories\Eloquent\InvestmentEarningRepository;
use App\Repositories\Eloquent\InvestmentRepository;
use App\Repositories\Eloquent\LanguageRepository;
use App\Repositories\Eloquent\MessageRepository;
use App\Repositories\Eloquent\MessageUserRepository;
use App\Repositories\Eloquent\MessengerRepository;
use App\Repositories\Eloquent\ModuleRepository;
use App\Repositories\Eloquent\NotificationRepository;
use App\Repositories\Eloquent\NotificationSetupRepository;
use App\Repositories\Eloquent\OtpVerificationRepository;
use App\Repositories\Eloquent\PaymentGatewayRepository;
use App\Repositories\Eloquent\PaymentRequestRepository;
use App\Repositories\Eloquent\PermissionGroupRepository;
use App\Repositories\Eloquent\PermissionRepository;
use App\Repositories\Eloquent\RoleRepository;
use App\Repositories\Eloquent\SettingRepository;
use App\Repositories\Eloquent\SystemUserRepository;
use App\Repositories\Eloquent\TeamMemberRepository;
use App\Repositories\Eloquent\TxnFeeReportRepository;
use App\Repositories\Eloquent\TxnReportRepository;
use App\Repositories\Eloquent\UserLogRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\WalletMangeRepository;
use App\Repositories\Eloquent\WalletTransactionLogRepository;
use App\Repositories\Eloquent\WithdrawAccountRepository;
use App\Repositories\Eloquent\WithdrawalAccountCredentialRepository;
use App\Repositories\Interfaces\AcceptCurrencyGatewayRepositoryInterface;
use App\Repositories\Interfaces\AcceptCurrencyRepositoryInterface;
use App\Repositories\Interfaces\ArticleDataRepositoryInterface;
use App\Repositories\Interfaces\ArticleLangDataRepositoryInterface;
use App\Repositories\Interfaces\ArticleRepositoryInterface;
use App\Repositories\Interfaces\CommissionSetupRepositoryInterface;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Repositories\Interfaces\CustomerVerifyRepositoryInterface;
use App\Repositories\Interfaces\ExternalApiRepositoryInterface;
use App\Repositories\Interfaces\FeeSettingRepositoryInterface;
use App\Repositories\Interfaces\FiatCurrencyRepositoryInterface;
use App\Repositories\Interfaces\GatewayCredentialRepositoryInterface;
use App\Repositories\Interfaces\InvestmentDetailsRepositoryInterface;
use App\Repositories\Interfaces\InvestmentEarningRepositoryInterface;
use App\Repositories\Interfaces\InvestmentRepositoryInterface;
use App\Repositories\Interfaces\LanguageRepositoryInterface;
use App\Repositories\Interfaces\MessageRepositoryInterface;
use App\Repositories\Interfaces\MessageUserRepositoryInterface;
use App\Repositories\Interfaces\MessengerRepositoryInterface;
use App\Repositories\Interfaces\ModuleRepositoryInterface;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use App\Repositories\Interfaces\NotificationSetupRepositoryInterface;
use App\Repositories\Interfaces\OtpVerificationRepositoryInterface;
use App\Repositories\Interfaces\PaymentGatewayRepositoryInterface;
use App\Repositories\Interfaces\PaymentRequestRepositoryInterface;
use App\Repositories\Interfaces\PermissionGroupRepositoryInterface;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\SettingRepositoryInterface;
use App\Repositories\Interfaces\SystemUsersRepositoryInterface;
use App\Repositories\Interfaces\TeamMemberRepositoryInterface;
use App\Repositories\Interfaces\TxnFeeReportRepositoryInterface;
use App\Repositories\Interfaces\TxnReportRepositoryInterface;
use App\Repositories\Interfaces\UserLogRepositoryInterface;
use App\Repositories\Interfaces\UsersRepositoryInterface;
use App\Repositories\Interfaces\WalletManageRepositoryInterface;
use App\Repositories\Interfaces\WalletTransactionLogRepositoryInterface;
use App\Repositories\Interfaces\WithdrawAccountCredentialRepositoryInterface;
use App\Repositories\Interfaces\WithdrawAccountRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use Modules\Package\App\Repositories\Eloquent\PlanTimeRepository;
use Modules\Package\App\Repositories\Interfaces\PlanTimeRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(UsersRepositoryInterface::class, UserRepository::class);
        $this->app->bind(SystemUsersRepositoryInterface::class, SystemUserRepository::class);
        $this->app->bind(PermissionGroupRepositoryInterface::class, PermissionGroupRepository::class);
        $this->app->bind(ArticleRepositoryInterface::class, ArticleRepository::class);
        $this->app->bind(ArticleDataRepositoryInterface::class, ArticleDataRepository::class);
        $this->app->bind(ArticleLangDataRepositoryInterface::class, ArticleLangDataRepository::class);
        $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
        $this->app->bind(TeamMemberRepositoryInterface::class, TeamMemberRepository::class);
        $this->app->bind(MessengerRepositoryInterface::class, MessengerRepository::class);
        $this->app->bind(MessageRepositoryInterface::class, MessageRepository::class);
        $this->app->bind(WalletManageRepositoryInterface::class, WalletMangeRepository::class);
        $this->app->bind(PaymentGatewayRepositoryInterface::class, PaymentGatewayRepository::class);
        $this->app->bind(LanguageRepositoryInterface::class, LanguageRepository::class);
        $this->app->bind(ExternalApiRepositoryInterface::class, ExternalApiSetupRepository::class);
        $this->app->bind(PlanTimeRepositoryInterface::class, PlanTimeRepository::class);
        $this->app->bind(ModuleRepositoryInterface::class, ModuleRepository::class);
        $this->app->bind(AcceptCurrencyRepositoryInterface::class, AcceptCurrencyRepository::class);
        $this->app->bind(WalletTransactionLogRepositoryInterface::class, WalletTransactionLogRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(GatewayCredentialRepositoryInterface::class, GatewayCredentialRepository::class);
        $this->app->bind(FeeSettingRepositoryInterface::class, FeeSettingRepository::class);
        $this->app->bind(NotificationSetupRepositoryInterface::class, NotificationSetupRepository::class);
        $this->app->bind(AcceptCurrencyGatewayRepositoryInterface::class, AcceptCurrencyGatewayRepository::class);
        $this->app->bind(TxnFeeReportRepositoryInterface::class, TxnFeeReportRepository::class);
        $this->app->bind(TxnReportRepositoryInterface::class, TxnReportRepository::class);
        $this->app->bind(InvestmentRepositoryInterface::class, InvestmentRepository::class);
        $this->app->bind(CustomerVerifyRepositoryInterface::class, CustomerVerifyRepository::class);
        $this->app->bind(InvestmentEarningRepositoryInterface::class, InvestmentEarningRepository::class);
        $this->app->bind(CommissionSetupRepositoryInterface::class, CommissionSetupRepository::class);
        $this->app->bind(InvestmentDetailsRepositoryInterface::class, InvestmentDetailsRepository::class);
        $this->app->bind(PaymentRequestRepositoryInterface::class, PaymentRequestRepository::class);
        $this->app->bind(NotificationRepositoryInterface::class, NotificationRepository::class);
        $this->app->bind(FiatCurrencyRepositoryInterface::class, FiatCurrencyRepository::class);
        $this->app->bind(WithdrawAccountRepositoryInterface::class, WithdrawAccountRepository::class);
        $this->app->bind(WithdrawAccountCredentialRepositoryInterface::class, WithdrawalAccountCredentialRepository::class);
        $this->app->bind(OtpVerificationRepositoryInterface::class, OtpVerificationRepository::class);
        $this->app->bind(MessageUserRepositoryInterface::class, MessageUserRepository::class);
        $this->app->bind(UserLogRepositoryInterface::class, UserLogRepository::class);
    }
}
