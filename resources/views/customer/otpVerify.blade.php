<x-customer-app-layout>
    <div class="card py-4 pb-0 shadow-none radius-15">
        <div
            class="card-header align-items-center d-flex flex-column flex-lg-row gap-3 justify-content-between pt-0 px-4 px-xl-5">

            {{ localize('OTP Verification') }}
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-4">
                    <x-message />
                    <form action="{{ route('otp.verify.process') }}" method="post" enctype="multipart/form-data"
                        class="py-4">
                        @csrf

                        <div class="floating-form-group mb-4">
                            <label class="floating-form-label z-index-1">
                                {{ localize('Verification Code') }}<i
                                    class="text-danger">*</i></label>
                            <input class="floating-form-control" type="text" name="verification_code"
                                id="verification_code" placeholder="6 Digits Code" />
                            <p class="mb-4 ms-3 text-success fs-16 fw-normal">
                                {{ localize('We have sent an OTP verification code to your email address') }} :
                                <b>{{ $email }}</b>
                            </p>
                        </div>

                        <button class="btn btn-save w-100" type="submit">{{ localize('Verify') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-customer-app-layout>
