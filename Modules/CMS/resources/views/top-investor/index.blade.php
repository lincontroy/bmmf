@php
    use App\Enums\StatusEnum;
@endphp
<x-app-layout>
    <div class="row gy-4">
        <div class="col-12">
            <div class="card py-4 px-3 radius-15">
                <div class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center mb-3">
                    <h3 class="fs-24 mb-0 text-color-2 fw-medium lh-1">{{ localize('Top Investor') }}</h3>
                    <div class="d-flex align-items-center gap-2">
                        <div class="border radius-10 p-1">
                            <button id="update-banner-button" data-bs-toggle="modal"
                                data-action='{{ route('admin.cms.top-investor.banner.update', ['article' => $topInvestorBanner->id]) }}'
                                data-route='{{ route('admin.cms.top-investor.banner.edit', ['article' => $topInvestorBanner->id]) }}'
                                data-bs-target="#updateBanner" class="btn btn-save lh-sm">
                                <span class="me-1">{{ localize('Update Investor Banner') }}</span><svg
                                    width="12" height="12" viewBox="0 0 12 12" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 6H11M6 1V11" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                        
                            <button id="update-header-button" data-bs-toggle="modal"
                                data-action='{{ route('admin.cms.top-investor.header.update', ['article' => $topInvestorHeader->id]) }}'
                                data-route='{{ route('admin.cms.top-investor.header.edit', ['article' => $topInvestorHeader->id]) }}'
                                data-bs-target="#updateHeader" class="btn btn-save lh-sm">
                                <span class="me-1">{{ localize('Update Header') }}</span><svg
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

    @include('cms::top-investor.updateBanner')

    @include('cms::top-investor.updateTopBanner')

    @include('cms::top-investor.updateHeader')

    @push('js')
        <script src="{{ module_asset('CMS', 'js/top-investor.min.js') }}"></script>
    @endpush
</x-app-layout>
