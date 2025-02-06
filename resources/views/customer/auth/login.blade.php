<x-customer-guest-layout id="login-bg" class="login-bg">
    <div class="form-container my-4">
        <div class="panel">
            
            <div class="panel-header mb-4">
                <h3 class="fs-30 text-black">{{ localize('Sign In') }}</h3>
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
                    {{ localize('Access using your email and password.') }}
                </p>
            </div>
            <form method="POST" action="{{ route('customer.login.submit') }}" class="register-form">
                @csrf
                <div class="mb-3">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium">
                        {{ localize('Email or User name') }}
                    </label>
                    <input type="email" name="email" id="email"
                        class="custom-form-control border-0 @error('email') is-invalid @enderror"
                        placeholder="example@exaple.com" />
                    @error('email')
                        <span class="invalid-feedback text-start" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <label class="col-form-label text-color-1 fs-16 fw-medium">{{ localize('Password') }}</label>
                    </div>
                    <div class="position-relative">
                        <input type="password" name="password" id="password"
                            class="custom-form-control border-0  @error('email') is-invalid @enderror"
                            placeholder="{{ localize('Password') }}" />
                        <div class="password-toggle-icon">
                            <i class="fas fa-eye-slash text-black-50"></i>
                        </div>
                    </div>
                    @error('password')
                        <span class="invalid-feedback text-start" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-save py-3 lh-1 w-100">
                    {{ localize('Sign in') }}
                </button>
            </form>
        </div>
    </div>

    @push('css')
        <link rel="stylesheet" href="{{ assets('css/login.min.css') }}">
    @endpush
    @push('js')
        <script src="{{ assets('js/login.min.js') }}"></script>
    @endpush

</x-customer-guest-layout>
