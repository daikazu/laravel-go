<?php
return [
    "title"         => ":site_name",
    "description"   => "Get up and get going!",
    "email"         => "example@example.com",
    "phone"         => "1-800-555-5555",
    "address"       => [
        "street"  => "",
        "city"    => "",
        "state"   => "",
        "zipcode" => "",
    ],
    "hours"         => "Monday - Friday 8am-6pm ET",
    "social"        => [
        "facebook"     => null,
        "twitter"      => null,
        "twitter_name" => null,
        "instagram"    => null,
        "youtube"      => null,
    ],
    "creation_year" => "2021",
    "misc"          => [],
    'tracking'      => [
        'google_analytics_id' => env('GOOGLE_ANALYTICS_TRACKING_ID')
    ]
];
