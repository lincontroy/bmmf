@php
    use Carbon\Carbon;use Modules\Package\App\Enums\InterestTypeEnum;use Modules\Package\App\Enums\InvestTypeEnum;
@endphp
<x-customer-app-layout>
    @php
        $currentMonthYear = Carbon::now();
    @endphp
    <x-message/>
    <div class="card py-4 pb-0 shadow-none radius-15">
        <div
            class="card-header align-items-center d-flex flex-column flex-lg-row gap-3 justify-content-between pt-0 px-4 px-xl-5">
            <h5 class="m-0 fs-20 fw-semi-bold">{{ localize('packages') }}</h5>
        </div>
        <div class="card-body">
            <div class="shadow-one py-4 radius-15 mb-4">
                <div class="d-flex flex-lg-nowrap flex-wrap gap-2 align-items-center justify-content-between p-4 border-bottom">
                    <div>
                        @if($setting->logo)
                            <img class="mb-2" src="{{ storage_asset($setting->logo) }}" alt=""/>
                        @else
                            <img class="mb-2" src="{{ asset('assets/img/user.png') }}" alt=""/>
                        @endif
                        <p class="mb-0 text-black-50 fs-16 fw-normal">
                            {{ $setting->title }} <br/>
                            {{ $setting->description }} <br/>
                            {{ $setting->phone }} <br/>
                            {{ $setting->email }}
                        </p>
                    </div>
                    <div class="align-items-lg-end d-flex flex-column gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <p class="text-black fs-16 mb-0 fw-semi-bold">{{ localize('order_No') }}</p>
                            <div class="bg-soft-7 px-4 py-2 radius-10 w-px-160">
                                <p class="mb-0 text-black-50 fs-16 fw-normal"># {{ $investment->id }}</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <p class="text-black fs-16 mb-0 fw-semi-bold">{{ localize('date') }}</p>
                            <div class="bg-soft-7 px-4 py-2 radius-10 w-px-160">
                                <p class="mb-0 text-black-50 fs-16 fw-normal">{{ get_ymd($currentMonthYear) }}</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-soft-7 px-4 py-2 radius-10">
                                <p class="mb-0 text-black-50 fs-16 fw-normal">
                                    <span class="text-black">{{ localize('name') }}:</span><span class="ms-2">{{ $customerInfo->first_name.' '.$customerInfo->last_name }} ({{ $customerInfo->user_id }})</span>
                                    <br/>
                                    <span class="text-black">{{ localize('email') }}:</span><span
                                        class="ms-2">{{ $customerInfo->email }}</span> <br/>
                                    <span class="text-black">{{ localize('phone') }}:</span><span
                                        class="ms-2">{{ $customerInfo->phone }}</span> <br/>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                <table class="table mb-4">
                    <thead>
                    <tr>
                        <th>
                            <div>
                                <p class="mb-1 fs-15 fw-medium">{{ localize('package') }}</p>
                                <p class="mb-0 fs-12 fw-normal">{{ $investment->package->name }}</p>
                            </div>
                        </th>
                        <th>
                            <div>
                                <p class="mb-1 fs-15 fw-medium">{{ localize('duration') }}</p>
                                <p class="mb-0 fs-12 fw-normal">{{ ($investment->package->planTime->hours_ / 24)*($investment->package->repeat_time?$investment->package->repeat_time:1) }}
                                    Days</p>
                            </div>
                        </th>
                        <th>
                            <div>
                                <p class="mb-1 fs-15 fw-medium">{{ localize('ROI Type') }}</p>
                                <p class="mb-0 fs-12 fw-normal">{{ $investment->package->planTime->name_ }}</p>
                            </div>
                        </th>
                        <th>
                            <div>
                                <p class="mb-1 fs-15 fw-medium">{{ localize('price') }}</p>
                                @if ($investment->package->invest_type->value == InvestTypeEnum::RANGE->value)
                                    <p class="mb-0 fs-12 fw-normal">
                                        ${{ $investment->package->min_price }} -
                                        ${{ $investment->package->max_price }}</p>
                                @else
                                    <p class="mb-0 fs-12 fw-normal">
                                        ${{ $investment->package->min_price }}</p>
                                @endif
                            </div>
                        </th>
                        <th>
                            <div>
                                <p class="mb-1 fs-15 fw-medium">{{ localize('return') }}</p>
                                @if ($investment->package->interest_type->value == InterestTypeEnum::PERCENT->value)
                                    <p class="mb-0 fs-12 fw-normal">{{ $investment->package->interest }}
                                        % {{ $investment->package->planTime->name_ }}</p>
                                @else
                                    <p class="mb-0 fs-12 fw-normal">${{ $investment->package->interest }}
                                        {{ $investment->package->planTime->name_ }}</p>
                                @endif
                            </div>
                        </th>
                        <th>
                            <div>
                                <p class="mb-1 fs-15 fw-medium">{{ localize('quantity') }}</p>
                                <p class="mb-0 fs-12 fw-normal">{{ $investment->invest_qty }}</p>
                            </div>
                        </th>
                        <th>
                            <div>
                                <p class="mb-1 fs-15 fw-medium">{{ localize('invest_amount') }}</p>
                                <p class="mb-0 fs-12 fw-normal">{{ $investment->total_invest_amount }}</p>
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                </div>
                <div class="row px-4 pb-4">
                    <div class="col-lg-8">
                        &nbsp;
                    </div>
                    <div class="col-lg-4">
                        <div class="align-items-end d-flex flex-column gap-1">
                            <div class="d-flex align-items-center gap-3">
                                <p class="text-black fs-16 mb-0 fw-semi-bold">{{ localize('Quantity') }} :</p>
                                <div class="px-4 py-2 radius-10 w-px-160">
                                    <p class="mb-0 text-black-50 fs-16 fw-normal chooseQuantity">{{ $investment->invest_qty }}</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <p class="text-black fs-16 mb-0 fw-semi-bold">{{ localize('Invest/QTY') }} :</p>
                                <div class="px-4 py-2 radius-10 w-px-160">
                                    <p class="mb-0 text-black-50 fs-16 fw-normal investAmount">
                                        ${{ number_format(($investment->total_invest_amount / $investment->invest_qty),2) }}</p>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-3">
                                <p class="text-black fs-16 mb-0 fw-semi-bold">{{ localize('Total') }} :</p>
                                <div class="px-4 py-2 radius-10 w-px-160">
                                    <p class="mb-0 text-black-50 fs-16 fw-normal totalInvestment">
                                        ${{ number_format($investment->total_invest_amount,2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script src="{{ module_asset('Package', 'js/customer/package.js') }}"></script>
    @endpush
</x-customer-app-layout>
