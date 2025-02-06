@extends('quickexchange::layouts.master')

@section('card_header_content')
    <h3 class="fs-24 mb-0 text-color-2 fw-medium lh-1">{{ localize('fees_history') }}</h3>
@endsection

@section('dataTableConent')
    <!-- Data table -->
    <x-data-table :dataTable="$dataTable" />
    <!-- Data table -->
@endsection
