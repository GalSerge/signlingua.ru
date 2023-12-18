<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\MoodleService;

class CourseController extends Controller
{
    public function displayUserCourses(Request $request): View
    {
        $courses = [];

        if ($request->user()->moodle_id != null && $request->user()->subscription_id != null)
        {
            $userCourses = MoodleService::getAllUserCourses($request->user()->moodle_id);

            $courses = $request->user()->courses->toArray();

            foreach ($courses as $key => $course)
                foreach ($userCourses as $moodleCourse)
                    if ($moodleCourse['moodle_id'] == $course['moodle_id'])
                    {
                        $courses[$key]['progress'] = $moodleCourse['progress'];
                        break;
                    }
        }

        return view('profile.pages.courses',
            ['courses' => $courses]);
    }

    public function goToMoodle(Request $request, MoodleService $service): RedirectResponse
    {
        if ($request->user()->moodle_id === null && $request->user()->role_id != 1)
            return redirect()->route('subscriptions');

        $link = $service->getLoginUrl($request->user());

        if ($link !== false)
            return redirect()->away($link);
        else
            return redirect()->back()->with('error', 'Что-то пошло не так...');
    }
}
