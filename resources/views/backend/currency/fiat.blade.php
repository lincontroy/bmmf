@php
    use App\Enums\CommonStatusEnum;
    use App\Enums\PermissionMenuEnum;
    use App\Enums\PermissionActionEnum;
@endphp

<x-app-layout>
    <div class="body-content">
        <div class="row gy-4">
            <div class="col-12">
                <div class="card py-4 px-3 radius-15">
                    <div class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center mb-3">
                        <h3 class="fs-24 mb-0 text-color-2 fw-medium lh-1">{{ localize('Fiat Currency') }}</h3>
                        @if ($_auth_user->can(PermissionMenuEnum::PAYMENT_SETTING_FIAT_CURRENCY->value . '.' . PermissionActionEnum::CREATE->value))
                            <div class="border radius-10 p-1">
                                <button id="add-fiat-currency-button" data-bs-toggle="modal"
                                    data-bs-target="#fiatCurrencyAddModal" class="btn btn-save lh-sm">
                                    <span class="me-1">{{ localize('Add New') }}</span><svg width="12"
                                        height="12" viewBox="0 0 12 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 6H11M6 1V11" stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </div>
                        @endif
                    </div>
                    <!-- Data table -->
                    <x-data-table :dataTable="$dataTable" />
                    <!-- Data table -->
                </div>
            </div>
        </div>
        <div class="modal fade" id="fiatCurrencyAddModal" tabindex="-1" aria-labelledby="acceptCurrencyModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content radius-35">
                    <div class="modal-header p-4">
                        <h5 class="modal-title text-color-5 fs-20 fw-medium" id="modelLabel">
                            {{ localize('Add Fiat Currency') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 pt-2">
                        <form action="{{ route('admin.currency.fiat.store') }}"
                            data-insert="{{ route('admin.currency.fiat.store') }}" method="post"
                            class="needs-validation" data="showCallBackData" id="fiat-currency-form" novalidate=""
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                            for="name">
                                            {{ localize('Name') }}<span class="text-danger">*</span></label>
                                        <input
                                            class="custom-form-control form-control bg-transparent @error('name') is-invalid @enderror"
                                            type="text" name="name" id="name"
                                            placeholder="{{ localize('enter name') }}" required />
                                        <div class="invalid-feedback" role="alert">
                                            @error('name')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                            for="symbol">
                                            {{ localize('Symbol') }} <span class="text-danger">*</span></label>
                                        <input
                                            class="custom-form-control form-control bg-transparent @error('symbol') is-invalid @enderror"
                                            type="text" name="symbol" id="symbol"
                                            placeholder="{{ localize('enter symbol') }}" required />
                                        <div class="invalid-feedback" role="alert">
                                            @error('symbol')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                            for="rate">
                                            {{ localize('Rate') }}</label>
                                        <input
                                            class="custom-form-control form-control bg-transparent @error('rate') is-invalid @enderror"
                                            type="number" name="rate" id="rate" step="any"
                                            placeholder="{{ localize('enter rate') }}" />
                                        <div class="invalid-feedback" role="alert">
                                            @error('rate')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mt-3">
                                        <label class="col-form-label text-start text-color-1 fs-16 fw-medium">
                                            {{ localize('Status') }} <i class="text-danger">*</i></label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status"
                                                    id="active_status" value="{{ CommonStatusEnum::ACTIVE->value }}"
                                                    checked>
                                                <label class="form-check-label" for="active_status">
                                                    {{ enum_ucfirst_case(CommonStatusEnum::ACTIVE->name) }}
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status"
                                                    id="inactive_status"
                                                    value="{{ CommonStatusEnum::INACTIVE->value }}">
                                                <label class="form-check-label" for="inactive_status">
                                                    {{ enum_ucfirst_case(CommonStatusEnum::INACTIVE->name) }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-row gap-3">
                                <button type="reset" class="btn btn-reset py-2 resetBtn w-25"
                                    title="{{ localize('Reset') }}">
                                    <i class="fa fa-undo-alt"></i>
                                </button>
                                <button type="submit" class="actionBtn btn btn-save py-2 w-75"
                                    id="actionBtn">{{ localize('Create') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @push('js')
            <script src="{{ assets('js/currency/fiat.min.js') }}"></script>
        @endpush
    </div>
</x-app-layout>
