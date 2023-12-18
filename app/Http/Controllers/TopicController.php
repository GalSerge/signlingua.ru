<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Topic;

class TopicController extends Controller
{
    public function show(string $id): View
    {
        return view('pages.topic', ['topic' => Topic::with('words.regions')->findOrFail($id)->toArray()]);
    }

    public function showAll(): View
    {
        return view('pages.topics', Topic::where('active', 1)
            ->orderBy('name')
            ->paginate(10)
            ->toArray()
        );
    }
}
