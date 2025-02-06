@php
    use App\Enums\SiteAlignEnum;

@endphp
<x-app-layout>
    <x-setting activeMenu="fee-setting" activeMenuTitle="{{ localize('Fee Setting') }}">

        <x-slot name="button">
            <button id="add-fee-setting-button" data-bs-toggle="modal" data-bs-target="#addFeeSetting"
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

    <div class="modal fade" id="addFeeSetting" tabindex="-1" aria-labelledby="addFeeSettingLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content radius-35">
                <div class="modal-header p-4">
                    <h5 class="modal-title text-color-5 fs-20 fw-medium" id="modelLabel">
                        {{ localize('fess settings') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-2">
                    <form action="{{ route('admin.setting.fee-setting.store') }}" method="post"
                        class="needs-validation" data="showCallBackData" id="fee-setting-form" novalidate=""
                        data-insert="{{ route('admin.setting.fee-setting.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="level">{{ localize('Level') }} <span class="text-danger">*</span> </label>
                                    <select name="level" id="level"
                                        class="custom-form-control placeholder-single @error('level') is-invalid @enderror"
                                        required>
                                        @foreach ($feeSettingLevels as $feeSettingLevel)
                                            <option value="{{ $feeSettingLevel }}">
                                                {{ $feeSettingLevel }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" role="alert">
                                        @error('level')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="fee">{{ localize('Fee') }} (%) <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" name="fee" id="fee" value="{{ old('fee') }}"
                                        class="custom-form-control form-control @error('fee') is-invalid @enderror"
                                        placeholder="{{ localize('enter fee') }}" step="any" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('fee')
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
                                id="feeSettingFormActionBtn">{{ localize('Create') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ assets('js/setting/fee-setting.min.js') }}"></script>
    @endpush
</x-app-layout>
