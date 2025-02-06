@extends('quickexchange::layouts.master')

@section('dataTableConent')
    <!-- Data table -->
    <x-data-table :dataTable="$dataTable" />
    <!-- Data table -->
@endsection

@section('content')
    <x-admin.edit-modal class="modal-lg modal-dialog-scrollable" modalTitle="Quick Exchange Request" />
@endsection

@push('js')
    <script src="{{ module_asset('QuickExchange', 'js/app.js') }}"></script>
@endpush
