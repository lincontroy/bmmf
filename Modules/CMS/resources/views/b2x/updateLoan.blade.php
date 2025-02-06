@php
    use App\Enums\StatusEnum;
@endphp

<div class="modal fade" id="updateLoan" tabindex="-1" aria-labelledby="updateLoanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content radius-35">
            <div class="modal-header p-4">
                <h5 class="modal-title text-color-5 fs-20 fw-medium" id="modelLabel">
                    {{ localize('Update B2X Loan') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 pt-2">
                <form action="#" method="post" class="needs-validation" data="showLoanCallBackData" id="loan-form"
                    novalidate="" data-insert="#" enctype="multipart/form-data"
                    data-getData="{{ route('admin.cms.b2x.loan.getArticleLang', [':language', ':article']) }}">
                    @csrf
                    <input type="hidden" name="loan_article_id" id="loan_article_id" value="0" />
                    <div class="row mb-3">

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="b2x_loan">{{ localize('B2X Loan') }} <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="b2x_loan" id="b2x_loan" value="{{ old('name') }}"
                                    class="custom-form-control form-control @error('b2x_loan') is-invalid @enderror"
                                    placeholder="{{ localize('enter b2x loan') }}" required />
                                <div class="invalid-feedback" role="alert">
                                    @error('b2x_loan')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="loan_image">{{ localize('Image') }}
                                </label>
                                <div class="" id="preview_file_loan_image">
                                </div>
                                <div class="custom-file-button position-relative mb-3">
                                    <input type="file" name="loan_image" id="loan_image" accept="image/*"
                                        class="custom-form-control file-preview @error('loan_image') is-invalid @enderror"
                                        data-previewDiv="preview_file_loan_image" />
                                    <input type="hidden" name="old_image" value="" />
                                    <div class="invalid-feedback" role="alert">
                                        @error('loan_image')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="loan_language_id">{{ localize('Language') }} <span class="text-danger">*</span>
                                </label>
                                <select name="loan_language_id" id="loan_language_id" data-allowClear="true"
                                    data-placeholder="{{ localize('Language') }}"
                                    class="custom-form-control placeholder-single @error('loan_language_id') is-invalid @enderror"
                                    required>
                                    @foreach ($languages as $language)
                                        <option value="{{ $language->id }}" @selected($language->id === ($setting->language_id ?? null))>
                                            {{ $language->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" role="alert">
                                    @error('loan_language_id')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="b2x_title">{{ localize('B2X Title') }} <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="b2x_title" id="b2x_title" value="{{ old('b2x_title') }}"
                                    class="custom-form-control form-control @error('b2x_title') is-invalid @enderror"
                                    placeholder="{{ localize('enter b2x title') }}" required />
                                <div class="invalid-feedback" role="alert">
                                    @error('b2x_title')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="b2x_button_one_text">{{ localize('Button One Text') }} <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="text" name="b2x_button_one_text" id="b2x_button_one_text"
                                    value="{{ old('b2x_button_one_text') }}"
                                    class="custom-form-control form-control @error('b2x_button_one_text') is-invalid @enderror"
                                    placeholder="{{ localize('enter button one text') }}" required />
                                <div class="invalid-feedback" role="alert">
                                    @error('b2x_button_one_text')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="b2x_button_two_text">{{ localize('Button Two Text') }} <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="text" name="b2x_button_two_text" id="b2x_button_two_text"
                                    value="{{ old('b2x_button_two_text') }}"
                                    class="custom-form-control form-control @error('b2x_button_two_text') is-invalid @enderror"
                                    placeholder="{{ localize('enter button two text') }}" required />
                                <div class="invalid-feedback" role="alert">
                                    @error('b2x_button_two_text')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="b2x_content">{{ localize('Content') }} <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="b2x_content" id="b2x_content"
                                    value="{{ old('b2x_content') }}"
                                    class="custom-form-control form-control @error('b2x_content') is-invalid @enderror"
                                    placeholder="{{ localize('enter content') }}" required />
                                <div class="invalid-feedback" role="alert">
                                    @error('b2x_content')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="loan_status">{{ localize('Status') }} <span class="text-danger">*</span>
                                </label>
                                <select name="loan_status" id="loan_status" data-allowClear="true"
                                    data-placeholder="{{ localize('Status') }}"
                                    class="custom-form-control placeholder-single @error('loan_status') is-invalid @enderror"
                                    required>
                                    <option value="{{ StatusEnum::ACTIVE->value }}">
                                        {{ enum_ucfirst_case(StatusEnum::ACTIVE->name) }}</option>
                                    <option value="{{ StatusEnum::INACTIVE->value }}">
                                        {{ enum_ucfirst_case(StatusEnum::INACTIVE->name) }}</option>
                                </select>
                                <div class="invalid-feedback" role="alert">
                                    @error('loan_status')
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
                            id="loanFormActionBtn">{{ localize('Create') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
