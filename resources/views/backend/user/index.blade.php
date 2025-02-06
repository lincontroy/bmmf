@php
    use App\Enums\PermissionMenuEnum;
    use App\Enums\PermissionActionEnum;
@endphp
<x-app-layout>
    <div class="row gy-4">
        <div class="col-12">
            <div class="card py-4 px-3 radius-15">
                <div class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center mb-3">
                    <h3 class="fs-24 mb-0 text-color-2 fw-medium lh-1">{{ localize('User') }}</h3>
                    @if ($_auth_user->can(PermissionMenuEnum::MANAGES_USER->value . '.' . PermissionActionEnum::CREATE->value))
                        <div class="d-flex align-items-center gap-2">
                            <div class="border radius-10 p-1">
                                <button id="add-user-button" data-bs-toggle="modal" data-bs-target="#addUser"
                                    class="btn btn-save lh-sm">
                                    <span class="me-1">{{ localize('Add New') }}</span><svg width="12"
                                        height="12" viewBox="0 0 12 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 6H11M6 1V11" stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif

                </div>

                <!-- Data table -->
                <x-data-table :dataTable="$dataTable" />
                <!-- Data table -->

            </div>
        </div>
    </div>

    <div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content radius-35">
                <div class="modal-header p-4">
                    <h5 class="modal-title text-color-5 fs-20 fw-medium" id="modelLabel">{{ localize('Create User') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-2">
                    <form action="{{ route('admin.user.store') }}" method="post" class="needs-validation"
                        data="showCallBackData" id="user-form" novalidate=""
                        data-insert="{{ route('admin.user.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="first_name">{{ localize('First Name') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="first_name" id="first_name"
                                        value="{{ old('first_name') }}"
                                        class="custom-form-control  form-control @error('first_name') is-invalid @enderror"
                                        placeholder="{{ localize('enter user first name') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('first_name')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="last_name">{{ localize('Last Name') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="last_name" id="last_name"
                                        value="{{ old('last_name') }}"
                                        class="custom-form-control  form-control @error('last_name') is-invalid @enderror"
                                        placeholder="{{ localize('enter user last name') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('last_name')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="email">{{ localize('Email') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                                        class="custom-form-control  form-control @error('email') is-invalid @enderror"
                                        placeholder="{{ localize('enter user email') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('email')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="password">{{ localize('Password') }}<span class="text-danger"
                                            id="password_required">*</span> </label>
                                    <input type="password" name="password" id="password" value="{{ old('password') }}"
                                        class="custom-form-control  form-control @error('password') is-invalid @enderror"
                                        placeholder="{{ localize('password') }}" required />
                                    <div class="invalid-feedback" role="alert">
                                        @error('password')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="role_id">{{ localize('Role') }}</label>
                                    <select name="role_id[]" id="role_id"
                                        class="custom-form-control placeholder-single @error('role_id') is-invalid @enderror"
                                        data-placeholder="{{ localize('Role') }}" data-fieldname="roles"
                                        data-fieldid="id" multiple>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" role="alert">
                                        @error('role_id')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                        for="image">{{ localize('Image') }}</label>
                                    <input type="file" name="image" id="image" accept="image/*"
                                        class="custom-form-control file-preview  @error('image') is-invalid @enderror"
                                        data-previewDiv="preview_file_image" />
                                    <span class="text-color-1 fs-16 fw-medium">{{ localize('Recommended Pixel') }} (60
                                        x 60)</span>
                                    <div class="mb-3 p-2 radius-10 w-max-content" id="preview_file_image">
                                    </div>
                                    <div class="invalid-feedback" role="alert">
                                        @error('image')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="mb-1 text-black fs-25 fw-medium">{{ localize('Permission') }} </h3>
                                </div>
                                <hr class="my-2" />

                                @include('backend.partial.permission_group')

                            </div>
                        </div>
                        <div class="d-flex flex-row gap-3">
                            <button type="reset" class="btn btn-reset py-2 resetBtn w-25"
                                title="{{ localize('Reset') }}">
                                <i class="fa fa-undo-alt"></i>
                            </button>
                            <button type="submit" class="actionBtn btn btn-save py-2 w-75"
                                id="userFormActionBtn">{{ localize('Create') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ assets('js/setting/user.min.js') }}"></script>
    @endpush
</x-app-layout>
