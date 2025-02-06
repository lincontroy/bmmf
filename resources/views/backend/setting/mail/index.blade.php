@php
    use App\Enums\SiteAlignEnum;

@endphp
<x-app-layout>
    <x-setting activeMenu="email-gateway" activeMenuTitle="{{ localize('Email Gateway Setting') }}">

        <div class="card-body px-4 px-xl-5">
            <form action="{{ route('admin.setting.email.update') }}" method="post" class="needs-validation"
                data="showCallBackData" id="email-setting-form" novalidate="" enctype="multipart/form-data"
                data-resetvalue="false">
                @csrf
                @method('patch')
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="mb-3">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                for="MAIL_MAILER">{{ localize('Mail Mailer') }}<span class="text-danger">*</span>
                            </label>
                            <select name="MAIL_MAILER" id="MAIL_MAILER"
                                class="custom-form-control placeholder-single @error('MAIL_MAILER') is-invalid @enderror"
                                required>
                                @foreach ($mailMailers as $mailMailer)
                                    <option value="{{ $mailMailer }}" @selected($mailMailer === $data['MAIL_MAILER'])>{{ $mailMailer }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" role="alert">
                                @error('MAIL_MAILER')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                for="MAIL_HOST">{{ localize('Mail Host') }}</label>
                            <input type="text" name="MAIL_HOST" id="MAIL_HOST"
                                value="{{ old('MAIL_HOST', $data['MAIL_HOST'] ?? null) }}"
                                class="custom-form-control  form-control @error('MAIL_HOST') is-invalid @enderror"
                                placeholder="{{ localize('enter mail host') }}" />
                            <div class="invalid-feedback" role="alert">
                                @error('MAIL_HOST')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                for="MAIL_PORT">{{ localize('Mail Port') }}</label>
                            <input type="number" name="MAIL_PORT" id="MAIL_PORT"
                                value="{{ old('MAIL_PORT', $data['MAIL_PORT'] ?? null) }}"
                                class="custom-form-control  form-control @error('MAIL_PORT') is-invalid @enderror"
                                placeholder="{{ localize('enter mail port number') }}" />
                            <div class="invalid-feedback" role="alert">
                                @error('MAIL_PORT')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                for="MAIL_USERNAME">{{ localize('Mail Username') }}</label>
                            <input type="text" name="MAIL_USERNAME" id="MAIL_USERNAME"
                                value="{{ old('MAIL_USERNAME', $data['MAIL_USERNAME'] ?? null) }}"
                                class="custom-form-control  form-control @error('MAIL_USERNAME') is-invalid @enderror"
                                placeholder="{{ localize('enter mail username') }}" />
                            <div class="invalid-feedback" role="alert">
                                @error('MAIL_USERNAME')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="mb-3">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                for="MAIL_PASSWORD">{{ localize('Mail Password') }}</label>
                            <input type="password" name="MAIL_PASSWORD" id="MAIL_PASSWORD"
                                value="{{ old('MAIL_PASSWORD', $data['MAIL_PASSWORD'] ?? null) }}"
                                class="custom-form-control  form-control @error('MAIL_PASSWORD') is-invalid @enderror"
                                placeholder="{{ localize('enter mail password') }}" />
                            <div class="invalid-feedback" role="alert">
                                @error('MAIL_PASSWORD')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                for="MAIL_FROM_ADDRESS">{{ localize('Sender Email Address') }}</label>
                            <input type="text" name="MAIL_FROM_ADDRESS" id="MAIL_FROM_ADDRESS"
                                value="{{ old('MAIL_FROM_ADDRESS', $data['MAIL_FROM_ADDRESS'] ?? null) }}"
                                class="custom-form-control  form-control @error('MAIL_FROM_ADDRESS') is-invalid @enderror"
                                placeholder="{{ localize('enter sender mail address') }}" />
                            <div class="invalid-feedback" role="alert">
                                @error('MAIL_FROM_ADDRESS')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                for="MAIL_FROM_NAME">{{ localize('Sender Name') }}</label>
                            <input type="text" name="MAIL_FROM_NAME" id="MAIL_FROM_NAME"
                                value="{{ old('MAIL_FROM_NAME', $data['MAIL_FROM_NAME'] ?? null) }}"
                                class="custom-form-control  form-control @error('MAIL_FROM_NAME') is-invalid @enderror"
                                placeholder="{{ localize('enter sender name') }}" />
                            <div class="invalid-feedback" role="alert">
                                @error('MAIL_FROM_NAME')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                for="MAIL_ENCRYPTION">{{ localize('Admin Align') }}</label>
                            <select name="MAIL_ENCRYPTION" id="MAIL_ENCRYPTION"
                                class="custom-form-control placeholder-single @error('MAIL_ENCRYPTION') is-invalid @enderror">
                                <option @selected($data['MAIL_ENCRYPTION'] == 'ssl') value="ssl">SSL</option>
                                <option @selected($data['MAIL_ENCRYPTION'] == 'tls') value="tls">TLS</option>
                            </select>
                            <div class="invalid-feedback" role="alert">
                                @error('MAIL_ENCRYPTION')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-2 row justify-content-end">
                        <button type="reset" class="btn btn-reset w-auto resetBtn"
                            title="{{ localize('Reset') }}">
                            <i class="fa fa-undo-alt"></i>
                        </button>
                        <button class="btn btn-save ms-3 w-auto actionBtn"
                            type="submit">{{ localize('Update') }}</button>
                    </div>
                </div>
            </form>

            <h3 class="pt-5 mb-4 text-black fs-25 fw-medium">{{ localize('Test Your Email Server') }}</h3>

            <form action="{{ route('admin.setting.email.send') }}" method="post" class="needs-validation"
                data="showCallBackDataForSendMail" id="send-mail-form" novalidate="" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="mb-3">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                for="mail_to">{{ localize('To') }}<span class="text-danger">*</span></label>
                            <input type="text" name="mail_to" id="mail_to" value=""
                                class="custom-form-control  form-control @error('mail_to') is-invalid @enderror"
                                placeholder="{{ localize('enter mail to') }}" required />
                            <div class="invalid-feedback" role="alert">
                                @error('mail_to')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="mb-3">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                for="mail_subject">{{ localize('Subject') }} <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="mail_subject" id="mail_subject" value=""
                                class="custom-form-control  form-control @error('mail_subject') is-invalid @enderror"
                                placeholder="{{ localize('enter mail subject') }}" required />
                            <div class="invalid-feedback" role="alert">
                                @error('mail_subject')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                for="mail_message">{{ localize('Message') }} <span
                                    class="text-danger">*</span></label>
                            <textarea name="mail_message" id="mail_message" value="{{ old('mail_message', $data['mail_message'] ?? null) }}"
                                class="custom-form-control  form-control @error('mail_message') is-invalid @enderror"
                                placeholder="{{ localize('enter mail message') }}" required></textarea>
                            <div class="invalid-feedback" role="alert">
                                @error('mail_message')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-2 row justify-content-end">
                        <button type="reset" class="btn btn-reset w-auto resetBtn"
                            title="{{ localize('Reset') }}">
                            <i class="fa fa-undo-alt"></i>
                        </button>
                        <button class="btn btn-save ms-3 w-auto actionBtn"
                            type="submit">{{ localize('Send') }}</button>
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
        <script src="{{ assets('js/setting/email.min.js') }}"></script>
    @endpush
</x-app-layout>
