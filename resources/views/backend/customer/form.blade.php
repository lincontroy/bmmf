@php use App\Enums\StatusEnum; @endphp
<div class="row mb-3 g-4">
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="mb-2">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium" for="first_name">{{ localize('First Name') }}<i
                            class="text-danger">*</i></label>
                    <input
                        class="custom-form-control form-control bg-transparent @error('first_name') is-invalid @enderror"
                        type="text" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name ??
                        null) }}" required/>
                    <div class="invalid-feedback" role="alert">
                        @error('first_name')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="mb-2">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium" for="last_name">{{ localize('Last Name') }}<i
                            class="text-danger">*</i></label>
                    <input
                        class="custom-form-control form-control bg-transparent @error('last_name') is-invalid @enderror"
                        type="text" name="last_name" id="last_name" value="{{ old('last_name', $user->last_name ??
                        null) }}" required/>
                    <div class="invalid-feedback" role="alert">
                        @error('last_name')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="mb-2">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium" for="email">{{ localize('Email') }}<i
                            class="text-danger">*</i></label>
                    <input
                        class="custom-form-control form-control bg-transparent @error('email') is-invalid @enderror"
                        type="text" name="email" id="email" value="{{ old('email', $user->email ??
                        null) }}" required/>

                    <div class="invalid-feedback" role="alert">
                        @error('email')
                        {{ $message }}
                        @enderror
                    </div>
                </div>

            </div>
            <div class="col-12 col-lg-6">
                <div class="mb-2">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium" for="referral_user">{{ localize('Referral ID') }}</label>
                    <input
                        class="custom-form-control form-control bg-transparent"
                        type="text" name="referral_user" id="referral_user" value="{{ old('referral_user', $user->referral_user ??
                        null) }}"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="mb-2">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium" for="password">{{ localize('Password') }} <i
                            class="text-danger password">*</i></label>
                    <input
                        class="custom-form-control form-control bg-transparent @error('password') is-invalid @enderror"
                        type="password" name="password" id="password" required/>
                    <div class="invalid-feedback" role="alert">
                        @error('password')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">

                <div class="mb-2">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium" for="password_confirmation">{{ localize('Confirm Password') }} <i
                            class="text-danger password_confirmation">*</i></label>
                    <input
                        class="custom-form-control form-control bg-transparent @error('password_confirmation') is-invalid @enderror"
                        type="password" name="password_confirmation" id="password_confirmation" required/>
                    <div class="invalid-feedback" role="alert">
                        @error('password_confirmation')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="mb-2">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium" for="phone">{{ localize('Phone') }} <i
                            class="text-danger">*</i></label>
                    <input class="custom-form-control form-control bg-transparent @error('phone') is-invalid @enderror"
                           type="text" name="phone" id="phone" value="{{ old('phone', $user->phone ??
                        null) }}" required/>
                    <div class="invalid-feedback" role="alert">
                        @error('phone')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">

                <div class="mt-4">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Status') }}<i
                            class="text-danger">*</i></label>
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="active_status" checked
                                   value="1" @isset($user)
                                @checked(old('status', $user->status->value) === StatusEnum::ACTIVE->value)
                                @endisset>
                            <label class="form-check-label" for="active_status"> {{ localize('Active') }} </label>
                            <div class="invalid-feedback" role="alert">
                                @error('status')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status"
                                   id="inactive_status" value="0"@isset($user)
                                @checked(old('status', $user->status->value) === StatusEnum::INACTIVE->value)
                                @endisset>
                            <label class="form-check-label" for="inactive_status"> {{ localize('Inactive') }} </label>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
