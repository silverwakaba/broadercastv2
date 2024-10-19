<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Hcaptcha extends Component{
    public $id;
    public string $button;
    public string $class;

    /**
     * Create a new component instance.
     */
    public function __construct($id = '', $button = '', $class = ''){
        $this->id = $id;
        $this->button = $button;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string{
        return view('components.form.hcaptcha');
    }
}
