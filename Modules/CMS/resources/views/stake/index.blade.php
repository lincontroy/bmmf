@php
    use App\Enums\StatusEnum;
@endphp
<x-app-layout>
    <div class="row gy-4">
        <div class="col-12">
            <div class="card py-4 px-3 radius-15">
                <div class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center mb-3">
                    <h3 class="fs-24 mb-0 text-color-2 fw-medium lh-1">{{ localize('Stake') }}</h3>
                    <div class="d-flex align-items-center gap-2">
                        <div class="border radius-10 p-1">
                            <button id="update-banner-button" data-bs-toggle="modal"
                                data-action='{{ route('admin.cms.stake.banner.update', ['article' => $stakeBanner->id]) }}'
                                data-route='{{ route('admin.cms.stake.banner.edit', ['article' => $stakeBanner->id]) }}'
                                data-bs-target="#updateBanner" class="btn btn-save lh-sm">
                                <span class="me-1">{{ localize('Update Stake Banner') }}</span><svg
                                    width="12" height="12" viewBox="0 0 12 12" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 6H11M6 1V11" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateBanner" tabindex="-1" aria-labelledby="updateBannerLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content radius-35">
                <div class="modal-header p-4">
                    <h5 class="modal-title text-color-5 fs-20 fw-medium" id="modelLabel">
                        {{ localize('Update Banner') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-2">
                    <form action="#" method="post" class="needs-validation" data="showBannerCallBackData"
                        id="banner-form" novalidate="" data-insert="#" enctype="multipart/form-data"
                        data-getData="{{ route('admin.cms.stake.banner.getArticleLang', [':language', ':article']) }}">
                        @csrf
                        <input type="hidden" name="banner_article_id" id="banner_article_id" value="0" />
                        <div class="row mb-3">

                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="stake_banner">{{ localize('Banner') }} <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="stake_banner" id="stake_banner"
                                        value="{{ old('stake_banner') }}"
                                        class="custom-form-control form-control @error('stake_banner') is-invalid @enderror"
                                        placeholder="{{ localize('enter header') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('stake_banner')
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
                                            data-previewDiv="preview_file_image" />
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
                                        for="stake_banner_title">{{ localize('Title') }} <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="stake_banner_title"
                                        id="stake_banner_title"
                                        value="{{ old('stake_banner_title') }}"
                                        class="custom-form-control form-control @error('stake_banner_title') is-invalid @enderror"
                                        placeholder="{{ localize('enter title') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('stake_banner_title')
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
                                id="bannerFormActionBtn">{{ localize('Create') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ module_asset('CMS', 'js/stake.js') }}"></script>
    @endpush
</x-app-layout>
