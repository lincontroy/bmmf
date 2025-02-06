<?php

namespace App\Enums;

enum WalletManageLogEnum: string {
    case CREDITED          = 'Credited';
    case DEPOSIT           = 'Deposit';
    case WITHDRAW          = 'Withdraw';
    case MERCHANT_WITHDRAW = 'Merchant Withdraw';
    case WITHDRAW_CANCEL   = 'Withdraw Cancel';
    case TRANSFER          = 'Transfer';
    case RECEIVED          = 'Received';
    case STAKE             = 'Staked';
    case PACKAGE           = 'Package';
    case LOAN              = 'Loan';
    case HOLD              = 'Hold';
    case REPAYMENT         = 'Repayment';
    case ROI               = 'ROI';
    case CAPITAL_RETURN    = 'Capital Return';
    case REDEEMED          = 'Redeemed';
    case STAKE_INTEREST    = 'Stake Interest';
}
