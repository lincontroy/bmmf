@if ($stake)
    <div class="modal-header p-4">
        <h5 class="modal-title text-color-5 fs-20 fw-medium" id="stakeBuyModalLabel">{{ $stake->stake_name }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body p-4">
        <form action="{{ route('customer.stake.plan.store') }}" method="POST">
            @csrf
            <input type="hidden" name="stakeInterestPercent" id="stakeInterestPercent"
                value="{{ $stakeRateInfo->rate }}">
            <input type="hidden" name="minAmount" id="minAmount" value="{{ $stakeRateInfo->min_amount }}">
            <input type="hidden" name="maxAmount" id="maxAmount" value="{{ $stakeRateInfo->max_amount }}">
            <input type="hidden" name="stakeCurrency" id="stakeCurrency" value="{{ $stake->acceptCurrency->symbol }}">
            <input type="hidden" name="walletBalance" id="walletBalance"
                value="{{ $walletBalanceInfo->balance ?? 0 }}">
            <div class="row g-3">
                <div class="col-12">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Stake Amount') }} <span class="text-danger">*</span>
                    </label>
                    <div class="position-relative">
                        <input class="custom-form-control" type="text" name="locked_amount" id="locked_amount"
                            required />
                        <span class="invest bg-transparent text-black px-3">{{ $stake->acceptCurrency->symbol }}</span>
                    </div>
                    <p class="mb-2 text-danger fw-semi-bold locked-error-msg"></p>
                    <p class="mb-0 mt-3 text-success fw-semi-bold">{{ localize('Available') }} : {{ $walletBalanceInfo->balance ?? 0 }}
                        {{ $stake->acceptCurrency->symbol }}</p>
                </div>
                <div class="col-12">
                    <div class="bg-whisper px-3 py-2 mb-3 d-flex align-items-center justify-content-between">
                        <p class="mb-0 text-black fw-semi-bold">APY Rate</p>
                        <p class="mb-0 text-black fw-semi-bold">{{ $stakeRateInfo->annual_rate }}%</p>
                    </div>
                    <div class="bg-whisper px-3 py-2 mb-3 d-flex align-items-center justify-content-between">
                        <p class="mb-0 text-black fw-semi-bold">{{ localize('Approx. Interest') }}</p>
                        <p class="mb-0 text-black fw-semi-bold"><span id="estimate_interest">0</span>
                            {{ $stake->acceptCurrency->symbol }}</p>
                    </div>
                    <div class="bg-whisper px-3 py-2 mb-3 d-flex align-items-center justify-content-between">
                        <p class="mb-0 text-black fw-semi-bold">{{ localize('Stake Duration') }}</p>
                        <p class="mb-0 text-black fw-semi-bold">{{ $stakeRateInfo->duration }} Days</p>
                    </div>
                    <div class="bg-whisper px-3 py-2 mb-3 d-flex align-items-center justify-content-between">
                        <p class="mb-0 text-black fw-semi-bold">{{ localize('Redeemed At') }}</p>
                        <p class="mb-0 text-black fw-semi-bold">{{ $redemptionData }}</p>
                    </div>
                    
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-save w-100 stake-now" disabled>Stake Now</button>
                </div>
            </div>
            <input type="hidden" name="stake_plan_id" value="{{ $stake->id }}">
            <input type="hidden" name="stake_plan_rate_id" value="{{ $stakeRateInfo->id }}">
        </form>
    </div>
@else
    <div class="modal-header p-4">
        <h5 class="modal-title text-color-5 fs-20 fw-medium" id="stakeBuyModalLabel">Data error</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body p-4">
        <div class="row g-3">
            <div class="col-12">
                <p class="mb-0 mt-3 text-danger fw-semi-bold text-center">Data not found</p>
            </div>
        </div>
    </div>
@endif
