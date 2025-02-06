@php
    use Carbon\Carbon;
@endphp
<x-customer-app-layout>

    <div class="row gy-4 justify-content-center">
        <div class="col-12">
            <div class="card shadow-none radius-15">
                <h3 class="border-bottom fs-25 fw-medium mb-0 px-4 px-xl-5 py-4 text-color-2">
                    {{ localize('Request Application') }}
                </h3>
                <div class="card-body px-4 px-xl-5">

                    {{-- Account Request Form --}}
                    <form action="{{ route('customer.merchant.account-request.store') }}" method="post"
                        class="px-lg-5 mx-xxl-5"  id="account-request-form"
                        novalidate="" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4 gx-xxl-5">
                            <div class="col-12 col-lg-6">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="store_name">{{ localize('Store Name') }} <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="store_name" id="store_name"
                                    class="custom-form-control bg-transparent form-control @error('store_name') is-invalid @enderror"
                                    placeholder="{{ localize('enter store name') }}" required />
                                <div class="invalid-feedback" role="alert">
                                    @error('store_name')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="website_url">{{ localize('store_URL') }}
                                </label>
                                <input type="text" name="website_url" id="website_url"
                                    class="custom-form-control bg-transparent form-control @error('website_url') is-invalid @enderror"
                                    placeholder="{{ localize('enter store_URL') }}" />
                                <div class="invalid-feedback" role="alert">
                                    @error('website_url')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="email">{{ localize('Email') }} <span class="text-danger">*</span>
                                </label>
                                <input type="email" name="email" id="email"
                                    class="custom-form-control bg-transparent form-control @error('email') is-invalid @enderror"
                                    placeholder="{{ localize('enter email') }}" required />
                                <div class="invalid-feedback" role="alert">
                                    @error('email')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="phone">{{ localize('phone_number') }}
                                </label>
                                <input type="text" name="phone" id="phone"
                                    class="custom-form-control bg-transparent form-control @error('phone') is-invalid @enderror"
                                    placeholder="{{ localize('enter phone_number') }}" />
                                <div class="invalid-feedback" role="alert">
                                    @error('phone')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="about">{{ localize('description') }}
                                </label>
                                <textarea name="about" id="about" class="customer-form-control bg-transparent form-control @error('about') is-invalid @enderror"
                                    placeholder="{{ localize('enter description') }}" rows="4"></textarea>
                                <div class="invalid-feedback" role="alert">
                                    @error('about')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="logo"
                                    class="col-form-label text-start text-color-1 fs-14 fw-semi-bold">
                                    {{ localize('store_logo') }}
                                </label>
                                <div class="d-flex align-items-start align-items-sm-center gap-4">
                                    <div id="preview_file_logo">
                                        <img src="{{ assets('img/avatar.png') }}" alt="user-avatar"
                                            class="d-block w-px-100 h-px-100 rounded" required />
                                    </div>
                                    <div class="button-wrapper">
                                        <input type="file" name="logo" id="logo" accept="image/*"
                                            class="custom-form-control bg-transparent file-preview @error('logo') is-invalid @enderror"
                                            data-previewDiv="preview_file_logo" />
                                        <div class="invalid-feedback" role="alert">
                                            @error('logo')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 d-lg-flex flex-lg-column justify-content-lg-end">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-reset ms-3 w-auto" type="reset">
                                        {{ localize('Reset') }}
                                    </button>
                                    <button class="btn btn-save ms-3 w-auto" type="submit">
                                        {{ localize('Send') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    {{-- Account Request Form --}}

                </div>
            </div>
        </div>
    </div>

    @push('js')
    @endpush
</x-customer-app-layout>
