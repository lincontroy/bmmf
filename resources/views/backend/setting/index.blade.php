<x-app-layout>
    <x-setting activeMenu="application-setting" activeMenuTitle="{{ localize('Application Setting') }}">
        <div class="card-body px-4 px-xl-5">
            <div class="mb-3">
                <label class="col-form-label text-start text-black fs-16 fw-medium">
                    {{ localize('cron_job') }} ({{ localize('set_below_command_for_every_minute') }})
                </label>
                <div class="position-relative">
                    <input class="custom-form-control bg-copy-box border-dotted py-4 mb-2 affiliate-url" type="text"
                        value="wget -q -O - {{ url('cronjob/start') }}">
                    <button class="btn-copy copy-value" data-copyvalue="wget -q -O - {{ url('cronjob/start') }}">
                        <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M6.52613 2.98673C6.03155 3.06298 5.76964 3.20245 5.58309 3.41637C5.39654 3.63028 5.27492 3.93062 5.20842 4.49777C5.13997 5.0816 5.1389 5.85538 5.1389 6.96485V10.8295C5.1389 11.9389 5.13997 12.7127 5.20842 13.2965C5.27492 13.8637 5.39654 14.164 5.5831 14.3779C5.76964 14.5918 6.03155 14.7313 6.52613 14.8076C7.03526 14.8861 7.71004 14.8873 8.67756 14.8873H10.6996C11.6672 14.8873 12.3419 14.8861 12.851 14.8076C13.3456 14.7313 13.6075 14.5918 13.7941 14.3779C13.9807 14.164 14.1023 13.8637 14.1688 13.2965C14.2372 12.7127 14.2383 11.9389 14.2383 10.8295V6.96485C14.2383 5.85538 14.2372 5.0816 14.1688 4.49777C14.1023 3.93062 13.9807 3.63029 13.7941 3.41637C13.6075 3.20245 13.3456 3.06298 12.851 2.98673C12.3419 2.90824 11.6672 2.907 10.6996 2.907H8.67756C7.71004 2.907 7.03526 2.90824 6.52613 2.98673ZM8.64057 1.74762H10.7366C11.6584 1.7476 12.4014 1.74759 12.9858 1.83768C13.5925 1.93122 14.1033 2.13133 14.509 2.59656C14.9147 3.06179 15.0892 3.64757 15.1708 4.34328C15.2494 5.01338 15.2494 5.86539 15.2493 6.92243V10.8719C15.2494 11.9289 15.2494 12.7809 15.1708 13.451C15.0892 14.1467 14.9147 14.7325 14.509 15.1977C14.1033 15.663 13.5925 15.8631 12.9858 15.9566C12.4014 16.0467 11.6584 16.0467 10.7366 16.0467H8.64056C7.71877 16.0467 6.97577 16.0467 6.39141 15.9566C5.78471 15.8631 5.27388 15.663 4.86817 15.1977C4.46247 14.7325 4.28796 14.1467 4.20639 13.451C4.12783 12.7809 4.12784 11.9289 4.12785 10.8719V6.92243C4.12784 5.86539 4.12783 5.01338 4.20639 4.34329C4.28796 3.64757 4.46247 3.06179 4.86818 2.59656C5.27388 2.13133 5.78471 1.93122 6.39141 1.83768C6.97578 1.74759 7.71877 1.7476 8.64057 1.74762Z"
                                fill="#0060FF"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M2.95708 2.84837C3.30347 2.52127 3.77789 2.3252 4.60134 2.22065L2.95708 2.84837ZM2.95708 2.84837C2.6107 3.17549 2.40308 3.62351 2.29237 4.40114C2.17929 5.19544 2.17798 6.24249 2.17798 7.71632V12.3539C2.17798 13.3143 3.00247 14.0929 4.01953 14.0929V15.2523C2.32445 15.2523 0.950287 13.9547 0.950287 12.3539L0.950287 7.67271C0.950274 6.25227 0.950264 5.12718 1.07562 4.24665C1.20464 3.34046 1.47646 2.607 2.08897 2.02857C2.70148 1.45015 3.47816 1.19344 4.43775 1.07161C5.37015 0.953225 6.56154 0.953235 8.06568 0.953247L11.3857 0.953248C13.0809 0.953248 14.455 2.25094 14.455 3.85171L14.0578 3.33642C14.0578 2.37596 12.4028 2.11263 11.3857 2.11263H8.11186C6.55119 2.11263 5.44244 2.11386 4.60134 2.22065"
                                fill="#0060FF"></path>
                        </svg>
                        <span> Copy</span>
                    </button>
                </div>
            </div>

            <form action="{{ route('admin.setting.update') }}" method="post" class="needs-validation"
                data="showCallBackData" id="app-setting-form" novalidate="" data-resetvalue="false"
                enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="mb-3">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                for="title">{{ localize('Application Title') }}<span class="text-danger">*</span>
                            </label>
                            <input type="text" name="title" id="title"
                                value="{{ old('title', $setting->title ?? null) }}"
                                class="custom-form-control @error('title') is-invalid @enderror"
                                placeholder="{{ localize('enter application title') }}" required />
                            <div class="invalid-feedback" role="alert">
                                @error('title')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                for="email">{{ localize('Email Address') }}</label>
                            <input type="email" name="email" id="email"
                                value="{{ old('email', $setting->email ?? null) }}"
                                class="custom-form-control @error('email') is-invalid @enderror"
                                placeholder="example@domain.com" />
                            <div class="invalid-feedback" role="alert">
                                @error('email')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                for="language_id">{{ localize('Language') }}</label>
                            <select name="language_id" id="language_id" data-allowClear="true"
                                data-placeholder="{{ localize('Language') }}"
                                class="custom-form-control placeholder-single @error('language_id') is-invalid @enderror">
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
                                for="site_align">{{ localize('Admin Align') }}</label>
                            <select name="site_align" id="site_align"
                                class="custom-form-control placeholder-single @error('site_align') is-invalid @enderror">
                                @foreach ($siteAligns as $siteAlign)
                                    <option value="{{ $siteAlign }}" @selected($siteAlign === ($setting->site_align ?? null))>
                                        {{ $siteAlign }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" role="alert">
                                @error('site_align')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                for="footer_text">{{ localize('Footer Text') }}</label>
                            <input type="text" name="footer_text" id="footer_text"
                                value="{{ old('footer_text', $setting->footer_text ?? null) }}"
                                class="custom-form-control @error('footer_text') is-invalid @enderror"
                                placeholder="{{ date('Y') }} © {{ localize('Copyright') }} {{ $setting->title ?? null }}" />
                            <div class="invalid-feedback" role="alert">
                                @error('footer_text')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                for="logo">{{ localize('Logo') }}</label>
                            <div class="border-all mb-3 p-2 radius-10 w-max-content " id="preview_file_logo">
                                <img class="preview_image"
                                    src="{{ $setting->logo ?? null ? storage_asset($setting->logo) : assets('img/logo-1.png') }}"
                                    alt="{{ localize('Logo') }}" />
                            </div>
                            <div class="custom-file-button position-relative mb-3">
                                <input type="file" name="logo" id="logo" accept="image/*"
                                    class="custom-form-control file-preview @error('logo') is-invalid @enderror"
                                    data-previewDiv="preview_file_logo" />
                                <input type="hidden" name="old_logo" value="{{ $setting->logo ?? null }}" />
                            </div>
                            <span class="text-color-1 fs-16 fw-medium">{{ localize('Recommended Pixel') }} (150 x
                                45)</span>
                            <div class="invalid-feedback" role="alert">
                                @error('logo')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                for="login_bg_img">{{ localize('Login BG Image') }}</label>
                            <div class="border-all mb-3 p-2 radius-10 w-max-content" id="preview_file_login_bg_img">
                                <img width="80" height="50" class="preview_image"
                                    src="{{ $setting->login_bg_img ? storage_asset($setting->login_bg_img) : assets('img/login-bg.png') }}"
                                    alt="{{ localize('login_bg_img') }}" />
                            </div>
                            <div class="custom-file-button position-relative mb-3">
                                <input type="file" name="login_bg_img" id="login_bg_img" accept="image/*"
                                    class="custom-form-control file-preview  @error('login_bg_img') is-invalid @enderror"
                                    data-previewDiv="preview_file_login_bg_img" />
                                <input type="hidden" name="old_login_bg_img"
                                    value="{{ $setting->login_bg_img ?? null }}" />
                            </div>
                            <div class="invalid-feedback" role="alert">
                                @error('login_bg_img')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="mb-3">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                for="description">{{ localize('Address') }}</label>
                            <input type="text" name="description" id="description"
                                value="{{ old('description', $setting->description ?? null) }}"
                                class="custom-form-control @error('description') is-invalid @enderror"
                                placeholder="{{ localize('Address') }}" />
                            <div class="invalid-feedback" role="alert">
                                @error('description')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                for="phone">{{ localize('Phone') }}</label>
                            <input type="text" name="phone" id="phone"
                                value="{{ old('phone', $setting->phone ?? null) }}"
                                class="custom-form-control @error('phone') is-invalid @enderror"
                                placeholder="{{ localize('Phone') }}" />
                            <div class="invalid-feedback" role="alert">
                                @error('phone')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                for="time_zone">{{ localize('Time Zone') }} * </label>
                            <select name="time_zone" id="time_zone"
                                class="custom-form-control placeholder-single @error('time_zone') is-invalid @enderror"
                                required>
                                <option value="USA" @selected('USA' === ($setting->site_align ?? null))>USA</option>
                                <option value="UK" @selected('UK' === ($setting->site_align ?? null))>UK</option>
                            </select>
                            <div class="invalid-feedback" role="alert">
                                @error('time_zone')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                for="office_time">{{ localize('Office Time') }}</label>
                            <input type="text" name="office_time" id="office_time"
                                value="{{ old('office_time', $setting->office_time ?? null) }}"
                                class="custom-form-control @error('office_time') is-invalid @enderror"
                                placeholder="{{ localize('Office Time') }}" />
                            <div class="invalid-feedback" role="alert">
                                @error('office_time')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                for="latitude_longitude">{{ localize('Latitude, Longitude') }}</label>
                            <input type="text" name="latitude_longitude" id="latitude_longitude"
                                value="{{ old('latitude_longitude', $setting->latitude_longitude ?? null) }}"
                                class="custom-form-control @error('latitude_longitude') is-invalid @enderror"
                                placeholder="{{ localize('Latitude, Longitude') }}" />
                            <div class="invalid-feedback" role="alert">
                                @error('latitude_longitude')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                for="favicon">{{ localize('Fav Icon') }}</label>
                            <div class="border-all mb-3 p-2 radius-10 w-max-content" id="preview_file_favicon">
                                <img class="preview_image"
                                    src="{{ $setting->favicon ? storage_asset($setting->favicon) : assets('img/favicon.png') }}"
                                    alt="Favicon" />
                            </div>
                            <div class="custom-file-button position-relative mb-3">
                                <input type="file" name="favicon" id="favicon" accept="image/*"
                                    class="custom-form-control file-preview  @error('favicon') is-invalid @enderror"
                                    data-previewDiv="preview_file_favicon" />
                                <input type="hidden" name="old_favicon" value="{{ $setting->favicon ?? null }}" />
                            </div>
                            <span class="text-color-1 fs-16 fw-medium">{{ localize('Recommended Pixel') }} (60 x
                                60)</span>
                            <div class="invalid-feedback" role="alert">
                                @error('favicon')
                                    {{ $message }}
                                @enderror
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
    </x-setting>

    @push('lib-styles')
        <link href="{{ assets('vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
        <link href="{{ assets('vendor/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet" />
    @endpush

    @push('lib-scripts')
        <script src="{{ assets('vendor/select2/dist/js/select2.min.js') }}"></script>
        <script src="{{ assets('js/pages/app.select2.js') }}"></script>
    @endpush

    @push('js')
        <script src="{{ assets('js/setting/index.min.js') }}"></script>
    @endpush
</x-app-layout>
