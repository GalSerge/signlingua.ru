<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use App\Models\Region;

class RegionController extends BaseAdminController
{
    public function __construct()
    {
        $this->resource = 'regions';
        $this->model = Region::class;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->viewList(
            $this->model::orderBy('name')->paginate(30)->toArray(),
            'Редактировать регионы',
            'name',
            fieldActive: null);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'in_name' => ['required', 'string', 'max:255'],
            'latitude' => ['required', 'string', 'max:255'],
            'longitude' => ['required', 'string', 'max:255']
        ]);

        $region = Region::create($validatedData);

        return redirect()->route('regions.edit', $region->id)->with('status', 'Новая запись добавлена.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'in_name' => ['required', 'string', 'max:255'],
            'latitude' => ['required', 'string', 'max:255'],
            'longitude' => ['required', 'string', 'max:255']
        ]);

        Region::where('id', $id)->update($validatedData);

        return redirect()->route('regions.edit', $id)->with('status', 'Данные успешно обновлены.');
    }
}
