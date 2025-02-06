@php
    use App\Enums\StatusEnum;
@endphp
<x-app-layout>
    <div class="row gy-4">
        <div class="col-12">
            <div class="card py-4 px-3 radius-15">
                <div class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center mb-3">
                    <h3 class="fs-24 mb-0 text-color-2 fw-medium lh-1">{{ localize('Package Banner') }}</h3>
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

    <div class="modal fade" id="addPackageBanner" tabindex="-1" aria-labelledby="addPackageBannerLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content radius-35">
                <div class="modal-header p-4">
                    <h5 class="modal-title text-color-5 fs-20 fw-medium" id="modelBannerLabel">
                        {{ localize('Create Package Banner') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-2">
                    <form action="#" method="post" class="needs-validation"
                        data="showCallBackData" id="package-banner-form" novalidate=""
                        data-insert="#" enctype="multipart/form-data"
                        data-getData="{{ route('admin.cms.package.banner.getArticleLang', [':language', ':article']) }}">
                        @csrf
                        <input type="hidden" name="article_id" id="article_id" value="0" />
                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="package_banner">{{ localize('Package Banner') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="package_banner" id="package_banner" value="{{ old('name') }}"
                                        class="custom-form-control form-control @error('package_banner') is-invalid @enderror"
                                        placeholder="{{ localize('enter package banner') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('package_banner')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="image">{{ localize('Image') }} <span id="image_required_div"
                                            class="text-danger">*</span>
                                    </label>
                                    <div class="" id="preview_file_image">
                                    </div>
                                    <div class="custom-file-button position-relative mb-3">
                                        <input type="file" name="image" id="image" accept="image/*"
                                            class="custom-form-control file-preview @error('image') is-invalid @enderror"
                                            data-previewDiv="preview_file_image" required />
                                        <input type="hidden" name="old_image" value="" />
                                        <div class="invalid-feedback" role="alert">
                                            @error('image')
                                                {{ $message }}
                                            @enderror
                                        </div>
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
                                        for="package_banner_title">{{ localize('Title') }} <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="package_banner_title" id="package_banner_title"
                                        value="{{ old('name') }}"
                                        class="custom-form-control form-control @error('package_banner_title') is-invalid @enderror"
                                        placeholder="{{ localize('enter title') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('package_banner_title')
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
                                id="packageBannerFrmActionBtn">{{ localize('Create') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addPackageHeader" tabindex="-1" aria-labelledby="addPackageHeaderLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content radius-35">
                <div class="modal-header p-4">
                    <h5 class="modal-title text-color-5 fs-20 fw-medium" id="modelHeaderLabel">
                        {{ localize('Update Package Header') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-2">
                    <form action="#" method="post" class="needs-validation"
                        data="showCallBackHeaderData" id="package-header-form" novalidate=""
                        data-insert="#" enctype="multipart/form-data"
                        data-getData="{{ route('admin.cms.package.header.getArticleLang', [':language', ':article']) }}">
                        @csrf
                        <input type="hidden" name="article_id" id="header_article_id" value="0" />
                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="package_header">{{ localize('Package Header') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="package_header" id="package_header" value="{{ old('name') }}"
                                        class="custom-form-control form-control @error('package_header') is-invalid @enderror"
                                        placeholder="{{ localize('enter package header') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('package_header')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="header_language_id">{{ localize('Language') }} <span class="text-danger">*</span>
                                    </label>
                                    <select name="header_language_id" id="header_language_id" data-allowClear="true"
                                        data-placeholder="{{ localize('Language') }}"
                                        class="custom-form-control placeholder-single @error('header_language_id') is-invalid @enderror"
                                        required>
                                        @foreach ($languages as $language)
                                            <option value="{{ $language->id }}" @selected($language->id === ($setting->language_id ?? null))>
                                                {{ $language->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" role="alert">
                                        @error('header_language_id')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="package_header_title">{{ localize('Title') }} <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="package_header_title" id="package_header_title"
                                        value="{{ old('name') }}"
                                        class="custom-form-control form-control @error('package_header_title') is-invalid @enderror"
                                        placeholder="{{ localize('enter title') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('package_header_title')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="package_header_content">{{ localize('Content') }} <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="package_header_content" id="package_header_content"
                                        value="{{ old('name') }}"
                                        class="custom-form-control form-control @error('package_header_content') is-invalid @enderror"
                                        placeholder="{{ localize('enter content') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('package_header_content')
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
                                    <select name="header_status" id="header_status" data-allowClear="true"
                                        data-placeholder="{{ localize('Status') }}"
                                        class="custom-form-control placeholder-single @error('header_status') is-invalid @enderror"
                                        required>
                                        <option value="{{ StatusEnum::ACTIVE->value }}">
                                            {{ enum_ucfirst_case(StatusEnum::ACTIVE->name) }}</option>
                                        <option value="{{ StatusEnum::INACTIVE->value }}">
                                            {{ enum_ucfirst_case(StatusEnum::INACTIVE->name) }}</option>
                                    </select>
                                    <div class="invalid-feedback" role="alert">
                                        @error('header_status')
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
                                id="packageHeaderFrmActionBtn">{{ localize('Create') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ module_asset('CMS', 'js/package-banner.min.js') }}"></script>
    @endpush
</x-app-layout>
