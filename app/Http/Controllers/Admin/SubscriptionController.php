<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Subscription;

class SubscriptionController extends BaseAdminController
{
    public function __construct()
    {
        $this->resource = 'subscriptions';
        $this->model = Subscription::class;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->viewList($this->model::orderBy('name')->paginate(10)->toArray(), 'Редактировать подписки', 'name');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => '',
            'calls' => ['required', 'integer', 'min:0'],
            'amount' => ['required', 'decimal:2'],
            'period_in_months' => ['required', 'integer', 'min:0'],
            'courses' => ['nullable', 'array'],
            'active' => ['nullable']
        ]);

        if (!isset($validatedData['courses']))
            $courses = [];
        else
            $courses = $validatedData['courses'];

        unset($validatedData['courses']);

        if (!isset($validatedData['active']))
            $validatedData['active'] = 0;

        $subscription = Subscription::create($validatedData);

        $subscription->courses()->sync($courses);

        return redirect()->route('subscriptions.edit', $subscription->id)->with('status', 'Новая запись добавлена.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => '',
            'calls' => ['required', 'integer', 'min:0'],
            'amount' => ['required', 'decimal:2'],
            'period_in_months' => ['required', 'integer', 'min:0'],
            'courses' => ['nullable', 'array'],
            'active' => ['nullable']
        ]);

        $subscription = Subscription::findOrFail($id);

        if (!isset($validatedData['courses']))
            $validatedData['courses'] = [];
        $subscription->courses()->sync($validatedData['courses']);

        unset($validatedData['courses']);

        if (!isset($validatedData['active']))
            $validatedData['active'] = 0;

        Subscription::where('id', $id)->update($validatedData);

        return redirect()->route('subscriptions.edit', $id)->with('status', 'Данные успешно обновлены.');
    }
}
