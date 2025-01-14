<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\AuthController;
use App\Http\Controllers\SuperAdmin\PageController;
use App\Http\Controllers\SuperAdmin\BranchController;
use App\Http\Controllers\SuperAdmin\SectionController;
use App\Http\Controllers\SuperAdmin\ActivityController;
use App\Http\Controllers\SuperAdmin\ContributionController;

Route::middleware('guest:super_admin')->group(function () {
    Route::get('/login', [AuthController::class, 'loginView'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});


Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::middleware( ['auth:super_admin'])->group(function(){
    
    Route::get('/',[PageController::class, 'index'])->name('index');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    //------- Branch --------//
    Route::group(
        ['prefix' => 'branch', 'as' => 'branch.'],
        function () {
            Route::get('/',                    [BranchController::class, 'allBranch'])             ->name('index');
            Route::get('/create',              [BranchController::class, 'createForm'])            ->name('create');
            Route::post('/create',             [BranchController::class, 'storeBranch'])           ->name('store');
            Route::get('/edit/{branch}',       [BranchController::class, 'editForm'])              ->name('edit');
            Route::post('/edit',               [BranchController::class, 'updateBranch'])          ->name('update');
            Route::post('/delete/{branch}',    [BranchController::class, 'destroyBranch'])         ->name('destroy');
            
        }
    );
    //------- Section --------//
    Route::group(
        ['prefix' => 'section', 'as' => 'section.'],
        function () {
            Route::get('/',                    [SectionController::class, 'allSection'])            ->name('index');
            Route::get('/create',              [SectionController::class, 'createForm'])            ->name('create');
            Route::post('/create',             [SectionController::class, 'storeSection'])          ->name('store');
            Route::get('/edit/{section}',      [SectionController::class, 'editForm'])              ->name('edit');
            Route::post('/edit',               [SectionController::class, 'updateSection'])         ->name('update');
            Route::post('/delete/{section}',   [SectionController::class, 'destroySection'])        ->name('destroy');
            
        }
    );
    //------- Contribution --------//
    Route::group(
        ['prefix' => 'contribution', 'as' => 'contribution.'],
        function () {
            Route::get('/',                        [ContributionController::class, 'allContribution'])      ->name('index');
            Route::post('/create',                 [ContributionController::class, 'storeContribution'])    ->name('store');
            Route::post('/edit',                   [ContributionController::class, 'updateContribution'])   ->name('update');
            Route::post('/delete/{contribution}',  [ContributionController::class, 'destroyContribution'])  ->name('destroy');
        }
    );
    //------- Activity --------//
    Route::group(
        ['prefix' => 'activity', 'as' => 'activity.'],
        function () {
            Route::get('/',                    [ActivityController::class, 'allActivity'])        ->name('index');
            Route::get('/create',              [ActivityController::class, 'createForm'])         ->name('create');
            Route::post('/create',             [ActivityController::class, 'storeActivity'])      ->name('store');
            Route::get('/edit/{activity}',     [ActivityController::class, 'editForm'])           ->name('edit');
            Route::post('/edit',               [ActivityController::class, 'updateActivity'])     ->name('update');
            Route::get('/sheet',               [ActivityController::class, 'sheet'])              ->name('sheet');
            Route::post('/export',             [ActivityController::class, 'export'])             ->name('export');
            Route::post('/import',             [ActivityController::class, 'import'])             ->name('import');
            Route::post('/delete/{activity}',  [ActivityController::class, 'deleteActivity'])     ->name('delete');
            Route::post('/bulk-delete',        [ActivityController::class, 'deleteActivities'])   ->name('bulk.delete');
        }
    );

});