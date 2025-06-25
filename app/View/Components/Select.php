<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    
    public string $label;
    public string $name;
    public string $campo;
    public $options;
    public ?string $selected;
    /**
     * Create a new component instance.
     */
    public function __construct(string $label, string $name,string $campo, $options = [], string $selected = null)
    {
        $this->label = $label;
        $this->name = $name;
        $this->campo = $campo;
        $this->options = $options;
        $this->selected = $selected;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select');
    }
}
