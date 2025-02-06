<x-payment-layout :paymentUrl="$merchantPaymentUrl->uu_id" :amount="$merchantPaymentUrl->amount">

    <div class="row">
        <div class="col-lg-6" id="payment-div">

            <div class="card py-4 pb-0 shadow-none radius-15 mb-3">
                <div
                    class="card-header align-items-center d-flex flex-column flex-lg-row gap-3 justify-content-between pt-0 px-4 px-xl-5">
                    <h5 class="m-0 fs-20 fw-semi-bold">{{ localize('Scan to Pay') }}</h5>
                </div>
                <div class="card-body">
                    <p class="fs-15 fw-normal mb-3">
                        {{ localize('Please, Keep this page open through out your payment session.') }}</p>
                    <div class="text-center">
                        <img class="border-dotted radius-10 p-2 mb-3" src="{{ $depositData->qrcode_url }}"
                            alt="" />
                        <div class="d-flex justify-content-center gap-2">
                            <div class="border-dotted radius-10 p-2 mb-3">{{ $depositData->address }}</div>

                            <input class="custom-form-control border-dotted-ash bg-transparent copy-data" type="hidden"
                                value="{{ $depositData->address }}" readonly />
                            <div class="border-dotted radius-10 p-2 mb-3 copy">
                                <svg width="18" height="24" viewBox="0 0 18 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M17.9991 8.91003C17.9991 7.25318 16.6423 5.91003 14.9684 5.91003H6.88681C5.21306 5.91003 3.8562 7.25318 3.8562 8.91003V20.91C3.8562 22.5669 5.21306 23.91 6.88681 23.91H14.9684C16.6423 23.91 17.9991 22.5669 17.9991 20.91V8.91003ZM15.9787 8.91003C15.9787 8.35775 15.5264 7.91003 14.9684 7.91003H6.88681C6.3289 7.91003 5.87661 8.35775 5.87661 8.91003V20.91C5.87661 21.4623 6.3289 21.91 6.88681 21.91H14.9684C15.5264 21.91 15.9787 21.4623 15.9787 20.91V8.91003Z"
                                        fill="black" />
                                    <path
                                        d="M3.03061 2.76733H13.1327C13.6906 2.76733 14.1429 2.31961 14.1429 1.76733C14.1429 1.21505 13.6906 0.767334 13.1327 0.767334H3.03061C1.35686 0.767334 0 2.11048 0 3.76733V17.7673C0 18.3196 0.452289 18.7673 1.0102 18.7673C1.56812 18.7673 2.02041 18.3196 2.02041 17.7673V3.76733C2.02041 3.21505 2.4727 2.76733 3.03061 2.76733Z"
                                        fill="black" />
                                </svg>
                            </div>
                        </div>
                        <div class="bg-dark px-4 py-2 radius-10 w-max-content m-auto">
                            <p class="mb-0 fw-semi-bold fs-22 text-white" id="timeout"
                                data-datevalue="{{ $expired_time }}">
                                {{ gmdate('H:i:s', $depositData->timeout) }}</p>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-9 text-center mt-2">
                                <a href="{{ route('payment.index', ['payment_url' => $merchantPaymentUrl->uu_id]) }}" class="btn btn-outline-stake">{{ localize('Back') }}</a>
                                <a href="{{ $paymentRequest->txn_data->status_url }}" class="btn btn-outline-stake"
                                    target="_blank">{{ localize('Txn Status') }}</a>
                                <a href="{{ route('payment.index', ['payment_url' => $merchantPaymentUrl->uu_id]) }}" class="btn btn-outline-stake"
                                    target="_blank">{{ localize('Txn Checkout') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card p-4 radius-15 mb-3">
                <ul class="list-unstyled mb-0 pay-scan">
                    <li>
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fw-medium fs-16">{{ localize('Received') }}</p>
                            <p class="mb-0 fw-medium fs-16">0 {{ $depositData->currency }}</p>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fw-medium fs-16">{{ localize('Amount') }}</p>
                            <p class="mb-0 fw-medium fs-16">{{ $depositData->amount }} {{ $depositData->currency }}
                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fw-medium fs-16">{{ localize('Pending') }}</p>
                            <p class="mb-0 fw-medium fs-16">0 {{ $depositData->currency }}</p>
                        </div>
                    </li>
                    <li>
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 fw-medium fs-16">Progress</p>
                            <div class="progress">
                                <div class="progress-bar w-75" role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <p class="mb-0 fw-medium text-center fs-16">{{ localize('Undetected Transfer') }}?</p>

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
        <script src="{{ module_asset('Merchant', 'js/deposit-process.min.js') }}"></script>
    @endpush

</x-payment-layout>
