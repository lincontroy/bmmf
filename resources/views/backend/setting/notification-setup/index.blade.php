@php
    use App\Enums\SiteAlignEnum;
    use App\Enums\NotificationSetupGroupEnum;
    use App\Enums\StatusEnum;
@endphp

<x-app-layout>
    <x-setting activeMenu="notification-setup" activeMenuTitle="{{ localize('Notification Setup') }}">
        <div class="card-body px-4 px-xl-5">
            <form
                action="{{ route('admin.setting.notification-setup.update', ['group' => NotificationSetupGroupEnum::EMAIL->value]) }}"
                method="post" class="needs-validation" data="showCallBackDataEmailForm" id="email-notification-setup-form"
                novalidate="" data-resetvalue="false" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="row">
                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <div>
                            <h3 class="mb-1 text-black fs-25 fw-medium">{{ localize('Email Notification Settings') }}
                            </h3>
                            <p class="text-heather mb-0 fs-15 fw-normal">
                                {{ localize('You will get only those email notification what you want.') }}</p>
                        </div>
                        <div>
                            <button type="reset" class="btn btn-reset w-auto resetBtn"
                                title="{{ localize('Reset') }}">
                                <i class="fa fa-undo-alt"></i>
                            </button>
                            <button class="btn btn-save ms-3 w-auto actionBtn"
                                type="submit">{{ localize('Update') }}</button>
                        </div>
                    </div>
                    <div class="row g-3">
                        @forelse ($emailNotificationSetups as $notificationSetups)
                            <div class="col-6 col-sm-4 col-md-3 col-xxl-3">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" name="notification_setup[]" type="checkbox"
                                        value="{{ $notificationSetups->id }}"
                                        id="notificationSetups_{{ $notificationSetups->id }}"
                                        @if ($notificationSetups->status->value === StatusEnum::ACTIVE->value) checked @endif />
                                    <label class="form-check-label fs-15 fw-normal"
                                        for="notificationSetups_{{ $notificationSetups->id }}">{{ $notificationSetups->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </form>

            <hr class="my-5" />

            <form
                action="{{ route('admin.setting.notification-setup.update', ['group' => NotificationSetupGroupEnum::SMS->value]) }}"
                method="post" class="needs-validation" data="showCallBackDataSMSForm" id="sms-notification-setup-form"
                novalidate="" data-resetvalue="false" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="row">
                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <div>
                            <h3 class="mb-1 text-black fs-25 fw-medium">{{ localize('SMS Settings') }}</h3>
                            <p class="text-heather mb-0 fs-15 fw-normal">
                                {{ localize('You will get only those sms notification what you want.') }}</p>
                        </div>
                        <div>
                            <button type="reset" class="btn btn-reset w-auto resetBtn"
                                title="{{ localize('Reset') }}">
                                <i class="fa fa-undo-alt"></i>
                            </button>
                            <button class="btn btn-save ms-3 w-auto actionBtn"
                                type="submit">{{ localize('Update') }}</button>
                        </div>
                    </div>
                    <div class="row g-3">
                        @forelse ($smsNotificationSetups as $notificationSetups)
                            <div class="col-6 col-sm-4 col-md-3 col-xxl-3">
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" name="notification_setup[]" type="checkbox"
                                        value="{{ $notificationSetups->id }}"
                                        id="notificationSetups_{{ $notificationSetups->id }}"
                                        @if ($notificationSetups->status->value === StatusEnum::ACTIVE->value) checked @endif />
                                    <label class="form-check-label fs-15 fw-normal"
                                        for="notificationSetups_{{ $notificationSetups->id }}">{{ $notificationSetups->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </form>

        </div>
    </x-setting>

    @push('js')
        <script src="{{ assets('js/setting/notification-setup.min.js') }}"></script>
    @endpush
</x-app-layout>
