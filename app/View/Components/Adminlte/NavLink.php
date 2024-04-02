<?php

namespace App\View\Components\Adminlte;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NavLink extends Component{
    public bool $icon;
    public bool $parent;
    public string $fa;
    public string $route;
    public string $value;
    public string $mode;

    /**
     * Create a new component instance.
     */
    public function __construct($icon = false, $parent = false, $fa = '', $route = '', $value = '', $mode = ''){
        $this->icon = $icon;
        $this->parent = $parent;
        $this->fa = $fa;
        $this->route = $route;
        $this->value = $value;
        $this->mode = $mode == null ? 'nav-link' : 'dropdown-item';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render() : View|Closure|string{
        return view('components.adminlte.nav-link');
    }
}
