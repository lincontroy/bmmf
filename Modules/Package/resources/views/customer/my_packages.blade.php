@extends('package::customer.layouts.master')

@section('card_header_content')
    <h3 class="m-0 fs-20 fw-semi-bold">{{ localize('my_packages') }}</h3>
@endsection
@section('contentData')
    <!-- Data table -->
    <x-data-table :dataTable="$dataTable" />
@endsection
