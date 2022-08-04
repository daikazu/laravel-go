<?php

namespace Daikazu\LaravelGo\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class InstallCommand extends Command
{
    protected $signature = 'go:install {--f|force : Force running install more than once} {--d|default : Install with default packages}';

    protected $description = 'Install the Laravel Go scaffolding';

    private $hasRun = false;

    public function __construct()
    {
        parent::__construct();

        if (file_exists(config_path('website.php'))) {
            $this->hasRun = true;
        }
    }

    public function handle()
    {
        if ($this->option('default')) {
            $this->call('go:init', ['--default' => true]);
        }

        if ($this->hasRun and ! $this->option('force')) {
            $this->warn('Install command has already been run. Use the -f option to force installation.');

            return null;
        }

        try {
            $configFile = json_decode(file_get_contents(base_path('go-packages.json')));
        } catch (\ErrorException $e) {
            $this->error('No such file or directory. please make sure you have the go-packages.json file in your application root folder.');
            exit;
        }

        $this->writeWelcomeMessage();

        $siteName = $this->ask('Site Name');

        // Composer packages...
        // require
        if (collect($configFile->composer_packages)->has('require')) {
            $this->updateComposerPackages(function ($packages) use ($configFile) {
                return (array) $configFile->composer_packages->require + $packages;
            });
        }
        // require dev
        if (collect($configFile->composer_packages)->has('require-dev')) {
            $this->updateComposerPackages(function ($packages) use ($configFile) {
                return (array) $configFile->composer_packages->{'require-dev'} + $packages;
            }, true);
        }

        // NPM Packages...
        if (collect($configFile->npm_packages)->has('dependencies')) {
            $this->updateNodePackages(function ($packages) use ($configFile) {
                return (array) $configFile->npm_packages->dependencies + $packages;
            });
        }

        if (collect($configFile->npm_packages)->has('devDependencies')) {
            $this->updateNodePackages(function ($packages) use ($configFile) {
                return (array) $configFile->npm_packages->devDependencies + $packages;
            }, true);
        }

        // copy base files..
        (new Filesystem)->cleanDirectory(resource_path('views'));
        $this->copyFiles(__DIR__.'/../../stubs/base/', base_path());

//        // Misc..
        (new Filesystem)->ensureDirectoryExists(resource_path('assets'));
        copy(__DIR__.'/../../stubs/misc/empty_gitkeep.txt', resource_path('assets/.gitkeep'));
        (new Filesystem)->ensureDirectoryExists(resource_path('svg'));
        copy(__DIR__.'/../../stubs/misc/empty_gitkeep.txt', resource_path('svg/.gitkeep'));

        $this->updateComposerScripts();

        $this->replaceInFile(':site_name', $siteName, base_path('config/seotools.php'));
        $this->replaceInFile(':site_name', $siteName, base_path('config/website.php'));
        $this->replaceInFile(':site_name', $siteName, resource_path('views/web/layout/footer.blade.php'));
        $this->replaceInFile(':site_name', $siteName, resource_path('views/web/layout/header.blade.php'));
        $this->replaceInFile(':site_name', $siteName, resource_path('views/web/sections/static/home.blade.php'));

        $this->info('<fg=red;options=bold>Laravel Go</> scaffolding installed successfully.');
        $this->comment('Please execute the "composer update" command to install added dependencies.');
        $this->comment('Please execute the "npm install && npm run dev" command to build your assets.');
    }

    /**
     * Update the "package.json" file.
     *
     * @param  callable  $callback
     * @param  bool  $dev
     * @return void
     */
    protected static function updateNodePackages(callable $callback, $dev = true)
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    /**
     * Update the "composer.json" file.
     *
     * @param  callable  $callback
     * @param  bool  $dev
     * @return void
     */
    protected static function updateComposerPackages(callable $callback, $dev = false)
    {
        if (! file_exists(base_path('composer.json'))) {
            return;
        }

        $configurationKey = $dev ? 'require-dev' : 'require';

        $packages = json_decode(file_get_contents(base_path('composer.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('composer.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    private function updateComposerScripts()
    {
        if (! file_exists(base_path('composer.json'))) {
            return;
        }
        $items = [
            '@php artisan vendor:publish --force --tag=livewire:assets --ansi',
            '@php artisan storage:link',
        ];

        $composer = json_decode(file_get_contents(base_path('composer.json')), true);

        foreach ($items as $item) {
            if (array_key_exists('post-autoload-dump', $composer['scripts'])) {
                if (! in_array($item, $composer['scripts']['post-autoload-dump'])) {
                    array_push($composer['scripts']['post-autoload-dump'], $item);
                }
            }
        }

        file_put_contents(
            base_path('composer.json'),
            json_encode($composer, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    /**
     * Delete the "node_modules" directory and remove the associated lock files.
     *
     * @return void
     */
    protected static function flushNodeModules()
    {
        tap(new Filesystem, function ($files) {
            $files->deleteDirectory(base_path('node_modules'));
            $files->delete(base_path('yarn.lock'));
            $files->delete(base_path('package-lock.json'));
        });
    }

    /**
     * Replace a given string within a given file.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $path
     * @return void
     */
    protected function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }

    public function writeWelcomeMessage()
    {
        $asciiLogo = <<<EOT
<fg=green>     __                                __   ______     </><fg=red>     __ </>
<fg=green>    / /   ____ __________ __   _____  / /  / ____/___  </><fg=red>     \ \ </>
<fg=green>   / /   / __ `/ ___/ __ `/ | / / _ \/ /  / / __/ __ \ </><fg=red> _____\ \ </>
<fg=green>  / /___/ /_/ / /  / /_/ /| |/ /  __/ /  / /_/ / /_/ / </><fg=red>/_____/ / </>
<fg=green> /_____/\__,_/_/   \__,_/ |___/\___/_/   \____/\____/  </><fg=red>     /_/ </>
EOT;

        $this->line("\n".$asciiLogo."\n");
    }

    private function copyFiles($src, $dst)
    {
        $dir = opendir($src);

        @mkdir($dst);

        foreach (scandir($src) as $file) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src.'/'.$file)) {
                    $this->copyFiles($src.'/'.$file, $dst.'/'.$file);
                } else {
                    copy($src.'/'.$file, $dst.'/'.$file);
                }
            }
        }

        closedir($dir);
    }
}
