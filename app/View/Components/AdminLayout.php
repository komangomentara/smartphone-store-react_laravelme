<?php
namespace App\View\Components;

use Illuminate\View\Component;

class AdminLayout extends Component
{
    public function render()
    {
        // sesuai modul: layout dipindah ke folder resources/views/layouts
        return view('layouts.admin-layout');
    }
}
