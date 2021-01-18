<?php

namespace App\View\Components;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\View\Component;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class MetaData extends Component
{
    public $meta;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        try {
            $this->meta = collect(Yaml::parse(app()->view->getSection('meta')));
        } catch (ParseException $exception) {
            // printf('Unable to parse the YAML string: %s', $exception->getMessage());
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        if ($this->meta->get('title')) {
            SEOTools::setTitle($this->meta->get('title'));
        }
        if ($this->meta->get('description')) {
            SEOTools::setDescription($this->meta->get('description'));
        }

        SEOTools::opengraph()->setUrl(app('url')->full());

        if ($this->meta->get('canonical')) {
            SEOMeta::setCanonical($this->meta->get('canonical'));
        } else {
            SEOTools::setCanonical(app('url')->full());
        }

        return view('web.layout.head.meta-data');
    }
}
