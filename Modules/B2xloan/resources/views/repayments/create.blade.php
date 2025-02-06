@extends('quickexchange::layouts.master')

@section('dataTableConent')
    <!-- Data table -->
    <x-data-table :dataTable="$dataTable" />
    <!-- Data table -->
@endsection
