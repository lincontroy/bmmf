<div class="table-responsive">
    {{ $dataTable->table() }}
</div>

@push('lib-styles')
    <link rel="stylesheet" href="{{ assets('vendor/yajra-laravel-datatables/assets/datatables.min.css') }}">
@endpush

@push('css')
    <link rel="stylesheet" href="{{ assets('css/data-table.min.css') }}">
@endpush

@push('lib-scripts')
    <script src="{{ assets('vendor/yajra-laravel-datatables/assets/datatables.js') }}"></script>
@endpush

@push('js')
    {{ $dataTable->scripts() }}
    <script src="{{ assets('js/datatables.active.min.js') }}"></script>
@endpush
