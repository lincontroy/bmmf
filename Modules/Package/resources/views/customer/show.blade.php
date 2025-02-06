@php
    use Carbon\Carbon;use Modules\Package\App\Enums\InterestTypeEnum;use Modules\Package\App\Enums\InvestTypeEnum;
@endphp
<x-customer-app-layout>
    @php
        $currentMonthYear = Carbon::now();
    @endphp

    <x-message />

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
                                @if($lastInvestment)
                                <p class="mb-0 text-black-50 fs-16 fw-normal"># {{ $lastInvestment->id + 1 }}</p>
                                @else
                                    <p class="mb-0 text-black-50 fs-16 fw-normal"># 1</p>
                                @endif

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
                <form action="{{ route('customer.packages.store') }}"  id="package-buy-form" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="table-responsive">
                    <table class="table mb-4">
                        <thead>
                        <tr>
                            <th>
                                <div>
                                    <p class="mb-1 fs-15 fw-medium">{{ localize('package') }}</p>
                                    <p class="mb-0 fs-12 fw-normal">{{ $package->name }}</p>
                                </div>
                            </th>
                            <th>
                                <div>
                                    <p class="mb-1 fs-15 fw-medium">{{ localize('duaration') }}</p>
                                    <p class="mb-0 fs-12 fw-normal">{{ ($package->planTime->hours_ / 24)*($package->repeat_time?$package->repeat_time:1) }} Days</p>
                                </div>
                            </th>
                            <th>
                                <div>
                                    <p class="mb-1 fs-15 fw-medium">{{ localize('ROI Type') }}</p>
                                    <p class="mb-0 fs-12 fw-normal">{{ $package->planTime->name_ }}</p>
                                </div>
                            </th>
                            <th>
                                <div>
                                    <p class="mb-1 fs-15 fw-medium">{{ localize('price') }}</p>
                                    @if ($package->invest_type->value == InvestTypeEnum::RANGE->value)
                                        <p class="mb-0 fs-12 fw-normal">
                                            ${{ $package->min_price }} - ${{ $package->max_price }}</p>
                                    @else
                                        <p class="mb-0 fs-12 fw-normal">
                                            ${{ $package->min_price }}</p>
                                    @endif
                                    <input type="hidden" name="package_id" value="{{ $package->id }}">
                                    <input type="hidden" id="investType" value="{{ InvestTypeEnum::RANGE->value }}">
                                    <input type="hidden" id="minPrice" value="{{ $package->min_price }}">
                                    <input type="hidden" id="maxPrice" value="{{ $package->max_price }}">
                                </div>
                            </th>
                            <th>
                                <div>
                                    <p class="mb-1 fs-15 fw-medium">{{ localize('return') }}</p>
                                    @if ($package->interest_type->value == InterestTypeEnum::PERCENT->value)
                                        <p class="mb-0 fs-12 fw-normal">{{ $package->interest }}
                                            % {{ $package->planTime->name_ }}</p>
                                    @else
                                        <p class="mb-0 fs-12 fw-normal">${{ $package->interest }}
                                            {{ $package->planTime->name_ }}</p>
                                    @endif
                                </div>
                            </th>
                            <th class="mx-w-400">
                                <div class="d-flex gap-2">
                                    @if ($package->invest_type->value == InvestTypeEnum::RANGE->value)
                                        <div class="input-group mb-3">
                                            <input name="investAmt" id="investAmt" type="number" class="form-control"
                                                   placeholder="1" aria-label="Recipient's username"
                                                   aria-describedby="basic-addon2" value="{{ $package->max_price }}">
                                            <span class="input-group-text" id="basic-addon2">{{ localize('invest_amount') }}</span>
                                        </div>
                                    @else
                                        <div class="input-group mb-3">
                                            <input name="investAmt" id="investAmt" type="number" class="form-control"
                                                   placeholder="1" aria-label="Recipient's username"
                                                   aria-describedby="basic-addon2" value="{{ $package->min_price }}"
                                                   readonly>
                                            <span class="input-group-text" id="basic-addon2">{{ localize('invest_amount') }}</span>
                                        </div>
                                    @endif
                                    <div class="input-group w-50 mb-3">
                                        <input name="quantity" id="quantity" type="number" class="form-control"
                                               placeholder="1"
                                               aria-label="Recipient's username" aria-describedby="basic-addon2"
                                               value="1">
                                        <span class="input-group-text" id="basic-addon2">{{ localize('Qty') }}</span>
                                    </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                    <div class="row px-4 pb-4">
                        <div class="col-lg-8">&nbsp;
                        </div>
                        <div class="col-lg-4">
                            <div class="align-items-end d-flex flex-column gap-1">
                                <div class="d-flex align-items-center gap-3">
                                    <p class="text-black fs-16 mb-0 fw-semi-bold">{{ localize('Quantity') }} :</p>
                                    <div class="px-4 py-2 radius-10 w-px-160">
                                        <p class="mb-0 text-black-50 fs-16 fw-normal chooseQuantity">1.00</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <p class="text-black fs-16 mb-0 fw-semi-bold">{{ localize('Price') }} :</p>
                                    <div class="px-4 py-2 radius-10 w-px-160">
                                        @if ($package->invest_type->value == InvestTypeEnum::RANGE->value)
                                            <p class="mb-0 text-black-50 fs-16 fw-normal investAmount">
                                                $ {{ $package->max_price }}</p>
                                        @else
                                            <p class="mb-0 text-black-50 fs-16 fw-normal investAmount">
                                                $ {{ $package->min_price }}</p>
                                        @endif

                                    </div>
                                </div>

                                <div class="d-flex align-items-center gap-3">
                                    <p class="text-black fs-16 mb-0 fw-semi-bold">{{ localize('Total') }} :</p>
                                    <div class="px-4 py-2 radius-10 w-px-160">
                                        @if ($package->invest_type->value == InvestTypeEnum::RANGE->value)
                                            <p class="mb-0 text-black-50 fs-16 fw-normal totalInvestment">
                                                $ {{ $package->max_price }}</p>
                                        @else
                                            <p class="mb-0 text-black-50 fs-16 fw-normal totalInvestment">
                                                $ {{ $package->min_price }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border-top p-4 mb-0">
                        <div class="align-items-center d-flex justify-content-end">
                            <a href="{{ route('customer.packages.index') }}" class="btn btn-red lh-lg py-2 w-auto"
                               type="submit">{{ localize('cancel') }}</a>
                            <button class="btn btn-save lh-lg ms-3 py-2 w-auto"
                                    type="submit">{{ localize('purchase') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('js')
        <script src="{{ module_asset('Package', 'js/customer/package.js') }}"></script>
    @endpush
</x-customer-app-layout>
