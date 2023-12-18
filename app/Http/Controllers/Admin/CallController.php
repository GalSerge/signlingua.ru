<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Call;
use App\Enums\CallStatusEnum;
use Illuminate\Validation\Rule;

class CallController extends Controller
{
    public function index(Request $request): View
    {
        return view('admin.pages.calls',
            [
                ...Call::with('user')
                    ->orderBy('updated_at', 'desc')
                    ->paginate(30)
                    ->toArray()
            ]);
    }

    public function show(string $id)
    {
        return view('admin.pages.call',
            [
                'call' => Call::with('user')
                    ->with('tutor')
                    ->findOrFail($id)
                    ->toArray(),
            ]);
    }

    public function updateStatusCall(Request $request, string $id): RedirectResponse
    {
        $validatedData = $request->validate([
            'status' => ['required'],
        ]);

        $validatedData['tutor_id'] = $request->user()->id;

        Call::where('id', $id)->update($validatedData);

        return redirect()->route('calls.edit', $id)->with('status', 'Данные успешно обновлены.');
    }
}

