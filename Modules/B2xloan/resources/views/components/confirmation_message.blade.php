<div class="modal fade" id="confirmation_message" tabindex="-1" aria-labelledby="userInfoLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content radius-35">
            <div class="modal-header p-4">
                <h5 class="modal-title text-color-5 fs-20 fw-medium" id="modelLabel">{{ localize('Notes') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action=""  method="post" class="needs-validation"
                      data="showCallBackData" id="b2x-loan-confirm-form" novalidate=""
                      enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="row mb-3 g-4">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-lg-12">
                                    <div class="mb-2">
                                        <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                                               for="checker_note">{{ localize('Note') }} <span
                                                class="text-danger">*</span></label>
                                        <textarea name="checker_note" id="checker_note" class="custom-form-control
                                        bg-transparent @error('checker_note') is-invalid @enderror"
                                                  placeholder="{{ localize('notes') }}" required></textarea>
                                        <div class="invalid-feedback" role="alert">
                                            @error('checker_note')
                                            {{ $message }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-lg-flex flex-lg-column justify-content-lg-end">
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-reset w-auto resetBtn" type="button"><i class="fa
                                    fa-undo-alt"></i> {{ localize('Reset') }}
                                </button>
                                <button class="btn btn-save ms-3 w-auto actionBtn" type="submit">{{ localize('Submit') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
