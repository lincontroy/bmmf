@php
    use App\Enums\PermissionMenuEnum;
    use App\Enums\PermissionActionEnum;
@endphp
@if (
    $_auth_user->can(PermissionMenuEnum::B2X_LOAN_AVAILABLE_PACKAGES->value . '.' . PermissionActionEnum::READ->value) ||
        $_auth_user->can(PermissionMenuEnum::B2X_LOAN_PENDING_LOANS->value . '.' . PermissionActionEnum::READ->value) ||
        $_auth_user->can(PermissionMenuEnum::B2X_LOAN_LOAN_SUMMARY->value . '.' . PermissionActionEnum::READ->value) ||
        $_auth_user->can(PermissionMenuEnum::B2X_LOAN_WITHDRAWAL_PENDING->value . '.' . PermissionActionEnum::READ->value) ||
        $_auth_user->can(PermissionMenuEnum::B2X_LOAN_CLOSED_LOANS->value . '.' . PermissionActionEnum::READ->value) ||
        $_auth_user->can(PermissionMenuEnum::B2X_LOAN_THE_MONTHS_REPAYMENTS->value . '.' . PermissionActionEnum::READ->value) ||
        $_auth_user->can(PermissionMenuEnum::B2X_LOAN_ALL_LOAN_REPAYMENTS->value . '.' . PermissionActionEnum::READ->value))
    <!-- Package -->
    <li>
        <a class="has-arrow material-ripple" href="#">
            <svg class="menu-icon" width="24" height="26" viewBox="0 0 24 26" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M23.6871 15.3556C23.3443 14.8961 22.8 14.6838 22.2729 14.7445C22.2814 14.5971 22.29 14.4497 22.29 14.298C22.29 11.1342 20.2586 6.87381 17.2543 5.18353C17.4514 4.95383 17.5757 4.65911 17.5757 4.32972C17.5757 3.82697 17.2886 3.39357 16.8771 3.1812L17.97 0.602434C18.0257 0.468078 18.0129 0.316386 17.9357 0.195033C17.8543 0.073679 17.7214 0 17.58 0H10.7229C10.5771 0 10.4443 0.073679 10.3671 0.195033C10.29 0.316386 10.2729 0.472412 10.3329 0.602434L11.4257 3.1812C11.0143 3.3979 10.7271 3.83131 10.7271 4.32972C10.7271 4.65911 10.8514 4.95383 11.0486 5.18353C8.04429 6.87381 6.01286 11.1385 6.01286 14.298C6.01286 14.8571 6.06857 15.4119 6.18 15.9537C5.47714 16.153 4.81714 16.4347 4.29857 16.7815V16.0317C4.29857 15.7933 4.10571 15.5983 3.87 15.5983H0.428571C0.192857 15.5983 0 15.7933 0 16.0317V25.5666C0 25.805 0.192857 26 0.428571 26H3.85714C4.09286 26 4.28571 25.805 4.28571 25.5666V24.2664H13.4914C14.5671 24.2664 15.6171 23.8893 16.4571 23.2045L23.3829 17.5443C23.7686 17.2495 24 16.7858 24 16.296C24 15.9493 23.8929 15.6243 23.6871 15.3556ZM3.42857 25.1332H0.857143V16.4651H3.42857V25.1332ZM11.3657 0.862477H16.9243L16.0071 3.0295H12.2871L11.37 0.862477H11.3657ZM16.7143 4.32972C16.7143 4.56809 16.5214 4.76313 16.2857 4.76313H12C11.7643 4.76313 11.5714 4.56809 11.5714 4.32972C11.5714 4.09135 11.7643 3.89632 12 3.89632H16.2857C16.5214 3.89632 16.7143 4.09135 16.7143 4.32972ZM12.0814 5.62994H16.2086C18.9986 6.74812 21.4329 10.7745 21.4329 14.298C21.4329 14.5754 21.4114 14.8485 21.3814 15.1172L16.2686 18.2247C16.1743 17.4792 15.5486 16.8985 14.7857 16.8985H12.24C11.3486 16.0707 10.0243 15.5983 8.57143 15.5983C8.07857 15.5983 7.53857 15.6546 7.00286 15.7543C6.90857 15.2775 6.85714 14.7921 6.85714 14.298C6.85714 10.7745 9.29143 6.74812 12.0814 5.62994ZM22.8557 16.8595L15.9171 22.5328C15.2314 23.0918 14.37 23.3996 13.4914 23.3996H4.28571V17.917C4.69286 17.4186 5.67 16.9548 6.76714 16.6948C6.77571 16.6948 6.78 16.6948 6.78857 16.6948C6.78857 16.6948 6.79286 16.6948 6.79714 16.6904C7.38 16.5518 7.99714 16.4694 8.57571 16.4694C9.85714 16.4694 11.0486 16.9072 11.7686 17.6396C11.85 17.722 11.9571 17.7696 12.0729 17.7696H14.79C15.1457 17.7696 15.4329 18.06 15.4329 18.4197C15.4329 18.7795 15.1457 19.0698 14.79 19.0698H9.86143C9.62571 19.0698 9.43286 19.2649 9.43286 19.5033C9.43286 19.7416 9.62571 19.9367 9.86143 19.9367H14.79C15.1971 19.9367 15.5657 19.772 15.8357 19.5033L22.0843 15.7066C22.3886 15.5203 22.7914 15.5983 23.01 15.8843C23.1 16.0057 23.1471 16.1487 23.1471 16.3004C23.1471 16.5214 23.0486 16.7208 22.86 16.8638L22.8557 16.8595Z"
                    fill="#6C6C6C"></path>
                <path
                    d="M13 14.2C12.45 14.2 12 13.795 12 13.3C12 13.0525 11.775 12.85 11.5 12.85C11.225 12.85 11 13.0525 11 13.3C11 14.2945 11.895 15.1 13 15.1H13.5V15.55C13.5 15.7975 13.725 16 14 16C14.275 16 14.5 15.7975 14.5 15.55V15.1H15C16.105 15.1 17 14.2945 17 13.3V12.85C17 11.8555 16.105 11.05 15 11.05H14.5V8.8H15C15.55 8.8 16 9.205 16 9.7C16 9.9475 16.225 10.15 16.5 10.15C16.775 10.15 17 9.9475 17 9.7C17 8.7055 16.105 7.9 15 7.9H14.5V7.45C14.5 7.2025 14.275 7 14 7C13.725 7 13.5 7.2025 13.5 7.45V7.9H13C11.895 7.9 11 8.7055 11 9.7V10.15C11 11.1445 11.895 11.95 13 11.95H13.5V14.2H13ZM14.5 11.95H15C15.55 11.95 16 12.355 16 12.85V13.3C16 13.795 15.55 14.2 15 14.2H14.5V11.95ZM13 11.05C12.45 11.05 12 10.645 12 10.15V9.7C12 9.205 12.45 8.8 13 8.8H13.5V11.05H13Z"
                    fill="#6C6C6C"></path>
            </svg>
            <span class="lh-1 ps-2">{{ localize('Wallets') }}</span>
        </a>
        <ul class="nav-second-level mm-collapse">
            @if ($_auth_user->can(PermissionMenuEnum::FINANCE_DEPOSIT_LIST->value . '.' . PermissionActionEnum::READ->value))
                <li>
                    <a href="{{ route('deposit.index') }}">{{ localize('Deposit_List') }}</a>
                </li>
            @endif
            @if ($_auth_user->can(PermissionMenuEnum::FINANCE_PENDING_DEPOSIT->value . '.' . PermissionActionEnum::READ->value))
                <li>
                    <a href="{{ route('pending-deposit.index') }}">{{ localize('Pending_Deposit') }}</a>
                </li>
            @endif
            @if ($_auth_user->can(PermissionMenuEnum::FINANCE_WITHDRAW_LIST->value . '.' . PermissionActionEnum::READ->value))
                <li>
                    <a href="{{ route('withdraw.index') }}">{{ localize('Withdraw_List') }}</a>
                </li>
            @endif
            @if ($_auth_user->can(PermissionMenuEnum::FINANCE_PENDING_WITHDRAW->value . '.' . PermissionActionEnum::READ->value))
                <li>
                    <a href="{{ route('pending-withdraw.index') }}">{{ localize('Pending_Withdraw') }}</a>
                </li>
            @endif
            @if ($_auth_user->can(PermissionMenuEnum::FINANCE_CREDIT_LIST->value . '.' . PermissionActionEnum::READ->value))
                <li>
                    <a href="{{ route('credit') }}">{{ localize('Credit_List') }}</a>
                </li>
            @endif
            @if ($_auth_user->can(PermissionMenuEnum::FINANCE_TRANSFER->value . '.' . PermissionActionEnum::READ->value))
                <li>
                    <a href="{{ route('transfer.index') }}">{{ localize('Transfer') }}</a>
                </li>
            @endif
        </ul>
    </li>
    <!-- Package -->
@endif
