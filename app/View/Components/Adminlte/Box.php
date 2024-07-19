<?php

namespace App\View\Components\Adminlte;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Box extends Component{
    public string $colors;
    public string $icon;
    public string $title;
    public string $content;
    public string $link;

    /**
     * Create a new component instance.
     */
    public function __construct($colors, $icon, $title, $content, $link){
        $this->colors = $colors;
        $this->icon = $icon;
        $this->title = $title;
        $this->content = $content;
        $this->link = $link;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render() : View|Closure|string{
        return view('components.adminlte.box');
    }
}
