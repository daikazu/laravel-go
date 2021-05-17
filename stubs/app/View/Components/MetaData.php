<?php

namespace App\View\Components;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\View\Component;

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
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        if (app()->view->getSection('meta_title')) {
            SEOTools::setTitle(app()->view->getSection('meta_title'));
        }
        if (app()->view->getSection('meta_description')) {
            SEOTools::setDescription(app()->view->getSection('meta_description'));
        }
        if (app()->view->getSection('meta_canonical')) {
            SEOMeta::setCanonical(app()->view->getSection('meta_canonical'));
        }
        return view('web.layout.head.meta-data');
    }
}
