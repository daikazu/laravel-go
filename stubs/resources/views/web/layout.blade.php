<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
@include('web.layout.head')
</head>
<body>
@include('web.layout.header')
<main>
@yield('main')
</main>
@include('web.layout.footer')
@livewireScripts
{{--<script src="{{ asset( mix('js/manifest.js'))}}"></script>--}}
{{--<script src="{{ asset( mix('js/vendor.js'))}}"></script>--}}
<script src="{{ asset( mix('js/app.js'))}}"></script>
@stack('footer-scripts')
{{--@include('cookieConsent::index')--}}
</body>
</html>
