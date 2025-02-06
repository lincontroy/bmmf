<x-app-layout>
    <div class="row gy-4">
        <div class="col-12">
            <div class="card py-4 px-3 radius-15">
                <div class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center mb-3">
                    <h3 class="fs-24 mb-0 text-color-2 fw-medium lh-1">{{ localize('Transfer List') }}</h3>
                </div>
                <!-- Data table -->
                <x-data-table :dataTable="$dataTable"/>
                <!-- Data table -->
            </div>
        </div>
    </div>

    <div class="modal fade" id="creditDetails" tabindex="-1" aria-labelledby="addCreditLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content radius-35">
                <div class="modal-header p-4">
                    <h5 class="modal-title text-color-5 fs-20 fw-medium" id="modelLabel">{{ localize('Credit Details') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" id="viewCreditDetails">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{ localize('Close') }}</button>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ module_asset('Finance', 'js/transfer.js') }}"></script>
    @endpush

</x-app-layout>
