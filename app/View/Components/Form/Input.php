<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component{
    public int $col;
    public string $name;
    public string $help;
    public string $type;
    public string $text;
    public $value;

    /**
     * Create a new component instance.
     */
    public function __construct($name, $type, $text, $help = '', $value = '', $col = ''){
        $this->name = $name;
        $this->help = $help;
        $this->type = $type;
        $this->text = $text;
        $this->value = $value ? $value : null;
        $this->col = $col ? $col : 12;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render() : View|Closure|string{
        return view('components.form.input');
    }
}
