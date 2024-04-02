<?php

namespace App\View\Components\Adminlte;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Card extends Component{
    public string $add;
    public string $title;
    public string $outline;

    /**
     * Create a new component instance.
     */
    public function __construct($add = '', $title = '', $outline = ''){
        $this->add = $add;
        $this->title = $title;
        $this->outline = $outline;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render() : View|Closure|string{
        return view('components.adminlte.card');
    }
}
