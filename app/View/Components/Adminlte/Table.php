<?php

namespace App\View\Components\Adminlte;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Table extends Component{
    public string $ids;

    /**
     * Create a new component instance.
     */
    public function __construct($ids = ''){
        $this->ids = $ids ? $ids : 'nah';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render() : View|Closure|string{
        return view('components.adminlte.table');
    }
}
