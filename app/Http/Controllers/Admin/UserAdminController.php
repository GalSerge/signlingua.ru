<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use App\Services\MoodleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password;

class UserAdminController extends BaseAdminController
{
    public function __construct()
    {
        $this->resource = 'admins';
        $this->model = User::class;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return $this->viewList($this->model::where('role_id', 1)->orderBy('email')->paginate(10)->toArray(), 'Редактировать администраторов', 'email');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        if (isset($request->email))
            $request->email = Str::lower($request->email);

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
            'active' => ['nullable']
        ]);

        if (!isset($validatedData['active']))
            $validatedData['active'] = 0;

        $validatedData['password'] = Hash::make($request->password);

        $role = Role::where('tag', 'admin')->first();

        $admin = $role->users()->create($validatedData);

        $moodleId = MoodleService::createNewUser($admin);

        if ($moodleId != false)
            $admin->fill(['moodle_id' => $moodleId])->save();

        return redirect()->route('admins.edit', $admin->id)->with('status', 'Новая запись добавлена.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'active' => ['nullable']
        ]);

        if (!isset($validatedData['active']))
            $validatedData['active'] = 0;

        if ($validatedData['password'] == null)
            unset($validatedData['password']);
        else
            $validatedData['password'] = Hash::make($request->password);

        User::where('id', $id)->update($validatedData);

        return redirect()->route('admins.edit', $id)->with('status', 'Данные успешно обновлены.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $admin = User::findOrFail($id);

        $userId = Auth::user()->id;

        if ($admin->id == $userId)
            return redirect()->back()->with('status', 'Невозможно удалить запись текущего администратора.');
        else
        {
            $admin->delete();
            return redirect()->route('admins.index')->with('status', 'Запись успешно удалена.');
        }
    }
}
