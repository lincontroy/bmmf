@php
    use App\Enums\StatusEnum;
@endphp
<x-app-layout>
    <div class="row gy-4">
        <div class="col-12">
            <div class="card py-4 px-3 radius-15">
                <div class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center mb-3">
                    <h3 class="fs-24 mb-0 text-color-2 fw-medium lh-1">{{ localize('Home Slider') }}</h3>
                    <div class="d-flex align-items-center gap-2">
                        <div class="border radius-10 p-1">
                            <button id="add-home-slider-button" data-bs-toggle="modal" data-bs-target="#addHomeSlider"
                                class="btn btn-save lh-sm">
                                <span class="me-1">{{ localize('Add New') }}</span><svg width="12" height="12"
                                    viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 6H11M6 1V11" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                    </div>
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

    <div class="modal fade" id="addHomeSlider" tabindex="-1" aria-labelledby="addHomeSliderLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content radius-35">
                <div class="modal-header p-4">
                    <h5 class="modal-title text-color-5 fs-20 fw-medium" id="modelLabel">
                        {{ localize('Create Home Slider') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-2">
                    <form action="{{ route('admin.cms.home-slider.store') }}" method="post" class="needs-validation"
                        data="showCallBackData" id="home-slider-form" novalidate=""
                        data-insert="{{ route('admin.cms.home-slider.store') }}" enctype="multipart/form-data"
                        data-getData="{{ route('admin.cms.home-slider.getArticleLang', [':language', ':article']) }}">
                        @csrf
                        <input type="hidden" name="article_id" id="article_id" value="0" />
                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="slider_name">{{ localize('Slider Name') }} <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="slider_name" id="slider_name"
                                        value="{{ old('name') }}"
                                        class="custom-form-control form-control @error('slider_name') is-invalid @enderror"
                                        placeholder="{{ localize('enter slider name') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('slider_name')
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
                                        for="language_id">{{ localize('Language') }} <span
                                            class="text-danger">*</span>
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
                                        for="slider_title">{{ localize('Slider Title') }} <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="slider_title" id="slider_title"
                                        value="{{ old('name') }}"
                                        class="custom-form-control form-control @error('slider_title') is-invalid @enderror"
                                        placeholder="{{ localize('enter slider title') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('slider_title')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="slider_header">{{ localize('Slider Header') }} <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="slider_header" id="slider_header"
                                        value="{{ old('name') }}"
                                        class="custom-form-control form-control @error('slider_header') is-invalid @enderror"
                                        placeholder="{{ localize('enter slider header') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('slider_header')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="slider_paragraph">{{ localize('Slider Paragraph') }} <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="slider_paragraph" id="slider_paragraph"
                                        value="{{ old('name') }}"
                                        class="custom-form-control form-control @error('slider_paragraph') is-invalid @enderror"
                                        placeholder="{{ localize('enter slider paragraph') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('slider_paragraph')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="slider_button_text">{{ localize('Button Text') }} <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="slider_button_text" id="slider_button_text"
                                        value="{{ old('name') }}"
                                        class="custom-form-control form-control @error('slider_button_text') is-invalid @enderror"
                                        placeholder="{{ localize('enter button text') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('slider_button_text')
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
                                id="homeSliderFormActionBtn">{{ localize('Create') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ module_asset('CMS', 'js/home-slider.min.js') }}"></script>
    @endpush
</x-app-layout>
