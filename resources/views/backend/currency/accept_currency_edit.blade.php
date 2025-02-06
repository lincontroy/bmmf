@if ($acceptCurrencyInfo)
    <form action="{{ route('admin.accept.currency.update', ['accept' => $acceptCurrencyInfo->id]) }}"
        data-insert="{{ route('admin.accept.currency.update', ['accept' => $acceptCurrencyInfo->id]) }}" method="post"
        class="needs-validation" data="showCallBackData" id="accept_currency_edit_form" novalidate=""
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-3 gx-xxl-5">
            <div class="col-12">
                <div class="mb-2">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium">
                        {{ localize('Currency Name') }}<span class="text-danger">*</span>
                    </label>
                    <input class="custom-form-control bg-transparent @error('currency_name') is-invalid @enderror"
                        type="text" name="currency_name" id="currency_name" value="{{ $acceptCurrencyInfo->name }}"
                        required />
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
                        {{ localize('Currency Symbol') }}<span class="text-danger">*</span>
                    </label>
                    <input class="custom-form-control bg-transparent @error('currency_symbol') is-invalid @enderror"
                        type="text" name="currency_symbol" id="currency_symbol"
                        value="{{ $acceptCurrencyInfo->symbol }}" required />
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
                        name="accept_payment_gateway[]" id="accept_payment_gateway" multiple="multiple" required>
                        <option value="">{{ localize('Select Option') }}</option>
                        @foreach ($acceptPaymentGateway as $index => $item)
                            <option value="{{ $item->id }}" @selected(in_array($item->id, $paymentGatewayIdArray))>{{ $item->name }}
                            </option>
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
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Status') }}<i
                            class="text-danger">*</i></label>
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="edit_active_status"
                                value="1" {{ $acceptCurrencyInfo->status == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="edit_active_status">{{ localize('Active') }} </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="edit_inactive_status"
                                value="0" {{ $acceptCurrencyInfo->status == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="edit_inactive_status">{{ localize('Inactive') }} </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-save w-100 actionBtn">{{ localize('SUBMIT') }}</button>
            </div>
        </div>
    </form>
@else
    <div class="text-danger text-center">
        {{ localize('Sorry, the data you are trying to edit could not be found. Please ensure the correct item is selected.') }}
    </div>
@endif
