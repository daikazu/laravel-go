<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
@include('web.layout.head')
</head>
<body>
<div class="min-h-screen bg-gray-100">
@include('web.layout.header')
<main>
@yield('main')
</main>
@include('web.layout.footer')
{{--<script src="{{ asset( mix('js/manifest.js'))}}"></script>--}}
{{--<script src="{{ asset( mix('js/vendor.js'))}}"></script>--}}
<script src="{{ asset( mix('js/app.js'))}}"></script>
@livewireScripts
@stack('footer-scripts')
{{--@include('cookieConsent::index')--}}
</body>
</html>
