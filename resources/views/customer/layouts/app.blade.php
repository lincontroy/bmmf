@php
    use App\Enums\SiteAlignEnum;
@endphp
<!doctype html >
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"   dir="{{ ($_auth_user->site_align && $_auth_user->site_align->value === SiteAlignEnum::RIGHT_TO_LEFT->value) ? 'rtl' : null }}" >

<head>
    {{-- meta manager --}}
    <x-meta-manager />
    {{-- favicon --}}
    <x-favicon />
    <!--customer style -->
    <x-customer.styles />
    <!--end customer style -->
</head>

<body {{ $attributes->merge(['class' => 'fixed sidebar-mini']) }}>
    <!--page loader -->
    <x-customer.preloader />
    <!--end page loader -->

    <div class="wrapper">
        <!--sidebar  -->
        <x-customer.left-sidebar />
        <!--end sidebar  -->

        <!--page content  -->
        <div class="content-wrapper">

            <!--main content-->
            <div class="main-content">
                <!--navbar-->
                <x-customer.header />
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

    <!--customer scripts -->
    <x-customer.scripts />
    <!--end customer scripts -->

</body>

</html>
