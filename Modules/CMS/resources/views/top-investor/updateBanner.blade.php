@php
    use App\Enums\StatusEnum;
@endphp

<div class="modal fade" id="updateBanner" tabindex="-1" aria-labelledby="updateBannerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content radius-35">
            <div class="modal-header p-4">
                <h5 class="modal-title text-color-5 fs-20 fw-medium" id="modelBannerLabel">
                    {{ localize('Update Investor Banner') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 pt-2">
                <form action="#" method="post" class="needs-validation" data="showBannerCallBackData"
                    id="banner-form" novalidate="" data-insert="#" enctype="multipart/form-data"
                    data-getData="{{ route('admin.cms.top-investor.banner.getArticleLang', [':language', ':article']) }}">
                    @csrf
                    <input type="hidden" name="banner_article_id" id="banner_article_id" value="0" />
                    <div class="row mb-3">

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="top_investor_banner">{{ localize('Top Investor Banner') }} <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="text" name="top_investor_banner" id="top_investor_banner"
                                    value="{{ old('top_investor_banner') }}"
                                    class="custom-form-control form-control @error('top_investor_banner') is-invalid @enderror"
                                    placeholder="{{ localize('enter top investor banner') }}" required />
                                <div class="invalid-feedback" role="alert">
                                    @error('top_investor_banner')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="banner_image">{{ localize('Image') }}
                                </label>
                                <div class="" id="preview_file_banner_image">
                                </div>
                                <div class="custom-file-button position-relative mb-3">
                                    <input type="file" name="banner_image" id="banner_image" accept="image/*"
                                        class="custom-form-control file-preview @error('banner_image') is-invalid @enderror"
                                        data-previewDiv="preview_file_banner_image" />
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
                                    for="top_investor_banner_title">{{ localize('Top Investor Banner Title') }} <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="text" name="top_investor_banner_title" id="top_investor_banner_title"
                                    value="{{ old('top_investor_banner_title') }}"
                                    class="custom-form-control form-control @error('top_investor_banner_title') is-invalid @enderror"
                                    placeholder="{{ localize('enter top investor banner title') }}" required />
                                <div class="invalid-feedback" role="alert">
                                    @error('top_investor_banner_title')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="banner_status">{{ localize('Status') }} <span class="text-danger">*</span>
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
