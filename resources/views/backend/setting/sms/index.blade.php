@php
    use App\Enums\SiteAlignEnum;

@endphp
<x-app-layout>
    <x-setting activeMenu="sms-gateway" activeMenuTitle="{{ localize('Sms Gateway Setting') }}">
        <div class="card-body px-4 px-xl-5">
            <form action="{{ route('admin.setting.sms.update') }}" method="post" class="needs-validation"
                data="showCallBackData" id="sms-setting-form" novalidate="" data-resetvalue="false"
                enctype="multipart/form-data">
                @csrf
                @method('patch')
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                for="TWILIO_SID">{{ localize('Twilo SID') }} </label>
                            <input type="text" name="TWILIO_SID" id="TWILIO_SID"
                                value="{{ old('TWILIO_SID', $data['TWILIO_SID'] ?? null) }}"
                                class="custom-form-control  form-control @error('TWILIO_SID') is-invalid @enderror"
                                placeholder="{{ localize('enter twilo sid') }}" />
                            <div class="invalid-feedback" role="alert">
                                @error('TWILIO_SID')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                for="TWILIO_AUTH_TOKEN">{{ localize('Twilo Token') }} </label>
                            <input type="password" name="TWILIO_AUTH_TOKEN" id="TWILIO_AUTH_TOKEN"
                                value="{{ old('TWILIO_AUTH_TOKEN', $data['TWILIO_AUTH_TOKEN'] ?? null) }}"
                                class="custom-form-control  form-control @error('TWILIO_AUTH_TOKEN') is-invalid @enderror"
                                placeholder="{{ localize('enter twilo token') }}" />
                            <div class="invalid-feedback" role="alert">
                                @error('TWILIO_AUTH_TOKEN')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                for="TWILIO_NUMBER">{{ localize('Twilo Number') }}</label>
                            <input type="text" name="TWILIO_NUMBER" id="TWILIO_NUMBER"
                                value="{{ old('TWILIO_NUMBER', $data['TWILIO_NUMBER'] ?? null) }}"
                                class="custom-form-control  form-control @error('TWILIO_NUMBER') is-invalid @enderror"
                                placeholder="{{ localize('enter twilo number') }}" />
                            <div class="invalid-feedback" role="alert">
                                @error('TWILIO_NUMBER')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-2 row justify-content-end">
                        <button type="reset" class="btn btn-reset w-auto resetBtn" title="{{ localize('Reset') }}">
                            <i class="fa fa-undo-alt"></i>
                        </button>
                        <button class="btn btn-save ms-3 w-auto actionBtn"
                            type="submit">{{ localize('Update') }}</button>
                    </div>
                </div>
            </form>

            <h3 class="pt-5 mb-4 text-black fs-25 fw-medium">{{ localize('Test Your SMS') }}</h3>

            <form action="{{ route('admin.setting.sms.send') }}" method="post" class="needs-validation"
                data="showCallBackDataForSendSMS" id="send-sms-form" novalidate="" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                for="sms_number">{{ localize('To') }}
                                <span class="text-danger">*</span></label>
                            <input type="text" name="sms_number" id="sms_number" value=""
                                class="custom-form-control  form-control @error('sms_number') is-invalid @enderror"
                                placeholder="{{ localize('enter sms number') }}" required />
                            <div class="invalid-feedback" role="alert">
                                @error('sms_number')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                for="sms_message">{{ localize('Message') }} <span class="text-danger">*</span></label>
                            <textarea name="sms_message" id="sms_message" value="{{ old('sms_message', $data['sms_message'] ?? null) }}"
                                class="custom-form-control  form-control @error('sms_message') is-invalid @enderror"
                                placeholder="{{ localize('enter sms message') }}" required></textarea>
                            <div class="invalid-feedback" role="alert">
                                @error('sms_message')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-2 row justify-content-end">
                        <button type="reset" class="btn btn-reset w-auto resetBtn" title="{{ localize('Reset') }}">
                            <i class="fa fa-undo-alt"></i>
                        </button>
                        <button class="btn btn-save ms-3 w-auto actionBtn"
                            type="submit">{{ localize('Send') }}</button>
                    </div>
                </div>
            </form>

        </div>
    </x-setting>

    @push('js')
        <script src="{{ assets('js/setting/sms.min.js') }}"></script>
    @endpush
</x-app-layout>
