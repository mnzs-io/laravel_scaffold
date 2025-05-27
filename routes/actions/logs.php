<?php

use App\Actions\Logs\LogsIndexAction;
use App\Http\Controllers\PageController;
use App\Models\LogEntry;
use Illuminate\Support\Facades\Route;

Route::middleware('web.authenticated')->group(function () {

    Route::get('/logs/lista', LogsIndexAction::class)
        ->can('viewAny', LogEntry::class)
        ->name('get.logs.index');

    Route::get('/log', [PageController::class, 'log']);

});
