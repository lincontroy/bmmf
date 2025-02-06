@php
    use App\Enums\CustomerMerchantVerifyStatusEnum;
@endphp


<x-customer-app-layout>
    <div class="row gy-4 justify-content-center">
        <div class="col-12">
            <div class="card shadow-none radius-15">
                <div
                    class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center mb-3 px-4 px-xl-5 py-4  border-bottom">
                    <h3 class="fs-24 mb-0 text-color-2 fw-medium lh-1">
                        {{ localize('Request Application') }}
                    </h3>
                    <div class="d-flex align-items-center gap-2">
                        <div class="border radius-10 p-1">

                            @if(in_array($customer->merchant_verified_status, [CustomerMerchantVerifyStatusEnum::NOT_SUBMIT, CustomerMerchantVerifyStatusEnum::CANCELED]))
                                <a href="{{ route('customer.merchant.account-request.create') }}"
                                    class="btn btn-save lh-sm">
                                    <span class="me-1">{{ localize('Add Request Application') }}</span><svg width="12"
                                        height="12" viewBox="0 0 12 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 6H11M6 1V11" stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </a>
                            @endif

                        </div>
                    </div>
                </div>

                <div class="card-body px-4 px-xl-5">

                    <!-- Data table -->
                    <x-data-table :dataTable="$dataTable" />
                    <!-- Data table -->

                </div>
            </div>
        </div>
    </div>
</x-customer-app-layout>
