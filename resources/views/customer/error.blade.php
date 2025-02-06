<x-customer-app-layout>
    <div class="card py-4 pb-0 shadow-none radius-15">
        <div
            class="card-header align-items-center d-flex flex-column flex-lg-row gap-3 justify-content-between pt-0 px-4 px-xl-5">
            {{ localize('OTP Verification') }}
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-4">
                    <a href="{{ route('customer.dashboard') }}" class="btn btn-save w-100">{{ localize('Return to Dashboard') }}</a>
                </div>
            </div>
        </div>
    </div>
</x-customer-app-layout>
