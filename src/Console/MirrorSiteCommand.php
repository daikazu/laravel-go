<?php

namespace Daikazu\LaravelGo\Console;

use Illuminate\Console\Command;
use Spatie\Crawler\Crawler;

class MirrorSiteCommand extends Command
{

//    private Crawler $crawler;


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'go:mirror {url : Root website Url to copy.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mirror an existing website structure and content?';

    /**
     * Create a new command instance.
     *
     * @return void
     */
//    public function __construct(Crawler $crawler)
    public function __construct()
    {
        parent::__construct();

//        $this->crawler = $crawler;


    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

return 0;




    }
}
