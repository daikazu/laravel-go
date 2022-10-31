<?php

namespace Daikazu\LaravelGo\Jobs;

use DOMDocument;
use DOMNode;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;

class ChangeUrlsToRouteNamesJob implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public function __construct(public string $rootURL)
    {

    }

    public function handle()
    {

        //TODO WIP

        $routeList = collect(\Route::getRoutes()->getRoutes())->pluck('uri', 'action.as');

        $files = collect(File::allFiles(resource_path('views/web/sections/static/')));

        //loop through files
        $files->each(function ($file) use ($routeList) {

            $fileContent = File::get($file->getPathname());

            $doc = new DOMDocument();
            $internalErrors = libxml_use_internal_errors(true);
            $doc->loadHTML($fileContent);
            libxml_use_internal_errors($internalErrors);

            $anchors = $doc->getElementsByTagName('a');

            foreach ($anchors as $a) {

                $originalUrl = $a->getAttribute('href');

                $removedUrl = str_replace($this->rootURL, '', $originalUrl);

                $searchUrl = str($removedUrl)->after('/')->beforeLast('?')->beforeLast('#')->toString();

                $matched =  $routeList->search( $searchUrl);

                $a->setAttribute('href', "{{ route('{$matched}')}}");
            }

            //save file
            File::put($file->getPathname(), $this->DOMinnerHTML($doc));

        });


    }

    private function DOMinnerHTML(DOMNode $element): string
    {
        $innerHTML = "";
        $children = $element->childNodes;

        foreach ($children as $child) {
            $innerHTML .= $element->ownerDocument->saveHTML($child);
        }

        return urldecode($innerHTML);
    }


}
