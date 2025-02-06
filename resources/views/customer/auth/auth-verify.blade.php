<x-guest-layout id="login-bg" class="login-bg" data-backgroundimage="{{ assets('img/login-bg.png') }}">
    <div class="form-container my-4">
        <div class="register-logo text-center mb-4">
            <img class="mb-2" src="{{ assets('img/logo.png') }}" alt="" />
            <h3 class="title-color-1 mb-0 fw-semi-bold lh-1">
                {{ $_setting->title ?? null }}
            </h3>
            <p class="text-color-1">{{ $_setting->description ?? null }}</p>
        </div>
        <div class="panel">
            <div class="panel-header mb-4">
                <h3 class="fs-30 text-black">{{ localize('Two Step Verification') }}</h3>
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session()->has('warning'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <p class="text-black fs-16 fw-normal mb-0">
                    {{ localize('Enter the code from the auth app in the field below') }}.</p>
            </div>
            <form method="POST" action="{{ route('customer.auth-verify.confirm') }}" class="register-form">
                @csrf
                <div class="mb-3">
                    <label
                        class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Verification Code') }}</label>
                    <input type="text" name="verification_code" id="verification_code"
                        class="custom-form-control border-0 @error('verification_code') is-invalid @enderror"
                        placeholder="" />
                    @error('verification_code')
                        <span class="invalid-feedback text-start" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-save py-3 lh-1 w-100">{{ localize('Confirm') }}</button>
            </form>
        </div>
    </div>

    @push('css')
        <link rel="stylesheet" href="{{ assets('css/login.min.css') }}">
    @endpush
    @push('js')
        <script src="{{ assets('js/login.min.js') }}"></script>
    @endpush

</x-guest-layout>
