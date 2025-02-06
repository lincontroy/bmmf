<x-app-layout>
    <div class="card shadow-none radius-15">
        <div class="card-body px-4 px-xl-5">
            <div class="row gy-4 justify-content-center">
                <div class="col-xl-10">
                    <div class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center mb-3">
                        <h3 class="fs-24 mb-0 text-color-2 fw-medium lh-1">{{ localize('account_settings') }}</h3>
                    </div>
                    <form action="{{ route('admin.update-account-setting', ['id' => auth()->user()->id]) }}"
                        method="post" class="needs-validation" data="showCallBackData" id="app-setting-form"
                        data-resetvalue="false" novalidate="" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                                for="first_name">{{ localize('first_name') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="first_name" id="first_name"
                                                value="{{ old('first_name', $user->first_name ?? null) }}"
                                                class="custom-form-control bg-transparent  @error('first_name') is-invalid @enderror"
                                                placeholder="{{ localize('first_name') }}" />
                                            <div class="invalid-feedback" role="alert">
                                                @error('first_name')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                                for="last_name">{{ localize('last_name') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="last_name" id="last_name"
                                                value="{{ old('last_name', $user->last_name ?? null) }}"
                                                class="custom-form-control bg-transparent @error('last_name') is-invalid @enderror"
                                                placeholder="{{ localize('last_name') }}" />
                                            <div class="invalid-feedback" role="alert">
                                                @error('last_name')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                                for="email">{{ localize('email') }} <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="email" id="email"
                                                value="{{ old('email', $user->email ?? null) }}"
                                                class="custom-form-control bg-transparent @error('email') is-invalid @enderror"
                                                placeholder="{{ localize('email') }}" />
                                            <div class="invalid-feedback" role="alert">
                                                @error('email')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                                for="password">{{ localize('password') }}</label>
                                            <input type="password" name="password" id="password" value=""
                                                class="custom-form-control bg-transparent @error('password') is-invalid @enderror"
                                                placeholder="{{ localize('password') }}" />
                                            <div class="invalid-feedback" role="alert">
                                                @error('password')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3">
                                        <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                            for="about">{{ localize('about') }}</label>
                                        <textarea name="about" id="about" class="custom-form-control bg-transparent"
                                            placeholder="{{ localize('about') }}">{{ $user->about }}</textarea>
                                        <div class="invalid-feedback" role="alert">
                                            @error('about')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3">
                                        <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                            for="image">{{ localize('image') }}</label>

                                        <div class="border-all mb-3 p-2 radius-10 w-max-content "
                                            id="preview_file_logo">
                                            <img width="80" class="preview_image"
                                                @if ($user->image) src="{{ storage_asset($user->image) }}"
                                                 @else src="{{ assets('img/noimage.jpg') }}" @endif
                                                alt="{{ localize('image') }}">
                                        </div>
                                        <div class="custom-file-button position-relative mb-3">
                                            <input type="file" name="image" id="image" accept="image/*"
                                                class="custom-form-control file-preview "
                                                data-previewDiv="preview_file_logo">
                                            <input type="hidden" name="old_photo"
                                                value="{{ storage_asset($user->image) }}">
                                        </div>
                                        <span class="fs-16 fw-medium text-warning">{{ localize('Recommended Pixel') }}
                                            (150 x 150)</span>
                                        <div class="invalid-feedback" role="alert">
                                            @error('image')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-2 row justify-content-end">
                                <button type="reset" class="btn btn-reset w-auto resetBtn">
                                    <i class="fa fa-undo-alt"></i>
                                </button>
                                <button class="btn btn-save ms-3 w-auto actionBtn"
                                    type="submit">{{ localize('Update') }}</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    @push('js')
        <script src="{{ assets('js/account_setting.js?v=1') }}"></script>
    @endpush
</x-app-layout>
