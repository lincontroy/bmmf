@php
    use App\Enums\PermissionMenuEnum;
    use App\Enums\PermissionActionEnum;
@endphp
<x-app-layout>
    <div class="body-content">
        <div class="row gy-4">
            <div class="col-12">
                <div class="card py-4 px-3 radius-15">
                    <div class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center mb-3">
                        <h3 class="fs-24 mb-0 text-color-2 fw-medium lh-1">{{ localize('Accept Currency List') }}</h3>
                        @if ($_auth_user->can(PermissionMenuEnum::PAYMENT_SETTING_ACCEPT_CURRENCY->value . '.' . PermissionActionEnum::CREATE->value))
                            <div class="border radius-10 p-1">
                                <a href="#" data-bs-toggle="modal" data-bs-target="#accept_currency_add_modal"
                                    class="btn btn-save lh-sm">
                                    <span class="me-1">{{ localize('Add New') }}</span><svg width="12"
                                        height="12" viewBox="0 0 12 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 6H11M6 1V11" stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Data table -->
                    <x-data-table :dataTable="$dataTable" />
                    <!-- Data table -->
                </div>
            </div>
        </div>
        <div class="modal fade" id="accept_currency_add_modal" tabindex="-1" aria-labelledby="acceptCurrencyModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content radius-35">
                    <div class="modal-header p-4">
                        <h5 class="modal-title text-color-5 fs-20 fw-medium" id="acceptCurrencyModalLabel">
                            {{ localize('Add Accept Currency') }} </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 pt-2">
                        <form action="{{ route('admin.accept.currency.store') }}"
                            data-insert="{{ route('admin.accept.currency.store') }}" method="post"
                            class="needs-validation" data="showCallBackData" id="accept_currency_form" novalidate=""
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="mb-2">
                                        <label class="col-form-label text-start text-color-1 fs-16 fw-medium">
                                            {{ localize('Currency Name') }} <span class="text-danger">*</span></label>
                                        <input
                                            class="custom-form-control bg-transparent @error('currency_name') is-invalid @enderror"
                                            type="text" name="currency_name" id="currency_name" required />
                                        <div class="invalid-feedback" role="alert">
                                            @error('currency_name')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                        <span class="text-warning mt-4"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> {{ localize('This currency must be listed on coinmarketcap') }}</span>                                        
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-2">
                                        <label class="col-form-label text-start text-color-1 fs-16 fw-medium">
                                            {{ localize('Currency Symbol') }}<span class="text-danger">*</span></label>
                                        <input
                                            class="custom-form-control bg-transparent @error('currency_symbol') is-invalid @enderror"
                                            type="text" name="currency_symbol" id="currency_symbol" required />
                                        <div class="invalid-feedback" role="alert">
                                            @error('currency_symbol')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-2">
                                        <label class="col-form-label text-start text-color-1 fs-16 fw-medium">
                                            {{ localize('Accept Payment Gateway') }}<span class="text-danger">*</span>
                                        </label>
                                        <select
                                            class="select-multiple floating-form-control placeholder-multiple @error('accept_payment_gateway') is-invalid @enderror"
                                            name="accept_payment_gateway[]" id="accept_payment_gateway"
                                            multiple="multiple" required>
                                            <option value="">Select Option</option>
                                            @foreach ($acceptPaymentGateway as $index => $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback" role="alert">
                                            @error('accept_payment_gateway')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mt-2">
                                        <label class="col-form-label text-start text-color-1 fs-16 fw-medium">
                                            {{ localize('Status') }} <i class="text-danger">*</i></label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status"
                                                    id="active_status" value="1" checked>
                                                <label class="form-check-label" for="active_status">
                                                    {{ localize('Active') }}</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status"
                                                    id="inactive_status" value="0">
                                                <label class="form-check-label" for="inactive_status">
                                                    {{ localize('Inactive') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit"
                                class="btn btn-save w-100 actionBtn">{{ localize('SUBMIT') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <x-admin.edit-modal class="modal-dialog-centered modal-dialog-scrollable" />

        @push('js')
            <script src="{{ assets('js/currency/accept_currency.js') }}"></script>
        @endpush
    </div>
</x-app-layout>
