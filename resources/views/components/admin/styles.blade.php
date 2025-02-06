@php
    use App\Enums\SiteAlignEnum;
@endphp

@if (isset($_setting) &&
        $_setting->site_align &&
        $_setting->site_align->value === SiteAlignEnum::RIGHT_TO_LEFT->value)
<link href="{{ assets('vendor/bootstrap/css/bootstrap.rtl.min.css?v=1.0') }}" rel="stylesheet" />
@else
<link href="{{ assets('vendor/bootstrap/css/bootstrap.min.css?v=1.0') }}" rel="stylesheet" />
@endif

<!--Global Styles(used by all pages)-->
<link href="{{ assets('vendor/metisMenu/metisMenu.css') }}" rel="stylesheet" />
<link href="{{ assets('vendor/fontawesome/css/all.min.css') }}" rel="stylesheet" />
<link href="{{ assets('vendor/typicons/src/typicons.min.css') }}" rel="stylesheet" />
<link href="{{ assets('vendor/themify-icons/themify-icons.min.css') }}" rel="stylesheet" />
<link href="{{ assets('vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ assets('vendor/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ assets('vendor/emojionearea/dist/emojionearea.min.css') }}" rel="stylesheet">
<link href="{{ assets('vendor/material_icons/materia_icons.css') }}" rel="stylesheet">

<!-- Third Party Style(used by this page)-->
@stack('lib-styles')
<!--Start Your Custom Style Now-->

<link id="light-messenger-css" href="{{ assets('css/messenger.css?v=1.0') }}" rel="stylesheet" />
<link id="dark-messenger-css" href="{{ assets('css/messenger-dark.css?v=1.0') }}" rel="stylesheet" />

@if (isset($_setting) &&
        $_setting->site_align &&
        $_setting->site_align->value === SiteAlignEnum::RIGHT_TO_LEFT->value)
    <link id="light-style-new-css" href="{{ assets('css/style-new-rtl.css?v=1.0') }}" rel="stylesheet" />
    <link id="dark-style-new-css" href="{{ assets('css/style-new-rtl-dark.css?v=1.15') }}" rel="stylesheet" />
@else
<link id="dark-style-new-css" href="{{ assets('css/style-new-dark.css?v=1.15') }}" rel="stylesheet" />
    <link id="light-style-new-css" href="{{ assets('css/style-new.css?v=1.15') }}" rel="stylesheet" />
@endif


<link href="{{ assets('css/extra.css?v=1.2') }}" rel="stylesheet" />
@stack('css')
