@php
    use App\Enums\StatusEnum;
    use App\Enums\PermissionMenuEnum;
    use App\Enums\PermissionActionEnum;
@endphp
<x-app-layout>
    <div class="row gy-4">
        <div class="col-12">
            <div class="card py-4 px-3 radius-15">
                <div class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center mb-3">
                    <h3 class="fs-24 mb-0 text-color-2 fw-medium lh-1">{{ localize('Packages') }}</h3>
                    @if ($_auth_user->can(PermissionMenuEnum::B2X_LOAN_AVAILABLE_PACKAGES->value . '.' . PermissionActionEnum::CREATE->value))
                        <div class="d-flex align-items-center gap-2">
                            <div class="border radius-10 p-1">
                                <button id="add-package-button" data-bs-toggle="modal" data-bs-target="#addPackage"
                                    class="btn btn-save lh-sm">
                                    <span class="me-1">{{ localize('Add New') }}</span>
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 6H11M6 1V11" stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
                <!-- Data table -->
                <x-data-table :dataTable="$dataTable" />
                <!-- Data table -->
            </div>
        </div>
    </div>
    <div class="modal fade" id="addPackage" tabindex="-1" aria-labelledby="addPackageLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content radius-35">
                <div class="modal-header p-4">
                    <h5 class="modal-title text-color-5 fs-20 fw-medium" id="modelLabel">{{ localize('Add package') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                        <form action="{{ route('b2xloan.package.store') }}" data-insert="{{ route('b2xloan.package.store') }}"
                              method="post" class="needs-validation" data="showCallBackData" id="b2x-loan-package-form" novalidate=""
                              enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3 g-4">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 col-lg-12">
                                        <div class="mb-2">
                                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                                for="no_of_month">{{ localize('No of month') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="no_of_month" id="no_of_month"
                                                   value="{{ old('no_of_month') }}"
                                                   class="custom-form-control bg-transparent @error('no_of_month') is-invalid @enderror"
                                                   placeholder="{{ localize('Number of month') }}" required />
                                            <div class="invalid-feedback" role="alert">
                                                @error('no_of_month')
                                                {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-12">
                                        <div class="mb-2">
                                            <label
                                                class="col-form-label text-start text-color-1 fs-16
                                            fw-medium">{{ localize('Interest Percent') }}
                                                <span class="text-danger">*</span></label>
                                            <input name="interest_percent" id="interest_percent"
                                                class="custom-form-control bg-transparent @error('interest_percent') is-invalid @enderror"
                                                type="text" placeholder="{{ localize('Interest percent') }}"
                                                required />
                                            <div class="invalid-feedback" role="alert">
                                                @error('interest_percent')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-12 d-lg-flex flex-lg-column justify-content-lg-center">
                                        <label
                                            class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Status') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status"
                                                    id="loanPackActive" checked value="1" />
                                                <label class="form-check-label"
                                                    for="loanPackActive">{{ localize('Active') }} </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status"
                                                    id="loanPackInactive" value="0" />
                                                <label class="form-check-label" for="loanPackInactive">
                                                    {{ localize('Inactive') }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="invalid-feedback" role="alert">
                                            @error('status')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 d-lg-flex flex-lg-column justify-content-lg-end">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-reset w-auto resetBtn" type="button"><i
                                            class="fa
                                    fa-undo-alt"></i>
                                        {{ localize('Reset') }}
                                    </button>
                                    <button class="btn btn-save ms-3 w-auto actionBtn"
                                        type="submit">{{ localize('Submit') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-admin.edit-modal />

    @push('js')
        <script src="{{ module_asset('B2xloan', 'js/package.js') }}"></script>
    @endpush

</x-app-layout>
