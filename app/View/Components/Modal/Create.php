<?php

namespace App\View\Components\Modal;

use Illuminate\View\Component;


class Create extends Component
{
    public $title;

    public function __construct($title)
    {
        $this->title = $title;
    }
    public function render()
    {
        return view('components.modal.create');
    }
}
