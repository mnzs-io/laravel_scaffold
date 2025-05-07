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

    public function profile()
    {
        return Inertia::render('Profile/ProfileEdit', [
            'breadcrumbs' => [['title' => 'Editar Perfil', 'href' => route('get.profile')]],
        ]);
    }

    public function log()
    {
        return Inertia::render('Log/LogInspect');
    }
}
