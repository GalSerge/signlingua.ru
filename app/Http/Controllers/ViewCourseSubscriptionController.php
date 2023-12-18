<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Subscription;
use Illuminate\View\View;

class ViewCourseSubscriptionController extends Controller
{
    public function showAllCourses(): View
    {
        return view('pages.courses',
            ['courses' => Course::where('visible', 1)
                ->orderBy('name')
                ->get()
                ->toArray()
            ]);
    }

    public function showSubscription(string $id): View
    {
        return view('pages.subscription',
            ['subscription' => Subscription::with('courses')->findOrFail($id)->toArray()]);
    }

    public function showCourse(string $id): View
    {
        return view('pages.course',
            ['course' => Course::with('subscriptions')->findOrFail($id)->toArray()]);
    }

    public function showAllSubscriptions(): View
    {
        return view('pages.subscriptions',
            ['subscriptions' => Subscription::where('active', 1)
                ->orderBy('amount')
                ->get()
                ->toArray()
            ]);
    }
}
