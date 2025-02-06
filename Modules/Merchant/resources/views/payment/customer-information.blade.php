<div class="card py-4 pb-0 shadow-none radius-15">
    <div
        class="card-header align-items-center d-flex flex-column flex-lg-row gap-3 justify-content-between pt-0 px-4 px-xl-5">
        <h5 class="m-0 fs-20 fw-semi-bold">{{ localize('Contact Details') }}</h5>
    </div>
    <div class="card-body p-3">
        <form
            action="{{ route('payment.process-customer', ['payment_url' => $merchantPaymentUrl->uu_id]) }}"
            method="post" class="needs-validation" id="customer-information" novalidate=""
            enctype="multipart/form-data">
            @csrf
            <div class="row mb-3">
                <div class="col-12">
                    <div class="mb-3">
                        <div class="input-group mb-3">
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="custom-form-control form-control @error('email') is-invalid @enderror"
                            placeholder="example@gmail.com" required />
                            <div class="input-group-append">
                              <span class="input-group-text input-group-text p-3" id="email">{{ localize('email') }}</span>
                            </div>
                            <div class="invalid-feedback" role="alert">
                                @error('email')
                                    {{ $message }}
                                @enderror
                            </div>
                          </div>
                    </div>
                </div>

                <div class="col-12 customer-name d-none">
                    <div class="mb-3">
                        <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                            for="first_name">{{ localize('First Name') }}
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}"
                            class="custom-form-control form-control customer-name-input @error('first_name') is-invalid @enderror"
                            placeholder="{{ localize('enter first name') }}" disabled />
                        <div class="invalid-feedback" role="alert">
                            @error('first_name')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-12 customer-name d-none">
                    <div class="mb-3">
                        <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                            for="last_name">{{ localize('Last Name') }}
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}"
                            class="custom-form-control form-control customer-name-input @error('last_name') is-invalid @enderror"
                            placeholder="{{ localize('enter last name') }}" disabled />
                        <div class="invalid-feedback" role="alert">
                            @error('last_name')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

            </div>
            <button type="submit" class="btn btn-save w-100">{{ localize('Proceed') }}</button>
        </form>
    </div>
</div>
