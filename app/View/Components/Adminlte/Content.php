<?php

namespace App\View\Components\Adminlte;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacades;
use Illuminate\View\Component;

class Content extends Component{
    public $title;
    public $previous;

    /**
     * Create a new component instance.
     */
    public function __construct($title = '', $previous = ''){
        $this->title = $title ? $title : ViewFacades::getSection('title');
        $this->previous = $previous;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render() : View|Closure|string{
        return view('components.adminlte.content');
    }
}
