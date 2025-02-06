@extends('b2xloan::customer.layouts.master')

@section('card_header_content')
    <h3 class="m-0 fs-20 fw-semi-bold">{{ localize('B2x_loan_calculator') }}</h3>
@endsection
@section('contentData')
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <h2 class="fw-bold text-black-50 text-center">{{ localize('B2X calculator') }}</h2>
            <p class="fw-normal fs-16 text-black-50 text-center">
                {{ localize('Nishue will match the amount of bitcoin deposited, giving you 2X your current holdings.') }}
            </p>
            <form action="{{ route('customer.b2x_loan.store') }}" method="post" class="needs-validation"
                data="showCallBackData" id="b2x-loan-package-form" novalidate="" enctype="multipart/form-data">
                @csrf
                <div class="row justify-content-center mb-4">
                    <div class="col-lg-6 col-xl-4">
                        <div class="mb-3">
                            <label
                                class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('holding_amount') }}</label>
                            <div class="position-relative">
                                <input name="holding_amount" id="holding_amount" class="custom-form-control"
                                    placeholder="{{ localize('holding_amount') }}" type="text"
                                    value="@if ($btcBalance && $btcBalance->balance <= 5) {{ $btcBalance->balance }}@else 1 @endif" />
                                <span class="invest bg-transparent text-black px-3">BTC</span>
                                <div class="invalid-feedback d-block" id="holding_amount_error" role="alert"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-4">
                        <div class="mb-3">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium">
                                {{ localize('Select Loan Month') }}
                            </label>
                            <select data-url="{{ route('customer.loan_calculator') }}"
                                class="custom-form-control placeholder-single" name="package_month" id="package_month">
                                <option value="">{{ localize('select_option') }}</option>
                                @foreach ($packages as $key => $package)
                                    <option @if ($key === 0) selected @endif
                                        value="{{ $package->no_of_month }}">{{ $package->no_of_month }} Months
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback d-block" id="package_month_error" role="alert"></div>
                        </div>
                    </div>

                    <div class="col-xl-3">
                        <label class="col-form-label text-start text-color-1 fs-16 fw-medium">
                            {{ localize('Final Wallet Balance') }}
                        </label>
                        <div class="mb-3 position-relative mb-3">
                            <input name="btcBalance" id="btcBalance"
                                class="custom-form-control bg-dark fw-bold fs-18 text-white" value="0.00" type="text"
                                readonly />
                            <span class="bg-btc input-group-text invest text-black" id="basic-addon2">BTC</span>
                        </div>
                    </div>
                </div>
                <div class="row g-3 justify-content-center mb-4" id="calcualations">
                    <h3 class="fw-bold text-black-50 mb-4 text-center">{{ localize('Loan Details') }}</h3>
                    <div class="col-lg-6 col-xl-3 col-xxl-05">
                        <div class="d-flex flex-column h-100 justify-content-center loan-border p-4 radius-10 text-center">
                            <p class="fw-normal fs-18 mb-4 text-black-50">{{ localize('Loan Amount') }}</p>
                            <h3 class="fw-bold fs-22 mb-0 text-black-50">$0.00</h3>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-3 col-xxl-05">
                        <div class="d-flex flex-column h-100 justify-content-center loan-border p-4 radius-10 text-center">
                            <p class="fw-normal fs-18 mb-4 text-black-50">{{ localize('Repay Amount (Per Month)') }}
                            </p>
                            <h3 class="fw-bold fs-22 mb-0 text-black-50">$0.00</h3>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-3 col-xxl-05">
                        <div class="d-flex flex-column h-100 justify-content-center loan-border p-4 radius-10 text-center">
                            <p class="fw-normal fs-18 mb-4 text-black-50">{{ localize('Loan Interest Rate') }}</p>
                            <h3 class="fw-bold fs-22 mb-0 text-black-50">0.00%</h3>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-3 col-xxl-05">
                        <div class="d-flex flex-column h-100 justify-content-center loan-border p-4 radius-10 text-center">
                            <p class="fw-normal fs-18 mb-4 text-black-50">{{ localize('Loan Total') }}</p>
                            <h3 class="fw-bold fs-22 mb-0 text-black-50">$0.00</h3>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    @if ($user->verified_status->value === '0')
                        <a href="{{ route('customer.account.kyc-verification.index') }}" type="text"
                            class="btn-stake mt-4 d-flex w-max-content px-4 m-auto"
                            tabindex="0">{{ localize('please_verify_your_account') }}</a>
                    @elseif($user->verified_status->value === '3')
                        <a href="#" type="text" class="btn-stake mt-4 d-flex w-max-content px-4 m-auto"
                            tabindex="0">{{ localize('please_wait_for_verification_confirmation') }}</a>
                    @else
                        <button type="submit" class="btn-stake mt-4 d-flex w-max-content border-0 px-4 m-auto actionBtn"
                            tabindex="0">{{ localize('get_a_loan') }}</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
