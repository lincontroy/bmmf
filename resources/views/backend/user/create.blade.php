@php
    use App\Enums\SiteAlignEnum;

@endphp
<x-app-layout>
    <div class="row">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h3 class="mr-auto p-3">{{ localize('Manage Users') }}</h3>
                    <div class="btn-group" role="group">
                        <a class="btn btn-primary" href="{{ route('admin.user.create') }}">{{ localize('Add') }}</a>
                    </div>

                </div>
            </div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>

    @push('js')
        <script src="{{ assets('vendor/yajra-laravel-datatables/assets/datatables.js') }}"></script>

        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @endpush
</x-app-layout>
