<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Td extends Component
{
   

    public function __construct(
        public string $align = "",

    )
    {}
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('components.td');
    }
}
