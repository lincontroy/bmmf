@php
    use Carbon\Carbon;
@endphp
<x-customer-app-layout>
    <x-customer.account activeMenu="account" activeMenuTitle="{{ localize('Account Details') }}" :customer="$customer">

        {{-- Customer Avatar Form --}}
        <form action="{{ route('customer.account.account.update_avatar') }}" method="post"
            class="d-flex flex-wrap align-items-center gap-3 mb-4 pb-4 border-bottom" data="showCallAvatarBackData"
            id="update-avatar-form" novalidate="" data-resetvalue="false" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div id="preview_file_avatar">
                <img src="{{ $customer->avatar ? storage_asset($customer->avatar) : assets('img/user.png') }}"
                    alt="user-avatar" class="account-img" />
            </div>
            <div class="button-wrapper">
                <div class="custom-file-button position-relative mb-3">
                    <input type="file" name="avatar" id="avatar" accept="image/*"
                        class="custom-form-control file-preview @error('avatar') is-invalid @enderror"
                        data-previewDiv="preview_file_avatar" />
                </div>
               <div class="d-flex flex-wrap align-items-center gap-2">
                <button class="btn btn-label-success btn-save mb-3 actionBtn" type="submit">
                    <span>{{ localize('Save') }}</span>
                </button>
                <button type="button" class="btn btn-label-secondary btn-reset mb-3">
                    <span>{{ localize('reset') }}</span>
                </button>
               </div>
                <p class="fs-16 fw-medium">{{ localize('Allowed JPG, GIF or PNG. Max size of 2MB') }}</p>
            </div>
        </form>
        {{-- Customer Avatar Form --}}

        {{-- Customer Information Form --}}
        <form action="{{ route('customer.account.account.update') }}" method="post" class=""
            data="showCallBackData" id="update-information-form" novalidate="" data-resetvalue="false"
            enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="row g-4 gx-xxl-5">
                <div class="col-12 col-lg-6">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                        for="username">{{ localize('User Name') }}<span class="text-danger">*</span>
                    </label>
                    <input type="text" name="username" id="username" value="{{ $customer->username }}"
                        class="custom-form-control  form-control @error('username') is-invalid @enderror"
                        placeholder="{{ localize('enter user name') }}" disabled />
                    <div class="invalid-feedback" role="alert">
                        @error('username')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                        for="email">{{ localize('Email') }}<span class="text-danger">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ $customer->email }}"
                        class="custom-form-control  form-control @error('email') is-invalid @enderror"
                        placeholder="{{ localize('enter user email') }}" required />
                    <div class="invalid-feedback" role="alert">
                        @error('user')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                        for="first_name">{{ localize('First Name') }}<span class="text-danger">*</span>
                    </label>
                    <input type="text" name="first_name" id="first_name" value="{{ $customer->first_name }}"
                        class="custom-form-control  form-control @error('first_name') is-invalid @enderror"
                        placeholder="{{ localize('enter user first name') }}" required />
                    <div class="invalid-feedback" role="alert">
                        @error('first_name')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                        for="last_name">{{ localize('Last Name') }}<span class="text-danger">*</span>
                    </label>
                    <input type="text" name="last_name" id="last_name" value="{{ $customer->last_name }}"
                        class="custom-form-control  form-control @error('last_name') is-invalid @enderror"
                        placeholder="{{ localize('enter user first name') }}" required />
                    <div class="invalid-feedback" role="alert">
                        @error('last_name')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                        for="phone">{{ localize('Phone Number') }}<span class="text-danger">*</span>
                    </label>
                    <input type="text" name="phone" id="phone" value="{{ $customer->phone }}"
                        class="custom-form-control  form-control @error('phone') is-invalid @enderror"
                        placeholder="{{ localize('enter user phone') }}" required />
                    <div class="invalid-feedback" role="alert">
                        @error('phone')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                        for="country">{{ localize('Country') }} <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="country" id="country" value="{{ $customer->country }}"
                        class="custom-form-control  form-control @error('country') is-invalid @enderror"
                        placeholder="{{ localize('enter user country') }}" required />
                    <div class="invalid-feedback" role="alert">
                        @error('country')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                        for="state">{{ localize('State') }}
                    </label>
                    <input type="text" name="state" id="state" value="{{ $customer->state }}"
                        class="custom-form-control  form-control @error('state') is-invalid @enderror"
                        placeholder="{{ localize('enter user state') }}" />
                    <div class="invalid-feedback" role="alert">
                        @error('state')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                        for="city">{{ localize('City') }} <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="city" id="city" value="{{ $customer->city }}"
                        class="custom-form-control  form-control @error('city') is-invalid @enderror"
                        placeholder="{{ localize('enter user city') }}" required />
                    <div class="invalid-feedback" role="alert">
                        @error('city')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                        for="address">{{ localize('Address') }}
                    </label>
                    <input type="text" name="address" id="address" value="{{ $customer->address }}"
                        class="custom-form-control  form-control @error('address') is-invalid @enderror"
                        placeholder="{{ localize('enter user address') }}" />
                    <div class="invalid-feedback" role="alert">
                        @error('address')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                        for="language">{{ localize('Language') }} <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="language" id="language" value="{{ $customer->language }}"
                        class="custom-form-control  form-control @error('language') is-invalid @enderror"
                        placeholder="{{ localize('enter user language') }}" required />
                    <div class="invalid-feedback" role="alert">
                        @error('language')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                        for="account_password">{{ localize('Account Password') }} <span class="text-danger">*</span>
                    </label>
                    <input type="password" name="account_password" id="account_password"
                        class="custom-form-control  form-control @error('account_password') is-invalid @enderror"
                        placeholder="{{ localize('enter password') }}" />
                    <div class="invalid-feedback" role="alert">
                        @error('account_password')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                        for="referral_user">{{ localize('Referral') }}
                    </label>
                    <input type="text" name="referral_user" id="referral_user" value="{{ $customer->referral_user ?? null }}"
                        class="custom-form-control  form-control @error('referral_user') is-invalid @enderror"
                        placeholder="{{ localize('enter user referral') }}" />
                    <div class="invalid-feedback" role="alert">
                        @error('referral_user')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="col-12 col-lg-6 d-lg-flex flex-lg-column justify-content-lg-end">
                    <div class="d-flex gap-3 justify-content-end">
                        <button type="reset" class="btn btn-reset w-auto resetBtn">
                            <i class="fa fa-undo-alt"></i>
                        </button>
                        <button class="btn btn-save ms-3 w-auto actionBtn"
                            type="submit">{{ localize('Update') }}</button>
                    </div>
                </div>
            </div>
        </form>
        {{-- Customer Information Form --}}

        @push('js')
            <script src="{{ assets('customer/js/account.min.js') }}"></script>
        @endpush

    </x-customer.account>
</x-customer-app-layout>
