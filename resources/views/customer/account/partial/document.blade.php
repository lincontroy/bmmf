@php
    use App\Enums\CustomerDocumentTypeEnum;

@endphp
<div id="tab-document" role="tabpanel" class="content" aria-labelledby="stepper1trigger2">
    <h5 class="mb-4 fs-20 fw-semi-bold">{{ localize('Upload Document') }}</h5>
    <div class="row gy-3 mb-4">
        <div class="col-lg-6 col-xl-4">
            <label class="radio-card w-100">
                <input name="document_type" value="{{ CustomerDocumentTypeEnum::PASSPORT->value }}" class="radio"
                    type="radio" checked required />
                <div class="doc-card">
                    <div class="align-items-center d-flex flex-column gap-2 justify-content-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-e-passport">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M2 5m0 2a2 2 0 0 1 2 -2h16a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-16a2 2 0 0 1 -2 -2z" />
                            <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                            <path d="M9 12h-7" />
                            <path d="M15 12h7" />
                        </svg>
                        <p class="mb-2 fs-18 fw-bold">{{ localize('Passport') }}</p>
                    </div>
                </div>
            </label>
        </div>
        <div class="col-lg-6 col-xl-4">
            <label class="radio-card w-100">
                <input name="document_type" value="{{ CustomerDocumentTypeEnum::DRIVING_LICENSE->value }}" class="radio"
                    type="radio" />
                <div class="doc-card">
                    <div class="align-items-center d-flex flex-column gap-2 justify-content-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-license">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M15 21h-9a3 3 0 0 1 -3 -3v-1h10v2a2 2 0 0 0 4 0v-14a2 2 0 1 1 2 2h-2m2 -4h-11a3 3 0 0 0 -3 3v11" />
                            <path d="M9 7l4 0" />
                            <path d="M9 11l4 0" />
                        </svg>
                        <p class="mb-2 fs-18 fw-bold">{{ localize('Driving License') }}</p>
                    </div>
                </div>
            </label>
        </div>
        <div class="col-lg-6 col-xl-4">
            <label class="radio-card w-100">
                <input name="document_type" value="{{ CustomerDocumentTypeEnum::VOTER_ID_CARD->value }}" class="radio"
                    type="radio" />
                <div class="doc-card">
                    <div class="align-items-center d-flex flex-column gap-2 justify-content-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-id">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" />
                            <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                            <path d="M15 8l2 0" />
                            <path d="M15 12l2 0" />
                            <path d="M7 16l10 0" />
                        </svg>
                        <p class="mb-2 fs-18 fw-bold">{{ localize('National ID Card') }}</p>
                    </div>
                </div>
            </label>
        </div>
        <div class="invalid-feedback" role="alert">
            @error('document_type')
                {{ $message }}
            @enderror
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10 col-xxl-6">
            <div class="mb-3">
                <label for="document1" class="col-form-label text-start text-color-1 fs-14 fw-semi-bold">
                    {{ localize('Document Font Page') }} <span class="text-danger">*</span>
                </label>
                <div class="d-flex align-items-start align-items-sm-center gap-4">
                    <div id="preview_file_document1">
                        <img src="{{ assets('img/avatar.png') }}" alt="user-avatar"
                            class="d-block w-px-100 h-px-100 rounded" required />
                    </div>
                    <div class="button-wrapper">
                        <input type="file" name="document1" id="document1" accept="image/*"
                            class="custom-form-control file-preview @error('document1') is-invalid @enderror"
                            data-previewDiv="preview_file_document1" />
                        <div class="invalid-feedback" role="alert">
                            @error('document1')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="text-muted fs-13">
                            {{ localize('Allowed JPG, GIF or PNG. Max size of 800KB') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="document2" class="col-form-label text-start text-color-1 fs-14 fw-semi-bold">
                    {{ localize('Document Back Page') }} <span class="text-danger">*</span>
                </label>
                <div class="d-flex align-items-start align-items-sm-center gap-4">
                    <div id="preview_file_document2">
                        <img src="{{ assets('img/avatar.png') }}" alt="user-avatar"
                            class="d-block w-px-100 h-px-100 rounded" required />
                    </div>
                    <div class="button-wrapper">
                        <input type="file" name="document2" id="document2" accept="image/*"
                            class="custom-form-control file-preview @error('document2') is-invalid @enderror"
                            data-previewDiv="preview_file_document2" />
                        <div class="invalid-feedback" role="alert">
                            @error('document2')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="text-muted fs-13">
                            {{ localize('Allowed JPG, GIF or PNG. Max size of 800KB') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label class="col-form-label text-start text-color-1 fs-16 fw-medium" for="id_number">
                    {{ localize('Identity No') }} <span class="text-danger">*</span>
                </label>
                <input type="text" name="id_number" id="id_number"
                    class="custom-form-control form-control @error('id_number') is-invalid @enderror"
                    placeholder="{{ localize('enter identity no') }}" required />
                <div class="invalid-feedback" role="alert">
                    @error('id_number')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <label class="col-form-label text-start text-color-1 fs-16 fw-medium" for="expire_date">
                    {{ localize('Expiry Date of the document') }} <span class="text-danger">*</span>
                </label>
                <input type="date" name="expire_date" id="expire_date"
                    class="custom-form-control form-control @error('expire_date') is-invalid @enderror"
                    placeholder="{{ localize('enter expiry date') }}" required />
                <div class="invalid-feedback" role="alert">
                    @error('expire_date')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center">
        <button type="button" class="btn btn-primary" onclick="stepper1.previous()">
            {{ localize('Previous') }}
        </button>
        <button type="button" class="btn btn-primary" onclick="stepper1.next()">
            {{ localize('Next') }}
        </button>
    </div>
</div>
