<div class="card py-4 pb-0 shadow-none radius-15">
    <div
        class="card-header align-items-center d-flex flex-column flex-lg-row gap-3 justify-content-between pt-0 px-4 px-xl-5">
        <h5 class="m-0 fs-20 fw-semi-bold">{{ localize('Select Crypto Currency') }}</h5>
    </div>
    <div class="card-body">
        <p class="fs-15 fw-normal mb-3">
            {{ localize('We will use the market price to determine the amount required for this transaction.') }}
        </p>
        <form
            action="{{ route('payment.pay-crypto-currency', ['payment_url' => $merchantPaymentUrl->uu_id, 'customer_info' => $merchantCustomerInfo->uuid]) }}"
            method="post" class="" id="pay-crypto-currency" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label
                    class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Coin Name') }}</label>
                <select name="accept_currency_id" id="accept_currency_id" class="form-select"
                    aria-label="Default select example">
                    @foreach ($merchantPaymentUrl->merchantAcceptedCoins as $merchantAcceptedCoin)
                        <option value="{{ $merchantAcceptedCoin->acceptCurrency->id }}">
                            {{ $merchantAcceptedCoin->acceptCurrency->symbol }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-save w-100">{{ localize('Pay Now') }}</button>
        </form>
    </div>
</div>
