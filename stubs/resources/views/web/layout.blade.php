<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
@include('web.layout.head')
</head>
<body @class(['debug-screens' => (config('app.env') === 'local')])>
<noscript>
    <p class="relative z-50 py-3 px-4 bg-gray-100 border-b border-gray-200 text-center font-bold text-xs text-gray-600">{{ __('strings.no_script') }}</p>
</noscript>
<a class="fixed hidden md:block bottom-safe left-8 py-2 px-4 bg-primary text-white text-sm font-bold translate-y-24 opacity-0 focus-visible:translate-y-0 focus-visible:opacity-100 focus:outline-none focus-visible:ring-2 ring-primary ring-offset-2 motion-safe:transition-all" href="#content">
    {{ __('strings.skip_to_content')}}
</a>
@include('web.layout.header')
<main id="content">
@yield('main')
</main>
@include('web.layout.footer')
@livewireScripts
<script src="{{ asset( mix('js/app.js'))}}"></script>
@stack('footer-scripts')
{{--@include('cookieConsent::index')--}}
</body>
</html>
