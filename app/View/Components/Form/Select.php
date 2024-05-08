<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component{
    public $data;
    public int $col;
    public string $name;
    public string $text;
    public $value;

    /**
     * Create a new component instance.
     */
    public function __construct($name, $text, $data, $value = '', $col = ''){
        $this->name = $name;
        $this->text = $text;
        $this->data = $data;
        $this->value = $value;
        $this->col = $col ? $col : 12;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render() : View|Closure|string{
        return view('components.form.select', [
            'data' => $this->data,
        ]);
    }
}
