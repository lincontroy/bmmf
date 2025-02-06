<x-app-layout>
    <div class="body-content">
        <div class="row gy-4">
            <div class="col-12">
                <div class="card py-4 px-3 radius-15">
                    <div class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center mb-3">
                        <h3 class="fs-24 mb-0 text-color-2 fw-medium lh-1">{{ localize('Verify Pending Customers') }}
                        </h3>
                    </div>
                    <!-- Data table -->
                    <x-data-table :dataTable="$dataTable" />
                    <!-- Data table -->
                </div>
            </div>
        </div>
        <div class="modal fade" id="customerVerifiedModal" tabindex="-1" aria-labelledby="addCustomerLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content radius-35">
                    <div class="modal-header p-4">
                        <h5 class="modal-title text-color-5 fs-20 fw-medium" id="addCustomerModalLabel">
                            {{ localize('Customer_Documents') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('admin.customers.store') }}"
                        data-insert="{{ route('admin.customers.store') }}" method="patch" id="customer-verified-form"
                        novalidate="" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="modal-body p-4 edit-modal">

                        </div>
                        <div class="modal-footer">
                            <button name="action" value="cancel" class="btn btn-reset w-auto"
                                type="submit">{{ localize('cancel') }}</button>
                            <button name="action" value="approve" class="btn btn-save ms-3 w-auto actionBtn"
                                type="submit">{{ localize('approved') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script src="{{ assets('customer/js/doc_view.js') }}"></script>
    @endpush
</x-app-layout>


