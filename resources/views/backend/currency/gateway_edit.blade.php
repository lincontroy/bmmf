@if ($gatewayInfo)
    <form action="{{ route('admin.payment.gateway.update', ['gateway' => $gatewayInfo->id]) }}"
        data-insert="{{ route('admin.payment.gateway.update', ['gateway' => $gatewayInfo->id]) }}" method="post"
        class="needs-validation" data="showCallBackData" id="gateway_edit_form" novalidate="" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-3 gx-xxl-5">
            <div class="col-12 col-lg-6">
                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                    for="gateway_name">{{ localize('Name') }}<i class="text-danger">*</i></label>
                <input class="custom-form-control" name="gateway_name" id="gateway_name" type="text"
                    value="{{ $gatewayInfo->name }}" required readonly>
            </div>
            <div class="col-12 col-lg-6">
                <label class="col-form-label text-start text-color-1 fs-16 fw-medium"
                    for="gateway_name">{{ localize('Logo') }}</label>
                <div class="rounded-3">
                    <img width="150" height="50" src="{{ asset('storage/' . optional($gatewayInfo)->logo) }}"
                        alt="" />
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <label
                    class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Minimum Transaction Amount(USD)') }}<i
                        class="text-danger">*</i></label>
                <input class="custom-form-control bg-transparent" type="text" name="min_transaction_amount"
                    id="min_transaction_amount" value="{{ $gatewayInfo->min_deposit }}" required>
            </div>
            <div class="col-12 col-lg-6">
                <div class="custom-file-button position-relative mb-3">
                    <label
                        class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Maximum Transaction Amount(USD)') }}<i
                            class="text-danger">*</i></label>
                    <input class="custom-form-control bg-transparent" type="text" name="max_transaction_amount"
                        id="max_transaction_amount" value="{{ $gatewayInfo->max_deposit }}" required>
                </div>
            </div>
            @if ($gatewayInfo->credential)
                @foreach ($gatewayInfo->credential as $gateway)
                    <div class="col-12 col-lg-6">
                        <label
                            class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Credential Name') }}<i
                                class="text-danger">*</i></label>
                        <input
                            class="custom-form-control bg-transparent @error('credential_name.' . $loop->iteration) is-invalid @enderror"
                            type="text" name="credential_name[]" value="{{ $gateway->name }}" required readonly />
                    </div>
                    <div
                        class="col-12 col-lg-6 d-lg-flex flex-lg-column justify-content-lg-end @if ($loop->iteration == 1) account-label-field @endif">
                        <label
                            class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Credential Value') }}<i
                                class="text-danger">*</i></label>
                        <div class="d-flex gap-2">
                            <input
                                class="custom-form-control bg-transparent @error('credential_value.' . $loop->iteration) is-invalid @enderror"
                                type="text" name="credential_value[]" value="{{ $gateway->credentials }}"
                                required />
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12 col-lg-6">
                    <label
                        class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Credential Name') }}
                        <i class="text-danger">*</i></label>
                    <input class="custom-form-control bg-transparent @error('credential_name.0') is-invalid @enderror"
                        type="text" name="credential_name[]" required readonly />
                </div>
                <div class="col-12 col-lg-6 d-lg-flex flex-lg-column justify-content-lg-end account-label-field">
                    <label
                        class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Credential Value') }}
                        <i class="text-danger">*</i></label>
                    <div class="d-flex gap-2">
                        <input
                            class="custom-form-control bg-transparent @error('credential_value.0') is-invalid @enderror"
                            type="text" name="credential_value[]" required />
                    </div>
                </div>
            @endif
            <div class="col-12 col-lg-6 d-lg-flex flex-lg-column justify-content-lg-center">
                <label class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Status') }}<i
                        class="text-danger">*</i></label>
                <div class="d-flex gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="edit_active_status"
                            value="1" {{ $gatewayInfo->status == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="edit_active_status"> {{ localize('Active') }} </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="edit_inactive_status"
                            value="0" {{ $gatewayInfo->status == '0' ? 'checked' : '' }}>
                        <label class="form-check-label" for="edit_inactive_status"> {{ localize('Inactive') }}
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="d-flex justify-content-end">
                    <button class="btn btn-reset w-auto" type="reset">{{ localize('reset') }}</button>
                    <button class="btn btn-save ms-3 w-auto actionBtn" type="submit">{{ localize('Update') }}</button>
                </div>
            </div>
        </div>
    </form>
@else
    <div class="text-danger text-center">
        {{ localize('Sorry, the data you are trying to edit could not be found. Please ensure the correct item is selected.') }}
    </div>
@endif
