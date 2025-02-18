@extends('finance::customer.layouts.master')

@section('card_header_content')
    <h5 class="m-0 fs-20 fw-semi-bold">{{ localize('Withdraw') }}</h5>
    <div class="d-flex align-items-center gap-2">
        <div class="border radius-10 p-1">
            <a href="{{ route('customer.withdraw.index') }}" class="btn btn-save lh-sm">
                <span class="me-1">{{ localize('Withdraw List') }}</span>
            </a>
        </div>
    </div>
@endsection
@section('contentData')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-4">
            <x-message />
            <form action="{{ route('customer.withdraw.store') }}" method="post" enctype="multipart/form-data"
                class="py-4">
                @csrf
                <input type="hidden" name="payment_method" value="1">

                <!-- Currency Selection -->
                <div class="mb-3">
                    <label for="payment_currency" class="form-label">{{ localize('Currency') }} <i class="text-danger">*</i></label>
                    <select class="form-select" name="payment_currency" id="payment_currency" required>
                      
                       
                        <option value="7">USDT</option>
                    </select>
                </div>
               
                <div class="floating-form-group mb-4">
                    <label class="floating-form-label z-index-1">{{ localize('Amount in usd') }}<i class="text-danger">*</i></label>
                    <input class="floating-form-control" type="text" name="withdraw_amount" id="withdraw_amount" />
                </div>
                <p class="mb-4 ms-3 text-success fs-16 fw-normal fees"></p>
                <div class="floating-form-group mb-4">
                    <label class="floating-form-label">{{ localize('Wallet address') }}</label>
                    <input class="floating-form-control" placeholder="{{ localize('Your wallet address') }}" rows="5" name="withdrawal_comments"
                        id="withdrawal_comments">
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
