@php
    use App\Enums\StatusEnum;
@endphp

<x-app-layout>
    <div class="row gy-4">
        <div class="col-12">
            <div class="card py-4 px-3 radius-15">
                <div class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center mb-3">
                    <h3 class="fs-24 mb-0 text-color-2 fw-medium lh-1">{{ localize('Contact Address') }}</h3>
                    <div class="d-flex align-items-center gap-2">
                        <div class="border radius-10 p-1">
                            <button id="add-contact-address-button" data-bs-toggle="modal" data-bs-target="#addContactAddress"
                                class="btn btn-save lh-sm">
                                <span class="me-1">{{ localize('Add Contact Address') }}</span><svg width="12"
                                    height="12" viewBox="0 0 12 12" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 6H11M6 1V11" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Data table -->
                <div class="card-body px-4 px-xl-5">
                    <!-- Data table -->
                    <x-data-table :dataTable="$dataTable" />
                    <!-- Data table -->
                </div>
                <!-- Data table -->

            </div>
        </div>
    </div>

    <div class="modal fade" id="addContactAddress" tabindex="-1" aria-labelledby="addContactAddressLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content radius-35">
                <div class="modal-header p-4">
                    <h5 class="modal-title text-color-5 fs-20 fw-medium" id="modelLabel">
                        {{ localize('Create Blog Content') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-2">
                    <form action="{{ route('admin.cms.contact.address.store') }}" method="post" class="needs-validation"
                        data="showCallBackData" id="contact-address-form" novalidate=""
                        data-insert="{{ route('admin.cms.contact.address.store') }}" enctype="multipart/form-data"
                        data-getData="{{ route('admin.cms.contact.address.getArticleLang', [':language', ':article']) }}">
                        @csrf
                        <input type="hidden" name="article_id" id="article_id" value="0" />
                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="contact_address">{{ localize('Contact Address') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="contact_address" id="contact_address"
                                        value="{{ old('contact_address') }}"
                                        class="custom-form-control form-control @error('contact_address') is-invalid @enderror"
                                        placeholder="{{ localize('enter contact address') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('contact_address')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="language_id">{{ localize('Language') }} <span class="text-danger">*</span>
                                    </label>
                                    <select name="language_id" id="language_id" data-allowClear="true"
                                        data-placeholder="{{ localize('Language') }}"
                                        class="custom-form-control placeholder-single @error('language_id') is-invalid @enderror"
                                        required>
                                        @foreach ($languages as $language)
                                            <option value="{{ $language->id }}" @selected($language->id === ($setting->language_id ?? null))>
                                                {{ $language->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" role="alert">
                                        @error('language_id')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="contact_address_place">{{ localize('Place') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="contact_address_place" id="contact_address_place"
                                        value="{{ old('contact_address_place') }}"
                                        class="custom-form-control form-control @error('contact_address_place') is-invalid @enderror"
                                        placeholder="{{ localize('enter Place') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('contact_address_place')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="contact_address_location">{{ localize('Location') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="contact_address_location" id="contact_address_location"
                                        value="{{ old('contact_address_location') }}"
                                        class="custom-form-control form-control @error('contact_address_location') is-invalid @enderror"
                                        placeholder="{{ localize('enter location') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('contact_address_location')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="contact_address_contact">{{ localize('contact') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="contact_address_contact" id="contact_address_contact"
                                        value="{{ old('contact_address_contact') }}"
                                        class="custom-form-control form-control @error('contact_address_contact') is-invalid @enderror"
                                        placeholder="{{ localize('enter contact') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('contact_address_contact')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="status">{{ localize('Status') }} <span class="text-danger">*</span>
                                    </label>
                                    <select name="status" id="status" data-allowClear="true"
                                        data-placeholder="{{ localize('Status') }}"
                                        class="custom-form-control placeholder-single @error('status') is-invalid @enderror"
                                        required>
                                        <option value="{{ StatusEnum::ACTIVE->value }}">
                                            {{ enum_ucfirst_case(StatusEnum::ACTIVE->name) }}</option>
                                        <option value="{{ StatusEnum::INACTIVE->value }}">
                                            {{ enum_ucfirst_case(StatusEnum::INACTIVE->name) }}</option>
                                    </select>
                                    <div class="invalid-feedback" role="alert">
                                        @error('status')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-row gap-3">
                            <button type="reset" class="btn btn-reset py-2 resetBtn w-25"
                                title="{{ localize('Reset') }}">
                                <i class="fa fa-undo-alt"></i>
                            </button>
                            <button type="submit" class="actionBtn btn btn-save py-2 w-75"
                                id="contactAddressFormActionBtn">{{ localize('Create') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    @push('js')
        <script src="{{ module_asset('CMS', 'js/contact-address.min.js') }}"></script>
    @endpush
</x-app-layout>
