<div class="modal fade" id="withdrawRequest" tabindex="-1" aria-labelledby="userInfoLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content radius-35">
            <div class="modal-header p-4">
                <h5 class="modal-title text-color-5 fs-20 fw-medium"
                    id="modelLabel">{{ localize('withdraw_request') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('customer.b2x_loan_withdraw_request') }}" method="post" id="withdraw-request-form">
                    @csrf
                    <input type="hidden" id="loanId" name="loanId">
                    <div class="row mb-3 g-4">
                        <div class="col-12">
                            <div class="row">
                                <div class="mb-2">
                                    <label for="payment_method"
                                           class="col-form-label text-start text-color-1 fs-16 fw-medium">
                                        {{ localize('method') }}
                                        <i class="text-danger">*</i>
                                    </label>
                                    <select class="custom-form-control bg-transparent placeholder-single"
                                            name="payment_method" id="payment_method" required>
                                        <option value="">{{ localize('select_option') }}</option>
                                        @foreach($paymentGateway as $key => $method)
                                            <option value="{{ $method->id }}">{{ $method->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback d-block" id="payment_method_error" role="alert"></div>
                                       <br>
                                        <span class="text-danger d-none accountNotFound">{{ localize('you_have_no_withdraw_account') }}, {{ localize('please_add_your_withdraw_account') }}</span>
                                <div class="mb-2">
                                    <label class="col-form-label text-start text-color-1 fs-16 fw-medium">{{ localize('Currency') }}<i class="text-danger">*</i></label>
                                    <select class="custom-form-control bg-transparent placeholder-single" name="payment_currency" id="payment_currency" required>
                                        <option value="">{{ localize('Select Option') }}</option>
                                    </select>
                                    <div class="invalid-feedback d-block" id="payment_currency_error" role="alert"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-lg-flex flex-lg-column justify-content-lg-end">
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-save ms-3 w-auto actionBtn" id="withdrawRequestButton" type="button">{{ localize('submit') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
