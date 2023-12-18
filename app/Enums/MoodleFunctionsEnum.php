<?php

namespace App\Enums;

class MoodleFunctionsEnum
{
    public const AUTH_REQUEST = 'auth_userkey_request_login_url';
    public const GET_COURSES = 'core_course_get_courses';
    public const ENROLL = 'enrol_manual_enrol_users';
    public const UNENROLL = 'enrol_manual_unenrol_users';
    public const GET_USER_COURSES = 'core_enrol_get_users_courses';
    public const CORE_USER_CREATE_USERS = 'core_user_create_users';

    public const STUDENT_ROLE_ID = 5;
    public const BETA_CATEGORY_ID = 3;
}
