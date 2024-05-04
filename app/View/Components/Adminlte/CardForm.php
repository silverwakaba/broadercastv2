<?php

namespace App\View\Components\Adminlte;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardForm extends Component{
    public string $title;
    public string $outline;
    public string $button;
    public string $action;
    public string $method;
    public string $encode;

    /**
     * Create a new component instance.
     */
    public function __construct($title = '', $outline = '', $button = '', $action = '', $method = '', $encode = ''){
        $this->title = $title;
        $this->outline = $outline;
        $this->button = $button ? $button : 'Add';
        $this->method = $method ? $method : 'POST';
        $this->action = $action ? route($action) : url()->current();
        $this->encode = $encode == 'upload' ? "multipart/form-data" : "application/x-www-form-urlencoded";
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.adminlte.card-form');
    }
}
