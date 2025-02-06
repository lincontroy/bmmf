@if ($quickExchangeCoin)
    <form action="{{ route('quickexchange.update', ['quickexchange' => $quickExchangeCoin->id]) }}"
        data-insert="{{ route('quickexchange.update', ['quickexchange' => $quickExchangeCoin->id]) }}" method="post"
        class="needs-validation" data="showCallBackData" id="quick_exchange_coin_edit_form" novalidate=""
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row mb-3 g-4">
            <div class="col-12 col-lg-6">
                <div class="mb-2">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Coin Name') }}<i
                            class="text-danger">*</i></label>
                    <input class="custom-form-control bg-transparent @error('coin_name') is-invalid @enderror"
                        type="text" name="coin_name" id="coin_name" required
                        value="{{ $quickExchangeCoin->coin_name }}" />
                </div>
                <div class="mb-2">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium">
                        {{ localize('Reserve Balance') }}<i class="text-danger">*</i></label>
                    <input class="custom-form-control bg-transparent @error('reserve_balance') is-invalid @enderror"
                        type="text" name="reserve_balance" id="reserve_balance" required
                        value="{{ $quickExchangeCoin->reserve_balance }}" />
                </div>
                <div class="mb-2">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Wallet ID') }} <i class="text-danger">*</i></label>
                    <input class="custom-form-control bg-transparent @error('wallet_id') is-invalid @enderror"
                        type="text" name="wallet_id" id="wallet_id" required
                        value="{{ $quickExchangeCoin->wallet_id }}" />
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="mb-2">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Symbol') }}<i
                            class="text-danger">*</i></label>
                    <input class="custom-form-control bg-transparent @error('symbol') is-invalid @enderror"
                        type="text" name="symbol" id="symbol" required
                        value="{{ $quickExchangeCoin->symbol }}" />
                    <div class="invalid-feedback" role="alert">
                        @error('symbol')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="mb-2">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium">
                        {{ localize('Min Transaction Amount') }}<i class="text-danger">*</i></label>
                    <input class="custom-form-control bg-transparent @error('min_transaction') is-invalid @enderror"
                        type="text" name="min_transaction" id="min_transaction"
                        value="{{ $quickExchangeCoin->minimum_tx_amount }}" required />
                    <div class="invalid-feedback" role="alert">
                        @error('min_transaction')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="mt-4">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Status') }}<i
                            class="text-danger">*</i></label>
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="edit_active_status"
                                value="1" {{ $quickExchangeCoin->status == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="edit_active_status"> {{ localize('Active') }} </label>
                            <div class="invalid-feedback" role="alert">
                                @error('status')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="edit_inactive_status"
                                value="0" {{ $quickExchangeCoin->status == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="edit_inactive_status"> {{ localize('Inactive') }} </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3 row justify-content-end">
                <button class="btn btn-reset w-auto" type="reset" id="quickExchangeFromReset">{{ localize('Reset') }}</button>
                <button class="btn btn-save ms-3 w-auto actionBtn" type="submit">{{ localize('Update') }}</button>
            </div>
        </div>
    </form>
@else
    <div class="text-danger text-center">
        {{ localize('Sorry, the data you are trying to edit could not be found. Please ensure the correct item is selected.') }}
    </div>
@endif
