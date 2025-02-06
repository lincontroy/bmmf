@php
    use App\Enums\PermissionMenuEnum;
    use App\Enums\PermissionActionEnum;
@endphp

@extends('quickexchange::layouts.master')

@section('card_header_content')
    <h3 class="fs-24 mb-0 text-color-2 fw-medium lh-1">{{ localize('Quick Exchange Coin') }}</h3>
    @if ($_auth_user->can(PermissionMenuEnum::QUICK_EXCHANGE_SUPPORTED_COIN->value . '.' . PermissionActionEnum::CREATE->value))
        <div class="border radius-10 p-1">
            <a href="#" data-bs-toggle="modal" data-bs-target="#addQuickExchangeCoin" class="btn btn-save lh-sm">
                <span class="me-1">{{ localize('Add Coin') }}</span><svg width="12" height="12" viewBox="0 0 12 12"
                    fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 6H11M6 1V11" stroke="white" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </a>
        </div>
    @endif
@endsection

@section('content')
    <div class="modal fade" id="addQuickExchangeCoin" tabindex="-1" aria-labelledby="addQuickExchangeCoinLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content radius-35">
                <div class="modal-header p-4">
                    <h5 class="modal-title text-color-5 fs-20 fw-medium" id="addCoinModalLabel">{{ localize('Add Coin') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('quickexchange.store') }}" data-insert="{{ route('quickexchange.store') }}"
                        method="post" class="needs-validation" data="showCallBackData" id="quick_exchange_coin_form"
                        novalidate="" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3 g-4">
                            <div class="col-12 col-lg-6">
                                <div class="mb-2">
                                    <label
                                        class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Coin Name') }}<i
                                            class="text-danger">*</i></label>
                                    <input
                                        class="custom-form-control bg-transparent @error('coin_name') is-invalid @enderror"
                                        type="text" name="coin_name" id="coin_name" required />
                                </div>
                                <div class="mb-2">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium">
                                        {{ localize('Reserve Balance') }}<i class="text-danger">*</i></label>
                                    <input
                                        class="custom-form-control bg-transparent @error('reserve_balance') is-invalid @enderror"
                                        type="text" name="reserve_balance" id="reserve_balance" required />
                                </div>
                                <div class="mb-2">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium">
                                        {{ localize('Wallet ID') }}<i class="text-danger">*</i></label>
                                    <input
                                        class="custom-form-control bg-transparent @error('wallet_id') is-invalid @enderror"
                                        type="text" name="wallet_id" id="wallet_id" required />
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="mb-2">
                                    <label
                                        class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Symbol') }}<i
                                            class="text-danger">*</i></label>
                                    <input class="custom-form-control bg-transparent @error('symbol') is-invalid @enderror"
                                        type="text" name="symbol" id="symbol" required />
                                </div>
                                <div class="mb-2">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium">
                                        {{ localize('Min Transaction Amount') }}<i class="text-danger">*</i></label>
                                    <input
                                        class="custom-form-control bg-transparent @error('min_transaction') is-invalid @enderror"
                                        type="text" name="min_transaction" id="min_transaction" required />
                                </div>
                                <div class="mt-4">
                                    <label
                                        class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Status') }}<i
                                            class="text-danger">*</i></label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="active_status"
                                                value="1" checked>
                                            <label class="form-check-label" for="active_status"> {{ localize('Active') }}
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status"
                                                id="inactive_status" value="0">
                                            <label class="form-check-label" for="inactive_status">
                                                {{ localize('Inactive') }} </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 row justify-content-end">
                                <button class="btn btn-reset w-auto" type="reset">{{ localize('Reset') }}</button>
                                <button class="btn btn-save ms-3 w-auto actionBtn"
                                    type="submit">{{ localize('Create') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <x-admin.edit-modal class="modal-dialog-centered modal-dialog-scrollable" />
@endsection

@section('dataTableConent')
    <!-- Data table -->
    <x-data-table :dataTable="$dataTable" />
    <!-- Data table -->
@endsection

@push('js')
    <script src="{{ module_asset('QuickExchange', 'js/app.js') }}"></script>
@endpush
