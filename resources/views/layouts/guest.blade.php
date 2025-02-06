<!doctype html>
<html lang="en">

<head>
    {{-- meta manager --}}
    <x-meta-manager />
    {{-- favicon --}}
    <x-favicon />
    {{-- style --}}
    <x-admin.styles />
</head>

<body {{ $attributes }}>

    <div class="d-flex align-items-center justify-content-center h-100vh">
        <div class="form-wrapper m-auto">
            {{ $slot }}
        </div>
    </div>

    <!--admin scripts -->
    <x-admin.scripts />
    <!--end admin scripts -->
</body>

</html>
