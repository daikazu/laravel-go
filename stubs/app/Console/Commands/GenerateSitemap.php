<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Spatie\Sitemap\Tags\Url;
use Spatie\Sitemap\SitemapGenerator;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate {--I|images : With Images}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): mixed
    {
        SitemapGenerator::create(config('app.url'))
            ->hasCrawled(
                function (Url $url) {
                    if (!$this->option('images')) {
                        if (Str::contains($url->url, ['.jpg', '.png', '.gif'])) return null;
                    }
                    return $url;
                }
            )
            ->writeToFile(storage_path('app/sitemap.xml'));
        return 0;
    }
}
