<?php

namespace App\View\Components;

use Illuminate\View\View;
use Illuminate\View\Component;

class StartUseLayout extends Component
{
    public function render() : View
    {
        return view('layouts.startuse');
    }
}
