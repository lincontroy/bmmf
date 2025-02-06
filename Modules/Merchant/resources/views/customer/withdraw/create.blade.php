@extends('finance::customer.layouts.master')

@section('card_header_content')
    <h5 class="m-0 fs-20 fw-semi-bold">{{ localize('Merchant Withdraw') }}</h5>
    <div class="d-flex align-items-center gap-2">
        <div class="border radius-10 p-1">
            <a href="{{ route('customer.merchant.withdraw.index') }}" class="btn btn-save lh-sm">
                <span class="me-1">{{ localize('Withdraw List') }}</span>
            </a>
        </div>
    </div>
@endsection
@section('contentData')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-4">
            <x-message />
            <form action="{{ route('customer.merchant.withdraw.store') }}" method="post" enctype="multipart/form-data"
                class="py-4">
                @csrf
                <div class="floating-form-group floating-form-select mb-4">
                    <label class="floating-form-label z-index-1">{{ localize('Payment Method') }}<i
                            class="text-danger">*</i></label>
                    <select class="placeholder-single" name="payment_method" id="payment_method" required>
                        <option value="">{{ localize('Select Option') }}</option>
                        @foreach ($gatewayData as $gateway)
                            <option value="{{ $gateway->id }}">{{ $gateway->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="floating-form-group floating-form-select mb-4">
                    <label class="floating-form-label z-index-1">{{ localize('Currency') }}<i
                            class="text-danger">*</i></label>
                    <select class="placeholder-single" name="payment_currency" id="payment_currency" required>
                        <option value="">{{ localize('Select Option') }}</option>
                    </select>
                </div>
                <p class="mb-4 ms-3 text-success fs-16 fw-normal withdraw-notify-msg"></p>
                <div class="floating-form-group mb-4">
                    <label class="floating-form-label z-index-1">{{ localize('Amount') }}<i
                            class="text-danger">*</i></label>
                    <input class="floating-form-control" type="text" name="withdraw_amount" id="withdraw_amount" />
                </div>
                <p class="mb-4 ms-3 text-success fs-16 fw-normal fees"></p>
                <div class="floating-form-group mb-4">
                    <label class="floating-form-label">{{ localize('Comments') }}</label>
                    <textarea class="floating-form-control" placeholder="{{ localize('Withdrawal Comments') }}" rows="5"
                        name="withdrawal_comments" id="withdrawal_comments"></textarea>
                </div>
                <button class="btn btn-save w-100" type="submit">{{ localize('Submit') }}</button>
            </form>
        </div>
    </div>
@endsection

@section('content')
    @push('js')
        <script src="{{ assets('js/pages/axios.min.js') }}"></script>
        <script src="{{ module_asset('Finance', 'js/app.js') }}"></script>
    @endpush
@endsection
