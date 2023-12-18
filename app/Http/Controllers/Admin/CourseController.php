<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Services\MoodleService;
use Illuminate\Support\Facades\Storage;
use App\Enums\MoodleFunctionsEnum;

class CourseController extends BaseAdminController
{
    public function __construct()
    {
        $this->resource = 'courses';
        $this->model = Course::class;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->viewList($this->model::orderBy('name')->paginate(10)->toArray(),
            'Редактировать курсы',
            'name',
            additional: 'load-courses',
            fieldActive: 'visible'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'max:255',
            'description' => '',
            'img' => ['nullable', 'file', 'mimes:jpg,bmp,png']
        ]);

        if (isset($validatedData['img'])) {
            Storage::putFileAs(
                'public/images/courses',
                $request->file('img'),
                'course_' . $id . '_img.' . $request->file('img')->extension()
            );
            $validatedData['img'] = 'course_' . $id . '_img.' . $request->file('img')->extension();
        }

        Course::where('id', $id)->update($validatedData);

        return redirect()->route('courses.edit', $id)->with('status', 'Данные успешно обновлены.');
    }

    public function load(MoodleService $service): RedirectResponse
    {
        $courses = $service->getAllCourses();

        foreach ($courses as $course)
            if ($course['category'] != MoodleFunctionsEnum::BETA_CATEGORY_ID)
                Course::updateOrCreate(
                    ['moodle_id' => $course['moodle_id']],
                    $course
                );

        return redirect()->route('courses.index')->with('status', 'Данные успешно обновлены.');
    }
}
