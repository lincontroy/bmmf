@php
    use Carbon\Carbon;
    use Modules\Merchant\App\Enums\MerchantPaymentTransactionStatusEnum;
@endphp
<x-customer-app-layout>

    <div class="row gy-4 justify-content-center">
        <div class="col-12">
            <div class="card shadow-none radius-15">
                <div
                    class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center mb-3 px-4 px-xl-5 py-4  border-bottom">
                    <h3 class="fs-24 mb-0 text-color-2 fw-medium lh-1">
                        {{ localize('Transaction') }}
                    </h3>
                </div>
                <div class="card-body px-4 px-xl-5">
                    <div class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center mb-3">
                        <ul class="nav nav-pills transaction-tab" id="pills-tab" role="tablist">
                            <li class="nav-item" data-status="" data-si="all">
                                <a class="default-cursor nav-link active" aria-selected="true">{{ localize('All Transaction') }}</a>
                            </li>
                            <li class="nav-item"
                                data-status="{{ MerchantPaymentTransactionStatusEnum::COMPLETE->value }}"
                                data-si="canceled">
                                <a class="default-cursor nav-link"
                                    aria-selected="true">{{ localize(enum_ucfirst_case(MerchantPaymentTransactionStatusEnum::COMPLETE->name)) }}
                                </a>
                            </li>
                            <li class="nav-item"
                                data-status="{{ MerchantPaymentTransactionStatusEnum::PENDING->value }}"
                                data-si="canceled">
                                <a class="default-cursor nav-link"
                                    aria-selected="true">{{ localize(enum_ucfirst_case(MerchantPaymentTransactionStatusEnum::PENDING->name)) }}
                                </a>
                            </li>
                            <li class="nav-item"
                                data-status="{{ MerchantPaymentTransactionStatusEnum::CANCELLED->value }}"
                                data-si="canceled">
                                <a class="default-cursor nav-link"
                                    aria-selected="true">{{ localize(enum_ucfirst_case(MerchantPaymentTransactionStatusEnum::CANCELLED->name)) }}
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Data table -->
                    <x-data-table :dataTable="$dataTable" />
                    <!-- Data table -->
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ module_asset('Merchant', 'js/transaction.js') }}"></script>
    @endpush
</x-customer-app-layout>
