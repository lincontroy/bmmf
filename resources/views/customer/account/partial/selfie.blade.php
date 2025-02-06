<div id="tab-selfie" role="tabpanel" class="content" aria-labelledby="stepper1trigger3">
    <h5 class="mb-4 fs-20 fw-semi-bold">{{ localize('Upload Selfie') }}</h5>

    <div class="row justify-content-center">
        <div class="col-lg-10 col-xxl-6">
            <div class="mb-3">
                <label for="document3" class="col-form-label text-start text-color-1 fs-14 fw-semi-bold" for="document3">
                    {{ localize('Upload Selfie with passport') }} <span class="text-danger">*</span>
                </label>
                <div class="d-flex align-items-start align-items-sm-center gap-4">
                    <div id="preview_file_document3">
                        <img src="{{ assets('img/avatar.png') }}" alt="user-avatar"
                            class="d-block w-px-100 h-px-100 rounded" required />
                    </div>
                    <div class="button-wrapper">
                        <input type="file" name="document3" id="document3" accept="image/*"
                            class="custom-form-control file-preview @error('document3') is-invalid @enderror"
                            data-previewDiv="preview_file_document3" />
                        <div class="invalid-feedback" role="alert">
                            @error('document_fort_page')
                                {{ $message }}
                            @enderror
                        </div>
                        <div class="text-muted fs-13">
                            {{ localize('Allowed JPG, GIF or PNG. Max size of 800KB') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center">
        <button type="button" class="btn btn-primary" onclick="stepper1.previous()">
            {{ localize('Previous') }}
        </button>
        <button type="submit" class="btn btn-success">
            {{ localize('Submit') }}
        </button>
    </div>
</div>
