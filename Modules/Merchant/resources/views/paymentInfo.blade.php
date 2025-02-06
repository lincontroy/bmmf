@php use Modules\Merchant\App\Enums\MerchantPaymentInfoStatusEnum; @endphp
@extends('merchant::layouts.master')

@section('contentData')
    <div class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center mb-3">
        <ul class="nav nav-pills transaction-tab" id="pills-tab" role="tablist">
            <li class="nav-item allTab" data-route="{{ route('admin.merchant.transactions.count',['status' => 'all'])
            }}"
                data-si="all"
                onclick="statusWisePaymentTransaction
            (this,
            'all')">
                <a class="nav-link active" aria-selected="true">All Transaction
                    (<span class="totalCount">{{ $totalCount }}</span>)</a>
            </li>
            <li class="nav-item allTab" data-route="{{ route('admin.merchant.transactions.count',['status' =>
            MerchantPaymentInfoStatusEnum::PENDING->value])
            }}"
                data-si="pending"
                onclick="statusWisePaymentTransaction
            (this,
            'pending')">
                <a class="default-cursor nav-link" aria-selected="false">Pending
                    <span class="text-warning">
                        (<span class="totalPending">{{ $totalPending }}</span>)
                    </span>
                </a>
            </li>
            <li class="nav-item allTab" data-route="{{ route('admin.merchant.transactions.count',['status' =>
            MerchantPaymentInfoStatusEnum::COMPLETE->value])
            }}"
                data-si="confirm"
                onclick="statusWisePaymentTransaction
            (this,
            'confirm')">
                <a class="default-cursor nav-link" aria-selected="false">Confirmed
                    <span class="text-success">
                        (<span class="totalComplete">{{ $totalComplete }} </span>)
                    </span>
                </a>
            </li>
            <li class="nav-item allTab" data-route="{{ route('admin.merchant.transactions.count',['status' =>
            MerchantPaymentInfoStatusEnum::CANCELED->value])
            }}"
                data-si="canceled"
                onclick="statusWisePaymentTransaction
            (this,
            'cancel')">
                <a class="default-cursor nav-link" aria-selected="false">Cancel
                    <span class="text-danger">
                        (<span class="totalCanceled">{{ $totalCanceled }}</span>)
                    </span>
                </a>
            </li>
        </ul>

    </div>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-subscription" role="tabpanel"
             aria-labelledby="pills-transactions-tab">
            <!-- Data table -->
            <x-data-table :dataTable="$dataTable"/>
            <!-- Data table -->
        </div>
        <div class="tab-pane fade" id="pills-complete" role="tabpanel" aria-labelledby="pills-complete-tab">

        </div>
        <div class="tab-pane fade" id="pills-pending" role="tabpanel" aria-labelledby="pills-pending-tab">

        </div>
        <div class="tab-pane fade" id="pills-canceled" role="tabpanel" aria-labelledby="pills-canceled-tab">

        </div>
    </div>
@endsection

@push('js')
    <script src="{{ module_asset('Merchant', 'js/paymentInfo.js?v=1') }}"></script>
@endpush
