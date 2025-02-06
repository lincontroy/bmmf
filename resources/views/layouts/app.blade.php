@php
    use App\Enums\SiteAlignEnum;
@endphp
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if($_setting->site_align->value === SiteAlignEnum::RIGHT_TO_LEFT->value) dir="rtl" @endif>

<head>
    {{-- meta manager --}}
    <x-meta-manager />
    {{-- favicon --}}
    <x-favicon />
    <!--admin style -->
    <x-admin.styles />
    <!--end admin style -->
</head>

<body {{ $attributes->merge(['class' => 'fixed sidebar-mini']) }}>
    <!--page loader -->
    <x-admin.preloader />
    <!--end page loader -->

    <div class="wrapper">
        <!--sidebar  -->
        <x-admin.left-sidebar />
        <!--end sidebar  -->

        <!--page content  -->
        <div class="content-wrapper">

            <!--main content-->
            <div class="main-content">
                <!--navbar-->
                <x-admin.header />
                <!--end navbar-->

                <!--boyd content-->
                <div class="body-content">
                    {{ $slot }}
                </div>
                <!-- end body content -->
            </div>
            <!--end main content-->

            <div class="overlay"></div>
        </div>
        <!--end page content -->
    </div>

    <!--admin scripts -->
    <x-admin.scripts />
    <!--end admin scripts -->

</body>

</html>
