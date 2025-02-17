@php
    use Modules\Package\App\Enums\CapitalBackEnum;
    use Modules\Package\App\Enums\InvestTypeEnum;
    use Modules\Package\App\Enums\InterestTypeEnum;
    use Modules\Package\App\Enums\ReturnTypeEnum;
@endphp
@foreach ($packages as $key => $package)
    <div class="card p-3 me-4 carusel-card-bg radius-15 mt-4">
        <div class="bg_conic_gradient_60">
            <div class="p-3 carusel-card-bg radius-15">
                <p class="mb-3 text-black fs-25 text-center fw-medium">{{ $package->name }}</p>
                @if ($package->invest_type->value == InvestTypeEnum::RANGE->value)
                    <p class="mb-3 text-black fs-25 text-center fw-semi-bold">
                        ${{ $package->min_price }} - ${{ $package->max_price }}</p>
                @else
                    <p class="mb-3 text-black fs-25 text-center fw-semi-bold">
                        ${{ $package->min_price }}</p>
                @endif
                <div class="invest-packeg-list mb-4">
                    <div
                        class="invest-packeg-item d-flex gap-3 justify-content-between align-items-center">
                        <p class="mb-0 text-black fw-light fs-15">{{ localize('interest') }}</p>
                        @if ($package->interest_type->value == InterestTypeEnum::PERCENT->value)
                            <p class="mb-0 text-black fw-medium fs-15">{{ $package->interest }}
                                % {{ $package->planTime->name_ }}</p>
                        @else
                            <p class="mb-0 text-black fw-medium fs-15">${{ $package->interest }}
                                {{ $package->planTime->name_ }}</p>
                        @endif
                    </div>
                    <div
                        class="invest-packeg-item d-flex gap-3 justify-content-between align-items-center">
                        <p class="mb-0 text-black fw-light fs-15">
                            {{ localize('capital_will_back') }}</p>
                        <p class="mb-0 text-black fw-medium fs-15">
                            @if ($package->capital_back->value == CapitalBackEnum::YES->value)
                                <span
                                    class="badge bg-label-success py-2 w-px-75">{{ CapitalBackEnum::YES->name }}</span>
                        </p>
                        @else
                            <span
                                class="badge bg-label-warning py-2 w-px-75">{{ CapitalBackEnum::NO->name }}</span>
                            </p>
                        @endif
                    </div>
                    <div
                        class="invest-packeg-item d-flex gap-3 justify-content-between align-items-center">
                        <p class="mb-0 text-black fw-light fs-15">{{ localize('profit_for') }}</p>
                        <p class="mb-0 text-black fw-medium fs-15">
                            @if ($package->return_type->value == ReturnTypeEnum::LIFE_TIME->value)
                                <span
                                    class="badge bg-label-success py-2 w-px-75">{{ str_replace('_', ' ', ReturnTypeEnum::LIFE_TIME->name) }}</span>
                        </p>
                        @else
                            <span
                                class="badge bg-label-warning py-2 w-px-75">{{ ReturnTypeEnum::REPEAT->name }}</span></p>
                        @endif
                    </div>
                    <div
                        class="invest-packeg-item d-flex gap-3 justify-content-between align-items-center">
                        <p class="mb-0 text-black fw-light fs-15">{{ localize('interest_recurrence') }}</p>
                        <p class="mb-0 text-black fw-medium fs-15">
                            @if ($package->return_type->value == ReturnTypeEnum::LIFE_TIME->value)
                                <span
                                    class="badge bg-label-success py-2 w-px-75"> {{ localize('one_Time') }}</span>
                        </p>
                        @else
                            <span
                                class="badge bg-label-warning py-2 w-px-75">{{ $package->repeat_time }} {{ localize('time') }}</span></p>
                        @endif
                    </div>
                </div>
                <a href="{{ route('customer.packages.show', [$package->id]) }}" class="btn-invest w-max-content">{{ localize('invest_now') }}</a>
            </div>
        </div>
    </div>
@endforeach
