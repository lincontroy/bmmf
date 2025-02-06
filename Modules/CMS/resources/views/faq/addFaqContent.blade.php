@php
    use App\Enums\StatusEnum;
@endphp

<div class="modal fade" id="addFaqContent" tabindex="-1" aria-labelledby="addFaqContentLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content radius-35">
            <div class="modal-header p-4">
                <h5 class="modal-title text-color-5 fs-20 fw-medium" id="modelLabel">
                    {{ localize('Create Faq Content') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 pt-2">
                <form action="{{ route('admin.cms.faq.content.store') }}" method="post" class="needs-validation"
                    data="showCallBackData" id="faq-content-form" novalidate=""
                    data-insert="{{ route('admin.cms.faq.content.store') }}" enctype="multipart/form-data"
                    data-getData="{{ route('admin.cms.faq.content.getArticleLang', [':language', ':article']) }}">
                    @csrf
                    <input type="hidden" name="article_id" id="article_id" value="0" />
                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="faq_content">{{ localize('Faq Content') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="faq_content" id="faq_content"
                                    value="{{ old('faq_content') }}"
                                    class="custom-form-control form-control @error('faq_content') is-invalid @enderror"
                                    placeholder="{{ localize('enter faq content') }}" required />
                                <div class="invalid-feedback" role="alert">
                                    @error('faq_content')
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
                                    for="question_content">{{ localize('Question') }} <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="text" name="question_content" id="question_content"
                                    value="{{ old('name') }}"
                                    class="custom-form-control form-control @error('question_content') is-invalid @enderror"
                                    placeholder="{{ localize('enter question') }}" required />
                                <div class="invalid-feedback" role="alert">
                                    @error('question_content')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="answer_content">{{ localize('Answer') }} <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="answer_content" id="answer_content"
                                    value="{{ old('name') }}"
                                    class="custom-form-control form-control @error('answer_content') is-invalid @enderror"
                                    placeholder="{{ localize('enter answer') }}" required />
                                <div class="invalid-feedback" role="alert">
                                    @error('answer_content')
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
                            id="faqContentFormActionBtn">{{ localize('Create') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
