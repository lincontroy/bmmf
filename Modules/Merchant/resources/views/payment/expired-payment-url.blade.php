<x-payment-layout :paymentUrl="$merchantPaymentUrl->uu_id" amount="0">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>{{ localize('Expiration') }}</h4>
                    </div>
                    <div class="card-body text-center">
                        <div class="alert alert-danger" role="alert">
                            {{ localize('The duration has expired') }}
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="javascript:void(0)" class="btn btn-primary">Back to Home</a>
                        {{-- <a href="{{ $merchantPaymentUrl->calback_url }}" class="btn btn-primary">Back to Home</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-payment-layout>
