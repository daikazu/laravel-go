<?php

namespace Daikazu\LaravelGo\Jobs;

use DOMDocument;
use DOMNode;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DuplicateWebsiteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $rootURL;

    private string $stub = __DIR__.'/../../stubs/new/static-duplicated-page.blade.php';

    private string $folder = 'views/web/sections/static/';

    public function __construct(public Collection $urls)
    {
        $parsedUrl = parse_url($urls->first());
        $this->rootURL = $parsedUrl['scheme'].'://'.$parsedUrl['host'];
    }

    public function handle()
    {
        Config::set('filesystems.disks.go_resource', [
            'driver' => 'local',
            'root' => resource_path(),
        ]);

        foreach ($this->urls->toArray() as $key => $url) {
            $request = Http::get($url);

            if ($request->status() !== 200) {
                exit;
            }

            $doc = new DOMDocument();
            $internalErrors = libxml_use_internal_errors(true);
            $doc->loadHTML($request->body());
            libxml_use_internal_errors($internalErrors);

            try {
                $header = $doc->getElementsByTagName('header')->item(0);
                if ($header) {
                    $this->downloadImagesFromNode($header);
                    Storage::disk('go_resource')->put('views/web/layout/header.blade.php',
                        "<header>{$this->DOMinnerHTML($header)}</header>");
                }
            } catch (Exception) {
            }

            try {
                $footer = $doc->getElementsByTagName('footer')->item(0);
                if ($footer) {
                    $this->downloadImagesFromNode($footer);
                    Storage::disk('go_resource')->put('views/web/layout/footer.blade.php',
                        "<footer>{$this->DOMinnerHTML($footer)}</footer>");
                }
            } catch (Exception) {
            }

            // Get the page title
            $title = $doc->getElementsByTagName('title')->item(0)->textContent;

            // get the meta description
            $xpath = new \DOMXPath($doc);
            $metDescription = $xpath->query('//meta[@name="description"]')->item(0)->getAttribute('content');

            $body = $doc->getElementsByTagName('body')->item(0);
            $this->removeHeaderFooter($body);
//            $this->downloadImagesFromNode($body);

            // Generate Routes and File
            $routeUrl = (string) str($url)->replace($this->rootURL, '')->lower();

            $routeName = (string) str($routeUrl)->endsWith('/') ? str($routeUrl)->replaceLast('/', '.index') : $routeUrl;
            $routeName = (string) str($routeName)->startsWith('/') ? str($routeName)->replaceFirst('/', '') : $routeName;
            $routeName = (string) str($routeName)->startsWith('.') ? str($routeName)->replaceFirst('.', '') : $routeName;

            $fileName = (string) str($routeName)->append('.blade.php');

            $routeName = (string) str($routeName)->replace('/', '.');
            $routeName = (string) ($routeName === 'index') ? 'home' : $routeName;

            ray($routeUrl, $routeName, $fileName);
        }
    }

    private function downloadImagesFromNode(&$node)
    {
        $images = $node->getElementsByTagName('img');

        foreach ($images as $image) {
            $src = $image->getAttribute('src');
            $image->setAttribute('src', $this->downloadImage($src));
        }
    }

    private function downloadImage($imageURL)
    {
        $name = basename($imageURL);

        if (! str($imageURL)->startsWith($this->rootURL)) {
            $imageURL = $this->rootURL.$imageURL;
        }

        try {
            $contents = file_get_contents($imageURL);
            $save_path = resource_path('assets/'.$name);
            file_put_contents($save_path, $contents);

            return "{{ asset('images/{$name}') }} ";  // Make this a blade string
        } catch (Exception) {
            return $imageURL;
        }
    }

    private function DOMinnerHTML(DOMNode $element)
    {
        $innerHTML = '';
        $children = $element->childNodes;

        foreach ($children as $child) {
            $innerHTML .= $element->ownerDocument->saveHTML($child);
        }

        return urldecode($innerHTML);
    }

    private function removeHeaderFooter(&$doc)
    {
        $header = $doc->getElementsByTagName('header')->item(0);
        $footer = $doc->getElementsByTagName('footer')->item(0);

        if ($header) {
            $header->parentNode->removeChild($header);
        }

        if ($footer) {
            $footer->parentNode->removeChild($footer);
        }

        while (($r = $doc->getElementsByTagName('script')) && $r->length) {
            $r->item(0)->parentNode->removeChild($r->item(0));
        }

        while (($r = $doc->getElementsByTagName('style')) && $r->length) {
            $r->item(0)->parentNode->removeChild($r->item(0));
        }
    }
}
