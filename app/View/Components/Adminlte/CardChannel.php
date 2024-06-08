<?php

namespace App\View\Components\Adminlte;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardChannel extends Component{
    public $channels;
    public $col;

    /**
     * Create a new component instance.
     */
    public function __construct($channels, $col){
        $this->channels = $channels;
        $this->col = $col;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render() : View|Closure|string{
        return view('components.adminlte.card-channel');
    }
}
