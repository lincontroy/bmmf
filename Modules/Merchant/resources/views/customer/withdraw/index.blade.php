@extends('finance::customer.layouts.master')

@section('card_header_content')
    <h5 class="m-0 fs-20 fw-semi-bold">{{ localize('Withdraw List') }}</h5>
    <div class="d-flex align-items-center gap-2">
        <div class="border radius-10 p-1">
            <a href="{{ route('customer.withdraw.create') }}" class="btn btn-save lh-sm">
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 6H11M6 1V11" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    </path>
                </svg>
                <span class="me-1">{{ localize('Withdraw') }}</span>
            </a>
        </div>
    </div>
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
