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

    <a href="https://wa.me/447445619112" target="_blank" class="whatsapp-button">
    <i class="fab fa-whatsapp"></i>
</a>

<!-- WhatsApp Button CSS -->
<style>
    .whatsapp-button {
        position: fixed;
        bottom: 20px;
        left: 20px;  /* Changed from right to left */
        background-color: #25D366;
        color: white;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        font-size: 30px;
        z-index: 1000;
    }

    .whatsapp-button i {
        color: white;
    }
</style>
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
    <!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/67b744d10429ca1916ecc060/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->

</body>

</html>
