<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CategoryOptions extends Component
{
    public $categories;
    public $level;

    public function __construct($categories, $level = 0)
    {
        $this->categories = $categories;
        $this->level = $level;
    }

    public function render()
    {
        return view('components.category-options');
    }
}

