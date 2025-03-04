<?php

use Livewire\Livewire;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TemporaryFileController;


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::post('/tmp-store', [TemporaryFileController::class, 'store'])->name('tmp.store');
Route::delete('/tmp-delete', [TemporaryFileController::class, 'delete'])->name('tmp.delete');
Livewire::setUpdateRoute(function ($handle) {
    return Route::post('/custom/livewire/update', $handle);
});