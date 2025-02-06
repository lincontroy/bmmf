<!--Global Styles(used by all pages)-->
@php
    use App\Enums\SiteAlignEnum;
@endphp
@if (isset($_auth_user) &&
        $_auth_user->site_align &&
        $_auth_user->site_align->value === SiteAlignEnum::RIGHT_TO_LEFT->value)
    <link href="{{ assets('plugins/bootstrap/css/bootstrap.rtl.min.css') }}" rel="stylesheet" />
@else
    <link href="{{ assets('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
@endif
<link href="{{ assets('plugins/metisMenu/metisMenu.css') }}" rel="stylesheet" />
<link href="{{ assets('plugins/fontawesome/css/all.min.css') }}" rel="stylesheet" />
<link href="{{ assets('plugins/typicons/src/typicons.min.css') }}" rel="stylesheet" />
<link href="{{ assets('plugins/themify-icons/themify-icons.min.css') }}" rel="stylesheet" />
<link href="{{ assets('plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ assets('plugins/silck-slider/slick.min.css') }}" rel="stylesheet" />
<link href="{{ assets('plugins/silck-slider/silck-theme.css') }}" rel="stylesheet" />
<link href="{{ assets('plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ assets('plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ assets('plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ assets('plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ assets('vendor/emojionearea/dist/emojionearea.min.css') }}" rel="stylesheet">
<link href="{{ assets('vendor/material_icons/materia_icons.css') }}" rel="stylesheet">

<!-- Third Party Style(used by this page)-->
@stack('lib-styles')

<link id="light-messenger-css" href="{{ assets('customer/css/messenger.css?v=1.3') }}" rel="stylesheet" />
<link id="dark-messenger-css" href="{{ assets('customer/css/messenger-dark.css?v=1.3') }}" rel="stylesheet" />

@if (isset($_auth_user) &&
        $_auth_user->site_align &&
        $_auth_user->site_align->value === SiteAlignEnum::RIGHT_TO_LEFT->value)
    <link id="light-style-new-css" href="{{ assets('customer/css/style-new-rtl.css?v=1.3') }}" rel="stylesheet" />
    <link id="dark-style-new-css" href="{{ assets('customer/css/style-new-rtl-dark.css?v=1.14') }}" rel="stylesheet" />
@else
    <link id="light-style-new-css" href="{{ assets('customer/css/style-new.css?v=1.14') }}" rel="stylesheet" />
    <link id="dark-style-new-css" href="{{ assets('customer/css/style-new-dark.css?v=1.154') }}" rel="stylesheet" />
@endif

<link href="{{ assets('customer/css/extra.css?v=2.3') }}" rel="stylesheet" />

@stack('css')
