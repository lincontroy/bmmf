@php
    use App\Enums\StatusEnum;
@endphp
<x-app-layout>
    <div class="row gy-4">
        <div class="col-12">
            <div class="card py-4 px-3 radius-15">
                <div class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center mb-3">
                    <h3 class="fs-24 mb-0 text-color-2 fw-medium lh-1">{{ localize('B2X') }}</h3>
                    <div class="d-flex align-items-center gap-2">
                        <div class="border radius-10 p-1">
                            <button id="update-loan-button" data-bs-toggle="modal"
                                data-action='{{ route('admin.cms.b2x.loan.update', ['article' => $b2xLoan->id]) }}'
                                data-route='{{ route('admin.cms.b2x.loan.edit', ['article' => $b2xLoan->id]) }}'
                                data-bs-target="#updateLoan" class="btn btn-save lh-sm">
                                <span class="me-1">{{ localize('Update B2X Loan') }}</span><svg width="12"
                                    height="12" viewBox="0 0 12 12" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 6H11M6 1V11" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                            <button id="update-loan-banner-button" data-bs-toggle="modal"
                                data-action='{{ route('admin.cms.b2x.loan-banner.update', ['article' => $b2xLoanBanner->id]) }}'
                                data-route='{{ route('admin.cms.b2x.loan-banner.edit', ['article' => $b2xLoanBanner->id]) }}'
                                data-bs-target="#updateLoanBanner" class="btn btn-save lh-sm">
                                <span class="me-1">{{ localize('Update B2X Loan Banner') }}</span><svg width="12"
                                    height="12" viewBox="0 0 12 12" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 6H11M6 1V11" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                            <button id="update-calculator-header-button" data-bs-toggle="modal"
                                data-action='{{ route('admin.cms.b2x.calculator-header.update', ['article' => $b2xCalculatorHeader->id]) }}'
                                data-route='{{ route('admin.cms.b2x.calculator-header.edit', ['article' => $b2xCalculatorHeader->id]) }}'
                                data-bs-target="#updateCalculatorHeader" class="btn btn-save lh-sm">
                                <span class="me-1">{{ localize('Update B2X Calculator Header') }}</span><svg
                                    width="12" height="12" viewBox="0 0 12 12" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 6H11M6 1V11" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('cms::b2x.updateLoan')

    @include('cms::b2x.updateLoanBanner')

    @include('cms::b2x.updateCalculatorHeader')

    @include('cms::b2x.updateLoanDetailsHeader')

    @include('cms::b2x.updateLoanDetailsContent')



    @push('js')
        <script src="{{ module_asset('CMS', 'js/b2x.min.js') }}"></script>
    @endpush
</x-app-layout>
