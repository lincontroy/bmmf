<x-app-layout>
    <div class="body-content">
        <div class="row gy-4">
            <div class="col-12">
                <div class="card py-4 px-3 radius-15">
                    @hasSection('card_header_content')
                        <div
                            class="d-flex flex-column flex-lg-row gap-3 justify-content-between align-items-center mb-3">
                            @yield('card_header_content')
                        </div>
                    @endif
                    @hasSection('dataTableConent')
                        @yield('dataTableConent')
                    @endif
                    @hasSection('contentData')
                        @yield('contentData')
                    @endif
                </div>
            </div>
        </div>
        @yield('content')
    </div>
</x-app-layout>
