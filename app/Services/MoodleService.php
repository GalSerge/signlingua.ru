<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use App\Models\User;
use App\Enums\MoodleFunctionsEnum;
use Illuminate\Support\Str;

class MoodleService
{
    private static function sendMoodleRequest(string $function, array|null $params = []): bool|Response
    {
        $params += [
            'wstoken' => config('services.moodle.token'),
            'wsfunction' => $function,
            'moodlewsrestformat' => 'json'
        ];

        $url = config('services.moodle.url') . '/webservice/rest/server.php';

        $response = Http::get($url, $params);

        if ($response->successful())
            return $response;
        else
            return false;
    }

    public static function getLoginUrl(User $user)
    {
        $data = [
            'user' => [
                'username' => $user->email,
                'firstname' => $user->name,
                'lastname' => $user->surname,
                'email' => $user->email
            ]
        ];

        $response = self::sendMoodleRequest(MoodleFunctionsEnum::AUTH_REQUEST, $data);

        if ($response && isset($response->object()->loginurl) && filter_var($response->object()->loginurl, FILTER_VALIDATE_URL))
            return $response->object()->loginurl;
        else
            return false;
    }

    public static function getAllCourses()
    {
        $courses = [];

        $response = self::sendMoodleRequest(MoodleFunctionsEnum::GET_COURSES);

        if ($response)
            foreach ($response->object() as $course)
            {
                if ($course->id == 1)
                    continue;

                $courses[] = [
                    'moodle_id' => $course->id,
                    'name' => $course->fullname,
                    'visible' => $course->visible,
                    'category' => $course->categoryid
                ];
            }

        return $courses;
    }

    public static function enrolUserInCourses(int $userMoodleId, array $courses)
    {
        $data = [];

        foreach ($courses as $course)
            $data['enrolments'][] = [
                'roleid' => MoodleFunctionsEnum::STUDENT_ROLE_ID,
                'userid' => $userMoodleId,
                'courseid' => $course['moodle_id']
            ];

        $response = self::sendMoodleRequest(MoodleFunctionsEnum::ENROLL, $data);

        return (bool)$response;
    }

    public static function getAllUserCourses(int $userMoodleId): array
    {
        $courses = [];
        $data = ['userid' => $userMoodleId];

        $response = self::sendMoodleRequest(MoodleFunctionsEnum::GET_USER_COURSES, $data);

        if ($response)
            foreach ($response->object() as $course)
                $courses[] = [
                    'moodle_id' => $course->id,
                    'name' => $course->fullname,
                    'description' => $course->summary,
                    'progress' => (int)$course->progress
                ];

        return $courses;
    }

    public static function unenrollUserFromAllCourses(int $userMoodleId): bool
    {
        $courses = self::getAllUserCourses($userMoodleId);

        $data = [];

        foreach ($courses as $course)
            $data['enrolments'][] = [
                'roleid' => MoodleFunctionsEnum::STUDENT_ROLE_ID,
                'userid' => $userMoodleId,
                'courseid' => $course['moodle_id']
            ];

        $response = self::sendMoodleRequest(MoodleFunctionsEnum::UNENROLL, $data);

        return (bool)$response;
    }

    public static function createNewUser(User $user)
    {
        $users = [
            [
                'username' => Str::lower($user->email),
                'firstname' => $user->name,
                'lastname' => $user->surname,
                'email' => $user->email,
                'password' => Str::password(15),
                'createpassword' => 0,

            ]
        ];

        $data = ['users' => $users];

        $response = self::sendMoodleRequest(MoodleFunctionsEnum::CORE_USER_CREATE_USERS, $data);

        if ($response)
            return $response->object()[0]->id;
        else
            return false;
    }

    public static function enrolUserInBetaCourses(int $userMoodleId): void
    {
        $allCourses = self::getAllCourses();
        $betaCourses = [];

        foreach ($allCourses as $course)
            if ($course['visible'] && $course['category'] == MoodleFunctionsEnum::BETA_CATEGORY_ID)
                $betaCourses[] = $course;

        self::enrolUserInCourses($userMoodleId, $betaCourses);
    }
}
