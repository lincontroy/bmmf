@php
    use App\Enums\SiteAlignEnum;
@endphp
<x-app-layout>
    <x-setting activeMenu="language-setting" activeMenuTitle="{{ localize('Language Setting') }}">

        <x-slot name="button">
            <button id="add-language-button" data-bs-toggle="modal" data-bs-target="#addLanguage"
                class="btn btn-save lh-sm">
                <span class="me-1">{{ localize('Add New') }}</span><svg width="12" height="12" viewBox="0 0 12 12"
                    fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 6H11M6 1V11" stroke="white" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </button>
        </x-slot>

        <div class="card-body px-4 px-xl-5">
            <!-- Data table -->
            <x-data-table :dataTable="$dataTable" />
            <!-- Data table -->
        </div>
    </x-setting>

    <div class="modal fade" id="addLanguage" tabindex="-1" aria-labelledby="addLanguageLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content radius-35">
                <div class="modal-header p-4">
                    <h5 class="modal-title text-color-5 fs-20 fw-medium" id="modelLabel">
                        {{ localize('Create Language') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-2">
                    <form action="{{ route('admin.setting.language.store') }}" method="post" class="needs-validation"
                        data="showCallBackData" id="language-form" novalidate=""
                        data-insert="{{ route('admin.setting.language.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="name">{{ localize('Name') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                        class="custom-form-control  form-control @error('name') is-invalid @enderror"
                                        placeholder="{{ localize('enter language name') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="symbol">{{ localize('Symbol') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="symbol" id="symbol" value="{{ old('symbol') }}"
                                        class="custom-form-control  form-control @error('symbol') is-invalid @enderror"
                                        placeholder="{{ localize('enter language symbol') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('symbol')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="logo">{{ localize('Logo') }}
                                    </label>
                                    <div class="radius-10 w-max-content preview-image" id="preview_file_logo">
                                    </div>
                                    <div class="custom-file-button position-relative mb-3">
                                        <input type="file" name="logo" id="logo" accept="image/*"
                                            class="custom-form-control file-preview @error('logo') is-invalid @enderror"
                                            data-previewDiv="preview_file_logo" />
                                        <input type="hidden" name="old_logo" value="" />
                                    </div>
                                    <span class="text-color-1 fs-16 fw-medium">{{ localize('Recommended Pixel') }} (150
                                        x 45)</span>
                                    <div class="invalid-feedback" role="alert">
                                        @error('logo')
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
                                id="languageFormActionBtn">{{ localize('Create') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    @push('js')
        <script src="{{ assets('js/setting/language.min.js') }}"></script>
    @endpush
</x-app-layout>
