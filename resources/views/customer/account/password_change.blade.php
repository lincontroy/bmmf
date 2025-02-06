@php
    use Carbon\Carbon;
@endphp
<x-customer-app-layout>
    <x-customer.account activeMenu="password-change" activeMenuTitle="{{ localize('Password Change') }}"
        :customer="$customer">
        {{-- Password Change Form --}}
        <form action="{{ route('customer.account.password-change.update') }}" method="post" class="mb-4"
            data="showCallBackData" id="update-password-form" novalidate="" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="row g-4 gx-xxl-5">

                <div class="col-12 col-lg-6">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                        for="old_password">{{ localize('Old Password') }} <span class="text-danger">*</span>
                    </label>
                    <input type="password" name="old_password" id="old_password"
                        class="custom-form-control  form-control @error('old_password') is-invalid @enderror"
                        placeholder="{{ localize('enter old password') }}" />
                    <div class="invalid-feedback" role="alert">
                        @error('old_password')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                        for="password">{{ localize('New Password') }} <span class="text-danger">*</span>
                    </label>
                    <input type="password" name="password" id="password"
                        class="custom-form-control  form-control @error('password') is-invalid @enderror"
                        placeholder="{{ localize('enter new password') }}" />
                    <div class="invalid-feedback" role="alert">
                        @error('password')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                        for="password_confirmation">{{ localize('Confirm Password') }} <span
                            class="text-danger">*</span>
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="custom-form-control  form-control @error('password_confirmation') is-invalid @enderror"
                        placeholder="{{ localize('enter confirm password') }}" />
                    <div class="invalid-feedback" role="alert">
                        @error('password_confirmation')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <ul class="mb-3">
                <li>{{ localize('Minimum 8 characters long - the more, the better') }}</li>
                <li>{{ localize('At least one lowercase character') }}</li>
                <li>{{ localize('At least one number, symbol, or whitespace character') }}</li>
            </ul>
            <div class="d-flex gap-3">
                <button type="reset" class="btn btn-reset w-auto resetBtn">
                    <i class="fa fa-undo-alt"></i>
                </button>
                <button class="btn btn-save ms-3 w-auto actionBtn" type="submit">{{ localize('Update') }}</button>
            </div>
        </form>
        {{-- Password Change Form --}}

    </x-customer.account>
    @push('js')
        <script src="{{ assets('customer/js/password_change.min.js') }}"></script>
    @endpush
</x-customer-app-layout>
