@php
    use App\Enums\PermissionMenuEnum;
    use App\Enums\PermissionActionEnum;
@endphp
@if (
    $_auth_user->can(PermissionMenuEnum::QUICK_EXCHANGE_SUPPORTED_COIN->value . '.' . PermissionActionEnum::READ->value) ||
        $_auth_user->can(PermissionMenuEnum::QUICK_EXCHANGE_SUPPORTED_COIN->value . '.' . PermissionActionEnum::CREATE->value) ||
        $_auth_user->can(PermissionMenuEnum::QUICK_EXCHANGE_ORDER_REQUEST->value . '.' . PermissionActionEnum::READ->value) ||
        $_auth_user->can(PermissionMenuEnum::QUICK_EXCHANGE_TRANSACTION_LIST->value . '.' . PermissionActionEnum::READ->value))
    <!-- Quick Exchange -->
    <li>
        <a class="has-arrow material-ripple" href="#">
            <svg class="menu-icon" width="17" height="16" viewBox="0 0 17 16" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M16.5092 6.40989C16.5869 6.22219 16.6072 6.01564 16.5676 5.81639C16.5279 5.61714 16.43 5.43413 16.2863 5.29051L11.1516 0.155762L9.69945 1.60787L13.0812 4.98962H0.156003V7.04352H15.5603C15.7634 7.04357 15.9619 6.9834 16.1308 6.87061C16.2997 6.75783 16.4314 6.5975 16.5092 6.40989V6.40989ZM0.234051 9.73105C0.156306 9.91875 0.135982 10.1253 0.17565 10.3245C0.215318 10.5238 0.313196 10.7068 0.456899 10.8504L5.59165 15.9852L7.04376 14.5331L3.66201 11.1513H16.5872V9.09742H1.18295C0.979827 9.09723 0.781217 9.15735 0.61229 9.27015C0.443363 9.38295 0.311723 9.54336 0.234051 9.73105V9.73105Z"
                    fill="#6C6C6C" />
            </svg>
            <span class="lh-1 ps-2">{{ localize('Quick Exchange') }}</span>
        </a>
        <ul class="nav-second-level mm-collapse">
            @if ($_auth_user->can(PermissionMenuEnum::QUICK_EXCHANGE_SUPPORTED_COIN->value . '.' . PermissionActionEnum::READ->value))
                <li>
                    <a href="{{ route('quickexchange.index') }}">{{ localize('Supported Coins') }}</a>
                </li>
            @endif
            @if ($_auth_user->can(PermissionMenuEnum::QUICK_EXCHANGE_SUPPORTED_COIN->value . '.' . PermissionActionEnum::CREATE->value))
                <li>
                    <a href="{{ route('quickexchange.create') }}">{{ localize('Base Currency') }}</a>
                </li>
            @endif
            @if ($_auth_user->can(PermissionMenuEnum::QUICK_EXCHANGE_ORDER_REQUEST->value . '.' . PermissionActionEnum::READ->value))
                <li>
                    <a href="{{ route('quickexchange.request') }}">{{ localize('Order Requests') }}</a>
                </li>
            @endif
            @if ($_auth_user->can(PermissionMenuEnum::QUICK_EXCHANGE_TRANSACTION_LIST->value . '.' . PermissionActionEnum::READ->value))
                <li>
                    <a href="{{ route('quickexchange.transaction') }}">{{ localize('Transaction List') }}</a>
                </li>
            @endif
        </ul>
    </li>
    <!-- Quick Exchange -->
@endif
