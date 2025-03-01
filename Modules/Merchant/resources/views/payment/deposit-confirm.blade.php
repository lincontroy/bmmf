<x-payment-layout :paymentUrl="$merchantPaymentUrl->uu_id" :amount="$merchantPaymentUrl->amount">

    <div class="row">
        <div class="col-lg-6" id="payment-div">
            <div class="card py-4 pb-0 shadow-none radius-15 mb-3">
                <div
                    class="card-header align-items-center d-flex flex-column flex-lg-row gap-3 justify-content-between pt-0 px-4 px-xl-5">
                    <h5 class="m-0 fs-20 fw-semi-bold">{{ localize('Payment Confirm') }}</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card py-4 pb-0 shadow-none radius-15">
                <div
                    class="card-header align-items-center d-flex flex-column flex-lg-row gap-3 justify-content-between pt-0 px-4 px-xl-5">
                    <h5 class="m-0 fs-20 fw-semi-bold">{{ localize('Payment Details') }}</h5>
                </div>
                <div class="card-body">
                    <h5 class="mb-3 fs-18 fw-semi-bold">{{ $merchantPaymentUrl->title }}</h5>
                    <div class="d-flex gap-3">
                        @foreach ($merchantPaymentUrl->merchantAcceptedCoins as $merchantAcceptedCoin)
                            <button class="btn btn-inverse-soft py-2 lh-lg w-auto"
                                type="submit">{{ $merchantAcceptedCoin->acceptCurrency->symbol }}</button>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex gap-3 justify-content-between">
                        <p class="mb-3 fs-17 fw-semi-bold">{{ localize('Amount') }}</p>
                        <p class="mb-3 fs-17 fw-semi-bold">${{ number_format($merchantPaymentUrl->amount, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
    @endpush

</x-payment-layout>
