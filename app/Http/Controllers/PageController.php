<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class PageController extends Controller
{
    public function dashboard()
    {
        return Inertia::render('Dashboard', [
            'breadcrumbs' => [['title' => 'Dashboard', 'href' => route('get.dashboard')]],
        ]);
    }

    public function welcome()
    {
        return Inertia::render('Welcome');
    }
}
