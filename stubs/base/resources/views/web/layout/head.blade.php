@include('web.layout.head.tracking')
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<meta name="csrf-token" content="{{ csrf_token() }}">
@include('web.layout.head.fonts')
@include('web.layout.head.favicon')
@include('web.layout.head.styles')
@include('web.layout.head.scripts')
<x-meta-data/>
@stack('head')
