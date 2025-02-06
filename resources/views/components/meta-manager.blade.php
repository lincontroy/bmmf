<meta charset="utf-8" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="base-url" content="{{ url('/') }}">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="description" content="{{ $_setting->description }}" />
<meta name="author" content="{{ $_setting->title }}" />

{!! SEO::generate(true) !!}

