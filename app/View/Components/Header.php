<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Header extends Component
{
    private $data;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->data['categories'] = \Helper::getCategories();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.header')->with($this->data);
    }
}
