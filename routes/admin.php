<?php

use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\TopicController;
use App\Http\Controllers\Admin\WordController;
use App\Http\Controllers\Admin\UsersNotificationsController;
use App\Http\Controllers\Admin\ConstantController;
use App\Http\Controllers\Admin\RegionController;
use App\Http\Controllers\Admin\CallController;

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'roles:admin']], function () {
    Route::get('/', function () {
        return view('admin.pages.documentation');
    })->name('admin.main');

    Route::post('/courses/load', [CourseController::class, 'load'])->name('admin.courses.load');
    Route::resource('courses', CourseController::class)
        ->except(['create', 'store', 'show', 'destroy']);

    Route::resource('admins', UserAdminController::class)->except(['show']);
    Route::resource('subscriptions', SubscriptionController::class)->except(['show']);
    Route::resource('topics', TopicController::class)->except(['show']);
    Route::resource('words', WordController::class)->except(['show']);
    Route::resource('regions', RegionController::class)->except(['show']);

    Route::get('/constants/1/edit', [ConstantController::class, 'editConstants'])->name('constants.edit');
    Route::put('/constants/1', [ConstantController::class, 'update'])->name('constants.update');

    Route::get('/calls', [CallController::class, 'index'])->name('calls.index');
    Route::get('/calls/{id}/edit', [CallController::class, 'show'])->name('calls.edit');
    Route::put('/calls/{id}', [CallController::class, 'updateStatusCall'])->name('calls.update');

    Route::get('/notifications', [UsersNotificationsController::class, 'index'])->name('notifications.create');
    Route::post('/notifications', [UsersNotificationsController::class, 'create'])->name('admin.notifications');
});
