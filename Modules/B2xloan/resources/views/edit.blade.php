@if ($package)
    <form action="{{ route('b2xloan.package.update', ['b2xloan_package' => $package->id]) }}"
        data-insert="{{ route('b2xloan.package.update', ['b2xloan_package' => $package->id]) }}" method="post"
        class="needs-validation" data="showCallBackData" id="b2x-loan-package-update-form" novalidate=""
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row mb-3 g-4">
            <div class="col-12">
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <div class="mb-2">
                            <label class="col-form-label text-start text-color-1 fs-16 fw-medium" for="no_of_month">
                                {{ localize('No of month') }} <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="no_of_month" id="no_of_month"
                                class="custom-form-control bg-transparent @error('no_of_month') is-invalid @enderror"
                                placeholder="{{ localize('Number of month') }}" required
                                value="{{ $package->no_of_month }}" />
                            <div class="invalid-feedback" role="alert">
                                @error('no_of_month')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-12">
                        <div class="mb-2">
                            <label
                                class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Interest Percent') }}(%)
                                <span class="text-danger">*</span></label>
                            <input name="interest_percent" id="interest_percent"
                                class="custom-form-control bg-transparent @error('interest_percent') is-invalid @enderror"
                                type="text" placeholder="{{ localize('Interest percent') }}" required
                                value="{{ number_format($package->interest_percent, 2, '.', '') }}" />
                            <div class="invalid-feedback" role="alert">
                                @error('interest_percent')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-12 d-lg-flex flex-lg-column justify-content-lg-center">
                        <label class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Status') }}
                            <span class="text-danger">*</span>
                        </label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="loanPackEditActive"
                                    value="1" @checked($package->status->value === \App\Enums\StatusEnum::ACTIVE->value) />
                                <label class="form-check-label" for="loanPackEditActive"> {{ localize('Active') }}
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="loanPackEditInactive"
                                    value="0" @checked($package->status->value === \App\Enums\StatusEnum::INACTIVE->value) />
                                <label class="form-check-label" for="loanPackEditInactive">
                                    {{ localize('Inactive') }}</label>
                            </div>
                        </div>
                        <div class="invalid-feedback" role="alert">
                            @error('status')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 d-lg-flex flex-lg-column justify-content-lg-end">
                <div class="d-flex justify-content-end">
                    <button class="btn btn-reset w-auto resetBtn" type="button">
                        <i class="fa fa-undo-alt"></i>{{ localize('Reset') }}
                    </button>
                    <button class="btn btn-save ms-3 w-auto actionBtn" type="submit">
                        {{ localize('Submit') }}
                    </button>
                </div>
            </div>
        </div>
    </form>
@else
    <div class="text-danger text-center">
        {{ localize('Sorry, the data you are trying to edit could not be found. Please ensure the correct item is selected.') }}
    </div>
@endif
