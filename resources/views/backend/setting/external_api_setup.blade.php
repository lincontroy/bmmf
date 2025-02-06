<x-app-layout>
    <x-setting activeMenu="external-api-setup" activeMenuTitle="{{ localize('external-api-setup') }}">
        <div class="card-body px-4 px-xl-5">
            <table class="table table-bordered table-hover">
                <thead>
                    <th>{{ localize('sl') }}</th>
                    <th>{{ localize('name') }}</th>
                    <th class="text-center">{{ localize('action') }}</th>
                </thead>
                <tbody>
                    @foreach ($externalApi as $key => $item)
                        @php
                            $arrData = json_decode($item->data);
                        @endphp
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $item->name }}</td>
                            <td class="text-center">
                                <a href="javascript:void(0);" class="btn btn-primary btn-sm text-white updateExternalApi"
                                    data-toggle="tooltip" data-placement="left" title="Update"
                                    create-link="{{ $arrData->create_link }}"
                                    data-action="{{ route('admin.setting.external_api_setup_update_submit', ['id' => $item->id]) }}"
                                    data-route="{{ route('admin.setting.external_api_setup_update', ['id' => $item->id]) }}"><i
                                        class="fa fa-cog" aria-hidden="true"></i> {{ localize('setup') }}</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="modal fade" id="externalApi" tabindex="-1" aria-labelledby="externalApiLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content radius-35">
                    <div class="modal-header p-4">
                        <h5 class="modal-title text-color-5 fs-20 fw-medium" id="modelLabel">
                            {{ localize('fess settings') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 pt-2">
                        <form action="#" method="post" class="needs-validation" data="showCallBackData"
                            id="externalApi-form" novalidate="" data-insert="#" enctype="multipart/form-data"
                            data-resetvalue="false">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                            for="name">{{ localize('name') }} <span class="text-danger">*</span>
                                        </label>
                                        <input readonly type="text" name="name" id="name"
                                            value="{{ old('name') }}"
                                            class="bg-transparent custom-form-control form-control @error('name') is-invalid @enderror"
                                            placeholder="{{ localize('enter name') }}" required />
                                        <div class="invalid-feedback" role="alert">
                                            @error('name')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                            for="api_key">{{ localize('api_key') }} <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="api_key" id="api_key"
                                            value="{{ old('api_key') }}"
                                            class="bg-transparent custom-form-control form-control @error('api_key') is-invalid @enderror"
                                            placeholder="{{ localize('api_key') }}" required />
                                        <div class="invalid-feedback" role="alert">
                                            @error('api_key')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <input type="hidden" name="url" id="url" value="{{ old('url') }}"
                                            class="bg-transparent custom-form-control form-control @error('url') is-invalid @enderror"
                                            placeholder="{{ localize('url') }}" required />
                                        <span class="text-success"><a class="create_link" target="_blank">Get Your API
                                                Key</a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-row gap-3">
                                <button type="reset" class="btn btn-reset py-2 resetBtn w-25"
                                    title="{{ localize('Reset') }}">
                                    <i class="fa fa-undo-alt"></i>
                                </button>
                                <button type="submit" class="actionBtn btn btn-save py-2 w-75"
                                    id="feeSettingFormActionBtn">{{ localize('update') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-setting>
    @push('js')
        <script src="{{ assets('js/setting/commission.js') }}"></script>
    @endpush
</x-app-layout>
