<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class File extends Component{
    public int $col;
    public string $name;
    public string $text;

    /**
     * Create a new component instance.
     */
    public function __construct($name, $text, $col = ''){
        $this->name = $name;
        $this->text = $text;
        $this->col = $col ? $col : 12;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render() : View|Closure|string{
        return view('components.form.file');
    }
}
