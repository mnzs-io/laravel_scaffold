<?php

use App\Actions\Teachers\TeachersIndexAction;
use App\Models\MemoryCards\Organization;

use function App\Support\{get, middleware, put};

middleware('web.authenticated', function () {

    get('/professores/{organization:slug}', TeachersIndexAction::class)
        ->can('update', 'organization')
        ->name('get.teachers.index');

    // put('/professor/{teacher}/disciplina/{subject}/{newState}', TeachersEditAction::class)
    //     ->can('update', 'teacher', )
    //     ->name('put.teacher.subject');

});
