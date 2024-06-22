<?php

namespace App\View\Components\Adminlte;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Card extends Component{
    public $tab;
    public $tabContent;
    public string $add;
    public string $title;
    public string $outline;

    /**
     * Create a new component instance.
     */
    public function __construct($tab = '', $tabContent = '', $add = '', $title = '', $outline = ''){
        $this->tab = $tab ? explode(', ', $tab) : null;
        $this->tabContent = $tabContent;
        
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
