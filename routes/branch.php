<?php

use Livewire\Livewire;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Branch\AuthController;
use App\Http\Controllers\Branch\PageController;
use App\Http\Controllers\Branch\EventController;

Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Livewire::setUpdateRoute(function ($handle) {
    return Route::post('/custom/livewire/update', $handle);
});
Route::middleware(['auth:branch'])->group(function () {
    Route::get('/', [PageController::class, 'index'])->name('index');
    Route::get('/activity/events/{id}', [EventController::class, 'getEventsByActivity'])->name('activity.events');
    Route::post('/event/change/{id}',   [EventController::class, 'changeEventStatus'])->name('change.events.status');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

