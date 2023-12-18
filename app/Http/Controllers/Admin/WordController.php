<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use App\Models\Word;
use App\Models\Region;
use App\Models\Topic;

class WordController extends BaseAdminController
{
    public function __construct()
    {
        $this->resource = 'words';
        $this->model = Word::class;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->viewList(
            $this->model::orderBy('text')->paginate(30)->toArray(),
            'Редактировать слова',
            'text',
            //  additional: 'words-search'
            fieldActive: null
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $topics = Topic::where('active', 1)->get()->toArray();
        foreach ($topics as $key => $topic)
            $topics[$key]['selected'] = false;

        return view('admin.pages.word',
            [
                'callback' => 'words.store',
                'method' => 'post',
                'title' => 'Создать / Редактировать запись',
                'topics' => $topics
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'text' => 'max:255',
            'topics' => ['nullable', 'array'],
        ]);

        if (!isset($validatedData['topics']))
            $topics = [];
        else
            $topics = $validatedData['topics'];

        unset($validatedData['topics']);

        $validatedData['tag'] = Str::limit(Str::slug($validatedData['text'], ''), 25);

        $word = Word::create($validatedData);

        $word->topics()->sync($topics);

        return redirect()->route('words.edit', $word->id)->with('status', 'Новая запись добавлена.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $word = Word::with('regions')->findOrFail($id)->toArray();

        $regions = Region::whereDoesntHave('words',
            function ($q) use ($id) {
                $q->where('word_id', $id);
            })->get()
            ->toArray();

        $topicsNotAttached = Topic::select('id')->whereDoesntHave('words',
            function ($q) use ($id) {
                $q->where('word_id', $id);
            })->get()
            ->pluck('id')
            ->toArray();

        $topics = Topic::where('active', 1)->get()->toArray();
        foreach ($topics as $key => $topic)
            if (in_array($topic['id'], $topicsNotAttached))
                $topics[$key]['selected'] = false;
            else
                $topics[$key]['selected'] = true;

        return view('admin.pages.word',
            [
                'callback' => 'words.update',
                'method' => 'put',
                'title' => 'Создать / Редактировать запись',
                'word' => $word,
                'regions' => $regions,
                'topics' => $topics
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'text' => 'max:255',
            'topics' => ['nullable', 'array'],
        ]);

        $word = Word::findOrFail($id);

        if (!isset($validatedData['topics']))
            $validatedData['topics'] = [];
        $word->topics()->sync($validatedData['topics']);

        unset($validatedData['topics']);

        Word::where('id', $id)->update($validatedData);

        return redirect()->route('words.edit', $id)->with('status', 'Данные успешно обновлены.');
    }

    public function addRegion(Request $request, string $word_id): Response
    {
        try
        {
            $validatedData = $request->validate([
                'region_id' => ['required', 'exists:regions,id'],
                'region_video_file' => ['required', 'file', 'mimetypes:video/mp4']
            ]);
        } catch (\Exception $e)
        {
            return response($e->getMessage(), 400);
        }

        $word = Word::findOrFail($word_id);
        $word->regions()->sync([$validatedData['region_id']], false);

        $path = Storage::putFileAs(
            'public/videos/words',
            $request->file('region_video_file'),
            $word->tag . '_' . $word->id . '_' . $validatedData['region_id'] . '.mp4'
        );

        return response($path, 200);
    }

    public function deleteRegion(Request $request, string $word_id)
    {
        if (isset($request->region_id))
        {
            $word = Word::findOrFail($word_id);
            $word->regions()->detach($request->region_id);

            Storage::delete('public/videos/words/' . $word->tag . '_' . $word->id . '_' . $request->region_id . '.mp4');

            return response('Ok', 200);
        } else
            return response('Bad request', 400);
    }

    public function getFreeRegions(string $word_id)
    {
        $regions = Region::whereDoesntHave('words',
            function ($q) use ($word_id) {
                $q->where('word_id', $word_id);
            })->get()
            ->toArray();

        return \Response::json($regions);
    }

    public function getWordsByText(Request $request): JsonResponse
    {
        if (!isset($request->q))
            return response()->json([]);

        if (isset($request->topic))
            $words = Word::select('words.id', 'words.text')
                ->join('topic_word', 'words.id', '=', 'topic_word.word_id')
                ->where('text', 'like', $request->q . '%')
                ->where('topic_word.topic_id', $request->topic)
                ->get()
                ->toArray();

        else
            $words = Word::select('words.id', 'words.text')
                ->where('text', 'like', $request->q . '%')
                ->get()
                ->toArray();

        return response()->json($words);
    }
}
