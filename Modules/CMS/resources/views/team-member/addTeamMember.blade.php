@php
    use App\Enums\StatusEnum;
@endphp

<div class="modal fade" id="addTeamMemberContent" tabindex="-1" aria-labelledby="addTeamMemberContentLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content radius-35">
            <div class="modal-header p-4">
                <h5 class="modal-title text-color-5 fs-20 fw-medium" id="modelContentLabel">
                    {{ localize('Create Merchant Content') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 pt-2">
                <form action="{{ route('admin.cms.team-member.content.store') }}" method="post"
                    class="needs-validation" data="showContentCallBackData" id="team-member-content-form"
                    novalidate="" data-insert="{{ route('admin.cms.team-member.content.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="name">{{ localize('Name') }} <span
                                        class="text-danger">*</span>
                                </label>
                                <input type="text" name="name" id="name"
                                    value="{{ old('name') }}"
                                    class="custom-form-control form-control @error('name') is-invalid @enderror"
                                    placeholder="{{ localize('enter name') }}" required />
                                <div class="invalid-feedback" role="alert">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                    for="designation">{{ localize('Designation') }} <span
                                        class="text-danger">*</span>
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
                                    for="avatar">{{ localize('Image') }} <span id="image_required_div"
                                        class="text-danger">*</span>
                                </label>
                                <div class="" id="preview_file_image">
                                </div>
                                <div class="custom-file-button position-relative mb-3">
                                    <input type="file" name="avatar" id="avatar" accept="image/*"
                                        class="custom-form-control file-preview @error('avatar') is-invalid @enderror"
                                        data-previewDiv="preview_file_image" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('avatar')
                                            {{ $message }}
                                        @enderror
                                    </div>
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
                            id="teamMemberContentFormActionBtn">{{ localize('Create') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
