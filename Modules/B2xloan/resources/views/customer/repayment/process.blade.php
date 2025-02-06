@extends('finance::customer.layouts.master')
@section('card_header_content')
    <h5 class="m-0 fs-20 fw-semi-bold">Repayment</h5>

@endsection

@section('contentData')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card p-3 mb-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="d-flex align-items-center gap-3">
                        <svg width="34" height="37" viewBox="0 0 34 37" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.375 18.5413L15.125 22.2451L18.875 18.5413L22.625 14.8375M32 18.5413C32 26.8029 21.7625 32.7894 18.2026 34.6215C17.8177 34.8196 17.6251 34.9187 17.3581 34.97C17.15 35.01 16.85 35.01 16.6419 34.97C16.3749 34.9187 16.1823 34.8196 15.7974 34.6215C12.2374 32.7894 2 26.8029 2 18.5413V11.5366C2 10.056 2 9.31568 2.24518 8.67931C2.46176 8.11712 2.81371 7.61551 3.27061 7.21781C3.78781 6.76763 4.48962 6.5077 5.89325 5.98781L15.9466 2.26422C16.3364 2.11985 16.5313 2.04766 16.7319 2.01903C16.9096 1.99366 17.0904 1.99366 17.2681 2.01903C17.4687 2.04766 17.6636 2.11985 18.0534 2.26422L28.1067 5.98781C29.5104 6.5077 30.2122 6.76763 30.7293 7.21781C31.1863 7.61551 31.5382 8.11712 31.7548 8.67931C32 9.31568 32 10.056 32 11.5366V18.5413Z"
                                stroke="#F7931A" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span class="text-warning fs-20 fw-semi-bold">{{ localize('Important') }}</span>
                    </div>
                </div>
                <ul class="warning-list">
                    <li class="text-warning">{{ localize('Please only send') }} <strong>{{ $depositData->currency }}</strong>
                        {{ localize('to this payment address. Sending any other coin or token to this address may result in the loss of your repayment') }} .
                    </li>
                    <li class="text-danger">{{ localize('Coins will be payment immediately after') }} <font color="#03a9f4">
                            {{ $depositData->confirms_needed }}</font> {{ localize('network confirmations') }} .</li>
                    @php
                        $timeInHour = $depositData->timeout / (60 * 60);
                        $hourText = $timeInHour > 1 ? 'hours' : 'hour';
                    @endphp
                    <li class="text-primary"> {{ localize('Payment must be sent immediately, within') }} {{ $timeInHour }}
                        {{ $hourText }}. {{ localize('Sending the payment after') }} {{ $timeInHour }} {{ $hourText }} {{ localize('may result in the loss of your repayment.') }}</li>
                </ul>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <div class="d-flex gap-3 mb-3">
                        <input class="custom-form-control border-dotted-ash bg-transparent copy-data" type="text"
                            value="{{ $depositData->address }}" readonly />
                        <button class="rounded-3 px-3 border-dotted-ash bg-transparent copy">
                            <div class="d-flex align-items-center gap-2">
                                <svg width="12" height="17" viewBox="0 0 12 17" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M12.0001 6.2853C12.0001 5.18058 11.0955 4.28503 9.97944 4.28503H4.59098C3.475 4.28503 2.57031 5.18058 2.57031 6.2853V14.2863C2.57031 15.3911 3.475 16.2866 4.59098 16.2866H9.97944C11.0955 16.2866 12.0001 15.3911 12.0001 14.2863V6.2853ZM10.653 6.2853C10.653 5.91706 10.3515 5.61854 9.97944 5.61854H4.59098C4.21899 5.61854 3.91743 5.91706 3.91743 6.2853V14.2863C3.91743 14.6546 4.21899 14.9531 4.59098 14.9531H9.97944C10.3515 14.9531 10.653 14.6546 10.653 14.2863V6.2853Z"
                                        fill="#525252" />
                                    <path
                                        d="M2.0197 2.18959H8.75527C9.12728 2.18959 9.42883 1.89107 9.42883 1.52283C9.42883 1.1546 9.12728 0.856079 8.75527 0.856079H2.0197C0.903712 0.856079 -0.000976562 1.75163 -0.000976562 2.85634V12.1909C-0.000976562 12.5591 0.300589 12.8576 0.672581 12.8576C1.04457 12.8576 1.34614 12.5591 1.34614 12.1909V2.85634C1.34614 2.48811 1.6477 2.18959 2.0197 2.18959Z"
                                        fill="#525252" />
                                </svg>
                                <span class="w-max-content">{{ localize('Copy Address') }}</span>
                            </div>
                        </button>
                    </div>
                    <div class="mb-3 text-center">
                        <img class="border-dotted-ash rounded-3 p-2 img-fluid" src="{{ $depositData->qrcode_url }}"
                            alt="" />
                    </div>
                    <p class="text-primary fw-semi-bold fs-25 text-center">{{ $depositData->amount }}
                        {{ $depositData->currency }}</p>
                </div>
                <div class="col-md-9 text-center">
                    <a href="{{ route('customer.b2x_loan_list') }}" class="btn btn-outline-stake">{{ localize('Back') }}</a>
                    <a href="{{ $depositData->status_url }}" class="btn btn-outline-stake" target="_blank">{{ localize('Txn Status') }}</a>
                    <a href="{{ $depositData->checkout_url }}" class="btn btn-outline-stake" target="_blank">{{ localize('Txn ') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
