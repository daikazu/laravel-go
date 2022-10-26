<?php

namespace Daikazu\LaravelGo\Commands;

use Illuminate\Console\Command;

class InitCommand extends Command
{
    protected $signature = 'go:init {--d|default : Use default packages shown in the README.md}';

    protected $description = 'Creates the go-packages.json file located in your project root.';

    private $file = 'go-packages.clean.json';

    public function handle(): int
    {
        if ($this->option('default')) {
            $this->file = 'go-packages.default.json';
        }

        copy(__DIR__.'/../../stubs/misc/'.$this->file, base_path('go-packages.json'));

        $this->info('the <fg=blue;options=bold>go-packages.json</> has been created.');

        return self::SUCCESS;
    }
}
