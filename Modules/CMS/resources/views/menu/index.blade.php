<x-app-layout>
    <div class="row gy-4">
        <div class="col-12">
            <div class="card py-4 px-3 radius-15">
                <div class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center mb-3">
                    <h3 class="fs-24 mb-0 text-color-2 fw-medium lh-1">{{ localize('Menus') }}</h3>
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

    <div class="modal fade" id="addMenu" tabindex="-1" aria-labelledby="addMenuLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content radius-35">
                <div class="modal-header p-4">
                    <h5 class="modal-title text-color-5 fs-20 fw-medium" id="modelLabel">
                        {{ localize('Create Menu') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-2">
                    <form action="#" method="post" class="needs-validation" data="showCallBackData" id="menu-form"
                        novalidate="" data-insert="#" enctype="multipart/form-data"
                        data-getData="{{ route('admin.cms.menu.getArticleLang', [':language', ':article']) }}">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-12">

                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="menu_slug">{{ localize('Menu') }} <span class="text-danger">*</span>
                                    </label>
                                    <select name="menu_slug" id="menu_slug" data-allowClear="true"
                                        data-placeholder="{{ localize('Menu') }}"
                                        class="custom-form-control placeholder-single @error('menu_slug') is-invalid @enderror"
                                        required>
                                    </select>
                                    <div class="invalid-feedback" role="alert">
                                        @error('menu_slug')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
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
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="menu_name">{{ localize('Menu Name') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="menu_name" id="menu_name" value="{{ old('name') }}"
                                        class="custom-form-control  form-control @error('menu_name') is-invalid @enderror"
                                        placeholder="{{ localize('enter menu name') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('menu_name')
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
                                id="menuFormActionBtn">{{ localize('Create') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ module_asset('CMS', 'js/menu.min.js') }}"></script>
    @endpush
</x-app-layout>
