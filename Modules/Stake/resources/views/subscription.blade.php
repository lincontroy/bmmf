@extends('stake::layouts.master')

@section('contentData')
    <div class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center mb-3">
        <ul class="nav nav-pills transaction-tab" id="pills-tab" role="tablist">
            <li class="nav-item allTab" data-si="all" onclick="subscriptionFilterData(this, 'all')">
                <a class="default-cursor nav-link active" aria-selected="true">{{ localize('All Staked') }}
                    <span>({{ $redeemed + $pending }})</span></a>
            </li>
            <li class="nav-item allTab" data-si="redeemed" onclick="subscriptionFilterData(this, 'redeemed')">
                <a class="default-cursor nav-link" aria-selected="false">{{ localize('Redeemed') }} <span
                        class="text-success">({{ $redeemed }})</span></a>
            </li>
            <li class="nav-item allTab" data-si="pending" onclick="subscriptionFilterData(this, 'pending')">
                <a class="default-cursor nav-link" aria-selected="false">{{ localize('Running') }} <span
                        class="text-primary">({{ $pending }})</span></a>
            </li>
        </ul>
    </div>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-subscription" role="tabpanel"
            aria-labelledby="pills-subscription-tab">
            <!-- Data table -->
            <x-data-table :dataTable="$dataTable" />
            <!-- Data table -->
        </div>
        <div class="tab-pane fade" id="pills-redeemed" role="tabpanel" aria-labelledby="pills-redeemed-tab">

        </div>
        <div class="tab-pane fade" id="pills-pending" role="tabpanel" aria-labelledby="pills-pending-tab">

        </div>
    </div>
@endsection

@push('js')
    <script src="{{ module_asset('Stake', 'js/app.js') }}"></script>
@endpush
