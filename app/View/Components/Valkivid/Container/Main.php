<?php

namespace App\View\Components\Valkivid\Container;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Main extends Component{
    public $title;
    public $background;
    public $backgroundClass;
    public $backgroundURL;

    /**
     * Create a new component instance.
     */
    public function __construct($title = null, $background = null, $backgroundClass = null, $backgroundURL = null){
        $this->title = $title;
        $this->background = (Str::of($background)->isUrl() == true) ? 'custom' : 'default';
        $this->backgroundClass = ($this->background == 'custom') ? 'bg-custom-this-page' : 'bg-placeholder-default';
        $this->backgroundURL = $background;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render() : View|Closure|string{
        return view('components.valkivid.container.main');
    }
}
