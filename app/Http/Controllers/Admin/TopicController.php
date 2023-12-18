<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Topic;

class TopicController extends BaseAdminController
{
    public function __construct()
    {
        $this->resource = 'topics';
        $this->model = Topic::class;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->viewList($this->model::orderBy('name')->paginate(10)->toArray(), 'Редактировать словари', 'name');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'max:255',
            'words' => ['nullable', 'array'],
            'active' => ['nullable']
        ]);

        if (!isset($validatedData['words']))
            $words = [];
        else
            $words = $validatedData['words'];

        unset($validatedData['words']);

        if (!isset($validatedData['active']))
            $validatedData['active'] = 0;

        $topic = Topic::create($validatedData);

        $topic->words()->sync($words);

        return redirect()->route('topics.edit', $topic->id)->with('status', 'Новая запись добавлена.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'words' => ['nullable', 'array'],
            'active' => ['nullable']
        ]);

        $topic = Topic::findOrFail($id);

        if (!isset($validatedData['words']))
            $validatedData['words'] = [];
        $topic->words()->sync($validatedData['words']);

        unset($validatedData['words']);

        if (!isset($validatedData['active']))
            $validatedData['active'] = 0;

        Topic::where('id', $id)->update($validatedData);

        return redirect()->route('topics.edit', $id)->with('status', 'Данные успешно обновлены.');
    }
}
