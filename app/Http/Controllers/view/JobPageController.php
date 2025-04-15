<?php

namespace App\Http\Controllers\view;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class JobPageController
{
    public function index(): Factory|View|Application
    {
        return view('jobs'); // no need to pass jobs here
    }

}
