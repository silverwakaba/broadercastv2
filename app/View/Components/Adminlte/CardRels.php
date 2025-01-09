<?php

namespace App\View\Components\Adminlte;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardRels extends Component{
    public $rels;
    public $col;

    /**
     * Create a new component instance.
     */
    public function __construct($rels, $col = ''){
        $this->rels = $rels;
        $this->col = $col ? $col : 1;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render() : View|Closure|string{
        return view('components.adminlte.card-rels');
    }
}
