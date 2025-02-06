@php
    use App\Enums\StatusEnum;
@endphp
<x-app-layout>
    <div class="row gy-4">
        <div class="col-12">
            <div class="card py-4 px-3 radius-15">
                <div class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center mb-3">
                    <h3 class="fs-24 mb-0 text-color-2 fw-medium lh-1">{{ localize('Why Chose Content') }}</h3>
                    <div class="d-flex align-items-center gap-2">
                        <div class="border radius-10 p-1">
                            <button id="update-why-chose-header-button" data-bs-toggle="modal"
                                data-action='{{ route('admin.cms.why-chose.header.update', ['article' => $article->id]) }}'
                                data-route='{{ route('admin.cms.why-chose.header.edit', ['article' => $article->id]) }}'
                                data-bs-target="#updateWhyChoseHeader" class="btn btn-save lh-sm">
                                <span class="me-1">{{ localize('Update Why Chose Header') }}</span><svg width="12"
                                    height="12" viewBox="0 0 12 12" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 6H11M6 1V11" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                        <div class="border radius-10 p-1">
                            <button id="add-why-chose-content-button" data-bs-toggle="modal"
                                data-bs-target="#addWhyChoseContent" class="btn btn-save lh-sm">
                                <span class="me-1">{{ localize('Add Why Chose Content') }}</span><svg width="12"
                                    height="12" viewBox="0 0 12 12" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 6H11M6 1V11" stroke="white" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Data table -->
                <div class="card-body px-4 px-xl-5">
                    <!-- Data table -->
                    <x-data-table :dataTable="$dataTable" />
                    <!-- Data table -->
                </div>
                <!-- Data table -->

            </div>
        </div>
    </div>

    @include('cms::why-chose.updateWhyChoseHeader')

    @include('cms::why-chose.addWhyChoseContent')

    @push('js')
        <script src="{{ module_asset('CMS', 'js/why-chose.min.js') }}"></script>
    @endpush
</x-app-layout>
