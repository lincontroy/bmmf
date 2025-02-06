@php
    use App\Enums\StatusEnum;
@endphp

<div class="modal fade" id="updateHeader" tabindex="-1" aria-labelledby="updateHeaderLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content radius-35">
            <div class="modal-header p-4">
                <h5 class="modal-title text-color-5 fs-20 fw-medium" id="modelHeaderLabel">
                    {{ localize('Update Our Difference Header') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 pt-2">
                <form action="#" method="post" class="needs-validation" data="showHeaderCallBackData"
                    id="header-form" novalidate="" data-insert="#" enctype="multipart/form-data"
                    data-getData="{{ route('admin.cms.team-member.header.getArticleDataLang', [':language', ':article']) }}">
                    @csrf
                    <input type="hidden" name="header_article_id" id="header_article_id" value="0" />
                    <div class="row mb-3">

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="our_difference_header">{{ localize('Our Difference Header') }} <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="text" name="our_difference_header" id="our_difference_header"
                                    value="{{ old('our_difference_header') }}"
                                    class="custom-form-control form-control @error('our_difference_header') is-invalid @enderror"
                                    placeholder="{{ localize('enter nishue difference header') }}" required />
                                <div class="invalid-feedback" role="alert">
                                    @error('our_difference_header')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="header_language_id">{{ localize('Language') }} <span
                                        class="text-danger">*</span>
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
                                    for="our_difference_header_title">{{ localize('Team Header Title') }} <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="text" name="our_difference_header_title" id="our_difference_header_title"
                                    value="{{ old('our_difference_header_title') }}"
                                    class="custom-form-control form-control @error('our_difference_header_title') is-invalid @enderror"
                                    placeholder="{{ localize('enter team header title') }}" required />
                                <div class="invalid-feedback" role="alert">
                                    @error('our_difference_header_title')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="our_difference_header_content">{{ localize('Team Header Content') }} <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="text" name="our_difference_header_content" id="our_difference_header_content"
                                    value="{{ old('our_difference_header_content') }}"
                                    class="custom-form-control form-control @error('our_difference_header_content') is-invalid @enderror"
                                    placeholder="{{ localize('enter team header Content') }}" required />
                                <div class="invalid-feedback" role="alert">
                                    @error('our_difference_header_content')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="header_status">{{ localize('Status') }} <span class="text-danger">*</span>
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
                            id="headerFormActionBtn">{{ localize('Create') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
