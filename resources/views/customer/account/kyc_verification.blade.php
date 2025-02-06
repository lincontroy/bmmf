@php
    use Carbon\Carbon;
    use App\Enums\CustomerVerifyStatusEnum;

@endphp
<x-customer-app-layout>
    <x-customer.account activeMenu="kyc-verification" activeMenuTitle="{{ localize('Kyc Verification') }}"
        :customer="$customer">
        @if ($customer->verified_status !== CustomerVerifyStatusEnum::PROCESSING)
            <div id="stepper1" class="bs-stepper">
                <div class="row">
                    <div class="col-md-3 col-xxl-2">
                        <div class="bs-stepper-header" role="tablist">
                            <div class="step" data-target="#tab-personal-details">
                                <button type="button" class="btn btn-link step-trigger" role="tab"
                                    id="stepper1trigger1" aria-controls="tab-personal-details">
                                    <span class="bs-stepper-circle"><i class="ti ti-user"></i></span>
                                    <div class="d-flex flex-column text-start">
                                        <span class="bs-stepper-label">
                                            {{ localize('Personal Details') }}
                                        </span>
                                        <span class="fs-13 text-black-50">
                                            {{ localize('Your personal information') }}
                                        </span>
                                    </div>
                                </button>
                            </div>
                            <div class="step" data-target="#tab-document">
                                <button type="button" class="btn btn-link step-trigger" role="tab"
                                    id="stepper1trigger2" aria-controls="tab-document">
                                    <span class="bs-stepper-circle"><i class="ti ti-file"></i></span>
                                    <div class="d-flex flex-column text-start">
                                        <span class="bs-stepper-label">
                                            {{ localize('Document') }}
                                        </span>
                                        <span class="fs-13 text-black-50">
                                            {{ localize('Your own documents') }}
                                        </span>
                                    </div>
                                </button>
                            </div>

                            <div class="step" data-target="#tab-selfie">
                                <button type="button" class="btn btn-link step-trigger" role="tab"
                                    id="stepper1trigger3" aria-controls="tab-selfie">
                                    <span class="bs-stepper-circle"><i class="ti ti-camera"></i></span>
                                    <div class="d-flex flex-column text-start">
                                        <span class="bs-stepper-label">
                                            {{ localize('Selfie') }}
                                        </span>
                                        <span class="fs-13 text-black-50">
                                            {{ localize('Your Selfie with document') }}
                                        </span>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 col-xxl-10">
                        <div class="bs-stepper-content">
                            {{-- Kyc Verification Form --}}
                            <form action="{{ route('customer.account.kyc-verification.store') }}" method="post"
                                class="" data="showCallBackData" id="kyc-verification-form" novalidate=""
                                enctype="multipart/form-data">
                                @csrf
                                @include('customer.account.partial.personal-details')
                                @include('customer.account.partial.document')
                                @include('customer.account.partial.selfie')
                            </form>
                            {{-- Kyc Verification Form --}}
                        </div>
                    </div>
                </div>
            </div>
        @else
            <h3>{{ localize('KYC Verification is pending') }} </h3>
        @endif

    </x-customer.account>

    @push('css')
        <link rel="stylesheet" href="{{ assets('plugins/bs-stepper/bs-stepper.css') }}" />
    @endpush

    @push('js')
        <script src="{{ assets('plugins/bs-stepper/bs-stepper.js') }}"></script>
        <script src="{{ assets('customer/js/kyc_verification.min.js') }}"></script>
    @endpush
</x-customer-app-layout>
