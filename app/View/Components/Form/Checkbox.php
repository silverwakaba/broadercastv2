<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Checkbox extends Component{
    public int $col;
    public string $name;
    public string $value;
    public string $values;

    /**
     * Create a new component instance.
     */
    public function __construct($name, $value = '', $values = '', $col = ''){
        $this->name = $name;
        $this->value = $value;
        $this->values = $values;
        $this->col = $col ? $col : 12;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render() : View|Closure|string{
        return view('components.form.checkbox');
    }
}
