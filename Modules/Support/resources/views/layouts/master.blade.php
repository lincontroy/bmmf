<x-app-layout>
    <div class="body-content">
        <div class="row gy-4">
            <div class="col-12">
                @hasSection('contentData')
                    @yield('contentData')
                @endif
            </div>
        </div>
        @yield('content')
    </div>
    @push('js') 
        <script src="{{ module_asset('Support', 'js/app.js') }}"></script>
    @endpush



</x-app-layout>