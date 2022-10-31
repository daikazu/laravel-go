<?php

namespace Daikazu\LaravelGo\Commands;

use Daikazu\LaravelGo\Observers\FetchUrlCrawlObserver;
use GuzzleHttp\RequestOptions;
use Illuminate\Console\Command;
use Spatie\Crawler\Crawler;
use Spatie\Crawler\CrawlProfiles\CrawlInternalUrls;

class DuplicateWebsiteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'go:duplicate
                            {url : Website you want to Duplicate}
                            {--filter= : Filter out site URLs. Excepts comma seperated values i.e. --filter=/blog,/images }
                            {--depth= : Depth of the crawl. default is 1000}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Duplicate a website and create a static version of it in the Laravel-Go way';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $url = $this->argument('url');

        $filter = explode(',', $this->option('filter'));

        array_push($filter, '/cdn-cgi/');

        array_walk($filter, function (&$value) use ($url) {
            $value = $url.$value;
        });

        $crawlLimit = 1000;

        if ($this->option('depth')) {
            $crawlLimit = (int) $this->option('depth');
        }

        $this->info("Collecting URLs for $url");

        Crawler::create([
            RequestOptions::ALLOW_REDIRECTS => true, RequestOptions::TIMEOUT => 30,
            RequestOptions::CONNECT_TIMEOUT => 10, RequestOptions::READ_TIMEOUT => 10,
        ])
            ->acceptNofollowLinks()
            ->ignoreRobots()
            ->setParseableMimeTypes(['text/html', 'text/plain'])
            ->setCrawlObserver(new FetchUrlCrawlObserver(rootURL: $url, filter: $filter))
            ->setCrawlProfile(new CrawlInternalUrls($url))
            ->setMaximumResponseSize(1024 * 1024 * 2) // 2 MB maximum
            ->setTotalCrawlLimit($crawlLimit) // limit defines the maximal count of URLs to crawl
            // ->setConcurrency(1) // all urls will be crawled one by one
            ->setDelayBetweenRequests(100)
            ->startCrawling($url);

        $this->info("URL Collecting for $url is completed (Spiders taking over!)");

        return Command::SUCCESS;
    }
}
