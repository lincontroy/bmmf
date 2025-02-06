@extends('b2xloan::customer.layouts.master')

@section('card_header_content')
    <h5 class="m-0 fs-20 fw-semi-bold">{{ localize('Repayment') }}</h5>
    <div class="d-flex align-items-center gap-2">
        <div class="border radius-10 p-1">
            <a href="{{ route('customer.b2x_loan_list') }}" class="btn btn-save lh-sm">
                <i class="fa fa-arrow-left" aria-hidden="true"></i>
                <span class="me-1">{{ localize('Loans') }}</span>
            </a>
        </div>
    </div>
@endsection
@section('contentData')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-4">
            <x-message />
            <form action="{{ route('customer.repayment.store') }}" method="post" enctype="multipart/form-data"
                class="py-4">
                @csrf
                <div class="floating-form-group floating-form-select mb-4">
                    <label class="floating-form-label z-index-1">{{ localize('Payment Method') }}<i class="text-danger">*</i></label>
                    <select class="placeholder-single" name="payment_method" id="payment_method" required>
                        <option value="">{{ localize('Select Option') }}</option>
                        @foreach ($gatewayData as $gateway)
                            <option value="{{ $gateway->id }}">{{ $gateway->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="floating-form-group floating-form-select mb-4">
                    <label class="floating-form-label z-index-1">{{ localize('Currency') }}<i class="text-danger">*</i></label>
                    <select class="placeholder-single" name="payment_currency" id="payment_currency" required>
                        <option value="">{{ localize('Select Option') }}</option>
                    </select>
                </div>
                <div class="floating-form-group mb-4">
                    <label class="floating-form-label z-index-1">{{ localize('Amount') }}<i class="text-danger">*</i></label>
                    <div class="input-group mb-3">
                        <span class="input-group-text custom-input-group-text" id="deposit-amount-dollar">$</span>
                        <input class="floating-form-control ms-4" type="text" name="deposit_amount" id="deposit_amount"
                            placeholder="{{ localize('Amount in USD') }}" aria-describedby="deposit-amount-dollar" value="{{ number_format($loan->installment_amount, 2, '.', '') }}" />
                    </div>
                </div>
                <p class="mb-4 ms-3 text-success fs-16 fw-normal fees"></p>
                <div class="floating-form-group mb-4">
                    <label class="floating-form-label">{{ localize('Comments') }}</label>
                    <textarea class="floating-form-control" placeholder="{{ localize('repayment_comments') }}" rows="5" name="deposit_comments"
                        id="deposit_comments"></textarea>
                </div>
                <button class="btn btn-save w-100" type="submit">{{ localize('Submit') }}</button>
            </form>
        </div>
    </div>
@endsection

@section('content')
    @push('js')
        <script src="{{ assets('js/pages/axios.min.js') }}"></script>
        <script src="{{ module_asset('B2xlaon', 'js/app.js') }}"></script>
    @endpush
@endsection
