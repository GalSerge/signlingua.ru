<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Constant;

class ConstantController extends BaseAdminController
{
    public function __construct()
    {
        $this->resource = 'constants';
        $this->model = Constant::class;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editConstants(): View
    {
        return $this->view('update', 'put', $this->model::findOrFail(1));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'feedback_email' => ['required', 'email:filter', 'max:255'],
            'call_amount' => ['required', 'numeric', 'min:10'],
            'trial_amount' => ['required', 'numeric', 'min:10'],
            'repeat_train_v' => ['required', 'integer', 'min:1'],
            'repeat_train_r' => ['required', 'integer', 'min:1'],
            'repeat_train_w' => ['required', 'integer', 'min:1'],
        ]);

        Constant::where('id', 1)->update($validatedData);

        return redirect()->route('constants.edit', 1)->with('status', 'Данные успешно обновлены.');
    }
}
