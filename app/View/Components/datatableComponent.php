<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class datatableComponent extends Component
{
    
    public $options;
    public string $id;
    public string $link;
    public string $titulobotao;

    public function __construct($options = [],string $id, string $link,string $titulobotao)
    {
        $this->options = $options;
        $this->id = $id;
        $this->link = $link;
        $this->titulobotao = $titulobotao;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.datatable-component');
    }
}
