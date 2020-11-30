<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;


class SectionComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $sections;

    

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        // dd('dfd');
        $view->with('sections','dfd');
    }
}