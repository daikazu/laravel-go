<?php

namespace Daikazu\LaravelGo\Observers;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Spatie\Crawler\CrawlObservers\CrawlObserver;

class FetchUrlCrawlObserver extends CrawlObserver
{
    private $content;

    private Collection $urls;

    private array $filter;

    public function __construct($filter)
    {
        $this->content = null;
        $this->urls = collect();
        $this->filter = $filter;
    }

    /**
     * Called when the crawler will crawl the url.
     *
     * @param  \Psr\Http\Message\UriInterface  $url
     */
    public function willCrawl(UriInterface $url): void
    {
//        Log::info('willCrawl',['url'=>$url]);
    }

    /**
     * Called when the crawler has crawled the given url successfully.
     *
     * @param  \Psr\Http\Message\UriInterface  $url
     * @param  \Psr\Http\Message\ResponseInterface  $response
     * @param  \Psr\Http\Message\UriInterface|null  $foundOnUrl
     */
    public function crawled(
        UriInterface $url,
        ResponseInterface $response,
        ?UriInterface $foundOnUrl = null
    ): void {
        if ($response->getStatusCode() == 200) {
            $this->urls->push($url->getPath());
        }
    }

    /**
     * Called when the crawler had a problem crawling the given url.
     *
     * @param  \Psr\Http\Message\UriInterface  $url
     * @param  \GuzzleHttp\Exception\RequestException  $requestException
     * @param  \Psr\Http\Message\UriInterface|null  $foundOnUrl
     */
    public function crawlFailed(
        UriInterface $url,
        RequestException $requestException,
        ?UriInterface $foundOnUrl = null
    ): void {
        Log::error('crawlFailed', ['url' => $url, 'error' => $requestException->getMessage()]);
    }

    /**
     * Called when the crawl has ended.
     */
    public function finishedCrawling(): void
    {
        Log::info('finishedCrawling');
        $test = $this->urls->filter(function ($url) {
            return ! str($url)->startsWith($this->filter) and $url !== '';
        });

        ray($test->sort()->flatten());
    }
}
