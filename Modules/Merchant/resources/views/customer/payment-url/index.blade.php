@php
    use Carbon\Carbon;
    use Modules\Merchant\App\Enums\MerchantPaymentUlrPaymentTypeEnum;
@endphp
<x-customer-app-layout>

    <div class="row gy-4 justify-content-center">
        <div class="col-12">
            <div class="card shadow-none radius-15">
                <div
                    class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center mb-3 px-4 px-xl-5 py-4  border-bottom">
                    <h3 class="fs-24 mb-0 text-color-2 fw-medium lh-1">
                        {{ localize('Payment Url') }}
                    </h3>
                    <div class="d-flex align-items-center gap-2">
                        <div class="border radius-10 p-1">
                            <button id="add-payment-url-button" data-bs-toggle="modal" data-bs-target="#addPaymentUrl"
                                class="btn btn-save lh-sm">
                                <span class="me-1">{{ localize('Add Payment Url') }}</span><svg width="12"
                                    height="12" viewBox="0 0 12 12" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 6H11M6 1V11" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body px-4 px-xl-5">

                    <!-- Data table -->
                    <x-data-table :dataTable="$dataTable" />
                    <!-- Data table -->

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addPaymentUrl" tabindex="-1" aria-labelledby="addPaymentUrlLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content radius-35">
                <div class="modal-header p-4">
                    <h5 class="modal-title text-color-5 fs-20 fw-medium" id="modelLabel">
                        {{ localize('Create Payment Url') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-2">
                    <form action="{{ route('customer.merchant.payment-url.index') }}" method="post"
                        class="needs-validation" data="showCallBackData" id="payment-url-form" novalidate=""
                        data-insert="{{ route('customer.merchant.payment-url.index') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">

                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="title">{{ localize('payment_name') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                                        class="custom-form-control bg-transparent form-control @error('title') is-invalid @enderror"
                                        placeholder="{{ localize('enter payment_name') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('title')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="amount">{{ localize('Amount') }} <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group position-relative mb-4">
                                        <input type="number" name="amount" id="amount"
                                            class="floating-form-control form-control radius-10"
                                            placeholder="{{ localize('Amount') }}" step="any" required />
                                        <select name="fiat_currency_id" id="fiat_currency_id"
                                            class="selectpicker convert-dropdwon border-0 rounded-3"
                                            data-style="btn-default">
                                            @foreach ($fiatCurrencies as $fiatCurrency)
                                                <option value="{{ $fiatCurrency->id }}">{{ $fiatCurrency->symbol }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="accept_currency_id">{{ localize('Accepted Coins') }}
                                    </label>
                                    <select name="accept_currency_id[]" id="accept_currency_id"
                                        data-allowClear="true" data-placeholder="{{ localize('Accepted Coins') }}"
                                        class="custom-form-control bg-transparent placeholder-single @error('accept_currency_id') is-invalid @enderror"
                                        data-fieldname="merchant_accepted_coins" data-fieldid="accept_currency_id"
                                        multiple>
                                        @foreach ($acceptCurrencies as $acceptCurrency)
                                            <option value="{{ $acceptCurrency->id }}"
                                                data-previewimage="{{ assets('img/' . $acceptCurrency->logo) }}">
                                                {{ $acceptCurrency->symbol }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" role="alert">
                                        @error('accept_currency_id')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="duration">{{ localize('Duration') }}
                                    </label>
                                    <input type="datetime-local" name="duration" id="duration"
                                        value="{{ old('duration') }}"
                                        class="custom-form-control bg-transparent form-control @error('duration') is-invalid @enderror"
                                        placeholder="{{ localize('enter duration') }}" />
                                    <div class="invalid-feedback" role="alert">
                                        @error('duration')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="description">{{ localize('Description') }} <span
                                            class="text-danger">*</span>
                                    </label>
                                    <textarea name="description" id="description"
                                        class="payment-url-form-control form-control @error('description') is-invalid @enderror"
                                        placeholder="{{ localize('enter description') }}" rows="3" required></textarea>
                                    <div class="invalid-feedback" role="alert">
                                        @error('description')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-row gap-3">
                                <button type="reset" class="btn btn-reset py-2 resetBtn w-25"
                                    title="{{ localize('Reset') }}">
                                    <i class="fa fa-undo-alt"></i>
                                </button>
                                <button type="submit" class="actionBtn btn btn-save py-2 w-75"
                                    id="paymentUrlFormActionBtn">{{ localize('Create') }}</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- view link modal  -->
    <div class="modal fade" id="linkModal" tabindex="-1" aria-labelledby="linkModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content radius-35" id="link-modal-content">

            </div>
        </div>
    </div>


    @push('js')
        <script src="{{ module_asset('Merchant', 'js/payment-url.min.js') }}"></script>
    @endpush
</x-customer-app-layout>
