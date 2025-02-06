<x-app-layout>
    <div class="row gy-4">
        <div class="col-12">
            <div class="card py-4 px-3 radius-15">
                <div class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center mb-3">
                    <h3 class="fs-24 mb-0 text-color-2 fw-medium lh-1">{{ localize('closed_loans') }}</h3>
                </div>
                <!-- Data table -->
                <x-data-table :dataTable="$dataTable"/>
                <!-- Data table -->
            </div>
        </div>
    </div>

    <x-finance::userprofile />

    @push('js')
        <script src="{{ module_asset('B2xloan', 'js/b2xloan.js') }}"></script>
    @endpush

</x-app-layout>
