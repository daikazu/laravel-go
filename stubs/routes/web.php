<?php

Route::feeds();
Route::get('sitemap.xml', function () {
    try {
        return response(file_get_contents(storage_path('app/sitemap.xml')), 200, [
            'Content-Type' => 'application/xml'
        ]);
    } catch (Exception $e) {}
});

Route::view('/', 'web.sections.static.home')->name('home');
