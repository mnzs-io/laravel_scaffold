<?php

use App\Actions\Organizations\OrganizationsIndexAction;
use App\Actions\Organizations\OrganizationsEditAction;
use App\Models\MemoryCards\Organization;

use function App\Support\{get, middleware};

middleware('web.authenticated', function () {

    get('/cursos/lista', OrganizationsIndexAction::class)
        ->can('viewAny', Organization::class)
        ->name('get.organizations.index');

        get('/curso/edit/{organization:slug}', OrganizationsEditAction::class)
        ->can('update', 'organization', )
        ->name('get.organization.edit');

});
