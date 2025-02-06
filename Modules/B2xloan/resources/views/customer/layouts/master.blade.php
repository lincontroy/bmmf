<x-customer-app-layout>
    <div class="card py-4 pb-0 shadow-none radius-15">
        @hasSection('card_header_content')
            <div
                class="card-header align-items-center d-flex flex-column flex-lg-row gap-3 justify-content-between pt-0 px-4 px-xl-5">
                @yield('card_header_content')
            </div>
        @endif
        <div class="card-body">
            @hasSection('contentData')
                @yield('contentData')
            @endif
        </div>
    </div>
    @hasSection('content')
        @yield('content')
    @endif
    @push('js')
        <script src="{{ module_asset('B2xloan', 'js/calculator.js') }}"></script>
    @endpush
</x-customer-app-layout>
