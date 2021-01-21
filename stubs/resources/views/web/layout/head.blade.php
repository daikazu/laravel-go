@include('web.layout.head.tracking')
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">
<x-meta-data/>
@include('web.layout.head.favicon')
@include('web.layout.head.fonts')
@include('web.layout.head.scripts')
@include('web.layout.head.styles')
