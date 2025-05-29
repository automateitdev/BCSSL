<?php

namespace App\View\Components\Layouts;

use App\Models\User;
use Illuminate\View\Component;

class AppMaster extends Component
{
    // /**
    //  * Create a new component instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     //
    // }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('layouts.app-master');
    }
}
