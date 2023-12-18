<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Topic;
use App\Models\Subscription;
use App\Models\User;
use App\Notifications\UpdatesNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

class UsersNotificationsController extends Controller
{
    public function index(): View
    {
        return view('admin.pages.notifications',
            [
                'courses' => Course::where('visible', 1)
                    ->get()
                    ->toArray(),
                'subscriptions' => Subscription::where('active', 1)
                    ->get()
                    ->toArray(),
                'topics' => Topic::where('active', 1)
                    ->get()
                    ->toArray()
            ]);
    }

    public function create(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'courses' => ['nullable', 'array'],
            'course_msg' => ['required', 'string', 'max:255'],

            'subscriptions' => ['nullable', 'array'],
            'subscription_msg' => ['required', 'string', 'max:255'],

            'topics' => ['nullable', 'array'],
            'topic_msg' => ['required', 'string', 'max:255'],
        ]);

        if (isset($validatedData['subscriptions']))
            foreach ($validatedData['subscriptions'] as $subscription_id)
                $this->createSubscriptionNotification($subscription_id, $validatedData['subscription_msg']);

        if (isset($validatedData['courses']))
            foreach ($validatedData['courses'] as $course_id)
                $this->createCourseNotification($course_id, $validatedData['course_msg']);

        if (isset($validatedData['topics']))
            foreach ($validatedData['topics'] as $topic_id)
                $this->createTopicNotification($topic_id, $validatedData['topic_msg']);

        return redirect()->back()->with('status', 'Уведомления разосланы.');
    }

    private function createCourseNotification(string $id, string $msg): void
    {
        $users = User::select('users.*', 'courses.name AS course_name')
            ->where('courses.id', $id)
            ->join('subscriptions', 'users.subscription_id', '=', 'subscriptions.id')
            ->join('course_subscription', 'course_subscription.subscription_id', '=', 'subscriptions.id')
            ->join('courses', 'course_subscription.course_id', '=', 'courses.id')
            ->get();

        if ($users->count() == 0)
            return;

        $msg = str_replace(':name', $users[0]->course_name, $msg);

        Notification::send($users, new UpdatesNotification($msg));
    }

    private function createSubscriptionNotification(string $id, string $msg): void
    {
        $subscription = Subscription::find($id);
        $msg = str_replace(':name', $subscription->name, $msg);

        $users = User::where('subscription_id', $id)->get();
        Notification::send($users, new UpdatesNotification($msg));
    }

    private function createTopicNotification(string $id, string $msg)
    {
        $topic = Topic::find($id);
        $msg = str_replace(':name', $topic->name, $msg);

        $users = User::select('users.*')
            ->join('user_word', 'users.id', '=', 'user_word.user_id')
            ->join('words', 'words.id', '=', 'user_word.word_id')
            ->join('topic_word', 'words.id', '=', 'topic_word.word_id')
            ->where('topic_id', $id)
            ->distinct()
            ->get();

        Notification::send($users, new UpdatesNotification($msg));
    }
}

