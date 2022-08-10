@if(app()->environment() === 'production')

    {{--<!-- Global site tag (gtag.js) - Google Analytics -->--}}
    @if(config('website.tracking.google_analytics_id'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{config('website.tracking.google_analytics_id')}}"></script>
        <script> window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', '{{config('website.tracking.google_analytics_id')}}');
            gtag('config', '{{config('website.tracking.google_analytics_id')}}', {'send_page_view': false});
            @if(config()->has('analytics-event-tracking'))
            gtag('event', 'page_view', {'event_callback': function(){
                @sendAnalyticsClientId
                }});
            @endif
        </script>
    @endif

@endif
