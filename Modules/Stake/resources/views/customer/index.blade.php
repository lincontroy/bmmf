@extends('stake::customer.layouts.master')

@section('card_header_content')
    <h5 class="m-0 fs-20 fw-semi-bold">Stake Plans</h5>
@endsection
@section('contentData')
    <div class="row g-3 g-lg-4 justify-content-center">
        <x-message />
        @foreach ($stakes as $key => $stake)
            <div class="col-md-6 col-lg-4 @if ($loop->iteration > 3) mt-5 @endif">
                <div class="card p-3 carusel-card-bg radius-15 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="stake-coin mx-auto rounded-circle mb-2 d-flex">
                            <img src="{{ assets('img/' . $stake->acceptCurrency->logo ?? 'blank50x50.png') }}" alt="">
                        </div>
                        <p class="mb-3 text-black fs-18 text-center fw-medium">{{ $stake->stake_name }}</p>
                        <p class="mb-3 text-black fs-18 text-center fw-normal">{{ localize('duration') }}</p>
                        <ul class="nav nav-pills d-flex gap-2 justify-content-center mb-4 stake-tab" id="pills-tab"
                            role="tablist">
                            @foreach ($stake->stakeRateInfo as $index => $item)
                                <li class="nav-item">
                                    <a class="nav-link btn-outline-stake @if ($index == 0) active @endif"
                                        id="pills-{{ $key . $index }}-tab" data-bs-toggle="pill"
                                        href="#pills-{{ $key . $index }}" role="tab"
                                        aria-controls="pills-{{ $key . $index }}" aria-selected="true"
                                        data-rate-id="{{ $item->id }}">
                                        {{ $item->duration }} {{ localize('days') }} </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div>
                        <div class="tab-content" id="pills-tabContent">
                            @foreach ($stake->stakeRateInfo as $index => $item)
                                <div class="tab-pane fade show @if ($index == 0) active @endif"
                                    id="pills-{{ $key . $index }}" role="tabpanel"
                                    aria-labelledby="pills-{{ $key . $index }}-tab">
                                    <div class="stake-packeg-list mx-auto mb-4">
                                        <div
                                            class="stake-packeg-item d-flex gap-3 justify-content-between align-items-center">
                                            <p class="mb-0 text-black fw-light fs-15">
                                               APY {{ localize('rate') }}</p>
                                            <p class="mb-0 text-black fw-medium fs-15">{{ $item->annual_rate }}%
                                                {{ $stake->acceptCurrency->symbol }}</p>
                                        </div>
                                        <div
                                            class="stake-packeg-item d-flex gap-3 justify-content-between align-items-center">
                                            <p class="mb-0 text-black fw-light fs-15">
                                                {{ localize('minimum_lock_amount') }}</p>
                                            <p class="mb-0 text-black fw-medium fs-15">{{ $item->min_amount }}
                                                {{ $stake->acceptCurrency->symbol }}</p>
                                        </div>
                                        <div
                                            class="stake-packeg-item d-flex gap-3 justify-content-between align-items-center">
                                            <p class="mb-0 text-black fw-light fs-15">
                                                {{ localize('maximum_lock_amount') }}</p>
                                            <p class="mb-0 text-black fw-medium fs-15">{{ $item->max_amount }}
                                                {{ $stake->acceptCurrency->symbol }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <a href="javascript:void(0)" class="btn-stake d-flex w-max-content m-auto stake-buy"
                            data-action="{{ route('customer.stake.plan.show', ['plan' => $stake->id]) }}">Stake Now</a>
                    </div>

                </div>
            </div>
        @endforeach
    </div>
    <div class="modal fade" id="stakeBuyModal" tabindex="-1" aria-labelledby="stakeBuyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content radius-35 stake-modal-content">

            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ module_asset('Stake', 'js/stake.js') }}"></script>
@endpush
