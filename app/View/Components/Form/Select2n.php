<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select2n extends Component{
    public $data;
    public int $col;
    public string $name;
    public string $text;
    public $value;
    public string $extclass;

    /**
     * Create a new component instance.
     */
    public function __construct($name, $text, $data, $value = '', $col = '', $extclass = ''){
        $this->name = $name;
        $this->text = $text;
        $this->data = $data;
        $this->value = $value;
        $this->col = $col ? $col : 12;
        $this->extclass = $extclass;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render() : View|Closure|string{
        return view('components.form.select2n', [
            'data' => $this->data,
        ]);
    }
}
