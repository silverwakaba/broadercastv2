<?php

namespace App\View\Components\Valkivid;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NavDropdownLink extends Component{
    public string $route;
    public string $value;
    public string $mode;

    /**
     * Create a new component instance.
     */
    public function __construct($value, $route, $mode){
        $this->route = $route;
        $this->value = $value;
        $this->mode = $mode;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render() : View|Closure|string{
        return view('components.valkivid.nav-dropdown-link');
    }
}
