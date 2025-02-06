@php use App\Enums\StatusEnum; @endphp
@if ($plan)
    <form action="{{ route('stake.update', ['stake' => $plan->id]) }}"
        data-insert="{{ route('stake.update', ['stake' => $plan->id]) }}" method="post" class="needs-validation"
        data="showCallBackData" id="stake_edit_form" novalidate="" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row mb-3">
            <div class="col-12">
                <div class="mb-2">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium">
                        {{ localize('Accept Currency') }}<span class="text-danger">*</span></label>
                    <select
                        class="custom-form-control bg-transparent form-select @error('accept_currency') is-invalid @enderror"
                        name="accept_currency" id="accept_currency" required>
                        <option value="">Select Option</option>
                        @foreach ($acceptCurrency as $index => $item)
                            <option value="{{ $item->id }}" @selected($item->id == $plan->accept_currency_id)>{{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" role="alert">
                        @error('accept_currency')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="mb-2">
                    <label
                        class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Plan Name') }}<span
                            class="text-danger">*</span></label>
                    <input class="custom-form-control bg-transparent @error('stake_title') is-invalid @enderror"
                        type="text" name="stake_title" id="stake_title" value="{{ $plan->stake_name }}" required />
                    <div class="invalid-feedback" role="alert">
                        @error('stake_title')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="mb-2">
                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Status') }}<i
                            class="text-danger">*</i></label>
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="active_status"
                                value="1"
                                @isset($plan)
                                @checked(old('status', $plan->status->value) === StatusEnum::ACTIVE->value)
                                @endisset>
                            <label class="form-check-label" for="active_status"> {{ localize('Active') }} </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="inactive_status"
                                value="0"@isset($plan)
                                @checked(old('status', $plan->status->value) === StatusEnum::INACTIVE->value)
                                @endisset>
                            <label class="form-check-label" for="inactive_status"> {{ localize('Inactive') }} </label>
                        </div>
                        <div class="invalid-feedback" role="alert">
                            @error('status')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="mb-3">
                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                    for="image">{{ localize('Image') }}</label>
                <div class="border-all mb-3 p-2 radius-10 w-max-content" id="preview_file_image">
                    <img width="80" height="50" class="preview_image"
                        src="{{ $plan->image ? storage_asset($plan->image) : storage_asset('upload/stake/stake-a.e82f9f17.png') }}"
                        alt="" />
                </div>
                <div class="custom-file-button position-relative mb-3">
                    <input type="file" name="image" id="image" accept="image/*"
                        class="custom-form-control file-preview  @error('image') is-invalid @enderror"
                        data-previewDiv="preview_file_image" />
                </div>
                <div class="invalid-feedback" role="alert">
                    @error('image')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="text-primary fw-semi-bold">{{ localize('Prices') }}</span>
            <hr class="my-2 divider-color w-100" />
        </div>
        @foreach ($plan->stakeRateInfo as $rateInfo)
            <div class="row mb-3">
                @if ($loop->iteration > 1)
                    <div class="align-items-center gap-2">
                        <button type="button"
                            class="btn btn-sm bg-soft-1 btn-sm p-sm-1 text-red white-space edit-remove-rates float-end mb-1"><i
                                class="fa fa-trash" aria-hidden="true"></i></button>
                        <hr class="my-2 divider-color w-100" />
                    </div>
                @endif
                <div class="col-12 col-lg-6">
                    <div class="mb-2">
                        <label
                            class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Duration (days)') }}<span
                                class="text-danger">*</span></label>
                        <input class="custom-form-control bg-transparent @error('duration') is-invalid @enderror"
                            type="text" name="duration[]" required value="{{ $rateInfo->duration }}" />
                        <div class="invalid-feedback" role="alert">
                            @error('duration')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="mb-2">
                        <label
                            class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Min Locked Amount') }}<span
                                class="text-danger">*</span></label>
                        <input class="custom-form-control bg-transparent @error('min_value') is-invalid @enderror"
                            type="text" name="min_value[]" required value="{{ $rateInfo->min_amount }}" />
                        <div class="invalid-feedback" role="alert">
                            @error('min_value')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="mb-2">
                        <label
                            class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Interest') }}(%)<span
                                class="text-danger">*</span></label>
                        <div class="position-relative">
                            <input
                                class="custom-form-control bg-transparent @error('interest_rate') is-invalid @enderror"
                                type="text" name="interest_rate[]" value="{{ $rateInfo->rate }}" required />
                            <span class="invest">%</span>
                            <div class="invalid-feedback" role="alert">
                                @error('interest_rate')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label
                            class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Max Locked Amount') }}<span
                                class="text-danger">*</span></label>
                        <input class="custom-form-control bg-transparent @error('max_value') is-invalid @enderror"
                            type="text" name="max_value[]" required value="{{ $rateInfo->max_amount }}" />
                        <div class="invalid-feedback" role="alert">
                            @error('max_value')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="row mb-3">
            <div class="edit-rates-section"></div>
            <div class="col-12">
                <div class="text-center mt-3">
                    <a href="#" id="editNewRates" data-bs-toggle="modal" data-bs-target="#_edit_modal"
                        class="btn btn-catalina-blue lh-sm">
                        <span class="me-1">Add New</span>
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 6H11M6 1V11" stroke="white" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-save w-100">{{ localize('Update') }}</button>
    </form>
@else
    <div class="text-danger text-center">
        {{ localize('Sorry, the data you are trying to edit could not be found. Please ensure the correct item is selected.') }}
    </div>
@endif
