<?php


namespace Daikazu\LaravelGo\Console;


use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class StaticPageCommand extends Command
{


    protected $signature = 'go:make-static {url : URL Path} {name? : Route name (optional)} {--title= : Page Title} {--description= : Meta Description}';

    protected $description = 'Create a static page';


    private $stub = __DIR__.'/../../stubs/new/static-page.blade.php';
    private $folder = 'views/web/sections/static/';

    private function escapeStings($string){
        return str_replace("'", "\'", $string);
    }

    public function handle()
    {

        $url = str_replace([' '], '-', strtolower($this->argument('url')));

        // Add index to end if url ends with a slash
        if (Str::endsWith($url, '/')) {
            $url .= 'index';
        }

        if ($this->argument('name')) {
            $route_name = $this->argument('name');
        } else {
            $route_name = str_replace('/', '.', $url);
        }

        $file_name = $url.'.blade.php';

        $viewPath = 'web.sections.static.'.str_replace('/', '.', $url);

        $url = str_replace('/index', '/', $url);

        $stub = (new Filesystem)->get($this->stub);

        if ($this->option('title')) {
            $title = $this->option('title');
        } else {
            $title = Str::title( str_replace( '-', ' ', str_replace('.blade', '', pathinfo($file_name, PATHINFO_FILENAME))));
        }

        $description = ($this->hasOption('description'))  ? $this->option('description') : '';

        $stub = str_replace(
            [':page_title', ':page_description'],
            [ $this->escapeStings($title) , $this->escapeStings($description)],
            $stub
        );

        (new Filesystem)->ensureDirectoryExists(resource_path(pathinfo($this->folder.$file_name, PATHINFO_DIRNAME)));
        (new Filesystem)->put(resource_path($this->folder.$file_name), $stub);

        $route = "Route::view('{$url}', '{$viewPath}')->name('{$route_name}');".PHP_EOL;

        // add line to web.php
        (new Filesystem)->append(base_path('routes/web.php'), $route);


        $this->info("{$title} page added successfully.");
//        $this->comment('Please execute the "npm install && npm run dev" command to build your assets.');
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


}
