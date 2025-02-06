@if ($quickExchangeRequest)
    @if ($quickExchangeRequest->status == 0)
        <form action="{{ route('quickexchange.tx.update', ['id' => $quickExchangeRequest->request_id]) }}"
            data-insert="{{ route('quickexchange.tx.update', ['id' => $quickExchangeRequest->request_id]) }}"
            method="post" class="needs-validation" data="callBackTableReload" id="quick_exchange_request_edit_form"
            novalidate="" enctype="multipart/form-data">
            @csrf
            @method('PUT')
    @endif
    <div class="row mb-3">
        <div class="col-12">
            <div class="mb-2">
                <label class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('User Payment Transaction Hash') }}</label>
                <div class="position-relative">
                    <input class="custom-form-control bg-transparent pe-110 copy-data" type="text"
                        value="{{ $quickExchangeRequest->user_send_hash }}" readonly />
                    <button type="button" class="btn invest copy">Copy</button>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-2">
                <label class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('User Receiver Wallet') }}</label>
                <div class="position-relative">
                    <input class="custom-form-control bg-transparent pe-110 copy-data" type="text"
                        value="{{ $quickExchangeRequest->user_payment_wallet }}" readonly />
                    <button type="button" class="btn invest copy">Copy</button>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-2">
                <label class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('User Sent Amount') }}</label>
                <div class="position-relative">
                    <input class="custom-form-control bg-transparent" type="text"
                        value="{{ $quickExchangeRequest->sell_amount }}" readonly />
                    <span class="invest bg-success px-3">{{ $quickExchangeRequest->sell_coin }}</span>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-2">
                <label class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('User Receivable Amount') }}</label>
                <div class="position-relative">
                    <input class="custom-form-control bg-transparent" type="text"
                        value="{{ $quickExchangeRequest->buy_amount }}" readonly />
                    <span class="invest bg-dark px-3">{{ $quickExchangeRequest->buy_coin }}</span>
                </div>
            </div>
        </div>
        @if ($quickExchangeRequest->status == 0)
            <div class="col-12">
                <label class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Status') }}<i
                        class="text-danger">*</i></label>
                <div class="d-flex gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="transactionStatus" id="tnxStatusPaid"
                            value="1" checked />
                        <label class="form-check-label" for="tnxStatusPaid">{{ localize('Paid') }}</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="transactionStatus" id="tnxStatusReject"
                            value="0" />
                        <label class="form-check-label" for="tnxStatusReject">{{ localize('Reject') }}</label>
                    </div>
                </div>
            </div>
            <div class="col-12 payment-tx-hash">
                <div class="mb-2">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Admin Payment Transaction Hash') }}<i class="text-danger">*</i></label>
                    <input class="custom-form-control bg-transparent" type="text" name="admin_payment_tnx_hash"
                        id="admin_payment_tnx_hash" required />
                </div>
            </div>
            <div class="col-12">
                <div class="d-flex justify-content-end mt-3">
                    <button class="btn btn-save ms-3 w-auto" type="submit">{{ localize('Submit') }}</button>
                </div>
            </div>
        @else
            <div class="col-12">
                <label class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Status') }}<i
                        class="text-danger">*</i></label>
                <div class="d-flex gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="transactionStatus" id="tnxStatusPaid"
                            value="1" @checked($quickExchangeRequest->status == 1) disabled />
                        <label class="form-check-label" for="tnxStatusPaid">Paid</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="transactionStatus" id="tnxStatusReject"
                            value="3" @checked($quickExchangeRequest->status == 3) disabled />
                        <label class="form-check-label" for="tnxStatusReject">{{ localize('Reject') }}</label>
                    </div>
                </div>
            </div>
            @if ($quickExchangeRequest->status == 1)
                <div class="col-12 payment-tx-hash">
                    <div class="mb-2">
                        <label class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Admin Payment Transaction Hash') }}<i class="text-danger">*</i></label>
                        <input class="custom-form-control bg-transparent" type="text" name="admin_payment_tnx_hash"
                            id="admin_payment_tnx_hash" readonly
                            value="{{ $quickExchangeRequest->admin_send_hash }}" />
                    </div>
                </div>
            @endif
        @endif
    </div>
    @if ($quickExchangeRequest->status == 0)
        </form>
    @endif
@else
    <div class="text-danger text-center">
        {{ localize('Sorry, the data you are trying to edit could not be found. Please ensure the correct item is selected.') }}
    </div>
@endif
