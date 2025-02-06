@php
    use App\Enums\PermissionMenuEnum;
    use App\Enums\PermissionActionEnum;
@endphp

<div class="row gy-4">
    <div class="col-xl-3 col-xxl-2">
        <div class="card px-4 px-xl-0 py-3 shadow-none radius-15">
            <div class="d-xl-grid settings-menu">
                @if ($_auth_user->can(PermissionMenuEnum::SETTING_APP_SETTING->value . '.' . PermissionActionEnum::READ->value))
                    <a href="{{ route('admin.setting.index') }}"
                        class="settings-nav-link  @if (!empty($activeMenu) && $activeMenu == 'application-setting') is-active @endif">{{ localize('App Setting') }}</a>
                @endif
                @if ($_auth_user->can(PermissionMenuEnum::SETTING_FEE_SETTING->value . '.' . PermissionActionEnum::READ->value))
                    <a href="{{ route('admin.setting.fee-setting.index') }}"
                        class="settings-nav-link  @if (!empty($activeMenu) && $activeMenu == 'fee-setting') is-active @endif">{{ localize('Fee Setting') }}</a>
                @endif
                @if ($_auth_user->can(PermissionMenuEnum::SETTING_COMMISSION_SETUP->value . '.' . PermissionActionEnum::READ->value))
                    <a href="{{ route('admin.setting.commission') }}"
                        class="settings-nav-link  @if (!empty($activeMenu) && $activeMenu == 'commission-setup') is-active @endif">{{ localize('Commission Setup') }}</a>
                @endif
                @if ($_auth_user->can(PermissionMenuEnum::SETTING_EMAIL_GATEWAY->value . '.' . PermissionActionEnum::READ->value))
                    <a href="{{ route('admin.setting.email.index') }}"
                        class="settings-nav-link  @if (!empty($activeMenu) && $activeMenu == 'email-gateway') is-active @endif">{{ localize('Email Gateway') }}</a>
                @endif
                @if ($_auth_user->can(PermissionMenuEnum::SETTING_LANGUAGE_SETTING->value . '.' . PermissionActionEnum::READ->value))
                    <a href="{{ route('admin.setting.language.index') }}"
                        class="settings-nav-link  @if (!empty($activeMenu) && $activeMenu == 'language-setting') is-active @endif">{{ localize('Language Setting') }}</a>
                @endif
                @if ($_auth_user->can(PermissionMenuEnum::SETTING_COMMISSION_SETUP->value . '.' . PermissionActionEnum::READ->value))
                    <a href="{{ route('admin.setting.external_api_setup') }}"
                       class="settings-nav-link  @if (!empty($activeMenu) && $activeMenu == 'external-api-setup') is-active @endif">{{ localize('external_api_setup') }}</a>
                @endif
                @if ($_auth_user->can(PermissionMenuEnum::SETTING_BACKUP->value . '.' . PermissionActionEnum::READ->value))
                    <a href="{{ route('admin.setting.backup.index') }}"
                        class="settings-nav-link  @if (!empty($activeMenu) && $activeMenu == 'backup-setting') is-active @endif">{{ localize('Backup') }}</a>
                @endif
            </div>
        </div>
    </div>
    <div class="col-xl-9 col-xxl-10">
        <div class="card shadow-none radius-15">
            <div
                class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center px-4 px-xl-5 pt-4">
                @if (isset($activeMenuTitle))
                    <h3 class=" mb-0 text-black fs-25 fw-medium">{{ $activeMenuTitle }}</h3>
                @endif
                @if (isset($button))
                    <div class="d-flex align-items-end gap-2">
                        <div class="border radius-10 p-1">
                            {{ $button }}
                        </div>
                    </div>
                @endif
            </div>
            {{ $slot }}
        </div>
    </div>
</div>
