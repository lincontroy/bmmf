@extends('finance::customer.layouts.master')

@section('card_header_content')
    <h5 class="m-0 fs-20 fw-semi-bold">{{ localize('Deposit') }}</h5>
    <div class="d-flex align-items-center gap-2">
        <div class="border radius-10 p-1">
            <a href="{{ route('customer.deposit.index') }}" class="btn btn-save lh-sm">
                <span class="me-1">{{ localize('Deposit List') }}</span>
            </a>
        </div>
    </div>
@endsection
@section('contentData')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-4">
            <x-message />
            <form action="{{ route('customer.deposit.store') }}" method="post" enctype="multipart/form-data" class="py-4">
                @csrf

                <input type="hidden" name="payment_method" value="1">

                <!-- Currency Selection -->
                <div class="mb-3">
                    <label for="payment_currency" class="form-label">{{ localize('Currency') }} <i class="text-danger">*</i></label>
                    <select class="form-select" name="payment_currency" id="payment_currency" required>
                        <option value="">Select deposit currency</option>    
                        <option value="5">BTC</option>
                        <option value="7">USDT</option>
                    </select>
                </div>

                

              


                <!-- Deposit Amount -->
                <div class="floating-form-group mb-4">
                    <label class="floating-form-label z-index-1">{{ localize('Amount') }}<i class="text-danger">*</i></label>
                    <div class="input-group mb-3">
                        <span class="input-group-text custom-input-group-text" id="deposit-amount-dollar">$</span>
                        <input class="floating-form-control ms-35" type="text" name="deposit_amount" id="deposit_amount"
                            placeholder="{{ localize('Amount in USD') }}" aria-describedby="deposit-amount-dollar" />
                    </div>
                </div>

                <p class="mb-4 ms-3 text-success fs-16 fw-normal fees"></p>

                 <!-- Wallet Address Display -->
                 <div id="wallet-address-container" class="floating-form-group mb-4" style="display: none;">
                    <label class="floating-form-label">{{ localize('Send funds to the Wallet Address below') }}</label><br><hr>
                    <div class="input-group">
                        <input type="text" class="floating-form-control" id="wallet_address" readonly>
                        <button type="button" class="btn btn-outline-secondary" onclick="copyWalletAddress()">Copy</button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button class="btn btn-save w-100" type="submit">{{ localize('After transfer click here') }}</button>
            </form>
        </div>
    </div>
    @push('js')
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const walletAddresses = {
            "5": "bc1qxy2kgdygjrsqtzq2n0yrf2493p83kkfjhx0wlh", // BTC Address
            "7": "0x3b929066b4298e4d8a3391a9364d8b962cf51af1"  // USDT Address
        };

        const currencySelect = document.getElementById("payment_currency");
        const walletAddressInput = document.getElementById("wallet_address");
        const walletContainer = document.getElementById("wallet-address-container");

        currencySelect.addEventListener("change", function () {

        console.log("Currency selected: ", this.value);
            const selectedCurrency = this.value;
            if (walletAddresses[selectedCurrency]) {
                walletAddressInput.value = walletAddresses[selectedCurrency];
                walletContainer.style.display = "block";
            } else {
                walletContainer.style.display = "none";
            }
        });

        if (currencySelect.value) {
            currencySelect.dispatchEvent(new Event('change'));
        }
    });

    function copyWalletAddress() {
        const walletAddressInput = document.getElementById("wallet_address");
        navigator.clipboard.writeText(walletAddressInput.value).then(() => {
            alert("Wallet address copied!");
        });
    }
</script>
        <script src="{{ assets('js/pages/axios.min.js') }}"></script>
        <script src="{{ module_asset('Finance', 'js/app.js') }}"></script>
        
    @endpush

    @endsection


