<?php


namespace Daikazu\LaravelGo\Console;


use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class InstallCommand extends Command
{


    protected $signature = 'go:install {--f|force : Force running install more than once}';

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

        if ($this->hasRun and !$this->option('force')) {
            $this->warn('Install command has already been run. Use the -f option to force installation.');
            return null;
        }

        $basename = basename(base_path()); //app folder name

        $this->writeWelcomeMessage();

        $siteName = $this->ask('Site Name');

        // Composer packages...
        $this->updateComposerPackages(function ($packages) {
            return [
                    "artesaos/seotools"               => "^0.20.0",
                    "spatie/schema-org"               => "^3.3",
                    "illuminatech/url-trailing-slash" => "*",
                    "livewire/livewire"               => "^2.4",
                    "spatie/laravel-backup"           => "^7.4",
                    "spatie/laravel-sitemap"          => "^6.0",

                ] + $packages;
        });

        // NPM Packages...
        $this->updateNodePackages(function ($packages) {
            return [
                    "@tailwindcss/aspect-ratio"   => "^0.2.0",
                    "@tailwindcss/forms"          => "^0.3.2",
                    "@tailwindcss/typography"     => "^0.4.0",
                    'alpinejs'                    => '^2.8.2',
                    "autoprefixer"                => "^10.2.5",
                    "axios"                       => "^0.21.1",
                    "browser-sync"                => "^2.26.14",
                    "browser-sync-webpack-plugin" => "^2.3.0",
                    "color"                       => "^3.1.3",
                    "cross-env"                   => "^7.0.3",
                    "laravel-mix"                 => "^6.0.16",
                    "lodash"                      => "^4.17.21",
                    "postcss"                     => "^8.2.9",
                    "postcss-import"              => "^14.0.1",
                    "resolve-url-loader"          => "^3.1.2",
                    "sass"                        => "^1.32.8",
                    "sass-loader"                 => "^11.0.1",
                    "tailwindcss"                 => "^2.1.1"
                ] + $packages;
        });

        // Controllers...

        // Views...
        (new Filesystem)->cleanDirectory(resource_path('views'));
        (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/resources/views', base_path('resources/views'));

        (new Filesystem)->ensureDirectoryExists(base_path('app/View/Components'));
        copy(__DIR__.'/../../stubs/app/View/Components/MetaData.php', base_path('app/View/Components/MetaData.php'));
        // Tests...

        // Misc..
        (new Filesystem)->ensureDirectoryExists(resource_path('images'));
        (new Filesystem)->ensureDirectoryExists(resource_path('svg'));

        copy(__DIR__.'/../../stubs/app/Console/kernel.php', base_path('app/Console/kernel.php'));
        (new Filesystem)->ensureDirectoryExists(base_path('app/Console/Commands'));
        copy(__DIR__.'/../../stubs/app/Console/Commands/GenerateSitemap.php',
            base_path('app/Console/Commands/GenerateSitemap.php'));

        // Routes...
        copy(__DIR__.'/../../stubs/routes/web.php', base_path('routes/web.php'));

        // Configs...
        copy(__DIR__.'/../../stubs/config/seotools.php', base_path('config/seotools.php'));
        copy(__DIR__.'/../../stubs/config/backup.php', base_path('config/backup.php'));
        copy(__DIR__.'/../../stubs/config/filesystems.php', base_path('config/filesystems.php'));
        copy(__DIR__.'/../../stubs/config/sitemap.php', base_path('config/sitemap.php'));
        copy(__DIR__.'/../../stubs/config/website.php', base_path('config/website.php'));

        // Tailwind / Webpack...
        copy(__DIR__.'/../../stubs/tailwind.config.js', base_path('tailwind.config.js'));
        copy(__DIR__.'/../../stubs/webpack.mix.js', base_path('webpack.mix.js'));
        copy(__DIR__.'/../../stubs/resources/css/app.css', resource_path('css/app.css'));
        copy(__DIR__.'/../../stubs/resources/js/app.js', resource_path('js/app.js'));
        copy(__DIR__.'/../../stubs/resources/js/bootstrap.js', resource_path('js/bootstrap.js'));
        copy(__DIR__.'/../../stubs/gitignore', base_path('.gitignore'));

        $this->updateComposerScripts();

        // Maybe run some stuff
//        Update Vaiables


        $this->replaceInFile(':base_name', $siteName, base_path('webpack.mix.js'));
        $this->replaceInFile(':site_name', $siteName, base_path('config/seotools.php'));
        $this->replaceInFile(':site_name', $siteName, base_path('config/website.php'));
        $this->replaceInFile(':site_name', $siteName, resource_path('views/web/layout/footer.blade.php'));
        $this->replaceInFile(':site_name', $siteName, resource_path('views/web/layout/header.blade.php'));
        $this->replaceInFile(':site_name', $siteName, resource_path('views/web/sections/static/home.blade.php'));


        $this->info('Laravel Go scaffolding installed successfully.');
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
        if (!file_exists(base_path('package.json'))) {
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
        if (!file_exists(base_path('composer.json'))) {
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
        if (!file_exists(base_path('composer.json'))) {
            return;
        }
        $items = [
            "@php artisan vendor:publish --force --tag=livewire:assets --ansi",
            "@php artisan storage:link"
        ];

        $composer = json_decode(file_get_contents(base_path('composer.json')), true);

        foreach ($items as $item) {
            if (array_key_exists("post-autoload-dump", $composer['scripts'])) {

                if (!in_array($item, $composer['scripts']['post-autoload-dump'])) {
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

}
