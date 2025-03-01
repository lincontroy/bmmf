@php
    use App\Enums\StatusEnum;
@endphp
<div class="modal fade" id="addCustomerSatisfyContent" tabindex="-1" aria-labelledby="addCustomerSatisfyContentLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content radius-35">
            <div class="modal-header p-4">
                <h5 class="modal-title text-color-5 fs-20 fw-medium" id="modelLabel">
                    {{ localize('Create Customer Satisfied Content') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 pt-2">
                <form action="{{ route('admin.cms.satisfied-customer.content.store') }}" method="post"
                    class="needs-validation" data="showCallBackData" id="satisfy-customer-content-form" novalidate=""
                    data-insert="{{ route('admin.cms.satisfied-customer.content.store') }}"
                    enctype="multipart/form-data"
                    data-getData="{{ route('admin.cms.satisfied-customer.content.getArticleLang', [':language', ':article']) }}">
                    @csrf
                    <input type="hidden" name="article_id" id="article_id" value="0" />
                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="customer_satisfy_content">{{ localize('Customer Satisfied Content') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="customer_satisfy_content" id="customer_satisfy_content"
                                    value="{{ old('customer_satisfy_content') }}"
                                    class="custom-form-control form-control @error('customer_satisfy_content') is-invalid @enderror"
                                    placeholder="{{ localize('enter customer satisfy content') }}" required />
                                <div class="invalid-feedback" role="alert">
                                    @error('customer_satisfy_content')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="satisfy_customer_name">{{ localize('Customer Name') }} <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="text" name="satisfy_customer_name" id="satisfy_customer_name"
                                    value="{{ old('satisfy_customer_name') }}"
                                    class="custom-form-control form-control @error('satisfy_customer_name') is-invalid @enderror"
                                    placeholder="{{ localize('enter customer name') }}" required />
                                <div class="invalid-feedback" role="alert">
                                    @error('satisfy_customer_name')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="designation">{{ localize('designation') }} <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="designation" id="designation"
                                    value="{{ old('designation') }}"
                                    class="custom-form-control form-control @error('designation') is-invalid @enderror"
                                    placeholder="{{ localize('enter designation') }}" required />
                                <div class="invalid-feedback" role="alert">
                                    @error('designation')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="satisfy_customer_company_name">{{ localize('Customer Company Name') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="satisfy_customer_company_name"
                                    id="satisfy_customer_company_name" value="{{ old('name') }}"
                                    class="custom-form-control form-control @error('satisfy_customer_company_name') is-invalid @enderror"
                                    placeholder="{{ localize('enter customer company name') }}" required />
                                <div class="invalid-feedback" role="alert">
                                    @error('satisfy_customer_company_name')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="satisfy_customer_company_url">{{ localize('Customer Company Url') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="satisfy_customer_company_url"
                                    id="satisfy_customer_company_url" value="{{ old('name') }}"
                                    class="custom-form-control form-control @error('satisfy_customer_company_url') is-invalid @enderror"
                                    placeholder="{{ localize('enter customer company url') }}" required />
                                <div class="invalid-feedback" role="alert">
                                    @error('satisfy_customer_company_url')
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
                                    for="satisfy_customer_message">{{ localize('Customer Message') }} <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="text" name="satisfy_customer_message" id="satisfy_customer_message"
                                    value="{{ old('name') }}"
                                    class="custom-form-control form-control @error('satisfy_customer_message') is-invalid @enderror"
                                    placeholder="{{ localize('enter customer message') }}" required />
                                <div class="invalid-feedback" role="alert">
                                    @error('satisfy_customer_message')
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
                            id="customerSatisfyContentFormActionBtn">{{ localize('Create') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
