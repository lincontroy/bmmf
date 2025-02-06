@extends('finance::customer.layouts.master')

@section('card_header_content')
    <h5 class="m-0 fs-20 fw-semi-bold">{{ localize('Transfer') }}</h5>
    <div class="d-flex align-items-center gap-2">
        <div class="border radius-10 p-1">
            <a href="{{ route('customer.transfer.index') }}" class="btn btn-save lh-sm">
                <span class="me-1">{{ localize('Transfer List') }}</span>
            </a>
        </div>
    </div>
@endsection
@section('contentData')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-4">
            <x-message />
            <form action="{{ route('customer.transfer.store') }}" method="post" enctype="multipart/form-data" class="py-4">
                @csrf

                <div class="floating-form-group floating-form-select mb-4">
                    <label class="floating-form-label z-index-1">{{ localize('Currency') }}<i class="text-danger">*</i></label>
                    <select class="placeholder-single" name="payment_currency" id="payment_currency" required>
                        <option value="" selected>{{ localize('Select Option') }}</option>
                        @foreach ($currencyData as $currency)
                            <option value="{{ $currency->symbol }}">{{ $currency->name }} ({{ $currency->symbol }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="floating-form-group mb-4">
                    <label class="floating-form-label z-index-1">{{ localize('Receiver UserId OR Email') }}<i
                            class="text-danger">*</i></label>
                    <input class="floating-form-control" type="text" name="receiver_user" id="receiver_user"
                        placeholder="{{ localize('UserId/Email') }}" />
                </div>
                <p class="mb-4 ms-3 fs-16 fw-normal transfer-notify-msg"></p>
                <div class="floating-form-group mb-4">
                    <label class="floating-form-label z-index-1">{{ localize('Amount') }}<i class="text-danger">*</i></label>
                    <input class="floating-form-control" type="text" name="transfer_amount" id="transfer_amount"
                        placeholder="{{ localize('Transfer Amount') }}" />
                </div>
                <p class="mb-4 ms-3 text-success fs-16 fw-normal fees"></p>
                <div class="floating-form-group mb-4">
                    <label class="floating-form-label">{{ localize('Comments') }}</label>
                    <textarea class="floating-form-control" placeholder="{{ localize('Transfer Comments') }}" rows="5" name="transfer_comments"
                        id="transfer_comments"></textarea>
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
