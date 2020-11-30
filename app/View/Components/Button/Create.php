<?php

namespace App\View\Components\Button;

use Illuminate\View\Component;


class Create extends Component
{
    public function render()
    {

        return function (array $data) {
            return '<div align="right">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createModal">Create</button>
                    </div>
            ';
        };
        // return view('components.modal.create');
    }
}
