<?php

namespace App\View\Components\Valkivid\Live;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Content extends Component{
    public $feeds;
    public $title;
    public $link;

    /**
     * Create a new component instance.
     */
    public function __construct($feeds, $title, $link = null){
        $this->feeds = $feeds;
        $this->title = $title;
        $this->link = $link;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render() : View|Closure|string{
        return view('components.valkivid.live.content');
    }
}
