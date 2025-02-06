@php
    use Carbon\Carbon;
@endphp
<x-customer-app-layout>

    <div class="row gy-4 justify-content-center">
        <div class="col-12">
            <div class="card shadow-none radius-15">
                <div
                    class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center mb-3 px-4 px-xl-5 py-4  border-bottom">
                    <h3 class="fs-24 mb-0 text-color-2 fw-medium lh-1">
                        {{ localize('Customer') }}
                    </h3>
                    <div class="d-flex align-items-center gap-2">
                        <div class="border radius-10 p-1">
                            <button id="add-customer-button" data-bs-toggle="modal" data-bs-target="#addCustomer"
                                class="btn btn-save lh-sm">
                                <span class="me-1">{{ localize('Add Customer') }}</span><svg width="12"
                                    height="12" viewBox="0 0 12 12" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 6H11M6 1V11" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body px-4 px-xl-5">

                    <!-- Data table -->
                    <x-data-table :dataTable="$dataTable" />
                    <!-- Data table -->

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addCustomer" tabindex="-1" aria-labelledby="addCustomerLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content radius-35">
                <div class="modal-header p-4">
                    <h5 class="modal-title text-color-5 fs-20 fw-medium" id="modelLabel">
                        {{ localize('Create Customer') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-2">
                    <form action="{{ route('customer.merchant.customer.index') }}" method="post"
                        class="needs-validation" data="showCallBackData" id="customer-form" novalidate=""
                        data-insert="{{ route('customer.merchant.customer.index') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="first_name">{{ localize('First Name') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="first_name" id="first_name"
                                        value="{{ old('first_name') }}"
                                        class="custom-form-control bg-transparent form-control @error('first_name') is-invalid @enderror"
                                        placeholder="{{ localize('enter first name') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('first_name')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="last_name">{{ localize('Last Name') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="last_name" id="last_name"
                                        value="{{ old('last_name') }}"
                                        class="custom-form-control bg-transparent form-control @error('last_name') is-invalid @enderror"
                                        placeholder="{{ localize('enter last name') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('last_name')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="email">{{ localize('Email') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                                        class="custom-form-control bg-transparent form-control @error('email') is-invalid @enderror"
                                        placeholder="{{ localize('enter email') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('email')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-row gap-3">
                                <button type="reset" class="btn btn-reset py-2 resetBtn w-25"
                                    title="{{ localize('Reset') }}">
                                    <i class="fa fa-undo-alt"></i>
                                </button>
                                <button type="submit" class="actionBtn btn btn-save py-2 w-75"
                                    id="customerFormActionBtn">{{ localize('Create') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ module_asset('Merchant', 'js/merchant-customer.min.js') }}"></script>
    @endpush
</x-customer-app-layout>
