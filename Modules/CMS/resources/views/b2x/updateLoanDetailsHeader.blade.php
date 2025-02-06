@php
    use App\Enums\StatusEnum;
@endphp

<div class="modal fade" id="updateLoanDetailsHeader" tabindex="-1" aria-labelledby="updateLoanDetailsHeaderLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content radius-35">
            <div class="modal-header p-4">
                <h5 class="modal-title text-color-5 fs-20 fw-medium" id="modelLoanDetailsHeaderLabel">
                    {{ localize('Update B2X Loan Details Header') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 pt-2">
                <form action="#" method="post" class="needs-validation" data="showLoanDetailsHeaderCallBackData"
                    id="loan-details-header-form" novalidate="" data-insert="#" enctype="multipart/form-data"
                    data-getData="{{ route('admin.cms.b2x.loan-details-header.getArticleLang', [':language', ':article']) }}">
                    @csrf
                    <input type="hidden" name="loan_details_header_article_id" id="loan_details_header_article_id"
                        value="0" />
                    <div class="row mb-3">

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="b2x_loan_details_header">{{ localize('B2X Loan Details Header') }} <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="text" name="b2x_loan_details_header" id="b2x_loan_details_header"
                                    value="{{ old('name') }}"
                                    class="custom-form-control form-control @error('b2x_loan_details_header') is-invalid @enderror"
                                    placeholder="{{ localize('enter b2x loan details header') }}" required />
                                <div class="invalid-feedback" role="alert">
                                    @error('b2x_loan_details_header')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="loan_details_header_language_id">{{ localize('Language') }} <span
                                        class="text-danger">*</span>
                                </label>
                                <select name="loan_details_header_language_id" id="loan_details_header_language_id"
                                    data-allowClear="true" data-placeholder="{{ localize('Language') }}"
                                    class="custom-form-control placeholder-single @error('loan_details_header_language_id') is-invalid @enderror"
                                    required>
                                    @foreach ($languages as $language)
                                        <option value="{{ $language->id }}" @selected($language->id === ($setting->language_id ?? null))>
                                            {{ $language->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback" role="alert">
                                    @error('loan_details_header_language_id')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="new_b2x_loan_details_header_title">{{ localize('B2X Loan Details Header Title') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="new_b2x_loan_details_header_title"
                                    id="new_b2x_loan_details_header_title"
                                    value="{{ old('new_b2x_loan_details_header_title') }}"
                                    class="custom-form-control form-control @error('new_b2x_loan_details_header_title') is-invalid @enderror"
                                    placeholder="{{ localize('enter b2x loan details header title') }}" required />
                                <div class="invalid-feedback" role="alert">
                                    @error('new_b2x_loan_details_header_title')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="loan_details_header_status">{{ localize('Status') }} <span
                                        class="text-danger">*</span>
                                </label>
                                <select name="loan_details_header_status" id="loan_details_header_status"
                                    data-allowClear="true" data-placeholder="{{ localize('Status') }}"
                                    class="custom-form-control placeholder-single @error('loan_details_header_status') is-invalid @enderror"
                                    required>
                                    <option value="{{ StatusEnum::ACTIVE->value }}">
                                        {{ enum_ucfirst_case(StatusEnum::ACTIVE->name) }}</option>
                                    <option value="{{ StatusEnum::INACTIVE->value }}">
                                        {{ enum_ucfirst_case(StatusEnum::INACTIVE->name) }}</option>
                                </select>
                                <div class="invalid-feedback" role="alert">
                                    @error('loan_details_header_status')
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
                            id="loanDetailsHeaderFormActionBtn">{{ localize('Create') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
