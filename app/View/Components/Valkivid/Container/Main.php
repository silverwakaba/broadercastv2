<?php

namespace App\View\Components\Valkivid\Container;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Main extends Component{
    public $title;
    public $background;

    /**
     * Create a new component instance.
     */
    public function __construct($title = null, $background = null){
        $this->title = $title;
        $this->background = $background ? $background : 'bg-placeholder-default';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render() : View|Closure|string{
        return view('components.valkivid.container.main');
    }
}
