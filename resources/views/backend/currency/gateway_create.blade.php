@php
    use App\Enums\PermissionMenuEnum;
    use App\Enums\PermissionActionEnum;
@endphp
<x-app-layout>
    <div class="body-content">
        <div class="row gy-4">
            <div class="col-12">
                <div class="card py-4 shadow-none radius-15">
                    <div
                        class="card-header align-items-center d-flex flex-column flex-lg-row gap-3 justify-content-between pt-0 px-4 px-xl-5">
                        <h3 class="fs-24 fw-medium mb-0 text-color-2">{{ localize('Add Payment Gateway') }}</h3>
                        @if ($_auth_user->can(PermissionMenuEnum::PAYMENT_SETTING_PAYMENT_GATEWAY->value . '.' . PermissionActionEnum::READ->value))
                            <div class="btn-group" role="group">
                                <a class="btn btn-primary"
                                    href="{{ route('admin.payment.gateway.index') }}">{{ localize('Gateway List') }}</a>
                            </div>
                        @endif

                    </div>
                    <div class="card-body px-4 px-xl-5">
                        <form action="{{ route('admin.payment.gateway.store') }}"
                            data-insert="{{ route('admin.payment.gateway.store') }}" method="post"
                            class="needs-validation" id="gateway_add_form" data="callBackFunc" novalidate=""
                            enctype="multipart/form-data" class="px-lg-5 mx-xxl-5">
                            @csrf
                            <div class="row g-3 gx-xxl-5">
                                <div class="col-12 col-lg-6">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="gateway_name">{{ localize('Name') }}<i class="text-danger">*</i></label>
                                    <input class="custom-form-control" name="gateway_name" id="gateway_name"
                                        type="text" required>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="custom-file-button position-relative mb-3">
                                        <label
                                            class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Logo') }}<i
                                                class="text-danger">*</i></label>
                                        <input type="file" class="custom-form-control" name="gateway_logo"
                                            id="gateway_logo" >
                                        <div class="invalid-feedback" role="alert">
                                            @error('gateway_logo')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium">
                                        {{ localize('Minimum Transaction Amount(USD)') }}<i
                                            class="text-danger">*</i></label>
                                    <input class="custom-form-control" type="text" name="min_transaction_amount"
                                        id="min_transaction_amount" required>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <div class="custom-file-button position-relative mb-3">
                                        <label class="col-form-label text-start text-color-1 fs-16 fw-medium">
                                            {{ localize('Maximum Transaction Amount(USD)') }}<i
                                                class="text-danger">*</i></label>
                                        <input class="custom-form-control" type="text" name="max_transaction_amount"
                                            id="max_transaction_amount" required>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium">
                                        {{ localize('Credential Name') }}<i class="text-danger">*</i></label>
                                    <input class="custom-form-control @error('credential_name.0') is-invalid @enderror"
                                        type="text" name="credential_name[]" required />
                                </div>
                                <div
                                    class="col-12 col-lg-6 d-lg-flex flex-lg-column justify-content-lg-end account-label-field">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium">
                                        {{ localize('Credential Value') }}<i class="text-danger">*</i></label>
                                    <div class="d-flex gap-2">
                                        <input
                                            class="custom-form-control @error('credential_value.0') is-invalid @enderror"
                                            type="text" name="credential_value[]" required />
                                        <button type="button" class="btn btn-dark add-account-label">
                                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1 11H21M11 1V21" stroke="white" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6 d-lg-flex flex-lg-column justify-content-lg-center">
                                    <label
                                        class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Status') }}<i
                                            class="text-danger">*</i></label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status"
                                                id="add_active_status" value="1" checked>
                                            <label class="form-check-label"
                                                for="add_active_status">{{ localize('Active') }}</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status"
                                                id="add_inactive_status" value="0">
                                            <label class="form-check-label"
                                                for="add_inactive_status">{{ localize('Inactive') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-reset w-auto"
                                            type="reset">{{ localize('Cancel') }}</button>
                                        <button class="btn btn-save ms-3 w-auto actionBtn"
                                            type="submit">{{ localize('Create') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script src="{{ assets('js/currency/gateway.js') }}"></script>
    @endpush
</x-app-layout>
