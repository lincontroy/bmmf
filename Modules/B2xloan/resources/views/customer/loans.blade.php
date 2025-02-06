@extends('b2xloan::customer.layouts.master')

@section('card_header_content')
    <h3 class="m-0 fs-20 fw-semi-bold">{{ localize('loans') }}</h3>
@endsection
@section('contentData')
    <x-message />
    <!-- Data table -->
    <x-data-table :dataTable="$dataTable" />

    <x-b2xloan::withdraw_request :paymentGateway="$paymentGateway" />

    @push('js')
        <script src="{{ assets('js/pages/axios.min.js') }}"></script>
        <script src="{{ module_asset('B2xloan', 'js/calculator.js') }}"></script>
    @endpush
@endsection
