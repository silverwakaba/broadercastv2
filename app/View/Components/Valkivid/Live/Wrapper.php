<?php

namespace App\View\Components\Valkivid\Live;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Wrapper extends Component{
    public $title;
    public $link;

    /**
     * Create a new component instance.
     */
    public function __construct($title, $link = null){
        $this->title = $title;
        $this->link = $link;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render() : View|Closure|string{
        return view('components.valkivid.live.wrapper');
    }
}
