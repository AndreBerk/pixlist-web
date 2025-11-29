<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

// 1. Renomeamos a classe para combinar com o nome do arquivo
class AdminLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        // 2. Apontamos para o nosso novo arquivo de layout renomeado
        return view('layouts.admin');
    }
}
