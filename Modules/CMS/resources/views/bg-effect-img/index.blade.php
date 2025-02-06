<x-app-layout>
    <div class="row gy-4">
        <div class="col-12">
            <div class="card py-4 px-3 radius-15">
                <div class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center mb-3">
                    <h3 class="fs-24 mb-0 text-color-2 fw-medium lh-1">{{ localize('BG Effect Images') }}</h3>
                </div>

                <!-- Data table -->
                <div class="card-body px-4 px-xl-5">
                    <!-- Data table -->
                    <div class="table-responsive">
                        <table class="table display table-bordered table-striped table-hover" id="backup-table">
                            <thead>
                                <tr>
                                    <th>{{ localize('SL') }}</th>
                                    <th>{{ localize('Image') }}</th>
                                    <th>{{ localize('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bgEffectImg->articleData as $articleData)
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <th>
                                            <img src="{{ storage_asset($articleData->content) }}" width="100"
                                                height="100" alt="" />
                                        </th>
                                        <th>
                                            <a href="javascript:void(0);"
                                                class="btn btn-info-soft btn-sm m-1 edit-bg-image-button"
                                                title="{{ localize('Edit') }}"
                                                data-action="{{ route('admin.cms.bg-image.update', ['article_id' => $articleData->article_id, 'slug' => $articleData->slug]) }}"
                                                data-route="{{ route('admin.cms.bg-image.edit', ['article_id' => $articleData->article_id, 'slug' => $articleData->slug]) }}">
                                                <i class="fa fa-edit"></i></a>
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Data table -->
                </div>
                <!-- Data table -->

            </div>
        </div>
    </div>

    <div class="modal fade" id="updateBgEffectImg" tabindex="-1" aria-labelledby="updateBgEffectImgLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content radius-35">
                <div class="modal-header p-4">
                    <h5 class="modal-title text-color-5 fs-20 fw-medium" id="modelLabel">
                        {{ localize('Update BG Image') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-2">
                    <form action="#" method="post" class="needs-validation" data="showCallBackData"
                        id="bg-image-form" novalidate="" data-insert="#" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="mb-3">
                                    <div class="" id="preview_file_image">
                                    </div>

                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="image">{{ localize('Image') }} <span class="text-danger">*</span>
                                    </label>
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
                        </div>
                        <div class="d-flex flex-row gap-3">
                            <button type="reset" class="btn btn-reset py-2 resetBtn w-25"
                                title="{{ localize('Reset') }}">
                                <i class="fa fa-undo-alt"></i>
                            </button>
                            <button type="submit" class="actionBtn btn btn-save py-2 w-75"
                                id="formActionBtn">{{ localize('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ module_asset('CMS', 'js/bg-effect-img.js') }}"></script>
    @endpush
</x-app-layout>
