<?php

namespace App\View\Components\Adminlte;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NavTree extends Component{
    public array $route;

    /**
     * Create a new component instance.
     */
    public function __construct($route = ''){
        $this->route = (array) $route;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render() : View|Closure|string{
        return view('components.adminlte.nav-tree');
    }
}
