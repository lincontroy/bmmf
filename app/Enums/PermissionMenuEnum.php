<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum PermissionMenuEnum: string {

    case DASHBOARD = 'dashboard';

    case CUSTOMER_CUSTOMERS        = 'customer';
    case ACCOUNT_VERIFICATION      = 'account_verification';
    case ACCOUNT_VERIFIED          = 'account_verified';
    case ACCOUNT_VERIFIED_CANCELED = 'account_verified_canceled';

    case B2X_LOAN_AVAILABLE_PACKAGES    = 'available_packages';
    case B2X_LOAN_PENDING_LOANS         = 'pending_loan';
    case B2X_LOAN_LOAN_SUMMARY          = 'loan_summary';
    case B2X_LOAN_WITHDRAWAL_PENDING    = 'withdrawal_pending';
    case B2X_LOAN_CLOSED_LOANS          = 'close_loan';
    case B2X_LOAN_THE_MONTHS_REPAYMENTS = 'the_months_payment';
    case B2X_LOAN_ALL_LOAN_REPAYMENTS   = 'all_loan_repayment';

    case FINANCE_DEPOSIT_LIST     = 'finance_deposit_list';
    case FINANCE_PENDING_DEPOSIT  = 'finance_pending_deposit';
    case FINANCE_WITHDRAW_LIST    = 'finance_withdraw_list';
    case FINANCE_PENDING_WITHDRAW = 'finance_pending_withdraw';
    case FINANCE_CREDIT_LIST      = 'finance_credit_list';
    case FINANCE_TRANSFER         = 'finance_transfer';

    case MERCHANT_APPLICATION      = 'merchant_application';
    case MERCHANT_ACCOUNT          = 'merchant_account';
    case MERCHANT_TRANSACTIONS     = 'merchant_transaction';
    case MERCHANT_TRANSACTION_FEES = 'merchant_transaction_fee';
    case MERCHANT_PENDING_WITHDRAW = 'merchant_pending_withdraw';
    case MERCHANT_WITHDRAW_LIST    = 'merchant_withdraw_list';

    case PACKAGE           = 'package';
    case PACKAGE_TIME_LIST = 'package_time_list';

    case QUICK_EXCHANGE_SUPPORTED_COIN   = 'supported_coin';
    case QUICK_EXCHANGE_BASE_CURRENCY    = 'base_currency';
    case QUICK_EXCHANGE_ORDER_REQUEST    = 'order_request';
    case QUICK_EXCHANGE_TRANSACTION_LIST = 'transaction_list';

    case REPORTS_TRANSACTION   = 'report_transaction';
    case REPORTS_INVESTMENT    = 'report_investment';
    case REPORTS_FEES          = 'report_fee';
    case REPORTS_LOGIN_HISTORY = 'report_login_history';

    case STAKE_PLAN         = 'plan';
    case STAKE_SUBSCRIPTION = 'subscription';

    case SUPPORT = 'support';

    case MANAGES_ROLE = 'role';
    case MANAGES_USER = 'user';

    case PAYMENT_SETTING_PAYMENT_GATEWAY = 'payment_gateway';
    case PAYMENT_SETTING_ACCEPT_CURRENCY = 'accept_currency';
    case PAYMENT_SETTING_FIAT_CURRENCY   = 'fiat_currency';

    case CMS_MENU               = 'menu';
    case CMS_HOME_SLIDER        = 'home_slider';
    case CMS_SOCIAL_ICON        = 'social_icon';
    case CMS_HOME_ABOUT         = 'home_about';
    case CMS_PACKAGE_BANNER     = 'package_banner';
    case CMS_JOIN_US_TODAY      = 'join_us_today';
    case CMS_MERCHANT           = 'merchant';
    case CMS_INVESTMENT         = 'investment';
    case CMS_WHY_CHOSE          = 'why_chose';
    case CMS_SATISFIED_CUSTOMER = 'satisfied_customer';
    case CMS_FAQ                = 'faq';
    case CMS_BLOG               = 'blog';
    case CMS_CONTACT            = 'contact';
    case CMS_PAYMENT_WE_ACCEPT  = 'payment_we_accept';
    case CMS_STAKE              = 'stake';
    case CMS_B2X                = 'b2x';
    case CMS_TOP_INVESTOR       = 'top_investor';
    case CMS_OUR_SERVICE        = 'our_service';
    case CMS_OUR_RATE           = 'our_rate';
    case CMS_TEAM_MEMBER        = 'team_member';
    case CMS_OUR_DIFFERENCE     = 'our_difference';
    case CMS_QUICK_EXCHANGE     = 'quick_exchange';
    case CMS_BG_IMAGE     = 'background_image';

    case SETTING_APP_SETTING        = 'app_setting';
    case SETTING_FEE_SETTING        = 'fee_setting';
    case SETTING_COMMISSION_SETUP   = 'commission_setup';
    case SETTING_NOTIFICATION_SETUP = 'notification_setup';
    case SETTING_EMAIL_GATEWAY      = 'email_gateway';
    case SETTING_SMS_GATEWAY        = 'sms_gateway';
    case SETTING_LANGUAGE_SETTING   = 'language_setting';
    case SETTING_BACKUP             = 'backup';
}