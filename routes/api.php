<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\WordController;
use App\Http\Controllers\Profile\TrainingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'admin'], function () {
    Route::post('/words/{word_id}/region', [WordController::class, 'addRegion'])->name('words.region.add');
    Route::delete('/words/{word_id}/region', [WordController::class, 'deleteRegion'])->name('words.region.delete');
    Route::get('/words/{word_id}/regions', [WordController::class, 'getFreeRegions'])->name('words.regions.get');
});

Route::get('/words/search', [WordController::class, 'getWordsByText'])->name('words.search');

Route::post('/training/next', [TrainingController::class, 'getNewQuestion'])->name('training.next-quest');
Route::post('/training/set', [TrainingController::class, 'setWordTrained'])->name('training.set-word');

