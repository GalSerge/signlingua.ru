<?php

use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Profile\PaymentController;
use App\Http\Controllers\Profile\CourseController;
use App\Http\Controllers\Profile\CallController;
use App\Http\Controllers\Profile\SubscriptionController;
use App\Http\Controllers\Profile\TrainingController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'profile', 'middleware' => ['auth', 'verified']], function () {
    Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/read-notes', [ProfileController::class, 'readNotifications'])->name('profile.read-notes');

    Route::get('/courses', [CourseController::class, 'displayUserCourses'])->name('profile.courses');
    Route::get('/courses/study', [CourseController::class, 'goToMoodle'])->name('profile.courses.study');

    Route::get('/calls', [CallController::class, 'index'])->name('profile.calls');
    Route::post('/call', [CallController::class, 'requestCall'])->name('profile.call.request');

    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');

    Route::post('/payment/subscribe', [PaymentController::class, 'subscribe'])->name('pay.subscribe');
    Route::post('/payment/calls', [PaymentController::class, 'buyCalls'])->name('pay.calls');
    Route::post('/payment/trial', [PaymentController::class, 'trial'])->name('pay.trial');
    Route::post('/payment/cancel', [SubscriptionController::class, 'cancel'])->name('pay.cancel');
    Route::get('/payment/{id}/callback/', [PaymentController::class, 'waitPayment'])->name('profile.payment.callback');

    Route::get('/sub', [SubscriptionController::class, 'index'])->name('profile.subscription');

    Route::get('/training', [TrainingController::class, 'index'])->name('training.index');
    Route::get('/training/{id}', [TrainingController::class, 'train'])->name('training');
    Route::get('/training/{id}/reset', [TrainingController::class, 'resetTraining'])->name('training.reset');

});
