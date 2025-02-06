@extends('finance::customer.layouts.master')

@section('card_header_content')
    <h5 class="m-0 fs-20 fw-semi-bold">{{ localize('repayments') }}</h5>
@endsection
@section('contentData')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- Data table -->
            <x-data-table :dataTable="$dataTable" />
            <!-- Data table -->
        </div>
    </div>
@endsection
