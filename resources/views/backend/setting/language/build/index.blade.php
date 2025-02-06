@php
    use App\Enums\SiteAlignEnum;
@endphp
<x-app-layout>
    <x-setting activeMenu="language-setting" activeMenuTitle="{{ localize('Language Build') }}">

        <x-slot name="button">
            <button id="add-language-button" data-bs-toggle="modal" data-bs-target="#addLanguageBuild"
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
            <div class="mb-2">
                <table class="table display table-sm" id="local-builder-table"
                    data-ajax="{{ route('admin.setting.language.build.data-table-ajax', $language->symbol) }}"
                    data-update>
                    <thead>
                        <tr class="role-header">
                            <th>@localize('Key')</th>
                            <th>@localize('Label')</th>
                            <th>@localize('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <!-- Data table -->

        </div>
    </x-setting>

    <div class="modal fade" id="addLanguageBuild" tabindex="-1" aria-labelledby="addLanguageBuildLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content radius-35">
                <div class="modal-header p-4">
                    <h5 class="modal-title text-color-5 fs-20 fw-medium" id="modelLabel">
                        {{ localize('Create Language Build') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-2">
                    <form action="{{ route('admin.setting.language.build.store', ['language' => $language->id]) }}"
                        method="post" class="needs-validation" data="showCallBackData" id="build-language-form"
                        novalidate=""
                        data-insert="{{ route('admin.setting.language.build.store', ['language' => $language->id]) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <table class="table display table-bordered table-sm  table-hover " id="build-local">
                                <thead>
                                    <tr class="role-header">
                                        <th style="width: 45%">@localize('Key')</th>
                                        <th style="width: 45%">@localize('Label')</th>
                                        <th style="width: 10%">
                                            <button class="btn btn-success bg-success btn-sm" id="addNewLocalRow"
                                                type="button">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
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


    @push('lib-styles')
        <link rel="stylesheet" href="{{ assets('vendor/yajra-laravel-datatables/assets/datatables.css') }}">
    @endpush


    @push('lib-scripts')
        <script src="{{ assets('vendor/yajra-laravel-datatables/assets/datatables.js') }}"></script>
    @endpush


    @push('js')
    <script src="{{ assets('js/datatables.active.min.js') }}"></script>
    <script src="{{ assets('js/setting/language-build.min.js') }}"></script>
    @endpush
</x-app-layout>
