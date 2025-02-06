<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    {{-- meta manager --}}
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="{{ $_setting->description }}" />
    <meta name="author" content="{{ $_setting->title }}" />
    {!! SEO::generate(true) !!}

    {{-- favicon --}}
    <x-favicon />

    {{-- style --}}
    <x-payment.styles />
</head>

<body {{ $attributes->merge(['class' => '']) }}>
    <div class="bg-primary py-2">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <a
                    href="{{ isset($paymentUrl) && !empty($paymentUrl) ? route('payment.index', ['payment_url' => $paymentUrl]) : 'javascript:void(0)' }}">
                    <img height="50" width="100" class="img-circle" src="{{ $storeLogo?storage_asset($storeLogo):assets('img/payment-logo.png') }}" alt="payment-logo" /> <span class="text-white">{{ $storeName }}</span>
                </a>

                @if ($amount)
                    <p class="mb-0 fw-semi-bold fs-18 text-white">${{ number_format($amount, 2) }}</p>
                @endif
            </div>
        </div>
    </div>
    <div class="container pt-5">
        {{ $slot }}
    </div>

    {{-- scripts --}}
    <x-payment.scripts />
</body>

</html>
