<?php

use Livewire\Livewire;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Volunteer\AuthController;
use App\Http\Controllers\Volunteer\PageController;
use App\Http\Controllers\Volunteer\EventController;
use App\Http\Controllers\SuperAdmin\SectionController;
use App\Http\Controllers\Volunteer\VolunteerController;


Livewire::setUpdateRoute(function ($handle) {
    return Route::post('/custom/livewire/update', $handle);
});
Route::middleware('guest:volunteer')->group(function () {
    Route::get('/login', [AuthController::class, 'loginView'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::middleware(['auth:volunteer'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    // event
    Route::get('/', [PageController::class, 'index'])->name('index');
    Route::get('/weekly-statistics', [PageController::class, 'getWeeklyVolunteerStatistics'])->name('weekly.statistics');

    Route::group(
        ['prefix' => 'event', 'as' => 'event.'],
        function () {
            Route::get('/', [EventController::class, 'index'])->name('index');
            Route::post('/filter', [EventController::class, 'eventFilter'])->name('filter');
            Route::get('/create', [EventController::class, 'create'])->name('create');
            Route::get('/edit/{id}', [EventController::class, 'edit'])->name('edit');
            Route::get('/create/{id}/media', [EventController::class, 'createMedia'])->name('create.media');
            Route::post('/create', [EventController::class, 'store'])->name('create');
            Route::post('/create/media', [EventController::class, 'storeMedia'])->name('create.media');
            Route::post('/destroy/{event}', [EventController::class, 'destroy'])->name('destroy');

        }
    );
    Route::group(
        ['prefix' => 'vol', 'as' => 'vol.'],
        function () {
            Route::get('/', [VolunteerController::class, 'allVolunteers'])->name('index');
            Route::get('/create', [VolunteerController::class, 'createVolunteer'])->name('create');
            Route::get('edit/{id}', [VolunteerController::class, 'editVolunteer'])->name('edit');
            Route::get('/teem-work', [VolunteerController::class, 'teemWork'])->name('teemWork');
            Route::post('/filter', [VolunteerController::class, 'volunteerFilter'])->name('filter');
            Route::post('/update', [VolunteerController::class, 'update'])->name('update');
            Route::post('/store', [VolunteerController::class, 'store'])->name('store');


        }
    );
    Route::post('/add-volunteer', [VolunteerController::class, 'shortStore']);
    Route::get('/search', [VolunteerController::class, 'searchVolunteers'])->name('search');
    Route::get('/get-section-contributions', [SectionController::class, 'getContributions'])->name('getSectionContributions');
});
