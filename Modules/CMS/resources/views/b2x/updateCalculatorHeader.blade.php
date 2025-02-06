@php
    use App\Enums\StatusEnum;
@endphp

<div class="modal fade" id="updateCalculatorHeader" tabindex="-1" aria-labelledby="updateCalculatorHeaderLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content radius-35">
            <div class="modal-header p-4">
                <h5 class="modal-title text-color-5 fs-20 fw-medium" id="modelCalculatorHeaderLabel">
                    {{ localize('Update B2X Calculator Header') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 pt-2">
                <form action="#" method="post" class="needs-validation" data="showCalculatorHeaderCallBackData"
                    id="calculator-header-form" novalidate="" data-insert="#" enctype="multipart/form-data"
                    data-getData="{{ route('admin.cms.b2x.calculator-header.getArticleLang', [':language', ':article']) }}">
                    @csrf
                    <input type="hidden" name="calculator_header_article_id" id="calculator_header_article_id"
                        value="0" />
                    <div class="row mb-3">

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="b2x_calculator_header">{{ localize('B2X Calculator Header') }} <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="text" name="b2x_calculator_header" id="b2x_calculator_header"
                                    value="{{ old('name') }}"
                                    class="custom-form-control form-control @error('b2x_calculator_header') is-invalid @enderror"
                                    placeholder="{{ localize('enter b2x calculator header') }}" required />
                                <div class="invalid-feedback" role="alert">
                                    @error('b2x_calculator_header')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="calculator_header_language_id">{{ localize('Language') }} <span
                                        class="text-danger">*</span>
                                </label>
                                <select name="calculator_header_language_id" id="calculator_header_language_id"
                                    data-allowClear="true" data-placeholder="{{ localize('Language') }}"
                                    class="custom-form-control placeholder-single @error('calculator_header_language_id') is-invalid @enderror"
                                    required>
                                    @foreach ($languages as $language)
                                        <option value="{{ $language->id }}" @selected($language->id === ($setting->language_id ?? null))>
                                            {{ $language->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" role="alert">
                                    @error('calculator_header_language_id')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="b2x_calculator_header_title">{{ localize('B2X Calculator Header Title') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="b2x_calculator_header_title"
                                    id="b2x_calculator_header_title" value="{{ old('b2x_calculator_header_title') }}"
                                    class="custom-form-control form-control @error('b2x_calculator_header_title') is-invalid @enderror"
                                    placeholder="{{ localize('enter b2x calculator header title') }}" required />
                                <div class="invalid-feedback" role="alert">
                                    @error('b2x_calculator_header_title')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="b2x_calculator_header_content">{{ localize('B2X Calculator Header Content') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="b2x_calculator_header_content"
                                    id="b2x_calculator_header_content"
                                    value="{{ old('b2x_calculator_header_content') }}"
                                    class="custom-form-control form-control @error('b2x_calculator_header_content') is-invalid @enderror"
                                    placeholder="{{ localize('enter b2x calculator header content') }}" required />
                                <div class="invalid-feedback" role="alert">
                                    @error('b2x_calculator_header_content')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="b2x_loan_details_header_title">{{ localize('B2X Details Header Content') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="b2x_loan_details_header_title"
                                    id="b2x_loan_details_header_title"
                                    value="{{ old('b2x_loan_details_header_title') }}"
                                    class="custom-form-control form-control @error('b2x_loan_details_header_title') is-invalid @enderror"
                                    placeholder="{{ localize('enter b2x details header content') }}" required />
                                <div class="invalid-feedback" role="alert">
                                    @error('b2x_loan_details_header_title')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="b2x_loan_button_text">{{ localize('B2X Loan Button Text') }} <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="text" name="b2x_loan_button_text" id="b2x_loan_button_text"
                                    value="{{ old('b2x_loan_button_text') }}"
                                    class="custom-form-control form-control @error('b2x_loan_button_text') is-invalid @enderror"
                                    placeholder="{{ localize('enter b2x loan button text') }}" required />
                                <div class="invalid-feedback" role="alert">
                                    @error('b2x_loan_button_text')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="calculator_header_status">{{ localize('Status') }} <span
                                        class="text-danger">*</span>
                                </label>
                                <select name="calculator_header_status" id="calculator_header_status"
                                    data-allowClear="true" data-placeholder="{{ localize('Status') }}"
                                    class="custom-form-control placeholder-single @error('calculator_header_status') is-invalid @enderror"
                                    required>
                                    <option value="{{ StatusEnum::ACTIVE->value }}">
                                        {{ enum_ucfirst_case(StatusEnum::ACTIVE->name) }}</option>
                                    <option value="{{ StatusEnum::INACTIVE->value }}">
                                        {{ enum_ucfirst_case(StatusEnum::INACTIVE->name) }}</option>
                                </select>
                                <div class="invalid-feedback" role="alert">
                                    @error('calculator_header_status')
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
                            id="calculatorHeaderFormActionBtn">{{ localize('Create') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
