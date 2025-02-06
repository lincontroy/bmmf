@php
    use App\Enums\PermissionMenuEnum;
    use App\Enums\PermissionActionEnum;
@endphp

@extends('stake::layouts.master')

@section('card_header_content')
    <h3 class="fs-24 mb-0 text-color-2 fw-medium lh-1">{{ localize('Manage Plan') }}</h3>
    @if ($_auth_user->can(PermissionMenuEnum::STAKE_PLAN->value . '.' . PermissionActionEnum::CREATE->value))
        <div class="border radius-10 p-1">
            <a href="#" data-bs-toggle="modal" data-bs-target="#stake_add_modal" class="btn btn-save lh-sm">
                <span class="me-1">{{ localize('Add New') }}</span><svg width="12" height="12" viewBox="0 0 12 12"
                    fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 6H11M6 1V11" stroke="white" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </a>
        </div>
    @endif
@endsection

@section('content')
    <div class="modal fade" id="stake_add_modal" tabindex="-1" aria-labelledby="stakeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content radius-35">
                <div class="modal-header p-4">
                    <h5 class="modal-title text-color-5 fs-20 fw-medium" id="stakeModalLabel">{{ localize('New Plan') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-2">
                    <form action="{{ route('stake.store') }}" data-insert="{{ route('stake.store') }}" method="post"
                        class="needs-validation" data="showCallBackData" id="stake_form" novalidate=""
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="mb-2">
                                    <label
                                        class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Accept Currency') }}<span
                                            class="text-danger">*</span></label>
                                    <select
                                        class="custom-form-control bg-transparent form-select @error('accept_currency') is-invalid @enderror"
                                        name="accept_currency" id="accept_currency">
                                        <option value="">Select Option</option>
                                        @foreach ($acceptCurrency as $index => $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" role="alert">
                                        @error('accept_currency')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-2">
                                    <label
                                        class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Plan Name') }}<span
                                            class="text-danger">*</span></label>
                                    <input
                                        class="custom-form-control bg-transparent @error('stake_title') is-invalid @enderror"
                                        type="text" name="stake_title" id="stake_title" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('stake_title')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="image">{{ localize('Image') }}</label>
                                <div class="border-all mb-3 p-2 radius-10 w-max-content" id="preview_file_image">
                                    <img width="80" height="50" class="preview_image"
                                        src="{{ storage_asset('upload/stake/stake-a.e82f9f17.png') }}"alt="" />
                                </div>
                                <div class="custom-file-button position-relative mb-3">
                                    <input type="file" name="image" id="image" accept="image/*"
                                        class="custom-form-control file-preview  @error('image') is-invalid @enderror"
                                        data-previewDiv="preview_file_image" />
                                </div>
                                <div class="invalid-feedback" role="alert">
                                    @error('image')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="align-items-center gap-2">
                            <span class="text-primary fw-semi-bold">{{ localize('Prices') }}</span>
                            <hr class="my-2 divider-color w-100" />
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 col-lg-6">
                                <div class="mb-2">
                                    <label
                                        class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Duration (days)') }}<span
                                            class="text-danger">*</span></label>
                                    <input
                                        class="custom-form-control bg-transparent @error('duration') is-invalid @enderror"
                                        type="text" name="duration[]" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('duration')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label
                                        class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Min Locked Amount') }}<span
                                            class="text-danger">*</span></label>
                                    <input
                                        class="custom-form-control bg-transparent @error('min_value') is-invalid @enderror"
                                        type="text" name="min_value[]" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('min_value')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="mb-2">
                                    <label
                                        class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Interest') }}(%)<span
                                            class="text-danger">*</span></label>
                                    <div class="position-relative">
                                        <input
                                            class="custom-form-control bg-transparent @error('interest_rate') is-invalid @enderror"
                                            type="text" name="interest_rate[]" required />
                                        <span class="invest">%</span>
                                        <div class="invalid-feedback" role="alert">
                                            @error('interest_rate')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label
                                        class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Max Locked Amount') }}<span
                                            class="text-danger">*</span></label>
                                    <input
                                        class="custom-form-control bg-transparent @error('max_value') is-invalid @enderror"
                                        type="text" name="max_value[]" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('max_value')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="rates-section"></div>
                            <div class="col-12">
                                <div class="text-center mt-3">
                                    <a href="#" id="addNewRates" data-bs-toggle="modal"
                                        data-bs-target="#stake_add_modal" class="btn btn-catalina-blue lh-sm">
                                        <span class="me-1">{{ localize('Add New') }}</span><svg width="12"
                                            height="12" viewBox="0 0 12 12" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 6H11M6 1V11" stroke="white" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-save w-100 actionBtn">{{ localize('SUBMIT') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <x-admin.edit-modal class="modal-dialog-centered modal-dialog-scrollable modal-lg" modalTitle="Update Plan" />
@endsection

@section('dataTableConent')
    <!-- Data table -->
    <x-data-table :dataTable="$dataTable" />
    <!-- Data table -->
@endsection

@push('js')
    <script src="{{ module_asset('Stake', 'js/app.js') }}"></script>
@endpush
