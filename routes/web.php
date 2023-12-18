<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\CallController;
use App\Http\Controllers\ViewCourseSubscriptionController;
use App\Http\Controllers\FeedbackController;
use Illuminate\Support\Facades\Route;

use App\Models\Course;

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

Route::get('/', function () {
    return view('pages.main', ['courses' => Course::where('visible', 1)->take(3)->get()->toArray()]);
});

Route::get('/emailtest', [FeedbackController::class, 'index']);

Route::get('/topic/{id}', [TopicController::class, 'show'])->name('topic');
Route::get('/topics', [TopicController::class, 'showAll'])->name('topics');

Route::get('/course/{id}', [ViewCourseSubscriptionController::class, 'showCourse'])->name('course');
Route::get('/courses', [ViewCourseSubscriptionController::class, 'showAllCourses'])->name('courses');

Route::get('/sub/{id}', [ViewCourseSubscriptionController::class, 'showSubscription'])->name('subscription');
Route::get('/subs', [ViewCourseSubscriptionController::class, 'showAllSubscriptions'])->name('subscriptions');

Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback');
Route::post('/feedback', [FeedbackController::class, 'send'])->name('feedback.callback');

Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');

Route::get('/test', [App\Http\Controllers\Profile\UserController::class, 'view']);
require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/profile.php';
