<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\AuthController;
use App\Http\Controllers\SuperAdmin\PageController;
use App\Http\Controllers\SuperAdmin\SectionController;
use App\Http\Controllers\SuperAdmin\ActivityController;


Route::middleware('guest:super_admin')->group(function () {
    Route::get('/login', [AuthController::class, 'loginView'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});


Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::middleware( ['auth:super_admin'])->group(function(){
    
    Route::get('/',[PageController::class, 'index'])->name('index');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::group(
        ['prefix' => 'section', 'as' => 'section.'],
        function () {
            Route::get('/create', [SectionController::class, 'showForm'])->name('create');
            Route::post('/create', [SectionController::class, 'storeSection'])->name('store');
        }
    );
    Route::group(
        ['prefix' => 'activity', 'as' => 'activity.'],
        function () {
            Route::get('/all',                 [ActivityController::class, 'allActivity'])        ->name('index');
            Route::get('/create',              [ActivityController::class, 'createForm'])         ->name('create');
            Route::post('/create',             [ActivityController::class, 'storeActivity'])      ->name('store');
            Route::get('/edit/{id}',           [ActivityController::class, 'editForm'])           ->name('edit');
            Route::post('/edit',               [ActivityController::class, 'updateActivity'])     ->name('update');
            Route::get('/sheet',               [ActivityController::class, 'sheet'])              ->name('sheet');
            Route::post('/export',             [ActivityController::class, 'export'])             ->name('export');
            Route::post('/import',             [ActivityController::class, 'import'])             ->name('import');
            Route::post('/delete/{activity}',  [ActivityController::class, 'deleteActivity'])     ->name('delete');
            Route::post('/bulk-delete',        [ActivityController::class, 'deleteActivities'])   ->name('bulk.delete');
        }
    );

});