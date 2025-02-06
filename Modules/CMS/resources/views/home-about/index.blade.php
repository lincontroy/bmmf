@php
    use App\Enums\StatusEnum;
@endphp
<x-app-layout>
    <div class="row gy-4">
        <div class="col-12">
            <div class="card py-4 px-3 radius-15">
                <div class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center mb-3">
                    <h3 class="fs-24 mb-0 text-color-2 fw-medium lh-1">{{ localize('Home About') }}</h3>
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

    <div class="modal fade" id="addHomeAbout" tabindex="-1" aria-labelledby="addHomeAboutLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content radius-35">
                <div class="modal-header p-4">
                    <h5 class="modal-title text-color-5 fs-20 fw-medium" id="modelLabel">
                        {{ localize('Create Home About') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-2">
                    <form action="#" method="post" class="needs-validation" data="showCallBackData"
                        id="home-about-form" novalidate="" data-insert="#" enctype="multipart/form-data"
                        data-getData="{{ route('admin.cms.home-about.content.getArticleLang', [':language', ':article']) }}">
                        @csrf
                        <input type="hidden" name="article_id" id="article_id" value="0" />
                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="about_name">{{ localize('About Name') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="about_name" id="about_name" value="{{ old('name') }}"
                                        class="custom-form-control form-control @error('about_name') is-invalid @enderror"
                                        placeholder="{{ localize('enter about name') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('about_name')
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
                            <div class="col-12 col-md-6" hidden>
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="button_link">{{ localize('Button Link') }} <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="button_link" id="button_link"
                                        value="{{ old('name') }}"
                                        class="custom-form-control form-control @error('button_link') is-invalid @enderror"
                                        placeholder="{{ localize('enter button link') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('button_link')
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
                                        for="about_title">{{ localize('About Title') }} <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="about_title" id="about_title"
                                        value="{{ old('name') }}"
                                        class="custom-form-control form-control @error('about_title') is-invalid @enderror"
                                        placeholder="{{ localize('enter about title') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('about_title')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="about_header">{{ localize('About Header') }} <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="about_header" id="about_header"
                                        value="{{ old('name') }}"
                                        class="custom-form-control form-control @error('about_header') is-invalid @enderror"
                                        placeholder="{{ localize('enter about header') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('about_header')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="about_content">{{ localize('About Paragraph') }} <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="about_content" id="about_content"
                                        value="{{ old('name') }}"
                                        class="custom-form-control form-control @error('about_content') is-invalid @enderror"
                                        placeholder="{{ localize('enter about paragraph') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('about_content')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="about_button_text">{{ localize('Button Text') }} <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="about_button_text" id="about_button_text"
                                        value="{{ old('name') }}"
                                        class="custom-form-control form-control @error('about_button_text') is-invalid @enderror"
                                        placeholder="{{ localize('enter button text') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('about_button_text')
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
                                id="homeAboutFormActionBtn">{{ localize('Create') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addAboutBanner" tabindex="-1" aria-labelledby="addAboutBannerLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content radius-35">
                <div class="modal-header p-4">
                    <h5 class="modal-title text-color-5 fs-20 fw-medium" id="modelBannerLabel">
                        {{ localize('About Us Banner') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-2">
                    <form action="#" method="post" class="needs-validation" data="showCallBackBannerData"
                        id="home-about-banner-form" novalidate="" data-insert="#" enctype="multipart/form-data"
                        data-getData="{{ route('admin.cms.home-about.banner.getArticleLang', [':language', ':article']) }}">
                        @csrf
                        <input type="hidden" name="banner_article_id" id="banner_article_id" value="0" />
                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="about_us_banner">{{ localize('About Us Banner') }} <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="about_us_banner" id="about_us_banner"
                                        value="{{ old('name') }}"
                                        class="custom-form-control form-control @error('about_us_banner') is-invalid @enderror"
                                        placeholder="{{ localize('enter about us banner') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('about_us_banner')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="banner_image">{{ localize('Image') }} <span
                                            id="banner_image_required_div" class="text-danger">*</span>
                                    </label>
                                    <div class="" id="preview_file_banner_image">
                                    </div>
                                    <div class="custom-file-button position-relative mb-3">
                                        <input type="file" name="banner_image" id="banner_image" accept="image/*"
                                            class="custom-form-control file-preview @error('image') is-invalid @enderror"
                                            data-previewDiv="preview_file_banner_image" required />
                                        <div class="invalid-feedback" role="alert">
                                            @error('banner_image')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="banner_language_id">{{ localize('Language') }} <span
                                            class="text-danger">*</span>
                                    </label>
                                    <select name="banner_language_id" id="banner_language_id" data-allowClear="true"
                                        data-placeholder="{{ localize('Language') }}"
                                        class="custom-form-control placeholder-single @error('banner_language_id') is-invalid @enderror"
                                        required>
                                        @foreach ($languages as $language)
                                            <option value="{{ $language->id }}" @selected($language->id === ($setting->language_id ?? null))>
                                                {{ $language->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" role="alert">
                                        @error('banner_language_id')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="about_us_banner_title">{{ localize('Banner Title') }} <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="about_us_banner_title" id="about_us_banner_title"
                                        value="{{ old('name') }}"
                                        class="custom-form-control form-control @error('about_us_banner_title') is-invalid @enderror"
                                        placeholder="{{ localize('enter banner title') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('about_us_banner_title')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="banner_status">{{ localize('Status') }} <span
                                            class="text-danger">*</span>
                                    </label>
                                    <select name="banner_status" id="banner_status" data-allowClear="true"
                                        data-placeholder="{{ localize('Status') }}"
                                        class="custom-form-control placeholder-single @error('banner_status') is-invalid @enderror"
                                        required>
                                        <option value="{{ StatusEnum::ACTIVE->value }}">
                                            {{ enum_ucfirst_case(StatusEnum::ACTIVE->name) }}</option>
                                        <option value="{{ StatusEnum::INACTIVE->value }}">
                                            {{ enum_ucfirst_case(StatusEnum::INACTIVE->name) }}</option>
                                    </select>
                                    <div class="invalid-feedback" role="alert">
                                        @error('banner_status')
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
                                id="homeAboutBannerFormActionBtn">{{ localize('Create') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    @push('js')
        <script src="{{ module_asset('CMS', 'js/home-about.min.js') }}"></script>
    @endpush
</x-app-layout>
