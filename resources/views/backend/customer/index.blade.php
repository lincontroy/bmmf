<x-app-layout>
    <div class="body-content">
        <div class="row gy-4">
            <div class="col-12">
                <div class="card py-4 px-3 radius-15">
                    <div class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center mb-3">
                        <h3 class="fs-24 mb-0 text-color-2 fw-medium lh-1">{{ localize('Customers') }}</h3>
                        <div class="d-flex align-items-center gap-2">
                            <div class="border radius-10 p-1">
                                <button id="add-user-button" data-bs-toggle="modal" data-bs-target="#addCustomer"
                                    class="btn btn-save lh-sm">
                                    <span class="me-1">{{ localize('Add New') }}</span>
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 6H11M6 1V11" stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Data table -->
                    <x-data-table :dataTable="$dataTable" />
                    <!-- Data table -->
                </div>
            </div>
        </div>
        <div class="modal fade" id="addCustomer" tabindex="-1" aria-labelledby="addCustomerLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content radius-35">
                    <div class="modal-header p-4">
                        <h5 class="modal-title text-color-5 fs-20 fw-medium" id="addCustomerModalLabel">
                            {{ localize('add customer') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.customers.store') }}"
                        data-insert="{{ route('admin.customers.store') }}" method="post" class="needs-validation"
                        data="showCallBackData" id="customer-form" novalidate="" enctype="multipart/form-data">

                        @csrf
                        <div class="modal-body p-4 edit-modal">
                            @include('backend.customer.form')
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-reset w-auto" type="reset">{{ localize('Reset') }}</button>
                            <button class="btn btn-save ms-3 w-auto actionBtn" type="submit">{{ localize('Create') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ assets('customer/js/app.js') }}"></script>
        <script>
            $(document).ready(function (){

                $('#active_status').trigger('click');
                console.log("yes");
            });
        </script>
    @endpush
</x-app-layout>
