@extends('quickexchange::layouts.master')

@section('contentData')
    <h3 class="border-bottom fs-25 fw-medium mb-0 px-4 px-xl-5 py-4 text-color-2">{{ localize('Base Currency') }}</h3>
    <div class="card-body px-4 px-xl-5">
        <form
            action="@if ($baseCoin) {{ route('quickexchange.update', ['quickexchange' => optional($baseCoin)->id]) }} @else {{ route('quickexchange.store') }} @endif"
            data-insert="@if ($baseCoin) {{ route('quickexchange.update', ['quickexchange' => optional($baseCoin)->id]) }} @else {{ route('quickexchange.store') }} @endif"
            method="post" class="needs-validation" data="baseCurrencyCallBack" id="quick_exchange_base_coin_form" novalidate=""
            enctype="multipart/form-data" class="px-lg-5 mx-xxl-5" data-resetvalue="false">
            @csrf
            @if ($baseCoin)
                @method('PUT')
            @endif
            <input type="hidden" name="coinType" value="1" />
            <div class="row g-4 gx-xxl-5">
                <div class="col-12 col-lg-6">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium" for="coin_name">{{ localize('Coin Name') }}<i
                            class="text-danger">*</i></label>
                    <input class="custom-form-control bg-transparent @error('coin_name') is-invalid @enderror"
                        type="text" name="coin_name" id="coin_name" required
                        value="{{ optional($baseCoin)->coin_name }}" />
                </div>
                <div class="col-12 col-lg-6">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium" for="symbol">
                        {{ localize('Symbol') }}<i
                            class="text-danger">*</i></label>
                    <input class="custom-form-control bg-transparent @error('symbol') is-invalid @enderror" type="text"
                        name="symbol" id="symbol" required value="{{ optional($baseCoin)->symbol }}" />
                </div>
                <div class="col-12 col-lg-6">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium" for="reserve_balance">
                        {{ localize('Reserve Balance') }}<i class="text-danger">*</i></label>
                    <input class="custom-form-control bg-transparent @error('reserve_balance') is-invalid @enderror"
                        type="text" name="reserve_balance" id="reserve_balance"
                        value="{{ optional($baseCoin)->reserve_balance }}" required />
                </div>
                <div class="col-12 col-lg-6">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium" for="min_transaction">
                        {{ localize('Minimum Transaction Amount') }} <i class="text-danger">*</i></label>
                    <input class="custom-form-control bg-transparent @error('min_transaction') is-invalid @enderror"
                        type="text" name="min_transaction" id="min_transaction"
                        value="{{ optional($baseCoin)->minimum_tx_amount }}" required />
                </div>
                <div class="col-12 col-lg-6">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium" for="buy_adjust_price">
                        {{ localize('Buy Adjust Price') }} (USD)<i class="text-danger">*</i></label>
                    <input class="custom-form-control bg-transparent @error('buy_adjust_price') is-invalid @enderror"
                        type="text" name="buy_adjust_price" id="buy_adjust_price"
                        value="{{ optional($baseCoin)->buy_adjust_price }}" required />
                </div>
                <div class="col-12 col-lg-6">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium" for="sell_adjust_price">
                        {{ localize('Sell Adjust Price') }} (USD)<i class="text-danger">*</i></label>
                    <input class="custom-form-control bg-transparent @error('sell_adjust_price') is-invalid @enderror"
                        type="text" name="sell_adjust_price" id="sell_adjust_price"
                        value="{{ optional($baseCoin)->sell_adjust_price }}" required />
                </div>
                @php
                    $walletData = optional($baseCoin)->wallet_id;
                    $walletData = $walletData ? json_decode($walletData) : null;
                @endphp
                @if ($walletData)
                    @foreach ($walletData as $key => $account)
                        <div class="col-12 col-lg-6">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Account Label Name') }}<i
                                    class="text-danger">*</i></label>
                            <input
                                class="custom-form-control bg-transparent @error('account_label_name.' . $loop->iteration) is-invalid @enderror"
                                type="text" name="account_label_name[]" value="{{ $key }}" required />
                        </div>
                        <div class="col-12 col-lg-6 d-lg-flex flex-lg-column justify-content-lg-end account-label-field">
                            <div class="d-flex gap-2">
                                <input
                                    class="custom-form-control bg-transparent @error('account_label_value.' . $loop->iteration) is-invalid @enderror"
                                    type="text" name="account_label_value[]" value="{{ $account }}" required />
                                @if ($loop->iteration > 1)
                                    <button type="button" class="btn btn-danger remove-account-label"><i
                                            class="fa fa-trash" aria-hidden="true"></i></button>
                                @else
                                    <button type="button" class="btn btn-dark add-account-label">
                                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 11H21M11 1V21" stroke="white" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 col-lg-6">
                        <label class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Account Label Name') }}<i
                                class="text-danger">*</i></label>
                        <input
                            class="custom-form-control bg-transparent @error('account_label_name.0') is-invalid @enderror"
                            type="text" name="account_label_name[]" required />
                    </div>
                    <div class="col-12 col-lg-6 d-lg-flex flex-lg-column justify-content-lg-end account-label-field">
                        <div class="d-flex gap-2">
                            <input
                                class="custom-form-control bg-transparent @error('account_label_value.0') is-invalid @enderror"
                                type="text" name="account_label_value[]" required />
                            <button type="button" class="btn btn-dark add-account-label">
                                <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 11H21M11 1V21" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif

                <div class="col-12 col-lg-6">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium" for="market_rate">{{ localize('Market Rate') }} (USD)<i class="text-danger">*</i></label>
                    <input class="custom-form-control bg-transparent @error('market_rate') is-invalid @enderror"
                        type="text" name="market_rate" id="market_rate"
                        value="{{ optional($baseCoin)->market_rate }}" required />
                </div>
                <div class="col-12 col-lg-6 d-lg-flex flex-lg-column justify-content-lg-center">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Status') }}<i
                            class="text-danger">*</i></label>
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="edit_active_status"
                                value="1"
                                {{ $baseCoin ? (optional($baseCoin)->status == '1' ? 'checked' : '') : 'checked' }}>
                            <label class="form-check-label" for="edit_active_status"> {{ localize('Active') }} </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="edit_inactive_status"
                                value="0" {{ optional($baseCoin)->status == '0' ? 'checked' : '' }}>
                            <label class="form-check-label" for="edit_inactive_status"> {{ localize('Inactive') }} </label>
                        </div>
                    </div>
                </div>
                <div class="col-12 d-lg-flex flex-lg-column justify-content-lg-end">
                    <div class="d-flex flex-wrap gap-3 justify-content-end">
                        <button class="btn btn-reset w-sm-100 w-auto" type="reset">{{ localize('Reset') }}</button>
                        <button class="btn btn-save w-sm-100 w-auto actionBtn" type="submit">{{ localize('update') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('js')
    <script src="{{ module_asset('QuickExchange', 'js/app.js') }}"></script>
@endpush
